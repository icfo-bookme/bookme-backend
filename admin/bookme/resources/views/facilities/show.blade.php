<x-app-layout>
    <div class="container w-[90%] mx-auto py-8">
        <!-- Page Title -->
        <h1 class="text-xl font-bold text-gray-800 mb-8 ">Property Facility Details</h1>
       @if ($category_id == 6)
    <a
        href="/admin/activities/properties/{{ $property->destination_id }}"
        class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition-colors duration-200"
    >
        Back to Properties
    </a>
     @elseif ($category_id == 5)
    <a
        href="/admin/tour%20packages/properties/{{ $property->destination_id }}"
        class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition-colors duration-200"
    >
        Back to Properties
    </a>
@else
    <a
        href="/admin/ships/properties/{{ $property->destination_id }}"
        class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition-colors duration-200"
    >
        Back to Properties
    </a>
@endif

       
        
        <!-- Property Information -->
        <div class="mb-8 p-6 bg-gray-50 shadow-md rounded-lg">
            <h2 class="text-2xl font-semibold mb-4">Property Name: <span class="text-blue-600">{{ $property->property_name }}</span></h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <p class="text-gray-700"><strong>District/City:</strong> {{ $property->district_city }}</p>
                <p class="text-gray-700"><strong>Address:</strong> {{ $property->address }}</p>
            </div>
        </div>

        <div class="pb-16">
            <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                class="text-white bg-blue-700  float-right  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button">
                Add Facility
            </button>
        </div>

        <!-- Facilities Section -->
        @if ($property->facilities->isEmpty())
            <p class="text-gray-500 text-center">No facilities found for this property.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-8">
                @foreach ($property->facilities as $facility)
                    <div class="bg-white p-6 shadow-lg rounded-lg border border-gray-200 ">
                        <form action="{{ route('facilities.update', $facility->id) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <div class="mb-4">
                                        <label class="block font-medium text-gray-700 mb-1">Facility Type:</label>
                                        <select name="facility_type" class="w-full border border-gray-300 rounded px-3 py-2 bg-white">
                                            <option value="">Select a facility type</option>
                                            @foreach ($facilitiestype as $type)
                                                <option value="{{ $type->id }}" {{ $facility->facility_type == $type->id ? 'selected' : '' }}>
                                                    {{ $type->facility_typename }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block font-medium text-gray-700 mb-1">Icon:</label>
                                        <div class="icon-select-component">
                                            <select name="icon" class="hidden">
                                                <option value="">Select a facility icon</option>
                                                @foreach ($icons as $iconOption)
                                                    <option value="{{ $iconOption->id }}" {{ $facility->icon == $iconOption->id ? 'selected' : '' }}>
                                                        {{ $iconOption->icon_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                            <!-- Custom dropdown trigger -->
                                            <div class="custom-dropdown-trigger mt-1 p-2 border border-gray-300 rounded-md w-full bg-white cursor-pointer flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <span class="selected-icon-preview mr-2">
                                                        @if($facility->icon)
                                                            @php
                                                                $selectedIcon = $icons->firstWhere('id', $facility->icon);
                                                            @endphp
                                                            @if($selectedIcon)
                                                                <img src="{{ asset('storage/' . $selectedIcon->image) }}" alt="{{ $selectedIcon->icon_name }}" class="w-5 h-5">
                                                            @endif
                                                        @endif
                                                    </span>
                                                    <span class="selected-icon-text">
                                                        @if($facility->icon)
                                                            @php
                                                                $selectedIcon = $icons->firstWhere('id', $facility->icon);
                                                            @endphp
                                                            {{ $selectedIcon ? $selectedIcon->icon_name : 'Select a facility icon' }}
                                                        @else
                                                            Select a facility icon
                                                        @endif
                                                    </span>
                                                </div>
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                            
                                            <!-- Custom dropdown content -->
                                            <div class="custom-dropdown-content absolute left-0 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden max-h-60 overflow-y-auto">
                                                @foreach ($icons as $iconOption)
                                                    <div class="dropdown-option flex items-center px-3 py-2 cursor-pointer hover:bg-blue-50" 
                                                         data-value="{{ $iconOption->id }}" 
                                                         data-icon-name="{{ $iconOption->icon_name }}"
                                                         data-icon-image="{{ asset('storage/' . $iconOption->image) }}">
                                                        <img src="{{ asset('storage/' . $iconOption->image) }}" alt="{{ $iconOption->icon_name }}" class="w-5 h-5 mr-2">
                                                        <span>{{ $iconOption->icon_name }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="block font-medium h-8 text-gray-700">Value:</label>
                                    <!-- CKEditor for the 'value' field -->
                                    <textarea id="value-{{ $facility->id }}" name="value" class="ckeditor w-full  border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ $facility->value }}</textarea>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2 mt-4">
                                <button type="button" onclick="enableEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                            </div>
                            
                        </form>
                        <form action="{{ route('facilities.destroy', $facility->id ) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
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
            <!-- Modal Content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Add New Facility</h3>
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

                <!-- Modal Body -->
                <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                   
                    <form action="{{ route('facilities.store') }}" method="POST" enctype="multipart/form-data"  onsubmit="return validateDuplicateFacility()">
                        @csrf
                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
                            <!-- Property ID -->
                            <div class="hidden">
                                <label for="property_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Property ID</label>
                                <input type="number" id="property_id" name="property_id" required readonly value="{{ $id }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                            </div>

                            <!-- Facility Type -->
                            <div>
                                <label for="facility_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facility Type<span class="text-red-500 font-bold text-2xl">*</span></label>
                                <select id="facility_type" name="facility_type" 
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                                    <option value="" disabled selected>Select a facility type</option>
                                    @foreach ($facilitiestype as $facility)
                                        <option value="{{ $facility->id }}">{{ $facility->facility_typename }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Facility Name -->
                            <div>
                                <label for="facility_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facility Name</label>
                                <input type="text" id="facility_name" name="facility_name" 
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                            </div>

                            <!-- Value -->
                            <div>
                                <label for="value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Value<span class="text-red-500 font-bold text-2xl">*</span></label>
                                <textarea id="value" name="value"
                                    class="ckeditor mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white"></textarea>
                            </div>

                            <!-- Image -->
                            <div>
                                <label for="img" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image<span class="text-red-500 font-bold text-2xl">*</span></label>
                                <input type="file" id="img" name="img"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                            </div>
                            
                            <!-- Icon Select -->
                            <div>
                                <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facility icon<span class="text-red-500 font-bold text-2xl">*</span></label>
                                <div class="relative icon-select-component">
                                    <!-- Hidden select for form submission -->
                                    <select id="icon" name="icon" required class="hidden">
                                        <option value="" disabled selected>Select a facility icon</option>
                                        @foreach ($icons as $iconOption)
                                            <option value="{{ $iconOption->id }}">{{ $iconOption->icon_name }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <!-- Custom dropdown trigger -->
                                    <div class="custom-dropdown-trigger mt-1 p-2 border border-gray-300 rounded-md w-full bg-white cursor-pointer flex items-center justify-between">
                                        <div class="flex items-center">
                                            <span class="selected-icon-preview mr-2"></span>
                                            <span class="selected-icon-text">Select a facility icon</span>
                                        </div>
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                    
                                    <!-- Custom dropdown content -->
                                    <div class="custom-dropdown-content absolute left-0 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden max-h-60 overflow-y-auto">
                                        @foreach ($icons as $iconOption)
                                            <div class="dropdown-option flex items-center px-3 py-2 cursor-pointer hover:bg-blue-50" 
                                                 data-value="{{ $iconOption->id }}" 
                                                 data-icon-name="{{ $iconOption->icon_name }}"
                                                 data-icon-image="{{ asset('storage/' . $iconOption->image) }}">
                                                <img src="{{ asset('storage/' . $iconOption->image) }}" alt="{{ $iconOption->icon_name }}" class="w-5 h-5 mr-2">
                                                <span>{{ $iconOption->icon_name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Active -->
                            <div>
                                <label for="isactive" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Active<span class="text-red-500 font-bold text-2xl">*</span></label>
                                <select id="isactive" name="isactive" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div>
                                <label for="serialno"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Serial
                                    No</label>
                                <input type="number" id="serialno" name="serialno"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                            </div>
                            <!-- Buttons -->
                            <div class="flex  space-x-2 mt-4">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Save</button>
                                <button type="button" data-modal-hide="static-modal"
                                    class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
<script>
    // Initialize CKEditor on all textarea elements with the class 'ckeditor'
    document.querySelectorAll('.ckeditor').forEach((textarea) => {
        ClassicEditor
            .create(textarea)
            .catch(error => {
                console.error(error);
            });
    });

    // Icon Select Component Class
    class IconSelect {
        constructor(container) {
            this.container = container;
            this.trigger = container.querySelector('.custom-dropdown-trigger');
            this.dropdown = container.querySelector('.custom-dropdown-content');
            this.hiddenSelect = container.querySelector('select');
            this.iconPreview = container.querySelector('.selected-icon-preview');
            this.iconText = container.querySelector('.selected-icon-text');
            
            this.init();
        }
        
        init() {
            // Set initial value if already selected
            const initialValue = this.hiddenSelect.value;
            if (initialValue) {
                this.setValue(initialValue);
            }
            
            // Toggle dropdown visibility
            this.trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleDropdown();
            });
            
            // Handle option selection
            this.dropdown.querySelectorAll('.dropdown-option').forEach(option => {
                option.addEventListener('click', () => {
                    this.selectOption(option);
                });
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!this.container.contains(e.target)) {
                    this.closeDropdown();
                }
            });
        }
        
        toggleDropdown() {
            this.dropdown.classList.toggle('hidden');
            
            // Close other open dropdowns
            document.querySelectorAll('.icon-select-component .custom-dropdown-content:not(.hidden)').forEach(otherDropdown => {
                if (otherDropdown !== this.dropdown) {
                    otherDropdown.classList.add('hidden');
                }
            });
        }
        
        closeDropdown() {
            this.dropdown.classList.add('hidden');
        }
        
        selectOption(option) {
            const value = option.getAttribute('data-value');
            const iconName = option.getAttribute('data-icon-name');
            const iconImage = option.getAttribute('data-icon-image');
            
            // Update hidden select
            this.hiddenSelect.value = value;
            
            // Update display
            this.iconPreview.innerHTML = `<img src="${iconImage}" alt="${iconName}" class="w-5 h-5">`;
            this.iconText.textContent = iconName;
            
            // Close dropdown
            this.closeDropdown();
            
            // Dispatch change event
            this.hiddenSelect.dispatchEvent(new Event('change'));
        }
        
        // Public method to set value programmatically
        setValue(value) {
            const option = this.dropdown.querySelector(`[data-value="${value}"]`);
            if (option) {
                this.selectOption(option);
            }
        }
        
        // Public method to get value
        getValue() {
            return this.hiddenSelect.value;
        }
    }

    // Initialize all icon selects on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.icon-select-component').forEach(container => {
            new IconSelect(container);
        });
    });

    // Enable the Edit button to toggle Save button visibility
    function enableEdit(button) {
        const form = button.closest('form');
        form.querySelector('.save-button').classList.remove('hidden');
        form.querySelectorAll('textarea').forEach(textarea => {
            textarea.disabled = false;
        });
        
        // Also enable the icon dropdown
        const iconSelectComponent = form.querySelector('.icon-select-component');
        if (iconSelectComponent) {
            const trigger = iconSelectComponent.querySelector('.custom-dropdown-trigger');
            trigger.style.pointerEvents = 'auto';
            trigger.style.opacity = '1';
        }
    }

    function validateDuplicateFacility() {
        let selectedFacilityType = document.getElementById('facility_type').value.trim();
        let selectedFacilityName = document.getElementById('facility_name').value.trim();
        let selectedFacilityValue = document.getElementById('value').value.trim();
        
        // Parse facilities passed from backend as JSON
        let facilities = @json($property->facilities);

        // Check for a duplicate entry where all three values match
        let isDuplicate = facilities.some(facility => 
            facility.facility_type === selectedFacilityType &&
            facility.facility_name === selectedFacilityName &&
            facility.value === selectedFacilityValue
        );

        if (isDuplicate) {
            alert('This combination of facility type, name, and value already exists.');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
</script>

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

<style>
    .custom-dropdown-trigger {
        min-height: 42px;
    }
    .custom-dropdown-content {
        scrollbar-width: thin;
    }
    .custom-dropdown-content::-webkit-scrollbar {
        width: 6px;
    }
    .custom-dropdown-content::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 3px;
    }
    
    /* Ensure images display properly */
    .selected-icon-preview img,
    .dropdown-option img {
        display: block;
        object-fit: contain;
    }
</style>