<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Las políticas del modelo.
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Registrar cualquier servicio de autenticación/autorización.
     */
    public function boot(): void
    {
        // Aquí definimos el Gate
        Gate::define('manage-users', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}
