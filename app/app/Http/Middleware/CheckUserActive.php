<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserActive
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->is_active) {
            // Determinar qué guard está siendo usado
            $guard = Auth::getDefaultDriver();
            
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirigir según el tipo de usuario/guard
            if ($guard === 'customer_web') {
                return redirect()->route('clientes.loginForm')->with('error', 'Su sesión ha finalizado. Comuníquese con el administrador.');
            } else {
                return redirect()->route('login')->with('error', 'Su sesión ha finalizado. Comuníquese con el administrador.');
            }
        }

        return $next($request);
    }
}