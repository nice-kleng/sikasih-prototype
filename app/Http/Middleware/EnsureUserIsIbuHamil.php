<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsIbuHamil
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dengan guard web
        if (!auth('web')->check()) {
            return redirect()->route('login');
        }

        $user = auth('web')->user();

        // Cek apakah role adalah ibu_hamil
        if (!$user->hasRole('ibu_hamil')) {
            // Logout jika bukan ibu hamil
            auth('web')->logout();

            return redirect()->route('login')
                ->withErrors(['error' => 'Anda tidak memiliki akses ke halaman ini. Silakan login sebagai ibu hamil.']);
        }

        return $next($request);
    }
}
