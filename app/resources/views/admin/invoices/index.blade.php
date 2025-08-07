{{-- resources/views/admin/invoices/index.blade.php --}}
@section('title', 'Facturas')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Facturas</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-sm">
                <h4 class="font-medium mb-2">Por favor corrige los siguientes errores:</h4>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @error('items')
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-sm">
                {{ $message }}
            </div>
        @enderror

        @error('status')
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-sm">
                {{ $message }}
            </div>
        @enderror

        {{-- Formulario crear --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg space-y-6">

            <h3 class="text-2xl font-semibold text-gray-800">
                Nueva Factura
            </h3>

            <form method="POST" id="invoiceForm"
                action="{{ route('admin.invoices.store') }}"
                class="space-y-6">
                @csrf

                {{-- Cliente, fecha y estado --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <select name="customer_id"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                        required>
                        <option value="">Cliente</option>
                        @foreach ($customers as $cust)
                            <option value="{{ $cust->id }}"
                                {{ old('customer_id') == $cust->id ? 'selected' : '' }}>
                                {{ $cust->name }}
                            </option>
                        @endforeach
                    </select>

                    <input type="date" name="issued_at"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                        value="{{ old('issued_at', date('Y-m-d')) }}" required>

                    <select name="status"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                        required>
                        <option value="">Estado</option>
                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>
                            Pendiente
                        </option>
                        <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>
                            Pagada
                        </option>
                        <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>
                            Vencida
                        </option>
                    </select>
                </div>

                {{-- Ítems --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-t border-b border-gray-200" id="itemsTable">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="text-left px-4 py-2">Producto</th>
                                <th class="text-left px-2 py-2">Cantidad</th>
                                <th class="text-left px-2 py-2">Precio</th>
                                <th class="text-left px-2 py-2">Subtotal</th>
                                <th class="px-2 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Items will be added dynamically -->
                        </tbody>
                    </table>
                </div>

                {{-- Añadir ítem --}}
                <div>
                    <button type="button" onclick="addRow()" class="text-blue-600 hover:underline text-sm font-medium">
                        + Añadir ítem
                    </button>
                </div>

                {{-- Botón guardar --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                        Crear
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- Listado --}}
    <div class="bg-white p-6 rounded-md shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Listado de Facturas</h3>
            <div class="flex items-center space-x-3">
                @can('view_invoices')
                    <a href="{{ route('admin.invoices.trash') }}" 
                       class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span>Papelera</span>
                    </a>
                @endcan
                @if(request('search') || request('status') || request('customer'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        Filtros aplicados
                    </span>
                @endif
            </div>
        </div>

        <!-- Search and Filters -->
        <form method="GET" action="{{ route('admin.invoices.index') }}" class="mb-6">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <input type="text" 
                               id="search"
                               name="search" 
                               placeholder="Número de factura, cliente..." 
                               value="{{ request('search') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label for="customer" class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                        <select name="customer" id="customer" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos los clientes</option>
                            @foreach($customers as $cust)
                                <option value="{{ $cust->id }}" {{ request('customer') == $cust->id ? 'selected' : '' }}>
                                    {{ $cust->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos los estados</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Pagada</option>
                            <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Vencida</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Filtrar
                        </button>
                        <a href="{{ route('admin.invoices.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Limpiar
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Facturas</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalInvoices }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pendientes</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $pendingInvoices }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pagadas</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $paidInvoices }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Vencidas</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $overdueInvoices }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Monto Total</p>
                        <p class="text-2xl font-semibold text-gray-900">${{ number_format($totalAmount, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="text-left px-4 py-2 font-medium">#</th>
                        <th class="text-left px-4 py-2 font-medium">Cliente</th>
                        <th class="text-left px-4 py-2 font-medium">Fecha</th>
                        <th class="text-left px-4 py-2 font-medium">Estado</th>
                        <th class="text-left px-4 py-2 font-medium">Total</th>
                        <th class="px-4 py-2 font-medium text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-800">
                    @foreach ($invoices as $inv)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $inv->id }}</td>
                            <td class="px-4 py-2">{{ $inv->customer->name }}</td>
                            <td class="px-4 py-2">{{ $inv->issued_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $statusConfig = [
                                        'pending' => ['text' => 'Pendiente', 'bg' => 'bg-yellow-100', 'text-color' => 'text-yellow-800'],
                                        'paid' => ['text' => 'Pagada', 'bg' => 'bg-green-100', 'text-color' => 'text-green-800'],
                                        'overdue' => ['text' => 'Vencida', 'bg' => 'bg-red-100', 'text-color' => 'text-red-800']
                                    ];
                                    $config = $statusConfig[$inv->status] ?? ['text' => $inv->status, 'bg' => 'bg-gray-100', 'text-color' => 'text-gray-800'];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $config['bg'] }} {{ $config['text-color'] }}">
                                    {{ $config['text'] }}
                                </span>
                                
                {{-- Status change buttons --}}
                <div class="mt-1 flex gap-1">
                    @if($inv->status !== 'pending')
                        <button type="button" 
                                onclick="openStatusChangeModal({{ $inv->id }}, 'pending', '{{ $inv->invoice_number }}')"
                                class="text-xs px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded">
                            Pendiente
                        </button>
                    @endif
                    
                    @if($inv->status !== 'paid')
                        <button type="button" 
                                onclick="openStatusChangeModal({{ $inv->id }}, 'paid', '{{ $inv->invoice_number }}')"
                                class="text-xs px-2 py-1 bg-green-500 hover:bg-green-600 text-white rounded">
                            Pagada
                        </button>
                    @endif
                    
                    @if($inv->status !== 'overdue')
                        <button type="button" 
                                onclick="openStatusChangeModal({{ $inv->id }}, 'overdue', '{{ $inv->invoice_number }}')"
                                class="text-xs px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded">
                            Vencida
                        </button>
                    @endif
                </div>
                            </td>
                            <td class="px-4 py-2">${{ number_format($inv->total, 2) }}</td>
                            <td class="px-4 py-2 space-x-2 text-sm text-center">
                                <button type="button" onclick="openViewModal({{ $inv->id }}, '{{ $inv->invoice_number }}', '{{ $inv->customer->name }}', '{{ $inv->issued_at->format('d/m/Y') }}', '{{ $inv->status }}', {{ $inv->total }}, {{ json_encode($inv->items->map(fn($item) => ['product_name' => $item->product->name ?? 'Producto eliminado', 'quantity' => $item->quantity, 'unit_price' => $item->unit_price, 'subtotal' => $item->subtotal])) }})"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded">
                                    Ver
                                </button>

                                <button type="button" onclick="openEditModal({{ $inv->id }}, '{{ $inv->customer->name }}', '{{ $inv->issued_at->format('Y-m-d') }}', {{ json_encode($inv->items) }})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                    Editar
                                </button>

                                <button type="button" onclick="openDeleteModal({{ $inv->id }}, '{{ $inv->invoice_number }}')"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-between items-center">
            <div class="text-sm text-gray-700">
                Mostrando {{ $invoices->firstItem() ?? 0 }} a {{ $invoices->lastItem() ?? 0 }} de {{ $invoices->total() }} resultados
            </div>
            {{ $invoices->appends(request()->query())->links() }}
        </div>
    </div>
    </div>

    <!-- Modal para mensaje de éxito -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-green-800">¡Éxito!</h2>
            </div>
            <p id="successModalText" class="mb-6 text-gray-700"></p>
            <div class="flex justify-end">
                <button type="button" onclick="closeSuccessModal()"
                    class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Aceptar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para productos duplicados -->
    <div id="duplicateProductModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-yellow-800">Producto ya agregado</h2>
            </div>
            <p id="duplicateProductText" class="mb-6 text-gray-700"></p>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDuplicateModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancelar
                </button>
                <button type="button" id="increaseQuantityBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Aumentar cantidad
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para razón de actualización -->
    <div id="updateReasonModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-blue-800">Actualizar Factura</h2>
            </div>
            <p class="mb-4 text-gray-700">Para actualizar la factura, es obligatorio proporcionar un motivo:</p>
            
            <label for="updateReasonTextArea" class="block text-sm text-gray-700 mb-1">Motivo de actualización *</label>
            <textarea id="updateReasonTextArea" class="w-full border rounded p-2 mb-4" rows="3"
                placeholder="Describe el motivo de la actualización..." required minlength="3" maxlength="255"></textarea>
            <p class="text-red-600 text-sm mt-1 hidden" id="update-reason-error"></p>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeUpdateReasonModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancelar
                </button>
                <button type="button" id="confirmUpdateBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Actualizar Factura
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para editar factura -->
    <div id="editInvoiceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-lg p-6 w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-blue-800">Editar Factura</h2>
            </div>

            <form id="editInvoiceForm" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Hidden inputs -->
                <input type="hidden" name="reason" id="editReasonInput">
                
                {{-- Cliente y fecha --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                        <select name="customer_id" id="editCustomerId" class="w-full rounded-lg border border-gray-300 px-4 py-2" required>
                            @foreach ($customers as $cust)
                                <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de emisión</label>
                        <input type="date" name="issued_at" id="editIssuedAt" class="w-full rounded-lg border border-gray-300 px-4 py-2" required>
                    </div>
                </div>

                {{-- Ítems --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Productos</label>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border border-gray-200" id="editItemsTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left px-4 py-2">Producto</th>
                                    <th class="text-left px-2 py-2">Cantidad</th>
                                    <th class="text-left px-2 py-2">Precio</th>
                                    <th class="text-left px-2 py-2">Subtotal</th>
                                    <th class="px-2 py-2"></th>
                                </tr>
                            </thead>
                            <tbody id="editItemsBody">
                                <!-- Items will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    
                    <button type="button" onclick="addEditRow()" class="mt-2 text-blue-600 hover:underline text-sm font-medium">
                        + Añadir ítem
                    </button>
                </div>

                {{-- Motivo de actualización --}}
                <div>
                    <label for="editReasonTextArea" class="block text-sm font-medium text-gray-700 mb-1">Motivo de actualización *</label>
                    <textarea id="editReasonTextArea" class="w-full border rounded p-2" rows="3"
                        placeholder="Describe el motivo de la actualización..." required minlength="3" maxlength="255"></textarea>
                    <p class="text-red-600 text-sm mt-1 hidden" id="edit-reason-error"></p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Actualizar Factura
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para ver detalles de factura -->
    <div id="viewInvoiceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-lg p-6 w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-green-800">Detalles de Factura</h2>
            </div>

            <div class="space-y-6">
                <!-- Invoice Header -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Número de Factura</label>
                            <p id="viewInvoiceNumber" class="text-lg font-semibold text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cliente</label>
                            <p id="viewCustomerName" class="text-lg font-semibold text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha</label>
                            <p id="viewIssuedDate" class="text-lg font-semibold text-gray-900"></p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <span id="viewInvoiceStatus" class="inline-flex px-3 py-1 text-sm font-semibold rounded-full"></span>
                    </div>
                </div>

                <!-- Invoice Items -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Productos</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left px-4 py-2 font-medium">Producto</th>
                                    <th class="text-right px-4 py-2 font-medium">Cantidad</th>
                                    <th class="text-right px-4 py-2 font-medium">Precio Unitario</th>
                                    <th class="text-right px-4 py-2 font-medium">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="viewInvoiceItems" class="divide-y divide-gray-200">
                                <!-- Items will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Total -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-700">Total:</span>
                        <span id="viewInvoiceTotal" class="text-2xl font-bold text-green-600"></span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeViewModal()"
                    class="px-6 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para eliminar factura -->
    <div id="deleteInvoiceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-red-800">Eliminar Factura Temporalmente</h2>
            </div>
            
            <p id="deleteInvoiceText" class="mb-4 text-gray-700"></p>
            
            <form id="deleteInvoiceForm" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="mb-4">
                    <label for="deleteReasonTextArea" class="block text-sm font-medium text-gray-700 mb-1">Motivo de eliminación *</label>
                    <textarea id="deleteReasonTextArea" 
                              name="reason" 
                              class="w-full border rounded p-2" 
                              rows="3"
                              placeholder="Describe el motivo por el cual se elimina esta factura..." 
                              required 
                              minlength="3" 
                              maxlength="255"></textarea>
                    <p class="text-red-600 text-sm mt-1 hidden" id="delete-reason-error"></p>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Eliminar Factura
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para cambiar estado de factura -->
    <div id="statusChangeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-blue-800">Cambiar Estado de Factura</h2>
            </div>
            
            <p id="statusChangeText" class="mb-6 text-gray-700"></p>
            
            <form id="statusChangeForm" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" id="newStatusInput">
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeStatusChangeModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancelar
                    </button>
                    <button type="submit" id="confirmStatusChangeBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS --}}
    <script>
        // Status change modal functions
        function openStatusChangeModal(invoiceId, newStatus, invoiceNumber) {
            const statusLabels = {
                'pending': 'Pendiente',
                'paid': 'Pagada',
                'overdue': 'Vencida'
            };
            
            const statusColors = {
                'pending': 'bg-yellow-600 hover:bg-yellow-700',
                'paid': 'bg-green-600 hover:bg-green-700',
                'overdue': 'bg-red-600 hover:bg-red-700'
            };
            
            const statusText = statusLabels[newStatus] || newStatus;
            
            document.getElementById('statusChangeText').textContent = 
                `¿Está seguro de cambiar el estado de la factura #${invoiceNumber} a "${statusText}"?`;
            
            document.getElementById('statusChangeForm').action = `/admin/invoices/${invoiceId}/status`;
            document.getElementById('newStatusInput').value = newStatus;
            
            // Update button color based on status
            const confirmBtn = document.getElementById('confirmStatusChangeBtn');
            confirmBtn.className = `px-4 py-2 text-white rounded focus:outline-none focus:ring-2 focus:ring-offset-2 ${statusColors[newStatus]}`;
            confirmBtn.textContent = `Cambiar a ${statusText}`;
            
            document.getElementById('statusChangeModal').style.display = 'flex';
        }

        function closeStatusChangeModal() {
            document.getElementById('statusChangeModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('statusChangeModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStatusChangeModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const statusModal = document.getElementById('statusChangeModal');
                if (statusModal.style.display === 'flex') {
                    closeStatusChangeModal();
                }
            }
        });

        // View invoice modal functions
        function openViewModal(invoiceId, invoiceNumber, customerName, issuedDate, status, total, items) {
            document.getElementById('viewInvoiceNumber').textContent = invoiceNumber;
            document.getElementById('viewCustomerName').textContent = customerName;
            document.getElementById('viewIssuedDate').textContent = issuedDate;
            
            // Set status with proper styling
            const statusElement = document.getElementById('viewInvoiceStatus');
            const statusConfig = {
                'pending': { text: 'Pendiente', bg: 'bg-yellow-100', textColor: 'text-yellow-800' },
                'paid': { text: 'Pagada', bg: 'bg-green-100', textColor: 'text-green-800' },
                'overdue': { text: 'Vencida', bg: 'bg-red-100', textColor: 'text-red-800' }
            };
            
            const config = statusConfig[status] || { text: status, bg: 'bg-gray-100', textColor: 'text-gray-800' };
            statusElement.textContent = config.text;
            statusElement.className = `inline-flex px-3 py-1 text-sm font-semibold rounded-full ${config.bg} ${config.textColor}`;
            
            // Set total
            document.getElementById('viewInvoiceTotal').textContent = `$${parseFloat(total).toFixed(2)}`;
            
            // Populate items
            const itemsBody = document.getElementById('viewInvoiceItems');
            itemsBody.innerHTML = '';
            
            items.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-4 py-2">${item.product_name}</td>
                    <td class="px-4 py-2 text-right">${item.quantity}</td>
                    <td class="px-4 py-2 text-right">$${parseFloat(item.unit_price).toFixed(2)}</td>
                    <td class="px-4 py-2 text-right">$${parseFloat(item.subtotal).toFixed(2)}</td>
                `;
                itemsBody.appendChild(row);
            });
            
            document.getElementById('viewInvoiceModal').style.display = 'flex';
        }

        function closeViewModal() {
            document.getElementById('viewInvoiceModal').style.display = 'none';
        }

        // Delete invoice modal functions
        function openDeleteModal(invoiceId, invoiceNumber) {
            document.getElementById('deleteInvoiceText').textContent = 
                `¿Está seguro de que desea eliminar temporalmente la factura #${invoiceNumber}? La factura será movida a la papelera y podrá restaurarla posteriormente. El stock NO será restaurado hasta la eliminación definitiva.`;
            
            document.getElementById('deleteInvoiceForm').action = `/admin/invoices/${invoiceId}`;
            document.getElementById('deleteReasonTextArea').value = '';
            
            // Clear any previous errors
            const errorEl = document.getElementById('delete-reason-error');
            const input = document.getElementById('deleteReasonTextArea');
            errorEl.classList.add('hidden');
            input.classList.remove('border-red-500');
            input.classList.add('border-gray-300');
            
            document.getElementById('deleteInvoiceModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteInvoiceModal').style.display = 'none';
        }

        function validateDeleteReason(value) {
            if (!value.trim()) return 'El motivo de eliminación es requerido';
            if (value.trim().length < 3) return 'El motivo debe tener al menos 3 caracteres';
            if (value.length > 255) return 'El motivo no puede tener más de 255 caracteres';
            return true;
        }

        // Success modal functions
        function showSuccessModal(message) {
            document.getElementById('successModalText').textContent = message;
            document.getElementById('successModal').style.display = 'flex';
        }

        function closeSuccessModal() {
            document.getElementById('successModal').style.display = 'none';
        }

        // Duplicate product modal functions
        let duplicateProductData = null;

        function showDuplicateModal(productName, existingRow, newSelect) {
            document.getElementById('duplicateProductText').textContent = 
                `El producto "${productName}" ya está en la factura. ¿Deseas aumentar la cantidad en la línea existente?`;
            
            duplicateProductData = { existingRow, newSelect };
            document.getElementById('duplicateProductModal').style.display = 'flex';
        }

        function closeDuplicateModal() {
            document.getElementById('duplicateProductModal').style.display = 'none';
            if (duplicateProductData) {
                // Reset the new select to empty
                duplicateProductData.newSelect.value = '';
                duplicateProductData = null;
            }
        }

        // Edit invoice modal functions
        let currentEditInvoiceId = null;

        function openEditModal(invoiceId, customerName, issuedAt, items) {
            currentEditInvoiceId = invoiceId;
            
            // Set form action
            document.getElementById('editInvoiceForm').action = `/admin/invoices/${invoiceId}`;
            
            // Set customer (find by name since we have the name)
            const customerSelect = document.getElementById('editCustomerId');
            for (let option of customerSelect.options) {
                if (option.textContent.trim() === customerName) {
                    option.selected = true;
                    break;
                }
            }
            
            // Set date
            document.getElementById('editIssuedAt').value = issuedAt;
            
            // Clear and populate items
            const tbody = document.getElementById('editItemsBody');
            tbody.innerHTML = '';
            
            items.forEach((item, index) => {
                addEditRowWithData(index, item.product_id, item.quantity, item.unit_price);
            });
            
            // Clear reason
            document.getElementById('editReasonTextArea').value = '';
            document.getElementById('edit-reason-error').classList.add('hidden');
            
            // Show modal
            document.getElementById('editInvoiceModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editInvoiceModal').style.display = 'none';
            currentEditInvoiceId = null;
        }

        function addEditRowWithData(index, productId, quantity, price) {
            const tbody = document.getElementById('editItemsBody');
            
            let opts = '<option value="">-- Producto --</option>';
            products.forEach(p => {
                const selected = p.id == productId ? 'selected' : '';
                opts += `<option value="${p.id}" data-price="${p.price}" ${selected}>${p.name}</option>`;
            });

            tbody.insertAdjacentHTML('beforeend', `
                <tr class="border-b border-gray-100">
                    <td class="px-4 py-2">
                        <select name="items[${index}][product_id]"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-1 focus:ring-indigo-300 edit-product-select"
                                required>${opts}</select>
                    </td>
                    <td class="px-2 py-2">
                        <input type="number" name="items[${index}][qty]"
                               class="w-20 rounded-md border border-gray-300 px-2 py-1 shadow-sm edit-qty-input"
                               value="${quantity}" min="1" required>
                    </td>
                    <td class="px-2 py-2">
                        <input type="number" name="items[${index}][price]"
                               class="w-28 rounded-md border border-gray-300 px-2 py-1 shadow-sm edit-price-input"
                               value="${price}" step="0.01" readonly>
                    </td>
                    <td class="px-2 py-2">
                        <input type="number"
                               class="w-32 rounded-md border border-gray-300 px-2 py-1 shadow-sm edit-subtotal-input"
                               value="${(quantity * price).toFixed(2)}" step="0.01" readonly>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <button type="button" onclick="removeEditRow(this)"
                                class="text-red-500 hover:text-red-700 transition">🗑️</button>
                    </td>
                </tr>
            `);
        }

        function addEditRow() {
            const tbody = document.getElementById('editItemsBody');
            const index = tbody.children.length;
            addEditRowWithData(index, '', 1, 0);
        }

        function removeEditRow(btn) {
            btn.closest('tr').remove();
        }

        function calcEditRow(row) {
            const qty = parseFloat(row.querySelector('.edit-qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.edit-price-input').value) || 0;
            row.querySelector('.edit-subtotal-input').value = (qty * price).toFixed(2);
        }

        // Update reason modal functions
        function showUpdateReasonModal() {
            document.getElementById('updateReasonTextArea').value = '';
            // Clear any previous errors
            const errorEl = document.getElementById('update-reason-error');
            const input = document.getElementById('updateReasonTextArea');
            errorEl.classList.add('hidden');
            input.classList.remove('border-red-500');
            input.classList.add('border-gray-300');
            
            document.getElementById('updateReasonModal').style.display = 'flex';
        }

        function closeUpdateReasonModal() {
            document.getElementById('updateReasonModal').style.display = 'none';
        }

        function validateUpdateReason(value) {
            if (!value.trim()) return 'La razón es requerida';
            if (value.trim().length < 3) return 'La razón debe tener al menos 3 caracteres';
            if (value.length > 255) return 'La razón no puede tener más de 255 caracteres';
            return true;
        }

        function validateReasonField(input, errorEl, validator) {
            const isValid = validator(input.value);
            if (isValid === true) {
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-300');
                errorEl.classList.add('hidden');
                return true;
            } else {
                input.classList.add('border-red-500');
                input.classList.remove('border-gray-300');
                errorEl.textContent = isValid;
                errorEl.classList.remove('hidden');
                return false;
            }
        }

        // Check for duplicate products
        function checkDuplicateProduct(selectElement) {
            const selectedProductId = selectElement.value;
            if (!selectedProductId) return false;

            const currentRow = selectElement.closest('tr');
            const allProductSelects = document.querySelectorAll('.product-select');
            
            for (let select of allProductSelects) {
                if (select !== selectElement && select.value === selectedProductId) {
                    const existingRow = select.closest('tr');
                    const productName = select.selectedOptions[0]?.textContent || 'Unknown';
                    
                    // Show modal asking to increase quantity
                    showDuplicateModal(productName, existingRow, selectElement);
                    return true; // Duplicate found
                }
            }
            return false; // No duplicate
        }

        // Check for success message and show modal when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('status'))
                showSuccessModal('{{ session('status') }}');
            @endif

            // Add initial row if table is empty
            const tbody = document.querySelector('#itemsTable tbody');
            if (tbody.children.length === 0) {
                addRow();
            }

            // Add form validation
            const invoiceForm = document.getElementById('invoiceForm');
            if (invoiceForm) {
                invoiceForm.addEventListener('submit', function(e) {
                    console.log('Form submission attempted');
                    
                    // Check if there are any items
                    const items = document.querySelectorAll('#itemsTable tbody tr');
                    if (items.length === 0) {
                        e.preventDefault();
                        alert('Debe agregar al menos un producto a la factura.');
                        return false;
                    }
                    
                    // Check if all items have products selected
                    let hasInvalidItems = false;
                    items.forEach(item => {
                        const productSelect = item.querySelector('.product-select');
                        if (!productSelect.value) {
                            hasInvalidItems = true;
                        }
                    });
                    
                    if (hasInvalidItems) {
                        e.preventDefault();
                        alert('Todos los productos deben estar seleccionados.');
                        return false;
                    }
                    
                    console.log('Form validation passed, submitting...');
                });
            }

            // Handle increase quantity button
            const increaseQuantityBtn = document.getElementById('increaseQuantityBtn');
            if (increaseQuantityBtn) {
                increaseQuantityBtn.addEventListener('click', function() {
                    if (duplicateProductData) {
                        const existingQtyInput = duplicateProductData.existingRow.querySelector('.qty-input');
                        const currentQty = parseInt(existingQtyInput.value) || 1;
                        existingQtyInput.value = currentQty + 1;
                        
                        // Recalculate the existing row
                        calcRow(duplicateProductData.existingRow);
                        
                        // Remove the new row if it was just added
                        const newRow = duplicateProductData.newSelect.closest('tr');
                        if (newRow && newRow.parentNode.children.length > 1) {
                            newRow.remove();
                        }
                        
                        closeDuplicateModal();
                    }
                });
            }

            // Handle update reason modal
            const updateReasonTextArea = document.getElementById('editReasonTextArea');
            if (updateReasonTextArea) {
                updateReasonTextArea.addEventListener('blur', () => {
                    validateReasonField(updateReasonTextArea, document.getElementById('edit-reason-error'), validateUpdateReason);
                });
            }

            // Handle edit form submission
            const editInvoiceForm = document.getElementById('editInvoiceForm');
            if (editInvoiceForm) {
                editInvoiceForm.addEventListener('submit', function(e) {
                    const reasonTextArea = document.getElementById('editReasonTextArea');
                    const reasonValid = validateReasonField(reasonTextArea, document.getElementById('edit-reason-error'), validateUpdateReason);
                    
                    if (!reasonValid) {
                        e.preventDefault();
                        alert('Debes ingresar un motivo válido de actualización.');
                        return;
                    }
                    
                    const reason = reasonTextArea.value.trim();
                    document.getElementById('editReasonInput').value = reason;
                });
            }

            // Handle delete form submission
            const deleteInvoiceForm = document.getElementById('deleteInvoiceForm');
            if (deleteInvoiceForm) {
                deleteInvoiceForm.addEventListener('submit', function(e) {
                    const reasonTextArea = document.getElementById('deleteReasonTextArea');
                    const reasonValid = validateReasonField(reasonTextArea, document.getElementById('delete-reason-error'), validateDeleteReason);
                    
                    if (!reasonValid) {
                        e.preventDefault();
                        alert('Debes ingresar un motivo válido de eliminación.');
                        return;
                    }
                });
            }

            // Handle delete reason validation
            const deleteReasonTextArea = document.getElementById('deleteReasonTextArea');
            if (deleteReasonTextArea) {
                deleteReasonTextArea.addEventListener('blur', () => {
                    validateReasonField(deleteReasonTextArea, document.getElementById('delete-reason-error'), validateDeleteReason);
                });
            }

            // Close modals when clicking outside
            document.getElementById('viewInvoiceModal').addEventListener('click', function(e) {
                if (e.target === this) closeViewModal();
            });

            document.getElementById('deleteInvoiceModal').addEventListener('click', function(e) {
                if (e.target === this) closeDeleteModal();
            });

            // Close modals with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const viewModal = document.getElementById('viewInvoiceModal');
                    const deleteModal = document.getElementById('deleteInvoiceModal');
                    
                    if (viewModal.style.display === 'flex') {
                        closeViewModal();
                    } else if (deleteModal.style.display === 'flex') {
                        closeDeleteModal();
                    }
                }
            });
        });

        // productos disponibles en JSON
        const products = @json($products->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'price' => $p->price]));

        function addRow() {
            const tbody = document.querySelector('#itemsTable tbody');
            const i = tbody.children.length;

            let opts = '<option value="">-- Producto --</option>';
            products.forEach(p => {
                opts += `<option value="${p.id}" data-price="${p.price}">${p.name}</option>`;
            });

            tbody.insertAdjacentHTML('beforeend', `
            <tr class="border-b border-gray-100">
                <td class="px-4 py-2">
                    <select name="items[${i}][product_id]"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring-1 focus:ring-indigo-300 product-select"
                            required>${opts}</select>
                </td>

                <td class="px-2 py-2">
                    <input type="number" name="items[${i}][qty]"
                           class="w-20 rounded-md border border-gray-300 px-2 py-1 shadow-sm qty-input"
                           value="1" min="1" required>
                </td>

                <td class="px-2 py-2">
                    <input type="number" name="items[${i}][price]"
                           class="w-28 rounded-md border border-gray-300 px-2 py-1 shadow-sm price-input"
                           value="0" step="0.01" readonly>
                </td>

                <td class="px-2 py-2">
                    <input type="number"
                           class="w-32 rounded-md border border-gray-300 px-2 py-1 shadow-sm subtotal-input"
                           value="0" step="0.01" readonly>
                </td>

                <td class="px-2 py-2 text-center">
                    <button type="button" onclick="removeRow(this)"
                            class="text-red-500 hover:text-red-700 transition">🗑️</button>
                </td>
            </tr>
        `);
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
        }

        // delegación: cambia producto o cantidad
        document.addEventListener('change', e => {
            if (e.target.matches('.product-select')) {
                // Check for duplicates first
                if (checkDuplicateProduct(e.target)) {
                    return; // Don't proceed if duplicate found
                }

                const price = e.target.selectedOptions[0]?.dataset.price || 0;
                const row = e.target.closest('tr');
                row.querySelector('.price-input').value = price;
                calcRow(row);
            }
            if (e.target.matches('.qty-input')) {
                calcRow(e.target.closest('tr'));
            }
        });

        function calcRow(row) {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            row.querySelector('.subtotal-input').value = (qty * price).toFixed(2);
        }

        // recalcula subtotales iniciales
        document.querySelectorAll('#itemsTable tbody tr').forEach(calcRow);
    </script>
</x-app-layout>
