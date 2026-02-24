<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex items-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Pickup Location Management</h1>
            <a
    href="/admin/activities/properties/{{$property->destination_id}}"
    class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition-colors duration-200"
  >
    Back to Properties
  </a>

            <div class="float-right">
                <button data-modal-target="pickup-location-modal" data-modal-toggle="pickup-location-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Add Pickup Location
                </button>
            </div>
        </div>

        <!-- Modal -->
        <div id="pickup-location-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">Add New Pickup Location(s)</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="pickup-location-modal">
                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('pickup_locations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property_id }}">

                        <div class="p-4 md:p-5 space-y-4">
                            <div id="destination-fields">
                                <div class="form-group mb-4 destination-group">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Destination <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="destination[]" required
                                        class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                                </div>
                            </div>

                            <!-- Add More Button -->
                            <button type="button" onclick="addDestinationField()"
                                class="text-sm text-blue-600 hover:underline">+ Add More Destination</button>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex items-center px-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Save Location(s)
                            </button>
                            <button type="button" data-modal-hide="pickup-location-modal"
                                class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Feedback -->
        <div class="w-[90%] mt-12 mx-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table -->
            <table id="example" class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Destination</th>
                        
                       
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($locations as $location)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('pickup_locations.update', $location->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <td class="px-4 py-2 border">{{ $location->id }}</td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="destination" value="{{ $location->destination }}"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                            </td>
                           
                            
                            <td class="px-4 py-2 border flex space-x-2">
                                <button type="button" onclick="enableEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                        </form>
                        <form action="{{ route('pickup_locations.destroy', $location->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function enableEdit(button) {
            const row = button.closest('tr');
            row.querySelectorAll('input').forEach(input => input.disabled = false);
            button.classList.add('hidden');
            row.querySelector('.save-button').classList.remove('hidden');
        }

        function addDestinationField() {
            const container = document.getElementById('destination-fields');
            const field = document.createElement('div');
            field.classList.add('form-group', 'mb-4', 'destination-group');
            field.innerHTML = `
                <input type="text" name="destination[]" required
                    class="mt-1 p-2 border border-gray-300 rounded-md w-full">
            `;
            container.appendChild(field);
        }
    </script>
</x-app-layout>
