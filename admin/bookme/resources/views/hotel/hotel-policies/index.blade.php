<x-app-layout>
    <div class="container w-[90%] mx-auto py-8">
        <!-- Page Title -->
        <h1 class="text-xl font-bold text-gray-800 mb-8">Hotel Policy Details</h1>
<a href="{{ url('/hotel/' . $destination_id) }}" class="inline-flex items-center px-3 py-1 bg-green-900 text-white rounded hover:bg-yellow-600 text-sm">
                        Back To Hotel List
                    </a>
        <!-- Success Alert -->
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                });
            </script>
        @endif

        <!-- Add Policy Button -->
        <div class="pb-16">
            <button data-modal-target="policy-modal" data-modal-toggle="policy-modal"
                class="text-white bg-blue-700 float-right hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Add Policy
            </button>
        </div>

        <!-- Policies Display -->
        @if ($policies->isEmpty())
            <p class="text-gray-500 text-center">No hotel policies available.</p>
        @else
            <div class="space-y-6">
                @foreach ($policies as $policy)
                <div class="bg-white p-6 shadow rounded-lg border border-gray-200">
                    <form action="{{ route('hotel-policies.update', $policy->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                            <!-- Icon Preview -->
                            <div>
                                <label class="block font-medium text-gray-700">Icon Preview:</label>
                                <div id="icon-preview-{{ $policy->id }}" class="mt-1 text-blue-600 text-2xl">
                                    <i class="{{ $policy->icon_class }}"></i>
                                </div>
                            </div>

                            <!-- Icon Class Input -->
                            <div>
                                <label class="block font-medium text-gray-700">Icon Class:</label>
                                <input 
                                    type="text" 
                                    name="icon_class" 
                                    value="{{ $policy->icon_class }}" 
                                    class="w-full border border-gray-300 rounded px-2 py-1 icon-input"
                                    data-preview-id="icon-preview-{{ $policy->id }}"
                                    disabled
                                >
                                <p class="text-sm text-gray-500">e.g. fa-solid fa-paw</p>
                            </div>

                            <!-- Policy Name -->
                            <div>
                                <label class="block font-medium text-gray-700">Name:</label>
                                <select name="name" class="w-full border border-gray-300 rounded px-2 py-1 policy-name-select" disabled
                                    onchange="updateIconClassFromName(this, '{{ $policy->id }}')">
                                    <option value="">Select Policy Name</option>
                                    <option value="Check In" {{ $policy->name == 'Check In' ? 'selected' : '' }}>Check In</option>
                                    <option value="Check Out" {{ $policy->name == 'Check Out' ? 'selected' : '' }}>Check Out</option>
                                    <option value="Instructions" {{ $policy->name == 'Instructions' ? 'selected' : '' }}>Instructions</option>
                                    <option value="Special Instructions" {{ $policy->name == 'Special Instructions' ? 'selected' : '' }}>Special Instructions</option>
                                    <option value="Child Policy" {{ $policy->name == 'Child Policy' ? 'selected' : '' }}>Child Policy</option>
                                    <option value="Pet Policy" {{ $policy->name == 'Pet Policy' ? 'selected' : '' }}>Pet Policy</option>
                                    <option value="House Rules" {{ $policy->name == 'House Rules' ? 'selected' : '' }}>House Rules</option>
                                    <option value="Property Accepts" {{ $policy->name == 'Property Accepts' ? 'selected' : '' }}>Property Accepts</option>
                                </select>
                            </div>

                            <!-- Policy Value -->
                            <div>
                                <label class="block font-medium text-gray-700">Value:</label>
                                <textarea name="value" class="ckeditor w-full border border-gray-300 rounded px-2 py-1"
                                    disabled>{{ $policy->value }}</textarea>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-2 mt-4">
                            <button type="button" onclick="enableEdit(this, '{{ $policy->id }}')"
                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                            <button type="submit"
                                class="save-button hidden bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Save</button>
                        </div>
                    </form>

                    <!-- Delete Button -->
                    <form action="{{ route('hotel-policies.destroy', $policy->id) }}" method="POST" class="mt-2 inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                    </form>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Add Policy Modal -->
    <div id="policy-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">Add Hotel Policy</h3>
                    <button type="button" data-modal-hide="policy-modal"
                        class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form action="{{ route('hotel-policies.store') }}" method="POST">
                        @csrf
                        <div class="hidden">
                            <input type="number" id="hotel_id" name="hotel_id" required value={{$hotel_id}}
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></div>
                        
                        <!-- Policy Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Policy Name <span class="text-red-500">*</span></label>
                            <select id="policy-name-select" name="name" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                onchange="updateModalIconClassFromName(this)">
                                <option value="">Select Policy Name</option>
                                <option value="Check In">Check In</option>
                                <option value="Check Out">Check Out</option>
                                <option value="Instructions">Instructions</option>
                                <option value="Special Instructions">Special Instructions</option>
                                <option value="Child Policy">Child Policy</option>
                                <option value="Pet Policy">Pet Policy</option>
                                <option value="House Rules">House Rules</option>
                                <option value="Property Accepts">Property Accepts</option>
                            </select>
                        </div>

                        <!-- Policy Value -->
                        <div class="mb-4">
                            <label for="value" class="block text-sm font-medium text-gray-700">Policy Value <span class="text-red-500">*</span></label>
                            <textarea id="value" name="value" class="ckeditor mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                        </div>
                        
                        <!-- Icon Class -->
                        <div class="form-group">
                            <label for="icon_class" class="block text-sm font-medium text-gray-700">Icon Class 
                                <span class="text-red-500 font-bold text-2xl">*</span></label>
                            <input type="text" id="icon-class-input" name="icon_class" placeholder="e.g. fa-solid fa-snowflake"
                                class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                required readonly>
                            <p class="mt-1 text-sm text-gray-500">Icon class will be auto-filled based on policy name</p>
                            
                            <div class="mt-2">
                                <label class="block text-sm font-medium text-gray-700">Preview:</label>
                                <div id="icon-preview" class="mt-2 p-4 border rounded-lg text-center">
                                    <i class="text-4xl text-gray-600"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-2 mt-4">
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
                            <button type="button" data-modal-hide="policy-modal"
                                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Include Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- CKEditor and JS Logic -->
