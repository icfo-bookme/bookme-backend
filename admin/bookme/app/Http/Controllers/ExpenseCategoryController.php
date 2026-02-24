<?php
namespace App\Http\Controllers;

use App\Models\ExpenseCategory;

use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::latest()->get();
        return view('expense.expense_categories', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        ExpenseCategory::create($request->all());

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, $id)
{ 
    $request->validate([
        'name' => 'required|string|max:100',
        'description' => 'nullable|string',
    ]);
    $category = ExpenseCategory::find($id);
    $category->update($request->all());

    return redirect()->back()->with('success', 'Category updated successfully.');
}

    public function destroy($id)
    {
        $category = ExpenseCategory::find($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
