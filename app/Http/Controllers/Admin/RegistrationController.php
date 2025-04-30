<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Player;
use App\Models\PlayerParent;
use App\Models\Registration;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //  retourne la vue de la liste des joueurs inscrits
        $registrations = Registration::with(['player', 'parent', 'season', 'age_category'])->get();
        return view('new.admin.registration.list', compact('registrations'));
    }

    public function create()
    {
        //  retourne la vue du formulaire d'inscription  
        //  A créer plutard 
        $players = Player::all();
        $seasons = Season::all();
        $parents = PlayerParent::all();
        return view('registrations.create',  compact('players', 'seasons', 'parents'));
    }

    public function store(Request $request)
    {
        // 1) Validation avec les nouvelles colonnes
        $data = $request->validate([
            'player_id'        => 'required|exists:players,id',
            'player_parent_id' => 'required|exists:player_parents,id',
            'season_id'        => 'required|exists:seasons,id',
        ]);

        // 2) Récupérer la catégorie d’âge du joueur
        $player = Player::findOrFail($data['player_id']);

        // 3) Compléter les champs manquants
        $data['age_categorie_id'] = $player->age_categories_id;  // FK depuis players
        $data['status'] = 'pending';

        // 4) Création de l’inscription
        Registration::create($data);

        // 5) Redirection
        return redirect()
            ->route('admin.registrations.index')
            ->with('success', 'Inscription réussie !');
    }



    public function validate(Registration $registration)
    {
        // Récupère l’admin connecté
        $admin = Admin::findOrFail(Auth::id());

        // Utilise la méthode du modèle Admin
        $admin->approve($registration);

        return redirect()
            ->back()
            ->with('success', 'Registration validated succesfully!');
    }

    /**
     * Annule (désvalide) une inscription.
     */
    public function cancel(Registration $registration)
    {
        // Récupère l’admin connecté
        $admin = Admin::findOrFail(Auth::id());

        // Utilise la méthode du modèle Admin
        $admin->reject($registration);

        return redirect()
            ->back()
            ->with('success', 'Registration cancelled succesfully.');
    }
}
