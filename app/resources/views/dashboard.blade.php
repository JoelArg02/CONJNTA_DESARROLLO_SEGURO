<x-app-layout>
    <!-- Header con logout -->
    <div class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('api-test') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm">
                        Probar API
                    </a>
                    <span class="text-gray-700">Hola, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mostrar mensaje de éxito -->
    @if(session('status'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('status') }}
        </div>
    @endif

    <!-- Formulario para crear tokens -->
    <div class="mb-6 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Crear Token de API</h2>
        <form method="POST" action="{{ route('crearTokenAcceso') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="user-select" class="block mb-2 text-sm font-medium text-gray-700">Selecciona un usuario:</label>
                    <select id="user-select" name="user_id" class="block w-full p-2 border border-gray-300 rounded">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="token_name" class="block mb-2 text-sm font-medium text-gray-700">Nombre del token:</label>
                    <input type="text" id="token_name" name="token_name" class="block w-full p-2 border border-gray-300 rounded" required>
                </div>
            </div>

            <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                Crear Token
            </button>
        </form>
    </div>

    <!-- Mostrar tokens existentes -->
    @if(isset($userTokens) && $userTokens->count() > 0)
        <div class="mb-6 bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold mb-4">Tokens de API</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-left">Último uso</th>
                            <th class="px-4 py-2 text-left">Creado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userTokens as $token)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $token->name }}</td>
                                <td class="px-4 py-2">{{ $token->last_used_at ? $token->last_used_at->diffForHumans() : 'Nunca' }}</td>
                                <td class="px-4 py-2">{{ $token->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Pass chart data to JavaScript -->
    @php
        $monthLabels = $chartData['month_labels'] ?? ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'];
        $monthlyRevenue = $chartData['monthly_revenue'] ?? [0, 0, 0, 0, 0, 0];
        $invoiceStatus = $chartData['invoice_status_data'] ?? ['paid' => 0, 'pending' => 0, 'overdue' => 0];
    @endphp

    <script>
        window.chartData = {
            month_labels: @json($monthLabels),
            monthly_revenue: @json($monthlyRevenue),
            invoice_status_data: @json($invoiceStatus)
        };
    </script>

   


    <section id="dashboard-section" class="content-section">
        @include('partials.dashboard')
    </section>

    <section id="invoices-section" class="content-section hidden">
        @include('partials.invoices', [
            'invoices' => $invoices,
            'customers' => $customers,
            'products' => $products,
        ])
    </section>

    <section id="clients-section" class="content-section hidden">
        @include('partials.clients', ['customers' => $customers, 'disabled' => $disabled])
    </section>

    <section id="products-section" class="content-section hidden">
        @include('partials.products', ['products' => $products])
    </section>

    <section id="reports-section" class="content-section hidden">
        @include('partials.reports')
    </section>

    <section id="profile-section" class="content-section hidden">
        @include('partials.profile')
    </section>

    <section id="team-section" class="content-section hidden">
        @include('partials.team', ['users' => $users])
    </section>

    <section id="config-section" class="content-section hidden">
        @include('partials.config')
    </section>

</x-app-layout>
