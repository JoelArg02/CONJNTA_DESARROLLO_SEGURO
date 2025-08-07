<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Facturas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #4f46e5;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .filters {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .filters h3 {
            margin: 0 0 10px 0;
            color: #374151;
        }
        
        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
        
        .stats {
            margin-bottom: 30px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
        
        .stat-card {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            border-left: 4px solid #4f46e5;
        }
        
        .stat-card h4 {
            margin: 0 0 5px 0;
            color: #6b7280;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        .stat-card p {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th,
        .table td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }
        
        .table th {
            background-color: #4f46e5;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }
        
        .table td {
            font-size: 10px;
        }
        
        .table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .status {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status.paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status.pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status.overdue {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .amount {
            text-align: right;
            font-weight: bold;
        }
        
        .total-row {
            background-color: #e5e7eb !important;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>AllpaSoft - Reporte de Facturas</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    @if($request->start_date || $request->end_date || $request->status || $request->customer_id)
    <div class="filters">
        <h3>Filtros Aplicados:</h3>
        @if($request->start_date)
            <span class="filter-item"><strong>Desde:</strong> {{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }}</span>
        @endif
        @if($request->end_date)
            <span class="filter-item"><strong>Hasta:</strong> {{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}</span>
        @endif
        @if($request->status)
            <span class="filter-item"><strong>Estado:</strong> 
                @switch($request->status)
                    @case('paid') Pagadas @break
                    @case('pending') Pendientes @break
                    @case('overdue') Vencidas @break
                @endswitch
            </span>
        @endif
        @if($request->customer_id)
            <span class="filter-item"><strong>Cliente:</strong> {{ $invoices->first()->customer->name ?? 'N/A' }}</span>
        @endif
    </div>
    @endif

    <div class="stats">
        <h3>Resumen Ejecutivo</h3>
        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Facturas</h4>
                <p>{{ $stats['total_invoices'] }}</p>
            </div>
            <div class="stat-card">
                <h4>Monto Total</h4>
                <p>$ {{ number_format($stats['total_amount'], 2) }}</p>
            </div>
            <div class="stat-card">
                <h4>Pagadas</h4>
                <p>$ {{ number_format($stats['paid_amount'], 2) }}</p>
            </div>
            <div class="stat-card">
                <h4>Pendientes</h4>
                <p>$ {{ number_format($stats['pending_amount'], 2) }}</p>
            </div>
        </div>
    </div>

    <h3>Detalle de Facturas</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nº Factura</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Subtotal</th>
                <th>IGV</th>
                <th>Total</th>
                <th>Creado por</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $invoice)
            <tr>
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ $invoice->customer->name }}</td>
                <td>{{ $invoice->issued_at->format('d/m/Y') }}</td>
                <td>
                    <span class="status {{ $invoice->status }}">
                        @switch($invoice->status)
                            @case('paid') Pagada @break
                            @case('pending') Pendiente @break
                            @case('overdue') Vencida @break
                            @default {{ ucfirst($invoice->status) }}
                        @endswitch
                    </span>
                </td>
                <td class="amount">$ {{ number_format($invoice->subtotal, 2) }}</td>
                <td class="amount">$ {{ number_format($invoice->tax_amount, 2) }}</td>
                <td class="amount">$ {{ number_format($invoice->total, 2) }}</td>
                <td>{{ $invoice->creator->name ?? 'Sistema' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; color: #6b7280; font-style: italic;">
                    No se encontraron facturas con los filtros aplicados
                </td>
            </tr>
            @endforelse
            
            @if($invoices->count() > 0)
            <tr class="total-row">
                <td colspan="4"><strong>TOTALES</strong></td>
                <td class="amount"><strong>$ {{ number_format($invoices->sum('subtotal'), 2) }}</strong></td>
                <td class="amount"><strong>$ {{ number_format($invoices->sum('tax_amount'), 2) }}</strong></td>
                <td class="amount"><strong>$ {{ number_format($invoices->sum('total'), 2) }}</strong></td>
                <td></td>
            </tr>
            @endif
        </tbody>
    </table>

    @if($invoices->count() > 10)
    <div class="page-break"></div>
    
    <h3>Detalle por Items</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Factura</th>
                <th>Producto/Servicio</th>
                <th>Cantidad</th>
                <th>Precio Unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $item->description }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td class="amount">$ {{ number_format($item->unit_price, 2) }}</td>
                    <td class="amount">$ {{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer">
        <p>Reporte generado automáticamente por AllpaSoft</p>
        <p>Página generada el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
