<x-app-layout>
     <div class="w-[95%] mx-auto">
    <div class="container">
        
        <div class="flex item-center justify-between mt-5">

                <h2 class="text-2xl font-bold mb-4">Property Packages: </h2>
                <a
    href="/admin/ships/properties/{{$property->destination_id}}"
    class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition-colors duration-200"
  >
    Back to Properties
  </a>
                <div class="flex justify-end mb-4">
                     <button data-modal-target="static-modal" data-modal-toggle="static-modal"
            class="block mb-5 float-right text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            Add New
        </button>
                </div>
            </div>
    
        <div class="mb-8 p-6 bg-gray-50 shadow-md rounded-lg">
            <h2 class="text-2xl font-semibold mb-4">Property Name: <span
                    class="text-blue-600">{{ $property->property_name }}</span></h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <p class="text-gray-700"><strong>District/City:</strong> {{ $property->district_city }}</p>
                <p class="text-gray-700"><strong>Address:</strong> {{ $property->address }}</p>
            </div>
        </div>
       
        @if ($property->property_uinit->isEmpty())
            <p>No units found for this property.</p>
        @else
        <div class="overflow-x-auto">
          <table id="example" class="table-auto w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Unit No</th>
                    <th class="px-4 py-2 border">Unit Name</th>
                    <th class="px-4 py-2 border">Unit Type</th>
                    <th class="px-4 py-2 border">Persons Allowed</th>
                    <th class="px-4 py-2 border">Additional Bed</th>
                    <th class="px-4 py-2 border">Status</th>
                     <th class="px-4 py-2 border">Discont amount</th>
                     <th class="px-4 py-2 border">discount_percent</th>
                     <th class="px-4 py-2 border">Price</th>
                     <th class="px-4 py-2 border">Stay Time</th>
                     <th class="px-4 py-2 border">round_trip_price</th>
                     <th class="px-4 py-2 text-left">Change Image</th>
                     <th class="px-4 py-2 text-left">Description</th>
                    <th class="px-4 py-2 border">Action</th>
                    <th class="px-4 py-2 border">set offer</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($property->property_uinit as $unit)
                <tr class="bg-white hover:bg-gray-50">
                    <form action="{{ route('property-units.update', $unit->unit_id) }}" method="POST"  enctype="multipart/form-data"
                        class="update-form">
                        @csrf
                        @method('PUT')
                           <input type="hidden" name="unit_id" value="{{ $unit->unit_id }}">
                        <td>
                            <textarea name="unit_no" class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                disabled>{{ $unit->unit_no }}</textarea>
                        </td>
                        <td>
                            <textarea name="unit_name"
                                class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                disabled>{{ $unit->unit_name }}</textarea>
                        </td>
                        <td>
                            <textarea name="unit_type"
                                class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                disabled>{{ $unit->unit_type }}</textarea>
                        </td>
                        <td>
                            <textarea name="person_allowed"
                                class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                disabled>{{ $unit->person_allowed }}</textarea>
                        </td>
                        <td>
                            <select name="additionalbed" class="w-full border border-gray-300 rounded px-2 py-1">
                                <option value=1 {{ $unit->additionalbed ? 'selected' : '' }}>Yes</option>
                                <option value=0 {{ !$unit->additionalbed ? 'selected' : '' }}>No</option>
                            </select>
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
        {{ $unit->discount ? $unit->discount->discount_percent: 0 }}
    </textarea>
   
</td>
                        <td>
    <textarea name="price"
        class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
        disabled>{{ $unit->price->first()?->price ?? 0 }}</textarea>
</td>
 <td>
                            <textarea name="Validity"
                                class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
                                disabled>{{ $unit->Validity }}</textarea>
                        </td>
                        <td>
    <textarea name="round_trip_price"
        class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
        disabled>{{ $unit->price->first()?->round_trip_price ?? 0 }}</textarea>
</td>

<td>
                                    <label
                                        class="flex flex-col items-center justify-center cursor-pointer border border-gray-300 rounded px-3 py-2 w-full">
                                        <input type="file" name="mainimg" class="hidden"
                                            id="fileInput-{{ $property->property_id }}" accept="image/*"
                                            onchange="showFilePath(event, '{{ $property->property_id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 16v-8m0 0-3 3m3-3 3 3m-9 4h12" />
                                        </svg>
                                    </label>
                                    <span id="fileName-{{ $property->property_id }}"
                                        class="text-xs text-gray-500 mt-1 block text-center"></span>
                                </td>
                        <td>
    <textarea name="description"
        class="w-full border border-gray-300 rounded px-2 py-1 resize-none"
        disabled>{{ $unit->description }}</textarea>
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
                            class="bg-red-500 text-white px-3 mb-5  rounded hover:bg-red-600">Delete</button>
                    </form>
                    </td>

                    <td >
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
                                    <label for="unit_category" class="block text-sm font-medium text-gray-700">Unit
                                        Category<span class="text-red-500 font-bold text-2xl">*</span></label>
                                    <select name="unit_category" id="unit_category"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                        <option value="room">Room</option>
                                        <option value="seat">Seat</option>
                                    </select>
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
    <label for="unit_type" class="block text-sm font-medium text-gray-700">
        Unit Type<span class="text-red-500 font-bold text-2xl">*</span>
    </label>
    <input type="text" name="unit_type" id="unit_type"
        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        required>
