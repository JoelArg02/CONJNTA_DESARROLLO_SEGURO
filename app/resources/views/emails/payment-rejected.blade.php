<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Rechazado</title>
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
            background-color: #ef4444;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #fef2f2;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .payment-details {
            background-color: white;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #ef4444;
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
            background-color: #ef4444;
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
        .warning-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .next-steps {
            background-color: #fef3c7;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #f59e0b;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="warning-icon">❌</div>
        <h1>Pago Rechazado</h1>
        <p>Su pago no pudo ser procesado</p>
    </div>
    
    <div class="content">
        <h2>Estimado/a {{ $customer->name }},</h2>
        
        <p>Lamentablemente, su pago <strong>no ha sido aprobado</strong> por nuestro equipo de validación.</p>
        
        <div class="payment-details">
            <h3>Detalles del Pago Rechazado</h3>
            
            <div class="detail-row">
                <span class="detail-label">Factura:</span>
                <span class="detail-value">#{{ $invoice->invoice_number }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Monto:</span>
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
                <span class="detail-value"><span class="status-badge">Rechazado</span></span>
            </div>
        </div>
        
        @if($payment->notes)
        <div style="background-color: #fee2e2; padding: 15px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #ef4444;">
            <h4 style="margin: 0 0 10px 0; color: #dc2626;">Motivo del Rechazo:</h4>
            <p style="margin: 0; color: #dc2626;">{{ $payment->notes }}</p>
        </div>
        @endif
        
        <div class="next-steps">
            <h4 style="margin: 0 0 15px 0; color: #92400e;">¿Qué hacer ahora?</h4>
            <ul style="margin: 0; padding-left: 20px; color: #92400e;">
                <li>Verifique que los datos de la transacción sean correctos</li>
                <li>Asegúrese de que el monto coincida exactamente con el total de la factura</li>
                <li>Revise que la referencia de transacción sea válida</li>
                <li>Si todo está correcto, intente realizar el pago nuevamente</li>
                <li>Para más información, contáctenos directamente</li>
            </ul>
        </div>
        
        <div style="text-align: center;">
            <p><strong>Su factura permanece como PENDIENTE de pago.</strong></p>
            <p>Puede intentar realizar el pago nuevamente desde su panel de cliente.</p>
        </div>
        
        <div class="footer">
            <p>Si tiene alguna pregunta sobre este rechazo o necesita asistencia, no dude en contactarnos.</p>
            <p><strong>Estamos aquí para ayudarle</strong></p>
            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">
            <p style="font-size: 12px;">
                Este es un correo automático generado por nuestro sistema de pagos.<br>
                Por favor, revise los datos e intente nuevamente o contacte soporte.
            </p>
        </div>
    </div>
</body>
</html>
