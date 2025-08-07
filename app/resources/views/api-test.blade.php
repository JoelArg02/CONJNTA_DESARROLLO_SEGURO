<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba API - Laravel Sanctum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Prueba de API (Customer)</h1>

            <!-- Login Form -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Login como Cliente</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <input type="email" id="email" placeholder="Email"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500">
                    <input type="password" id="password" placeholder="Contraseña"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500">
                    <input type="text" id="device" placeholder="Nombre del dispositivo (opcional)" value="web"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <button onclick="loginCustomer()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Iniciar Sesión
                    </button>
                </div>

                <div id="loginResponse" class="text-sm text-gray-700"></div>
            </div>

            <!-- Token y Endpoints -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Probar Endpoints con Token</h2>

                <div class="mb-4">
                    <label for="token" class="block text-sm font-medium text-gray-700 mb-2">Token de API:</label>
                    <input type="text" id="token"
                        placeholder="Pega o genera aquí el token..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <button onclick="testAPI('/api/customer/me')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                        GET /api/customer/me
                    </button>
                    <button onclick="testAPI('/api/customer/invoices')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                        GET /api/customer/invoices
                    </button>
                    <button onclick="testAPI('/api/user')" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        GET /api/user
                    </button>
                </div>
            </div>

            <!-- API Response -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-2">Respuesta de la API:</h3>
                <div id="apiResponse" class="bg-gray-50 border border-gray-200 rounded-md p-4 min-h-32">
                    <p class="text-gray-500">Los resultados aparecerán aquí...</p>
                </div>
            </div>

            <!-- Instrucciones -->
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Instrucciones:</h3>
                <ol class="list-decimal list-inside text-blue-800 space-y-1">
                    <li>Ingresa las credenciales de un cliente válido.</li>
                    <li>Presiona "Iniciar Sesión" para obtener el token de acceso.</li>
                    <li>El token se autocompletará arriba.</li>
                    <li>Haz clic en los botones para probar los endpoints protegidos.</li>
                </ol>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </div>

    <script>
        async function loginCustomer() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const device = document.getElementById('device').value;
            const tokenInput = document.getElementById('token');
            const loginDiv = document.getElementById('loginResponse');

            if (!email) {
                loginDiv.innerHTML = '<span class="text-red-600">Email y contraseña son obligatorios.</span>';
                return;
            }

            loginDiv.innerHTML = '<span class="text-gray-600">Iniciando sesión...</span>';

            try {
                const response = await fetch('/api/customer/login', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password,
                        device_name: device
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    tokenInput.value = data.token;
                    loginDiv.innerHTML = `<span class="text-green-600 font-semibold">Token obtenido correctamente.</span>`;
                } else {
                    loginDiv.innerHTML = `<span class="text-red-600">Error: ${data.message || 'Credenciales inválidas.'}</span>`;
                }
            } catch (error) {
                loginDiv.innerHTML = `<span class="text-red-600">Error de conexión: ${error.message}</span>`;
            }
        }

        async function testAPI(endpoint) {
            const token = document.getElementById('token').value;
            const responseDiv = document.getElementById('apiResponse');

            if (!token) {
                responseDiv.innerHTML = '<p class="text-red-600">Por favor, introduce un token de API válido.</p>';
                return;
            }

            try {
                responseDiv.innerHTML = '<p class="text-gray-600">Cargando...</p>';

                const response = await fetch(endpoint, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    responseDiv.innerHTML = `
                        <div class="text-green-600 font-semibold mb-2">Éxito (${response.status})</div>
                        <pre class="bg-white p-4 rounded border overflow-x-auto text-sm">${JSON.stringify(data, null, 2)}</pre>
                    `;
                } else {
                    responseDiv.innerHTML = `
                        <div class="text-red-600 font-semibold mb-2">Error (${response.status})</div>
                        <pre class="bg-white p-4 rounded border overflow-x-auto text-sm">${JSON.stringify(data, null, 2)}</pre>
                    `;
                }
            } catch (error) {
                responseDiv.innerHTML = `
                    <div class="text-red-600 font-semibold mb-2">Error de conexión</div>
                    <p class="text-red-600">${error.message}</p>
                `;
            }
        }
    </script>
</body>
</html>
