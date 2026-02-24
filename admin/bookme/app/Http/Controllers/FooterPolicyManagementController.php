<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FooterPolicy;

class FooterPolicyManagementController  extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $footerPolicies = FooterPolicy::all();
        return view('footer-policy.index', compact('footerPolicies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Updated to match the 'name' column
            'value' => 'required|string',        // Updated to match the 'value' column
            'isActive' => 'required|boolean',    // Added for the 'isActive' column
        ]);

        FooterPolicy::create([
            'name' => $request->name,
            'value' => $request->value,
            'isActive' => $request->isActive,
        ]);

        return redirect()->back()->with('success', 'Footer Policy Added Successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Updated to match the 'name' column
            'value' => 'required|string',        // Updated to match the 'value' column
            'isActive' => 'required|boolean',    // Added for the 'isActive' column
        ]);

        $policy = FooterPolicy::findOrFail($id);
        $policy->update([
            'name' => $request->name,
            'value' => $request->value,
            'isActive' => $request->isActive,
        ]);

        return redirect()->back()->with('success', 'Footer Policy Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        FooterPolicy::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Footer Policy Deleted Successfully!');
    }
}