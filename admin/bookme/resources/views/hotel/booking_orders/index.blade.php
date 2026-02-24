<x-app-layout>
    <div class="max-w-7xl mt-5 mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Hotel Orders Management
        </h2>
        <div class="mt-6 mb-4 grid grid-cols-4 gap-10">
            
            <div class="">
                <label for="statusFilter" class="block text-sm font-medium text-gray-700">Filter by Status</label>
                <select id="statusFilter"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">All Order Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="checked-in">Checked In</option>
                    <option value="checked-out">Checked Out</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="flex-1">
                <label for="checkInDateFilter" class="block text-sm font-medium text-gray-700">Filter by Check-In Date</label>
                <input type="date" id="checkInDateFilter"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="flex items-end">
                <button id="clearFilters"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Clear Filters
                </button>
            </div>
        </div>

        <!-- Loader -->
        <div id="loader" class="text-center my-4">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="mt-2 text-gray-600">Loading data...</p>
        </div>

        <!-- Hotel Orders Table -->
        <div class="overflow-x-auto">
            <table id="salesTable" class="min-w-full border border-gray-300 border-collapse hidden">
                <thead class="bg-[#003366] text-white">
                    <tr>
                        <th class="border  px-4 py-2">Order No</th>
                        <th class="border  px-4 py-2">Order Date</th>
                        <th class="border  px-4 py-2">Customer Info</th>
                        <th class="border  px-4 py-2">Purchaser</th>
                        <th class="border  px-4 py-2">Hotels & Rooms</th>
                        <th class="border  px-4 py-2">Verified By</th>
                        <th class="border  px-4 py-2">Status</th>
                        <th class="border  px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="salesBody" >
                    <!-- Data will be populated dynamically via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal for Hotel Orders -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white h-full max-h-[90%] py-5 overflow-y-auto">
            <div class="mt-3 h-full">
                <div class="flex justify-between items-center pb-3 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">Edit Hotel Order</h3>
                    <button id="closeModalX" class="text-red-600 text-xl hover:text-gray-600">
                        x
                    </button>
                </div>

                <form id="editForm" class="mt-4">
                    <input type="hidden" id="editId">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Order Information -->
                        <div class="mb-4">
                            <label for="editOrderNo" class="block text-sm font-medium text-gray-700">Order No</label>
                            <input type="text" id="editOrderNo" readonly
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-gray-100">
                        </div>

                        <div class="mb-4">
                            <label for="editOrderDate" class="block text-sm font-medium text-gray-700">Order Date</label>
                            <input type="date" id="editOrderDate"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <!-- Customer Information -->
                        <div class="mb-4">
                            <label for="editCustomerName" class="block text-sm font-medium text-gray-700">Customer Name</label>
                            <input type="text" id="editCustomerName"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <div class="mb-4">
                            <label for="editMobile" class="block text-sm font-medium text-gray-700">Mobile</label>
                            <input type="text" id="editMobile"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <div class="mb-4">
                            <label for="editPurchaser" class="block text-sm font-medium text-gray-700">Purchaser</label>
                            <input type="text" id="editPurchaser"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <div class="mb-4">
                            <label for="editEmail" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="editEmail"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="editStatus" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="editStatus"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="checked-in">Checked In</option>
                                <option value="checked-out">Checked Out</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <!-- Payment Information -->
                        <div class="mb-4">
                            <label for="editPaymentStatus" class="block text-sm font-medium text-gray-700">Payment Status</label>
                            <select id="editPaymentStatus"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                <option value="unpaid">unpaid</option>
                                <option value="partial">Partial</option>
                                <option value="paid">Paid</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                        <!-- Payment Amounts Section -->

                    </div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <!-- Total Payable Amount -->
    <div class="mb-4">
        <label for="editTotalPayable" class="block text-sm font-medium text-gray-700">Total Payable Amount (BDT)</label>
        <input type="number" step="0.01" id="editTotalPayable" name="total_payable" 
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
    </div>

    <!-- Total Paid Amount -->
    <div class="mb-4">
        <label for="editTotalPaid" class="block text-sm font-medium text-gray-700">Total Paid (BDT)</label>
        <input type="number" step="0.01" id="editTotalPaid" name="total_paid" 
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
    </div>
</div>


                    <!-- Booking Details Section -->
                    <div class="mt-6 border-t pt-4">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Booking Details</h4>
                        <div id="bookingDetailsContainer">
                            <!-- Dynamic booking details will be added here -->
                        </div>
                    </div>

                    <div class="flex justify-end py-5 space-x-3">
                        <button type="button" id="cancelBtn"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-950 text-white rounded-md hover:bg-blue-800">
                            Update Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Booking Detail Template (Hidden) -->
<template id="bookingDetailTemplate">
    <div class="booking-detail border rounded-lg p-4 mb-4 bg-gray-50">
        <div class="flex justify-between items-center mb-3">
            <h5 class="font-medium text-gray-700">Room Booking</h5>
            <button type="button" class="remove-booking-detail text-red-600 hover:text-red-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Hotel Name Field - Will be replaced with searchable input -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Hotel Name</label>
                <input type="text" class="edit-hotel-name mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" readonly>
            </div>
            
            <!-- Hotel ID Field - Will be removed and handled by search -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Hotel Id</label>
                <input type="text" class="edit-hotel-id mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" readonly>
            </div>

            <!-- Room Name Field - Will be replaced with select -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Room Name</label>
                <input type="text" class="edit-room-name mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" readonly>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Check-In Date</label>
                <input type="date" class="edit-check-in-date mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Check-Out Date</label>
                <input type="date" class="edit-check-out-date mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Total Guests</label>
                <input type="number" class="edit-total-guests mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" min="1">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Total Price</label>
                <input type="number" step="0.01" class="edit-total-price mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            </div>
        </div>
    </div>
</template>

<script src="{{ asset('js/order.js') }}"></script>