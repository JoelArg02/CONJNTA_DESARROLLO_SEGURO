<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Invoices -->
    <div class="card p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Facturas</p>
                <p class="text-2xl font-semibold text-gray-900">$ {{ number_format($stats['total_invoices'], 2) }}</p>
                @if ($stats['total_change'] != 0)
                    <p class="text-xs {{ $stats['total_change'] > 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                        <i class="fas fa-arrow-{{ $stats['total_change'] > 0 ? 'up' : 'down' }} mr-1"></i>
                        {{ abs(round($stats['total_change'], 1)) }}% desde el mes pasado
                    </p>
                @else
                    <p class="text-xs text-gray-600 mt-1">
                        <i class="fas fa-minus mr-1"></i> Sin cambios
                    </p>
                @endif
            </div>
            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center">
                <i class="fas fa-file-invoice text-indigo-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Paid Invoices -->
    <div class="card p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Facturas Pagadas</p>
                <p class="text-2xl font-semibold text-gray-900">$ {{ number_format($stats['paid_invoices'], 2) }}</p>
                @if ($stats['paid_change'] != 0)
                    <p class="text-xs {{ $stats['paid_change'] > 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                        <i class="fas fa-arrow-{{ $stats['paid_change'] > 0 ? 'up' : 'down' }} mr-1"></i>
                        {{ abs(round($stats['paid_change'], 1)) }}% desde el mes pasado
                    </p>
                @else
                    <p class="text-xs text-gray-600 mt-1">
                        <i class="fas fa-minus mr-1"></i> Sin cambios
                    </p>
                @endif
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Invoices -->
    <div class="card p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Facturas Pendientes</p>
                <p class="text-2xl font-semibold text-gray-900">$ {{ number_format($stats['pending_invoices'], 2) }}</p>
                <p class="text-xs text-yellow-600 mt-1">
                    <i class="fas fa-clock mr-1"></i> En proceso
                </p>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Overdue Invoices -->
    <div class="card p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Facturas Vencidas</p>
                <p class="text-2xl font-semibold text-gray-900">$ {{ number_format($stats['overdue_invoices'], 2) }}</p>
                <p class="text-xs text-red-600 mt-1">
                    <i class="fas fa-exclamation-circle mr-1"></i> Requieren atención
                </p>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Tables -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Revenue Chart -->
    <div class="card p-6 lg:col-span-2">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Ingresos Mensuales</h3>
        </div>
        <div class="chart-container">
            <canvas id="revenueChart" style="display: block; box-sizing: border-box; height: 220px; width: 537px;"
                height="220" width="537"></canvas>
        </div>
    </div>

    <!-- Invoice Status -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Estado de Facturas</h3>
        </div>
        <div class="chart-container">
            <canvas id="invoiceStatusChart" style="display: block; box-sizing: border-box; height: 220px; width: 232px;"
                height="220" width="232"></canvas>
        </div>
    </div>
</div>

<!-- Recent Invoices and Top Clients -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Recent Invoices -->
    <div class="card p-6 lg:col-span-2">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Facturas Recientes</h3>
            <a href="/admin/invoices" class="text-sm text-indigo-600 hover:text-indigo-800">Ver todas</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Factura</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cliente</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado</th>
                        {{-- <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones</th> --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($invoices as $invoice)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">#{{ $invoice->invoice_number }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full"
                                            src="https://ui-avatars.com/api/?name={{ urlencode($invoice->customer->name ?? 'Cliente') }}&background=6366F1&color=fff"
                                            alt="Client">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $invoice->customer->name ?? 'Cliente Eliminado' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    class="text-sm text-gray-500">{{ $invoice->issued_at ? $invoice->issued_at->format('d/m/Y') : $invoice->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-sm text-gray-900">$ {{ number_format($invoice->total, 2) }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @switch($invoice->status)
                                    @case('paid')
                                        <span class="status-badge paid">Pagada</span>
                                    @break

                                    @case('pending')
                                        <span class="status-badge pending">Pendiente</span>
                                    @break

                                    @case('overdue')
                                        <span class="status-badge overdue">Vencida</span>
                                    @break

                                    @default
                                        <span class="status-badge pending">{{ ucfirst($invoice->status) }}</span>
                                @endswitch
                            </td>
                            {{-- <td class="px-4 py-3 whitespace-nowrap text-right text-sm">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                                <a href="#" class="text-gray-600 hover:text-gray-900">Descargar</a>
                            </td> --}}
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    <i class="fas fa-file-invoice text-4xl text-gray-300 mb-4"></i>
                                    <p>No hay facturas registradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Clients -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Clientes Destacados</h3>
                <a href="/admin/customers" class="text-sm text-indigo-600 hover:text-indigo-800">Ver todos</a>
            </div>
            <div class="space-y-4">
                @forelse($topClients as $client)
                    <div class="flex items-center p-3 rounded-lg hover:bg-gray-50">
                        <div class="flex-shrink-0 h-10 w-10">
                            <img class="h-10 w-10 rounded-full"
                                src="https://ui-avatars.com/api/?name={{ urlencode($client->name) }}&background={{ str_replace('#', '', '#' . substr(md5($client->name), 0, 6)) }}&color=fff"
                                alt="Client">
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="text-sm font-medium text-gray-900">{{ $client->name }}</div>
                            <div class="text-xs text-gray-500">{{ $client->invoice_count ?? 0 }}
                                {{ ($client->invoice_count ?? 0) == 1 ? 'factura' : 'facturas' }}</div>
                        </div>
                        <div class="text-sm font-medium text-gray-900">$
                            {{ number_format($client->total_amount ?? 0, 2) }}</div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No hay datos de clientes disponibles</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    </div>
