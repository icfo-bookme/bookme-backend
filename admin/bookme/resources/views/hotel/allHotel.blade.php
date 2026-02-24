<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Hotels</h1>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Popularity Score</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Select Badge</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entry Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entry BY</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($hotels as $index => $hotel)
                                    <tr>
                                        <td class="px-6 py-4">{{ $hotel->id }}</td>
                                        <td class="px-6 py-4">{{ $hotel->name }}</td>
                                        <td class="px-6 py-4">{{ $hotel->star_rating ?? 'N/A' }} Star</td>
                                        <td class="px-6 py-4">
                                            <input type="hidden" name="hotels[{{ $index }}][id]" value="{{ $hotel->id }}">
                                            <select name="hotels[{{ $index }}][is_active]" class="border rounded px-2 py-1">
                                                <option value="1" {{ $hotel->is_active ? 'selected' : '' }}>yes</option>
                                                <option value="0" {{ !$hotel->is_active ? 'selected' : '' }}>no</option>
                                            </select>
                                        </td>
                                        <td  data-order="{{ $hotel->sort_order }}" class="px-6 py-4" >
                                            <input type="number" name="hotels[{{ $index }}][sort_order]" value="{{ $hotel->sort_order }}" class="border rounded px-2 py-1 w-20">
                                        </td>
                                        <td class="px-6 py-4">
                                            <select name="hotels[{{ $index }}][label]" class="form-control">
                                                <option value="">-- Select Label --</option>
                                                @foreach($lavel as $item)
                                                    <option value="{{ $item->name }}" {{ isset($hotel->label) && $hotel->label === $item->name ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-6 py-4">{{ $hotel->created_at->format('d F Y') }}</td>
                                        <td class="px-6 py-4">{{ optional($hotel->user)->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex space-x-2">
                                                <a href="{{ url('/hotel/edit/' . $hotel->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                                    Edit
                                                </a>
                                                <a href="{{ url('hotel/features/' . $hotel->id) }}" class="inline-flex items-center px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm">
                                                    Features
                                                </a>
                                                <a href="{{ url('/rooms/' . $hotel->id) }}" class="inline-flex items-center px-3 py-1 bg-purple-500 text-white rounded hover:bg-purple-600 text-sm">
                                                    Rooms
                                                </a>
                                                <a href="{{ url('/hotel-policies/' . $hotel->id) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded hover:bg-purple-600 text-sm">
                                                    Policy
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
</x-app-layout>
