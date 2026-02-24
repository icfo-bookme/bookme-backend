<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex items-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Car Prices</h1>
            <div class="float-right">
                <button data-modal-target="carprice-modal" data-modal-toggle="carprice-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Add Car Price 
                </button>
            </div>
        </div>

        <!-- Add Car Price Modal -->
        <div id="carprice-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">Add Car Price</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="carprice-modal">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <form action="{{ route('car-prices.store') }}" method="POST">
                        @csrf
                        <div class="p-4 md:p-5 space-y-4">
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <div class="hidden">
                                    <label for="property_id" class="block text-sm font-medium text-gray-700">
                                        Property ID <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <input type="number" name="property_id" id="property_id" value = "{{$id}}"
                                        class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                </div>

                                <div>
                                    <label for="price_upto_4_hours" class="block text-sm font-medium text-gray-700">
                                       price_upto_4_hours <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <input type="text" name="price_upto_4_hours" id="price_upto_4_hours"
                                        class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                </div>
                                 <div>
                                    <label for="price_upto_6_hours" class="block text-sm font-medium text-gray-700">
                                        price_upto_6_hours <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <input type="text" name="price_upto_6_hours" id="price_upto_6_hours"
                                        class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                </div>

                                <div>
                                    <label for="kilometer_price" class="block text-sm font-medium text-gray-700">
                                        Kilometer Price <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <input type="text" name="kilometer_price" id="kilometer_price"
                                        class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center px-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Save
                            </button>
                            <button type="button" data-modal-hide="carprice-modal"
                                class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Car Prices Table -->
        <div class="w-[90%] mt-12 mx-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table id="example" class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">price_upto_4_hours</th>
                        <th class="px-4 py-2 border">price_upto_6_hours</th>
                        <th class="px-4 py-2 border">KM Price</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carPrices as $price)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('car-prices.update', $price->id) }}" method="POST" class="update-form">
                            @csrf
                            @method('PUT')
                            <td class="px-4 py-2 border">{{ $price->id }}</td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="price_upto_4_hours" value="{{ $price->price_upto_4_hours }}"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                            </td>
                             <td class="px-4 py-2 border">
                                <input type="text" name="price_upto_6_hours" value="{{ $price->price_upto_6_hours }}"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                            </td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="kilometer_price" value="{{ $price->kilometer_price }}"
                                    class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                            </td>
                           
                            <td class="px-4 py-2 border flex space-x-2">
                                <button type="button" onclick="enableEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                        </form>
                        <form action="{{ route('car-prices.destroy', $price->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function enableEdit(button) {
        const row = button.closest('tr');
        row.querySelectorAll('input').forEach(input => input.disabled = false);
        button.classList.add('hidden');
        row.querySelector('.save-button').classList.remove('hidden');
    }
    </script>
</x-app-layout>
