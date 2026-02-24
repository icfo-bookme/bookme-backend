<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    // Display a list of permissions in a Blade view
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    // Store a new permission
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'module' => 'required|string',
            'label' => 'required|string',
        ]);

        Permission::create([
            'name' => $request->name,
            'module' => $request->module,
            'label' => $request->label,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission added successfully.');
    }

    // Update an existing permission
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
            'module' => 'required|string',
            'label' => 'required|string',
        ]);

        $permission->update($request->only('name', 'module', 'label'));

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    // Delete a permission
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
