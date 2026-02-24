<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex item-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Country Visas</h1>

            <div class="float-right">
                <!-- Button to Open Modal for Adding Visa -->
                <button data-modal-target="visa-modal" data-modal-toggle="visa-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">
                    Add Country
                </button>
            </div>
        </div>

        <!-- Flowbite Modal for Adding Visas -->
        <div id="visa-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add Visa
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="visa-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form action="{{ route('country-visas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="p-4 md:p-5 space-y-4">
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <div class="form-group">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Visa Name <span
                                            class="text-red-500 font-bold text-2xl">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                </div>

                                <div class="form-group">
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full h-32"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="image" class="block text-sm font-medium text-gray-700">Visa
                                        Image</label>
                                    <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-md file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-blue-50 file:text-blue-700
                                                  hover:file:bg-blue-100">
                                    <p class="mt-1 text-sm text-gray-500">JPEG, PNG, JPG, or GIF (Max: 2MB)</p>
                                </div>

                                 <div class="form-group">
                                    <label for="popularityScore" class="block text-sm font-medium text-gray-700">popularity Score <span
                                            class="text-red-500 font-bold text-2xl">*</span></label>
                                    <input type="number" name="popularityScore" id="popularityScore"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" >
                                </div>
                                
                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-700">Active Status</label>
                                    <div class="mt-1 flex items-center">
                                        <input type="radio" name="is_active" id="active_yes" value="1" checked
                                            class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                        <label for="active_yes" class="ml-2 block text-sm text-gray-700">Yes</label>

                                        <input type="radio" name="is_active" id="active_no" value="0"
                                            class="ml-4 focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                        <label for="active_no" class="ml-2 block text-sm text-gray-700">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div
                            class="flex items-center px-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-50 focus:outline-none bg-blue-500 rounded-lg border border-gray-200 hover:bg-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="visa-modal">
                                Save Visa
                            </button>
                            <button type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="visa-modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table to Show Existing Visas -->
        <div class="w-[90%] mt-12 mx-auto">
            <table id="example" class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Description</th>
                        <th class="px-4 py-2 border">Current Image</th>
                        <th class="px-4 py-2 border">Update Image</th>
                        
                        <th class="px-4 py-2 border">Active</th>
                        <th class="px-4 py-2 border">popularity Score</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($countryVisas as $visa)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('country-visas.update', $visa->id) }}" method="POST" class="update-form"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <td class="border px-4 py-2">
                                {{ $visa->id }}
                            </td>

                            <td class="border px-4 py-2">
                                <textarea name="name"
                                    class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                    disabled>{{ $visa->name }}</textarea>
                            </td>

                            <td class="border px-4 py-2">
                                <textarea name="description"
                                    class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                    disabled>{{ $visa->description }}</textarea>
                            </td>

                            <td class="border px-4 py-2">
                                @if($visa->image)
                                <img src="{{ asset('storage/' . $visa->image) }}" alt="Visa Image"
                                    class="w-16 h-16 object-cover">

                                @else
                                <span class="text-gray-400">No image</span>
                                @endif
                            </td>

                            <td class="border px-4 py-2">
                                <div class="flex flex-col items-center">
                                    <input type="file" name="image" style="display: none;"
                                        onchange="previewImagePath(this, 'preview-{{ $visa->id }}')">

                                    <button type="button" onclick="this.previousElementSibling.click()"
                                        class=" text-black px-3 py-1 rounded hover:bg-blue-600 mb-2 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                        </svg>
                                       
                                    </button>

                                    <div id="preview-{{ $visa->id }}"
                                        class="text-xs text-gray-500 truncate w-full text-center">
                                        No file chosen
                                    </div>
                                </div>
                            </td>

                            <td class="border px-4 py-2">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <input type="radio" name="is_active" value="1"
                                            {{ $visa->is_active ? 'checked' : '' }} disabled
                                            class="h-4 w-4 text-blue-600 border-gray-300">
                                        <span class="ml-2">Yes</span>
                                    </div>
                                    <div>
                                        <input type="radio" name="is_active" value="0"
                                            {{ !$visa->is_active ? 'checked' : '' }} disabled
                                            class="h-4 w-4 text-blue-600 border-gray-300">
                                        <span class="ml-2">No</span>
                                    </div>
                                </div>
                            </td>
                        <td class="border px-4 py-2">
                                <textarea name="popularityScore"
                                    class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                    disabled>{{ $visa->popularityScore }}</textarea>
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
                        <form action="{{ route('country-visas.destroy', $visa->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                        </form>
                        <a href="{{ url('/visa/properties/' . $visa->id) }}">
                            <button type="button"
                                class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-600">Add
                                Details</button>
                        </a>
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

        // Enable textareas
        row.querySelectorAll('textarea').forEach(textarea => textarea.disabled = false);

        // Enable radio buttons
        row.querySelectorAll('input[type="radio"]').forEach(radio => radio.disabled = false);

        // Show file input for image
        const fileInput = row.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.classList.remove('hidden');
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