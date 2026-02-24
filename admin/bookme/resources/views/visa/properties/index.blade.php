<x-app-layout>
    <!-- Button to Open Modal -->

    <div class="w-[95%] mx-auto">
        <div class="container mx-auto mt-4">
            <div class="flex item-center justify-between">

                <h2 class="text-2xl font-bold mb-4">Property List: </h2>
                <div class="flex justify-end mb-4">
                    <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Add New Property
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <!-- Table for displaying properties -->
                <table id="example" class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">Property Id</th>
                            <th class="px-4 py-2 text-left">Property Name</th>
                           
                           
                          
                          
                            <th class="px-4 py-2 text-left">Destination_id</th>
                            <th class="px-4 py-2 text-left">Image</th>
                            <th class="px-4 py-2 text-left">Change Image</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Popularity Score</th>
                             <th class="px-4 py-2 text-left">meta description</th>
                            <th class="px-4 py-2 text-left">kewords</th>
                            <th class="px-4 py-2 text-left">specialkeywords</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($properties as $property)
                        <tr>
                            <form action="{{ route('properties.update', $property->property_id) }}" method="POST"
                                enctype="multipart/form-data" class="update-form">
                                @csrf
                                @method('PUT')

                                <td>
                                    <textarea class="w-full  border border-gray-300 rounded px-2 py-1 resize-none"
                                        disabled>{{ $property->property_id }} }</textarea>
                                </td>

                                <input type="hidden" name="destination_id" value="{{ $property->destination_id }}">
                                <td>
                                    <textarea required name="property_name"
                                        class="w-full  border border-gray-300 rounded px-2 py-1 resize-none"
                                        disabled>{{ $property->property_name }}</textarea>
                                </td>
                               
                               
                                <td>
                                    <textarea required name="spot_id"
                                        class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                        disabled>{{ $property->destination_id }}</textarea>
                                </td>

                                <td>
                                    @if ($property->main_img)
                                    <img src="{{ asset('storage/' . $property->main_img) }}"
                                        class="w-20 h-20 object-cover" alt="Property Image">
                                    @endif

                                </td>
                                <td>
                                    <label
                                        class="flex flex-col items-center justify-center cursor-pointer border border-gray-300 rounded px-3 py-2 w-full">
                                        <input type="file" name="main_img" class="hidden"
                                            id="fileInput-{{ $property->property_id }}" accept="image/*"
                                            onchange="showFilePath(event, '{{ $property->property_id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 16v-8m0 0-3 3m3-3 3 3m-9 4h12" />
                                        </svg>
                                    </label>
                                    <span id="fileName-{{ $property->property_id }}"
                                        class="text-xs text-gray-500 mt-1 block text-center"></span>
                                </td>



                                <td>
                                    <textarea required name="isactive"
                                        class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                        disabled>{{ $property->isactive }}</textarea>
                                </td>
                                <td>
                                    <textarea required name="popularity"
                                        class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                        disabled>{{ $property->popularity }}</textarea>
                                </td>
                               <td>
                                    <textarea  name="meta_description"
                                        class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                        disabled>{{ $property->meta_description }}</textarea>
                                </td>
                                 <td>
                                    <textarea  name="kewords"
                                        class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                        disabled>{{ $property->kewords }}</textarea>
                                </td>
                                 <td>
                                    <textarea  name="specialkeywords"
                                        class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                        disabled>{{ $property->specialkeywords }}</textarea>
                                </td>

                                <td class="flex space-x-2">
                                    <button type="button" onclick="enableEdit(this)"
                                        class="bg-yellow-600 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</button>
                                    <button type="submit"
                                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>




                            </form>
                           

                            @if($property->category_id == 4)
    <a href="/admin/property-summary/visa/{{$property->property_id}}"
       class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-500 save-button">
        Add Summary
    </a>
     <a href="/admin/visa/facilities/{{$property->property_id}}"
                                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-500  save-button">Add
                                details</button>
                                 <a href="/admin/property-units/visa/{{$property->property_id}}"
                                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-500  save-button">Add
                                            Packages
                                            </button>
