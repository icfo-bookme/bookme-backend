<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex item-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Room Types:</h1>

            <div class="float-right">
                <button data-modal-target="roomtype-modal" data-modal-toggle="roomtype-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Add Room Type
                </button>
            </div>
        </div>

        {{-- Success / Error Alerts --}}
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

        {{-- Modal for Adding Room Type --}}
        <div id="roomtype-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Add New Room Type
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="roomtype-modal">
                            <svg class="w-3 h-3" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" fill="none">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('room-types.store') }}" method="POST">
                        @csrf
                        <div class="p-4 md:p-5 space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Room Type Name <span class="text-red-500 font-bold text-lg">*</span>
                                </label>
                                <input type="text" name="name" required
                                    class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full">
                            </div>
                            <div>
                                <label for="isActive" class="block text-sm font-medium text-gray-700">
                                    Status
                                </label>
                                <select name="isActive"
                                    class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center px-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button type="submit"
                                class="py-2.5 px-5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 w-full sm:w-auto">
                                Save Room Type
                            </button>
                            <button type="button"
                                class="py-2.5 px-5 ml-3 text-sm font-medium bg-white text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100"
                                data-modal-hide="roomtype-modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Table Display --}}
        <div class="w-[90%] mt-12 mx-auto">
            <table id="example" class="table-auto w-full border-collapse" id="roomtype-table">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Room Type Name</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roomTypes as $roomType)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $roomType->id }}</td>
                            <form action="{{ route('room-types.update', $roomType->id) }}" method="POST" class="update-form">
                                @csrf
                                @method('PUT')
                                <td class="px-4 py-2 border">
                                    <input name="name" class="w-full border border-gray-300 rounded px-2 py-1" disabled
                                        value="{{ $roomType->name }}">
                                </td>
                                <td class="px-4 py-2 border">
                                    <select name="isActive" class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                        <option value="1" {{ $roomType->isActive ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$roomType->isActive ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </td>
                                <td class="px-4 py-2 border flex space-x-2">
                                    <button type="button" onclick="enableRoomTypeEdit(this)"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                    <button type="submit"
                                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                            </form>
                            <form action="{{ route('room-types.destroy', $roomType->id) }}" method="POST">
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
        function enableRoomTypeEdit(button) {
            const row = button.closest('tr');
            row.querySelectorAll('input, select').forEach(field => field.disabled = false);
            button.classList.add('hidden');
            row.querySelector('.save-button').classList.remove('hidden');
        }

        // Status style
        document.querySelectorAll('select[name="isActive"]').forEach(select => {
            const cell = select.closest('td');
            if (select.value === '1') {
                cell.classList.add('bg-green-50', 'text-green-800');
            } else {
                cell.classList.add('bg-red-50', 'text-red-800');
            }
        });
    </script>
</x-app-layout>
