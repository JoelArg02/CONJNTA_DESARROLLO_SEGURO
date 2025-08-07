@php
    use Illuminate\Support\Facades\Auth;
    use Spatie\Permission\Models\Role;

    $user = Auth::user();
    $isJoel = $user && $user->email === 'joel.darguello@gmail.com';
    $allRoles = Role::all();
@endphp

@if ($isJoel)
    {{-- Rol actual --}}
    <section class="space-y-4 mt-10">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Rol actual</h2>
            <p class="mt-1 text-sm text-gray-600">
                Tu rol actual es: 
                <strong class="text-blue-600">
                    {{ $user->getRoleNames()->first() ?? 'Sin rol asignado' }}
                </strong>
            </p>
        </header>
    </section>

    {{-- Crear nuevo rol --}}
    <section class="space-y-6 mt-8">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Crear nuevo rol</h2>
            <p class="mt-1 text-sm text-gray-600">Puedes añadir un nuevo rol al sistema si no existe aún.</p>
        </header>

        <form method="POST" action="{{ route('profile.createSpatieRole') }}" class="space-y-6">
            @csrf
            <div>
                <x-input-label for="new_role" value="Nombre del nuevo rol" />
                <x-text-input id="new_role" name="new_role" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('new_role')" class="mt-2" />
            </div>
            <div>
                <x-primary-button>Crear Rol</x-primary-button>
            </div>
        </form>
    </section>

    {{-- Cambiar rol asignado al usuario --}}
    <section class="space-y-6 mt-10">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Cambiar mi rol</h2>
            <p class="mt-1 text-sm text-gray-600">Puedes cambiar tu rol actual a cualquiera disponible.</p>
        </header>

        <form method="POST" action="{{ route('profile.changeSpatieRole') }}" class="space-y-6">
            @csrf
            <div>
                <x-input-label for="role" value="Selecciona un rol" />
                <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @foreach ($allRoles as $role)
                        <option value="{{ $role->name }}" @if($user->hasRole($role->name)) selected @endif>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>
            <div>
                <x-primary-button>Cambiar Rol</x-primary-button>
            </div>
        </form>
    </section>

    {{-- Tabla de roles con edición y eliminación --}}
    <section class="space-y-6 mt-10">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Lista y gestión de roles</h2>
            <p class="text-sm text-gray-600">Puedes editar o eliminar roles existentes. El rol <strong>admin</strong> está protegido.</p>
        </header>

        <div class="overflow-x-auto mt-4">
            <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded">
                <thead class="bg-gray-100 text-gray-700 text-sm">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-center">Actualizar</th>
                        <th class="px-4 py-2 text-center">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allRoles as $index => $role)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>

                            {{-- Formulario de edición --}}
                            <td class="px-4 py-2">
                                @if ($role->name === 'admin')
                                    <span class="text-gray-500 italic">{{ $role->name }} (protegido)</span>
                                @else
                                    <form method="POST" action="{{ route('profile.updateSpatieRole', $role->id) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="updated_role" value="{{ $role->name }}"
                                               class="w-full px-2 py-1 border rounded text-sm" required />
                                        <x-primary-button class="text-xs px-2 py-1">Guardar</x-primary-button>
                                    </form>
                                @endif
                            </td>

                            {{-- Botón de eliminar --}}
                            <td class="px-4 py-2 text-center">
                                @if ($role->name !== 'admin')
                                    <form method="POST" action="{{ route('profile.deleteSpatieRole', $role->id) }}" onsubmit="return confirm('¿Eliminar el rol {{ $role->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button class="text-xs px-3 py-1">Eliminar</x-danger-button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm">No permitido</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500 italic">No hay roles registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endif
