<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear producto
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('admin.products.store') }}"
            class="bg-white p-8 rounded-2xl shadow-md space-y-6 max-w-xl mx-auto" id="product-form">
            @csrf

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Nuevo Producto</h2>

            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700">Nombre *</label>
                <input type="text" name="name" id="name"
                    class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none transition"
                    value="{{ old('name') }}" required minlength="2" maxlength="255">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-red-600 text-sm mt-1 hidden" id="name-error"></p>
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-semibold text-gray-700">Stock *</label>
                <input type="number" name="stock" id="stock"
                    class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none transition"
                    value="{{ old('stock') }}" required min="0" max="999999">
                @error('stock')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-red-600 text-sm mt-1 hidden" id="stock-error"></p>
            </div>

            <!-- Precio -->
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700">Precio *</label>
                <input type="number" name="price" id="price" step="0.01"
                    class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none transition"
                    value="{{ old('price') }}" required min="0.01" max="99999.99">
                @error('price')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-red-600 text-sm mt-1 hidden" id="price-error"></p>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.products.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('product-form');
            const nameInput = document.getElementById('name');
            const stockInput = document.getElementById('stock');
            const priceInput = document.getElementById('price');

            // Frontend validation functions
            function validateName() {
                const value = nameInput.value.trim();
                const errorEl = document.getElementById('name-error');

                if (!value) {
                    showError(nameInput, errorEl, 'El nombre es requerido');
                    return false;
                } else if (value.length < 2) {
                    showError(nameInput, errorEl, 'El nombre debe tener al menos 2 caracteres');
                    return false;
                } else if (value.length > 255) {
                    showError(nameInput, errorEl, 'El nombre no puede tener más de 255 caracteres');
                    return false;
                }

                hideError(nameInput, errorEl);
                return true;
            }

            function validateStock() {
                const value = stockInput.value;
                const errorEl = document.getElementById('stock-error');

                if (!value) {
                    showError(stockInput, errorEl, 'El stock es requerido');
                    return false;
                } else if (parseInt(value) < 0) {
                    showError(stockInput, errorEl, 'El stock no puede ser negativo');
                    return false;
                } else if (parseInt(value) > 999999) {
                    showError(stockInput, errorEl, 'El stock no puede ser mayor a 999,999');
                    return false;
                }

                hideError(stockInput, errorEl);
                return true;
            }

            function validatePrice() {
                const value = priceInput.value;
                const errorEl = document.getElementById('price-error');

                if (!value) {
                    showError(priceInput, errorEl, 'El precio es requerido');
                    return false;
                } else if (parseFloat(value) <= 0) {
                    showError(priceInput, errorEl, 'El precio debe ser mayor a 0');
                    return false;
                } else if (parseFloat(value) > 99999.99) {
                    showError(priceInput, errorEl, 'El precio no puede ser mayor a 99,999.99');
                    return false;
                }

                hideError(priceInput, errorEl);
                return true;
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

            // Real-time validation
            nameInput.addEventListener('blur', validateName);
            nameInput.addEventListener('input', function() {
                if (this.value.trim().length >= 2) validateName();
            });

            stockInput.addEventListener('blur', validateStock);
            stockInput.addEventListener('input', function() {
                if (this.value) validateStock();
            });

            priceInput.addEventListener('blur', validatePrice);
            priceInput.addEventListener('input', function() {
                if (this.value) validatePrice();
            });

            // Form submission validation
            form.addEventListener('submit', function(e) {
                const isNameValid = validateName();
                const isStockValid = validateStock();
                const isPriceValid = validatePrice();

                if (!isNameValid || !isStockValid || !isPriceValid) {
                    e.preventDefault();
                    alert('Por favor, corrija los errores antes de enviar el formulario.');
                }
            });
        });
    </script>
</x-app-layout>
