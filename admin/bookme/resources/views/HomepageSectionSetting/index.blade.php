<x-app-layout>
    <div class="w-[95%] mx-auto">
        <div class="container mx-auto mt-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold mb-4">Homepage Section Settings</h2>
                <div class="flex justify-end mb-4">
                    <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Add New Section
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table id="example" class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Heading</th>
                            <th class="px-4 py-2 text-left">Category</th>
                            <th class="px-4 py-2 text-left">Subcategory</th>
                            <th class="px-4 py-2 text-left">Limit</th>
                            <th class="px-4 py-2 text-left">Order</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($settings as $setting)
                        <tr>
                            <form action="{{ route('homepage-section-settings.update', $setting->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <td class="px-4 py-2">{{ $setting->id }}</td>
                                <td class="px-4 py-2">
                                    <input type="text" name="heading" value="{{ $setting->heading }}"
                                        class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                </td>
                                <td class="px-4 py-2">
                                    {{ $setting->category }}
                                   <select id="category" name="category" required
    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm modal-category-select">
    <option value="">Select Category</option>
    @foreach($categories as $category)
        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
    @endforeach
</select>
                                </td>
                                <td class="px-4 py-2">
                                    <select name="subcategory" 
                                        class="w-full border border-gray-300 rounded px-2 py-1 subcategory-select" disabled>
                                        <option value="">Select Subcategory</option>
                                        @if($setting->category == 1)
                                            @foreach($subcategoryforid1 as $subcategory)
                                                <option value="{{ $subcategory->id }}" {{ $setting->subcategory == $subcategory->id ? 'selected' : '' }}>
                                                    {{ $subcategory->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            @if($setting->subcategory)
                                                <option value="{{ $setting->subcategory }}" selected>
                                                    {{ $setting->subcategory }}
                                                </option>
                                            @endif
                                        @endif
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" name="limit" value="{{ $setting->limit }}" required min="1"
                                        class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" name="order" value="{{ $setting->order }}" required min="0"
                                        class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                </td>
                                <td class="px-4 py-2">
                                    <select name="active" class="border border-gray-300 rounded px-2 py-1" disabled>
                                        <option value="yes" {{ strtolower(trim($setting->active)) === 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no" {{ strtolower(trim($setting->active)) === 'no' ? 'selected' : '' }}>No</option>
                                    </select>
                                </td>
                                <td class="px-4 py-2 flex space-x-2">
                                    <button type="button" onclick="enableEdit(this)"
                                        class="bg-yellow-600 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</button>
                                    <button type="submit"
                                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                            </form>
                            <form action="{{ route('homepage-section-settings.destroy', $setting->id) }}" method="POST" class="inline">
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

        <!-- Add New Section Modal -->
        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Add New Section</h3>
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
                        <form action="{{ route('homepage-section-settings.store') }}" method="POST">
                            @csrf
                            <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
                                <div>
                                    <label for="heading" class="block text-sm font-medium text-gray-700">Heading</label>
                                    <input type="text" id="heading" name="heading"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700">Category*</label>
                                    <select id="category" name="category" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm modal-category-select">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="subcategory" class="block text-sm font-medium text-gray-700">Subcategory</label>
                                    <select id="subcategory" name="subcategory"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm modal-subcategory-select">
                                        <option value="">Select Subcategory</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="limit" class="block text-sm font-medium text-gray-700">Limit*</label>
                                    <input type="number" id="limit" name="limit" required min="1"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="order" class="block text-sm font-medium text-gray-700">Order*</label>
                                    <input type="number" id="order" name="order" required min="0"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="active" class="block text-sm font-medium text-gray-700">Active*</label>
                                    <select id="active" name="active" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Add Section
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function enableEdit(button) {
        const row = button.closest('tr');
        row.querySelectorAll('input, select').forEach(field => field.disabled = false);
        button.classList.add('hidden');
        row.querySelector('.save-button').classList.remove('hidden');
        
        // When enabling edit, load subcategories for the selected category
        const categorySelect = row.querySelector('.category-select');
        if (categorySelect) {
            loadSubcategories(categorySelect);
        }
    }

    function confirmDelete(button) {
        if (confirm('Are you sure you want to delete this section?')) {
            button.closest('form').submit();
        }
    }

    // Function to load subcategories
    function loadSubcategories(selectElement) {
        const categoryId = selectElement.value;
        const subcategorySelect = selectElement.closest('tr').querySelector('.subcategory-select');
        
        if (categoryId == 1) {
            // For category ID 1, use the predefined subcategoryforid1 data
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
            @foreach($subcategoryforid1 as $subcategory)
                subcategorySelect.innerHTML += `<option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>`;
            @endforeach
        } else {
            // For other categories, you might want to keep the existing value or clear the field
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
        }
        
        // If there's a previously selected subcategory, try to select it
        const currentSubcategory = subcategorySelect.dataset.current;
        if (currentSubcategory) {
            subcategorySelect.value = currentSubcategory;
        }
    }

    // Event listener for category changes in the table
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.category-select').forEach(select => {
            select.addEventListener('change', function() {
                loadSubcategories(this);
            });
        });

        // Event listener for category changes in the modal
        document.querySelector('.modal-category-select')?.addEventListener('change', function() {
            const categoryId = this.value;
            const subcategorySelect = document.querySelector('.modal-subcategory-select');
            
            if (categoryId == 1) {
                // For category ID 1 in modal, use the predefined subcategoryforid1 data
                subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                @foreach($subcategoryforid1 as $subcategory)
                    subcategorySelect.innerHTML += `<option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>`;
                @endforeach
            } else {
                // For other categories in modal, clear the field
                subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
            }
        });
    });
    </script>
</x-app-layout>