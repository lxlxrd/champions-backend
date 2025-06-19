<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use App\Models\PlayerParent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller {

    public function store( LoginRequest $request ): JsonResponse {
        $credentials = $request->only( 'email', 'password' );
        $keepLoggedIn = $request->boolean( 'keepLoggedIn' );

        // Parent login
        $parent = PlayerParent::where( 'email', $credentials[ 'email' ] )->first();
        if ( $parent && Hash::check( $credentials[ 'password' ], $parent->password ) ) {
            Auth::guard( 'web' )->login( $parent );
            $request->session()->regenerate();

            $token = null;
            if ( $keepLoggedIn ) {
                $token = $parent->createToken( 'spa-token' )->plainTextToken;
            }

            return response()->json( [
                'message' => 'Authenticated successfully.',
                'role' => 'parent',
                'redirect' => '/user-dashboard',
                'user' => $parent,
                'token' => $token,
            ] );
        }

        // Admin login
        $admin = Admin::where( 'email', $credentials[ 'email' ] )->first();
        if ( $admin && Hash::check( $credentials[ 'password' ], $admin->password ) ) {
            Auth::guard( 'admin' )->login( $admin );
            $request->session()->regenerate();

            $token = null;
            if ( $keepLoggedIn ) {
                $token = $admin->createToken( 'spa-token' )->plainTextToken;
            }

            return response()->json( [
                'message' => 'Authenticated successfully.',
                'role' => 'admin',
                'redirect' => config( 'app.url' ) . '/administration',
                'user' => $admin,
                'token' => $token,
            ] );
        }

        return response()->json( [
            'message' => 'Invalid credentials.',
        ], 401 );
    }

    public function destroy( Request $request ): JsonResponse {
        // Supprimer le token seulement s'il existe
    if ($request->user() && $request->user()->currentAccessToken()) {
        $request->user()->currentAccessToken()->delete();
    }

    Auth::guard('web')->logout();
    Auth::guard('admin')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->json(['message' => 'Logged out successfully.' ] );
    }

}
