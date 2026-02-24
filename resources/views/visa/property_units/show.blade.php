<x-app-layout>
     <div class="w-[95%] mx-auto">
    <div class="container">
    <h2 class="text-2xl mt-10 font-bold mb-4">Property Packages</h2>
        <div class="mb-8 p-6 bg-gray-50 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Property Name: <span
                    class="text-blue-600">{{ $property->property_name }}</span></h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <p class="text-gray-700"><strong>District/City:</strong> {{ $property->district_city }}</p>
                <p class="text-gray-700"><strong>Address:</strong> {{ $property->address }}</p>
            </div>
        </div>
        <button data-modal-target="static-modal" data-modal-toggle="static-modal"
            class="block mb-5 float-right text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            Add New
        </button>
        @if ($property->property_uinit->isEmpty())
            <p>No units found for this property.</p>
        @else
          <table id="example" class="table-auto w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Unit Name</th>
                    <th class="px-4 py-2 border">Unit Type</th>
                    <th class="px-4 py-2 border">Max_Stay</th>
                    <th class="px-4 py-2 border">Validity</th>
                   
                    <th class="px-4 py-2 border">Status</th>
                     <th class="px-4 py-2 border">Discount amount</th>
                     <th class="px-4 py-2 border">Discount percent</th>
                     <th class="px-4 py-2 border">Price</th>
                       <th class="px-4 py-2 border">Fee Type</th>
                    <th class="px-4 py-2 border">Action</th>
                    <th class="px-4 py-2 border">set offer</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($property->property_uinit as $unit)
                <tr class="bg-white hover:bg-gray-50">
                    <form action="{{ route('property-units.update', $unit->unit_id) }}" method="POST"
                        class="update-form">
                        @csrf
                        @method('PUT')
                           <input type="hidden" name="Max_Stay" value="{{ $unit->unit_id }}">
                           <td>
                            <textarea name="unit_name"
                                class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                disabled>{{ $unit->unit_name }}</textarea>
                        </td>
                           <td>
                            <textarea name="unit_type" class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                disabled>{{ $unit->unit_type }}</textarea>
                        </td>
                        
                        <td>
                            <textarea name="Max_Stay" class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                disabled>{{ $unit->Max_Stay }}</textarea>
                        </td>
                        <td>
                            <textarea name="Validity"
                                class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                disabled>{{ $unit->Validity }}</textarea>
                        </td>
                        

                        <td>
                            <select name="isactive" class="w-full border border-gray-300 rounded px-2 py-1">
                                <option value="1" {{ $unit->isactive ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$unit->isactive ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </td>
                        <td>
                            <textarea name="discount_amount"
                                class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                disabled>
                                {{ $unit->discount ? $unit->discount->discount_amount : 0 }}
                            </textarea>
                        </td>

                        <td>
                            <textarea name="discount_percent"
                                class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                disabled>
                                {{ $unit->discount ? $unit->discount->discount_percent : '' }}
                            </textarea>
                        </td>
                        <td>
    <textarea name="price"
        class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
        disabled>{{ $unit->price->first()?->price ?? 0 }}</textarea>
</td>
 <td>
   <select name="fee_type" class="w-full border border-gray-300 rounded px-2 py-1">
    <option value="" disabled selected>Select Fee Type</option>
    <option value="Processing Fee" {{ $unit->fee_type == 'Processing Fee' ? 'selected' : '' }}>Processing Fee</option>
    <option value="Visa Issuance Fee" {{ $unit->fee_type == 'Visa Issuance Fee' ? 'selected' : '' }}>Visa Issuance Fee</option>
    <option value="Service Fee" {{ $unit->fee_type == 'Service Fee' ? 'selected' : '' }}>Service Fee</option>
    <option value="Biometric Fee" {{ $unit->fee_type == 'Biometric Fee' ? 'selected' : '' }}>Biometric Fee</option>
    <option value="Priority / Premium Fee" {{ $unit->fee_type == 'Priority / Premium Fee' ? 'selected' : '' }}>Priority / Premium Fee</option>
    <option value="Multiple Entry Fee" {{ $unit->fee_type == 'Multiple Entry Fee' ? 'selected' : '' }}>Multiple Entry Fee</option>
    <option value="Extension Fee" {{ $unit->fee_type == 'Extension Fee' ? 'selected' : '' }}>Extension Fee</option>
     <option value="all fee included" {{ $unit->fee_type == 'all fee included' ? 'selected' : '' }}>All Fee Included </option>
</select>

</td>



                        <td class=" space-x-2">
                            <!-- Edit Button -->
                            <button type="button" onclick="enableEdit(this)"
                                class="bg-yellow-500 text-white px-3 py-1 ml-3 mb-3 rounded hover:bg-yellow-600">Edit</button>
                            <!-- Save Button -->
                            <button type="submit"
                                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                    </form>

                    <!-- Delete Button -->
                    <form action="{{ route('property-units.destroy', $unit->unit_id) }}" method="POST"
                        class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-3 rounded hover:bg-red-600">Delete</button>
                    </form>
                   
                    </td>

                    <td>
                        <button data-modal-target="add-price-modal" data-modal-toggle="add-price-modal"
                            class="bg-green-500 mb-3 p-3 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105"
                            onclick="setUnitForPrice('{{ $unit->unit_id }}')">
                            <span>Add Price</span>
                        </button>

                        <!-- Add Discount Button -->
                        <button data-modal-target="add-discount-modal" data-modal-toggle="add-discount-modal"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105"
                            onclick="setUnitForDiscount('{{ $unit->unit_id }}')">
                            <span>Add Discount</span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @endif
    </div>

    <!-- Modal for adding unit -->
    <div id="static-modal"  data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow ">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add New Unit
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="static-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4">
                    <form action="{{ route('property-units.store', $property_id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <input required type="number" name="property_id" value="{{ $property_id }}" readonly
                                class="hidden">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="unit_type" class="block text-sm font-medium text-gray-700">
                                        Unit Type<span class="text-red-500 font-bold text-2xl">*</span>
                                    </label>
                                    <input type="text" name="unit_type" id="unit_type"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                </div>
                                <div>
                                    <label for="unit_name" class="block text-sm font-medium text-gray-700">
                                        Unit Name<span class="text-red-500 font-bold text-2xl">*</span>
                                    </label>
                                    <input type="text" name="unit_name" id="unit_name"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="Validity" class="block text-sm font-medium text-gray-700">
                                       Validity <span class="text-red-500 font-bold text-2xl">*</span>
                                    </label>
                                    <input type="text" name="Validity" id="Validity"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                </div>

                                <div>
                                    <label for="unit_no" class="block text-sm font-medium text-gray-700">
                                        Max_Stay<span class="text-red-500 font-bold text-2xl">*</span></label>
                                    <input type="text" required name="Max_Stay" id="Max_Stay"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                </div>
                            </div>

                           
                            <div>
                                <label for="mainimg" class="block text-sm font-medium text-gray-700">Main Image<span class="text-red-500 font-bold text-2xl">*</span></label>
                                <input required type="file" name="mainimg" id="mainimg"
                                    class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    accept="image/*">
                            </div>
                            

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="isactive" class="block text-sm font-medium text-gray-700">Active
                                        Status<span class="text-red-500 font-bold text-2xl">*</span></label>
                                    <select name="isactive" id="isactive"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 focus:outline-none">Save</button>
                            <button type="button"
                                class="ml-3 py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                                data-modal-hide="static-modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Price -->
    <div id="add-price-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add Price
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="add-price-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4">
                    <form action="{{ route('price.store') }}" method="POST">
                        @csrf
                        <div class="mb-4 hidden">
                            <input type="number" name="unit_id" id="unit_no1" value="" readonly>
                        </div>

                        <!-- Price input -->
                        <div class="mb-4">
                            <label for="price"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price<span class="text-red-500 font-bold text-2xl">*</span></label>
                            <input required type="number" id="price" name="price"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                placeholder="Enter price" required>
                        </div>

                        <!-- Effective From date input -->
                        <div class="mb-4">
                            <label for="effectfrom"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Effective
                                From<span class="text-red-500 font-bold text-2xl">*</span></label>
                            <input required type="datetime-local" id="effectfrom" name="effectfrom"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                required>
                        </div>

                        <!-- Effective Till date input -->
                        <div class="mb-4">
                            <label for="effective_till"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Effective
                                Till<span class="text-red-500 font-bold text-2xl">*</span></label>
                            <input required type="datetime-local" id="effective_till" name="effective_till"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <button type="button" data-modal-hide="add-price-modal"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:ring-2 focus:ring-green-500">
                                Save Price
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Discount -->
    <div id="add-discount-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add Discount
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="add-discount-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4">
                    <form action="{{ route('discount.store') }}" method="POST" id="discount-form">
                        @csrf
                        <input type="hidden" name="unit_id" id="unit_id_discount">
<div class="mb-4">
                            <label for="discount_amount"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount
                                Amount</label>
                            <input type="number" id="discount_amount" name="discount_amount"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                placeholder="Enter discount amount"
                                oninput="toggleDiscountFields('amount')">
                        </div>
                        <!-- Discount Percentage or Amount -->
                        <div class="mb-4">
                            <label for="discount_percent"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount
                                Percentage
                                (%)</label>
                            <input type="number" id="discount_percent" name="discount_percent"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                placeholder="Enter discount percentage" step="0.01"
                                oninput="toggleDiscountFields('percent')">
                        </div>

                        

                        <!-- Effective From Date -->
                        <div class="mb-4">
                            <label for="effectfrom"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Effective
                                From<span class="text-red-500 font-bold text-2xl">*</span></label>
                            <input required type="datetime-local" id="effectfrom" name="effectfrom"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                required>
                        </div>

                        <!-- Effective Till Date -->
                        <div class="mb-4">
                            <label for="effective_till"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Effective
                                Till<span class="text-red-500 font-bold text-2xl">*</span></label>
                            <input required type="datetime-local" id="effective_till" name="effective_till"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <button type="button" data-modal-hide="add-discount-modal"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                Save Discount
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDiscountFields(type) {
            const percentField = document.getElementById('discount_percent');
            const amountField = document.getElementById('discount_amount');
            
            if (type === 'percent' && percentField.value) {
                amountField.disabled = true;
                amountField.value = '';
                amountField.removeAttribute('name'); // Remove the name attribute so it won't be submitted
                percentField.setAttribute('name', 'discount_percent'); // Ensure name is set
            } else if (type === 'amount' && amountField.value) {
                percentField.disabled = true;
                percentField.value = '';
                percentField.removeAttribute('name'); // Remove the name attribute so it won't be submitted
                amountField.setAttribute('name', 'discount_amount'); // Ensure name is set
            } else {
                // If field is cleared, re-enable both
                percentField.disabled = false;
                amountField.disabled = false;
                percentField.setAttribute('name', 'discount_percent');
                amountField.setAttribute('name', 'discount_amount');
            }
        }

        // Function to enable edit mode
        function enableEdit(button) {
            const row = button.closest('tr');
            const textareas = row.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.disabled = false;
            });
            row.querySelector('.save-button').classList.remove('hidden');
            button.classList.add('hidden');
        }

        // Function to set unit_no for the Add Price Modal
        function setUnitForPrice(unitNo) {
            document.getElementById('unit_no1').value = unitNo;
            const priceModal = document.getElementById('add-price-modal');
            priceModal.classList.remove('hidden');
        }

        // Function to set unit_id for the Add Discount Modal
        function setUnitForDiscount(unitNo) {
            document.getElementById('unit_id_discount').value = unitNo;
            const discountModal = document.getElementById('add-discount-modal');
            discountModal.classList.remove('hidden');
        }

        // Form validation for discount form
        document.getElementById('discount-form').addEventListener('submit', function(e) {
            const percent = document.getElementById('discount_percent').value;
            const amount = document.getElementById('discount_amount').value;
            
            if (!percent && !amount) {
                e.preventDefault();
                alert('Please enter either discount percentage or amount');
                return false;
            }
            
            return true;
        });
    </script>
</x-app-layout>