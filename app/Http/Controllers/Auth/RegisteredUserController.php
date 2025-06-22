<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Player;
use App\Models\PlayerParent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): JsonResponse
    {
        // Valider les données du formulaire

        if ($request->has('admin')) {
            // === ADMIN REGISTRATION ===
            $validator = Validator::make($request->all(), [
                'admin.first_name' => 'required|string|max:255',
                'admin.last_name' => 'required|string|max:255',
                'admin.email' => 'required|email|max:255|unique:users,email',
                'admin.phone' => 'required|string|max:20',
                'admin.address' => 'required|string|max:255',
                'admin.password' => [
                    'required',
                    'confirmed',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                ],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erreur de validation.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            try {
                $admin = Admin::create([
                    'first_name' => $request->input('admin.first_name'),
                    'last_name' => $request->input('admin.last_name'),
                    'email' => $request->input('admin.email'),
                    'phone' => $request->input('admin.phone'),
                    'address' => $request->input('admin.address'),
                    'password' => Hash::make($request->input('admin.password')),
                    'role' => 'admin',
                ]);

                event(new Registered($admin));
                // Auth::guard( 'admin' )->login( $admin );

                return response()->json([
                    'message' => 'Inscription admin réussie.',
                    'admin' => $admin,
                    // 'redirect' => config( 'app.url' ) . '/administration',
                    // dd( config( 'app.url' ) . '/administration' )
                ], 201);

            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Une erreur est survenue lors de l’inscription admin.',
                    'error' => $e->getMessage(),
                ], 500);
            }

        } else {
            $messages = [
                'parent.phone.regex' => 'Le numéro doit être au format international, ex: +33612345678.',
                'parent.address.regex' => 'L’adresse contient des caractères non autorisés.',
                'parent.password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.',
            ];
            $validator = Validator::make($request->all(), [
                'parent.first_name' => 'required|string|max:255',
                'parent.last_name' => 'required|string|max:255',
                'parent.email' => 'required|email|max:255|unique:player_parents,email',
                'parent.phone' => [
                    'required',
                    'regex:/^(\+?[1-9]{1}[0-9]{6,14})$/',
                ],
                'parent.address' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\p{L}\p{N}\s\',.\-]{5,255}$/u'
                ],
                'parent.password' => [
                    'required',
                    'confirmed',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                ],
                'player.first_name' => 'required|string|max:255',
                'player.last_name' => 'required|string|max:255',
                'player.birth_date' => 'required|date',
                'player.gender' => 'required|in:male,female,other',
                'player.preferred_location' => 'required|in:courtice,bowmanville,newcastle',
                'player.jersey_size' => 'required|string|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erreur de validation.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            try {
                // Création du parent
                $parent = PlayerParent::create([
                    'first_name' => $request->input('parent.first_name'),
                    'last_name' => $request->input('parent.last_name'),
                    'email' => $request->input('parent.email'),
                    'phone' => $request->input('parent.phone'),
                    'address' => $request->input('parent.address'),
                    'password' => Hash::make($request->input('parent.password')),
                ]);

                // Création du joueur lié au parent
                $player = Player::create([
                    'first_name' => $request->input('player.first_name'),
                    'last_name' => $request->input('player.last_name'),
                    'birth_date' => $request->input('player.birth_date'),
                    'gender' => $request->input('player.gender'),
                    'preferred_location' => $request->input('player.preferred_location'),
                    'jersey_size' => $request->input('player.jersey_size'),
                    'player_parents_id' => $parent->id,
                ]);

                event(new Registered($parent));

                Auth::login($parent);
                // Réponse avec succès
                return response()->json([
                    'message' => 'Inscription réussie.',
                    'parent' => $parent,
                    'player' => $player,
                ], 201);

                // return response()->json( null, 204 );
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Une erreur est survenue lors de l’inscription.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
    }
}
