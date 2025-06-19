<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetSessionLifetimeFromRequest {
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return \Symfony\Component\HttpFoundation\Response
    */

    public function handle( Request $request, Closure $next ) {
        Log::info( '--- NEW REQUEST ---' );
        Log::info( 'Request URL: ' . $request->fullUrl() );
        Log::info( 'Request method: ' . $request->method() );
        Log::info( 'Session ID: ' . $request->session()->getId() );
        Log::info( 'Session data BEFORE: ', $request->session()->all() );

        if ( $request->is( 'login' ) ) {
            Log::info( 'Request data at login: ', $request->all() );
            $keepLoggedIn = $request->boolean( 'keepLoggedIn' );
            $request->session()->put( '_keepLoggedIn', $keepLoggedIn );
        } else {
            $keepLoggedIn = $request->session()->get( '_keepLoggedIn', false );
        }

        // Appliquer les paramètres dynamiques
        if ( $keepLoggedIn ) {
            Config::set( 'session.expire_on_close', false );
            Config::set( 'session.lifetime', 2880 );
        } else {
            Config::set( 'session.expire_on_close', true );
            Config::set( 'session.lifetime', 120 );
        }

        Log::info( 'Session lifetime for this request: ' . config( 'session.lifetime' ) );
        Log::info( 'Expire on close: ' . ( config( 'session.expire_on_close' ) ? 'true' : 'false' ) );

        $response = $next( $request );

        // Forcer un cookie laravel_session avec la bonne durée
        $minutes = $keepLoggedIn ? 2880 : null;
        // null => cookie de session ( expire à fermeture navigateur )

        $cookie = cookie(
            config( 'session.cookie' ),
            $request->session()->getId(),
            $minutes,
            config( 'session.path' ),
            config( 'session.domain' ),
            config( 'session.secure' ),
            config( 'session.http_only' ),
            false,
            config( 'session.same_site' )
        );

        $response->headers->setCookie( $cookie );

        Log::info( 'Session data AFTER: ', $request->session()->all() );

        return $response;
    }

}

