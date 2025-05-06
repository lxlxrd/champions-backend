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
        // phpinfo();

        $type = $request->type; // PUB ou GALLERY
        $files = Storage::disk('public')->files('posts');

        $seasons = Season::orderByDesc('year')->get();
        $posts = Post::with('seasons')

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
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'content' => 'required|string',
            'type' => 'required|in:GALERY,PUBLICATION',
            'image_path' => 'required|image|mimes:jpeg,png,webp',
        ]);

        // Stockage de l'image

        $imagePath = $request->file('image_path')->store('posts', 'public');

        // Création du post
        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'image_path' => $imagePath,
        ]);

        // Association à la saison courante
        $season = app(SeasonService::class)->current();
        if ($season) {
            $post->seasons()->attach($season->id, [
                'admin_id' => Auth::id(),
                'date' => now()
            ]);
        }

        return redirect()->route('admin.post.index')
            ->with('success', 'Post created successfully.');
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
    public function update(Request $request, $id) // Changez Post $post en $id pour matcher la route
    {
        // dd($request->all());
        // 1) Récupération du post

        $post = Post::findOrFail($id);

        // 2) Validation des champs
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $post->id,
            'content' => 'required|string',
            'type' => 'required|in:GALERY,PUBLICATION',
            'image_path' => 'nullable|image|mimes:jpeg,png,webp',
            // 'image_path' => 'nullable|image|mimes:jpeg,png,webp|max:4096',
        ]);

        // 3) Gestion de l'image
        if ($request->hasFile('image_path')) {
            // Supprimer l'ancienne image si elle existe
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            // Stocker la nouvelle image
            $validated['image_path'] = $request->file('image_path')->store('posts', 'public');
        }

        // 4) Mise à jour du post
        $post->update($validated);

        // 5) Mise à jour de la relation avec la saison
        $season = app(SeasonService::class)->current();
        if ($season) {
            $post->seasons()->sync([
                $season->id => [
                    'admin_id' => Auth::id(),
                    'date' => now()
                ]
            ]);
        }

        return redirect()->route('admin.post.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $post = Post::findOrFail($id);

        // Supprimer l'image si elle existe
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // 2) Détacher les saisons
        $post->seasons()->detach();

        // 3) Supprimer le post
        $post->delete();

        return redirect()
            ->route('admin.post.index')
            ->with('success', 'Post deleted succesfully.');
    }
}
