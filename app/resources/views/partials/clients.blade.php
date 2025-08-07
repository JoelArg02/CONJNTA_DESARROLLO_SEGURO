    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Clientes') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Formulario crear o editar --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-lg font-semibold mb-4">
                {{ isset($editing) ? 'Editar Cliente' : 'Crear Cliente' }}
            </h3>

            <form method="POST"
                action="{{ isset($editing) ? route('admin.customers.update', $editing->id) : route('admin.customers.store') }}">
                @csrf
                @if (isset($editing))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input name="name" type="text" placeholder="Nombre" class="form-input" required
                        value="{{ old('name', $editing->name ?? '') }}">
                    <input name="email" type="email" placeholder="Email" class="form-input" required
                        value="{{ old('email', $editing->email ?? '') }}">
                    <input name="phone" type="text" placeholder="Teléfono" class="form-input"
                        value="{{ old('phone', $editing->phone ?? '') }}">
                    <input name="address" type="text" placeholder="Dirección" class="form-input"
                        value="{{ old('address', $editing->address ?? '') }}">
                </div>

                <div class="mt-4 flex justify-between items-center">
                    @if (isset($editing))
                        <a href="{{ route('admin.customers.index') }}"
                            class="text-sm text-gray-600 hover:underline">Cancelar</a>
                    @endif
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        {{ isset($editing) ? 'Guardar cambios' : 'Crear cliente' }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabla de clientes activos --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-lg font-semibold mb-4">Clientes Activos</h3>

            @if ($customers->count())
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-sm text-gray-600 uppercase tracking-wider">
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $c)
                            <tr class="border-b">
                                <td class="py-2">{{ $c->name }}</td>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->phone }}</td>
                                <td>{{ $c->address }}</td>
                                <td class="space-x-2">
                                    <a href="{{ route('admin.customers.index', ['edit' => $c->id]) }}"
                                        class="text-blue-600 hover:underline">Editar</a>

                                    <form action="{{ route('admin.customers.destroy', $c->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('¿Desactivar este cliente?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="reason" value="Desactivado manualmente">
                                        <button class="btn-primary">Desactivar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No hay clientes activos.</p>
            @endif
        </div>

        {{-- Tabla de clientes desactivados --}}
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Clientes Desactivados</h3>

            @if ($disabled->count())
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-sm text-gray-600 uppercase tracking-wider">
                            <th>Nombre</th>
                            <th>Motivo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($disabled as $c)
                            <tr class="border-b">
                                <td class="py-2">{{ $c->name }}</td>
                                <td>{{ $c->deactivation_reason }}</td>
                                <td>
                                    <form action="{{ route('admin.customers.restore', $c->id) }}" method="POST"
                                        onsubmit="return confirm('¿Reactivar este cliente?')">
                                        @csrf
                                        @method('PUT')
                                        <button class="text-green-600 hover:underline">Reactivar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No hay clientes desactivados.</p>
            @endif
        </div>
    </div>
