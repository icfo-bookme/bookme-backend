<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex items-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Users</h1>

            <div class="float-right">
                <!-- Button to Open Modal for Adding User -->
                <button data-modal-target="user-modal" data-modal-toggle="user-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="button">
                    Add User
                </button>
            </div>
        </div>

        <!-- Modal for Adding User -->
        <div id="user-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 pb-10 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">Add User</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="user-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="p-4 space-y-4">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="form-group">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                    <input type="email" autocomplete="off" name="email" id="email" class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center px-4 border-t rounded-b">
                            <button type="submit" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-50 bg-blue-500 rounded-lg hover:bg-blue-600 w-full sm:w-auto">Save User</button>
                            <button type="button" data-modal-hide="user-modal"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white rounded-lg hover:bg-gray-100 w-full sm:w-auto">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="w-[90%] mt-12 mx-auto">
            <table id="example" class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Phone</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('users.update', $user->id) }}" method="POST" class="update-form">
                            @csrf
                            @method('PUT')
                            <td class="border px-4 py-2">{{ $user->id }}</td>
                            <td class="border px-4 py-2">
                                <input type="text" name="name" value="{{ $user->name }}" disabled
                                    class="w-full border border-gray-300 rounded px-2 py-1">
                            </td>
                            <td class="border px-4 py-2">
                                <input type="email" name="email" value="{{ $user->email }}" disabled
                                    class="w-full border border-gray-300 rounded px-2 py-1">
                            </td>
                            <td class="border px-4 py-2">
                                <input type="text" name="phone" value="{{ $user->phone }}" disabled
                                    class="w-full border border-gray-300 rounded px-2 py-1">
                            </td>
                            <td class="border px-4 py-2 flex space-x-2">
                                <button type="button" onclick="enableEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                        </form>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete()">
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
            row.querySelectorAll('input').forEach(input => input.disabled = false);
            button.classList.add('hidden');
            row.querySelector('.save-button').classList.remove('hidden');
        }

        function confirmDelete() {
            return confirm('Are you sure you want to delete this user?');
        }
    </script>
</x-app-layout>
