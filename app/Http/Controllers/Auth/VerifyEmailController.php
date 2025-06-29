<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\PlayerParent;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */

    public function __invoke(Request $request, $id, $hash)
    {
        $user = Admin::find($id) ?? PlayerParent::find($id);

        if (!$user) {
            abort(404, 'User not found');
        }

        if (
            !hash_equals((string) $id, (string) $user->getKey()) ||
            !hash_equals((string) $hash, sha1($user->getEmailForVerification()))
        ) {
            abort(403, 'Invalid verification link');
        }

        if (!$user instanceof MustVerifyEmail) {
            abort(403, 'User must implement MustVerifyEmail');
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        // Redirection selon le type d'utilisateur
        if ($user instanceof Admin) {
            return response()->view('new.admin.verified-message', [
                'redirect_url' => route('admin.login'),
            ]);
        }

        return response()->view('new.admin.verified-message', [
            'redirect_url' => config('app.frontend_url') . '/#/verify-email?verified=1&role=parent',
        ]);

    }



}
