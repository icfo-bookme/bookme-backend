<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <h1 class="text-2xl font-bold mb-4">Car Rental Property Details</h1>
        
        <!-- Property Info -->
        <div class="mb-8 p-6 mt-3 bg-gray-50 shadow-md mx-auto w-[95%] rounded-lg">
            <h2 class="text-2xl font-semibold mb-4">Property Name: <span class="text-blue-600">{{ $property->property_name }}</span></h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <p class="text-gray-700"><strong>District/City:</strong> {{ $property->district_city }}</p>
                <p class="text-gray-700"><strong>Address:</strong> {{ $property->address }}</p>
            </div>
        </div>
        
        <!-- Add Summary Button -->
        <div class="float-right mr-36">
            <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                class="block mb-12 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                type="button">
                Add Summary
            </button>
        </div>
        
        <!-- Modal -->
        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-5xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">Add Car Rental Property Summary</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="static-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form action="{{ route('property-summary.store') }}" method="POST" id="summaryForm">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property_id }}">
                        <div class="p-4 md:p-5 space-y-4">
                            <div id="summaryFields">
                                @php
                                    $defaultNames = ['Air Conditioning', 'Seating Capacity', 'Comfortable Interiors'];
                                    $defaultIcons = ['FaCertificate', 'MdEventSeat', 'FaStroopwafel'];
                                    $defaultLabels = ['air conditioning', 'seating capacity', 'comfortable interiors'];
                                @endphp
                                
                                @foreach ($defaultNames as $index => $name)
                                    <div class="summaryRow grid grid-cols-4 gap-4 mb-4">
                                         <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facility Name<span class="text-red-500 font-bold text-2xl">*</span></label>
                                            <select id="name" name="name[]" required
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                                                <option value="" disabled>Select a facility name<span class="text-red-500 font-bold text-2xl">*</span></option>
                                                @foreach ($names as $nameOption)
                                                    <option value="{{ $nameOption->id }}" data-name="{{ $nameOption->name }}" {{ $nameOption->name === $defaultNames[$index] ? 'selected' : '' }}>
                                                        {{ $nameOption->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="block text-sm font-medium text-gray-700">
                                                {{ ucfirst($defaultLabels[$index]) }}<span class="text-red-500 font-bold">*</span>
                                            </label>
                                            @if($defaultNames[$index] === 'Seating Capacity')
                                                <input type="number" name="value[]" class="mt-1 p-2 border border-gray-300 rounded-md w-full" placeholder="Enter seating capacity" min="1" max="20" required>
                                            @else
                                                <select name="value[]" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                                    <option value="Yes" selected>Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            @endif
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Facility icon<span class="text-red-500 font-bold">*</span>
                                            </label>
                                            <!-- Using our component - PASS THE ICONS VARIABLE -->
                                            <x-icon-select name="icon[]" :required="true" :icons="$icons"
                                                :selected="$icons->firstWhere('icon_name', $defaultIcons[$index])->id ?? null" />
                                        </div>

                                        <div class="form-group">
                                            <label class="block text-sm font-medium text-gray-700">
                                                Display<span class="text-red-500 font-bold">*</span>
                                            </label>
                                            <select name="display[]" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                                <option value="yes" selected>Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex space-x-2 mt-4">
                                <button type="button" id="addMoreBtn" class="text-white bg-green-500 px-4 py-2 rounded-md hover:bg-green-600">
                                    Add New
                                </button>
                                <button type="button" id="removeRowBtn" class="text-white bg-red-500 px-4 py-2 rounded-md hover:bg-red-600">
                                    Remove Last
                                </button>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button type="submit" class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-md">
                                Save Summaries
                            </button>
                            <button type="button" data-modal-hide="static-modal" class="ms-3 text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 px-4 py-2 rounded-md">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Summary Table -->
        <div class="w-[90%] mt-12 mx-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <table class="table-auto w-full mt-6 border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Facility Name</th>
                        <th class="px-4 py-2 border">Value</th>
                        <th class="px-4 py-2 border">Icon</th>
                        <th class="px-4 py-2 border">Display</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summaries as $summary)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('property-summary.update', $summary->id) }}" method="POST" class="update-form">
                            @csrf
                            @method('PUT')
                            <td class="px-4 py-2 border">
                                <select name="name" class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                    @foreach ($names as $name)
                                        <option value="{{ $name->id }}" data-name="{{ $name->name }}" {{ $summary->name == $name->id ? 'selected' : '' }}>
                                            {{ $name->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-2 border">
                                @php
                                    $currentName = $names->firstWhere('id', $summary->name)->name ?? '';
                                @endphp
                                @if($currentName === 'Seating Capacity')
                                    <input type="number" name="value" class="w-full border border-gray-300 rounded px-2 py-1" value="{{ $summary->value }}" min="1" max="20" disabled>
                                @else
                                    <select name="value" class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                        <option value="Yes" {{ $summary->value == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ $summary->value == 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                @endif
                            </td>
                            <td class="px-4 py-2 border">
                                <div class="icon-select-component relative w-64">
                                    <select name="icon" class="hidden" disabled>
                                        @foreach ($icons as $iconOption)
                                            <option value="{{ $iconOption->id }}" {{ $summary->icon == $iconOption->id ? 'selected' : '' }}>
                                                {{ $iconOption->icon_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <div class="custom-dropdown-trigger mt-1 p-2 border border-gray-300 rounded-md w-full bg-white cursor-pointer flex items-center justify-between">
                                        <div class="flex items-center">
                                            <span class="selected-icon-preview mr-2">
                                                @php
                                                    $icon = $icons->firstWhere('id', $summary->icon);
                                                @endphp
                                                @if($icon)
                                                    <img src="{{ asset('storage/' . $icon->image) }}" alt="{{ $icon->icon_name }}" class="w-5 h-5">
                                                @endif
                                            </span>
                                            <span class="selected-icon-text">
                                                {{ $icon->icon_name ?? 'Select Icon' }}
                                            </span>
                                        </div>
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                    
                                    <div class="custom-dropdown-content absolute left-0 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg z-50 hidden max-h-60 overflow-y-auto">
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
                            </td>
                            <td class="px-4 py-2 border">
                                <select name="display" class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                    <option value="yes" {{ $summary->display == 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ $summary->display == 'no' ? 'selected' : '' }}>No</option>
                                </select>
                            </td>
                            <td class="px-4 py-2 border flex space-x-2">
                                <button type="button" onclick="enableEdit(this)" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                    Edit
                                </button>
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">
                                    Save
                                </button>
                            </form>
                                <form action="{{ route('property-summary.destroy', $summary->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this summary?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include the JavaScript -->
    <script>
        // Icon Select Component Class
        class IconSelect {
            constructor(container) {
                this.container = container;
                this.trigger = container.querySelector('.custom-dropdown-trigger');
                this.dropdown = container.querySelector('.custom-dropdown-content');
                this.hiddenSelect = container.querySelector('select');
                this.iconPreview = container.querySelector('.selected-icon-preview');
                this.iconText = container.querySelector('.selected-icon-text');
                
                // Set initial value if exists
                const initialValue = this.hiddenSelect.value;
                if (initialValue) {
                    this.setInitialValue(initialValue);
                }
                
                this.init();
            }
            
            init() {
                // Toggle dropdown visibility
                this.trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleDropdown();
                });
                
                // Handle option selection
                this.dropdown.querySelectorAll('.dropdown-option').forEach(option => {
                    option.addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.selectOption(option);
                    });
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', (e) => {
                    if (!this.container.contains(e.target)) {
                        this.closeDropdown();
                    }
                });
                
                // Prevent form submission when interacting with dropdown
                this.container.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            }
            
            setInitialValue(value) {
                const option = this.dropdown.querySelector(`[data-value="${value}"]`);
                if (option) {
                    const iconName = option.getAttribute('data-icon-name');
                    const iconImage = option.getAttribute('data-icon-image');
                    
                    // Update display
                    this.iconPreview.innerHTML = `<img src="${iconImage}" alt="${iconName}" class="w-5 h-5">`;
                    this.iconText.textContent = iconName;
                }
            }
            
            toggleDropdown() {
                this.dropdown.classList.toggle('hidden');
                
                // Close other open dropdowns
                document.querySelectorAll('.icon-select-component .custom-dropdown-content:not(.hidden)').forEach(otherDropdown => {
                    if (otherDropdown !== this.dropdown && !otherDropdown.closest('.icon-select-component').contains(this.dropdown)) {
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
            
            // Enable or disable the dropdown
            setDisabled(disabled) {
                if (disabled) {
                    this.trigger.style.pointerEvents = 'none';
                    this.trigger.style.opacity = '0.6';
                    this.hiddenSelect.disabled = true;
                } else {
                    this.trigger.style.pointerEvents = 'auto';
                    this.trigger.style.opacity = '1';
                    this.hiddenSelect.disabled = false;
                }
            }
        }

        // Function to toggle value field based on facility name selection
        function toggleValueField(selectElement) {
            const row = selectElement.closest('.summaryRow');
            const valueContainer = row.querySelector('.form-group');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const facilityName = selectedOption.getAttribute('data-name');
            
            if (facilityName === 'Seating Capacity') {
                valueContainer.innerHTML = `
                    <label class="block text-sm font-medium text-gray-700">Value<span class="text-red-500 font-bold">*</span></label>
                    <input type="number" name="value[]" class="mt-1 p-2 border border-gray-300 rounded-md w-full" placeholder="Enter seating capacity" min="1" max="20" required>
                `;
            } else {
                valueContainer.innerHTML = `
                    <label class="block text-sm font-medium text-gray-700">Value<span class="text-red-500 font-bold">*</span></label>
                    <select name="value[]" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                        <option value="Yes" selected>Yes</option>
                        <option value="No">No</option>
                    </select>
                `;
            }
        }

        // Add/Remove row functionality
        const addMoreBtn = document.getElementById('addMoreBtn');
        const removeRowBtn = document.getElementById('removeRowBtn');
        const summaryFields = document.getElementById('summaryFields');
        const summaryForm = document.getElementById('summaryForm');

        const createNewRow = () => {
            const newSummaryRow = document.createElement('div');
            newSummaryRow.className = 'summaryRow grid grid-cols-4 gap-4 mb-4';
            newSummaryRow.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facility Name<span class="text-red-500 font-bold text-2xl">*</span></label>
                    <select name="name[]" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                        <option value="" disabled selected>Select a facility name</option>
                        @foreach ($names as $name)
                            <option value="{{ $name->id }}" data-name="{{ $name->name }}">
                                {{ $name->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700">Value<span class="text-red-500 font-bold">*</span></label>
                    <select name="value[]" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                        <option value="Yes" selected>Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Facility icon<span class="text-red-500 font-bold">*</span></label>
                    <div class="relative icon-select-component w-64">
                        <select name="icon[]" class="hidden" required>
                            <option value="" disabled selected>Select a facility icon</option>
                            @foreach ($icons as $iconOption)
                                <option value="{{ $iconOption->id }}">
                                    {{ $iconOption->icon_name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <div class="custom-dropdown-trigger mt-1 p-2 border border-gray-300 rounded-md w-full bg-white cursor-pointer flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="selected-icon-preview mr-2"></span>
                                <span class="selected-icon-text">Select a facility icon</span>
                            </div>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        
                        <div class="custom-dropdown-content absolute left-0 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg z-50 hidden max-h-60 overflow-y-auto">
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
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700">Display<span class="text-red-500 font-bold">*</span></label>
                    <select name="display[]" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                        <option value="yes" selected>Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            `;
            
            // Add event listener for facility name change
            const facilitySelect = newSummaryRow.querySelector('select[name="name[]"]');
            facilitySelect.addEventListener('change', function() {
                toggleValueField(this);
            });
            
            // Initialize the icon select for the new row
            setTimeout(() => {
                const iconSelectContainer = newSummaryRow.querySelector('.icon-select-component');
                if (iconSelectContainer) {
                    new IconSelect(iconSelectContainer);
                }
            }, 0);
            
            return newSummaryRow;
        };

        addMoreBtn.addEventListener('click', () => {
            summaryFields.appendChild(createNewRow());
        });

        removeRowBtn.addEventListener('click', () => {
            const rows = document.querySelectorAll('.summaryRow');
            if (rows.length > 3) { // Keep at least the default 3 rows
                rows[rows.length - 1].remove();
            }
        });

        // Store references to all IconSelect instances
        const iconSelectInstances = new Map();

        function enableEdit(button) {
            const row = button.closest('tr');
            const form = row.querySelector('form');
            
            // Enable all form fields
            row.querySelectorAll('select[name="name"], input[name="value"], select[name="value"], select[name="display"]').forEach(field => {
                field.disabled = false;
            });
            
            // Enable icon dropdown
            const iconSelectContainer = row.querySelector('.icon-select-component');
            if (iconSelectContainer) {
                // Check if we already have an instance for this container
                if (!iconSelectInstances.has(iconSelectContainer)) {
                    // Create new instance if it doesn't exist
                    const iconSelect = new IconSelect(iconSelectContainer);
                    iconSelectInstances.set(iconSelectContainer, iconSelect);
                }
                
                // Enable the dropdown
                const iconSelect = iconSelectInstances.get(iconSelectContainer);
                iconSelect.setDisabled(false);
                
                // Make sure the hidden select is enabled
                iconSelect.hiddenSelect.disabled = false;
            }
            
            // Show save button, hide edit button
            button.classList.add('hidden');
            row.querySelector('.save-button').classList.remove('hidden');
        }

        // Initialize all existing dropdowns on page load
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.icon-select-component').forEach(container => {
                const iconSelect = new IconSelect(container);
                iconSelectInstances.set(container, iconSelect);
                
                // Initially disable the dropdown if it's in a table row
                if (container.closest('tr')) {
                    iconSelect.setDisabled(true);
                }
            });
            
            // Add event listeners for facility name changes in modal
            document.querySelectorAll('select[name="name[]"]').forEach(select => {
                select.addEventListener('change', function() {
                    toggleValueField(this);
                });
            });
            
            // Reinitialize after form submission if page doesn't reload
            document.querySelectorAll('.update-form').forEach(form => {
                form.addEventListener('submit', () => {
                    setTimeout(() => {
                        document.querySelectorAll('.icon-select-component').forEach(container => {
                            if (!iconSelectInstances.has(container)) {
                                const iconSelect = new IconSelect(container);
                                iconSelectInstances.set(container, iconSelect);
                            }
                        });
                    }, 100);
                });
            });
        });
    </script>
</x-app-layout>