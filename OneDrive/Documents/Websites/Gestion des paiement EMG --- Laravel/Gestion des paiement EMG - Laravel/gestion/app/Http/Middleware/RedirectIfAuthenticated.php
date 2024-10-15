<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                //return redirect(RouteServiceProvider::HOME);

            $user = Auth::user();

            if ($user->role === 'comptable') {
                return redirect()->route('comptable.filtreEtudiant'); // Redirection vers la page du comptable
            } else {
                return redirect()->route('etudiant.paiementEtudiant', ['id' => $user->id]); // Redirection vers la page de l'étudiant
            }}
        }

        return $next($request);
    }
}
