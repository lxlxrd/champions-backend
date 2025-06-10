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

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): Response
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return response()->noContent();
    // }


    public function store(LoginRequest $request): JsonResponse
    {

        $credentials = $request->only('email', 'password');


        // 1. Tentative d'authentification dans PlayerParent
        $parent = PlayerParent::where('email', $credentials['email'])->first();

        if ($parent && Hash::check($credentials['password'], $parent->password)) {
            $request->authenticateAs('web');
            $request->session()->regenerate();

            $parent->role = 'parent';

            if ($request->boolean('keepLoggedIn')) {
                config(['session.expire_on_close' => false]); // Le cookie ne sera pas supprimé à la fermeture du navigateur
                config(['session.lifetime' => 2880]); // 30 jours
            } else {
                // Expire à la fermeture → pas de changement ici, Laravel crée un cookie sans expiration
                config(['session.expire_on_close' => true]);
            }

            return response()->json([
                'message' => 'Authenticated succefully.',
                'role' => $parent->role,
                'redirect' => '/user-dashboard',
                'user' => $parent,
            ]);
        }

        // 2. Sinon : Tentative dans Admin
        $admin = Admin::where('email', $credentials['email'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Auth::guard('admin')->login($admin);
            // Auth::shouldUse('admin');
            $request->session()->regenerate();


            $admin->role = 'admin';

            if ($request->boolean('keepLoggedIn')) {
                config(['session.expire_on_close' => false]); // Le cookie ne sera pas supprimé à la fermeture du navigateur
                // config(['session.lifetime' => 2880]); // 30 jours
            } else {
                // Expire à la fermeture → pas de changement ici, Laravel crée un cookie sans expiration
                config(['session.expire_on_close' => true]);
            }

            return response()->json([
                'message' => 'Authenticated succefully (admin).',
                'redirect' => config('app.url') . '/administration',
                'user' => $admin,
                'role' => 'admin',
            ]);
        }



        // 3. Échec total
        return response()->json([
            'message' => 'Invalids credentials.',
        ], 401);
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
