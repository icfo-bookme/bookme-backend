<x-app-layout>
    <div class="container w-[95%] mx-auto">
<div>
  <h1 class="text-2xl font-bold mb-4">Property Details</h1>
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
</div>

        <div class="mb-8 p-6 mt-3 bg-gray-50 shadow-md mx-auto w-[95%] rounded-lg">
            <h2 class="text-2xl font-semibold mb-4">Property Name: <span class="text-blue-600">{{ $property->property_name }}</span></h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <p class="text-gray-700"><strong>District/City:</strong> {{ $property->district_city }}</p>
                <p class="text-gray-700"><strong>Address:</strong> {{ $property->address }}</p>
            </div>
        </div>
        <div class="float-right mr-36">
            <!-- Button to Open Modal for Adding Summaries -->
            <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                class="block mb-12 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button">
                Add Summary
            </button>
        </div>
        <!-- Flowbite Modal for Adding Summaries -->
        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add Property Summary
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

                    <!-- Modal body -->
                    <form action="{{ route('property-summary.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property_id }}">
                        <div class="p-4 md:p-5 space-y-4">
                            <div id="summaryFields">
                                @php
                                    $defaultIcons = ['IoLocationOutline', 'FaRegClock', 'PiUsersThree', 'GoCommentDiscussion'];
                                    $defaultLabels = ['location', 'duration', 'person allow', 'policy'];
                                @endphp
                                @foreach ($defaultIcons as $index => $icon)
                                    <div class="summaryRow grid grid-cols-4 gap-4 mb-4">

                                        <div class="form-group">
                                            <label for="value" class="block text-sm font-medium text-gray-700">{{ ucfirst($defaultLabels[$index]) }}<span class="text-red-500 font-bold text-2xl">*</span></label>
                                            <input type="text" name="value[]"
                                                class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                                placeholder="Enter {{ $defaultLabels[$index] }}" required>
                                        </div>

                                        <div>
                                            <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facility icon<span class="text-red-500 font-bold text-2xl">*</span></label>
                                            <select id="icon" name="icon[]" required
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                                                <option value="" disabled>Select a facility icon<span class="text-red-500 font-bold text-2xl">*</span></option>
                                                @foreach ($icons as $iconOption)
                                                    <option value="{{ $iconOption->id }}" data-icon-name="{{ $iconOption->icon_name }}">
                                                        {{ $iconOption->icon_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="display" class="block text-sm font-medium text-gray-700">Display<span class="text-red-500 font-bold text-2xl">*</span></label>
                                            <select name="display[]"
                                                class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                                required>
                                                <option value="yes" selected>Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="addMoreBtn"
                                class="text-white bg-green-500 px-4 py-2 rounded-md hover:bg-green-600 mt-4">
                                Add New
                            </button>
                            <button type="button" id="removeRowBtn"
                                class="text-white bg-red-500 px-4 py-2 rounded-md hover:bg-red-600 mt-4">
                                Remove Last Row
                            </button>
                            <button type="button" id="removeAllRowsBtn"
                                class="text-white bg-red-700 px-4 py-2 rounded-md hover:bg-red-800 mt-4">
                                Remove All Default Rows
                            </button>
                        </div>

                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-50 focus:outline-none bg-blue-500 rounded-lg border border-gray-200 hover:bg-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full sm:w-auto"
                                data-modal-hide="static-modal">
                                Save Summaries
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
        <div class="w-[90%] mt-12 mx-auto">
            <table id="example" class="table-auto w-full mt-6 border-collapse">
                <thead>
                    <tr class="bg-gray-100">
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
                            <td>
                                <textarea name="value" class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ $summary->value }}</textarea>
                            </td>
                            <td>
                                <textarea name="icon" class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ $summary->icon }}</textarea>
                            </td>
                            <td>
                                <textarea name="display" class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ ucfirst($summary->display) }}</textarea>
                            </td>
                            <td class="flex space-x-2">
                                <!-- Edit Button -->
                                <button type="button" onclick="enableEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <!-- Save Button -->
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                            </form>
                                <!-- Delete Button -->
                                <form action="{{ route('property-summary.destroy', $summary->id) }}" method="POST" class="inline-block">
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

    <script>
        // Add More Button functionality for adding new rows
        const addMoreBtn = document.getElementById('addMoreBtn');
        const removeRowBtn = document.getElementById('removeRowBtn');
        const removeAllRowsBtn = document.getElementById('removeAllRowsBtn');
        const summaryFields = document.getElementById('summaryFields');

        // Function to create a new row
        const createNewRow = () => {
            const newSummaryRow = document.createElement('div');
            newSummaryRow.className = 'summaryRow grid grid-cols-3 gap-4 mb-4';
            newSummaryRow.innerHTML = `
                <div class="form-group">
                    <label for="value" class="block text-sm font-medium text-gray-700">Value<span class="text-red-500 font-bold text-2xl">*</span></label>
                    <input type="text" name="value[]"
                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                        placeholder="Enter value" required>
                </div>
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facility icon<span class="text-red-500 font-bold text-2xl">*</span></label>
                    <select id="icon" name="icon[]" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
                        <option value="" disabled>Select a facility icon</option>
                        @foreach ($icons as $iconOption)
                            <option value="{{ $iconOption->id }}" data-icon-name="{{ $iconOption->icon_name }}">
                                {{ $iconOption->icon_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="display" class="block text-sm font-medium text-gray-700">Display<span class="text-red-500 font-bold text-2xl">*</span></label>
                    <select name="display[]"
                        class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                        required>
                        <option value="yes" selected>Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            `;
            return newSummaryRow;
        };

        // Add More Button
        addMoreBtn.addEventListener('click', () => {
            const newRow = createNewRow();
            summaryFields.appendChild(newRow);
        });

        // Remove Last Row Button
        removeRowBtn.addEventListener('click', () => {
            const rows = document.querySelectorAll('.summaryRow');
            if (rows.length > 0) {
                rows[rows.length - 1].remove(); // Remove the last row
            }
        });

        // Remove All Rows Button
        removeAllRowsBtn.addEventListener('click', () => {
            summaryFields.innerHTML = ''; // Remove all rows
        });

        // Set default icons using JavaScript
        document.addEventListener('DOMContentLoaded', () => {
            const defaultIcons = ['IoLocationOutline', 'FaRegClock', 'PiUsersThree', 'GoCommentDiscussion'];
            const rows = document.querySelectorAll('.summaryRow');

            rows.forEach((row, index) => {
                const iconSelect = row.querySelector('select[name="icon[]"]');
                if (iconSelect) {
                    const options = iconSelect.querySelectorAll('option');
                    options.forEach(option => {
                        if (option.getAttribute('data-icon-name') === defaultIcons[index]) {
                            option.selected = true;
                        }
                    });
                }
            });
        });
    </script>

    <script>
        function enableEdit(button) {
            const row = button.closest('tr');
            row.querySelectorAll('textarea').forEach(textarea => textarea.disabled = false); // Enable all textarea fields
            row.querySelectorAll('input').forEach(input => input.disabled = false); // Enable all input fields (if any)
            button.classList.add('hidden'); // Hide the Edit button
            row.querySelector('.save-button').classList.remove('hidden'); // Show the Save button
        }
    </script>
</x-app-layout>