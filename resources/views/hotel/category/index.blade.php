<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex item-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold ">Hotel Categories: </h1>

            <div class="float-right ">
                <!-- Button to Open Modal for Adding Categories -->
                <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">
                    Add Category
                </button>
            </div>
        </div>

        <!-- Flowbite Modal for Adding Categories -->
        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add Hotel Category
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="static-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form action="{{ route('hotel_categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="p-4 md:p-5 space-y-4">
                            <!-- Category Fields -->
                            <div id="categoryFields">
                                <div class="categoryRow grid grid-cols-1 gap-4 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Category Name 
                                            <span class="text-red-500 font-bold text-2xl">*</span></label>
                                        <input type="text" name="name"
                                            class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div
                            class="flex items-center px-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-50 focus:outline-none bg-blue-500 rounded-lg border border-gray-200 hover:bg-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="static-modal">
                                Save Category
                            </button>
                            <button type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="static-modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table to Show Existing Categories -->
        <div class="w-[90%] mt-12 mx-auto">
            <table id="example" class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Category Name</th>
                       
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('hotel_categories.update', $category->id) }}" method="POST" class="update-form">
                            @csrf
                            @method('PUT')

                            <td>
                                <textarea name="" class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                    disabled>{{ $category->id }}</textarea>
                            </td>
                            <td>
                                <textarea name="name"
                                    class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                    disabled>{{ $category->name }}</textarea>
                            </td>
                           

                            <td class="flex space-x-2">
                                <!-- Edit Button -->
                                <button type="button" onclick="enableEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <!-- Save Button -->
                                <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                        </form>
                        <!-- Delete Button -->
                        <form action="{{ route('hotel_categories.destroy', $category->id) }}" method="POST" class="inline-block">
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
    // Add More Button functionality for adding new rows
    const addMoreBtn = document.getElementById('addMoreBtn');
    const removeRowBtn = document.getElementById('removeRowBtn');
    const categoryFields = document.getElementById('categoryFields');

    addMoreBtn?.addEventListener('click', () => {
        const newCategoryRow = document.querySelector('.categoryRow').cloneNode(true);
        newCategoryRow.querySelectorAll('input, select').forEach(input => input.value = '');
        categoryFields.appendChild(newCategoryRow);
    });

    removeRowBtn?.addEventListener('click', () => {
        const rows = document.querySelectorAll('.categoryRow');
        if (rows.length > 1) {
            rows[rows.length - 1].remove();
        } else {
            alert('At least one row must remain!');
        }
    });

    function enableEdit(button) {
        const row = button.closest('tr');
        row.querySelectorAll('textarea').forEach(textarea => textarea.disabled = false);
        row.querySelectorAll('input').forEach(input => input.disabled = false);
        button.classList.add('hidden');
        row.querySelector('.save-button').classList.remove('hidden');
    }
    </script>
</x-app-layout>