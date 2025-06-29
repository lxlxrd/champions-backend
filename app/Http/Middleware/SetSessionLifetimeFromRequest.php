<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

class SetSessionLifetimeFromRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function handle(Request $request, Closure $next)
    {
        // Vérifie si l'utilisateur a demandé une session longue
        $response = $next($request);

        $sessionName = Config::get('session.cookie');

        if ($request->hasCookie('keepLoggedIn') && $request->cookie('keepLoggedIn') === 'true') {
            // Étendre la durée de session
            Config::set('session.lifetime', 2880); // 2 jours

            // Forcer la recréation du cookie
            if ($request->hasSession() && $request->session()->isStarted()) {
                $response->headers->setCookie(
                    new Cookie(
                        $sessionName,
                        $request->session()->getId(), // important !
                        now()->addDays(2),
                        config('session.path'),
                        config('session.domain'),
                        config('session.secure'),
                        config('session.http_only'),
                        false, // raw
                        config('session.same_site')
                    )
                );
            }
        }

        return $response;
    }

}

