<div class="card p-6">
    {{-- ENCABEZADO --}}
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-900">Miembros del equipo</h3>

        <div class="flex items-center space-x-2">
            {{-- Botón crear --}}
            <button type="button" onclick="openCreateModal()"
                class="px-3 py-1 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                Crear Usuario
            </button>

            {{-- Botón ver desactivados --}}
            <button type="button" onclick="openInactiveModal()"
                class="px-3 py-1 bg-amber-600 text-white text-sm rounded-md hover:bg-amber-700">
                Ver desactivados
            </button>
        </div>

        {{-- Buscador --}}
        <form method="GET" action="{{ route('dashboard') }}#team-section" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                class="border-gray-300 rounded-md shadow-sm text-sm" placeholder="Buscar...">
            <button type="submit" class="px-3 py-1 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                Buscar
            </button>
        </form>
    </div>

    {{-- TABLA ACTIVOS (igual que antes) --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registrado</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full"
                                    src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=8B5CF6&color=fff"
                                    alt="Avatar">
                                <div class="ml-3 text-sm font-medium text-gray-900">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right text-sm">
                            <a href="#" onclick='openEditModal(@json($user))'
                                class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>

                            <button type="button"
                                onclick="openDeactivateModal({{ $user->id }}, '{{ $user->name }}')"
                                class="text-red-600 hover:text-red-800">Desactivar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $users->withQueryString()->fragment('team-section')->links() }}
    </div>

    {{-- ===============  MODAL LISTA DE INACTIVOS =============== --}}
    <div id="inactive-users-modal" class="fixed z-50 inset-0 hidden bg-black bg-opacity-40 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-6 relative">
                <button onclick="closeInactiveModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

                <h3 class="text-lg font-semibold mb-4 text-gray-900">Usuarios desactivados</h3>

                <div id="inactive-loading" class="text-sm text-gray-500 mb-4">Cargando...</div>

                <div class="overflow-x-auto">
                    <table class="min-w-full" id="inactive-table" style="display:none">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha baja
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motivo</th>
                            </tr>
                        </thead>
                        <tbody id="inactive-tbody" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ... encabezado omitido para brevedad ... -->
    <div id="deactivate-user-modal" class="fixed z-50 inset-0 overflow-y-auto hidden bg-black bg-opacity-40">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
                <button onclick="closeDeactivateModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

                <h3 class="text-lg font-semibold mb-4 text-gray-900" id="deactivate-modal-title">Desactivar cuenta</h3>

                <form id="deactivate-user-form" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="deactivate-user-id" />
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Motivo de desactivación</label>
                        <textarea name="reason" id="deactivate-reason" rows="3" class="form-input"></textarea>
                        <p class="text-sm text-red-600 mt-1" id="deactivate-error-reason"></p>
                    </div>
                    <div class="text-right">
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 text-sm">Desactivar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de edición -->
    <div id="edit-user-modal" class="fixed z-50 inset-0 overflow-y-auto hidden bg-black bg-opacity-40">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6 relative">
                <button onclick="closeEditModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

                <h3 class="text-lg font-semibold mb-4 text-gray-900">Editar Usuario</h3>

                <form id="edit-user-form" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="name" id="edit-name" class="form-input" />
                        <p class="text-sm text-red-600 mt-1" id="edit-error-name"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="edit-email" class="form-input" />
                        <p class="text-sm text-red-600 mt-1" id="edit-error-email"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Contraseña (opcional)</label>
                        <input type="password" name="password" id="edit-password" class="form-input" />
                        <p class="text-sm text-red-600 mt-1" id="edit-error-password"></p>
                    </div>

                    <div class="text-right">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal de creación -->
    <div id="create-user-modal" class="fixed z-50 inset-0 overflow-y-auto hidden bg-black bg-opacity-40">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6 relative">
                <button onclick="closeCreateModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

                <h3 class="text-lg font-semibold mb-4 text-gray-900">Crear Usuario</h3>

                <form id="create-user-form" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="name" id="create-name" class="form-input" />
                        <p class="text-sm text-red-600 mt-1" id="create-error-name"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="create-email" class="form-input" />
                        <p class="text-sm text-red-600 mt-1" id="create-error-email"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input type="password" name="password" id="create-password" class="form-input" />
                        <p class="text-sm text-red-600 mt-1" id="create-error-password"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Rol</label>
                        <select name="role" id="create-role" class="form-input">
                            <option value="">Seleccione un rol</option>
                            @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>

                        <p class="text-sm text-red-600 mt-1" id="create-error-role"></p>
                    </div>

                    <div class="text-right">
                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .form-input {
            @apply mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2 text-gray-900;
        }
    </style>

    <script>
        /* ---------- MODAL DESACTIVADOS ---------- */
        function openInactiveModal() {
            document.getElementById('inactive-users-modal').classList.remove('hidden');
            loadInactiveUsers();
        }

        function closeInactiveModal() {
            document.getElementById('inactive-users-modal').classList.add('hidden');
        }

        function loadInactiveUsers() {
            const tbody = document.getElementById('inactive-tbody');
            const table = document.getElementById('inactive-table');
            const loading = document.getElementById('inactive-loading');

            tbody.innerHTML = '';
            table.style.display = 'none';
            loading.textContent = 'Cargando…';

            fetch('{{ route('admin.users.inactive') }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (!Array.isArray(data)) throw new Error('Formato inesperado');

                    data.forEach(u => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
        <td class="px-4 py-3 text-sm text-gray-900">${u.name}</td>
        <td class="px-4 py-3 text-sm text-gray-500">${u.email}</td>
        <td class="px-4 py-3 text-sm text-gray-500">${u.deleted_at ?? '-'}</td>
        <td class="px-4 py-3 text-sm text-gray-500">${u.deactivation_reason ?? ''}</td>
        <td class="px-4 py-3 text-sm">
            <button onclick="reactivateUser(${u.id})"
                class="bg-green-600 text-white px-3 py-1 rounded-md text-sm hover:bg-green-700">
                Activar
            </button>
        </td>
    `;
                        tbody.appendChild(tr);
                    });


                    loading.textContent = data.length ? '' : 'No hay usuarios desactivados.';
                    table.style.display = data.length ? '' : 'none';
                })
                .catch(() => {
                    loading.textContent = 'Error al obtener la lista.';
                });
        }

        function reactivateUser(userId) {
            if (!confirm('¿Estás seguro de reactivar este usuario?')) return;

            fetch(`/admin/users/${userId}/reactivate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            }).then(res => {
                if (res.ok) {
                    location.reload(); // ← recarga toda la página

                } else {
                    alert('No se pudo reactivar el usuario.');
                }
            }).catch(() => {
                alert('Error inesperado al reactivar.');
            });
        }

        function openDeactivateModal(userId, userName) {
            document.getElementById('deactivate-user-modal').classList.remove('hidden');
            document.getElementById('deactivate-user-id').value = userId;
            document.getElementById('deactivate-modal-title').textContent = `Desactivar a ${userName}`;
            document.getElementById('deactivate-reason').value = '';
            document.getElementById('deactivate-error-reason').textContent = '';
        }

        function closeDeactivateModal() {
            document.getElementById('deactivate-user-modal').classList.add('hidden');
        }

        document.getElementById('deactivate-user-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const userId = document.getElementById('deactivate-user-id').value;
            const reason = document.getElementById('deactivate-reason').value;

            fetch(`/admin/users/${userId}/deactivate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    reason
                })
            }).then(async res => {
                if (res.status === 422) {
                    const data = await res.json();
                    document.getElementById('deactivate-error-reason').textContent = data.errors.reason
                        ?.[0] || '';
                } else if (res.ok) {
                    location.reload();
                } else {
                    alert("Error inesperado del servidor.");
                }
            }).catch(() => alert("Error inesperado."));
        });

        function openEditModal(user) {
            const modal = document.getElementById('edit-user-modal');
            modal.classList.remove('hidden');

            document.getElementById('edit-name').value = user.name;
            document.getElementById('edit-email').value = user.email;
            document.getElementById('edit-password').value = '';
            document.getElementById('edit-role').value = user.roles?.[0]?.name ?? '';

            document.getElementById('edit-user-form').action = `/admin/users/${user.id}`;
            clearErrors('edit');
        }


        function closeEditModal() {
            document.getElementById('edit-user-modal').classList.add('hidden');
        }

        function openCreateModal() {
            document.getElementById('create-user-modal').classList.remove('hidden');
            clearErrors('create');
            document.getElementById('create-user-form').reset();
        }

        function closeCreateModal() {
            document.getElementById('create-user-modal').classList.add('hidden');
        }

        function clearErrors(prefix) {
            ['name', 'email', 'password', 'role'].forEach(field => {
                const errorEl = document.getElementById(`${prefix}-error-${field}`);
                if (errorEl) errorEl.textContent = '';
            });
        }

        function deleteUser(id) {
            if (!confirm('¿Estás seguro de eliminar este usuario?')) return;

            fetch(`/admin/users/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(async res => {
                    if (!res.ok) {
                        const error = await res.json();
                        alert('Error: ' + (error.message || 'Error desconocido'));
                    } else {
                        alert('Usuario eliminado correctamente');
                        location.reload();
                    }
                })
                .catch(err => {
                    alert('Error inesperado del servidor');
                    console.error(err);
                });
        }

        document.getElementById('create-user-form').addEventListener('submit', function(e) {
            e.preventDefault();
            clearErrors('create');
            const form = e.target;
            const data = new FormData(form);

            fetch("{{ route('admin.users.store') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: data
            }).then(res => {
                if (res.status === 422) {
                    return res.json().then(data => {
                        for (let key in data.errors) {
                            document.getElementById(`create-error-${key}`).textContent = data
                                .errors[key][0];
                        }
                    });
                } else if (res.ok) {
                    location.reload();
                }
            }).catch(console.error);
        });

        document.getElementById('edit-user-form').addEventListener('submit', function(e) {
            e.preventDefault();
            clearErrors('edit');
            const form = e.target;
            const data = new FormData(form);

            fetch(form.action, {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    'X-HTTP-Method-Override': 'PUT'
                },
                body: data
            }).then(res => {
                if (res.status === 422) {
                    return res.json().then(data => {
                        for (let key in data.errors) {
                            document.getElementById(`edit-error-${key}`).textContent = data.errors[
                                key][0];
                        }
                    });
                } else if (res.ok) {
                    location.reload();
                }
            }).catch(console.error);
        });
    </script>


</div>
