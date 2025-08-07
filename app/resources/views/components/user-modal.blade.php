@props([
    'open' => false,
    'title' => '',
    'action' => '',
    'method' => 'POST',
    'user' => null,
    'roles' => [],
])

<div
    x-data="{ show: @js($open) }"
    x-show="show"
    x-cloak
    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50"
>
    <div @click.away="show = false" class="bg-white w-full max-w-lg rounded shadow p-6">
        <h2 class="text-lg font-bold mb-4">{{ $title }}</h2>

        <form method="POST" action="{{ $action }}">
            @csrf
            @if($method === 'PUT')
                @method('PUT')
            @endif

            <div class="mb-4">
                <x-input-label for="name" value="Nombre" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                              value="{{ old('name', $user->name ?? '') }}" required />
            </div>

            <div class="mb-4">
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                              value="{{ old('email', $user->email ?? '') }}" required />
            </div>

            @if(!$user)
                <div class="mb-4">
                    <x-input-label for="password" value="Contraseña" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                </div>
            @endif

            <div class="mb-4">
                <x-input-label for="role" value="Rol" />
                <select name="role" id="role" class="mt-1 block w-full">
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ (isset($user) && $user->hasRole($role)) ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <x-secondary-button @click="show = false" class="mr-2">Cancelar</x-secondary-button>
                <x-primary-button type="submit">Guardar</x-primary-button>
            </div>
        </form>
    </div>
</div>
