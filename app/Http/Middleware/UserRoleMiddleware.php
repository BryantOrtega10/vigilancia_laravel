<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        $roles = explode("|", $roles);
        if (Auth::check()) {
            foreach ($roles as $rol) {
                if (Auth::user()->rol != null && strtolower(Auth::user()->rol) == strtolower($rol))
                    return $next($request);
            }
        }
        switch(strtolower(Auth::user()->rol->nombre)){
            case 'admin':
                return redirect(route('propiedad.tabla'));
                break;
            default:
                return redirect(route('propiedad.tabla'));
                break;
        }
        return redirect('/');
    }
}
