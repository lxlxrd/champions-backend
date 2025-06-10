<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
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
        // Vérifie si le frontend demande une session persistante
        if ($request->has('keepLoggedIn') && $request->boolean('keepLoggedIn')) {
            config([
                'session.lifetime' => 43200, // 30 jours (en minutes)
                'session.expire_on_close' => false,
            ]);

            // Recrée manuellement le cookie laravel_session avec durée persistante
            Cookie::queue(Cookie::make(
                config('session.cookie'), // nom du cookie (ex: laravel_session)
                $request->cookie(config('session.cookie')), // valeur actuelle du cookie
                43200, // ⬅ durée en minutes, pas en secondes !
                config('session.path', '/'),
                config('session.domain', null),
                config('session.secure', true),
                config('session.http_only', true),
                false,
                config('session.same_site', 'lax')
            ));
        } else {
            config([
                'session.expire_on_close' => true, // expire à la fermeture du navigateur
            ]);
        }

        return $next($request);
    }
}
