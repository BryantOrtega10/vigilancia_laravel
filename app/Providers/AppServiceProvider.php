<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('propiedad', function (User $user) {
            return (strtolower($user->rol) == 'admin' || strtolower($user->rol) == 'admin_sede');
        });
        Gate::define('rondas', function (User $user) {
            return (strtolower($user->rol) == 'admin' || strtolower($user->rol) == 'admin_sede');
        });
        Gate::define('novedades', function (User $user) {
            return (strtolower($user->rol) == 'admin' || strtolower($user->rol) == 'admin_sede');
        });
        Gate::define('minutas', function (User $user) {
            return (strtolower($user->rol) == 'admin' || strtolower($user->rol) == 'admin_sede');
        });
        Gate::define('paquetes', function (User $user) {
            return (strtolower($user->rol) == 'admin' || strtolower($user->rol) == 'admin_sede');
        });
        Gate::define('visitas', function (User $user) {
            return (strtolower($user->rol) == 'admin' || strtolower($user->rol) == 'admin_sede');
        });
        Gate::define('usuarios', function (User $user) {
            return (strtolower($user->rol) == 'admin');
        });
        Gate::define('riesgos', function (User $user) {
            return (strtolower($user->rol) == 'admin' || strtolower($user->rol) == 'admin_sede');
        });        
        
        $permisosSuperAdmin = [
            'propiedad.agregar',
            'propiedad.modificar',
            'propiedad.eliminar',
            'propiedad.subirCSV',
            'propiedad.config',
            'rondas.eliminarRecorrido',
            'rondas.agregar',
            'rondas.modificar',
            'rondas.eliminar',
        ];
        
        foreach ($permisosSuperAdmin as $permisoSuperAdmin) {
            Gate::define($permisoSuperAdmin, function (User $user) {
                return (strtolower($user->rol) == 'admin');
            });
        }
               
        
    }
}