</div>


                                <div>
                                    <label for="unit_no" class="block text-sm font-medium text-gray-700">Unit
                                        Number<span class="text-red-500 font-bold text-2xl">*</span></label>
                                    <input type="text" required name="unit_no" id="unit_no"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="person_allowed" class="block text-sm font-medium text-gray-700">Persons
                                        Allowed<span class="text-red-500 font-bold text-2xl">*</span></label>
                                    <input required type="number" name="person_allowed" id="person_allowed"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                </div>

                                <div>
                                    <label for="additionalbed"
                                        class="block text-sm font-medium text-gray-700">Additional Bed<span class="text-red-500 font-bold text-2xl">*</span></label>
                                    <select name="additionalbed" id="additionalbed"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="mainimg" class="block text-sm font-medium text-gray-700">Main Image<span class="text-red-500 font-bold text-2xl">*</span></label>
                                <input required type="file" name="mainimg" id="mainimg"
                                    class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    accept="image/*">
                            </div>
                            <div class="mt-4">
    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea name="description" id="description" rows="4"
        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
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
                                <div class="mt-4">
    <label for="Validity" class="block text-sm font-medium text-gray-700">Stay Time</label>
     <input required type="text" name="Validity" id="Validity"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        >
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
                    <div class="flex items-center">
    <input 
      type="checkbox" 
      id="roundTripCheckbox" 
      name="round_trip_price"
      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
    >
    <label for="roundTripCheckbox" class="ms-2 text-sm font-medium text-gray-900">
      Round Trip
    </label>
  </div>
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
                        <div class="space-y-4">
  <!-- Round Trip Checkbox -->
  

  <!-- Round Trip Price (hidden by default) -->
  <div id="roundTripPriceContainer" class="hidden">
    <label for="round_trip_price" class="block mb-1 text-sm font-medium text-gray-900">
      Round Trip Price
    </label>
    <input 
      type="number" 
      id="roundTripPrice" 
      name="round_trip_price"
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
      placeholder="Enter price"
    >
  </div>
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
                <form action="{{ route('discount.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="unit_id" id="unit_id_discount">

                    <!-- Discount Percentage or Amount -->
                    <div class="mb-4">
                        <label for="discount_percent"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount
                            Percentage
                            (%)<span class="text-red-500 font-bold text-2xl">*</span></label>
                        <input type="number" id="discount_percent" name="discount_percent"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                            placeholder="Enter discount percentage" step="0.01"
                            oninput="toggleDiscountFields('percent')">
                    </div>

                    <div class="mb-4">
                        <label for="discount_amount"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount
                            Amount<span class="text-red-500 font-bold text-2xl">*</span></label>
                        <input type="number" id="discount_amount" name="discount_amount"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                            placeholder="Enter discount amount"
                            oninput="toggleDiscountFields('amount')">
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
            amountField.required = false;
            percentField.required = true;
        } else if (type === 'amount' && amountField.value) {
            percentField.disabled = true;
            percentField.value = '';
            percentField.required = false;
            amountField.required = true;
        } else {
            // If field is cleared, re-enable both
            percentField.disabled = false;
            amountField.disabled = false;
            percentField.required = true;
            amountField.required = true;
        }
    }
</script>
     
             <script>
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
        </script>

<script>
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
    
    function showFilePath(event, propertyId) {
    const input = event.target;
    const fileNameSpan = document.getElementById('fileName-' + propertyId);

    if (input.files && input.files[0]) {
        let fileName = input.files[0].name;

        // Limit file name length to 10 characters and add '...' if longer
        if (fileName.length > 10) {
            fileName = fileName.substring(0, 7) + '...';
        }

        fileNameSpan.textContent = fileName; // Display shortened file name
    } else {
        fileNameSpan.textContent = ""; // Clear text if no file is selected
    }
}
</script>

    <script>
        // Function to set unit_no for the Add Price Modal
        function setUnitForPrice(unitNo) {
            // Set the unit_no field for the price modal
            document.getElementById('unit_no1').value = unitNo;

            // Show the Add Price Modal
            const priceModal = document.getElementById('add-price-modal');
            priceModal.classList.remove('hidden');
        }

        // Function to set unit_id for the Add Discount Modal
        function setUnitForDiscount(unitNo) {
            // Set the unit_id field for the discount modal
            document.getElementById('unit_id_discount').value = unitNo;

            // Show the Add Discount Modal
            const discountModal = document.getElementById('add-discount-modal');
            discountModal.classList.remove('hidden');
        }
    </script>
<script>
  document.getElementById('roundTripCheckbox').addEventListener('change', function() {
    const priceContainer = document.getElementById('roundTripPriceContainer');
    if (this.checked) {
      priceContainer.classList.remove('hidden');
    } else {
      priceContainer.classList.add('hidden');
      // Optional: Clear the price field when hiding
      document.getElementById('roundTripPrice').value = '';
    }
  });
</script>
</x-app-layout>
