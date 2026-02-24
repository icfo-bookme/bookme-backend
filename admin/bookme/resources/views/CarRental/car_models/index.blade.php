<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex items-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Car Models</h1>
            <div class="float-right">
                <button data-modal-target="model-modal" data-modal-toggle="model-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Add Model
                </button>
            </div>
        </div>

        {{-- Modal for Adding Car Model --}}
        <div id="model-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">Add Car Model</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="model-modal">
                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <form action="{{ route('car-models.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="p-4 md:p-5 space-y-4">
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <div>
                                    <label for="brand_id" class="block text-sm font-medium text-gray-700">
                                        Brand <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <select name="brand_id" id="brand_id" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                                        <option value="">Select Brand</option>
                                        @foreach($carBrands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="model_name" class="block text-sm font-medium text-gray-700">
                                        Model Name <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <input type="text" name="model_name" id="model_name"
                                        class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">
                                        Status <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <select name="status" id="status" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700">
                                        Image
                                    </label>
                                    <input type="file" name="image" id="image"
                                        class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center px-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save Model</button>
                            <button type="button" data-modal-hide="model-modal" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        <div class="w-[90%] mt-12 mx-auto">
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

            {{-- Table --}}
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Model Name</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Image</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carModels as $model)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('car-models.update', $model->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <td class="px-4 py-2 border">{{ $model->id }}</td>

                            {{-- Model Name --}}
                            <td class="px-4 py-2 border">
                                <textarea name="model_name" class="w-full border border-gray-300 rounded px-2 py-1 resize-none model-name" readonly>{{ $model->model_name }}</textarea>
                                <input type="hidden" name="brand_id" value="{{ $model->brand_id }}">
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-2 border">
                                <select name="status" class="border rounded px-2 py-1 status-select" disabled>
                                    <option value="active" {{ $model->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $model->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </td>

                            {{-- Image --}}
                            <td class="px-4 py-2 border">
                                @if($model->image)
                                    <img src="{{ asset('storage/' . $model->image) }}" alt="Car Image" class="w-20 h-20 object-cover mb-2 rounded">
                                @endif
                                <input type="file" name="image" class="border border-gray-300 rounded p-1 w-full image-input hidden">
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-2 border flex space-x-2">
                                <button type="button" onclick="enableEdit(this)" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                        </form>
                        <form action="{{ route('car-models.destroy', $model->id) }}" method="POST" class="inline-block">
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

    {{-- Enable Edit Script --}}
    <script>
        function enableEdit(button) {
            const row = button.closest('tr');

            // Enable fields
            row.querySelector('.model-name').removeAttribute('readonly');
            row.querySelector('.status-select').removeAttribute('disabled');
            row.querySelector('.image-input').classList.remove('hidden');

            // Show Save button, hide Edit button
            button.classList.add('hidden');
            row.querySelector('.save-button').classList.remove('hidden');
        }
    </script>
</x-app-layout>
