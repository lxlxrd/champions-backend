<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Season;
use App\Services\SeasonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->type; // PUB ou GALLERY
        $files = Storage::disk('public')->files('posts');

        $seasons = Season::orderByDesc('year')->get();
        $posts = Post::with('seasons')
            // ->when($type, fn($q) => $q->where('type', $type))

            // ->when(request('season_id'), function ($q, $seasonId) {
            //     return $q->whereHas(
            //         'seasons',
            //         fn($qb) =>
            //         $qb->where('seasons.id', $seasonId)
            //     );
            // })
            // ->orderByDesc('created_at')
            ->paginate(10);   // <-- pagination

        return view('new.admin.post.list', compact('posts', 'files', 'seasons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $seasons = Season::all();
        $admins = Admin::all();
        return view('admin.posts.create', compact('seasons', 'admins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1) Validation des champs
        $request->validate([
            'title'   => 'required|string|max:255|unique:Posts,title',
            'content' => 'nullable|string|unique:Posts,content',
            'type'    => 'required|in:GALERY,PUBLICATION',
            'image'   => 'required|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
            // 'season'  => 'nullable|integer|exists:seasons,id',
        ]);

        // 2) Stockage du fichier image
        // stocke dans storage/app/public/posts et retourne le chemin relatif
        $path = $request->file('image')
            ->store('posts', 'public');

        // 3) Création du post en base
        $post = Post::create([
            'title'   => $request->title,
            'content' => $request->content,
            'type'    => $request->type,
            'image_path'   => $path,
        ]);

        $season = app(SeasonService::class)->current();
        if (!$season) {
            // pas de saison active : on sort
            return;
        }

        // 4) Association à la saison choisie (si fournie)
        // if ($request->filled('season')) {
        $post->seasons()->attach($season, [
            'admin_id' => Auth::user()->id,
            'date'     => now(),
        ]);
        // }

        // 5) Redirection avec message de succès
        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post created succesfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Charge la relation seasons et ses pivots (admin, date)
        $post->load([
            'seasons' => function ($q) {
                $q->orderByDesc('post_season.date');
            }
        ]);

        // Affiche la vue posts.show avec le post chargé
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Récupère toutes les saisons pour le <select>
        $seasons = Season::orderByDesc('year')->get();

        // Affiche la vue posts.edit avec le post et la liste des saisons
        return view('admin.posts.edit', compact('post', 'seasons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'   => 'required|string|max:255|unique:Posts,title',
            'content' => 'nullable|string|unique:Posts,content',
            'type'     => 'required|in:GALERY,PUB',
            'image_path'    => 'nullable|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
            // 'season'  => 'nullable|integer|exists:seasons,id',
        ]);

        // Si nouvelle image → on supprime l’ancienne + on stocke la nouvelle
        if ($request->hasFile('image_path')) {
            Storage::disk('public')->delete($post->image);
            $post->image_path = $request->file('image_path')->store('posts', 'public');
        }

        // Mise à jour des champs simples
        $post->update([
            'title'   => $request->title,
            'content' => $request->content,
            'type'    => $request->type,
            // 'season' => $request->season
        ]);

        $season = app(SeasonService::class)->current();
        if (!$season) {
            // pas de saison active : on sort
            return;
        }

        // if ($request->has('season')) {
        $post->seasons()->sync([ // on supprime les anciennes saisons et fais le nouvelle association
            $season => [
                'admin_id' => Auth::user()->id,
                'date'     => now()
            ]
        ]);
        // }

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Supprimer l'image si elle existe
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // 2) Détacher les saisons
        $post->seasons()->detach();

        // 3) Supprimer le post
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post deleted succesfully.');
    }
}
