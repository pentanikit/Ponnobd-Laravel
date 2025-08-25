<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SystemAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $roles = Role::pluck('name');

        if(auth()->user()?->hasAnyRole($roles->toArray()) && user('user_type') == 'staff' || user('user_type') == 'admin'){
            return $next($request);
        }

        return abort(401);
    }
}
