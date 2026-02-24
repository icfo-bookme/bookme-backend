<x-app-layout>
    <div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Select Room Facilitiy by Category</h2>
        <a href="{{ url('/rooms/' . $hotel_id) }}" class="inline-flex items-center px-3 py-1 bg-green-900 text-white rounded hover:bg-yellow-600 text-sm">
            Back To Room List
        </a>
        <form action="{{ route('room_features.store') }}" method="POST">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room_id }}">

            <!-- Insert this note right below the form tag -->
            <p class="text-sm text-gray-600 italic mb-4">
                Note: By default, 3 features (Room Service, Toiletries, TV) are selected as summary features. However, these selections are fully customizable — you may select or deselect any features as needed.
            </p>

            @foreach ($roomFeature as $category)
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

                        // Only 3 default summary features
                        $defaultSummaryFeatures = [
                            'room service',
                            'toiletries',
                            'tv',
                        ];

                        $featureName = strtolower(trim($feature->name));
                        $isDefaultSummary = in_array($featureName, $defaultSummaryFeatures);

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

                        <input 
                            type="hidden" 
                            name="features[{{ $feature->id }}][feature_id]" 
                            value="{{ $feature->id }}"
                        >
                    </div>
                @endforeach
            @endforeach

            <button type="submit" class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                Save Features
            </button>
        </form>
    </div>
</x-app-layout>
