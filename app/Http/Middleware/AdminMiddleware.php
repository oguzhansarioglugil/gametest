<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        // Kullanıcı giriş yapmış mı kontrol et
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Bu sayfaya erişmek için giriş yapmalısınız.');
        }

        $user = auth()->user();

        // Eğer belirli bir role belirtilmişse, o role'e sahip mi kontrol et
        if ($role) {
            if ($role === 'super_admin' && !$user->isSuperAdmin()) {
                abort(403, 'Bu sayfaya erişim yetkiniz yok. Sadece Süper Yöneticiler erişebilir.');
            }
        } else {
            // Genel admin kontrolü - admin veya super_admin olmalı
            if (!$user->isAdmin() && !$user->isSuperAdmin()) {
                abort(403, 'Bu sayfaya erişim yetkiniz yok. Yönetici yetkisi gereklidir.');
            }
        }

        return $next($request);
    }
}
