<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-900 mb-6">Reportes del Sistema</h1>
                    
                    <!-- Reporte de Facturas -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-file-invoice text-indigo-600 text-2xl mr-3"></i>
                            <h2 class="text-xl font-semibold text-gray-800">Reporte de Facturas</h2>
                        </div>
                        
                        <form action="{{ route('admin.reports.invoices-pdf') }}" method="GET" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <!-- Fecha de inicio -->
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                        Fecha de Inicio
                                    </label>
                                    <input type="date" 
                                           id="start_date" 
                                           name="start_date" 
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <!-- Fecha de fin -->
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                                        Fecha de Fin
                                    </label>
                                    <input type="date" 
                                           id="end_date" 
                                           name="end_date" 
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <!-- Estado -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        Estado
                                    </label>
                                    <select id="status" 
                                            name="status" 
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Todos los estados</option>
                                        <option value="paid">Pagadas</option>
                                        <option value="pending">Pendientes</option>
                                        <option value="overdue">Vencidas</option>
                                    </select>
                                </div>
                                
                                <!-- Cliente -->
                                <div>
                                    <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Cliente
                                    </label>
                                    <select id="customer_id" 
                                            name="customer_id" 
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Todos los clientes</option>
                                        <!-- Los clientes se cargarán con JavaScript -->
                                    </select>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center pt-4">
                                <div class="text-sm text-gray-600">
                                    <p class="mb-1">Generar reporte en formato PDF con los filtros seleccionados</p>
                                    <p>Incluye: Listado de facturas, totales, estadísticas y gráficos</p>
                                </div>
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fas fa-download mr-2"></i>
                                    Generar PDF
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Estadísticas Rápidas -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <!-- Total de Facturas -->
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-file-invoice text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium opacity-75">Total Facturas</p>
                                    <p class="text-2xl font-bold" id="total-invoices">{{ $stats['total_invoices'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Ingresos -->
                        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-dollar-sign text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium opacity-75">Total Ingresos</p>
                                    <p class="text-2xl font-bold">$ {{ number_format($stats['total_amount'] ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Facturas Pendientes -->
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-6 text-white">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-clock text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium opacity-75">Pendientes</p>
                                    <p class="text-2xl font-bold">{{ $stats['pending_count'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Facturas Vencidas -->
                        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-6 text-white">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium opacity-75">Vencidas</p>
                                    <p class="text-2xl font-bold">{{ $stats['overdue_count'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Otros tipos de reportes futuros -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Reporte de Productos -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-box text-indigo-600 text-2xl mr-3"></i>
                                <h3 class="text-lg font-semibold text-gray-800">Reporte de Productos</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Inventario, productos más vendidos, stock bajo</p>
                            <button class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" disabled>
                                <i class="fas fa-tools mr-2"></i>
                                Próximamente
                            </button>
                        </div>

                        <!-- Reporte de Clientes -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-users text-indigo-600 text-2xl mr-3"></i>
                                <h3 class="text-lg font-semibold text-gray-800">Reporte de Clientes</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Clientes más activos, historial de compras</p>
                            <button class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" disabled>
                                <i class="fas fa-tools mr-2"></i>
                                Próximamente
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cargar clientes
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route("admin.reports.customers") }}')
                .then(response => response.json())
                .then(customers => {
                    const select = document.getElementById('customer_id');
                    customers.forEach(customer => {
                        const option = document.createElement('option');
                        option.value = customer.id;
                        option.textContent = customer.name;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar clientes:', error));

            // Establecer fecha de fin como hoy si no se ha seleccionado
            const endDateInput = document.getElementById('end_date');
            if (!endDateInput.value) {
                endDateInput.value = new Date().toISOString().split('T')[0];
            }
        });
    </script>
</x-app-layout>
