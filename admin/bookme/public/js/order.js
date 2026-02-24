document.addEventListener("DOMContentLoaded", () => {
    const loader = document.getElementById("loader");
    const table = document.getElementById("salesTable");
    const salesBody = document.getElementById("salesBody");
    const statusFilter = document.getElementById("statusFilter");
    const checkInDateFilter = document.getElementById("checkInDateFilter");
    const clearFiltersBtn = document.getElementById("clearFilters");
    const bookingDetailsContainer = document.getElementById("bookingDetailsContainer");
    const bookingDetailTemplate = document.getElementById("bookingDetailTemplate");

    let dataTable;

    const modal = {
        element: document.getElementById("editModal"),
        show: function () {
            this.element.classList.remove("hidden");
            this.element.classList.add("flex");
        },
        hide: function () {
            this.element.classList.add("hidden");
            this.element.classList.remove("flex");
            bookingDetailsContainer.innerHTML = '';
        },
    };

    function initializeModalEvents() {
        document.getElementById("closeModalX").addEventListener("click", () => modal.hide());
        document.getElementById("cancelBtn").addEventListener("click", () => modal.hide());
        modal.element.addEventListener("click", (e) => {
            if (e.target === modal.element) modal.hide();
        });
    }

    // Build URL with parameters
    function buildUrl() {
        const params = new URLSearchParams();

        if (statusFilter.value) {
            params.append('status', statusFilter.value);
        }

        if (checkInDateFilter.value) {
            params.append('checkin', checkInDateFilter.value);
        }

        const queryString = params.toString();
        const url = queryString ? `https://bookme.com.bd/admin/booking_orders?${queryString}` : '/admin/booking_orders';

        console.log('Request URL:', url);
        return url;
    }

    // Initialize DataTables
    function initializeDataTable() {
        if (dataTable) {
            dataTable.destroy();
        }

        dataTable = $('#salesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: buildUrl(),
                type: 'GET',
                data: function (d) {
                    console.log('DataTables sending:', d);
                }
            },
            createdRow: function (row, data, dataIndex) {
                $(row).addClass('border border-gray-200 hover:bg-gray-50 transition-colors duration-200');
            },
            columns: [
                {
                    data: 'orderno',
                    name: 'orderno',
                    orderable: false,
                },
                {
                    data: 'order_date',
                    name: 'order_date',
                    orderable: false,
                    render: data => data ? new Date(data).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : 'N/A',
                    className: 'px-4 py-3 border border-gray-200 text-sm'
                },
                {
                    data: 'customer_info',
                    name: 'customer_name',
                    order: [],
                    orderable: false,
                    render: data => data || 'N/A',
                    className: 'px-4 py-3 border border-gray-200 text-sm'
                },
                {
                    data: 'purchaser',
                    name: 'purchaser',
                    orderable: false,
                    render: data => data || 'N/A',
                    className: 'px-4 py-3 border border-gray-200 text-sm'
                },
                {
                    data: 'details',
                    render: function (data) {
                        if (!data || data.length === 0) return 'No booking details';
                        return data.map(detail => `
                    <div class="text-sm mb-2 last:mb-0 p-2 bg-gray-50 rounded border border-gray-200">
                        <strong class="font-medium text-gray-900">${detail.hotel}</strong> - <span class="text-gray-700">${detail.room}</span><br>
                        <span class="text-gray-600 text-xs">${detail.check_in_date} to ${detail.check_out_date}</span><br>
                        <span class="text-gray-600 text-xs">Guests: ${detail.total_guests} | Price: ${detail.total_price} BDT</span>
                    </div>
                `).join('');
                    },
                    orderable: false,
                    className: 'px-4 py-3 border border-gray-200 text-sm'
                },
                {
                    data: 'verified_by',
                    name: 'verified_by',
                    orderable: false,
                    render: data => data || 'N/A',
                    className: 'px-4 py-3 border border-gray-200 text-sm'
                },
                {
                    data: 'order_status',
                    name: 'order_status',
                    orderable: false,
                    render: data => {
                        const statusMap = {
                            'pending': '<span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">Pending</span>',
                            'confirmed': '<span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Confirmed</span>',
                            'checked-in': '<span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">Checked In</span>',
                            'checked-out': '<span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">Checked Out</span>',
                            'cancelled': '<span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">Cancelled</span>'
                        };
                        return statusMap[data] || `<span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">${data || 'Unknown'}</span>`;
                    },
                    className: 'px-4 py-3 border border-gray-200 text-sm'
                },
                {
                    data: null,
                    orderable: false,
                    render: (data, type, row) => createActionButtons(data),
                    className: 'px-4 py-3 text-sm'
                }
            ],
            dom: "lBfrtip",
            buttons: ['copy', 'excel', 'csv', 'pdf', 'print', 'colvis'],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            language: {
                emptyTable: "No hotel orders found",
                zeroRecords: "No matching orders found"
            },
            drawCallback: function () {
                attachEventListeners();
                loader.style.display = "none";
                table.classList.remove("hidden");
            },
            initComplete: function () {
                loader.style.display = "none";
                table.classList.remove("hidden");
                $('#salesTable_wrapper').addClass('border border-gray-200 rounded-lg overflow-hidden');
            }
        });
    }

    // Reload DataTables with new filters
    function reloadWithFilters() {
        if (dataTable) {
            dataTable.ajax.url(buildUrl()).load();
        }
    }

    // Filter event listeners
    statusFilter.addEventListener("change", function () {
        console.log('Status filter changed to:', this.value);
        reloadWithFilters();
    });

    checkInDateFilter.addEventListener("change", function () {
        console.log('Check-in date filter changed to:', this.value);
        reloadWithFilters();
    });

    // Clear filters
    clearFiltersBtn.addEventListener("click", function () {
        statusFilter.value = "";
        checkInDateFilter.value = "";
        console.log('Filters cleared');
        reloadWithFilters();
    });

   function createActionButtons(order) {
    // convert order object → safe JSON string
   const safeOrder = JSON.stringify(order).replace(/"/g, '&quot;');

 
 
    return `
        <div class="flex gap-2 items-center justify-center">
            <button class="text-blue-950 px-2 py-1 rounded editBtn"
                data-id="${order.orderno}"
                data-order="${safeOrder}"> <!-- use double quotes -->
                Edit
            </button>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded downloadBtn"
                    data-id="${order.orderno}">
                    Download Invoice
            </button>
        </div>
    `;
}


    function attachEventListeners() {
        document.querySelectorAll(".editBtn").forEach((btn) => {
            btn.addEventListener("click", () => showEditModal(btn));
        });

        document.querySelectorAll(".deleteBtn").forEach((btn) => {
            btn.addEventListener("click", () => deleteOrder(btn));
        });
        
        document.querySelectorAll(".downloadBtn").forEach((btn) => {
            btn.addEventListener("click", () => downloadInvoice(btn));
        });
    }

    // Search hotels function
    async function searchHotels(query) {
        try {
            const response = await fetch(`/admin/receipt/search-properties?q=${encodeURIComponent(query)}&category_id=3`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            console.log('Hotels found:', data);
            return data;
        } catch (error) {
            console.error('Error searching hotels:', error);
            return [];
        }
    }

    // Load rooms based on hotel ID
    async function loadRooms(hotelId) {
        try {
            const response = await fetch(`/admin/receipt/property-units/${hotelId}/3`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            console.log('Rooms found:', data);
            return data;
        } catch (error) {
            console.error('Error loading rooms:', error);
            return [];
        }
    }

    // Create hotel search input with datalist
    function createHotelSearchInput(currentHotel = '', currentHotelId = '') {
        const container = document.createElement('div');
        container.className = 'relative';

        const input = document.createElement('input');
        input.type = 'text';
        input.className = 'edit-hotel-name w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent';
        input.value = currentHotel;
        input.placeholder = 'Type to search hotels...';
        input.setAttribute('autocomplete', 'off');
        input.setAttribute('list', `hotel-suggestions-${Date.now()}`);

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.className = 'edit-hotel-id';
        hiddenInput.value = currentHotelId;

        const datalist = document.createElement('datalist');
        datalist.id = input.getAttribute('list');
        datalist.className = 'hotel-suggestions';

        container.appendChild(input);
        container.appendChild(hiddenInput);
        container.appendChild(datalist);

        // Add event listener for hotel search
        let searchTimeout;
        input.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                datalist.innerHTML = '';
                hiddenInput.value = '';
                return;
            }

            searchTimeout = setTimeout(async () => {
                try {
                    const hotels = await searchHotels(query);
                    datalist.innerHTML = '';

                    hotels.forEach(hotel => {
                        const option = document.createElement('option');
                        option.value = hotel.property_name || hotel.name || '';
                        option.setAttribute('data-hotel-id', hotel.property_id || hotel.id || '');
                        option.setAttribute('data-hotel-data', JSON.stringify(hotel));
                        datalist.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error in hotel search:', error);
                }
            }, 300);
        });

        // Handle hotel selection
        input.addEventListener('change', function () {
            const selectedOption = Array.from(datalist.options).find(option => option.value === this.value);
            if (selectedOption) {
                const hotelId = selectedOption.getAttribute('data-hotel-id');
                hiddenInput.value = hotelId;

                // Auto-load rooms when hotel is selected
                const roomSelect = container.closest('.booking-detail').querySelector('.edit-room-name');
                if (roomSelect) {
                    loadRoomsForHotel(hotelId, roomSelect);
                }
            } else {
                hiddenInput.value = '';
                // Clear room selection if hotel is cleared
                const roomSelect = container.closest('.booking-detail').querySelector('.edit-room-name');
                if (roomSelect) {
                    roomSelect.innerHTML = '<option value="">Select hotel first</option>';
                }
            }
        });

        return container;
    }

    // Load rooms for a specific hotel
    async function loadRoomsForHotel(hotelId, roomSelect) {
        if (!hotelId) {
            roomSelect.innerHTML = '<option value="">Select hotel first</option>';
            return;
        }

        roomSelect.innerHTML = '<option value="">Loading rooms...</option>';
        roomSelect.disabled = true;

        try {
            const rooms = await loadRooms(hotelId);
            roomSelect.innerHTML = '<option value="">Select a room</option>';

            if (rooms.length === 0) {
                roomSelect.innerHTML = '<option value="">No rooms available</option>';
                return;
            }

            rooms.forEach(room => {
                const option = document.createElement('option');
                option.value = room.unit_id || room.id || '';
                option.textContent = room.unit_name + (room.current_price ? ` - ৳${parseFloat(room.current_price).toLocaleString()}` : '');
                option.setAttribute('data-room-data', JSON.stringify(room));
                roomSelect.appendChild(option);
            });

            roomSelect.disabled = false;
        } catch (error) {
            console.error('Error loading rooms:', error);
            roomSelect.innerHTML = '<option value="">Error loading rooms</option>';
        }
    }

   function showEditModal(btn) {
       
    const order = JSON.parse(btn.dataset.order);
 

    // Fill only the main fields first (no totals yet)
    document.getElementById("editId").value = order.orderno;
    document.getElementById("editOrderNo").value = order.orderno;
    document.getElementById("editOrderDate").value = formatDateForInput(order.order_date);
    document.getElementById("editCustomerName").value = order.customer_name;
    document.getElementById("editMobile").value = order.mobile_no;
    document.getElementById("editPurchaser").value = order.purchaser ?? "";
    document.getElementById("editEmail").value = order.email || "";
    document.getElementById("editStatus").value = order.order_status;
    document.getElementById("editPaymentStatus").value = order.payment_status;

    // Load booking details first
    bookingDetailsContainer.innerHTML = '';
    if (order.details && order.details.length > 0) {
        order.details.forEach((detail, index) => {
            addBookingDetailSection(detail, index);
        });
    }

    // SET PAYABLE + PAID AMOUNTS AT THE END
    document.getElementById("editTotalPayable").value = order.total_payable;
    document.getElementById("editTotalPaid").value = order.total_paid;

    modal.show();
}


    function addBookingDetailSection(detail = {}, index = 0) {
        const template = bookingDetailTemplate.content.cloneNode(true);
        const section = template.querySelector('.booking-detail');

        // Replace hotel input with searchable input
        const hotelNameContainer = section.querySelector('.mb-4:first-child');
        if (hotelNameContainer) {
            hotelNameContainer.innerHTML = `
                <label class="block text-sm font-medium text-gray-700">Hotel Name</label>
                <div class="hotel-search-container mt-1"></div>
            `;
            const hotelSearchContainer = hotelNameContainer.querySelector('.hotel-search-container');
            const hotelSearchInput = createHotelSearchInput(detail.hotel || '', detail.hotel_id || '');
            hotelSearchContainer.appendChild(hotelSearchInput);
        }

        // Remove the hotel ID field
        const hotelIdField = section.querySelector('.mb-4:nth-child(2)');
        if (hotelIdField) {
            hotelIdField.remove();
        }

        // Replace room input with select
        const roomField = section.querySelector('.mb-4:nth-child(2)');
        if (roomField) {
            roomField.innerHTML = `
                <label class="block text-sm font-medium text-gray-700">Room Name</label>
                <select class="edit-room-name mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    <option value="">Select room</option>
                </select>
                <input type="hidden" class="edit-room-id" value="${detail.room_id || ''}">
            `;

            // Load rooms if hotel ID exists
            if (detail.hotel_id) {
                const roomSelect = roomField.querySelector('.edit-room-name');
                const roomIdInput = roomField.querySelector('.edit-room-id');
                
                loadRoomsForHotel(detail.hotel_id, roomSelect).then(() => {
                    if (detail.room_id) {
                        roomSelect.value = detail.room_id;
                    } else if (detail.room) {
                        const option = Array.from(roomSelect.options).find(opt => opt.textContent.includes(detail.room));
                        if (option) {
                            roomSelect.value = option.value;
                            roomIdInput.value = option.value;
                        }
                    }
                });
            }
        }

        // Populate other fields
        section.querySelector('.edit-check-in-date').value = formatDateForInput(detail.check_in_date);
        section.querySelector('.edit-check-out-date').value = formatDateForInput(detail.check_out_date);
        section.querySelector('.edit-total-guests').value = detail.total_guests || '';
        section.querySelector('.edit-total-price').value = detail.total_price || '';

        // Add remove button functionality
        section.querySelector('.remove-booking-detail').addEventListener('click', function () {
            section.remove();
        });

        bookingDetailsContainer.appendChild(section);
    }

    function formatDateForInput(dateString) {
        if (!dateString || dateString === "Not specified") return "";
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return "";
        return date.toISOString().split("T")[0];
    }

    document.getElementById("editForm").addEventListener("submit", async (e) => {
        e.preventDefault();
        const orderno = document.getElementById("editId").value;
        
        // RITICAL FIX: Added total_paid to the data object
        const data = {
            orderno: document.getElementById("editOrderNo").value,
            order_date: document.getElementById("editOrderDate").value,
            customer_name: document.getElementById("editCustomerName").value,
            mobile_no: document.getElementById("editMobile").value,
            purchaser: document.getElementById("editPurchaser").value,
            email: document.getElementById("editEmail").value,
            total_paid: document.getElementById("editTotalPaid").value,      
            total_payable: document.getElementById("editTotalPayable").value, 
            order_status: document.getElementById("editStatus").value,
            payment_status: document.getElementById("editPaymentStatus").value,
        };

        console.log('Submitting data:', data);

        data.booking_details = [];
        document.querySelectorAll('.booking-detail').forEach((section) => {
            const hotelIdInput = section.querySelector('.edit-hotel-id');
            const hotelNameInput = section.querySelector('.edit-hotel-name');
            const roomSelect = section.querySelector('.edit-room-name');

            const selectedRoomOption = roomSelect ? roomSelect.options[roomSelect.selectedIndex] : null;
            const roomName = selectedRoomOption ? selectedRoomOption.textContent.split(' - ')[0] : '';

            const detail = {
                hotel: hotelNameInput ? hotelNameInput.value : '',
                hotel_id: hotelIdInput ? hotelIdInput.value : '',
                room: roomName,
                room_id: roomSelect ? roomSelect.value : '',
                check_in_date: section.querySelector('.edit-check-in-date').value,
                check_out_date: section.querySelector('.edit-check-out-date').value,
                total_guests: section.querySelector('.edit-total-guests').value,
                total_price: section.querySelector('.edit-total-price').value
            };
            data.booking_details.push(detail);
        });

        await updateOrder(orderno, data);
    });

    async function updateOrder(id, data) {
        try {
            const response = await fetch(`/admin/booking_orders/${id}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (response.ok) {
                Swal.fire({
                    title: "Success!",
                    text: "Order updated successfully!",
                    icon: "success",
                    confirmButtonText: "OK",
                });
                reloadWithFilters();
                modal.hide();
            } else {
                throw new Error(result.message || "Failed to update order");
            }
        } catch (error) {
            console.error("Error updating order:", error);
            Swal.fire({
                title: "Error!",
                text: "Failed to update order. Please try again.",
                icon: "error",
                confirmButtonText: "OK",
            });
        }
    }

    async function deleteOrder(btn) {
        const orderId = btn.dataset.id;
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(`/admin/booking_orders/${orderId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                });

                if (response.ok) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Order has been deleted.",
                        icon: "success",
                        confirmButtonText: "OK",
                    });
                    reloadWithFilters();
                } else {
                    throw new Error("Failed to delete order");
                }
            } catch (error) {
                console.error("Error deleting order:", error);
                Swal.fire({
                    title: "Error!",
                    text: "Failed to delete order. Please try again.",
                    icon: "error",
                    confirmButtonText: "OK",
                });
            }
        }
    }
    
    function downloadInvoice(btn) {
        const orderId = btn.dataset.id;
        window.location.href = `/admin/invoice/download/${orderId}`;
        
    }

    // Initialize the page
    function initializePage() {
        initializeModalEvents();
        initializeDataTable();
    }

    initializePage();
});