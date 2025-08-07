<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $status = $request->input('status');

        $query = User::query()->with('roles');

        // Filter by status
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($role) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        $users = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        // Get statistics for all users (regardless of current filters)
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();
        $adminUsers = User::whereHas('roles', function ($q) {
            $q->where('name', 'Administrador');
        })->count();

        $roles = Role::all();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
            'role' => $role,
            'status' => $status,
            'roles' => $roles,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'adminUsers' => $adminUsers,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'min:2', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'roles'    => ['required', 'array', 'min:1'],
            'roles.*'  => ['exists:roles,name'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['roles']);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties(['roles' => $validated['roles']])
            ->log('Usuario creado');

        return redirect()->route('admin.users.index')->with('status', 'Usuario creado correctamente.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'min:2', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', Rules\Password::defaults()],
            'roles'    => ['required', 'array', 'min:1'],
            'roles.*'  => ['exists:roles,name'],
        ]);

        $user->update([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password']
                ? Hash::make($validated['password'])
                : $user->password,
        ]);

        $user->syncRoles($validated['roles']);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'roles' => $validated['roles']
            ])
            ->log('Usuario actualizado');

        return redirect()->route('admin.users.index')->with('status', 'Usuario actualizado correctamente.');
    }

    public function deactivate(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'No puedes desactivarte a ti mismo.']);
        }

        $user->is_active = false;
        $user->deactivation_reason = $request->input('reason');
        $user->save();

        $user->delete(); // <-- esto aplica SoftDelete

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties(['reason' => $request->input('reason')])
            ->log('Usuario desactivado');

        return response()->json(['message' => 'Usuario desactivado correctamente.']);
    }



    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', [
            'roles' => $roles,
        ]);
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function inactive()
    {
        $users = User::onlyTrashed()->get(['id', 'name', 'email', 'deleted_at', 'deactivation_reason']);
        return response()->json($users);
    }


    public function destroy(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'No puedes eliminarte a ti mismo.']);
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties(['reason' => $request->input('reason')])
            ->log('Usuario eliminado');

        $user->delete();

        return back()->with('status', 'Usuario eliminado correctamente.');
    }

    public function reactivate(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'No puedes reactivarte a ti mismo.']);
        }

        $user->restore();
        $user->is_active = true;
        $user->deactivation_reason = null;
        $user->save();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->log('Usuario reactivado');

        return back()->with('status', 'Usuario reactivado correctamente.');
    }


    public function createToken(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'token_name' => 'required|string|max:255',
        ]);

        $user = User::find($request->user_id);

        $token = $user->createToken($request->token_name);
        $plainTextToken = $token->plainTextToken;
        
        session(['last_created_token' => $plainTextToken]);
        
        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties([
                'token_name' => $request->token_name,
                'token_preview' => substr($plainTextToken, 0, 10) . '...'
            ])
            ->log('Creación de token');
            
        return redirect()->route('test')->with('status', 'Token creado exitosamente: ' . $plainTextToken);
    }
}
