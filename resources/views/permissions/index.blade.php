<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex items-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Permissions</h1>

            <button data-modal-target="permission-modal" data-modal-toggle="permission-modal"
                class="block text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                Add Permission
            </button>
        </div>

        <!-- Modal for Adding Permission -->
        <div id="permission-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Add Permission</h3>
                    <button data-modal-hide="permission-modal" class="text-gray-500">&times;</button>
                </div>
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" class="form-control w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Module</label>
                            <select name="module" class="form-control w-full border rounded p-2" required>
                                <option value="">Select Module</option>
                                <option value="hotel">Hotel</option>
                                <option value="ship">Ship</option>
                                <option value="visa">Visa</option>
                                <option value="flight">Flight</option>
                                <option value="booking">Booking</option>
                                <option value="activities">Activities</option>
                                <option value="tour_packages">Tour Packages</option>
                                <option value="car_rental">Car Rental</option>
                                <option value="superadmin">Superadmin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Label</label>
                            <input type="text" name="label" class="form-control w-full border rounded p-2" required>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                        <button type="button" data-modal-hide="permission-modal" class="ml-2 px-4 py-2 rounded border">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table of Permissions -->
        <div class="mt-10 w-full">
            <table id="example" class="w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Module</th>
                        <th class="px-4 py-2 border">Label</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('permissions.update', $permission->id) }}" method="POST" class="update-form">
                            @csrf
                            @method('PUT')
                            <td class="border px-2 py-1">{{ $permission->id }}</td>
                            <td class="border px-2 py-1">
                                <input type="text" name="name" value="{{ $permission->name }}" class="w-full border rounded px-2 py-1" disabled>
                            </td>
                            <td class="border px-2 py-1">
                                <select name="module" class="w-full border rounded px-2 py-1" disabled>
                                    <option value="hotel" {{ $permission->module=='hotel' ? 'selected' : '' }}>Hotel</option>
                                    <option value="ship" {{ $permission->module=='ship' ? 'selected' : '' }}>Ship</option>
                                    <option value="visa" {{ $permission->module=='visa' ? 'selected' : '' }}>Visa</option>
                                    <option value="flight" {{ $permission->module=='flight' ? 'selected' : '' }}>Flight</option>
                                    <option value="booking" {{ $permission->module=='booking' ? 'selected' : '' }}>Booking</option>
                                    <option value="activities" {{ $permission->module=='activities' ? 'selected' : '' }}>Activities</option>
                                    <option value="tour_packages" {{ $permission->module=='tour_packages' ? 'selected' : '' }}>Tour Packages</option>
                                    <option value="car_rental" {{ $permission->module=='car_rental' ? 'selected' : '' }}>Car Rental</option>
                                    <option value="superadmin" {{ $permission->module=='superadmin' ? 'selected' : '' }}>Superadmin</option>
                                </select>
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" name="label" value="{{ $permission->label }}" class="w-full border rounded px-2 py-1" disabled>
                            </td>
                            <td class="border px-2 py-1 flex space-x-2">
                                <button type="button" onclick="enableEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 save-button hidden">Save</button>
                        </form>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
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
            row.querySelectorAll('input, select').forEach(input => input.disabled = false);
            button.classList.add('hidden');
            row.querySelector('.save-button').classList.remove('hidden');
        }

        // Confirm before deleting
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this permission?')) {
                    form.submit();
                }
            });
        });
    </script>
</x-app-layout>
