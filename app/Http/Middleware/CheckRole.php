<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        
        // Jika user adalah admin, izinkan akses ke semua fitur
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Jika role yang diminta adalah admin, tolak akses
        if ($role === 'admin' && $user->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Jika role yang diminta adalah staff, izinkan akses
        if ($role === 'staff' && ($user->role === 'staff' || $user->role === 'admin')) {
            return $next($request);
        }

        // Jika tidak ada role yang cocok, tolak akses
        abort(403, 'Unauthorized action.');
    }
}
