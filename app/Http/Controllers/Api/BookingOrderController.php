<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookingOrder;
use App\Models\Notification;
use App\Models\HotelBookingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class BookingOrderController extends Controller
{
   public function showHotelOrder($id)
{
    $hotel_orders = BookingOrder::with(['bookingDetails.room.hotel'])
        ->where('service_category_id', 3)
        ->where('customerid', $id)
        ->get();
        
    $bookings = $hotel_orders->map(function ($order) {
        return $order->bookingDetails->map(function ($detail) use ($order) {
            return [
                'id' => $order->orderno,
                'hotelName' => $detail->room->hotel->name ?? 'Unknown Hotel',
                'location' => $detail->room->hotel->street_address ?? 'Unknown Location',
                'checkIn' => $detail->check_in_date,
                'checkOut' => $detail->check_out_date,
                'nights' => \Carbon\Carbon::parse($detail->check_in_date)
                        ->diffInDays(\Carbon\Carbon::parse($detail->check_out_date)),
                'guests' => $detail->total_guests,
                'rooms' => 1,
                'roomType' => $detail->room->name ?? 'Standard',
                'totalAmount' => $detail->total_price,
                'pricePerNight' => $detail->price_per_night,
                'specialRequests' => $detail->special_requests,
                'status' => $order->order_status,
                'paymentStatus' => $order->payment_status,
                'bookingDate' => $order->order_date,
                
            ];
        });
    })->flatten(1);

    // Updated grouping: upcoming = confirmed + pending
    $grouped = [
        'upcoming' => $bookings->whereIn('status', ['confirmed', 'pending'])->values(),
        'completed' => $bookings->where('status', 'completed')->values(),
        'cancelled' => $bookings->where('status', 'cancelled')->values(),
    ];

    return response()->json($grouped);
}


    /**
     * Display a list of all booking orders with details and rooms
     */
     
    public function index()
    {
        $orders = BookingOrder::with('bookingDetails.room')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ], 200);
    }

    /**
     * Show a single booking order with all details
     */
    public function show($id)
    {
        $order = BookingOrder::with('bookingDetails.room')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Booking order not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ], 200);
    }

    /**
     * Store a new booking order with multiple booking details
     */
    public function store(Request $request)
    { 
        $request->validate([
            'order_date' => 'required|date',
            'customerid' => 'nullable|integer',
            'customer_name' => 'nullable|string|max:255',
            'purchaser_name' => 'nullable|string|max:255',
            'mobile_no' => 'required|string',
            'email' => 'nullable|email',
            'order_status' => 'required|string',
            'payment_status' => 'required|string',
            'property_id' => 'required|integer',
            'service_category_id' => 'required|integer',

            // Booking details validation
            'booking_details' => 'required|array|min:1',
            'booking_details.*.room_id' => 'required|integer',
            'booking_details.*.check_in_date' => 'required|date',
            'booking_details.*.check_out_date' => 'required|date|after:booking_details.*.check_in_date',
            'booking_details.*.total_guests' => 'required|integer|min:1',
            'booking_details.*.price_per_night' => 'required|numeric|min:0',
            'booking_details.*.total_price' => 'required|numeric|min:0',
            'booking_details.*.special_requests' => 'nullable|string'
        ]);

       

        try {
            // Create booking order
            $bookingOrder = BookingOrder::create([
                'order_date' => $request->order_date,
                'customerid' => $request->customerid ?? null,
                'purchaser' => $request->purchaser_name ?? null,
                'customer_name' => $request->customer_name,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'order_status' => $request->order_status,
                'payment_status' => $request->payment_status,
                'property_id' => $request->property_id,
                'service_category_id' => $request->service_category_id,
            ]);

            foreach ($request->booking_details as $detail) {
    
    $checkIn = \Carbon\Carbon::parse($detail['check_in_date']);
    $checkOut = \Carbon\Carbon::parse($detail['check_out_date']);
    $totalNights = $checkOut->diffInDays($checkIn);

    $detail['total_price'] = $totalNights * $detail['price_per_night'];

    // Save the detail
    $bookingOrder->bookingDetails()->create($detail);
}

        $user = Customer::where('phone', $request->mobile_no)
                ->orWhere('email', $request->email)
                ->first();
                
        Notification::create([
                 'notification' => "$request->customer_name booked New Hotels",
                 'redirectUrl' => "/booking/orders"
                 ]);


        if (!$user) {
            $user = Customer::create([
                'name' => $request->customer_name,
                'email' => $request->email ?? null,
                'password' => null,
                'phone' => $request->mobile_no,
                'type' => "Guest Order",
            ]);
        }

            return response()->json([
                'success' => true,
                'message' => 'Booking order created successfully',
                'data' => $bookingOrder->load('bookingDetails.room')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing booking order
     */
    public function update(Request $request, $id)
    {
        $bookingOrder = BookingOrder::find($id);

        if (!$bookingOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Booking order not found'
            ], 404);
        }

        $request->validate([
            'order_status' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'customer_name' => 'nullable|string|max:255',
            'mobile_no' => 'nullable|string|max:15',
            'email' => 'nullable|email',
        ]);

        $bookingOrder->update($request->only([
            'order_status',
            'payment_status',
            'customer_name',
            'mobile_no',
            'email'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Booking order updated successfully',
            'data' => $bookingOrder
        ], 200);
    }

    /**
     * Delete a booking order and its details
     */
    public function destroy($id)
    {
        $bookingOrder = BookingOrder::find($id);

        if (!$bookingOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Booking order not found'
            ], 404);
        }

        $bookingOrder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking order and its details deleted successfully'
        ], 200);
    }
    
    public function bookingItem(){
        
        
    }
    
    public function AcrivityOrderStore(Request $request)
{
    
    try {
      
        $validated =  $request->validate([
        // Booking Order validation
     
        'order_date' => 'required|date',
        'customerid' => 'nullable|integer',
        'customer_name' => 'required|string|max:255',
        'mobile_no' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'order_status' => 'required|string',
        'payment_status' => 'required|string',
        'property_id' => 'required|integer',
        'service_category_id' => 'required|integer',

        // Activity Order Detail validation
        'package_id' => 'required|integer',
        'package_name' => 'required|string|max:255',
        'base_price' => 'required|numeric',
        'discount_percent' => 'nullable|numeric',
        'discount_amount' => 'nullable|numeric',
        'final_price' => 'required|numeric',
        'activity_date' => 'required|date',
        'activity_time' => 'required',
        'total_guests' => 'required|integer|min:1',
        'pickup_location' => 'nullable|string|max:255',
        'special_requests' => 'nullable|string',
    ]);

        

    } catch (\Illuminate\Validation\ValidationException $e) {
        
        dd($e->errors()); // This will show the validation error messages
    }
   


    try {
      
        $bookingOrder = BookingOrder::create([
            'orderno' => $request->orderno,
            'order_date' => $request->order_date,
            'customerid' => $request->customerid,
            'customer_name' => $request->customer_name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
            'property_id' => $request->property_id,
            'service_category_id' => $request->service_category_id,
        ]);


        $activityDetail = \App\Models\ActivitiesOrderDetail::create([
            'order_id' => $bookingOrder->orderno,
            'package_id' => $request->package_id,
            'package_name' => $request->package_name,
            'base_price' => $request->base_price,
            'discount_percent' => $request->discount_percent ?? 0,
            'discount_amount' => $request->discount_amount ?? 0,
            'final_price' => $request->final_price,
            'activity_date' => $request->activity_date,
            'activity_time' => $request->activity_time,
            'total_guests' => $request->total_guests,
            'pickup_location' => $request->pickup_location,
            'special_requests' => $request->special_requests,
        ]);
        $user = Customer::where('phone', $request->mobile_no)->first();

        if (!$user) {
            $user = Customer::create([
                'name' => $request->customer_name,
                'email' => $request->email ?? null,
                'password' => null,
                'phone' => $request->mobile_no,
                'type' => "Guest Order",
            ]);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Booking and activity details created successfully.',
            'data' => [
                'booking_order' => $bookingOrder,
                'activity_detail' => $activityDetail
            ]
        ], 201);
    } catch (\Exception $e) {
      

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong while saving the order.',
            'error' => $e->getMessage()
        ], 500);
    }}
    
        public function checkNewOrders()
        {
            $newOrders = BookingOrder::where('order_status', 'pending')->count();
        
            return response()->json([
                'newOrders' => $newOrders
            ]);
        }



    
}







