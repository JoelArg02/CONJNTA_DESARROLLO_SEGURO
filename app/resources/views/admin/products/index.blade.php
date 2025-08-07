<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Productos
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Gestiona el inventario de productos de tu empresa
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('admin.products.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-plus mr-2"></i>
                        Nuevo Producto
                    </a>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                @if($products->count() > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($products as $product)
                            <li class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <div class="h-12 w-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                                                <i class="fas fa-box text-indigo-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $product->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 flex items-center space-x-4">
                                                <span>Precio: <span class="font-medium text-green-600">${{ number_format($product->price, 2) }}</span></span>
                                                <span>Stock: <span class="font-medium {{ $product->stock < 10 ? 'text-red-600' : 'text-green-600' }}">{{ $product->stock }}</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($product->stock < 10)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Stock Bajo
                                            </span>
                                        @endif
                                        <div class="flex space-x-1">
                                            <button onclick="editProduct({{ $product->id }})" 
                                                    class="text-indigo-600 hover:text-indigo-900 p-1">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="deleteProduct({{ $product->id }})" 
                                                    class="text-red-600 hover:text-red-900 p-1">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-3 bg-gray-50">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-6xl mb-4">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay productos</h3>
                        <p class="text-gray-500 mb-6">Comienza agregando tu primer producto al inventario.</p>
                        <a href="{{ route('admin.products.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-plus mr-2"></i>
                            Crear Primer Producto
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal para editar producto -->
    <div id="edit-product-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Editar Producto</h3>
                </div>
                <form id="edit-product-form">
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label for="edit-name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" id="edit-name" name="name" required minlength="2" maxlength="255"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-red-600 text-sm mt-1 hidden" id="edit-name-error"></p>
                        </div>
                        <div>
                            <label for="edit-price" class="block text-sm font-medium text-gray-700">Precio *</label>
                            <input type="number" id="edit-price" name="price" step="0.01" min="0.01" max="99999.99" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-red-600 text-sm mt-1 hidden" id="edit-price-error"></p>
                        </div>
                        <div>
                            <label for="edit-stock" class="block text-sm font-medium text-gray-700">Stock *</label>
                            <input type="number" id="edit-stock" name="stock" min="0" max="999999" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-red-600 text-sm mt-1 hidden" id="edit-stock-error"></p>
                        </div>
                        <div>
                            <label for="edit-reason" class="block text-sm font-medium text-gray-700">Razón del cambio *</label>
                            <input type="text" id="edit-reason" name="reason" required minlength="3" maxlength="255"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-red-600 text-sm mt-1 hidden" id="edit-reason-error"></p>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" 
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para eliminar producto -->
    <div id="delete-product-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Eliminar Producto</h3>
                </div>
                <form id="delete-product-form">
                    <div class="px-6 py-4 space-y-4">
                        <p class="text-sm text-gray-600">¿Estás seguro de que deseas eliminar este producto?</p>
                        <div>
                            <label for="delete-reason" class="block text-sm font-medium text-gray-700">Razón de eliminación *</label>
                            <input type="text" id="delete-reason" name="reason" required minlength="3" maxlength="255"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-red-600 text-sm mt-1 hidden" id="delete-reason-error"></p>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                        <button type="button" onclick="closeDeleteModal()" 
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Eliminar
                        </button>
                    </div>
                </form>
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

    <script>
        let currentProductId = null;

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

        function validatePrice(value) {
            if (!value) return 'El precio es requerido';
            const num = parseFloat(value);
            if (num <= 0) return 'El precio debe ser mayor a 0';
            if (num > 99999.99) return 'El precio no puede ser mayor a 99,999.99';
            return true;
        }

        function validateStock(value) {
            if (!value && value !== '0') return 'El stock es requerido';
            const num = parseInt(value);
            if (num < 0) return 'El stock no puede ser negativo';
            if (num > 999999) return 'El stock no puede ser mayor a 999,999';
            return true;
        }

        function validateReason(value) {
            if (!value.trim()) return 'La razón es requerida';
            if (value.trim().length < 3) return 'La razón debe tener al menos 3 caracteres';
            if (value.length > 255) return 'La razón no puede tener más de 255 caracteres';
            return true;
        }

        function editProduct(id) {
            currentProductId = id;
            
            // Obtener datos del producto
            fetch(`/admin/products/${id}`)
                .then(response => response.json())
                .then(product => {
                    document.getElementById('edit-name').value = product.name;
                    document.getElementById('edit-price').value = product.price;
                    document.getElementById('edit-stock').value = product.stock;
                    document.getElementById('edit-reason').value = '';
                    
                    // Clear any previous errors
                    const errorElements = ['edit-name-error', 'edit-price-error', 'edit-stock-error', 'edit-reason-error'];
                    errorElements.forEach(id => {
                        document.getElementById(id).classList.add('hidden');
                        const input = document.getElementById(id.replace('-error', ''));
                        input.classList.remove('border-red-500');
                        input.classList.add('border-gray-300');
                    });
                    
                    document.getElementById('edit-product-modal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cargar los datos del producto');
                });
        }

        function deleteProduct(id) {
            currentProductId = id;
            document.getElementById('delete-reason').value = '';
            
            // Clear any previous errors
            const errorEl = document.getElementById('delete-reason-error');
            const input = document.getElementById('delete-reason');
            errorEl.classList.add('hidden');
            input.classList.remove('border-red-500');
            input.classList.add('border-gray-300');
            
            document.getElementById('delete-product-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-product-modal').classList.add('hidden');
            currentProductId = null;
        }

        function closeDeleteModal() {
            document.getElementById('delete-product-modal').classList.add('hidden');
            currentProductId = null;
        }

        function showSuccessModal(message) {
            document.getElementById('successModalText').textContent = message;
            document.getElementById('successModal').style.display = 'flex';
        }

        function closeSuccessModal() {
            document.getElementById('successModal').style.display = 'none';
        }

        // Add real-time validation when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Edit form validation
            const editNameInput = document.getElementById('edit-name');
            const editPriceInput = document.getElementById('edit-price');
            const editStockInput = document.getElementById('edit-stock');
            const editReasonInput = document.getElementById('edit-reason');

            editNameInput.addEventListener('blur', () => {
                validateField(editNameInput, document.getElementById('edit-name-error'), validateName);
            });

            editPriceInput.addEventListener('blur', () => {
                validateField(editPriceInput, document.getElementById('edit-price-error'), validatePrice);
            });

            editStockInput.addEventListener('blur', () => {
                validateField(editStockInput, document.getElementById('edit-stock-error'), validateStock);
            });

            editReasonInput.addEventListener('blur', () => {
                validateField(editReasonInput, document.getElementById('edit-reason-error'), validateReason);
            });

            // Delete form validation
            const deleteReasonInput = document.getElementById('delete-reason');
            deleteReasonInput.addEventListener('blur', () => {
                validateField(deleteReasonInput, document.getElementById('delete-reason-error'), validateReason);
            });
        });

        // Manejar formulario de edición
        document.getElementById('edit-product-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate all fields
            const nameValid = validateField(document.getElementById('edit-name'), document.getElementById('edit-name-error'), validateName);
            const priceValid = validateField(document.getElementById('edit-price'), document.getElementById('edit-price-error'), validatePrice);
            const stockValid = validateField(document.getElementById('edit-stock'), document.getElementById('edit-stock-error'), validateStock);
            const reasonValid = validateField(document.getElementById('edit-reason'), document.getElementById('edit-reason-error'), validateReason);

            if (!nameValid || !priceValid || !stockValid || !reasonValid) {
                alert('Por favor, corrija los errores antes de enviar el formulario.');
                return;
            }
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            fetch(`/admin/products/${currentProductId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.message) {
                    closeEditModal();
                    showSuccessModal(result.message);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else if (result.error) {
                    alert(result.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar el producto');
            });
        });

        // Manejar formulario de eliminación
        document.getElementById('delete-product-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate reason field
            const reasonValid = validateField(document.getElementById('delete-reason'), document.getElementById('delete-reason-error'), validateReason);
            
            if (!reasonValid) {
                alert('Por favor, proporcione una razón válida para la eliminación.');
                return;
            }
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            fetch(`/admin/products/${currentProductId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.message) {
                    closeDeleteModal();
                    showSuccessModal(result.message);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else if (result.error) {
                    alert(result.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar el producto');
            });
        });

        // Cerrar modales al hacer clic fuera
        document.getElementById('edit-product-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        document.getElementById('delete-product-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>
