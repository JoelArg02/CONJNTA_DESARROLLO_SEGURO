<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Estadísticas para mostrar en la vista (solo facturas activas, no eliminadas)
        $stats = [
            'total_invoices' => Invoice::count(),
            'total_amount' => Invoice::sum('total'),
            'pending_count' => Invoice::where('status', 'pending')->count(),
            'overdue_count' => Invoice::where('status', 'overdue')->count(),
        ];

        return view('admin.reports.index', compact('stats'));
    }

    public function invoicesPdf(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|in:paid,pending,overdue',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        $query = Invoice::with(['customer', 'items.product', 'creator']);

        // Filtros por fecha de emisión (issued_at)
        if ($request->start_date) {
            $query->whereDate('issued_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('issued_at', '<=', $request->end_date);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }

        $invoices = $query->orderBy('issued_at', 'desc')->get();

        // Estadísticas
        $stats = [
            'total_invoices' => $invoices->count(),
            'total_amount' => $invoices->sum('total'),
            'paid_amount' => $invoices->where('status', 'paid')->sum('total'),
            'pending_amount' => $invoices->where('status', 'pending')->sum('total'),
            'overdue_amount' => $invoices->where('status', 'overdue')->sum('total'),
        ];

        $pdf = Pdf::loadView('admin.reports.invoices-pdf', compact('invoices', 'stats', 'request'));
        
        return $pdf->download('reporte-facturas-' . now()->format('Y-m-d') . '.pdf');
    }

    public function getCustomers()
    {
        $customers = Customer::where('is_active', true)->orderBy('name')->get(['id', 'name']);
        return response()->json($customers);
    }
}
