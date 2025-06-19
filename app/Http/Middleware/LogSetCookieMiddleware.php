<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogSetCookieMiddleware {
    /**
    * Handle an incoming request.
    *
    * @param  \Closure( \Illuminate\Http\Request ): ( \Symfony\Component\HttpFoundation\Response )  $next
    */

    public function handle( Request $request, Closure $next ) {
        $response = $next( $request );

        // Récupère les cookies envoyés
        $cookies = $response->headers->getCookies();

        // Transforme les cookies en un tableau lisible
        $cookieData = [];
        foreach ( $cookies as $cookie ) {
            $cookieData[] = [
                'name' => $cookie->getName(),
                'value' => $cookie->getValue(),
                'expires' => $cookie->getExpiresTime() ? date( 'Y-m-d H:i:s', $cookie->getExpiresTime() ) : 'Session',
                'path' => $cookie->getPath(),
                'domain' => $cookie->getDomain(),
                'secure' => $cookie->isSecure(),
                'httpOnly' => $cookie->isHttpOnly(),
                'sameSite' => $cookie->getSameSite(),
            ];
        }

        Log::info( 'Set-Cookie headers sent in response', $cookieData );
        Log::info( 'Session lifetime for this request: ' . config( 'session.lifetime' ) );
        Log::info( 'Expire on close: ' . ( config( 'session.expire_on_close' ) ? 'true' : 'false' ) );

        return $response;
    }
}
