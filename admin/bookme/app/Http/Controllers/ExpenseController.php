<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubcategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
{
   $categories = ExpenseCategory::all();
$subcategories = ExpenseSubcategory::all();
$expenses = Expense::latest()->get(); // or with('subcategory') if needed

return view('expense.expenses', compact('categories', 'subcategories', 'expenses'));

}


    public function create()
    {
        $subcategories = ExpenseSubcategory::with('category')->get();
        return view('expenses.create', compact('subcategories'));
    }

    public function store(Request $request)
    { 
        $request->validate([
            'subcategory_id' => 'required|exists:expense_subcategories,id',
             'category_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense recorded successfully.');
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $subcategories = ExpenseSubcategory::with('category')->get();
        return view('expenses.edit', compact('expense', 'subcategories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'subcategory_id' => 'required|exists:expense_subcategories,id',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
