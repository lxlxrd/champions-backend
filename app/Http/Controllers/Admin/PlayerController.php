<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\PlayerParent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlayerController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {
        //
        $players  =  Player::with( 'parent' )->get();
        return view( 'new.admin.player.list', compact( 'players' ) );
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {
        //
        $parents = PlayerParent::all();
        return view( 'admin.players.create', compact( 'parents' ) );
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        $data = $request->validate( [
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255|unique:players,last_name',
            'birth_date'        => 'required|date|unique:players,birth_date',
            'gender'            => 'required|in:male,female|unique:players,gender',
            'jersey_size'       => 'required|string|max:10',
            'preferred_location' => 'required|string|max:255',
            // 'player_parents_id' => 'required|exists:player_parents,id',
            'player_parents_id' => 'nullable|exists:player_parents,id',

        ] );

        $birth = Carbon::parse( $data[ 'birth_date' ] );
        $age = $birth->age;
        if ( $age < 10 ) {
            return back()
            ->withInput()
            ->with( 'error_min_age', "The minimum age is 10 years-old. You are {$age} years-old." );
        }

        Player::create( $data );
        return redirect()->route( 'admin.player.index' )->with( 'success', 'Player created successfully.' );
    }

    /**
    * Display the specified resource.
    */

    public function show( Player $player ) {
        //
        $player = Player::with( 'parent' )->find( $player->id );
        if ( !$player ) {
            return redirect()->with( 'error', 'Player not found.' );
        }

        //
        return view( 'admin.players.show',  compact( 'player' ) );
    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit( string $id ) {
        //
        // On récupère le joueur par son ID
        $player = Player::findOrFail( $id );

        // On retourne la vue 'players.edit' avec le joueur
        return view( 'admin.players.edit', compact( 'player' ) );
    }

    /**
    * Update the specified resource in storage.
    */
    /**
    * Update the specified resource in storage.
    */

    public function update( Request $request, string $id ) {
        // 1 ) Récupère le joueur ou 404
        $player = Player::findOrFail( $id );

        // 2 ) Validation des champs
        $data = $request->validate( [
            'first_name'         => 'required|string|max:255',
            'last_name'          => 'required|string|max:255',
            'birth_date'         => 'required|date',
            'gender'             => 'required|in:male,female',
            'jersey_size'        => 'required|string|max:10',
            'preferred_location' => 'required|string|max:255',
            'player_parents_id'  => 'exists:player_parents,id',
            'player_age_category_id' => 'exists:age_categories,id',
        ] );
        // dd( $data );

        // 3 ) Mise à jour du modèle
        $player->update( $data );

        // 4 ) Redirection avec message de succès
        return redirect()
        ->route( 'admin.player.index' )
        ->with( 'success', 'Player updated succesfully.' );
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( string $id ) {
        // On récupère le joueur ou on renvoie une 404
        $player = Player::findOrFail( $id );

        // Suppression du joueur
        $player->delete();

        // Redirection avec un message de succès
        return redirect()
        ->route( 'admin.player.index' )
        ->with( 'success', 'Player deleted successfully.' );
    }

}
