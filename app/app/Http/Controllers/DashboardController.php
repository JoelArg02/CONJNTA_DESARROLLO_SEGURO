<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Si es un customer que accede a /dashboard, redirigir a /clientes/dashboard
        if (Auth::guard('customer_web')->check()) {
            return redirect()->route('clientes.dashboard');
        }
        $search = $request->input('search');

        $users = User::query()
            ->when($search, fn($query) =>
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Obtener datos adicionales para otras secciones del dashboard
        $customers = Customer::where('is_active', true)->get();
        $disabledCustomers = Customer::where('is_active', false)->get();
        $products = Product::where('is_active', true)->get();
        $invoices = Invoice::with('customer')->latest()->take(10)->get();

        // Estadísticas del dashboard
        $stats = $this->getDashboardStats();
        
        // Datos para gráficos
        $chartData = $this->getChartData();
        
        // Clientes principales
        $topClients = $this->getTopClients();

        return view('dashboard', [
            'users' => $users,
            'customers' => $customers,
            'disabled' => $disabledCustomers,
            'products' => $products,
            'invoices' => $invoices,
            'search' => $search,
            'stats' => $stats,
            'chartData' => $chartData,
            'topClients' => $topClients
        ]);
    }

    private function getDashboardStats()
    {
        $totalInvoices = Invoice::sum('total');
        $paidInvoices = Invoice::where('status', 'paid')->sum('total');
        $pendingInvoices = Invoice::where('status', 'pending')->sum('total');
        $overdueInvoices = Invoice::where('status', 'overdue')->sum('total');

        // Calcular cambios del mes anterior
        $lastMonth = Carbon::now()->subMonth();
        $totalLastMonth = Invoice::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('total');
        
        $paidLastMonth = Invoice::where('status', 'paid')
            ->whereMonth('updated_at', $lastMonth->month)
            ->whereYear('updated_at', $lastMonth->year)
            ->sum('total');

        $totalChange = $totalLastMonth > 0 ? (($totalInvoices - $totalLastMonth) / $totalLastMonth) * 100 : 0;
        $paidChange = $paidLastMonth > 0 ? (($paidInvoices - $paidLastMonth) / $paidLastMonth) * 100 : 0;

        return [
            'total_invoices' => $totalInvoices,
            'paid_invoices' => $paidInvoices,
            'pending_invoices' => $pendingInvoices,
            'overdue_invoices' => $overdueInvoices,
            'total_change' => $totalChange,
            'paid_change' => $paidChange
        ];
    }

    private function getChartData()
    {
        // Ingresos de los últimos 6 meses
        $monthlyRevenue = [];
        $monthLabels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Invoice::where('status', 'paid')
                ->whereMonth('updated_at', $date->month)
                ->whereYear('updated_at', $date->year)
                ->sum('total');
            
            $monthlyRevenue[] = (float) $revenue;
            $monthLabels[] = $date->format('M');
        }

        return [
            'monthly_revenue' => $monthlyRevenue,
            'month_labels' => $monthLabels,
            'invoice_status_data' => [
                'paid' => (float) Invoice::where('status', 'paid')->sum('total'),
                'pending' => (float) Invoice::where('status', 'pending')->sum('total'),
                'overdue' => (float) Invoice::where('status', 'overdue')->sum('total')
            ]
        ];
    }

    private function getTopClients()
    {
        return Customer::select('customers.*')
            ->selectRaw('SUM(invoices.total) as total_amount')
            ->selectRaw('COUNT(invoices.id) as invoice_count')
            ->leftJoin('invoices', 'customers.id', '=', 'invoices.customer_id')
            ->where('customers.is_active', true)
            ->groupBy('customers.id')
            ->orderByDesc('total_amount')
            ->limit(4)
            ->get();
    }
}
