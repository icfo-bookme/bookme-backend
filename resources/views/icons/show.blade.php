<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex items-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Icon Management</h1>

            <div class="float-right">
                <!-- Button to Open Modal for Adding Icons -->
                <button data-modal-target="icon-modal" data-modal-toggle="icon-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Add Icon
                </button>
            </div>
        </div>

        <!-- Flowbite Modal for Adding Icons -->
        <div id="icon-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Add New Icon
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
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
                    <form action="{{ route('icons.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="p-4 md:p-5 space-y-4">
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <div class="form-group">
                                    <label for="icon_name" class="block text-sm font-medium text-gray-700">
                                        Icon Name <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <input type="text" name="icon_name" id="icon_name"
                                        class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                                        required>
                                    @error('icon_name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="icon_import" class="block text-sm font-medium text-gray-700">
                                        Icon Import Code <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <input type="text" name="icon_import" id="icon_import"
                                        class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                                        placeholder="e.g., fa fa-user"
                                        required>
                                    @error('icon_import')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="image" class="block text-sm font-medium text-gray-700">
                                        Icon Image <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <input type="file" name="image" id="image"
                                        class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                                        accept="image/*"
                                        required>
                                    @error('image')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex items-center px-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Save Icon
                            </button>
                            <button type="button" data-modal-hide="icon-modal"
                                class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table to Show Existing Icons -->
        <div class="w-[90%] mt-12 mx-auto">
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

            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Icon</th>
                        <th class="px-4 py-2 border">Icon Name</th>
                        <th class="px-4 py-2 border">Import Code</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($icons as $icon)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('icons.update', $icon->id) }}" method="POST" enctype="multipart/form-data" class="update-form">
                            @csrf
                            @method('PUT')
                            <td class="px-4 py-2 border">
                                {{ $icon->id }}
                            </td>
                            <td class="px-4 py-2 border">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 mr-2">
                                        <img src="{{ asset('storage/' . $icon->image) }}" alt="{{ $icon->icon_name }}" class="w-full h-full object-contain">
                                    </div>
                                    <input type="file" name="image" class="hidden change-image-input" accept="image/*">
                                    <button type="button" onclick="triggerImageChange(this)" class="text-blue-600 text-sm hidden change-image-btn">Change</button>
                                </div>
                            </td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="icon_name" value="{{ $icon->icon_name }}" 
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                            </td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="icon_import" value="{{ $icon->icon_import }}" 
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                            </td>
                            
                            <td class="px-4 py-2 border flex space-x-2">
                                <!-- Edit Button -->
                                <button type="button" onclick="enableEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <!-- Save Button -->
                                <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                        </form>
                        <!-- Delete Button -->
                        <form action="{{ route('icons.destroy', $icon->id) }}" method="POST" class="inline-block">
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
        row.querySelectorAll('input[type="text"]').forEach(input => input.disabled = false);
        row.querySelector('.change-image-btn').classList.remove('hidden');
        button.classList.add('hidden');
        row.querySelector('.save-button').classList.remove('hidden');
    }
    
    function triggerImageChange(button) {
        const input = button.previousElementSibling;
        input.click();
        
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const img = this.parentElement.querySelector('img');
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    img.src = e.target.result;
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    </script>
</x-app-layout>