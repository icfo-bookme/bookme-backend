<x-app-layout>
<div class="container mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Edit Itineraries</h2>
 <a
        href="/admin/tour%20packages/properties/{{ $destination_id }}"
        class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition-colors duration-200"
    >
        Back to Properties
    </a>
    @foreach ($itineraries as $dayno => $dayItineraries)
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Day {{ $dayno }}</h3>
            <div class="space-y-2">
                @foreach ($dayItineraries as $itinerary)
                    <div class="flex items-center justify-between bg-gray-100 p-4 rounded shadow">
                        <div>
                            <p><strong>Time:</strong> {{ $itinerary->time }}</p>
                            <p><strong>Name:</strong> {{ $itinerary->name }}</p>
                            <p><strong>Location:</strong> {{ $itinerary->location }}</p>
                            <p><strong>Duration:</strong> {{ $itinerary->duration }}</p>
                        </div>

                        <!-- Button triggers modal -->
                        <label for="modal-{{ $itinerary->id }}"
                               class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2 cursor-pointer">
                            Edit
                        </label>

                        <!-- Hidden checkbox to open modal -->
                        <input type="checkbox" id="modal-{{ $itinerary->id }}" class="modal-toggle hidden">

                        <!-- Modal -->
                        <div class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[80vh] overflow-y-auto">
                                <div class="flex items-start justify-between p-4 border-b">
                                    <h3 class="text-xl font-semibold">Edit Itinerary</h3>
                                    <label for="modal-{{ $itinerary->id }}" class="cursor-pointer text-gray-500">✕</label>
                                </div>
                                <form action="{{ route('itineraries.update', $itinerary->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label class="block mb-1 text-sm font-medium">Day</label>
                                        <input type="text" name="dayno" value="{{ old('dayno', $itinerary->dayno) }}" class="input-text" required>
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-sm font-medium">Time</label>
                                        <input type="text" name="time" value="{{ old('time', $itinerary->time) }}" class="input-text" required>
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-sm font-medium">Name</label>
                                        <input type="text" name="name" value="{{ old('name', $itinerary->name) }}" class="input-text" required>
                                    </div>
                                     <div>
                                        <label class="block mb-1 text-sm font-medium">Description</label>
                                        <input type="text" name="value" value="{{ old('value', $itinerary->value) }}" class="input-text" >
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-sm font-medium">Location</label>
                                        <input type="text" name="location" value="{{ old('location', $itinerary->location) }}" class="input-text" >
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-sm font-medium">Duration</label>
                                        <input type="text" name="duration" value="{{ old('duration', $itinerary->duration) }}" class="input-text" >
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-sm font-medium">Image</label>
                                        <input type="file" name="image" class="input-text">
                                        @if($itinerary->image)
                                            <img src="{{ asset('/bookme/public/' . $itinerary->image) }}" alt="Itinerary Image" class="mt-2 w-32 h-32 object-cover rounded">
                                        @endif
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- End modal -->
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<style>
.input-text {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 0.375rem;
}

/* Modal toggle */
.modal-toggle:checked + .modal {
    display: flex;
}

/* Modal scroll for long content */
.modal > div {
    overflow-y: auto;
    padding-right: 1rem; /* space for scrollbar */
}
</style>
</x-app-layout>
