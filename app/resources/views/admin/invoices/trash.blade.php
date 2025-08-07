<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Papelera de Facturas</h2>
            <a href="{{ route('admin.invoices.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                ← Volver a Facturas
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm">
                {{ session('status') }}
            </div>
        @endif

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

        <div class="bg-white p-6 rounded-md shadow-md">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Facturas Eliminadas Temporalmente</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Total: {{ $trashedInvoices->total() }}</span>
                    @if(request('search') || request('customer'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            Filtros aplicados
                        </span>
                    @endif
                </div>
            </div>

            <!-- Search and Filters -->
            <form method="GET" action="{{ route('admin.invoices.trash') }}" class="mb-6">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                            <input type="text" 
                                   id="search"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Número, motivo o cliente..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="customer" class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                            <select name="customer" id="customer" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Todos los clientes</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ request('customer') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="flex items-end gap-2">
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-semibold transition">
                                Buscar
                            </button>
                            <a href="{{ route('admin.invoices.trash') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition">
                                Limpiar
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Número</th>
                            <th scope="col" class="px-6 py-3">Cliente</th>
                            <th scope="col" class="px-6 py-3">Total</th>
                            <th scope="col" class="px-6 py-3">Estado</th>
                            <th scope="col" class="px-6 py-3">Eliminada por</th>
                            <th scope="col" class="px-6 py-3">Motivo</th>
                            <th scope="col" class="px-6 py-3">Fecha eliminación</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trashedInvoices as $invoice)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $invoice->invoice_number }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $invoice->customer->name ?? 'Cliente eliminado' }}
                                </td>
                                <td class="px-6 py-4">
                                    ${{ number_format($invoice->total, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($invoice->status === 'paid') bg-green-100 text-green-800
                                        @elseif($invoice->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $invoice->softDeleter->name ?? 'Usuario eliminado' }}
                                </td>
                                <td class="px-6 py-4 max-w-xs">
                                    <div class="truncate" title="{{ $invoice->soft_delete_reason }}">
                                        {{ $invoice->soft_delete_reason }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $invoice->deleted_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <!-- Restore Button -->
                                        @can('edit_invoices')
                                            @if(Auth::user()->hasRole('Administrador') || $invoice->created_by === Auth::id())
                                                <button onclick="openRestoreModal('{{ $invoice->id }}', '{{ $invoice->invoice_number }}')" 
                                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                                    Restaurar
                                                </button>
                                            @endif
                                        @endcan

                                        <!-- Permanent Delete Button -->
                                        @can('delete_invoices')
                                            @if(Auth::user()->hasRole('Administrador'))
                                                <button onclick="openForceDeleteModal('{{ $invoice->id }}', '{{ $invoice->invoice_number }}')" 
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                                    Eliminar Definitivamente
                                                </button>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center space-y-2">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No hay facturas en la papelera</p>
                                        <p class="text-sm">Las facturas eliminadas temporalmente aparecerán aquí</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($trashedInvoices->hasPages())
                <div class="mt-6">
                    {{ $trashedInvoices->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Restore Modal -->
    <div id="restoreModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-center mx-auto w-12 h-12 rounded-full bg-green-100">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <div class="mt-5 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Restaurar Factura</h3>
                    <div class="mt-3 px-7 py-3">
                        <p class="text-sm text-gray-500">
                            ¿Está seguro de que desea restaurar la factura <span class="font-semibold" id="restoreInvoiceNumber"></span>?
                        </p>
                        <p class="text-sm text-green-600 mt-2 font-medium">
                            La factura volverá a estar activa y disponible para edición.
                        </p>
                        
                        <form id="restoreForm" method="POST" class="mt-4">
                            @csrf
                            @method('PATCH')
                        </form>
                    </div>
                    <div class="flex justify-center space-x-3 px-4 py-3">
                        <button onclick="closeRestoreModal()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-semibold transition">
                            Cancelar
                        </button>
                        <button onclick="submitRestore()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold transition">
                            Restaurar Factura
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Force Delete Modal -->
    <div id="forceDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-center mx-auto w-12 h-12 rounded-full bg-red-100">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Eliminar Definitivamente</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">
                            ¿Está seguro de que desea eliminar definitivamente la factura <strong id="invoiceNumber"></strong>?
                        </p>
                        <p class="text-sm text-red-600 mt-2 font-medium">
                            Esta acción restaurará el stock y NO se puede deshacer.
                        </p>
                        
                        <form id="forceDeleteForm" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <div class="text-left">
                                <label for="final_reason" class="block text-sm font-medium text-gray-700 mb-1">
                                    Motivo de eliminación definitiva
                                </label>
                                <textarea 
                                    name="final_reason" 
                                    id="final_reason"
                                    rows="3" 
                                    required
                                    placeholder="Explique por qué esta factura debe ser eliminada definitivamente..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="flex justify-end space-x-3 px-4 py-3">
                        <button onclick="closeForceDeleteModal()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-semibold transition">
                            Cancelar
                        </button>
                        <button onclick="submitForceDelete()" 
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold transition">
                            Eliminar Definitivamente
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openForceDeleteModal(invoiceId, invoiceNumber) {
            document.getElementById('invoiceNumber').textContent = invoiceNumber;
            document.getElementById('forceDeleteForm').action = "{{ route('admin.invoices.forceDelete', ':id') }}".replace(':id', invoiceId);
            document.getElementById('final_reason').value = '';
            document.getElementById('forceDeleteModal').classList.remove('hidden');
        }

        function closeForceDeleteModal() {
            document.getElementById('forceDeleteModal').classList.add('hidden');
        }

        function submitForceDelete() {
            const reason = document.getElementById('final_reason').value;
            if (reason.trim().length < 3) {
                alert('El motivo debe tener al menos 3 caracteres.');
                return;
            }
            document.getElementById('forceDeleteForm').submit();
        }

        // Restore Modal Functions
        function openRestoreModal(invoiceId, invoiceNumber) {
            document.getElementById('restoreInvoiceNumber').textContent = invoiceNumber;
            document.getElementById('restoreForm').action = "{{ route('admin.invoices.restore', ':id') }}".replace(':id', invoiceId);
            document.getElementById('restoreModal').classList.remove('hidden');
        }

        function closeRestoreModal() {
            document.getElementById('restoreModal').classList.add('hidden');
        }

        function submitRestore() {
            document.getElementById('restoreForm').submit();
        }

        // Close modal when clicking outside
        document.getElementById('forceDeleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeForceDeleteModal();
            }
        });

        document.getElementById('restoreModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRestoreModal();
            }
        });
    </script>
</x-app-layout>
