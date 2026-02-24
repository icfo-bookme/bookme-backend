<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex item-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Expense Categories</h1>

            <div class="float-right">
                <button data-modal-target="category-modal" data-modal-toggle="category-modal"
                    class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5"
                    type="button">
                    Add Category
                </button>
            </div>
        </div>

        <!-- Modal -->
        <div id="category-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto">
            <div class="relative p-4 w-full max-w-xl max-h-full">
                <div class="bg-white rounded-lg shadow">
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 class="text-xl font-semibold text-gray-900">Add Category</h3>
                        <button type="button" data-modal-hide="category-modal"
                            class="text-gray-400 hover:text-gray-900">✕</button>
                    </div>

                    <form action="{{ route('expense-categories.store') }}" method="POST">
                        @csrf
                        <div class="p-4 space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium">Name</label>
                                <input type="text" name="name" id="name" required
                                    class="mt-1 p-2 border border-gray-300 rounded w-full">
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium">Description</label>
                                <textarea name="description" id="description"
                                    class="mt-1 p-2 border border-gray-300 rounded w-full h-24"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 p-4 border-t">
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                            <button type="button" data-modal-hide="category-modal"
                                class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="w-[90%] mt-12 mx-auto">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Description</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('expense-categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <td class="border px-4 py-2">{{ $category->id }}</td>
                            <td class="border px-4 py-2">
                                <input type="text" name="name" value="{{ $category->name }}"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                            </td>
                            <td class="border px-4 py-2">
                                <textarea name="description"
                                    class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                    disabled>{{ $category->description }}</textarea>
                            </td>
                            <td class="border px-4 py-2 flex space-x-2">
                                <!-- Edit Button -->
                                <button type="button"
                                    class="edit-button bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                                    onclick="enableEdit(this)">Edit</button>

                                <!-- Save Button (hidden by default) -->
                                <button type="submit"
                                    class="save-button bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden">
                                    Save
                                </button>
                        </form>

                        <!-- Delete -->
                        <form action="{{ route('expense-categories.destroy', $category->id) }}" method="POST">
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
        function enableEdit(button) {
            const row = button.closest('tr');

            // Enable inputs and textareas
            row.querySelectorAll('input[type="text"], textarea').forEach(input => {
                input.disabled = false;
            });

            // Toggle buttons
            button.classList.add('hidden'); // hide Edit
            row.querySelector('.save-button').classList.remove('hidden'); // show Save
        }
    </script>
</x-app-layout>
