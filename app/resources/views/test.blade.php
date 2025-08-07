<x-app-layout>

    {{-- Mostrar mensaje de estado con el token recién creado --}}
    @if (session('status'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('status') }}
        </div>
    @endif

    @if (session('last_created_token'))
        <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
            <h3 class="font-semibold">Último token creado:</h3>
            <div class="mt-2 p-2 bg-white border rounded font-mono text-sm break-all">
                {{ session('last_created_token') }}
            </div>
            <small class="text-blue-600">Copia este token ahora, no se mostrará nuevamente por seguridad.</small>
        </div>
        {{ session()->forget('last_created_token') }}
    @endif

    <form class="mb-4" method="POST" action="{{ route('crearTokenAcceso') }}">
        @csrf

        <label for="user-select" class="block mb-2 text-sm font-medium text-gray-700">Selecciona un usuario:</label>
        <select id="user-select" name="user_id" class="block w-full p-2 border border-gray-300 rounded">
            @foreach ($users as $user)
                <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
            @endforeach
        </select>

        <label for="token_name" class="block mt-2 mb-2 text-sm font-medium text-gray-700">Nombre del token:</label>
        <input type="text" id="token_name" name="token_name" class="block w-full p-2 border border-gray-300 rounded"
            required>

        <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Crear Token</button>
    </form>

    <div class="mt-6">
        <h2 class="text-lg font-semibold mb-4">Tokens existentes por usuario</h2>
        <ul>
            @foreach ($users as $user)
                <li class="mb-4 p-4 border rounded-lg">
                    <span class="font-medium text-lg">{{ $user['name'] }} ({{ $user['email'] }})</span>
                    @if (!empty($user['tokens']) && count($user['tokens']) > 0)
                        <ul class="ml-4 mt-2 space-y-2">
                            @foreach ($user['tokens'] as $token)
                                <li class="p-2 bg-gray-50 rounded">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <strong>{{ $token->name }}</strong>
                                            <br>
                                            <small class="text-gray-500">
                                                Creado: {{ $token->created_at->format('d/m/Y H:i') }}
                                                @if($token->last_used_at)
                                                    | Último uso: {{ $token->last_used_at->format('d/m/Y H:i') }}
                                                @else
                                                    | Nunca usado
                                                @endif
                                            </small>
                                        </div>
                                        <span class="text-xs bg-gray-200 px-2 py-1 rounded">
                                            ID: {{ $token->id }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="ml-4 mt-2 text-gray-500 italic">Sin tokens creados</div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

</x-app-layout>