@else
    <a href="/admin/property-summary/{{$property->property_id}}"
       class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-500 save-button">
        Add Summary
    </a>
     <a href="/admin/facilities/{{$property->property_id}}"
                                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-500  save-button">Add
                                details</button>
      
@endif

                                     
                                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Main Modal -->
        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal Content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Add New Property</h3>
                        <button type="button"
                            class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="static-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <div class="p-6 space-y-6">
                        <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- <div class="hidden">
                                <input type="number" value={{$spot_id}} name="spot_id">
                            </div> -->
                            <div class="hidden">
                                <input type="number" value={{$spot_id}} id="destination_id" name="destination_id">
                            </div>
                            <div class="hidden">
                                <input type="number" value={{$category_id}} id="category_id" name="category_id">
                            </div>
                            <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">



                                <!-- Property Name -->
                                <div>
                                    <label for="property_name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Property
                                        Name<span class="text-red-500 font-bold text-2xl">*</span></label>
                                    <input type="text" id="property_name" name="property_name"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                                </div>

                                <!-- Description -->
                                

                                <!-- Image Upload -->
                                <div>
                                    <label for="main_img"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image<span
                                            class="text-red-500 font-bold text-2xl">*</span></label>
                                    <input required type="file" id="main_img" name="main_img"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                                </div>

                                <!-- Active (Yes/No) -->
                                <div>
                                    <label for="isactive"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Active<span
                                            class="text-red-500 font-bold text-2xl">*</span></label>
                                    <select id="isactive" name="isactive"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="lat_long"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Popularity Score <span
                                        class="text-red-500 font-bold text-2xl">*</span></label>
                                    <input type="number" id="popularity" name="popularity"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                                </div>
                                
                            </div>
      <div>
    <label for="meta_description"
        class="block text-sm font-medium text-gray-700 dark:text-gray-300">meta_description</label>
    <textarea id="meta_description" name="meta_description"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white"
        rows="3"></textarea>
</div>

<div>
    <label for="kewords"
        class="block text-sm font-medium text-gray-700 dark:text-gray-300">keywords</label>
    <textarea id="keywords" name="keywords"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white"
        rows="3"></textarea>
</div>

<div>
    <label for="specialkeywords"
        class="block text-sm font-medium text-gray-700 dark:text-gray-300">specialkeywords</label>
    <textarea id="specialkeywords" name="specialkeywords"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white"
        rows="3"></textarea>
</div>


                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Add Property
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
function showFilePath(event, propertyId) {
    const input = event.target;
    const fileNameSpan = document.getElementById('fileName-' + propertyId);

    if (input.files && input.files[0]) {
        let fileName = input.files[0].name;

        // Limit file name length to 10 characters and add '...' if longer
        if (fileName.length > 10) {
            fileName = fileName.substring(0, 7) + '...';
        }

        fileNameSpan.textContent = fileName; // Display shortened file name
    } else {
        fileNameSpan.textContent = ""; // Clear text if no file is selected
    }
}
</script>
<script>
document.querySelector('form').addEventListener('submit', function() {
    // Ensure the file input is not disabled
    document.querySelector('input[type="file"]').disabled = false;
});

function enableEdit(button) {
    const row = button.closest('tr');
    row.querySelectorAll('textarea').forEach(textarea => textarea.disabled = false); // Enable all textarea fields
    row.querySelectorAll('input').forEach(input => input.disabled = false); // Enable all input fields (if any)
    button.classList.add('hidden'); // Hide the Edit button
    row.querySelector('.save-button').classList.remove('hidden'); // Show the Save button
}
</script>
<script>
@if(session('success'))
Swal.fire({
    title: 'Success!',
    text: '{{ session('
    success ') }}',
    icon: 'success',
    confirmButtonText: 'OK'
})
@endif
</script>