<?php
namespace App\Http\Controllers;

use App\Models\FooterPolicy;
use Illuminate\Http\Request;

class FooterPolicyController extends Controller
{
    // Get all policies
    public function index()
    {
        return response()->json(FooterPolicy::all(), 200);
    }

    // Store a new policy
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:footer_policies',
            'value' => 'required|string',
            'isActive' => 'boolean',
        ]);

        $policy = FooterPolicy::create($request->all());

        return response()->json($policy, 201);
    }

    // Get a single policy
    public function show($id)
    {
        $policy = FooterPolicy::find($id);

        if (!$policy) {
            return response()->json(['message' => 'Policy not found'], 404);
        }

        return response()->json($policy, 200);
    }

    // Update a policy
    public function update(Request $request, $id)
    {
        $policy = FooterPolicy::find($id);

        if (!$policy) {
            return response()->json(['message' => 'Policy not found'], 404);
        }

        $request->validate([
            'name' => 'string|unique:footer_policies,name,' . $id,
            'value' => 'string',
            'isActive' => 'boolean',
        ]);

        $policy->update($request->all());

        return response()->json($policy, 200);
    }

    // Delete a policy
    public function destroy($id)
    {
        $policy = FooterPolicy::find($id);

        if (!$policy) {
            return response()->json(['message' => 'Policy not found'], 404);
        }

        $policy->delete();

        return response()->json(['message' => 'Policy deleted'], 200);
    }
}
