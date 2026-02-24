<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex item-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Flight Routes</h1>

            <div class="float-right">
                <!-- Button to Open Modal for Adding Flight Route -->
                <button data-modal-target="flight-route-modal" data-modal-toggle="flight-route-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">
                    Add Flight Route
                </button>
            </div>
        </div>

        <!-- Flowbite Modal for Adding Flight Routes -->
        <div id="flight-route-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow ">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 ">
                            Add Flight Route
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="flight-route-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form action="{{ route('flight-routes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="p-4 md:p-5 space-y-4">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="form-group col-span-2">
  <label for="flight_type" class="block text-sm font-medium text-gray-700">
    Flight Type <span class="text-red-500 font-bold text-2xl">*</span>
  </label>
  <select
    name="flight_type"
    id="flight_type"
    required
    class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
  >
    <option value="">-- Select Flight Type --</option>
    <option value="domestic">Domestic</option>
    <option value="international">International</option>
  </select>
</div>

                                <div class="form-group">
                                    <label for="origin_city" class="block text-sm font-medium text-gray-700">Origin City <span
                                            class="text-red-500 font-bold text-2xl">*</span></label>
                                    <textarea name="origin_city" id="origin_city" rows="2"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="destination_city" class="block text-sm font-medium text-gray-700">Destination City <span
                                            class="text-red-500 font-bold text-2xl">*</span></label>
                                    <textarea name="destination_city" id="destination_city" rows="2"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="origin_airport_name" class="block text-sm font-medium text-gray-700">Origin Airport <span
                                            class="text-red-500 font-bold text-2xl">*</span></label>
                                    <textarea name="origin_airport_name" id="origin_airport_name" rows="2"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="destination_airport_name" class="block text-sm font-medium text-gray-700">Destination Airport <span
                                            class="text-red-500 font-bold text-2xl">*</span></label>
                                    <textarea name="destination_airport_name" id="destination_airport_name" rows="2"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="number_of_stops" class="block text-sm font-medium text-gray-700">Number of Stops <span
                                            class="text-red-500 font-bold text-2xl">*</span></label>
                                    <input type="number" name="number_of_stops" id="number_of_stops" min="0"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" required value="0">
                                </div>

                                <div class="form-group">
                                    <label for="flight_duration" class="block text-sm font-medium text-gray-700">Flight Duration <span
                                            class="text-red-500 font-bold text-2xl">*</span></label>
                                    <textarea name="flight_duration" id="flight_duration" rows="2" placeholder="e.g., 2 hours 30 minutes"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="airline_icon_url" class="block text-sm font-medium text-gray-700">Airline Icon</label>
                                    <input type="file" name="airline_icon_url" id="airline_icon_url" class="mt-1 block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-md file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-blue-50 file:text-blue-700
                                                  hover:file:bg-blue-100">
                                    <p class="mt-1 text-sm text-gray-500">JPEG, PNG, JPG, or GIF (Max: 2MB)</p>
                                </div>

                                <div class="form-group">
                                    <label for="base_price" class="block text-sm font-medium text-gray-700">Base Price ($) <span
                                            class="text-red-500 font-bold text-2xl">*</span></label>
                                    <input type="number" name="base_price" id="base_price" min="0" step="0.01"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                </div>

                                <div class="form-group">
                                    <label for="discount_percent" class="block text-sm font-medium text-gray-700">Discount Percent (%)</label>
                                    <input type="number" name="discount_percent" id="discount_percent" min="0" max="100" step="0.01"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" value="0.00">
                                </div>
                                                                <div class="form-group">
                                    <label for="popularity_score" class="block text-sm font-medium text-gray-700">popularity_score</label>
                                    <input type="number" name="popularity_score" id="popularity_score" step="1"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" >
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div
                            class="flex items-center px-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-50 focus:outline-none bg-blue-500 rounded-lg border border-gray-200 hover:bg-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="flight-route-modal">
                                Save Flight Route
                            </button>
                            <button type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="flight-route-modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table to Show Existing Flight Routes -->
        <div class="w-[90%] mt-12 mx-auto">
            <table id="example" class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Origin City</th>
                        <th class="px-4 py-2 border">Destination City</th>
                        <th class="px-4 py-2 border">Origin Airport</th>
                        <th class="px-4 py-2 border">Destination Airport</th>
                        <th class="px-4 py-2 border">Stops</th>
                        <th class="px-4 py-2 border">Duration</th>
                        <th class="px-4 py-2 border">Airline Icon</th>
                        <th class="px-4 py-2 border">Base Price</th>
                        <th class="px-4 py-2 border">Discount</th>
                         <th class="px-4 py-2 border">popularity score</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($flightRoutes as $route)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('flight-routes.update', $route->id) }}" method="POST" class="update-form"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <td class="border px-4 py-2">
                                {{ $route->id }}
                            </td>

                            <td class="border px-4 py-2">
                                <textarea name="origin_city" rows="2"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>{{ $route->origin_city }}</textarea>
                            </td>

                            <td class="border px-4 py-2">
                                <textarea name="destination_city" rows="2"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>{{ $route->destination_city }}</textarea>
                            </td>

                            <td class="border px-4 py-2">
                                <textarea name="origin_airport_name" rows="2"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>{{ $route->origin_airport_name }}</textarea>
                            </td>

                            <td class="border px-4 py-2">
                                <textarea name="destination_airport_name" rows="2"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>{{ $route->destination_airport_name }}</textarea>
                            </td>

                            <td class="border px-4 py-2">
                                <input type="number" name="number_of_stops" value="{{ $route->number_of_stops }}" min="0"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                            </td>

                            <td class="border px-4 py-2">
                                <textarea name="flight_duration" rows="2"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>{{ $route->flight_duration }}</textarea>
                            </td>

                            <td class="border px-4 py-2">
                                <div class="flex flex-col items-center">
                                    @if($route->airline_icon_url)
                                    <img src="{{ asset('storage/' . $route->airline_icon_url) }}" alt="Airline Icon"
                                        class="w-16 h-16 object-cover mb-2">
                                    @else
                                    <span class="text-gray-400 mb-2">No icon</span>
                                    @endif
                                    
                                    <input type="file" name="airline_icon_url" style="display: none;"
                                        onchange="previewImagePath(this, 'preview-{{ $route->id }}')">

                                    <button type="button" onclick="this.previousElementSibling.click()"
                                        class=" text-black px-3 py-1 rounded hover:bg-blue-600 mb-2 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                        </svg>
                                       
                                    </button>

                                    <div id="preview-{{ $route->id }}"
                                        class="text-xs text-gray-500 truncate w-full text-center">
                                        No file chosen
                                    </div>
                                </div>
                            </td>

                            <td class="border px-4 py-2">
                                <input type="number" name="base_price" value="{{ $route->base_price }}" min="0" step="0.01"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                            </td>

                            <td class="border px-4 py-2">
                                <input type="number" name="discount_percent" value="{{ $route->discount_percent }}" min="0" max="100" step="0.01"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                            </td>
                            
                             <td class="border px-4 py-2" data-order="{{ $route->popularity_score }}">
    <input type="number" name="popularity_score" value="{{ $route->popularity_score }}" step="1"
        class="w-full border border-gray-300 rounded px-2 py-1" disabled>
</td>


                            <td class="border px-4 py-2 flex space-x-2">
                                <!-- Edit Button -->
                                <button type="button" onclick="enableEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <!-- Save Button -->
                                <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                        </form>
                        <!-- Delete Button -->
                        <form action="{{ route('flight-routes.destroy', $route->id) }}" method="POST"
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

        // Enable input fields and textareas
        row.querySelectorAll('input, textarea').forEach(field => {
            if (field.type !== 'file') {
                field.disabled = false;
            }
        });

        // Show file input for airline icon
        const fileInput = row.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.style.display = 'block';
        }

        // Toggle buttons
        button.classList.add('hidden');
        row.querySelector('.save-button').classList.remove('hidden');
    }

    function previewImagePath(input, previewId) {
        const previewElement = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            previewElement.textContent = fileName.length > 20 ?
                fileName.substring(0, 20) + '...' :
                fileName;
        } else {
            previewElement.textContent = 'No file chosen';
        }
    }
    </script>
</x-app-layout>