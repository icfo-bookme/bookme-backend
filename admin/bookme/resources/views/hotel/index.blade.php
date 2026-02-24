<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Hotels</h1>
                <div class="flex space-x-4">
                    <a href="{{ url('/hotel/') }}" class="inline-flex items-center px-3 py-1 bg-green-900 text-white rounded hover:bg-yellow-600 text-sm">
                        Back To Destination List
                    </a>
                    <a href="{{ url('/hotel/create/' . $id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Add New Hotel
                    </a>
                </div>
            </div>
            

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filter Section -->
            <div class="bg-white shadow rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="rating_filter" class="block text-sm font-medium text-gray-700 mb-1">Filter by Rating</label>
                        <select id="rating_filter" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Ratings</option>
                            <option value="5">5 Star</option>
                            <option value="4">4 Star</option>
                            <option value="3">3 Star</option>
                            <option value="2">2 Star</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>
                    <div>
                        <label for="badge_filter" class="block text-sm font-medium text-gray-700 mb-1">Filter by Badge</label>
                        <select id="badge_filter" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Badges</option>
                            @foreach($lavel as $badge)
                                <option value="{{ $badge->name }}">{{ $badge->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button id="clear_filters" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>

            <form action="{{ route('hotels.bulk-update') }}" method="POST" id="hotels_form">
                @csrf
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table id="example" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hotel Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Is Active</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">popularity score</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Select Badge</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entry Date</th>
                                     <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entry BY</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="hotels_tbody">
                                @foreach($hotels as $index => $hotel)
                                <tr class="hotel-row" 
                                    data-rating="{{ $hotel->star_rating ?? '' }}" 
                                    data-badge="{{ $hotel->label ?? '' }}">
                                    <td class="px-6 py-4">{{ $hotel->id }}</td>
                                    <td class="px-6 py-4">{{ $hotel->name }}</td>
                                    <td class="px-6 py-4">{{ $hotel->star_rating ?? 'N/A' }} Star</td>
                                    <td class="px-6 py-4" >
                                        <input type="hidden" name="hotels[{{ $index }}][id]" value="{{ $hotel->id }}">
                                        <select name="hotels[{{ $index }}][is_active]" class="border rounded px-2 py-1">
                                            <option value="1" {{ $hotel->is_active ? 'selected' : '' }}>yes</option>
                                            <option value="0" {{ !$hotel->is_active ? 'selected' : '' }}>no</option>
                                        </select>
                                    </td>
                                    
                                    <td class="px-6 py-4" data-order="{{ $hotel->sort_order}}">
                                        <input type="number" name="hotels[{{ $index }}][sort_order]" value="{{ $hotel->sort_order }}" class="border rounded px-2 py-1 w-20">
                                    </td>
                                    <td>
                                        <select name="hotels[{{ $index }}][label]" class="form-control">
                                            <option value="">-- Select Label --</option>
                                            @foreach($lavel as $item)
                                                <option value="{{ $item->name }}" 
                                                    {{ isset($hotel->label) && $hotel->label === $item->name ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="px-6 py-4">{{ $hotel->created_at->format('d F Y') }}</td>
<td class="px-6 py-4">{{ optional($hotel->user)->name ?? 'N/A' }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <a href="{{ url('/hotel/edit/' . $hotel->id) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                                Details view & Edit
                                            </a>
                                           
                                            <a href="{{ url('hotel/features/' . $hotel->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-900 text-white rounded hover:bg-yellow-600 text-sm">
                                                Manage Features
                                            </a>
                                            <a href="{{ url('/rooms/' . $hotel->id) }}" class="inline-flex items-center px-3 py-1 bg-green-900 text-white rounded hover:bg-yellow-600 text-sm">
                                                Manage Room
                                            </a>
                                            <a href="{{ url('/hotel-policies/' . $hotel->id) }}" class="inline-flex items-center px-3 py-1 bg-cyan-900 text-white rounded hover:bg-yellow-600 text-sm">
                                                Manage Policy
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Update Selected
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingFilter = document.getElementById('rating_filter');
            const badgeFilter = document.getElementById('badge_filter');
            const clearFiltersBtn = document.getElementById('clear_filters');
            const hotelRows = document.querySelectorAll('.hotel-row');

            // Filter hotels when dropdown changes
            ratingFilter.addEventListener('change', filterHotels);
            badgeFilter.addEventListener('change', filterHotels);

            // Clear filters
            clearFiltersBtn.addEventListener('click', function() {
                ratingFilter.value = '';
                badgeFilter.value = '';
                filterHotels();
            });

            function filterHotels() {
                const selectedRating = ratingFilter.value;
                const selectedBadge = badgeFilter.value;

                hotelRows.forEach(row => {
                    const rowRating = row.getAttribute('data-rating');
                    const rowBadge = row.getAttribute('data-badge');

                    const ratingMatch = !selectedRating || rowRating === selectedRating;
                    const badgeMatch = !selectedBadge || rowBadge === selectedBadge;

                    if (ratingMatch && badgeMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });
    </script>
</x-app-layout>