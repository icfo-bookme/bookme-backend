<x-app-layout>
    <div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
        <div class = "flex justify-between">
        <h2 class="text-2xl font-bold mb-6">Select Hotel Facilities by Category</h2>
<a href="{{ url('/hotel/' . $destination_id) }}" class="inline-flex items-center px-3 py-1 bg-green-900 text-white rounded hover:bg-yellow-600 text-sm">
                                           Back To Hotel List
                                        </a></div>
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

        <form action="{{ route('hotel_features.store') }}" method="POST">
            @csrf
            <input type="hidden" name="hotel_id" value="{{ $hotelId }}">

            @foreach ($hotelFeatures as $category)
                <h3 class="text-xl font-semibold mt-6 mb-2 text-blue-700 border-b pb-1">{{ $category->name }}</h3>

                <div class="grid grid-cols-3 font-semibold text-gray-700 border-b pb-2 mb-3">
                    <div>Feature Name</div>
                    <div>Is Facility</div>
                    <div>Is Facility Summary</div>
                </div>

                @foreach ($category->feature as $feature)
                    @php
                        $existing = $existingFeatures[$feature->id] ?? null;
                        $isFeature = $existing ? (bool) $existing->isfeature : true;

                        // ফিচারের নামগুলো ছোট হরফে যাচাই করতে
                        $defaultSummaryFeatures = ['telephone', 'elevator', 'smoke detector', 'air conditioning', 'couple friendly'];

                        // যেকোনো কেস (case-insensitive) অনুসারে মিলিয়ে চেক করা
                        $isDefaultSummary = in_array(strtolower(trim($feature->name)), $defaultSummaryFeatures);

                        // যদি ডাটাবেজে আগে থেকেই selected থাকে, তাহলে সেটি থাকবে
                        $isSummary = $existing ? (bool) $existing->isfeature_summary : $isDefaultSummary;
                    @endphp

                    <div class="grid grid-cols-3 items-center py-2 border-b">
                        <div>{{ $feature->name }}</div>

                        <div>
                            <input 
                                type="checkbox" 
                                name="features[{{ $feature->id }}][isfeature]" 
                                {{ $isFeature ? 'checked' : '' }}
                                class="w-5 h-5"
                            >
                        </div>

                        <div>
                            <input 
                                type="checkbox" 
                                name="features[{{ $feature->id }}][isfeature_summary]" 
                                {{ $isSummary ? 'checked' : '' }}
                                class="w-5 h-5"
                            >
                        </div>

                        <input type="hidden" name="features[{{ $feature->id }}][feature_id]" value="{{ $feature->id }}">
                    </div>
                @endforeach
            @endforeach

            <button type="submit" class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                Save Facilities
            </button>
        </form>
    </div>
</x-app-layout>
