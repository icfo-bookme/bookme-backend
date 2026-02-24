<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Show all customers
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    // Show form to create a new customer
    public function create()
    {
        return view('customers.create');
    }

    // Store a new customer
    public function store(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:20',
             'type' => 'nullable|string',
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'type' => $request->type,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    // Show a specific customer
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    // Show form to edit a customer
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    // Update a customer
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:20',
             'type' => 'nullable|string',
        ]);

        $data = $request->all();
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    // Delete a customer
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
    
    public function searchByPhone(Request $request)
{
    $query = $request->input('q');
    
    $customers = Customer::where('phone', 'LIKE', "%{$query}%")
        ->orWhere('name', 'LIKE', "%{$query}%")
        ->select('id', 'name', 'email', 'phone')
        ->limit(10)
        ->get();
    
    return response()->json($customers);
}
public function searchCustomers(Request $request)
{
    $query = $request->input('q');
    
    $customers = Customer::where(function($q) use ($query) {
            $q->where('phone', 'LIKE', "%{$query}%")
              ->orWhere('name', 'LIKE', "%{$query}%");
        })
        ->select('id', 'name', 'email', 'phone')
        ->limit(10)
        ->get();
    
    return response()->json($customers);
}
}
