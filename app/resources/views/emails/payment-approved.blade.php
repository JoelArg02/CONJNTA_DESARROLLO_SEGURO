<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Aprobado</title>
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
            background-color: #10b981;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f0fdf4;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .payment-details {
            background-color: white;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #10b981;
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
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: #10b981;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 6px;
            font-size: 14px;
            color: #6b7280;
        }
        .cta-button {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .success-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="success-icon">✅</div>
        <h1>¡Pago Aprobado!</h1>
        <p>Su pago ha sido procesado exitosamente</p>
    </div>
    
    <div class="content">
        <h2>Estimado/a {{ $customer->name }},</h2>
        
        <p>Nos complace informarle que su pago ha sido <strong>aprobado</strong> y procesado correctamente.</p>
        
        <div class="payment-details">
            <h3>Detalles del Pago</h3>
            
            <div class="detail-row">
                <span class="detail-label">Factura:</span>
                <span class="detail-value">#{{ $invoice->invoice_number }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Monto Pagado:</span>
                <span class="detail-value">${{ number_format($payment->amount, 2) }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Método de Pago:</span>
                <span class="detail-value">{{ ucfirst($payment->method) }}</span>
            </div>
            
            @if($payment->transaction_reference)
            <div class="detail-row">
                <span class="detail-label">Referencia:</span>
                <span class="detail-value">{{ $payment->transaction_reference }}</span>
            </div>
            @endif
            
            <div class="detail-row">
                <span class="detail-label">Fecha de Pago:</span>
                <span class="detail-value">{{ $payment->paid_at->format('d/m/Y H:i') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Estado del Pago:</span>
                <span class="detail-value"><span class="status-badge">Aprobado</span></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Estado de la Factura:</span>
                <span class="detail-value"><span class="status-badge">{{ ucfirst($invoice->status) }}</span></span>
            </div>
        </div>
        
        <div style="text-align: center;">
            <p><strong>Su factura ya se encuentra marcada como PAGADA en nuestro sistema.</strong></p>
            <p>Adjunto encontrará una copia de la factura en formato PDF.</p>
        </div>
        
        @if($payment->notes)
        <div style="background-color: #fef3c7; padding: 15px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #f59e0b;">
            <h4 style="margin: 0 0 10px 0; color: #92400e;">Notas del Pago:</h4>
            <p style="margin: 0; color: #92400e;">{{ $payment->notes }}</p>
        </div>
        @endif
        
        <div class="footer">
            <p>Si tiene alguna pregunta sobre este pago, no dude en contactarnos.</p>
            <p><strong>¡Gracias por su confianza!</strong></p>
            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">
            <p style="font-size: 12px;">
                Este es un correo automático generado por nuestro sistema de facturación.<br>
                Por favor, conserve este comprobante para sus registros.
            </p>
        </div>
    </div>
</body>
</html>
