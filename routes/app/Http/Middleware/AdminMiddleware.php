<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission = null): Response
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login');
        }

        $admin = Auth::guard('admin')->user();

        // If no specific permission is required, just check if admin is logged in
        if (!$permission) {
            return $next($request);
        }

        // Check if admin has the required permission
        if (!$admin->hasPermission($permission)) {
            // Redirect to dashboard with error message
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this module.');
        }

        return $next($request);
    }
}
