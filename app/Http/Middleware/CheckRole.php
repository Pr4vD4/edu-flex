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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Если роли не указаны, пропускаем
        if (empty($roles)) {
            return $next($request);
        }

        // Проверяем, есть ли у пользователя нужная роль
        foreach ($roles as $role) {
            if ($request->user()->role === $role) {
                return $next($request);
            }
        }

        // Если нет подходящей роли, перенаправляем
        return redirect()->route('home')->with('error', 'У вас нет доступа к этой странице.');
    }
}
