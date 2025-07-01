<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): JsonResponse
    // {
    //     // $request->validate([
    //     //     'email' => ['required', 'email'],
    //     // ]);

    //     // // We will send the password reset link to this user. Once we have attempted
    //     // // to send the link, we will examine the response then see the message we
    //     // // need to show to the user. Finally, we'll send out a proper response.
    //     // $status = Password::sendResetLink(
    //     //     $request->only('email')
    //     // );

    //     // if ($status != Password::RESET_LINK_SENT) {
    //     //     throw ValidationException::withMessages([
    //     //         'email' => [__($status)],
    //     //     ]);
    //     // }

    //     // return response()->json(['status' => __($status)]);





    //     $request->validate([
    //         'email' => ['required', 'email'],
    //     ]);

    //     // ✅ ici on force le broker 'admins'
    //     $status = Password::broker('admins')->sendResetLink(
    //         $request->only('email')
    //     );

    //     if ($status != Password::RESET_LINK_SENT) {
    //         throw ValidationException::withMessages([
    //             'email' => [__($status)],
    //         ]);
    //     }

    //     if ($request->expectsJson()) {
    //         return response()->json(['status' => __($status)]);
    //     }

    //     return back()->with('status', __($status));
    // }




    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Utiliser le broker pour les admins
        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        // Si l'envoi échoue
        if ($status !== Password::RESET_LINK_SENT) {
            if ($request->expectsJson()) {
                throw ValidationException::withMessages([
                    'email' => [__($status)],
                ]);
            }

            return back()->withErrors([
                'email' => __($status),
            ]);
        }

        // Réponse selon le type de requête
        if ($request->expectsJson()) {
            return response()->json(['status' => __($status)]);
        }

        return back()->with('status', __($status));
    }

}
