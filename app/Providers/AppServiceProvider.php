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
            return (strtolower($user->rol) == 'admin');
        });
        Gate::define('rondas', function (User $user) {
            return (strtolower($user->rol) == 'admin');
        });
        Gate::define('novedades', function (User $user) {
            return (strtolower($user->rol) == 'admin');
        });
        Gate::define('minutas', function (User $user) {
            return (strtolower($user->rol) == 'admin');
        });
        Gate::define('paquetes', function (User $user) {
            return (strtolower($user->rol) == 'admin');
        });
        Gate::define('visitas', function (User $user) {
            return (strtolower($user->rol) == 'admin');
        });
        
    }
}
