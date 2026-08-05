<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Cek role pengguna yang login (contoh: role:admin,editor).
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        if (!in_array(Auth::user()->role, $roles, true)) {
            abort(403, 'Akses ditolak untuk role ini.');
        }

        return $next($request);
    }
}
