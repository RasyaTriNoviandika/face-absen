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
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Superadmin bisa akses semua
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Check if user has required role
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized access. You do not have permission to access this page.');
        }

        // Check if user is active
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}

// app/Http/Middleware/EnsureUserHasEmployee.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasEmployee
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Admin tidak perlu employee
        if ($user->isAdmin()) {
            return $next($request);
        }

        // User harus punya employee
        if (!$user->employee_id || !$user->employee) {
            return redirect()->route('profile.edit')
                ->with('error', 'Please complete your employee profile first.');
        }

        return $next($request);
    }
}