<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Receipt</h2>
            <a href="{{ route('receipts.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">← Back to Receipts</a>
        </div>
    </x-slot>
    
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
    
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('receipts.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="selected_property_id" name="property_id">

                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Receipt Information</h3>
                        <p class="text-sm text-gray-600 mt-1">Fill in the customer and receipt details</p>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Customer & Service Info -->
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Order Details</h4>

                                    <div>
                                        <x-input-label for="service" value="Select Service" />
                                        <select id="service" name="service" class="block w-full mt-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Choose a Service --</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->category_id }}">{{ $service->category_name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('service')" class="mt-2" />
                                    </div>

                                    <!-- Property and Packages Fields - Always Visible -->
                                    <div id="ships_fields" class="mt-4 space-y-4">
                                        <!-- Property Autocomplete -->
                                        <div class="relative">
                                            <x-input-label for="property" value="Property/Hotel/Route/Packages/Activities/Country" />
                                            <x-text-input id="property" type="text" class="mt-1 block w-full pr-10" placeholder="Search Property/Hotel/Route/Packages/Activities..." autocomplete="off" />
                                            <div id="property_loading" class="hidden absolute inset-y-0 right-0 pr-3 flex items-center">
                                                <svg class="animate-spin h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                            <div id="property_suggestions" class="absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-auto"></div>
                                            <x-input-error :messages="$errors->get('property_id')" class="mt-2" />
                                        </div>

                                        <!-- Packages - Updated to input with datalist -->
                                        <div>
                                            <x-input-label for="packages" value="Packages/Units" />
                                            <x-text-input 
                                                id="packages" 
                                                type="text" 
                                                name="packages" 
                                                class="mt-1 block w-full" 
                                                placeholder="Type or select a package..." 
                                                list="packages_options"
                                                autocomplete="off"
                                                disabled
                                            />
                                            <datalist id="packages_options">
                                                <!-- Options will be populated dynamically -->
                                            </datalist>
                                            <input type="hidden" id="selected_package_id" name="package_id">
                                            <div id="packages_loading" class="hidden mt-2 text-sm text-gray-500">Loading packages...</div>

                                            <!-- Price Info -->
                                            <div id="price_info" class="hidden mt-2 p-3 bg-blue-50 rounded-lg">
                                                <div class="grid grid-cols-2 gap-2 text-sm">
                                                    <div class="font-medium text-gray-700">Original Price:</div>
                                                    <div id="original_price" class="text-gray-900">-</div>

                                                    <div class="font-medium text-gray-700">Discount:</div>
                                                    <div id="discount_amount" class="text-green-600">-</div>

                                                    <div class="font-medium text-gray-700">Final Price:</div>
                                                    <div id="final_price" class="text-lg font-bold text-blue-700">-</div>
                                                </div>
                                            </div>

                                            <x-input-error :messages="$errors->get('packages')" class="mt-2" />
                                        </div>
                                        
                                        <div>
                                            <x-input-label for="date_time" value="Date & Time" :required="true" />
                                            <x-text-input id="date_time" type="datetime-local" name="date_time" class="mt-1 block w-full" required />
                                        </div>
                                    </div>

                                    <!-- Customer Details -->
                                    <h4 class="text-md font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200 mt-6">Customer Details</h4>
                                    <div class="space-y-4">
                                        <div class="relative">
                                            <x-input-label for="customer_phone" value="Phone Number" :required="true" />
                                            <x-text-input id="customer_phone" type="text" name="customer_phone" class="mt-1 block w-full pr-10" placeholder="+1 (555) 123-4567" autocomplete="off" required />
                                            <div id="loading_spinner" class="hidden absolute inset-y-0 right-0 pr-3 flex items-center">
                                                <svg class="animate-spin h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                            <div id="phone_suggestions" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-auto"></div>
                                            <x-input-error :messages="$errors->get('customer_phone')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="customer_name" value="Full Name" :required="true" />
                                            <x-text-input id="customer_name" type="text" name="customer_name" class="mt-1 block w-full" placeholder="Enter customer full name" required />
                                            <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="customer_email" value="Email Address" />
                                            <x-text-input id="customer_email" type="email" name="customer_email" class="mt-1 block w-full" placeholder="customer@example.com" />
                                            <x-input-error :messages="$errors->get('customer_email')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="notes" value="Additional Notes" />
                                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Any additional information..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Receipt Details -->
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Receipt Details</h4>

                                    <div class="space-y-4">
                                        <div>
                                            <x-input-label for="issued_date" value="Issued Date" :required="true" />
                                            <x-text-input id="issued_date" type="date" name="issued_date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                                        </div>

                                        <!-- Amount Details -->
                                        <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                                            <h5 class="text-sm font-medium text-gray-700">Amount Details</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <x-input-label for="total_payable" value="Total Payable" :required="true" />
                                                    <div class="relative mt-1">
                                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"><span class="text-gray-500"></span></div>
                                                        <x-text-input id="total_payable" type="number" step="0.01" name="total_payable" class="block w-full pl-7" placeholder="0.00" required />
                                                    </div>
                                                </div>
                                                <div>
                                                    <x-input-label for="paid_amount" value="Paid Amount" :required="true" />
                                                    <div class="relative mt-1">
                                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"><span class="text-gray-500"></span></div>
                                                        <x-text-input id="paid_amount" type="number" step="0.01" name="paid_amount" class="block w-full pl-7" placeholder="0.00" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <x-input-label for="special_discount" value="Special Discount" />
                                                    <div class="relative mt-1">
                                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"><span class="text-gray-500"></span></div>
                                                        <x-text-input id="special_discount" type="number" step="0.01" name="special_discount" class="block w-full pl-7" placeholder="0.00" value="0" />
                                                    </div>
                                                </div>
                                                <div>
                                                    <x-input-label for="balance_due" value="Balance Due" />
                                                    <div class="relative mt-1">
                                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"><span class="text-gray-500"></span></div>
                                                        <x-text-input id="balance_due" type="number" step="0.01" name="balance_due" class="block w-full pl-7 bg-gray-100" placeholder="0.00" value="0.00" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Buttons -->
                        <div class="flex justify-end space-x-4 pt-6 mt-8 border-t border-gray-200">
                            <x-secondary-button type="button" onclick="window.location='{{ route('receipts.index') }}'">Cancel</x-secondary-button>
                            <x-primary-button type="submit">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Create Receipt
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceSelect = document.getElementById('service');
        const propertyInput = document.getElementById('property');
        const propertySuggestions = document.getElementById('property_suggestions');
        const propertyLoading = document.getElementById('property_loading');
        const packagesInput = document.getElementById('packages');
        const packagesDatalist = document.getElementById('packages_options');
        const packageIdInput = document.getElementById('selected_package_id');
        const packagesLoading = document.getElementById('packages_loading');
        const priceInfo = document.getElementById('price_info');
        const originalPriceEl = document.getElementById('original_price');
        const discountAmountEl = document.getElementById('discount_amount');
        const finalPriceEl = document.getElementById('final_price');
        const totalInput = document.getElementById('total_payable');
        const paidInput = document.getElementById('paid_amount');
        const discountInput = document.getElementById('special_discount');
        const balanceInput = document.getElementById('balance_due');
        const phoneInput = document.getElementById('customer_phone');
        const nameInput = document.getElementById('customer_name');
        const emailInput = document.getElementById('customer_email');
        const suggestionsDiv = document.getElementById('phone_suggestions');
        const loadingSpinner = document.getElementById('loading_spinner');
        
        let selectedPropertyId = null;
        let packagesData = {};
        let propertyDebounceTimer;
        let propertyCurrentFocus = -1;
        let customerDebounceTimer;
        let customerFocus = -1;
        let currentServiceCategory = null;

        // Service select - conditionally enable/disable packages
        serviceSelect.addEventListener('change', function() {
            const val = this.value;
            currentServiceCategory = val;
            
            // Clear previous selections
            propertyInput.value = '';
            packagesInput.value = '';
            packagesDatalist.innerHTML = '';
            packageIdInput.value = '';
            document.getElementById('selected_property_id').value = '';
            priceInfo.classList.add('hidden');
            selectedPropertyId = null;
            packagesData = {};
            totalInput.value = '';
            discountInput.value = '0';
            calculateBalance();
            
            // Handle service category 5 (no packages)
            if (val === '5' || val === '2') {
                packagesInput.disabled = true;
                packagesInput.placeholder = "No packages available for this service";
            } else {
                packagesInput.disabled = false;
                packagesInput.placeholder = "Type or select a package...";
            }
        });

        // Property autocomplete
        propertyInput.addEventListener('input', function() {
            const query = this.value.trim();
            clearTimeout(propertyDebounceTimer);
            if (query.length < 2) { 
                propertySuggestions.classList.add('hidden'); 
                propertyLoading.classList.add('hidden'); 
                return; 
            }
            propertyLoading.classList.remove('hidden');

            propertyDebounceTimer = setTimeout(() => {
                const categoryId = serviceSelect.value;
                fetch(`/admin/receipt/search-properties?q=${encodeURIComponent(query)}&category_id=${categoryId}`, {
                    headers: {'X-Requested-With': 'XMLHttpRequest','Accept': 'application/json'}
                })
                .then(res => res.ok ? res.json() : [])
                .then(data => {
                    propertyLoading.classList.add('hidden');
                    displayPropertySuggestions(data);
                }).catch(() => {
                    propertyLoading.classList.add('hidden');
                    propertySuggestions.innerHTML = '<div class="px-4 py-3 text-sm text-red-600">Error loading properties</div>';
                    propertySuggestions.classList.remove('hidden');
                });
            }, 300);
        });

        function displayPropertySuggestions(properties) {
            if (!properties.length) {
                propertySuggestions.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500">No properties found</div>';
            } else {
                propertySuggestions.innerHTML = properties.map(p => {
                    let priceInfo = '';
                    if (p.price>0) {
                        priceInfo = ` - ৳${parseFloat(p.price).toLocaleString()}`;
                    }
                    return `<div class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-gray-100 property-suggestion-item" 
                             data-property-id="${p.property_id}" 
                             data-price="${p.price || 0}" 
                             data-property-name="${p.property_name}">
                             ${p.property_name}${priceInfo}${p.address ? ` - ${p.address}` : ''}
                            </div>`;
                }).join('');
            }
            propertySuggestions.classList.remove('hidden');
            propertyCurrentFocus = -1;
            
            document.querySelectorAll('.property-suggestion-item').forEach(item => {
                item.addEventListener('click', function() {
                    propertyInput.value = this.dataset.propertyName;
                    selectedPropertyId = this.dataset.propertyId;
                    const propertyPrice = parseFloat(this.dataset.price) || 0;
                    document.getElementById('selected_property_id').value = selectedPropertyId;
                    propertySuggestions.classList.add('hidden');
                    
                    // Handle different service categories
                    if (currentServiceCategory === '5' || currentServiceCategory === '2' ) {
                        // For category 5, use property price directly (no packages)
                        handleCategory5Property(propertyPrice);
                    } else {
                        // For other categories (1,6), load packages
                        loadPackages(selectedPropertyId, currentServiceCategory);
                    }
                });
            });
        }

        function handleCategory5Property(propertyPrice) {
            // For category 5, set the total price directly from property
            totalInput.value = propertyPrice.toFixed(2);
            discountInput.value = '0';
            
            // Display price info
            originalPriceEl.textContent = `${propertyPrice.toFixed(2)}`;
            discountAmountEl.textContent = 'No discount';
            finalPriceEl.textContent = `${propertyPrice.toFixed(2)}`;
            priceInfo.classList.remove('hidden');
            
            calculateBalance();
        }

        function loadPackages(propertyId, currentServiceCategory) {
            packagesInput.disabled = true;
            packagesInput.value = '';
            packageIdInput.value = '';
            packagesDatalist.innerHTML = '';
            packagesLoading.classList.remove('hidden');
            priceInfo.classList.add('hidden');

            fetch(`/admin/receipt/property-units/${propertyId}/${currentServiceCategory}`, {
                headers: {'X-Requested-With': 'XMLHttpRequest','Accept':'application/json'}
            })
            .then(res => res.ok ? res.json() : [])
            .then(data => {
                packagesLoading.classList.add('hidden');
                packagesData = {};
                
                // Clear datalist first
                packagesDatalist.innerHTML = '';
                
                // Populate datalist with options
                data.forEach(u => {
                    const option = document.createElement('option');
                    option.value = u.unit_name + (u.current_price ? ` - ৳${parseFloat(u.current_price).toLocaleString()}` : '');
                    option.setAttribute('data-unit-id', u.unit_id);
                    option.setAttribute('data-unit-data', JSON.stringify(u));
                    packagesDatalist.appendChild(option);
                    
                    // Store package data for lookup
                    packagesData[u.unit_id] = u;
                });
                
                packagesInput.disabled = false;
            }).catch(() => { 
                packagesLoading.classList.add('hidden'); 
                packagesInput.placeholder = "Error loading packages";
            });
        }

        // Packages input event listener
        packagesInput.addEventListener('input', function() {
            const inputValue = this.value.trim();
            
            // Clear previous selection
            packageIdInput.value = '';
            totalInput.value = '';
            discountInput.value = '0';
            priceInfo.classList.add('hidden');
            
            if (!inputValue) {
                calculateBalance();
                return;
            }
            
            // Try to find matching package by name
            const datalistOptions = document.getElementById('packages_options').options;
            let matchedUnit = null;
            
            for (let option of datalistOptions) {
                // Compare without price part for matching
                const optionTextWithoutPrice = option.value.split(' - ৳')[0];
                if (optionTextWithoutPrice === inputValue || option.value === inputValue) {
                    const unitId = option.getAttribute('data-unit-id');
                    matchedUnit = packagesData[unitId];
                    packageIdInput.value = unitId; // Set the hidden package_id
                    break;
                }
            }
            
            if (matchedUnit) {
                // If matched from datalist, use the package data
                totalInput.value = parseFloat(matchedUnit.current_price || 0).toFixed(2);
                discountInput.value = parseFloat(matchedUnit.discount_amount || 0).toFixed(2);
                displayPriceInfo(matchedUnit);
            } else {
                // If typing custom value, you can set a custom price or handle differently
                // For now, we'll keep the price fields empty for custom entries
                packageIdInput.value = ''; // No package ID for custom entries
                priceInfo.classList.add('hidden');
            }
            
            calculateBalance();
        });

        function displayPriceInfo(unit) {
            const originalPrice = parseFloat(unit.current_price) || 0;
            const discountPercent = parseFloat(unit.discount_percent) || 0;
            const discountAmount = parseFloat(unit.discount_amount) || 0;
            let finalPrice = originalPrice;
            let discountText = 'No discount';

            if (discountPercent > 0) {
                finalPrice = originalPrice - (originalPrice * discountPercent / 100);
                discountText = `${discountPercent}% (৳${(originalPrice * discountPercent / 100).toFixed(2)})`;
            } else if (discountAmount > 0) {
                finalPrice = originalPrice - discountAmount;
                discountText = `৳${discountAmount.toFixed(2)}`;
            }

            originalPriceEl.textContent = `৳${originalPrice.toFixed(2)}`;
            discountAmountEl.textContent = discountText;
            finalPriceEl.textContent = `৳${finalPrice.toFixed(2)}`;
            priceInfo.classList.remove('hidden');
        }

        function calculateBalance() {
            const total = parseFloat(totalInput.value) || 0;
            const paid = parseFloat(paidInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            let balance = total - paid - discount;
            if (balance < 0) balance = 0;
            
            balanceInput.value = balance.toFixed(2);
            balanceInput.classList.remove('bg-red-50', 'text-red-900', 'bg-green-50', 'text-green-900');
            
            if (balance > 0) {
                balanceInput.classList.add('bg-red-50', 'text-red-900');
            } else {
                balanceInput.classList.add('bg-green-50', 'text-green-900');
            }
        }

        [totalInput, paidInput, discountInput].forEach(i => i.addEventListener('input', calculateBalance));

        // Phone autocomplete
        phoneInput.addEventListener('input', function() {
            const query = this.value.trim();
            clearTimeout(customerDebounceTimer);
            if (query.length < 2) {
                suggestionsDiv.classList.add('hidden');
                loadingSpinner.classList.add('hidden');
                return;
            }
            loadingSpinner.classList.remove('hidden');
            
            customerDebounceTimer = setTimeout(() => {
                fetch(`/admin/receipt/search-customers?q=${encodeURIComponent(query)}`, {
                    headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}
                })
                .then(res => res.ok ? res.json() : [])
                .then(data => {
                    loadingSpinner.classList.add('hidden');
                    displayCustomerSuggestions(data);
                })
                .catch(() => {
                    loadingSpinner.classList.add('hidden');
                    suggestionsDiv.innerHTML = '<div class="px-4 py-3 text-sm text-red-600">Error loading suggestions</div>';
                    suggestionsDiv.classList.remove('hidden');
                });
            }, 300);
        });

        function displayCustomerSuggestions(customers) {
            if (!customers.length) {
                suggestionsDiv.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500">No customers found</div>';
            } else {
                suggestionsDiv.innerHTML = customers.map(c => 
                    `<div class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-gray-100 suggestion-item" 
                          data-phone="${c.phone}" 
                          data-name="${c.name}" 
                          data-email="${c.email || ''}">
                          ${c.name} - ${c.phone}
                     </div>`
                ).join('');
            }
            suggestionsDiv.classList.remove('hidden');
            
            document.querySelectorAll('.suggestion-item').forEach(item => {
                item.addEventListener('click', function() {
                    phoneInput.value = this.dataset.phone;
                    nameInput.value = this.dataset.name;
                    emailInput.value = this.dataset.email;
                    suggestionsDiv.classList.add('hidden');
                });
            });
        }

        document.addEventListener('click', function(e) {
            if (!propertyInput.contains(e.target) && !propertySuggestions.contains(e.target)) {
                propertySuggestions.classList.add('hidden');
            }
            if (!phoneInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                suggestionsDiv.classList.add('hidden');
            }
        });
    });
    </script>
</x-app-layout>