<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    /* ───────────────────────────────── INDEX ─────────────────────────────── */
    public function index(Request $request)
    {
        $seasons = Season::orderByDesc('year')->with('registrations.parent', 'registrations.player')->get()
            ->map(function ($season) {
                // Compter les joueurs distincts
                $season->distinct_players = $season->registrations
                    ->pluck('player_id')
                    ->unique()
                    ->count();

                // Compter les parents distincts
                $season->distinct_parents = $season->registrations
                    ->pluck('player_parent_id')
                    ->unique()
                    ->count();

                return $season;
            });

        return view('new.admin.seasons.list', compact('seasons'));
    }

    /* ─────────────────────────────── CREATE FORM ─────────────────────────── */
    public function create()
    {
        $activeExists = Season::where('active', true)->exists();

        return view('admin.seasons.create', compact('activeExists'));
    }

    /* ───────────────────────────────── STORE ─────────────────────────────── */
    public function store(Request $request)
    {
        $data = $request->validate([
            'year'   => 'required|integer|digits:4|unique:seasons,year',
            'active' => 'sometimes|boolean',   // présent uniquement si la case est cochée
        ]);


        // Si on coche "active", on désactive d'abord toutes les autres saisons
        $makeActive = $request->has('active');
        if ($makeActive) {
            Season::where('active', true)->update(['active' => false]);
        }

        Season::create([
            'year'   => $data['year'],
            'active' => $request->has('active'),   // true si checkbox cochée
        ]);

        return redirect()
            ->route('admin.seasons.index')
            ->with('success', 'Season created successfully.');
    }

    /* ───────────────────────────────── EDIT FORM ─────────────────────────── */
    public function edit(string $id)
    {
        $season = Season::findOrFail($id);
        return view('admin.seasons.edit', compact('season'));
    }

    /* ───────────────────────────────── UPDATE ────────────────────────────── */
    public function update(Request $request, string $id)
    {
        $season = Season::findOrFail($id);

        $data = $request->validate([
            'year'   => 'required|integer|digits:4|unique:seasons,year,' . $season->id,
            'active' => 'sometimes|boolean',
        ]);

        $makeActive = $request->has('active');
        if ($makeActive) {
            // Désactive toutes les autres saisons
            Season::where('active', true)
                ->where('id', '<>', $season->id)
                ->update(['active' => false]);
        }


        $season->update([
            'year'   => $data['year'],
            'active' => $request->has('active'),
        ]);

        return redirect()
            ->route('admin.seasons.index')
            ->with('success', 'Season updated successfully.');
    }

    /* ─────────────────────────────── ARCHIVE/UNARCHIVE ───────────────────── */
    public function archive(Season $season)
    {
        $season->update(['active' => false]);
        return back()->with('success', 'Season archived successfully!');
    }


    public function archived()
    {
        $archived = Season::with(['registrations.player', 'registrations.parent'])
            ->where('active', false)
            ->orderByDesc('year')
            ->paginate(10);

        return view('admin.seasons.archived', compact('archived'));
    }

    /* ───────────────────────────────── DESTROY ───────────────────────────── */
    public function destroy(string $id)
    {
        Season::findOrFail($id)->delete();

        return redirect()
            ->route('admin.seasons.index')
            ->with('success', 'Season deleted successfully.');
    }
}
