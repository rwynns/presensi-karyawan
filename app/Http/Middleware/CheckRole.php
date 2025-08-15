<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        $userRole = $user->role_id;
        $allowedRoles = array_map('intval', $roles);

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized');
        }

        // Cek aktivasi untuk non-admin - tapi hanya untuk request non-AJAX/non-filter
        if ($userRole != 1 && !$user->is_active) {
            // Jangan logout jika ini adalah request untuk aktivasi page (admin sedang mengelola aktivasi)
            if (!$request->routeIs('admin.aktivasi.*')) {
                Auth::logout();
                return redirect('login')->withErrors(['email' => 'Akun Anda belum diaktivasi oleh admin.']);
            }
        }

        return $next($request);
    }
}
