<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex item-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold ">Facilities Category: </h1>

            <div class="float-right">
                <!-- Button to Open Modal for Adding Features -->
                <button data-modal-target="feature-modal" data-modal-toggle="feature-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">
                    Add Category 
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
        <!-- Flowbite Modal for Adding Features -->
        <div id="feature-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add New Category
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="feature-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form action="{{ route('feature-categories.store') }}" method="POST">
                        @csrf

                        <div class="p-4 md:p-5 space-y-4">
                            <div id="featureFields">
                                <div class="featureRow grid grid-cols-1 gap-4 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Feature Category Name 
                                            <span class="text-red-500 font-bold text-2xl">*</span></label>
                                        <input type="text" name="name"
                                            class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                            required>
                                    </div>
                                    <input type="text" name="type" value="room"
                                            class="hidden form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                            required>
                                    <div class="form-group">
                                        <label for="isactive" class="block text-sm font-medium text-gray-700">Status</label>
                                        <select name="isactive" class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full">
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex items-center px-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-50 focus:outline-none bg-blue-500 rounded-lg border border-gray-200 hover:bg-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="feature-modal">
                                Save Feature
                            </button>
                            <button type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="feature-modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table to Show Existing Features -->
        <div class="w-[90%] mt-12 mx-auto">
            <table id="features-table" class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Category Name</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('feature-categories.update', $category->id) }}" method="POST" class="update-form">
                            @csrf
                            @method('PUT')

                            <td class="px-4 py-2 border">
                                <span>{{ $category->id }}</span>
                            </td>
                            <td class="px-4 py-2 border">
                                <textarea name="name"
                                    class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                    disabled>{{ $category->name }}</textarea>
                            </td>
                            <td class="px-4 py-2 border">
                                <select name="isactive" class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                    <option value="1" {{ $category->isactive ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$category->isactive ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </td>

                            <td class="px-4 py-2 border flex space-x-2">
                                <!-- Edit Button -->
                                <button type="button" onclick="enableFeatureEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <!-- Save Button -->
                                <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                        </form>
                        <!-- Delete Button -->
                        <form action="{{ route('feature-categories.destroy', $category->id) }}" method="POST" class="inline-block">
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
    function enableFeatureEdit(button) {
        const row = button.closest('tr');
        row.querySelectorAll('textarea, select').forEach(field => field.disabled = false);
        button.classList.add('hidden');
        row.querySelector('.save-button').classList.remove('hidden');
    }

    // Status badge styling
    document.querySelectorAll('select[name="isactive"]').forEach(select => {
        const statusCell = select.closest('td');
        if (select.value === '1') {
            statusCell.classList.add('bg-green-50', 'text-green-800');
        } else {
            statusCell.classList.add('bg-red-50', 'text-red-800');
        }
    });
    </script>
</x-app-layout>