<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
<script>
    // Initialize CKEditor for all policy textareas
    document.querySelectorAll('.ckeditor').forEach((textarea) => {
        ClassicEditor
            .create(textarea)
            .catch(error => console.error(error));
    });

    // Policy name to icon class mapping
    const policyIcons = {
        'Check In': 'fa-solid fa-door-open',
        'Check Out': 'fa-solid fa-door-closed',
        'Instructions': 'fa-solid fa-list-check',
        'Special Instructions': 'fa-solid fa-clipboard-list',
        'Child Policy': 'fa-solid fa-child',
        'Pet Policy': 'fa-solid fa-paw',
        'House Rules': 'fa-solid fa-house',
        'Property Accepts': 'fa-solid fa-check-circle'
    };

    // Enable inline editing of policy
    function enableEdit(button, policyId) {
        const form = button.closest('form');
        form.querySelectorAll('textarea, input, select').forEach(el => el.disabled = false);
        button.classList.add('hidden');
        form.querySelector('.save-button').classList.remove('hidden');
    }
    
    // Update icon class based on selected name in edit mode
    function updateIconClassFromName(selectElement, policyId) {
        const selectedName = selectElement.value;
        const iconClass = policyIcons[selectedName] || '';
        
        const iconInput = selectElement.closest('form').querySelector('input[name="icon_class"]');
        iconInput.value = iconClass;
        
        updateEditIconPreview(policyId);
    }
    
    // Update icon preview in edit mode
    function updateEditIconPreview(policyId) {
        const input = document.querySelector(`input[name="icon_class"][data-preview-id="icon-preview-${policyId}"]`);
        const preview = document.getElementById(`icon-preview-${policyId}`);
        if (input && preview) {
            preview.innerHTML = `<i class="${input.value} text-2xl text-blue-600"></i>`;
        }
    }

    // Update icon class based on selected name in modal
    function updateModalIconClassFromName(selectElement) {
        const selectedName = selectElement.value;
        const iconClass = policyIcons[selectedName] || '';
        
        const iconInput = document.getElementById('icon-class-input');
        iconInput.value = iconClass;
        
        updateIconPreview();
    }

    // Update icon preview in add modal
    function updateIconPreview() {
        const input = document.getElementById('icon-class-input');
        const preview = document.getElementById('icon-preview');
        preview.innerHTML = `<i class="${input.value} text-4xl text-gray-600"></i>`;
    }

    // Initialize icon preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any existing previews
        updateIconPreview();
        
        // Initialize edit mode previews
        document.querySelectorAll('.icon-input').forEach(input => {
            const previewId = input.getAttribute('data-preview-id');
            const policyId = previewId.split('-')[2];
            updateEditIconPreview(policyId);
        });
    });
</script>