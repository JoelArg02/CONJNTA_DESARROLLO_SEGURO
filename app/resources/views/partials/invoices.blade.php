{{-- <div class="container py-4">
    <h1 class="text-2xl font-bold mb-4">Crear Nueva Factura</h1>

    <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
        @csrf
        <div class="card mb-4">
            <div class="card-header">Información Básica</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="customer_id" class="form-label">Cliente</label>
                    <select name="customer_id" id="customer_id" class="form-control" required>
                        <option value="">Seleccione un cliente</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="issued_at" class="form-label">Fecha de Emisión</label>
                    <input type="date" name="issued_at" id="issued_at" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Productos</div>
            <div class="card-body">
                <table class="table" id="products-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-items">
                        <tr class="item-row">
                            <td>
                                <select name="items[0][product_id]" class="form-control product-select" required>
                                    <option value="">Seleccione un producto</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="items[0][quantity]" class="form-control quantity" min="1" value="1" required>
                            </td>
                            <td>
                                <input type="number" name="items[0][unit_price]" class="form-control unit-price" step="0.01" readonly>
                            </td>
                            <td>
                                <input type="number" name="items[0][subtotal]" class="form-control subtotal" step="0.01" readonly>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-item">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" id="add-item" class="btn btn-primary">Agregar Producto</button>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Total</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <table class="table">
                            <tr>
                                <th>Total:</th>
                                <td>
                                    <input type="number" name="total" id="total" class="form-control" step="0.01" readonly>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end">
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar Factura</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowIndex = 0;

        // Calculate item subtotal
        function calculateSubtotal(row) {
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
            const subtotal = quantity * unitPrice;
            row.querySelector('.subtotal').value = subtotal.toFixed(2);
            calculateTotal();
        }

        // Calculate invoice total
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(function(el) {
                total += parseFloat(el.value) || 0;
            });
            document.getElementById('total').value = total.toFixed(2);
        }

        // Handle product selection
        function handleProductSelect(row) {
            const select = row.querySelector('.product-select');
            const option = select.options[select.selectedIndex];
            if (option && option.dataset.price) {
                row.querySelector('.unit-price').value = option.dataset.price;
                calculateSubtotal(row);
            }
        }

        // Initial calculations
        document.querySelectorAll('.item-row').forEach(function(row) {
            handleProductSelect(row);
            
            row.querySelector('.product-select').addEventListener('change', function() {
                handleProductSelect(row);
            });
            
            row.querySelector('.quantity').addEventListener('input', function() {
                calculateSubtotal(row);
            });
        });

        // Add new item row
        document.getElementById('add-item').addEventListener('click', function() {
            rowIndex++;
            const newRow = document.createElement('tr');
            newRow.className = 'item-row';
            newRow.innerHTML = `
                <td>
                    <select name="items[${rowIndex}][product_id]" class="form-control product-select" required>
                        <option value="">Seleccione un producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="items[${rowIndex}][quantity]" class="form-control quantity" min="1" value="1" required>
                </td>
                <td>
                    <input type="number" name="items[${rowIndex}][unit_price]" class="form-control unit-price" step="0.01" readonly>
                </td>
                <td>
                    <input type="number" name="items[${rowIndex}][subtotal]" class="form-control subtotal" step="0.01" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-item">Eliminar</button>
                </td>
            `;
            document.getElementById('invoice-items').appendChild(newRow);
            
            // Add event listeners to new row
            const row = document.getElementById('invoice-items').lastElementChild;
            handleProductSelect(row);
            
            row.querySelector('.product-select').addEventListener('change', function() {
                handleProductSelect(row);
            });
            
            row.querySelector('.quantity').addEventListener('input', function() {
                calculateSubtotal(row);
            });
            
            row.querySelector('.remove-item').addEventListener('click', function() {
                row.remove();
                calculateTotal();
            });
        });

        // Remove item row
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-item')) {
                if (document.querySelectorAll('.item-row').length > 1) {
                    e.target.closest('tr').remove();
                    calculateTotal();
                } else {
                    alert('La factura debe tener al menos un producto');
                }
            }
        });
    });
</script>
@endpush --}}
