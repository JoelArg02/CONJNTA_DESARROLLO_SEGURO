<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura {{ $invoice->invoice_number }}</title>
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
        
        .invoice-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .invoice-info .left, .invoice-info .right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .invoice-info .right {
            text-align: right;
        }
        
        .invoice-info h3 {
            margin: 0 0 10px 0;
            color: #374151;
            font-size: 14px;
        }
        
        .invoice-info p {
            margin: 3px 0;
            font-size: 12px;
        }
        
        .invoice-number {
            background-color: #4f46e5;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
        }
        
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            margin-top: 5px;
        }
        
        .status.pending {
            background-color: #fbbf24;
            color: #92400e;
        }
        
        .status.paid {
            background-color: #10b981;
            color: white;
        }
        
        .status.overdue {
            background-color: #ef4444;
            color: white;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .items-table th {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        .items-table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            font-size: 11px;
        }
        
        .items-table .text-right {
            text-align: right;
        }
        
        .items-table .text-center {
            text-align: center;
        }
        
        .totals {
            float: right;
            width: 300px;
            margin-top: 20px;
        }
        
        .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .totals td {
            padding: 5px 10px;
            border-top: 1px solid #e5e7eb;
        }
        
        .totals .total-row {
            font-weight: bold;
            background-color: #f9fafb;
            border-top: 2px solid #4f46e5;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }
        
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        
        @page {
            margin: 1cm;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURA</h1>
        <p>Sistema de Gestión de Productos</p>
        <p>Factura electrónica</p>
    </div>

    <div class="invoice-info">
        <div class="left">
            <h3>Facturar a:</h3>
            <p><strong>{{ $invoice->customer->name }}</strong></p>
            <p>{{ $invoice->customer->email }}</p>
            @if($invoice->customer->phone)
                <p>Tel: {{ $invoice->customer->phone }}</p>
            @endif
            @if($invoice->customer->address)
                <p>{{ $invoice->customer->address }}</p>
            @endif
        </div>
        
        <div class="right">
            <div class="invoice-number">{{ $invoice->invoice_number }}</div>
            <div class="status {{ $invoice->status }}">{{ ucfirst($invoice->status) }}</div>
            <p><strong>Fecha de emisión:</strong> {{ $invoice->issued_at->format('d/m/Y') }}</p>
            @if($invoice->due_at)
                <p><strong>Fecha de vencimiento:</strong> {{ $invoice->due_at->format('d/m/Y') }}</p>
            @endif
            <p><strong>Creado por:</strong> {{ $invoice->creator->name ?? 'N/A' }}</p>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th class="text-center">Cantidad</th>
                <th class="text-right">Precio Unitario</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->description }}</strong>
                        @if($item->product)
                            <br><small>Código: {{ $item->product->code ?? 'N/A' }}</small>
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($item->quantity, 0) }}</td>
                    <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="clearfix">
        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right">${{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                @if($invoice->tax_amount > 0)
                    <tr>
                        <td>Impuestos:</td>
                        <td class="text-right">${{ number_format($invoice->tax_amount, 2) }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td><strong>Total:</strong></td>
                    <td class="text-right"><strong>${{ number_format($invoice->total, 2) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>Esta es una factura generada electrónicamente.</p>
        <p>Generada el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
