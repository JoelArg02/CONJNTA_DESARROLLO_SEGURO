<x-app-layout>

    <section id="clients-section" class="content-section hidden">
        <h1>text</h1>
    </section>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Clientes') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Formulario crear o editar --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-lg font-semibold mb-4">
                {{ isset($editingCustomer) ? 'Editar Cliente' : 'Crear Cliente' }}
            </h3>

            <form method="POST"
                action="{{ isset($editingCustomer) ? route('admin.customers.update', $editingCustomer->id) : route('admin.customers.store') }}">
                @csrf
                @if (isset($editingCustomer))
                    @method('PUT')
                @endif

            <form method="POST" id="customer-form"
                action="{{ isset($editingCustomer) ? route('admin.customers.update', $editingCustomer->id) : route('admin.customers.store') }}">
                @csrf
                @if (isset($editingCustomer))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <input name="name" type="text" placeholder="Nombre *" 
                               class="form-input w-full border rounded px-3 py-2" required minlength="2" maxlength="255"
                               value="{{ old('name', $editingCustomer->name ?? '') }}">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-red-600 text-sm mt-1 hidden" id="name-error"></p>
                    </div>
                    <div>
                        <input name="email" type="email" placeholder="Email *" 
                               class="form-input w-full border rounded px-3 py-2" required maxlength="255"
                               value="{{ old('email', $editingCustomer->email ?? '') }}">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-red-600 text-sm mt-1 hidden" id="email-error"></p>
                    </div>
                    <div>
                        <input name="phone" type="tel" placeholder="Teléfono" 
                               class="form-input w-full border rounded px-3 py-2" maxlength="20"
                               pattern="[0-9+\-\s()]*"
                               value="{{ old('phone', $editingCustomer->phone ?? '') }}">
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-red-600 text-sm mt-1 hidden" id="phone-error"></p>
                    </div>
                    <div>
                        <input name="address" type="text" placeholder="Dirección" 
                               class="form-input w-full border rounded px-3 py-2" maxlength="500"
                               value="{{ old('address', $editingCustomer->address ?? '') }}">
                        @error('address')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-red-600 text-sm mt-1 hidden" id="address-error"></p>
                    </div>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    @if (isset($editingCustomer))
                        <a href="{{ route('admin.customers.index') }}"
                            class="text-sm text-gray-600 hover:underline">Cancelar</a>
                    @endif
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        {{ isset($editingCustomer) ? 'Guardar cambios' : 'Crear cliente' }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabla de clientes activos --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-lg font-semibold mb-4">Clientes Activos</h3>

            @if ($customers->count())
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-sm text-gray-600 uppercase tracking-wider">
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $c)
                            <tr class="border-b">
                                <td class="py-2">{{ $c->name }}</td>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->phone }}</td>
                                <td>{{ $c->address }}</td>
                                <td class="space-x-2 p-2">
                                    <a href="{{ route('admin.customers.index', ['edit' => $c->id]) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>

                                    <form action="{{ route('admin.customers.destroy', $c->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('¿Desactivar este cliente?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="reason" value="Desactivado manualmente">
                                        <button type="button"
                                            onclick="openDeactivateModal({{ $c->id }}, '{{ $c->name }}')"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            Desactivar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No hay clientes activos.</p>
            @endif
        </div>

        {{-- Tabla de clientes desactivados --}}
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Clientes Desactivados</h3>

            @if ($disabledCustomers->count())
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-sm text-gray-600 uppercase tracking-wider">
                            <th>Nombre</th>
                            <th>Motivo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($disabledCustomers as $c)
                            <tr class="border-b">
                                <td class="py-2">{{ $c->name }}</td>
                                <td>{{ $c->deactivation_reason }}</td>
                                <td class="p-2">
                                    <form action="{{ route('admin.customers.restore', $c->id) }}" method="POST"
                                        id="restoreForm-{{ $c->id }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="button"
                                            onclick="openReactivateModal({{ $c->id }}, '{{ $c->name }}')"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded">
                                            Reactivar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No hay clientes desactivados.</p>
            @endif
        </div>
    </div>
    <!-- Modal para desactivar cliente -->
    <div id="deactivateModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <h2 class="text-lg font-semibold mb-4">Desactivar Cliente</h2>
            <form id="deactivateForm" method="POST">
                @csrf
                @method('DELETE')

                <input type="hidden" name="reason" id="deactivateReasonInput">
                <p id="deactivateModalText" class="mb-4"></p>

                <label for="reasonTextArea" class="block text-sm text-gray-700 mb-1">Motivo de desactivación *</label>
                <textarea id="reasonTextArea" class="w-full border rounded p-2 mb-4" rows="3"
                    placeholder="Motivo de desactivación..." required minlength="3" maxlength="255"></textarea>
                <p class="text-red-600 text-sm mt-1 hidden" id="deactivate-reason-error"></p>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeDeactivateModal()"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Confirmar</button>
                </div>
            </form>
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

    <!-- Modal para reactivar cliente -->
    <div id="reactivateModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-green-800">Reactivar Cliente</h2>
            </div>
            <p id="reactivateModalText" class="mb-6 text-gray-700"></p>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeReactivateModal()"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</button>
                <button type="button" onclick="confirmReactivate()"
                    class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Confirmar
                </button>
            </div>
        </div>
    </div>

    <script>
        // Validation functions
        function validateField(input, errorEl, validator) {
            const isValid = validator(input.value);
            if (isValid === true) {
                hideError(input, errorEl);
                return true;
            } else {
                showError(input, errorEl, isValid);
                return false;
            }
        }

        function showError(input, errorEl, message) {
            input.classList.add('border-red-500');
            input.classList.remove('border-gray-300');
            errorEl.textContent = message;
            errorEl.classList.remove('hidden');
        }

        function hideError(input, errorEl) {
            input.classList.remove('border-red-500');
            input.classList.add('border-gray-300');
            errorEl.classList.add('hidden');
        }

        function validateName(value) {
            if (!value.trim()) return 'El nombre es requerido';
            if (value.trim().length < 2) return 'El nombre debe tener al menos 2 caracteres';
            if (value.length > 255) return 'El nombre no puede tener más de 255 caracteres';
            return true;
        }

        function validateEmail(value) {
            if (!value.trim()) return 'El email es requerido';
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(value)) return 'Formato de email inválido';
            if (value.length > 255) return 'El email no puede tener más de 255 caracteres';
            return true;
        }

        function validatePhone(value) {
            if (value && value.length > 20) return 'El teléfono no puede tener más de 20 caracteres';
            if (value && !/^[0-9+\-\s()]*$/.test(value)) return 'El teléfono solo puede contener números, +, -, espacios y paréntesis';
            return true;
        }

        function validateAddress(value) {
            if (value && value.length > 500) return 'La dirección no puede tener más de 500 caracteres';
            return true;
        }

        function validateReason(value) {
            if (!value.trim()) return 'La razón es requerida';
            if (value.trim().length < 3) return 'La razón debe tener al menos 3 caracteres';
            if (value.length > 255) return 'La razón no puede tener más de 255 caracteres';
            return true;
        }

        function openDeactivateModal(customerId, customerName) {
            const form = document.getElementById('deactivateForm');
            form.action = "{{ route('admin.customers.destroy', ':id') }}".replace(':id', customerId);

            document.getElementById('reasonTextArea').value = '';
            document.getElementById('deactivateModalText').textContent = `¿Deseas desactivar al cliente "${customerName}"?`;
            
            // Clear any previous errors
            const errorEl = document.getElementById('deactivate-reason-error');
            const input = document.getElementById('reasonTextArea');
            errorEl.classList.add('hidden');
            input.classList.remove('border-red-500');
            input.classList.add('border-gray-300');
            
            document.getElementById('deactivateModal').style.display = 'flex';
        }

        function closeDeactivateModal() {
            document.getElementById('deactivateModal').style.display = 'none';
        }

        function showSuccessModal(message) {
            document.getElementById('successModalText').textContent = message;
            document.getElementById('successModal').style.display = 'flex';
        }

        function closeSuccessModal() {
            document.getElementById('successModal').style.display = 'none';
        }

        let currentReactivateCustomerId = null;

        function openReactivateModal(customerId, customerName) {
            currentReactivateCustomerId = customerId;
            document.getElementById('reactivateModalText').textContent = `¿Deseas reactivar al cliente "${customerName}"?`;
            document.getElementById('reactivateModal').style.display = 'flex';
        }

        function closeReactivateModal() {
            document.getElementById('reactivateModal').style.display = 'none';
            currentReactivateCustomerId = null;
        }

        function confirmReactivate() {
            if (currentReactivateCustomerId) {
                const form = document.getElementById(`restoreForm-${currentReactivateCustomerId}`);
                if (form) {
                    form.submit();
                }
            }
        }

        // DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            // Check for success message and show modal
            @if (session('status'))
                showSuccessModal('{{ session('status') }}');
            @endif

            // Customer form validation
            const customerForm = document.getElementById('customer-form');
            const nameInput = document.querySelector('input[name="name"]');
            const emailInput = document.querySelector('input[name="email"]');
            const phoneInput = document.querySelector('input[name="phone"]');
            const addressInput = document.querySelector('input[name="address"]');

            if (nameInput) {
                nameInput.addEventListener('blur', () => {
                    validateField(nameInput, document.getElementById('name-error'), validateName);
                });
            }

            if (emailInput) {
                emailInput.addEventListener('blur', () => {
                    validateField(emailInput, document.getElementById('email-error'), validateEmail);
                });
            }

            if (phoneInput) {
                phoneInput.addEventListener('blur', () => {
                    validateField(phoneInput, document.getElementById('phone-error'), validatePhone);
                });
            }

            if (addressInput) {
                addressInput.addEventListener('blur', () => {
                    validateField(addressInput, document.getElementById('address-error'), validateAddress);
                });
            }

            // Customer form submission validation
            if (customerForm) {
                customerForm.addEventListener('submit', function(e) {
                    const nameValid = validateField(nameInput, document.getElementById('name-error'), validateName);
                    const emailValid = validateField(emailInput, document.getElementById('email-error'), validateEmail);
                    const phoneValid = validateField(phoneInput, document.getElementById('phone-error'), validatePhone);
                    const addressValid = validateField(addressInput, document.getElementById('address-error'), validateAddress);

                    if (!nameValid || !emailValid || !phoneValid || !addressValid) {
                        e.preventDefault();
                        alert('Por favor, corrija los errores antes de enviar el formulario.');
                    }
                });
            }

            // Deactivate form validation
            const reasonTextArea = document.getElementById('reasonTextArea');
            if (reasonTextArea) {
                reasonTextArea.addEventListener('blur', () => {
                    validateField(reasonTextArea, document.getElementById('deactivate-reason-error'), validateReason);
                });
            }
        });

        // Antes de enviar, pasa el motivo del textarea al input hidden
        document.getElementById('deactivateForm').addEventListener('submit', function(e) {
            const reasonTextArea = document.getElementById('reasonTextArea');
            const reasonValid = validateField(reasonTextArea, document.getElementById('deactivate-reason-error'), validateReason);
            
            if (!reasonValid) {
                e.preventDefault();
                alert('Debes ingresar un motivo válido de desactivación.');
                return;
            }
            
            const reason = reasonTextArea.value.trim();
            document.getElementById('deactivateReasonInput').value = reason;
        });
    </script>

</x-app-layout>
