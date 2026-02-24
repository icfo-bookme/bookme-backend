<x-app-layout>
    <div class="w-[95%] mx-auto">
        <h2 class="text-2xl mt-10 font-bold mb-4">Properties Images</h2>
 @if ($category_id == 6)
    <a
        href="/admin/activities/properties/{{ $property->destination_id }}"
        class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition-colors duration-200"
    >
        Back to Properties
    </a>
     @elseif ($category_id == 5)
    <a
        href="/admin/tour%20packages/properties/{{ $property->destination_id }}"
        class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition-colors duration-200"
    >
        Back to Properties
    </a>
@else
    <a
        href="/admin/ships/properties/{{ $property->destination_id }}"
        class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition-colors duration-200"
    >
        Back to Properties
    </a>
@endif

        <div class="mb-8 p-6 mt-3 bg-gray-50 shadow-md rounded-lg">
            <h2 class="text-2xl font-semibold px-5 mb-4">
                Property Name: <span class="text-blue-600">{{ $property->property_name }}</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <p class="text-gray-700"><strong>District/City:</strong> {{ $property->district_city }}</p>
                <p class="text-gray-700"><strong>Address:</strong> {{ $property->address }}</p>
            </div>
        </div>

        <!-- Add Image Button -->
        <div class="flex justify-end items-center mb-5 mr-10">
            <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700">
                Add Property Images
            </button>
        </div>

        <!-- Existing Images -->
        <div class="mt-10 grid grid-cols-3 gap-6">
            <h3 class="text-lg font-semibold text-gray-900 col-span-3">Existing Property Images</h3>
            @if($propertyImages->isNotEmpty())
                @foreach($propertyImages as $image)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Property Image" class="w-full h-40 object-cover rounded-lg">
                        <form action="{{ route('property_images.destroy', $image->image_id) }}" method="POST" class="absolute top-2 right-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white bg-red-600 rounded-full p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            @else
                <p class="text-gray-700 col-span-3">No images found for this property.</p>
            @endif
        </div>

        <!-- Modal -->
        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add Property Images
                        </h3>
                        <button type="button"
                                class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="static-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="px-10 pb-10">
                        <form action="{{ route('property_images.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="property_id" value="{{ $propertyId }}">

                            <!-- Multi Image Upload -->
                            <div class="mt-4">
                                <label for="images" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Upload Images<span class="text-red-500 font-bold text-2xl">*</span>
                                </label>
                                <input required type="file" id="images" name="path[]" multiple
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                                @error('path')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6 flex justify-end">
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Add Images
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Success Notification -->
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    </script>
@endif
