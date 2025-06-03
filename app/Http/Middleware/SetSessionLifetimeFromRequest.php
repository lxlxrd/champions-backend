<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSessionLifetimeFromRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si le front a envoyé keepLoggedIn = true, on garde la session 30 jours
        if ($request->boolean('keepLoggedIn')) {
            config(['session.lifetime' => 43200]); // 30 jours
            config(['session.expire_on_close' => false]);
        } else {
            config(['session.expire_on_close' => true]); // expire à fermeture navigateur
        }

        return $next($request);
    }
}
