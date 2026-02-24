<?php
namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\ExpenseSubcategory;
use Illuminate\Http\Request;

class ExpenseSubcategoryController extends Controller
{
    public function index()
    
    {
        $categories = ExpenseCategory::all();
        $subcategories = ExpenseSubcategory::with('category')->latest()->get();
        return view('expense.expense_subcategories', compact('subcategories','categories'));
    }

    public function create()
    {
        $categories = ExpenseCategory::all();
        return view('subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        ExpenseSubcategory::create($request->all());

        return redirect()->back()->with('success', 'Subcategory created successfully.');
    }

   

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);
        $subcategory= ExpenseSubcategory::find($id);
        $subcategory->update($request->all());

        return redirect()->back()->with('success', 'Subcategory updated successfully.');
    }

    public function destroy($id)
    {
        $subcategory= ExpenseSubcategory::find($id);
        $subcategory->delete();
        return redirect()->back()->with('success', 'Subcategory deleted successfully.');
    }
}
