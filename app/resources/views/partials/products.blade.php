<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card p-6">

    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Inventario de Productos</h3>
    </div>
    <button onclick="openModal('modal-create-product')"
        class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
        Crear Producto
    </button>
    <button onclick="openDisabledProductsModal()"
        class="px-4 py-2 bg-yellow-600 text-white text-sm rounded-md hover:bg-yellow-700 ml-2">
        Ver desactivados
    </button>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody id="products-tbody" class="divide-y divide-gray-200 text-sm"></tbody>
        </table>
    </div>
</div>
<!-- Modal: Productos Desactivados -->
<div id="modal-disabled-products" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded-md w-full max-w-3xl">
            <h2 class="text-lg font-semibold mb-4">Productos Desactivados</h2>
            <table class="min-w-full mb-4">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Producto</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Motivo</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Acción</th>
                    </tr>
                </thead>
                <tbody id="disabled-products-tbody" class="divide-y divide-gray-200 text-sm">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-center text-gray-400">Cargando...</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-end">
                <button onclick="closeModal('modal-disabled-products')" class="px-4 py-2 bg-gray-300 rounded-md">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Crear producto -->
<div id="modal-create-product" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded-md w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Crear Producto</h2>
            <form id="form-create-product">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Precio</label>
                    <input type="number" step="0.01" name="price"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modal-create-product')"
                        class="px-4 py-2 bg-gray-300 rounded-md">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Editar producto -->
<div id="modal-edit-product" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded-md w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Editar Producto</h2>
            <form id="form-edit-product">
                <input type="hidden" name="id">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Precio</label>
                    <input type="number" step="0.01" name="price"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modal-edit-product')"
                        class="px-4 py-2 bg-gray-300 rounded-md">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Desactivar producto -->
<div id="modal-disable-product" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded-md w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Desactivar Producto</h2>
            <form id="form-disable-product">
                <input type="hidden" name="id">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Motivo</label>
                    <textarea name="reason" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modal-disable-product')"
                        class="px-4 py-2 bg-gray-300 rounded-md">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Desactivar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.addEventListener('DOMContentLoaded', async () => {
        const res = await fetch('/admin/products', {
            headers: {
                Accept: 'application/json'
            }
        });

        const products = await res.json();
        const tbody = document.getElementById('products-tbody');

        products.forEach(product => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td class="px-4 py-3">${product.name}</td>
                <td class="px-4 py-3">${product.stock}</td>
                <td class="px-4 py-3">$${Number(product.price).toFixed(2)}</td>
                <td class="px-4 py-3 space-x-2">
                    <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700" onclick='editProductModal(${product.id}, "${product.name}", ${product.stock}, ${product.price})'>Editar</button>
                    <button class="px-3 py-1 text-sm bg-red-600 text-white rounded-md hover:bg-red-700" onclick='openDisableModal(${product.id})'>Desactivar</button>
                </td>
            `;

            tbody.appendChild(row);
        });
    });

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function editProductModal(id, name, stock, price) {
        const form = document.getElementById('form-edit-product');
        form.elements['id'].value = id;
        form.elements['name'].value = name;
        form.elements['stock'].value = stock;
        form.elements['price'].value = price;

        openModal('modal-edit-product');
    }

    function openDisableModal(productId) {
        const form = document.getElementById('form-disable-product');
        form.id.value = productId;
        openModal('modal-disable-product');
    }


    document.getElementById('form-create-product').addEventListener('submit', async (e) => {
        e.preventDefault();

        const form = e.target;
        const data = {
            name: form.name.value,
            stock: form.stock.value,
            price: form.price.value
        };

        try {
            const res = await fetch('/admin/products', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (!res.ok) throw new Error('Error al crear producto');

            location.reload();
        } catch (error) {
            alert('Error al crear producto');
            console.error(error);
        }
    });
    document.getElementById('form-edit-product').addEventListener('submit', async (e) => {
        e.preventDefault();

        const form = e.target;
        const id = form.id.value;
        const data = {
            name: form.name.value,
            stock: form.stock.value,
            price: form.price.value,
            reason: 'Actualización manual'
        };

        try {
            const res = await fetch(`/admin/products/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (!res.ok) throw new Error('Error al editar producto');

            location.reload();
        } catch (error) {
            alert('Error al editar producto');
            console.error(error);
        }
    });

    document.getElementById('form-disable-product').addEventListener('submit', async (e) => {
        e.preventDefault();

        const form = e.target;
        const id = form.id.value;
        const data = {
            reason: form.reason.value
        };

        try {
            const res = await fetch(`/admin/products/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (!res.ok) throw new Error('Error al desactivar producto');

            location.reload();
        } catch (error) {
            alert('Error al desactivar producto');
            console.error(error);
        }
    });
    async function openDisabledProductsModal() {
        openModal('modal-disabled-products');
        const tbody = document.getElementById('disabled-products-tbody');
        tbody.innerHTML = `<tr><td colspan="3" class="px-4 py-3 text-center text-gray-400">Cargando...</td></tr>`;

        try {
            const res = await fetch('/admin/products/disabled', {
                headers: {
                    Accept: 'application/json'
                }
            });

            const products = await res.json();
            tbody.innerHTML = '';

            if (products.length === 0) {
                tbody.innerHTML =
                    `<tr><td colspan="3" class="px-4 py-3 text-center text-gray-500">No hay productos desactivados.</td></tr>`;
                return;
            }

            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td class="px-4 py-3">${product.name}</td>
                <td class="px-4 py-3 text-gray-500">${product.deactivation_reason ?? '-'}</td>
                <td class="px-4 py-3">
                    <button onclick="reactivateProduct(${product.id})"
                        class="px-3 py-1 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                        Reactivar
                    </button>
                </td>
            `;
                tbody.appendChild(row);
            });
        } catch (error) {
            tbody.innerHTML =
                `<tr><td colspan="3" class="px-4 py-3 text-center text-red-600">Error al cargar productos.</td></tr>`;
            console.error(error);
        }
    }
</script>
