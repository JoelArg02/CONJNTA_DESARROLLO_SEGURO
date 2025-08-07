<x-app-layout>

<div class="container">
    <h2 class="mb-4">Pagos pendientes</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($payments->isEmpty())
        <p>No hay pagos pendientes por validar.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Cliente</th>
                    <th>Método</th>
                    <th>Monto</th>
                    <th>Referencia</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->invoice->invoice_number }}</td>
                        <td>{{ $payment->invoice->customer->name }}</td>
                        <td>{{ ucfirst($payment->method) }}</td>
                        <td>$ {{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->transaction_reference ?? '-' }}</td>
                        <td>{{ $payment->paid_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <form action="{{ route('payments.approve', $payment->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button class="btn btn-success btn-sm" onclick="return confirm('¿Aprobar este pago?')">Aprobar</button>
                            </form>

                            <form action="{{ route('payments.reject', $payment->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Rechazar este pago?')">Rechazar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</x-app-layout>
