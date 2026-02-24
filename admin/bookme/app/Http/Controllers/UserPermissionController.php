<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;

class UserPermissionController extends Controller

{
     public function __construct()
    {
        $this->middleware('checkPermission:permission.manage');
    }
    public function index()
    {
        $users = User::with('permissions')->get();
        $permissions = Permission::all()->groupBy('module');
        return view('user-permissions.index', compact('users', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->permissions()->sync($request->permissions ?? []);
        return redirect()->back()->with('success', 'User permissions updated');
    }
}

