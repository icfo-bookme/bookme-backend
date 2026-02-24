<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex item-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Expense Subcategories</h1>

            <div class="float-right">
                <button data-modal-target="subcategory-modal" data-modal-toggle="subcategory-modal"
                    class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5"
                    type="button">
                    Add Subcategory
                </button>
            </div>
        </div>

        <!-- Add Subcategory Modal -->
        <div id="subcategory-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto">
            <div class="relative p-4 w-full max-w-xl max-h-full">
                <div class="bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex justify-between items-center p-4 border-b dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Add Subcategory</h3>
                        <button type="button" data-modal-hide="subcategory-modal"
                            class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                            ✕
                        </button>
                    </div>

                    <form action="{{ route('expense-subcategories.store') }}" method="POST">
                        @csrf
                        <div class="p-4 space-y-4">
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                <select name="category_id" id="category_id" required
                                    class="mt-1 p-2 border border-gray-300 rounded w-full">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                <input type="text" name="name" id="name" required
                                    class="mt-1 p-2 border border-gray-300 rounded w-full">
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" id="description"
                                    class="mt-1 p-2 border border-gray-300 rounded w-full h-24"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 p-4 border-t dark:border-gray-600">
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                            <button type="button" data-modal-hide="subcategory-modal"
                                class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Subcategories Table -->
        <div class="w-[90%] mt-12 mx-auto">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Category</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Description</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subcategories as $sub)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('expense-subcategories.update', $sub->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <td class="border px-4 py-2">{{ $sub->id }}</td>
                            <td class="border px-4 py-2">
                                <select name="category_id" class="w-full border border-gray-300 rounded p-1" disabled>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id == $sub->category_id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="border px-4 py-2">
                                <input type="text" name="name" value="{{ $sub->name }}"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                            </td>
                            <td class="border px-4 py-2">
                                <textarea name="description"
                                    class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ $sub->description }}</textarea>
                            </td>
                            <td class="border px-4 py-2 flex space-x-2">
                                <!-- Edit -->
                                <button type="button"
                                    class="edit-button bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                                    onclick="enableSubEdit(this)">Edit</button>

                                <!-- Save (hidden initially) -->
                                <button type="submit"
                                    class="save-button bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden">
                                    Save
                                </button>
                        </form>

                        <!-- Delete -->
                        <form action="{{ route('expense-subcategories.destroy', $sub->id) }}" method="POST">
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

    <!-- JavaScript -->
    <script>
        function enableSubEdit(button) {
            const row = button.closest('tr');

            // Enable all inputs and selects
            row.querySelectorAll('input, textarea, select').forEach(field => {
                field.disabled = false;
            });

            // Toggle button visibility
            button.classList.add('hidden');
            row.querySelector('.save-button').classList.remove('hidden');
        }
    </script>
</x-app-layout>
