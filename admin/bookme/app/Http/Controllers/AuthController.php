<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\CustomerDetail;
use App\Models\Customer;

class AuthController extends Controller
{
    // Register a new user and return token
    public function register(Request $request)
    { 
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|unique:customers,phone',
             'type' => 'nullable|string',
        ]);

        $user = Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'type' => $validated['type'],

        ]);
        
           $userdetails = CustomerDetail::create([
            'customer_id' => $user->id,
            'given_name' => $validated['name'],

        ]);
        
        // Create token for the user
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
        ], 201);
    }

    // Login user and return token
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = Customer::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
        ], 200);
    }

    // Return authenticated user details
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // Logout and revoke current token
    public function logout(Request $request)
    { 
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}



