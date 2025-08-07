<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    /**
     * Mostrar el formulario de perfil del usuario.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualizar la información del perfil.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Eliminar cuenta de usuario.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Cambiar rol del usuario actual.
     */
    public function changeSpatieRole(Request $request)
    {
        $request->validate([
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        $user = auth()->user();

        if ($user->email !== 'joel.darguello@gmail.com') {
            abort(403, 'No autorizado');
        }

        $user->syncRoles([$request->role]);

        return back()->with('status', 'Rol actualizado correctamente.');
    }

    /**
     * Crear un nuevo rol si no existe.
     */
    public function createSpatieRole(Request $request)
    {
        $request->validate([
            'new_role' => ['required', 'string', 'min:3', 'max:30', 'unique:roles,name'],
        ]);

        if (auth()->user()->email !== 'joel.darguello@gmail.com') {
            abort(403, 'No autorizado');
        }

        $role = Role::create(['name' => $request->new_role]);

        return back()->with('status', "Rol '{$role->name}' creado correctamente.");
    }

    /**
     * Actualizar un rol existente.
     */
    public function updateSpatieRole(Request $request, $id)
    {
        $request->validate([
            'updated_role' => ['required', 'string', 'min:3', 'max:30', 'unique:roles,name,' . $id],
        ]);

        if (auth()->user()->email !== 'joel.darguello@gmail.com') {
            abort(403, 'No autorizado');
        }

        $role = Role::findOrFail($id);
        $role->name = $request->updated_role;
        $role->save();

        return back()->with('status', "Rol actualizado a '{$role->name}'.");
    }

    /**
     * Eliminar un rol del sistema.
     */
    public function deleteSpatieRole($id)
    {
        if (auth()->user()->email !== 'joel.darguello@gmail.com') {
            abort(403, 'No autorizado');
        }

        $role = Role::findOrFail($id);

        if ($role->users()->count() > 0) {
            return back()->withErrors(['msg' => 'No se puede eliminar un rol que ya está asignado a usuarios.']);
        }

        $role->delete();

        return back()->with('status', "Rol '{$role->name}' eliminado correctamente.");
    }
}
