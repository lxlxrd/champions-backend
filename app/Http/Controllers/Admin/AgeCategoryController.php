<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AgeCategory;
use Illuminate\Http\Request;

class AgeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories =  AgeCategory::with('admin')->get();
        return view('new.admin.age-category.list', compact('categories'))->with('success', 'Category retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $admins =  Admin::all();
        return view('admin.age-categories.create', compact('admins'))->with('success', 'Category created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|unique:age_categories,name',
            'min_age' => 'required|integer|min:0|unique:age_categories,min_age',
            'max_age' => 'required|integer|gt:min_age|unique:age_categories,max_age',
            // 'admin_id' => 'required|exists:admins,id',
        ]);

        AgeCategory::create($request->all());
        return redirect()->route('admin.age-category.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = AgeCategory::findOrFail($id);
        $admins = Admin::all(); //  modifier aussi l'admin associé
        return view('admin.age-categories.edit', compact('category', 'admins'))->with('success', 'Category updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Valider les données entrantes
        $request->validate([
            'name' => 'required|string',
            'min_age' => 'required|integer|min:0',
            'max_age' => 'required|integer|gt:min_age',
            // 'admin_id' => 'required|exists:admins,id',
        ]);

        // Trouver la catégorie par ID
        $category = AgeCategory::findOrFail($id);

        // Mettre à jour les données
        $category->update([
            'name' => $request->name,
            'min_age' => $request->min_age,
            'max_age' => $request->max_age,
            // 'admin_id' => $request->admin_id,
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('admin.age-category.index')->with('success', 'Category updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = AgeCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.age-category.index')->with('success', 'Category deleted successfully.');
    }
}
