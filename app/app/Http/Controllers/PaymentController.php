<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Mail\PaymentApproved;
use App\Mail\PaymentRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'invoice_id' => ['required', 'exists:invoices,id'],
                'method' => ['required', Rule::in(['efectivo', 'tarjeta', 'transferencia', 'cheque'])],
                'transaction_reference' => ['nullable', 'string', 'max:100'],
                'amount' => ['required', 'numeric', 'min:0.01'],
                'notes' => ['nullable', 'string'],
            ]);

            $invoice = Invoice::findOrFail($request->invoice_id);

            if ($invoice->customer_id !== Auth::id()) {
                abort(403, 'No puedes pagar facturas de otros clientes.');
            }

            if ($invoice->status === 'pagada') {
                abort(400, 'La factura ya está pagada.');
            }

            if ($invoice->total != $request->amount) {
                abort(400, 'El monto del pago no coincide con el total de la factura.');
            }

            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $request->amount,
                'method' => $request->method,
                'status' => 'pendiente',
                'transaction_reference' => $request->transaction_reference,
                'paid_at' => now(),
                'created_by' => Auth::id(),
                'notes' => $request->notes,
            ]);

            return response()->json($payment, 201);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Error interno',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }


    public function index()
    {

        if (!Auth::user()->can('view_invoices')) {
            abort(403, 'No tiene permisos para ver facturas.');
        }
        $payments = Payment::with('invoice', 'invoice.customer')
            ->where('status', 'pendiente')
            ->get();

        return view('payments.index', compact('payments'));
    }

    // Validador: Aprobar pago
    public function approve(Payment $payment)
    {
        if ($payment->status !== 'pendiente') {
            return redirect()->route('payments.index')->with('error', 'Este pago ya fue validado.');
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($payment)
            ->log('Pago aprobado');

        DB::transaction(function () use ($payment) {
            $payment->update([
                'status' => 'aprobado',
                'validated_at' => now(),
                'soft_deleted_by' => Auth::id(), // opcional
            ]);

            $payment->invoice->update([
                'status' => 'paid'
            ]);
        });

        // Load relationships for email
        $payment->load(['invoice.customer', 'invoice.items.product', 'invoice.creator']);

        // Send email to customer with payment approval notification and PDF attachment
        try {
            Mail::to($payment->invoice->customer->email)->send(new PaymentApproved($payment));
            activity()
                ->causedBy(Auth::user())
                ->performedOn($payment)
                ->log('Email de pago aprobado enviado al cliente');
        } catch (\Exception $e) {
            // Log the error but don't fail the payment approval
            activity()
                ->causedBy(Auth::user())
                ->performedOn($payment)
                ->withProperties(['error' => $e->getMessage()])
                ->log('Error al enviar email de pago aprobado');
        }

        return redirect()->route('payments.index')->with('success', 'Pago aprobado correctamente y email enviado al cliente.');
    }

    // Validador: Rechazar pago
    public function reject(Request $request, Payment $payment)
    {
        if ($payment->status !== 'pendiente') {
            return redirect()->route('payments.index')->with('error', 'Este pago ya fue validado.');
        }

        // Validar el motivo de rechazo si se proporciona
        $validated = $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ], [
            'rejection_reason.max' => 'El motivo de rechazo no puede tener más de 500 caracteres.',
        ]);

        $payment->update([
            'status' => 'rechazado',
            'validated_at' => now(),
            'notes' => $validated['rejection_reason'] ?? $payment->notes,
            'soft_deleted_by' => Auth::id(),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($payment)
            ->withProperties(['rejection_reason' => $validated['rejection_reason'] ?? 'Sin motivo especificado'])
            ->log('Pago rechazado');

        // No se modifica el estado de la factura

        // Load relationships for email
        $payment->load(['invoice.customer', 'invoice.items.product']);
        
        // Send email to customer with payment rejection notification
        try {
            Mail::to($payment->invoice->customer->email)->send(new PaymentRejected($payment));
            activity()
                ->causedBy(Auth::user())
                ->performedOn($payment)
                ->log('Email de pago rechazado enviado al cliente');
        } catch (\Exception $e) {
            // Log the error but don't fail the payment rejection
            activity()
                ->causedBy(Auth::user())
                ->performedOn($payment)
                ->withProperties(['error' => $e->getMessage()])
                ->log('Error al enviar email de pago rechazado');
        }

        return redirect()->route('payments.index')->with('success', 'Pago rechazado y email enviado al cliente.');
    }
}
