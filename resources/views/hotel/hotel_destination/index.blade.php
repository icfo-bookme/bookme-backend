<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex items-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Hotel Destination:</h1>
            <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                Add Destination
            </button>
        </div>

        <!-- Modal for Adding Destination -->
        <div id="static-modal" data-modal-backdrop="static" class="hidden fixed top-0 right-0 left-0 z-50 overflow-y-auto overflow-x-hidden w-full h-[calc(100%-1rem)] max-h-full justify-center items-center">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">Add Destination</h3>
                        <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg w-8 h-8" data-modal-hide="static-modal">
                            ✕
                        </button>
                    </div>
                    <form action="{{ route('hotel_destinations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="p-4 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" required class="p-2 border border-gray-300 rounded-md w-full">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Country <span class="text-red-500">*</span></label>
                                    <input type="text" name="country" required class="p-2 border border-gray-300 rounded-md w-full">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Image</label>
                                    <input type="file" name="img" accept="image/*" class="p-2 border border-gray-300 rounded-md w-full">
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center px-4 py-3 border-t">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 px-5 py-2 rounded-lg">
                                Save Destination
                            </button>
                            <button type="button" data-modal-hide="static-modal" class="ml-3 text-gray-600 hover:text-gray-900">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table for Destinations -->
        <div class="w-[90%] mt-12 mx-auto">
            <table id="example" class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Country</th>
                        <th class="px-4 py-2 border">Image</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spots as $spot)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('hotel_destinations.update', $spot->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <td class="px-4 py-2 border">
                                {{ $spot->id }}
                            </td>
                            <td class="px-4 py-2 border">
                                <textarea name="name" class="w-full border rounded px-2 py-1 resize-none" disabled>{{ $spot->name }}</textarea>
                            </td>
                            <td class="px-4 py-2 border">
                                <textarea name="country" class="w-full border rounded px-2 py-1 resize-none" disabled>{{ $spot->country }}</textarea>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <img src="{{ asset('storage/' . $spot->img) }}" alt="Destination Image" class="w-16 h-16 object-cover mx-auto mb-2 rounded">
                                <input type="file" name="img" class="hidden mt-2 w-full file-input" disabled>
                            </td>
                            <td class="px-4 py-2 border flex flex-col space-y-2">
                                <div class="flex space-x-2">
                                    <button type="button" onclick="enableEdit(this)" class="edit-btn bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                    <button type="submit" class="save-btn bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden">Save</button>
                                    <a href="{{ url('/hotel/' . $spot->id) }}">
                                        <button type="button" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">Manage Hotel</button>
                                    </a>
                                </div>
                                <button type="button" onclick="cancelEdit(this)" class="cancel-btn bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 hidden">Cancel</button>
                            </td>
                        </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function enableEdit(button) {
            // First, disable all other edit modes if any are active
            document.querySelectorAll('.cancel-btn').forEach(cancelBtn => {
                if (!cancelBtn.classList.contains('hidden')) {
                    cancelEdit(cancelBtn);
                }
            });

            const row = button.closest('tr');
            row.querySelectorAll('textarea').forEach(el => el.disabled = false);
            row.querySelectorAll('input[type="file"]').forEach(el => {
                el.disabled = false;
                el.classList.remove('hidden');
            });
            
            // Hide edit button, show save and cancel buttons
            row.querySelector('.edit-btn').classList.add('hidden');
            row.querySelector('.save-btn').classList.remove('hidden');
            row.querySelector('.cancel-btn').classList.remove('hidden');
        }

        function cancelEdit(button) {
            const row = button.closest('tr');
            row.querySelectorAll('textarea').forEach(el => {
                el.disabled = true;
                // Reset to original values - you might need to adjust this if you want to keep changes
                // until page reload
            });
            row.querySelectorAll('input[type="file"]').forEach(el => {
                el.disabled = true;
                el.classList.add('hidden');
                el.value = ''; // Reset file input
            });
            
            // Show edit button, hide save and cancel buttons
            row.querySelector('.edit-btn').classList.remove('hidden');
            row.querySelector('.save-btn').classList.add('hidden');
            row.querySelector('.cancel-btn').classList.add('hidden');
        }
    </script>
</x-app-layout>