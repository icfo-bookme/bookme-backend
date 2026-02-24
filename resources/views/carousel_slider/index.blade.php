<x-app-layout>
    <div class="w-[95%] mx-auto">
        <div class="container mx-auto mt-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold mb-4">Carousel Sliders</h2>
                <div class="flex justify-end mb-4">
                    <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Add New Slider
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Image</th>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Subtitle</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $slider)
                        <tr>
                            <form action="{{ route('carousel-slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <td class="px-4 py-2">{{ $slider->id }}</td>
                                <td class="px-4 py-2 hidden">
                                    <input type="text" name="destination_id" value="{{ $slider->destination_id }}"
                                        class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                </td>
                                <td class="px-4 py-2">
                                    @if($slider->image)
                                    <img src="{{ asset('storage/' . $slider->image) }}" class="w-20 h-20 object-cover" alt="Slider Image">
                                    @endif
                                    <input type="file" name="image" class="mt-2 w-full" disabled>
                                </td>
                                <td class="px-4 py-2">
                                    <textarea name="title" rows="2"
                                        class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ $slider->title }}</textarea>
                                </td>
                                <td class="px-4 py-2">
                                    <textarea name="subtitle" rows="2"
                                        class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ $slider->subtitle }}</textarea>
                                </td>
                                <td class="px-4 py-2 flex space-x-2">
                                    <button type="button" onclick="enableEdit(this)"
                                        class="bg-yellow-600 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</button>
                                    <button type="submit"
                                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                            </form>
                                    <form action="{{ route('carousel-slider.destroy', $slider->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                                    </form>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add New Slider Modal -->
        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Add New Slider</h3>
                        <button type="button" data-modal-hide="static-modal"
                            class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-6 space-y-6">
                        <form action="{{ route('carousel-slider.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
                                <div class="sm:col-span-2 hidden">
                                    <label for="destination_id" class="block text-sm font-medium text-gray-700">Destination ID*</label>
                                    <input type="text" id="destination_id" name="destination_id" required value="{{ $destination_id }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                
                                <div class="sm:col-span-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700">Title*</label>
                                    <textarea id="title" name="title" rows="2" 
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm resize-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                </div>
 <div class="sm:col-span-2">
    <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
    <textarea id="subtitle" name="subtitle" rows="2" maxlength="255"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm resize-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        oninput="updateCharCount()"></textarea>
    <p id="charCount" class="text-sm text-gray-500 mt-1">0 / 255 characters</p>
</div>


                                
                                <div class="sm:col-span-2">
                                    <label for="image" class="block text-sm font-medium text-gray-700">Image*</label>
                                    <input type="file" id="image" name="image" required accept="image/*"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Add Slider
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function enableEdit(button) {
        const row = button.closest('tr');
        row.querySelectorAll('input, textarea').forEach(field => field.disabled = false);
        button.classList.add('hidden');
        row.querySelector('.save-button').classList.remove('hidden');
    }

    function confirmDelete(button) {
        if (confirm('Are you sure you want to delete this slider?')) {
            button.closest('form').submit();
        }
    }

    @if(session('success'))
        alert('{{ session('success') }}');
    @endif
    </script>
</x-app-layout>
