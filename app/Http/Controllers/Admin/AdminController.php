<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AgeCategory;
use App\Models\Player;
use App\Models\Post;
use App\Models\Registration;
use App\Models\Season;
use Illuminate\Http\Request;

class AdminController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {
        $admins =  Admin::all();
        return view( 'admin.admins.index', compact( 'admins' ) );
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {
        //
    }

    public function dashboard() {
        // // Nombre total de posts
        // $totalPosts = Post::count();

        // // Nombre de saisons non archivée ( is_archived = false )
        // $activeSeasons = Season::where( 'active', true )->count();

        // // Nombre d'inscriptions en attente (isValidated = false)
        // $pendingRegistrations = Registration::where('status', 'pending')->count();

        // // Nombre total d'admins
        // // $totalAdmins = Admin::count();

        // $galleryPosts = Post::where( 'type', 'GALERY' )
        //     ->whereNotNull( 'image_path' )
        //     ->orderByDesc( 'created_at' )
        //     ->take( 8 )
        //     ->get();

        // // Récupère les 8 derniers posts de type PUB ( publications )
        // $publicationPosts = Post::where( 'type', 'PUBLICATION' )
        //     ->whereNotNull( 'image_path' )
        //     ->orderByDesc( 'created_at' )
        //     ->take( 8 )
        //     ->get();

        // // On passe toutes ces variables à la vue
        // return view( 'new.admin.dashboard', compact(
        //     'totalPosts',
        //     'activeSeasons',
        //     'pendingRegistrations',
        //     'totalAdmins',
        //     'galleryPosts',
        //     'publicationPosts'
        // ) );

        return view( 'new.admin.dashboard', [
            'totalPlayers' => Player::count(),
            'pendingRegistrations' => Registration::where( 'status', 'pending' )->count(),
            'approvedRegistrations' => Registration::where( 'status', 'approved' )->count(),
            'rejectedRegistrations' => Registration::where( 'status', 'rejected' )->count(),
            'ageCategories' => AgeCategory::distinct()->count( 'name' ),
            'seasonsCount' => Season::all( [ 'year', 'active' ] )->count(),
            'seasons' => Season::orderByDesc( 'year' )->get(),
            // 'seasons' => Season::all( [ 'year', 'active' ] )->count(),
            'galleryPosts' => Post::where( 'type', 'GALERY' )->count(),
            'publicationPosts' => Post::where( 'type', 'PUBLICATION' )->count()
        ] );
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        //
        $request->validate( [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
        ] );
        Admin::create( $request->all() );
        return redirect()->route( 'admins.index' );
    }

    /**
    * Display the specified resource.
    */

    public function show( string $id ) {
        //
        return view( 'admins.show', compact( 'admin' ) );
    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit( string $id ) {
        //
    }

    /**
    * Update the specified resource in storage.
    */

    public function update( Request $request, string $id ) {
        //
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( string $id ) {
        //
    }
}
