<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Itineraries for Property ID: {{ $property_id }}
        </h2>
    </x-slot>
     <a
        href="/admin/tour%20packages/properties/{{ $destination_id }}"
        class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition-colors duration-200"
    >
        Back to Properties
    </a>
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
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Itinerary</h3>
                                                <a href="/admin/itineraries/edit/{{$property_id}}"
                                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-500  save-button">See details & edit</button></a>

                <form id="itineraryForm" action="{{ route('itineraries.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="property_id" value="{{ $property_id }}">

                    <div id="itineraryFields">
                        <!-- Initial itinerary item -->
                        <div class="itinerary-item mb-6 border border-gray-200 rounded p-4 relative" data-index="0">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center">
                                    <span class="font-semibold mr-2">Day:</span>
                                    <input type="number" name="itineraries[0][dayno]" value="1" min="1" 
                                           class="day-input w-16 border-gray-300 rounded-md shadow-sm">
                                </div>
                                <button type="button" class="removeItineraryBtn bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm">
                                    Remove
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-medium text-gray-700">Time</label>
                                    <input type="time" name="itineraries[0][time]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>

                                <div>
                                    <label class="block font-medium text-gray-700">Name</label>
                                    <input type="text" name="itineraries[0][name]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block font-medium text-gray-700">Description</label>
                                    <textarea name="itineraries[0][value]" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                </div>

                                <div>
                                    <label class="block font-medium text-gray-700">Location</label>
                                    <input type="text" name="itineraries[0][location]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>

                                <div>
                                    <label class="block font-medium text-gray-700">Duration</label>
                                    <input type="text" name="itineraries[0][duration]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block font-medium text-gray-700">Image</label>
                                    <input type="file" name="itineraries[0][image]" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <p class="mt-1 text-sm text-gray-500">Upload an image for this itinerary item</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 mt-6">
                        <button type="button" id="addSameDayBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
                            Add Item to Same Day
                        </button>
                        <button type="button" id="addNewDayBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                            Add New Day
                        </button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded ml-auto">
                            Save All Itineraries
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemCount = 0;
            const itineraryFields = document.getElementById('itineraryFields');

            // Add item to same day
            document.getElementById('addSameDayBtn').addEventListener('click', function() {
                const lastItem = itineraryFields.lastElementChild;
                const dayNo = lastItem.querySelector('.day-input').value;
                addItineraryItem(dayNo);
            });

            // Add new day (next day number)
            document.getElementById('addNewDayBtn').addEventListener('click', function() {
                const lastItem = itineraryFields.lastElementChild;
                const dayNo = parseInt(lastItem.querySelector('.day-input').value) + 1;
                addItineraryItem(dayNo);
            });

            // Add itinerary item function
            function addItineraryItem(dayNo) {
                itemCount++;
                const newIndex = itemCount;
                
                const newItem = document.createElement('div');
                newItem.classList.add('itinerary-item', 'mb-6', 'border', 'border-gray-200', 'rounded', 'p-4', 'relative');
                newItem.dataset.index = newIndex;
                
                newItem.innerHTML = `
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <span class="font-semibold mr-2">Day:</span>
                            <input type="number" name="itineraries[${newIndex}][dayno]" value="${dayNo}" min="1" 
                                   class="day-input w-16 border-gray-300 rounded-md shadow-sm">
                        </div>
                        <button type="button" class="removeItineraryBtn bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm">
                            Remove
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-gray-700">Time</label>
                            <input type="time" name="itineraries[${newIndex}][time]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700">Name</label>
                            <input type="text" name="itineraries[${newIndex}][name]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium text-gray-700">Description</label>
                            <textarea name="itineraries[${newIndex}][value]" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700">Location</label>
                            <input type="text" name="itineraries[${newIndex}][location]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700">Duration</label>
                            <input type="text" name="itineraries[${newIndex}][duration]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium text-gray-700">Image</label>
                            <input type="file" name="itineraries[${newIndex}][image]" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <p class="mt-1 text-sm text-gray-500">Upload an image for this itinerary item</p>
                        </div>
                    </div>
                `;

                itineraryFields.appendChild(newItem);
                
                // Add event listener to the new remove button
                newItem.querySelector('.removeItineraryBtn').addEventListener('click', function() {
                    newItem.remove();
                });
            }

            // Add event listeners to existing remove buttons
            document.querySelectorAll('.removeItineraryBtn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.itinerary-item').remove();
                });
            });
        });
    </script>
</x-app-layout>