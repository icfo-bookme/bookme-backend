<?php

namespace App\Http\Controllers\Api;

use App\Models\CartSession;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartSessionController extends Controller
{
    // Get all cart sessions
    public function index()
    {
        return response()->json(CartSession::all());
    }

    // Store a new cart session
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|integer',
            'pickup_location' => 'nullable|string|max:255',
            'total_guest' => 'nullable|integer',
            'date' => 'nullable|date',
            'time' => 'nullable',
        ]);

        $cartSession = CartSession::create($validated);

        return response()->json($cartSession, 201);
    }

// Show a specific cart session
public function show($id)
{
    // Find the cart session
    $cartSession = CartSession::find($id);

    if (!$cartSession) {
        return response()->json([
            'status' => 'error',
            'message' => 'Cart session not found',
        ], 404);
    }

    // Load related property unit with price and discount
    $propertyUnit = PropertyUnit::with(['priceSingle', 'discount'])->find($cartSession->item_id);

    if (!$propertyUnit) {
        return response()->json([
            'status' => 'error',
            'message' => 'Property unit not found',
        ], 404);
    }

    // Fetch the related property
    $property = Property::find($propertyUnit->property_id);

    // Extract price and discount details safely
    $basePrice = (float) ($propertyUnit->priceSingle->price ?? 0);
    $discountAmount = (float) ($propertyUnit->discount->discount_amount ?? 0);
    $discountPercent = (float) ($propertyUnit->discount->discount_percent ?? 0);

    // Calculate the final price
    if ($discountPercent > 0) {
        $finalPrice = $basePrice - ($basePrice * ($discountPercent / 100));
    } else {
        $finalPrice = $basePrice - $discountAmount;
    }

    $finalPrice = max($finalPrice, 0); // Prevent negative prices

    return response()->json([
        'status' => 'success',
        'data' => [
            'cart_session' => [
                'id' => $cartSession->id,
                'item_id' => $cartSession->item_id,
                'pickup_location' => $cartSession->pickup_location,
                'total_guest' => (int) $cartSession->total_guest,
                'date' => $cartSession->date,
                'time' => $cartSession->time,
                'created_at' => $cartSession->created_at,
                'updated_at' => $cartSession->updated_at,
            ],
            'property' => [
                'id' => $property?->property_id,
                'name' => $property?->property_name,
            ],
            'package' => [
                'name' => $propertyUnit->unit_name,
                'base_price' => number_format($basePrice, 2, '.', ''),
                'discount_percent' => $discountPercent,
                'discount_amount' => number_format($discountAmount, 2, '.', ''),
                'final_price' => number_format($finalPrice, 2, '.', ''),
            ]
        ]
    ]);
}


    // Update a cart session
    public function update(Request $request, $id)
    {
        $cartSession = CartSession::find($id);

        if (!$cartSession) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validated = $request->validate([
            'item_id' => 'sometimes|integer',
            'pickup_location' => 'sometimes|string|max:255',
            'total_guest' => 'sometimes|integer',
            'date' => 'sometimes|date',
            'time' => 'sometimes|date_format:H:i:s',
        ]);

        $cartSession->update($validated);

        return response()->json($cartSession);
    }

    // Delete a cart session
    public function destroy($id)
    {
        $cartSession = CartSession::find($id);

        if (!$cartSession) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $cartSession->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
