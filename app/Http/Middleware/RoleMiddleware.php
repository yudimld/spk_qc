<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek apakah role user ada di dalam array roles
        if (!in_array(Auth::user()->role, $roles)) {
            return redirect('/'); // Redirect jika tidak memiliki akses
        }
        
        return $next($request);
    }
}
