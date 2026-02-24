<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex justify-between item-center px-10 pt-10">
            <h1 class="text-2xl font-bold">Service Category: </h1>

            <div class="float-right">
                <!-- Button to Open Modal for Adding Summaries -->
                <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                    class="block mb-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">
                    Add Category 
                </button>
            </div>
        </div>
        
        <!-- Flowbite Modal for Adding Summaries -->
        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden  overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative  p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow ">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 ">
                            Add Category
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

                    <form action="{{ route('service_categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="p-4 md:p-5 space-y-4 bg-white">
                            <div id="summaryFields">
                                <div class="summaryRow grid grid-cols-2 gap-4 mb-4">
                                    <div class="form-group">
                                        <label for="category_name" class="block text-sm font-medium text-gray-700">
                                            Category Name <span class="text-red-500 font-bold text-2xl">*</span>
                                        </label>
                                        <input type="text" name="category_name"
                                            class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="block text-sm font-medium text-gray-700">
                                            Description
                                        </label>
                                        <input type="text" name="description"
                                            class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full">
                                    </div>
                                    <div class="form-group">
                                        <label for="serialno" class="block text-sm font-medium text-gray-700">
                                            Serial No
                                        </label>
                                        <input type="number" name="serialno"
                                            class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full">
                                    </div>
                                    <div class="form-group">
                                        <label for="isactive" class="block text-sm font-medium text-gray-700">
                                            Active <span class="text-red-500 font-bold text-2xl">*</span>
                                        </label>
                                        <select name="isactive"
                                            class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                            required>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                      <div class="form-group">
                                        <label for="isShow" class="block text-sm font-medium text-gray-700">
                                            Show in Homepage <span class="text-red-500 font-bold text-2xl">*</span>
                                        </label>
                                        <select name="isShow"
                                            class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                            required>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-50 focus:outline-none bg-blue-500 rounded-lg border border-gray-200 hover:bg-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto">
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

        <!-- Table to Show Existing Summaries -->
        <div class="w-[90%] mx-auto">
            <table id="example" class="table-auto w-full mt-6 border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Description</th>
                        <th class="px-4 py-2 border">isactive</th>
                        <th class="px-4 py-2 border">show in homepage</th>
                        <th class="px-4 py-2 border">Homepage Sort By</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('service_categories.update', $category->category_id) }}" method="POST" class="update-form">
                            @csrf
                            @method('PUT')

                            <td class="px-4 py-2 border">
                                <textarea name="" class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                    disabled>{{ $category->category_id }}</textarea>
                            </td>
                            <td class="px-4 py-2 border">
                                <textarea name="category_name"
                                    class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                    disabled>{{ $category->category_name }}</textarea>
                            </td>
                            <td class="px-4 py-2 border">
                                <textarea name="description"
                                    class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                    disabled>{{ $category->description }}</textarea>
                            </td>
                            <td class="px-4 py-2 border">
                                <select name="isactive" class="w-full border border-gray-300 rounded px-2 py-1 isactive-select" disabled>
                                    <option value="1" {{ $category->isactive == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $category->isactive == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </td>
                            <td class="px-4 py-2 border">
                                <select name="isShow" class="w-full border border-gray-300 rounded px-2 py-1 isShow-select" disabled>
                                    <option value="yes" {{ $category->isShow == 'yes' ? 'selected' : '' }}>yes</option>
                                    <option value="no" {{ $category->isShow == 'no' ? 'selected' : '' }}>no</option>
                                </select>
                            </td>
                            <td class="px-4 py-2 border">
                                <textarea name="serialno"
                                    class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                    disabled>{{ $category->serialno }}</textarea>
                            </td>

                            <td class="px-4 py-2 border flex flex-col space-y-2">
                                <div class="flex space-x-2">
                                    <!-- Edit Button -->
                                    <button type="button" onclick="enableEdit(this)"
                                        class="edit-btn bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                    <!-- Save Button -->
                                    <button type="submit"
                                        class="save-btn bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden">Save</button>
                                    
                                   <a href="{{ url('/' . \Illuminate\Support\Str::slug($category->category_name)) }}">
    <button type="button" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-900">
        Add_Details
    </button>
</a>


                                </div>
                                <!-- Cancel Button -->
                                <button type="button" onclick="cancelEdit(this)"
                                    class="cancel-btn bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 hidden">Cancel</button>
                            </td>
                        </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    // Add More Button functionality for adding new rows
    const addMoreBtn = document.getElementById('addMoreBtn');
    const removeRowBtn = document.getElementById('removeRowBtn');
    const summaryFields = document.getElementById('summaryFields');

    if (addMoreBtn) {
        addMoreBtn.addEventListener('click', () => {
            const newSummaryRow = document.querySelector('.summaryRow').cloneNode(true);
            newSummaryRow.querySelectorAll('input, select').forEach(input => input.value = '');
            summaryFields.appendChild(newSummaryRow);
        });
    }

    if (removeRowBtn) {
        removeRowBtn.addEventListener('click', () => {
            const rows = document.querySelectorAll('.summaryRow');
            if (rows.length > 1) {
                rows[rows.length - 1].remove();
            } else {
                alert('At least one row must remain!');
            }
        });
    }

    function enableEdit(button) {
        // First, disable all other edit modes if any are active
        document.querySelectorAll('.cancel-btn').forEach(cancelBtn => {
            if (!cancelBtn.classList.contains('hidden')) {
                cancelEdit(cancelBtn);
            }
        });

        const row = button.closest('tr');
        row.querySelectorAll('textarea').forEach(el => el.disabled = false);
        row.querySelectorAll('select').forEach(el => el.disabled = false);
        
        // Hide edit button, show save and cancel buttons
        row.querySelector('.edit-btn').classList.add('hidden');
        row.querySelector('.save-btn').classList.remove('hidden');
        row.querySelector('.cancel-btn').classList.remove('hidden');
    }

    function cancelEdit(button) {
        const row = button.closest('tr');
        row.querySelectorAll('textarea').forEach(el => el.disabled = true);
        row.querySelectorAll('select').forEach(el => el.disabled = true);
        
        // Show edit button, hide save and cancel buttons
        row.querySelector('.edit-btn').classList.remove('hidden');
        row.querySelector('.save-btn').classList.add('hidden');
        row.querySelector('.cancel-btn').classList.add('hidden');
    }
    
    function confirmDelete(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
                form.appendChild(csrfToken);
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Show success/error messages
    @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif
    </script>

    <style>
        /* SweetAlert2 custom styles */
        .swal2-confirm {
            background-color: #1e40af !important;
        }
        .swal2-confirm:hover {
            background-color: #1e3a8a !important;
        }
        .swal2-cancel {
            background-color: #dc2626 !important;
        }
        .swal2-cancel:hover {
            background-color: #b91c1c !important;
        }
    </style>
</x-app-layout>