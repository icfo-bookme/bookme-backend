<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerDetail;
use Illuminate\Http\Request;

class CustomerDetailController extends Controller
{
    // Get all customer details
    public function index()
    {
        return response()->json(CustomerDetail::all(), 200);
    }

    // Store data
    public function store(Request $request)
    { 
        $validated = $request->validate([
            'customer_id' => 'required|integer',
            'given_name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:50',
            'phone_number' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'post_code' => 'nullable|string|max:20',
            'passport_number' => 'nullable|string|max:100',
            'passport_expiry_date' => 'nullable|date',
            'passport_document_url' => 'nullable|string',
            'visa_document' => 'nullable|string',
            'profile_image' => 'nullable|string',
        ]);

        $customer = CustomerDetail::create($validated);
        return response()->json([
            'message' => 'Customer detail stored successfully',
            'data' => $customer
        ], 201);
    }

    // Get single customer detail
   public function show($id)
{ 
    $customer = CustomerDetail::where('customer_id', $id)->firstOrFail();

    return response()->json($customer);
}

public function update(Request $request, $id)
{
    $customer = CustomerDetail::find($id);
    if (!$customer) {
        return response()->json(['message' => 'Customer detail not found'], 404);
    }

    try {
        $validated = $request->validate([
            'customer_id' => 'required|integer',
            'given_name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:50',
            'phone_number' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'postcode' => 'nullable|string|max:20', // Changed from post_code to postcode
            'passport' => 'nullable|string|max:100', // Changed from passport_number to passport
            'expire' => 'nullable|date', // Changed from passport_expiry_date to expire
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    }

    // Map frontend field names to database column names
    $mappedData = [
        'customer_id' => $validated['customer_id'],
        'given_name' => $validated['given_name'] ?? null,
        'surname' => $validated['surname'] ?? null,
        'gender' => $validated['gender'] ?? null,
        'phone_number' => $validated['phone_number'] ?? null,
        'date_of_birth' => $validated['date_of_birth'] ?? null,
        'nationality' => $validated['nationality'] ?? null,
        'address' => $validated['address'] ?? null,
        'post_code' => $validated['postcode'] ?? null, // Map postcode to post_code
        'passport_number' => $validated['passport'] ?? null, // Map passport to passport_number
        'passport_expiry_date' => $validated['expire'] ?? null, // Map expire to passport_expiry_date
    ];

    // Handle file uploads with correct field names
    if ($request->hasFile('passport_file')) { // Changed from passport-file to passport_file
        $passportFile = $request->file('passport_file');
        $passportFileName = 'passport_' . time() . '_' . $customer->id . '.' . $passportFile->getClientOriginalExtension();
        $passportPath = $passportFile->storeAs('documents/passports', $passportFileName, 'public');
        $mappedData['passport_document_url'] = asset('storage/' . $passportPath);
    }

    if ($request->hasFile('visa_file')) { // Changed from visa-file to visa_file
        $visaFile = $request->file('visa_file');
        $visaFileName = 'visa_' . time() . '_' . $customer->id . '.' . $visaFile->getClientOriginalExtension();
        $visaPath = $visaFile->storeAs('documents/visas', $visaFileName, 'public');
        $mappedData['visa_document'] = asset('storage/' . $visaPath);
    }

    if ($request->hasFile('profile_image')) { // Changed from profile-image to profile_image
        $profileImage = $request->file('profile_image');
        $profileImageName = 'profile_' . time() . '_' . $customer->id . '.' . $profileImage->getClientOriginalExtension();
        $profilePath = $profileImage->storeAs('profiles', $profileImageName, 'public');
        $mappedData['profile_image'] = asset('storage/' . $profilePath);
    }

    // Handle date formatting if needed
    if (isset($mappedData['date_of_birth']) && $mappedData['date_of_birth']) {
        $mappedData['date_of_birth'] = date('Y-m-d H:i:s', strtotime($mappedData['date_of_birth']));
    }

    if (isset($mappedData['passport_expiry_date']) && $mappedData['passport_expiry_date']) {
        $mappedData['passport_expiry_date'] = date('Y-m-d H:i:s', strtotime($mappedData['passport_expiry_date']));
    }

    $check = $customer->update($mappedData);

    return response()->json([
        'message' => 'Customer detail updated successfully',
        'data' => $customer
    ], 200);
}



    public function destroy($id)
    {
        $customer = CustomerDetail::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer detail not found'], 404);
        }

        $customer->delete();

        return response()->json(['message' => 'Customer detail deleted successfully'], 200);
    }
}
