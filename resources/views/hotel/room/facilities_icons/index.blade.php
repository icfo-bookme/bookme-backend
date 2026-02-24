<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex item-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Room Facility Icons</h1>

            <div class="float-right">
                <!-- Button to Open Modal for Adding Icons -->
                <button data-modal-target="icon-modal" data-modal-toggle="icon-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">
                    Add Icon
                </button>
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

        <!-- Include Font Awesome 6 -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Flowbite Modal for Adding Icons -->
        <div id="icon-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-4xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add New Room Facility Icon
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="icon-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form action="{{ route('facilities-icons.store') }}" method="POST">
                        @csrf
                        <div class="p-4 md:p-5 space-y-4">
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <div class="form-group">
                                    <label for="facility_id" class="block text-sm font-medium text-gray-700">Room Facility 
                                        <span class="text-red-500 font-bold text-2xl">*</span></label>
                                    <select name="facility_id" class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                        <option value="">Select Room Facility</option>
                                        @foreach($roomFacilities as $facility)
                                            <option value="{{ $facility->id }}">{{ $facility->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="type" id="type" maxlength="255"  value="room">
                                <div class="form-group">
                                    <label for="icon_class" class="block text-sm font-medium text-gray-700">Icon Class 
                                        <span class="text-red-500 font-bold text-2xl">*</span></label>
                                    <input type="text" id="icon-class-input" name="icon_class" placeholder="e.g. fa-solid fa-snowflake"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                        required>
                                    <p class="mt-1 text-sm text-gray-500">Use Font Awesome icon classes (e.g. "fa-solid fa-snowflake")</p>
                                    <div class="mt-2 grid grid-cols-4 gap-2">
                                        <!-- Air Conditioning & Temperature -->
                                        <button type="button" onclick="setIconClass('fa-solid fa-snowflake')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-snowflake"></i> Air Conditioning
                                        </button>
                                        <button type="button" onclick="setIconClass('fa-solid fa-fan')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-fan"></i> Fan
                                        </button>
                                        
                                        <!-- Bedroom Facilities -->
                                        <button type="button" onclick="setIconClass('fa-solid fa-bed')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-bed"></i> Bed
                                        </button>
                                        <button type="button" onclick="setIconClass('fa-solid fa-blanket')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-blanket"></i> Blankets
                                        </button>
                                        <button type="button" onclick="setIconClass('fa-solid fa-wardrobe')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-wardrobe"></i> Closet
                                        </button>
                                        <button type="button" onclick="setIconClass('fa-solid fa-curtains')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-curtains"></i> Curtain
                                        </button>
                                        <button type="button" onclick="setIconClass('fa-solid fa-couch')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-couch"></i> Day Bed
                                        </button>
                                        
                                        <!-- Bathroom Facilities -->
                                        <button type="button" onclick="setIconClass('fa-solid fa-bath')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-bath"></i> Bathroom
                                        </button>
                                        <button type="button" onclick="setIconClass('fa-solid fa-hot-tub-person')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-hot-tub-person"></i> Hot Water
                                        </button>
                                        <button type="button" onclick="setIconClass('fa-solid fa-pump-soap')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-pump-soap"></i> Toiletries
                                        </button>
                                        
                                        <!-- Media & Technology -->
                                        <button type="button" onclick="setIconClass('fa-solid fa-tv')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-tv"></i> TV
                                        </button>
                                        <button type="button" onclick="setIconClass('fa-solid fa-satellite-dish')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-satellite-dish"></i> Cable TV
                                        </button>
                                        <button type="button" onclick="setIconClass('fa-solid fa-wifi')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-wifi"></i> Wi-Fi
                                        </button>
                                        <button type="button" onclick="setIconClass('fa-solid fa-phone')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-phone"></i> Telephone
                                        </button>
                                        
                                        <!-- Food & Drink -->
                                        <button type="button" onclick="setIconClass('fa-solid fa-bottle-water')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-bottle-water"></i> Free Bottled Water
                                        </button>
                                        <button type="button" onclick="setIconClass('fa-solid fa-mug-saucer')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-mug-saucer"></i> Coffee/Tea
                                        </button>
                                        
                                        <!-- Services -->
                                        <button type="button" onclick="setIconClass('fa-solid fa-bell-concierge')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-bell-concierge"></i> Room Service
                                        </button>
                                        <button type="button" onclick="setIconClass('fa-solid fa-broom')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-broom"></i> Housekeeping
                                        </button>
                                        
                                        <!-- Electrical -->
                                        <button type="button" onclick="setIconClass('fa-solid fa-plug')" class="p-2 border rounded hover:bg-gray-100">
                                            <i class="fa-solid fa-plug"></i> 220V Socket
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-700">Preview:</label>
                                    <div id="icon-preview" class="mt-2 p-4 border rounded-lg text-center">
                                        <i class="text-4xl text-gray-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex items-center px-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-50 focus:outline-none bg-blue-500 rounded-lg border border-gray-200 hover:bg-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="icon-modal">
                                Save Icon
                            </button>
                            <button type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="icon-modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table to Show Existing Icons -->
        <div class="w-[90%] mt-12 mx-auto">
            <table id="example" class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Facility</th>
                     
                        <th class="px-4 py-2 border">Icon Class</th>
                        <th class="px-4 py-2 border">Preview</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roomFacilitiesIcons as $icon)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-4 py-2 border">
                            <span>{{ $icon->id }}</span>
                        </td>
                        <form action="{{ route('facilities-icons.update', $icon->id) }}" method="POST" class="update-form">
                            @csrf
                            @method('PUT')
                            <td class="px-4 py-2 border">
                                <select name="facility_id" class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                    @foreach($roomFacilities as $facility)
                                        <option value="{{ $facility->id }}" {{ $icon->facility_id == $facility->id ? 'selected' : '' }}>
                                            {{ $facility->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            
                            <td class="px-4 py-2 border">
                                <input type="text" name="icon_class" value="{{ $icon->icon_class }}"
                                    class="w-full border border-gray-300 rounded px-2 py-1"
                                    disabled>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <div class="text-3xl">
                                    <i class="{{ $icon->icon_class }}"></i>
                                </div>
                            </td>
                            <td class="px-4 py-2 border flex space-x-2">
                                <!-- Edit Button -->
                                <button type="button" onclick="enableIconEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <!-- Save Button -->
                                <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                            </form>
                            <!-- Delete Button -->
                            <form action="{{ route('facilities-icons.destroy', $icon->id) }}" method="POST" class="inline-block">
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
    function enableIconEdit(button) {
        const row = button.closest('tr');
        row.querySelectorAll('input, select').forEach(field => field.disabled = false);
        button.classList.add('hidden');
        row.querySelector('.save-button').classList.remove('hidden');
    }

    // Set icon class from quick selection buttons
    function setIconClass(iconClass) {
        const input = document.getElementById('icon-class-input');
        input.value = iconClass;
        updateIconPreview();
    }

    // Update icon preview in real-time
    function updateIconPreview() {
        const input = document.getElementById('icon-class-input');
        const preview = document.getElementById('icon-preview');
        preview.innerHTML = `<i class="${input.value} text-4xl text-gray-600"></i>`;
    }

    // Initialize icon preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const iconInput = document.getElementById('icon-class-input');
        
        // Live preview when typing
        iconInput.addEventListener('input', updateIconPreview);
        
        // Initialize any existing previews
        updateIconPreview();
    });
    </script>
</x-app-layout>