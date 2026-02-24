<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\BookingOrder;
use App\Models\HotelBookingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingOrderController extends Controller
{
    /**
     * Display a list of all booking orders with details and rooms
     */
    public function index(Request $request)
{ 
    $start = $request->input('start', 0);
    $length = $request->input('length', 10);
    $searchValue = $request->input('search.value', '');
    
    // Get filters from URL parameters
    $statusFilter = $request->input('status');
    $checkInDateFilter = $request->input('checkin');

 

    $query = BookingOrder::with(['bookingDetails.room.hotel'])
                ->where('service_category_id', 3);

    // Apply status filter if provided
    if (!empty($statusFilter) && $statusFilter !== '') {
        $query->where('order_status', $statusFilter);
    }

    // Apply check-in date filter if provided
    if (!empty($checkInDateFilter) && $checkInDateFilter !== '') {
        $query->whereHas('bookingDetails', function($q) use ($checkInDateFilter) {
            $q->whereDate('check_in_date', $checkInDateFilter);
        });
    }

    // Apply search filter
    if (!empty($searchValue)) {
        $query->where(function($q) use ($searchValue) {
            $q->where('orderno', 'like', "%{$searchValue}%")
              ->orWhere('customer_name', 'like', "%{$searchValue}%")
              ->orWhere('mobile_no', 'like', "%{$searchValue}%")
              ->orWhere('purchaser', 'like', "%{$searchValue}%")
              ->orWhereHas('bookingDetails', function($d) use ($searchValue) {
                  $d->where('room_id', 'like', "%{$searchValue}%")
                    ->orWhereHas('room.hotel', function($h) use ($searchValue) {
                        $h->where('name', 'like', "%{$searchValue}%");
                    });
              });
        });
    }

    // Get total count before pagination
    $total = $query->count();

    // Apply pagination and ordering
    $records = $query->skip($start)
                     ->take($length)
                     ->orderBy('orderno', 'DESC')
                     ->get();

    // Format the data
    $data = $records->map(function($order) {
        $details = $order->bookingDetails->map(function($detail) {
            return [
                 'id'         => $detail->detail_id ?? 'N/A',
                'hotel'         => $detail->room?->hotel?->name ?? 'N/A',
                'hotel_id'         => $detail->room?->hotel?->id ?? 'N/A',
                'room'          => $detail->room?->name ?? 'N/A',
                'check_in_date' => $detail->check_in_date,
                'check_out_date'=> $detail->check_out_date,
                'total_guests'  => $detail->total_guests,
                'total_price'   => $detail->total_price,
            ];
        });

        return [
            'id' => $order->id,
            'orderno' => $order->orderno,
            'order_date' => $order->order_date,
            'customer_name' => $order->customer_name,
            'mobile_no' => $order->mobile_no,
            'purchaser' => $order->purchaser,
            'order_status' => $order->order_status,
            'payment_status' => $order->payment_status,
            'total_payable'  => $order->total_payable,
            'total_paid'  => $order->total_paid,
            'email' => $order->email,
            'verified_by' => $order->verified_by,
            'customer_info' => $order->customer_name . "<br>" . $order->mobile_no,
            'details' => $details,
        ];
    });

    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $total,
        'recordsFiltered' => $total,
        'data' => $data
    ]);
}

 public function showOrders()
    {
        return view('hotel.booking_orders.index');
    }

    /**
     * Show a single booking order with all details
     */
    public function show($id)
    {
        $order = BookingOrder::with('bookingDetails.room')->find($id);

        if (!$order) {
            return redirect()->route('booking_orders.index')
                ->with('error', 'Booking order not found.');
        }

        return view('hotel.booking_orders.show', compact('order'));
    }

    /**
     * Show create booking order form
     */
    public function create()
    {
        return view('hotel.booking_orders.create');
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
            'mobile_no' => 'required|string|max:15',
            'email' => 'required|email',
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

            // Add booking details
            foreach ($request->booking_details as $detail) {
                $bookingOrder->bookingDetails()->create($detail);
            }


            return redirect()->route('hotel.booking_orders.index')
                ->with('success', 'Booking order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()
                ->with('error', 'Failed to create booking order: ' . $e->getMessage());
        }
    }

    /**
     * Show edit booking order form
     */
    public function edit($id)
    {
        $bookingOrder = BookingOrder::with('bookingDetails.room')->find($id);

        if (!$bookingOrder) {
            return redirect()->route('booking_orders.index')
                ->with('error', 'Booking order not found.');
        }

        return view('hotel.booking_orders.edit', compact('bookingOrder'));
    }

    /**
     * Update an existing booking order
     */
     public function update(Request $request, $id)
    { 
        try {
            $bookingOrder = BookingOrder::findOrFail($id);
             $user = Auth::user();
            // Update main booking order
            $bookingOrder->update([
                'orderno' => $request->orderno,
                'order_date' => $request->order_date,
                'customer_name' => $request->customer_name,
                'mobile_no' => $request->mobile_no,
                'purchaser' => $request->purchaser,
                'email' => $request->email,
                'order_status' => $request->order_status,
                'total_payable' => $request->total_payable,
                'total_paid' => $request->total_paid,
                'payment_status' => $request->payment_status,
                'property_id' => $request->booking_details[0]['hotel_id'] ?? null,
                'verified_by' => $user->name ?? null,
            ]);

            // Update booking details
            HotelBookingDetail::where('order_id', $id)->delete();

            foreach ($request->booking_details as $detail) {

                $details = HotelBookingDetail::create([
                    'order_id' => $bookingOrder->orderno,
                    'room_id' => $detail['room_id'],
                    'check_in_date' => $detail['check_in_date'],
                    'check_out_date' => $detail['check_out_date'],
                    'total_guests' => $detail['total_guests'],
                    'total_price' => $detail['total_price'],
                    'price_per_night' => $detail['total_price'], // Simple - same as total price
                ]);
                
            }

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a booking order and its details
     */
    public function destroy($id)
    {
        $bookingOrder = BookingOrder::find($id);

        if (!$bookingOrder) {
            return redirect()->back()
                ->with('error', 'Booking order not found.');
        }

        $bookingOrder->delete();

        return redirect()->route('hotel.booking_orders.index')
            ->with('success', 'Booking order and its details deleted successfully.');
    }
}
