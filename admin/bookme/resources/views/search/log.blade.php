<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Search Results</h1>
            @if($user)
    <table class="table-auto border border-gray-300 w-full text-left">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border">Customer Name</th>
                <th class="px-4 py-2 border">Phone</th>
                <th class="px-4 py-2 border">Email</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="px-4 py-2 border">{{ $user->name }}</td>
                <td class="px-4 py-2 border">{{ $user->phone }}</td>
                <td class="px-4 py-2 border">{{ $user->email }}</td>
            </tr>
        </tbody>
    </table>
@endif

        </div>

        <!-- Hotel Orders Section -->
        @if($hotel_orders->count() > 0)
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Hotel Bookings</h2>
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $hotel_orders->count() }} booking{{ $hotel_orders->count() > 1 ? 's' : '' }}
                    </span>
                </div>
                
                <div class="space-y-6">
                    @foreach($hotel_orders as $order)
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                            <!-- Order Header -->
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                                <div class="flex flex-col md:flex-row md:items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800">Order #{{ $order->orderno }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Booked on {{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}
                                        </p>
                                    </div>
                                    <div class="mt-2 md:mt-0">
                                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                                            {{ $order->order_status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                               ($order->order_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                        <span class="inline-block ml-2 px-3 py-1 text-sm font-semibold rounded-full
                                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Details -->
                            <div class="p-6">
                                <div class="">
                                    <div class="space-y-2 grid grid-cols-1 md:grid-cols-2">
                                        <p class="text-gray-700">
                                            <span class="font-semibold text-gray-800">Customer:</span>
                                            {{ $order->customer_name ?? 'N/A' }}
                                        </p>
                                        <p class="text-gray-700">
                                            <span class="font-semibold text-gray-800">Mobile:</span>
                                            {{ $order->mobile_no }}
                                        </p>
                                    </div>
                                    
                                </div>

                                <!-- Booking Details -->
                                @if($order->bookingDetails->count() > 0)
                                    <div class="mt-6">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                                            Room Bookings
                                        </h4>
                                        <div class="space-y-4">
                                            @foreach($order->bookingDetails as $detail)
                                                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                                        <!-- Room Information -->
                                                        <div class="space-y-3">
                                                            <div>
                                                                <h5 class="font-semibold text-gray-800 text-lg">{{ $detail->room->name ?? 'N/A' }}</h5>
                                                                @if(isset($detail->room->hotel))
                                                                    <p class="text-blue-600 font-medium">
                                                                        {{ $detail->room->hotel->name }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                            <div class="grid grid-cols-3 gap-4">
                                                                <div>
                                                                    <p class="text-sm text-gray-600 font-medium">Check-in</p>
                                                                    <p class="font-semibold text-gray-800">
                                                                        {{ \Carbon\Carbon::parse($detail->check_in_date)->format('d M, Y') }}
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm text-gray-600 font-medium">Check-out</p>
                                                                    <p class="font-semibold text-gray-800">
                                                                        {{ \Carbon\Carbon::parse($detail->check_out_date)->format('d M, Y') }}
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                <p class="text-sm text-gray-600 font-medium">Guests</p>
                                                                <p class="font-semibold text-gray-800">{{ $detail->total_guests }} Person(s)</p>
                                                            </div>
                                                            </div>
                                                            
                                                        </div>

                                                        <!-- Pricing Information -->
                                                        <div class="space-y-3">
                                                            <div class="flex justify-between items-center">
                                                                <span class="text-gray-600">Price per night:</span>
                                                                <span class="font-semibold text-gray-800">৳{{ number_format($detail->price_per_night, 2) }}</span>
                                                            </div>
                                                            @if($detail->discount_amount > 0)
                                                                <div class="flex justify-between items-center">
                                                                    <span class="text-gray-600">Discount:</span>
                                                                    <span class="font-semibold text-red-600">-৳{{ number_format($detail->discount_amount, 2) }}</span>
                                                                </div>
                                                            @endif
                                                            <div class="flex justify-between items-center pt-3 border-t border-gray-300">
                                                                <span class="text-lg font-semibold text-gray-800">Total Price:</span>
                                                                <span class="text-xl font-bold text-blue-600">৳{{ number_format($detail->total_price, 2) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Activities Orders Section -->
        @if($activities_orders->count() > 0)
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Activity Bookings</h2>
                    <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $activities_orders->count() }} booking{{ $activities_orders->count() > 1 ? 's' : '' }}
                    </span>
                </div>
                
                <div class="space-y-6">
                    @foreach($activities_orders as $order)
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                            <!-- Order Header -->
                            <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-b border-green-200">
                                <div class="flex flex-col md:flex-row md:items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800">Order #{{ $order->orderno }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Booked on {{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}
                                        </p>
                                    </div>
                                    <div class="mt-2 md:mt-0">
                                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                                            {{ $order->order_status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                               ($order->order_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                        <span class="inline-block ml-2 px-3 py-1 text-sm font-semibold rounded-full
                                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Details -->
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <div class="space-y-2">
                                        <p class="text-gray-700">
                                            <span class="font-semibold text-gray-800">Customer:</span>
                                            {{ $order->customer_name ?? 'N/A' }}
                                        </p>
                                        
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-gray-700">
                                            <span class="font-semibold text-gray-800">Mobile:</span>
                                            {{ $order->mobile_no }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Activity Details -->
                                @if($order->activitieDetails->count() > 0)
                                    <div class="mt-6">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                                            Activity Details
                                        </h4>
                                        <div class="space-y-4">
                                            @foreach($order->activitieDetails as $detail)
                                                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                                        <!-- Activity Information -->
                                                        <div class="space-y-4">
                                                            <div>
                                                                <h5 class="font-semibold text-gray-800 text-lg">{{ $detail->package_name }}</h5>
                                                                <p class="text-green-600 font-medium text-sm">Activity Package</p>
                                                            </div>
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <div>
                                                                    <p class="text-sm text-gray-600 font-medium">Activity Date</p>
                                                                    <p class="font-semibold text-gray-800">
                                                                        {{ \Carbon\Carbon::parse($detail->activity_date)->format('d M, Y') }}
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm text-gray-600 font-medium">Activity Time</p>
                                                                    <p class="font-semibold text-gray-800">
                                                                        {{ \Carbon\Carbon::parse($detail->activity_time)->format('h:i A') }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="space-y-2 grid grid-cols-2">
                                                                <div>
                                                                    <p class="text-sm text-gray-600 font-medium">Participants</p>
                                                                    <p class="font-semibold text-gray-800">{{ $detail->total_guests }} Person(s)</p>
                                                                </div>
                                                                @if($detail->pickup_location)
                                                                    <div>
                                                                        <p class="text-sm text-gray-600 font-medium">Pickup Location</p>
                                                                        <p class="font-semibold text-gray-800 text-sm">{{ $detail->pickup_location }}</p>
                                                                    </div>
                                                                @endif
                                                                @if($detail->special_requests)
                                                                    <div>
                                                                        <p class="text-sm text-gray-600 font-medium">Special Requests</p>
                                                                        <p class="font-semibold text-gray-800 text-sm">{{ $detail->special_requests }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <!-- Pricing Information -->
                                                        <div class="space-y-3">
                                                            <div class="flex justify-between items-center">
                                                                <span class="text-gray-600">Base Price:</span>
                                                                <span class="font-semibold text-gray-800">৳{{ number_format($detail->base_price, 2) }}</span>
                                                            </div>
                                                            @if($detail->discount_amount > 0)
                                                                <div class="flex justify-between items-center">
                                                                    <span class="text-gray-600">Discount ({{ $detail->discount_percent }}%):</span>
                                                                    <span class="font-semibold text-red-600">-৳{{ number_format($detail->discount_amount, 2) }}</span>
                                                                </div>
                                                            @endif
                                                            <div class="flex justify-between items-center pt-3 border-t border-gray-300">
                                                                <span class="text-lg font-semibold text-gray-800">Final Price:</span>
                                                                <span class="text-xl font-bold text-green-600">৳{{ number_format($detail->final_price, 2) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- No Results Message -->
        @if($hotel_orders->count() == 0 && $activities_orders->count() == 0)
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="text-gray-400 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-3">No Bookings Found</h3>
                    <p class="text-gray-600 mb-8">No hotel or activity bookings were found for the provided phone number.</p>
                    <a href="/admin/dashboard" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Search
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>