<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ServiceCategory::all();
        return view('service_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('service_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'img' => 'nullable|string',
            'serialno' => 'nullable|integer',
            'isactive' => 'required|boolean',
            'isShow' => 'nullable|string',
        ]);

        ServiceCategory::create($request->all());

        return redirect()->route('service_categories.index')
                         ->with('success', 'Service Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = ServiceCategory::findOrFail($id);
        return view('service_categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = ServiceCategory::findOrFail($id);
        return view('service_categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    { 
       $data=  $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'img' => 'nullable|string',
            'serialno' => 'nullable|integer',
            'isactive' => 'required|boolean',
            'isShow' => 'nullable|string',
        ]);
       
        $category = ServiceCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('service_categories.index')
                         ->with('success', 'Service Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = ServiceCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('service_categories.index')
                         ->with('success', 'Service Category deleted successfully.');
    }
}