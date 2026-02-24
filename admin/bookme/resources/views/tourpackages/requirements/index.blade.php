<x-app-layout>
    <style>
        .ck-editor__editable {
            padding: 2.5rem !important;
            box-sizing: border-box;
            min-height: 150px;
        }

        /* Add left gap for lists inside CKEditor content */
        .ck-content ul,
        .ck-content ol {
            padding-left: 2rem !important;
            margin-left: 0 !important;
        }
    </style>

    <div class="container w-[90%] mx-auto py-8">
        <h1 class="text-xl font-bold text-gray-800 mb-8">Property Requirements</h1>

        <div class="pb-16">
            <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                class="text-white bg-blue-700 float-right hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button">
                Add Requirements
            </button>
        </div>
 <a
        href="/admin/tour%20packages/properties/{{ $destination_id }}"
        class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition-colors duration-200"
    >
        Back to Properties
    </a>
        @if ($requirements->isEmpty())
            <p class="text-gray-500 text-center">No requirements found for this property.</p>
        @else
            <div class="grid grid-cols-1 gap-8">
                @foreach ($requirements as $requirement)
                    <div class="bg-white p-6 shadow-lg rounded-lg border border-gray-200 hover:scale-105 hover:shadow-xl transition duration-300">
                        <form action="{{ route('requirements.update', $requirement->id) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PUT')
                            <label class="block font-medium text-gray-700 mb-2">Requirements:</label>
                            <textarea name="requirments" class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled rows="4">{{ $requirement->requirments }}</textarea>
                            <div class="flex justify-end space-x-2 mt-4">
                                <button type="button" onclick="enableEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                            </div>
                        </form>
                        <form action="{{ route('requirements.destroy', $requirement->id) }}" method="POST" class="inline-block mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                onclick="return confirm('Are you sure you want to delete this requirement?')">Delete</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modal -->
    <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Add New Requirement</h3>
                    <button type="button"
                        class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="static-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                    <form id="createRequirementForm" action="{{ route('requirements.store') }}" method="POST" onsubmit="return validateDuplicateRequirement()">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property_id }}" />
                        <label for="requirments" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Requirement<span class="text-red-500">*</span></label>
                        <textarea id="requirments" name="requirments" class="hidden"></textarea>
                        <div id="editor" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" rows="5" required></div>
                        <div class="flex space-x-2 mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Save</button>
                            <button type="button" data-modal-hide="static-modal" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
<script>
    let createEditor;
    let existingRequirements = @json($requirements->pluck('requirments'));

    // Initialize CKEditor with indent buttons
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: [
                'bold', 'italic', 'bulletedList', 'numberedList', 'indent', 'outdent', '|', 'undo', 'redo'
            ]
        })
        .then(editor => {
            createEditor = editor;
            editor.ui.view.editable.element.style.minHeight = '150px';

            // Update hidden textarea before form submission
            document.getElementById('createRequirementForm').addEventListener('submit', function(e) {
                document.getElementById('requirments').value = editor.getData();
            });
        })
        .catch(error => {
            console.error(error);
        });

    function enableEdit(button) {
        const form = button.closest('form');
        form.querySelectorAll('textarea').forEach(textarea => textarea.disabled = false);
        button.classList.add('hidden');
        form.querySelector('.save-button').classList.remove('hidden');
    }

    function validateDuplicateRequirement() {
        const newReq = document.getElementById('requirments').value.trim();
        if (existingRequirements.includes(newReq)) {
            alert('This requirement already exists.');
            return false;
        }
        return true;
    }
</script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    });
</script>
@endif
