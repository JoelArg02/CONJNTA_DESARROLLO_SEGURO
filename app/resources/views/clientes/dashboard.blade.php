<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-lg w-full bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Bienvenido</h1>
            <p class="mt-2 text-gray-600">Panel de cliente</p>
        </div>
        <div class="mb-4 text-center">
            <span class="inline-block px-4 py-2 rounded bg-blue-100 text-blue-800 font-semibold">
                Tipo de acceso: Cliente
                
            </span>
        </div>
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Tus datos</h2>
        </div>
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Tus tokens de acceso</h2>
            <div>
                @forelse ($tokens as $token)
                    <div class="mb-2 p-3 bg-gray-50 rounded border">
                        <div class="font-semibold">{{ $token->name }}</div>
                        <div class="text-sm text-gray-600">Creado: {{ $token->created_at->format('d/m/Y H:i') }}</div>
                        <div class="mt-1 text-xs break-all">
                            <span class="font-mono bg-gray-200 px-2 py-1 rounded">Token: {{ $token->plain_text_token ?? 'No disponible' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500">No tienes tokens registrados</div>
                @endforelse
            </div>
        </div>
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Tus facturas</h2>
            <div>
                @forelse ($invoices as $invoice)
                    <div class="mb-2 p-3 bg-gray-50 rounded border">
                        <div class="font-semibold">Factura #{{ $invoice->id }}</div>
                        <div class="text-sm text-gray-600">Fecha: {{ $invoice->created_at->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-600">Total: ${{ number_format($invoice->total, 2) }}</div>
                        <div class="text-sm text-gray-600">Estado: {{ $invoice->status ?? 'Sin estado' }}</div>
                    </div>
                @empty
                    <div class="text-gray-500">No tienes facturas registradas</div>
                @endforelse
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">Salir</a>
        </div>
    </div>
</body>

</html>
