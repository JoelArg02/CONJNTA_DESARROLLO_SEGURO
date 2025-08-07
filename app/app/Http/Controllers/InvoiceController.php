<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Product;
use App\Mail\InvoiceCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class InvoiceController extends Controller
{
    public function __construct()
    {
        // No middleware needed - handle in individual methods
    }

    public function index(Request $request)
    {
        // Verificar permisos
        if (!Auth::user()->can('view_invoices')) {
            abort(403, 'No tiene permisos para ver facturas.');
        }

        $search = $request->input('search');
        $status = $request->input('status');
        $customer = $request->input('customer');

        $query = Invoice::with(['customer', 'creator']);

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($status) {
            $query->where('status', $status);
        }

        // Customer filter
        if ($customer) {
            $query->where('customer_id', $customer);
        }

        $invoices = $query->latest()->paginate(15)->withQueryString();

        // Get statistics for all invoices (regardless of current filters)
        $totalInvoices = Invoice::count();
        $pendingInvoices = Invoice::where('status', 'pending')->count();
        $paidInvoices = Invoice::where('status', 'paid')->count();
        $overdueInvoices = Invoice::where('status', 'overdue')->count();
        $totalAmount = Invoice::sum('total');

        $customers = Customer::where('is_active', true)->orderBy('name')->get();
        $editingInvoice = $request->filled('edit')
            ? Invoice::with('items')->findOrFail($request->input('edit'))
            : null;

        $products = Product::where('is_active', true)->orderBy('name')->get();
        
        return view(
            'admin.invoices.index',
            compact(
                'invoices', 
                'customers', 
                'editingInvoice', 
                'products',
                'search',
                'status',
                'customer',
                'totalInvoices',
                'pendingInvoices',
                'paidInvoices',
                'overdueInvoices',
                'totalAmount'
            )
        );
    }

    public function store(Request $request)
    {
        // Verificar permisos
        if (!Auth::user()->can('create_invoices')) {
            abort(403, 'No tiene permisos para crear facturas.');
        }
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id,is_active,1',
            'issued_at' => 'required|date',
            'status' => 'required|in:pending,paid,overdue',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id,is_active,1',
            'items.*.qty' => 'required|integer|min:1|max:1000',
            'items.*.description' => 'sometimes|string|max:255',
        ], [
            'customer_id.required' => 'Debe seleccionar un cliente.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',
            'issued_at.required' => 'La fecha de emisión es requerida.',
            'issued_at.date' => 'La fecha de emisión debe ser una fecha válida.',
            'status.required' => 'Debe seleccionar un estado para la factura.',
            'status.in' => 'El estado seleccionado no es válido.',
            'items.required' => 'Debe agregar al menos un producto.',
            'items.min' => 'Debe agregar al menos un producto.',
            'items.*.product_id.required' => 'Debe seleccionar un producto.',
            'items.*.product_id.exists' => 'El producto seleccionado no es válido.',
            'items.*.qty.required' => 'La cantidad es requerida.',
            'items.*.qty.min' => 'La cantidad debe ser mayor a 0.',
            'items.*.qty.max' => 'La cantidad no puede ser mayor a 1000.',
        ]);

        try {
            $invoice = DB::transaction(function () use ($validated) {
                // Verificar stock disponible
                foreach ($validated['items'] as $item) {
                    $product = Product::find($item['product_id']);
                    if ($product->stock < $item['qty']) {
                        throw ValidationException::withMessages([
                            'items' => "Stock insuficiente para el producto: {$product->name}. Stock disponible: {$product->stock}"
                        ]);
                    }
                }

                $invoice = Invoice::create([
                    'customer_id' => $validated['customer_id'],
                    'invoice_number' => Invoice::generateInvoiceNumber(),
                    'subtotal' => 0,
                    'tax_amount' => 0,
                    'total' => 0,
                    'status' => $validated['status'],
                    'issued_at' => $validated['issued_at'],
                    'created_by' => Auth::id(),
                ]);

                foreach ($validated['items'] as $item) {
                    $product = Product::find($item['product_id']);
                    $unitPrice = $product->sale_price ?? $product->price;
                    $subtotal = $item['qty'] * $unitPrice;

                    // Crear el item de la factura
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $product->id,
                        'description' => $item['description'] ?? $product->name,
                        'quantity' => $item['qty'],
                        'unit_price' => $unitPrice,
                        'subtotal' => $subtotal,
                    ]);

                    // Reducir stock
                    $product->decrement('stock', $item['qty']);
                }

                $invoice->refreshTotal();
                activity()->causedBy(Auth::user())->performedOn($invoice)->log('Factura creada');
                
                return $invoice;
            });

            // Load relationships for email
            $invoice->load(['customer', 'items.product', 'creator']);
            
            // Send email to customer with PDF attachment
            try {
                Mail::to($invoice->customer->email)->send(new InvoiceCreated($invoice));
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($invoice)
                    ->log('Email de factura enviado al cliente');
            } catch (\Exception $e) {
                // Log the error but don't fail the invoice creation
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($invoice)
                    ->withProperties(['error' => $e->getMessage()])
                    ->log('Error al enviar email de factura');
            }

            return back()->with('status', 'Factura creada correctamente y email enviado al cliente');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function update(Request $request, Invoice $invoice)
    {
        // Verificar permisos
        if (!Auth::user()->can('edit_invoices')) {
            abort(403, 'No tiene permisos para editar facturas.');
        }

        // Solo el creador o administrador puede editar
        if (!Auth::user()->hasRole('Administrador') && $invoice->created_by !== Auth::id()) {
            abort(403, 'No tiene permisos para editar esta factura.');
        }

        $validated = $request->validate([
            'issued_at' => 'required|date|before_or_equal:today',
            'reason' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id,is_active,1',
            'items.*.qty' => 'required|integer|min:1|max:1000',
            'items.*.description' => 'sometimes|string|max:255',
        ], [
            'issued_at.required' => 'La fecha de emisión es requerida.',
            'issued_at.before_or_equal' => 'La fecha de emisión no puede ser futura.',
            'reason.required' => 'El motivo de actualización es requerido.',
            'reason.max' => 'El motivo no puede tener más de 255 caracteres.',
            'items.required' => 'Debe agregar al menos un producto.',
            'items.min' => 'Debe agregar al menos un producto.',
            'items.*.product_id.required' => 'Debe seleccionar un producto.',
            'items.*.product_id.exists' => 'El producto seleccionado no es válido.',
            'items.*.qty.required' => 'La cantidad es requerida.',
            'items.*.qty.min' => 'La cantidad debe ser mayor a 0.',
            'items.*.qty.max' => 'La cantidad no puede ser mayor a 1000.',
        ]);

        try {
            DB::transaction(function () use ($invoice, $validated) {
                // Restaurar stock de los items anteriores
                foreach ($invoice->items as $oldItem) {
                    if ($oldItem->product) {
                        $oldItem->product->increment('stock', $oldItem->quantity);
                    }
                }

                // Verificar stock disponible para los nuevos items
                foreach ($validated['items'] as $item) {
                    $product = Product::find($item['product_id']);
                    if ($product->stock < $item['qty']) {
                        throw ValidationException::withMessages([
                            'items' => "Stock insuficiente para el producto: {$product->name}. Stock disponible: {$product->stock}"
                        ]);
                    }
                }

                $invoice->update(['issued_at' => $validated['issued_at']]);
                $invoice->items()->delete();

                foreach ($validated['items'] as $item) {
                    $product = Product::find($item['product_id']);
                    $subtotal = $item['qty'] * $product->price;

                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $product->id,
                        'description' => $item['description'] ?? $product->name,
                        'quantity' => $item['qty'],
                        'unit_price' => $product->price,
                        'subtotal' => $subtotal,
                    ]);

                    // Reducir stock nuevamente
                    $product->decrement('stock', $item['qty']);
                }

                $invoice->refreshTotal();
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($invoice)
                    ->withProperties(['reason' => $validated['reason']])
                    ->log('Factura actualizada');
            });

            return redirect()->route('admin.invoices.index')
                ->with('status', 'Factura actualizada correctamente');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(Request $request, Invoice $invoice)
    {
        // Verificar permisos
        if (!Auth::user()->can('delete_invoices')) {
            abort(403, 'No tiene permisos para eliminar facturas.');
        }

        // Solo el creador o administrador puede eliminar
        if (!Auth::user()->hasRole('Administrador') && $invoice->created_by !== Auth::id()) {
            abort(403, 'No tiene permisos para eliminar esta factura.');
        }

        // Validar el motivo de eliminación
        $validated = $request->validate([
            'reason' => 'required|string|min:3|max:255',
        ], [
            'reason.required' => 'El motivo de eliminación es requerido.',
            'reason.min' => 'El motivo debe tener al menos 3 caracteres.',
            'reason.max' => 'El motivo no puede tener más de 255 caracteres.',
        ]);

        // SOFT DELETE - No restaurar stock aún
        $invoice->update([
            'soft_delete_reason' => $validated['reason'],
            'soft_deleted_by' => Auth::id(),
        ]);
        
        $invoice->delete(); // Esto es soft delete gracias al trait

        // Registrar actividad de soft delete
        activity()->causedBy(Auth::user())
            ->performedOn($invoice)
            ->withProperties(['reason' => $validated['reason']])
            ->log('Factura eliminada temporalmente - Motivo: ' . $validated['reason']);

        return redirect()->route('admin.invoices.index')
            ->with('status', 'Factura eliminada temporalmente. Puede restaurarla desde la papelera o eliminarla definitivamente.');
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        // Verificar permisos
        if (!Auth::user()->can('edit_invoices')) {
            abort(403, 'No tiene permisos para cambiar el estado de facturas.');
        }

        // Solo el creador o administrador puede cambiar el estado
        if (!Auth::user()->hasRole('Administrador') && $invoice->created_by !== Auth::id()) {
            abort(403, 'No tiene permisos para cambiar el estado de esta factura.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,paid,overdue',
        ], [
            'status.required' => 'Debe seleccionar un estado.',
            'status.in' => 'El estado seleccionado no es válido.',
        ]);

        $oldStatus = $invoice->status;
        $newStatus = $validated['status'];

        if ($oldStatus === $newStatus) {
            return back()->with('info', 'El estado de la factura ya era ' . $newStatus);
        }

        $invoice->update(['status' => $newStatus]);

        // Registrar actividad
        activity()
            ->causedBy(Auth::user())
            ->performedOn($invoice)
            ->withProperties([
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ])
            ->log("Estado de factura cambiado de {$oldStatus} a {$newStatus}");

        $statusLabels = [
            'pending' => 'pendiente',
            'paid' => 'pagada',
            'overdue' => 'vencida'
        ];

        return back()->with('status', 
            "Estado de la factura #{$invoice->invoice_number} cambiado a {$statusLabels[$newStatus]}"
        );
    }

    /**
     * Show soft deleted invoices (trash)
     */
    public function trash(Request $request)
    {
        // Verificar permisos
        if (!Auth::user()->can('view_invoices')) {
            abort(403, 'No tiene permisos para ver facturas eliminadas.');
        }

        $search = $request->input('search');
        $customer = $request->input('customer');

        $query = Invoice::onlyTrashed()->with(['customer', 'creator', 'softDeleter']);

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhere('soft_delete_reason', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($search) {
                      $customerQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Customer filter
        if ($customer) {
            $query->where('customer_id', $customer);
        }

        $trashedInvoices = $query->latest('deleted_at')->paginate(15)->withQueryString();
        $customers = Customer::where('is_active', true)->orderBy('name')->get();

        return view('admin.invoices.trash', compact('trashedInvoices', 'customers'));
    }

    /**
     * Restore a soft deleted invoice
     */
    public function restore($invoiceId)
    {
        // Verificar permisos
        if (!Auth::user()->can('edit_invoices')) {
            abort(403, 'No tiene permisos para restaurar facturas.');
        }

        // Find the soft deleted invoice
        $invoice = Invoice::withTrashed()->findOrFail($invoiceId);

        // Solo el creador o administrador puede restaurar
        if (!Auth::user()->hasRole('Administrador') && $invoice->created_by !== Auth::id()) {
            abort(403, 'No tiene permisos para restaurar esta factura.');
        }

        $invoice->restore();
        $invoice->update([
            'soft_delete_reason' => null,
            'soft_deleted_by' => null,
        ]);

        // Registrar actividad
        activity()->causedBy(Auth::user())
            ->performedOn($invoice)
            ->log('Factura restaurada');

        return back()->with('status', 'Factura restaurada correctamente');
    }

    /**
     * Permanently delete an invoice (hard delete)
     */
    public function forceDelete(Request $request, $invoiceId)
    {
        // Verificar permisos
        if (!Auth::user()->can('delete_invoices')) {
            abort(403, 'No tiene permisos para eliminar definitivamente facturas.');
        }

        // Solo administradores pueden hacer hard delete
        if (!Auth::user()->hasRole('Administrador')) {
            abort(403, 'Solo los administradores pueden eliminar facturas definitivamente.');
        }

        // Find the soft deleted invoice
        $invoice = Invoice::withTrashed()->findOrFail($invoiceId);

        // Validar motivo de eliminación definitiva
        $validated = $request->validate([
            'final_reason' => 'required|string|min:3|max:255',
        ], [
            'final_reason.required' => 'El motivo de eliminación definitiva es requerido.',
            'final_reason.min' => 'El motivo debe tener al menos 3 caracteres.',
            'final_reason.max' => 'El motivo no puede tener más de 255 caracteres.',
        ]);

        DB::transaction(function () use ($invoice, $validated) {
            // Restaurar stock de todos los productos
            foreach ($invoice->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            // Registrar actividad antes de eliminar definitivamente
            activity()->causedBy(Auth::user())
                ->performedOn($invoice)
                ->withProperties([
                    'original_reason' => $invoice->soft_delete_reason,
                    'final_reason' => $validated['final_reason']
                ])
                ->log('Factura eliminada definitivamente - Stock restaurado - Motivo final: ' . $validated['final_reason']);

            $invoice->items()->forceDelete();
            $invoice->forceDelete();
        });

        return redirect()->route('admin.invoices.trash')
            ->with('status', 'Factura eliminada definitivamente y stock restaurado correctamente');
    }
   
    public function getInvoicesByCustomer($customerId)
    {
    $invoices = Invoice::with('items')
                ->where('customer_id', $customerId)
                ->get();

    return response()->json(['invoices' => $invoices]);
    }

     public function getAuthenticatedUserInvoices(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'invoices' => $user->invoices()->with(['items'])->get()
        ]);
    }

}
