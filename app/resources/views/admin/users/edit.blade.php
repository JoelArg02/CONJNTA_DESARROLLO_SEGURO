<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Usuario</h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-6 text-black">
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}" id="user-edit-form">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full border rounded px-3 py-2"
                       required minlength="2" maxlength="255">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-red-600 text-sm mt-1 hidden" id="name-error"></p>
            </div>

            <div class="mb-3">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo *</label>
                <input type="email" name="email" id="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full border rounded px-3 py-2"
                       required maxlength="255">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-red-600 text-sm mt-1 hidden" id="email-error"></p>
            </div>

            <div class="mb-3">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña</label>
                <input type="password" name="password" id="password"
                       placeholder="Dejar en blanco para mantener la actual"
                       class="w-full border rounded px-3 py-2" minlength="8">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-red-600 text-sm mt-1 hidden" id="password-error"></p>
                <p class="text-gray-500 text-xs mt-1">Opcional - Mínimo 8 caracteres si se modifica</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Roles * (seleccione al menos uno)</label>
                <div class="space-y-2">
                    @php
                        $userRoles = old('roles', $user->getRoleNames()->toArray());
                    @endphp
                    @foreach ($roles as $role)
                        <label class="flex items-center">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                   class="mr-2 role-checkbox"
                                   {{ in_array($role->name, $userRoles) ? 'checked' : '' }}>
                            <span class="capitalize">{{ $role->name }}</span>
                            @if($role->name === 'Administrador')
                                <span class="text-gray-500 text-sm ml-2">(Acceso completo)</span>
                            @elseif($role->name === 'Secretario')
                                <span class="text-gray-500 text-sm ml-2">(Gestión de clientes y reportes)</span>
                            @elseif($role->name === 'Bodega')
                                <span class="text-gray-500 text-sm ml-2">(Gestión de productos)</span>
                            @elseif($role->name === 'Ventas')
                                <span class="text-gray-500 text-sm ml-2">(Creación de facturas)</span>
                            @endif
                        </label>
                    @endforeach
                </div>
                @error('roles')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-red-600 text-sm mt-1 hidden" id="roles-error"></p>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Cancelar</a>
                <button type="submit" class="bg-blue-300 text-black px-4 py-2 rounded hover:bg-blue-400">Actualizar</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('user-edit-form');
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const roleCheckboxes = document.querySelectorAll('.role-checkbox');

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

            function validatePassword(value) {
                // Password is optional on edit, but if provided, must be at least 8 chars
                if (value && value.length < 8) return 'La contraseña debe tener al menos 8 caracteres';
                return true;
            }

            function validateRoles() {
                const checkedRoles = document.querySelectorAll('.role-checkbox:checked');
                const errorEl = document.getElementById('roles-error');
                
                if (checkedRoles.length === 0) {
                    errorEl.textContent = 'Debe seleccionar al menos un rol';
                    errorEl.classList.remove('hidden');
                    return false;
                } else {
                    errorEl.classList.add('hidden');
                    return true;
                }
            }

            // Real-time validation
            nameInput.addEventListener('blur', () => {
                validateField(nameInput, document.getElementById('name-error'), validateName);
            });

            emailInput.addEventListener('blur', () => {
                validateField(emailInput, document.getElementById('email-error'), validateEmail);
            });

            passwordInput.addEventListener('blur', () => {
                validateField(passwordInput, document.getElementById('password-error'), validatePassword);
            });

            roleCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', validateRoles);
            });

            // Form submission validation
            form.addEventListener('submit', function(e) {
                const isNameValid = validateField(nameInput, document.getElementById('name-error'), validateName);
                const isEmailValid = validateField(emailInput, document.getElementById('email-error'), validateEmail);
                const isPasswordValid = validateField(passwordInput, document.getElementById('password-error'), validatePassword);
                const areRolesValid = validateRoles();

                if (!isNameValid || !isEmailValid || !isPasswordValid || !areRolesValid) {
                    e.preventDefault();
                    alert('Por favor, corrija los errores antes de enviar el formulario.');
                }
            });
        });
    </script>
</x-app-layout>
