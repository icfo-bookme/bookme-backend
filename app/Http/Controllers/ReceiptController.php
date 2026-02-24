<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\Receipt;
use App\Models\Customer;
use App\Models\ServiceCategory;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\Price;
use App\Models\Discount;
use App\Models\FlightRoute;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\CountryVisa;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Display a listing of receipts.
     */
    public function index()
    {
        $receipts = Receipt::with('customer')->latest()->get();
        return view('receipts.index', compact('receipts'));
    }

    /**
     * Show the form for creating a new receipt.
     */
  public function create()
{
     $services = ServiceCategory::all();
    return view('receipts.create', compact('services'));
}


 public function store(Request $request)
{  
    $validated = $request->validate([
        'customer_id' => 'nullable|integer',
        'customer_name' => 'required|string|max:100',
        'customer_email' => 'nullable|email',
        'customer_phone' => 'nullable|string|max:20',
        'issued_date' => 'required|date',
        'total_payable' => 'required|numeric|min:0',
        'paid_amount' => 'required|numeric|min:0',
        'special_discount' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string',
    ]);

    $validated['generated_by'] = Auth::user()->name ?? 'System';

    try {
        // If customer_id is not provided, try to create a new customer
        if (empty($validated['customer_id'])) {
            $customer = Customer::create([
                'name' => $validated['customer_name'] ?? 'Unknown',
                'email' => $validated['customer_email'] ?? null,
                'phone' => $validated['customer_phone'] ?? null,
                'type' => "Invoice" ?? null,
            ]);
            $validated['customer_id'] = $customer->id;
        }

        // Temporarily assign a non-null receipt number
        $validated['receipt_number'] = 'TEMP';

        // Create receipt
        $receipt = Receipt::create($validated);

        // Generate final receipt number
        $year = now()->year;
        $receipt_number = 'RC-' . $year . '-' . $receipt->id;

        // Update receipt number
        $receipt->update(['receipt_number' => $receipt_number]);

        return redirect()->route('receipts.index', compact('customer'))
            ->with('success', 'Receipt created successfully. Receipt Number: ' . $receipt_number);

    } catch (QueryException $e) {
        // Handle duplicate email error (code 1062)
       if ($e->getCode() == 23000 && str_contains($e->getMessage(), 'Duplicate entry')) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'A customer with this email already exists.');
        }

        // Handle other errors generically
        return redirect()->back()
            ->withInput()
            ->with('error', 'An unexpected error occurred. Please try again.');
    
    }
}
    /**
     * Display the specified receipt.
     */
    public function show(Receipt $receipt)
    {
        return view('receipts.show', compact('receipt'));
    }

    /**
     * Show the form for editing the specified receipt.
     */
    public function edit(Receipt $receipt)
    {
        $customers = Customer::all();
        return view('receipts.edit', compact('receipt', 'customers'));
    }

    /**
     * Update the specified receipt in storage.
     */
    public function update(Request $request, Receipt $receipt)
    {
        $validated = $request->validate([
            'payment_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'receipt_number' => 'required|string|unique:receipts,receipt_number,' . $receipt->id,
            'issued_date' => 'required|date',
            'generated_by' => 'required|string|max:100',
            'total_payable' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'special_discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $receipt->update($validated);

        return redirect()->route('receipts.index')
            ->with('success', 'Receipt updated successfully.');
    }

    /**
     * Remove the specified receipt from storage.
     */
    public function destroy(Receipt $receipt)
    {
        $receipt->delete();

        return redirect()->route('receipts.index')
            ->with('success', 'Receipt deleted successfully.');
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

public function searchProperties(Request $request)
{
    $query = $request->input('q', '');
    $categoryId = $request->input('category_id');

    // If no category is provided, return an empty response
    if (!$categoryId) {
        return response()->json([]);
    }

    // pecial case for Flights (category_id = 2)
    if ($categoryId == "2") {
        $routes = FlightRoute::query()
            ->when($query, function ($q) use ($query) {
                $q->where('origin_city', 'LIKE', "%{$query}%")
                  ->orWhere('destination_city', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get()
            ->map(function ($route) {
                return [
                    'property_id' => $route->id,
                    'property_name' => "{$route->origin_city} - {$route->destination_city}",
                    'price' => $route->base_price,
                ];
            });

        return response()->json($routes);
    }

if ($categoryId == "3") {
    $hotels = Hotel::with('rooms')
        ->where('is_active', 1)
        ->when($query, function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        })
        ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END, sort_order DESC')
        ->get();

    $formatted = $hotels->map(function ($hotel) {
        return [
            'property_id' => $hotel->id,
            'property_name' => $hotel->name,
            'street_address' => $hotel->street_address,
            'star_rating' => $hotel->star_rating,
            'image' => $hotel->main_photo,
        ];
    });

    return response()->json($formatted);
}

if ($categoryId == "4") {
    $countries = CountryVisa::with('properties')
        ->where('is_active', true)
        ->get()
        ->flatMap(function ($country) {
            return $country->properties->map(function ($property) use ($country) {
                return [
                    'property_name' => $country->name, // country name
                    'property_id' => $property->property_id,    
                ];
            });
        });

    return response()->json($countries);
}


    $properties = Property::query()
        ->where('category_id', $categoryId)
        ->where('isactive', 1)
        ->when($query, function ($q) use ($query) {
            $q->where('property_name', 'LIKE', "%{$query}%")
              ;
        })
        ->limit(10)
        ->get(['property_id', 'property_name', 'address', 'district_city', 'price']);

    return response()->json($properties);
}



 /**
 * Get all property units for a specific property with price and discount
 */
public function getPropertyUnits($propertyId, $service_id)
{ 
    try {
       if ($service_id == "3") {
    // Fetch all rooms for the hotel
    $rooms = Room::where('hotel_id', $propertyId)->get();

    // Transform data
    $roomsData = $rooms->map(function ($room) {
        $discountPercent = $room->discouont ?? 0; 
        $currentPrice = $room->price ?? 0;
        $discountAmount = ($currentPrice * $discountPercent) / 100;
        $finalPrice = round($currentPrice - $discountAmount);

        return [
            'unit_id' => $room->id,
            'unit_name' => $room->name,
            'unit_no' => $room->id,
            'unit_category' => 'room',
            'person_allowed' => $room->max_adults,
            'fee_type' => null,
            'current_price' => $currentPrice,
            'round_trip_price' => null,
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
            'final_price' => $finalPrice,
        ];
    });

    return response()->json($roomsData);

}

        
      $units = PropertyUnit::where('property_id', $propertyId)
    ->where('isactive', 1)
    ->orderBy('unit_name')
    ->get(['unit_id', 'unit_name', 'unit_no', 'unit_type', 'unit_category', 'person_allowed', 'fee_type']);

foreach ($units as $unit) {
    // Get first price record
    $price = Price::where('unit_id', $unit->unit_id)->first();

    // Get first discount record
    $discount = Discount::where('unit_id', $unit->unit_id)->first();

    $unit->current_price = $price ? $price->price : 0;
    $unit->round_trip_price = $price ? $price->round_trip_price : 0;

    // Default discount values
    $unit->discount_percent = 0;
    $unit->discount_amount = 0;

    if ($discount) {
        $unit->discount_percent = $discount->discount_percent ?? 0;

        // Always calculate discount amount from percent if percent > 0
        if ($unit->discount_percent > 0) {
            $unit->discount_amount = round($unit->current_price * $unit->discount_percent / 100, 2);
        } else {
            $unit->discount_amount = $discount->discount_amount ?? 0;
        }
    }

    // Calculate final price
    $unit->final_price = round($unit->current_price - $unit->discount_amount, 2);
}

return response()->json($units);


    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to load property units'], 500);
    }
}
    
    
    
}
