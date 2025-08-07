<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4f46e5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f8fafc;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .invoice-details {
            background-color: white;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #4f46e5;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .detail-label {
            font-weight: bold;
            color: #6b7280;
        }
        .detail-value {
            color: #1f2937;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status.pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status.paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status.overdue {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .amount {
            font-size: 18px;
            font-weight: bold;
            color: #059669;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">AllpaSoft</div>
        <h2>Nueva Factura Generada</h2>
    </div>
    
    <div class="content">
        <p>Estimado/a <strong>{{ $customer->name }}</strong>,</p>
        
        <p>Le informamos que se ha generado una nueva factura para su cuenta. Adjunto encontrará el documento en formato PDF con todos los detalles.</p>
        
        <div class="invoice-details">
            <h3 style="margin-top: 0; color: #4f46e5;">Detalles de la Factura</h3>
            
            <div class="detail-row">
                <span class="detail-label">Número de Factura:</span>
                <span class="detail-value"><strong>{{ $invoice->invoice_number }}</strong></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Fecha de Emisión:</span>
                <span class="detail-value">{{ $invoice->issued_at->format('d/m/Y') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Estado:</span>
                <span class="detail-value">
                    @php
                        $statusLabels = [
                            'pending' => 'Pendiente',
                            'paid' => 'Pagada', 
                            'overdue' => 'Vencida'
                        ];
                    @endphp
                    <span class="status {{ $invoice->status }}">
                        {{ $statusLabels[$invoice->status] ?? ucfirst($invoice->status) }}
                    </span>
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Subtotal:</span>
                <span class="detail-value">${{ number_format($invoice->subtotal, 2) }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">IGV (18%):</span>
                <span class="detail-value">${{ number_format($invoice->tax_amount, 2) }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Total:</span>
                <span class="detail-value amount">${{ number_format($invoice->total, 2) }}</span>
            </div>
        </div>
        
        <p><strong>Productos/Servicios incluidos:</strong></p>
        <ul style="background-color: white; padding: 20px; border-radius: 6px; margin: 10px 0;">
            @foreach($invoice->items as $item)
                <li style="margin-bottom: 8px;">
                    <strong>{{ $item->description ?? $item->product->name ?? 'Producto' }}</strong> 
                    - Cantidad: {{ $item->quantity }} 
                    - Precio: ${{ number_format($item->unit_price, 2) }}
                    - Subtotal: ${{ number_format($item->subtotal, 2) }}
                </li>
            @endforeach
        </ul>
        
        @if($invoice->status === 'pending')
            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; margin: 20px 0; border-radius: 0 6px 6px 0;">
                <strong>Información de pago:</strong> Esta factura está pendiente de pago. Por favor, procese el pago según las condiciones acordadas.
            </div>
        @elseif($invoice->status === 'paid')
            <div style="background-color: #d1fae5; border-left: 4px solid #10b981; padding: 15px; margin: 20px 0; border-radius: 0 6px 6px 0;">
                <strong>¡Gracias!</strong> Esta factura ha sido marcada como pagada.
            </div>
        @endif
        
        <p>Si tiene alguna pregunta sobre esta factura, no dude en contactarnos.</p>
        
        <p>Atentamente,<br>
        <strong>El equipo de AllpaSoft</strong></p>
    </div>
    
    <div class="footer">
        <p>Este es un correo automático, por favor no responda a esta dirección.</p>
        <p>© {{ date('Y') }} AllpaSoft. Todos los derechos reservados.</p>
    </div>
</body>
</html>
