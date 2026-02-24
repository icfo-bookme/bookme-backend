<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex item-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">FontAwesome Icons</h1>

            <div class="float-right">
                <!-- Button to Open Modal for Adding Icon -->
                <button data-modal-target="icon-modal" data-modal-toggle="icon-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">
                    Add New Icon
                </button>
            </div>
        </div>

        <!-- Flowbite Modal for Adding Icons -->
        <div id="icon-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add New Icon
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
                    <form action="{{ route('icons.store') }}" method="POST">
                        @csrf

                        <div class="p-4 md:p-5 space-y-4">
                            <div class="mb-4">
                                <div class="form-group">
                                    <label for="icon_class" class="block text-sm font-medium text-gray-700">Icon Class <span
                                            class="text-red-500 font-bold text-2xl">*</span></label>
                                    <input type="text" name="icon_class" id="icon_class"
                                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" 
                                        placeholder="e.g., fas fa-user" required>
                                    <p class="mt-1 text-sm text-gray-500">Enter the FontAwesome icon class (e.g., fas fa-user, fab fa-twitter)</p>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-700">Preview</label>
                                    <div id="icon-preview" class="mt-2 p-4 border border-gray-300 rounded-md text-center text-4xl">
                                        <i class="fas fa-question-circle text-gray-400"></i>
                                        <p class="text-sm text-gray-500 mt-2">Icon preview will appear here</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div
                            class="flex items-center px-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-50 focus:outline-none bg-blue-500 rounded-lg border border-gray-200 hover:bg-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="icon-modal">
                                Save Icon
                            </button>
                            <button type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="icon-modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table to Show Existing Icons -->
        <div class="w-[90%] mt-12 mx-auto">
            <table id="example" class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Icon Class</th>
                        <th class="px-4 py-2 border">Preview</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($icons as $icon)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('icons.update', $icon->id) }}" method="POST" class="update-form">
                            @csrf
                            @method('PUT')

                            <td class="border px-4 py-2">
                                {{ $icon->id }}
                            </td>

                            <td class="border px-4 py-2">
                                <input type="text" name="icon_class" value="{{ $icon->icon_class }}"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                            </td>

                            <td class="border px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <i class="{{ $icon->icon_class }} text-3xl"></i>
                                </div>
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
                        <form action="{{ route('icons.destroy', $icon->id) }}" method="POST"
                            class="inline-block">
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

    <!-- Include FontAwesome for icon preview -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
    function enableEdit(button) {
        const row = button.closest('tr');
        
        // Enable input field
        const inputField = row.querySelector('input[name="icon_class"]');
        inputField.disabled = false;
        inputField.focus();

        // Toggle buttons
        button.classList.add('hidden');
        row.querySelector('.save-button').classList.remove('hidden');
    }

    // Live preview for icon class input
    document.addEventListener('DOMContentLoaded', function() {
        const iconClassInput = document.getElementById('icon_class');
        const iconPreview = document.getElementById('icon-preview');
        
        if (iconClassInput) {
            iconClassInput.addEventListener('input', function() {
                const iconClass = this.value.trim();
                if (iconClass) {
                    iconPreview.innerHTML = `<i class="${iconClass} text-blue-500"></i>
                                            <p class="text-sm text-gray-500 mt-2">${iconClass}</p>`;
                } else {
                    iconPreview.innerHTML = `<i class="fas fa-question-circle text-gray-400"></i>
                                            <p class="text-sm text-gray-500 mt-2">Icon preview will appear here</p>`;
                }
            });
        }
    });
    </script>
</x-app-layout>