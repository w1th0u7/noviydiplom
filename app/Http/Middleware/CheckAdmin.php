<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @param   \Illuminate\View\Middleware\ShareErrorsFromSession::class
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isAdmin()) { // Замените isAdmin() на ваш метод проверки прав
            return $next($request);
        }

        //  Если не админ, перенаправляем куда-нибудь (например, на главную)
        return redirect('home')->with('error', 'У вас нет прав администратора.');
    }
}