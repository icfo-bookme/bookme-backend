<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <!-- Page Header -->
        <div class="flex items-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold text-gray-800">Expenses</h1>
            <button data-modal-target="expense-modal" data-modal-toggle="expense-modal"
                    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 shadow transition-colors duration-200"
                    type="button">
                + Add Expense
            </button>
            <a href="/admin/expense-categories"
               class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 shadow transition-colors duration-200">
                + Add Category
            </a>
            <a href="/admin/expense-subcategories"
               class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 shadow transition-colors duration-200">
                + Add Subcategory
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mt-6 px-10">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mt-6 px-10">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="mt-8 px-10 bg-white rounded-lg shadow-sm p-6">
            <div class="flex flex-wrap gap-4 items-end">
                <!-- Date Range Filter -->
               <div class="flex-1 min-w-[200px]">
    <label for="date_range" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
    <select name="date_range" id="date_range" 
            class="w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <option value="custom">Custom Range</option>
        <option value="lifetime">Lifetime</option>
        <option value="today">Today</option>
        <option value="yesterday">Yesterday</option>
        <option value="this_week">This Week</option>
        <option value="last_week">Last Week</option>
        <option value="this_month">This Month</option>
        <option value="last_month">Last Month</option>
        <option value="this_quarter">This Quarter</option>
        <option value="last_quarter">Last Quarter</option>
        <option value="this_year">This Year</option>
        <option value="last_year">Last Year</option>
    </select>
</div>

                <!-- Custom Date Inputs (Hidden by default) -->
                <div id="custom-date-range" class="hidden flex-1 min-w-[200px]">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" id="start_date" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div id="custom-date-range-end" class="hidden flex-1 min-w-[200px]">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date" id="end_date" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Category Filter -->
                <div class="flex-1 min-w-[200px]">
                    <label for="category_filter" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category_id" id="category_filter"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Subcategory Filter -->
                <div class="flex-1 min-w-[200px]">
                    <label for="subcategory_filter" class="block text-sm font-medium text-gray-700 mb-1">Subcategory</label>
                    <select name="subcategory_id" id="subcategory_filter"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Subcategories</option>
                        @foreach ($subcategories as $sub)
                            <option value="{{ $sub->id }}" data-category="{{ $sub->category_id }}">{{ $sub->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button type="button" id="apply-filters"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition-colors duration-200 font-medium">
                        Apply Filters
                    </button>
                    <button type="button" id="reset-filters"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-400 transition-colors duration-200">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Expenses Table -->
        <div class="w-[90%] mt-12 mx-auto overflow-x-auto">
            <table id="example" class="min-w-full border-collapse shadow-md rounded">
                <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                <tr>
                    <th class="px-4 py-3 border">ID</th>
                    <th class="px-4 py-3 border">Category</th>
                    <th class="px-4 py-3 border">Subcategory</th>
                    <th class="px-4 py-3 border">Amount</th>
                    <th class="px-4 py-3 border">Date</th>
                    <th class="px-4 py-3 border">Description</th>
                    <th class="px-4 py-3 border">Action</th>
                </tr>
                </thead>
                <tbody class="bg-white text-sm" id="expenses-table-body">
                @php $total = 0; @endphp
                @foreach ($expenses as $expense)
                    @php $total += $expense->amount; @endphp
                    <tr class="expense-row hover:bg-gray-50 border-t" 
                        data-id="{{ $expense->id }}"
                        data-category="{{ $expense->subcategory->category_id }}"
                        data-subcategory="{{ $expense->subcategory_id }}"
                        data-date="{{ $expense->expense_date }}"
                        data-amount="{{ $expense->amount }}">
                        <td class="px-4 py-2 border">{{ $expense->id }}</td>

                        <td class="px-4 py-2 border">
                            <span class="category-display font-medium">{{ $expense->subcategory->category->name }}</span>
                            <select name="category_id" class="category-select w-full border border-gray-300 rounded p-1 hidden" disabled>
                                <option value="">Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                            {{ $cat->id == $expense->subcategory->category_id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td class="px-4 py-2 border">
                            <span class="subcategory-display">{{ $expense->subcategory->name }}</span>
                            <select name="subcategory_id" class="subcategory-select w-full border border-gray-300 rounded p-1 hidden" disabled>
                                @foreach ($subcategories->where('category_id', $expense->subcategory->category_id) as $sub)
                                    <option value="{{ $sub->id }}"
                                            {{ $sub->id == $expense->subcategory_id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td class="px-4 py-2 border">
                            <span class="amount-display">{{ number_format($expense->amount, 2) }}</span>
                            <div class="flex items-center hidden">
                                <input type="number" step="0.01" name="amount" value="{{ $expense->amount }}"
                                       class="w-24 border border-gray-300 rounded px-2 py-1">
                            </div>
                        </td>

                        <td class="px-4 py-2 border">
                            <span class="date-display">{{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}</span>
                            <input type="date" name="expense_date" value="{{ $expense->expense_date }}"
                                   class="w-full border border-gray-300 rounded px-2 py-1 hidden">
                        </td>

                        <td class="px-4 py-2 border">
                            <span class="description-display">{{ $expense->description }}</span>
                            <textarea name="description"
                                      class="w-full border border-gray-300 rounded px-2 py-1 resize-none h-16 hidden">{{ $expense->description }}</textarea>
                        </td>

                        <td class="px-4 py-2 border flex space-x-2">
                            <button type="button"
                                    class="edit-button bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition-colors duration-200"
                                    onclick="enableExpenseEdit(this)">Edit</button>
                            
                            <!-- Edit Form - Hidden until needed -->
                            <form action="{{ route('expenses.update', $expense->id) }}" method="POST" class="edit-form hidden">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                        class="save-button bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors duration-200">
                                    Save
                                </button>
                            </form>

                            <!-- Delete Form -->
                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors duration-200"
                                        onclick="return confirm('Are you sure you want to delete this expense?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total Section -->
        <div class="mt-6 px-10 text-right">
            <p class="text-lg font-semibold text-gray-800">Total: <span class="text-blue-600" id="total-amount">${{ number_format($total, 2) }}</span></p>
        </div>

        <!-- No Results Message -->
        <div id="no-results" class="hidden mt-8 text-center py-12">
            <div class="text-gray-500">
                <i class="fas fa-receipt text-5xl mb-4"></i>
                <p class="text-xl font-medium text-gray-700">No expenses found</p>
                <p class="text-gray-500 mt-2">Try adjusting your filters</p>
            </div>
        </div>

        <!-- Add Expense Modal -->
        <div id="expense-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
             class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black bg-opacity-50">
            <div class="relative p-4 w-full max-w-xl">
                <div class="bg-white rounded-lg shadow-lg">
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 class="text-xl font-semibold text-gray-800">Add Expense</h3>
                        <button type="button" data-modal-hide="expense-modal"
                                class="text-gray-400 hover:text-gray-900 text-xl rounded-lg p-2 hover:bg-gray-100 transition-colors duration-200">×</button>
                    </div>

                    <form action="{{ route('expenses.store') }}" method="POST" id="expense-form">
                        @csrf
                        <div class="p-4 space-y-4">
                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category_id" id="category_id" required
                                        class="mt-1 p-2 border border-gray-300 rounded w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Subcategory -->
                            <div>
                                <label for="subcategory_id"
                                       class="block text-sm font-medium text-gray-700">Subcategory</label>
                                <select name="subcategory_id" id="subcategory_id" required
                                        class="mt-1 p-2 border border-gray-300 rounded w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Subcategory</option>
                                </select>
                            </div>

                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="number" step="0.01" name="amount" id="amount" required
                                       class="mt-1 p-2 border border-gray-300 rounded w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="expense_date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" name="expense_date" id="expense_date" required
                                       class="mt-1 p-2 border border-gray-300 rounded w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description"
                                          class="mt-1 p-2 border border-gray-300 rounded w-full h-24 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 p-4 border-t">
                            <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors duration-200">Save</button>
                            <button type="button" data-modal-hide="expense-modal"
                                    class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 transition-colors duration-200">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Store all expenses data for filtering
        const allExpenses = [
            @foreach($expenses as $expense)
            {
                id: {{ $expense->id }},
                category_id: {{ $expense->subcategory->category_id }},
                subcategory_id: {{ $expense->subcategory_id }},
                amount: {{ $expense->amount }},
                date: "{{ $expense->expense_date }}",
                description: `{{ $expense->description }}`,
                category_name: `{{ $expense->subcategory->category->name }}`,
                subcategory_name: `{{ $expense->subcategory->name }}`,
                update_url: "{{ route('expenses.update', $expense->id) }}",
                delete_url: "{{ route('expenses.destroy', $expense->id) }}",
                csrf_token: "{{ csrf_token() }}"
            },
            @endforeach
        ];

        // Store all categories for dropdowns
        const allCategories = [
            @foreach($categories as $cat)
            {
                id: {{ $cat->id }},
                name: `{{ $cat->name }}`
            },
            @endforeach
        ];

        // Store all subcategories for dropdowns
        const allSubcategories = [
            @foreach($subcategories as $sub)
            {
                id: {{ $sub->id }},
                name: `{{ $sub->name }}`,
                category_id: {{ $sub->category_id }}
            },
            @endforeach
        ];

        // Date range utility functions
        function getDateRange(rangeType) {
            const today = new Date();
            const start = new Date();
            const end = new Date();

            switch (rangeType) {
                case 'today':
                    start.setHours(0, 0, 0, 0);
                    end.setHours(23, 59, 59, 999);
                    break;
                case 'yesterday':
                    start.setDate(today.getDate() - 1);
                    start.setHours(0, 0, 0, 0);
                    end.setDate(today.getDate() - 1);
                    end.setHours(23, 59, 59, 999);
                    break;
                case 'this_week':
                    start.setDate(today.getDate() - today.getDay());
                    start.setHours(0, 0, 0, 0);
                    end.setHours(23, 59, 59, 999);
                    break;
                case 'last_week':
                    start.setDate(today.getDate() - today.getDay() - 7);
                    start.setHours(0, 0, 0, 0);
                    end.setDate(today.getDate() - today.getDay() - 1);
                    end.setHours(23, 59, 59, 999);
                    break;
                case 'this_month':
                    start.setDate(1);
                    start.setHours(0, 0, 0, 0);
                    end.setMonth(today.getMonth() + 1, 0);
                    end.setHours(23, 59, 59, 999);
                    break;
                case 'last_month':
                    start.setMonth(today.getMonth() - 1, 1);
                    start.setHours(0, 0, 0, 0);
                    end.setMonth(today.getMonth(), 0);
                    end.setHours(23, 59, 59, 999);
                    break;
                case 'this_quarter':
                    const quarter = Math.floor(today.getMonth() / 3);
                    start.setMonth(quarter * 3, 1);
                    start.setHours(0, 0, 0, 0);
                    end.setMonth(quarter * 3 + 3, 0);
                    end.setHours(23, 59, 59, 999);
                    break;
                case 'last_quarter':
                    const lastQuarter = Math.floor(today.getMonth() / 3) - 1;
                    start.setMonth(lastQuarter * 3, 1);
                    start.setHours(0, 0, 0, 0);
                    end.setMonth(lastQuarter * 3 + 3, 0);
                    end.setHours(23, 59, 59, 999);
                    break;
                case 'this_year':
                    start.setMonth(0, 1);
                    start.setHours(0, 0, 0, 0);
                    end.setMonth(11, 31);
                    end.setHours(23, 59, 59, 999);
                    break;
                case 'last_year':
                    start.setFullYear(today.getFullYear() - 1, 0, 1);
                    start.setHours(0, 0, 0, 0);
                    end.setFullYear(today.getFullYear() - 1, 11, 31);
                    end.setHours(23, 59, 59, 999);
                    break;
                case 'custom':
                    // Use custom dates from inputs
                    const customStart = document.getElementById('start_date').value;
                    const customEnd = document.getElementById('end_date').value;
                    return {
                        start: customStart ? new Date(customStart) : null,
                        end: customEnd ? new Date(customEnd) : null
                    };
                default: // 'lifetime'
                    return { start: null, end: null };
            }

            return { start, end };
        }

        function formatDateForInput(date) {
            return date.toISOString().split('T')[0];
        }

        // Filter functionality
        function applyFilters() {
            const dateRange = document.getElementById('date_range').value;
            const categoryId = document.getElementById('category_filter').value;
            const subcategoryId = document.getElementById('subcategory_filter').value;

            const { start, end } = getDateRange(dateRange);

            const filteredExpenses = allExpenses.filter(expense => {
                const expenseDate = new Date(expense.date);
                
                // Date filter
                if (start && expenseDate < start) return false;
                if (end && expenseDate > end) return false;
                
                // Category filter
                if (categoryId && expense.category_id != categoryId) return false;
                
                // Subcategory filter
                if (subcategoryId && expense.subcategory_id != subcategoryId) return false;
                
                return true;
            });

            updateTable(filteredExpenses);
        }

        function updateTable(expenses) {
            const tbody = document.getElementById('expenses-table-body');
            const noResults = document.getElementById('no-results');
            const totalAmount = document.getElementById('total-amount');
            
            // Clear existing rows
            tbody.innerHTML = '';
            
            if (expenses.length === 0) {
                noResults.classList.remove('hidden');
                totalAmount.textContent = '$0.00';
                return;
            }
            
            noResults.classList.add('hidden');
            
            let newTotal = 0;
            
            expenses.forEach(expense => {
                newTotal += parseFloat(expense.amount);
                
                const row = document.createElement('tr');
                row.className = 'expense-row hover:bg-gray-50 border-t';
                row.setAttribute('data-id', expense.id);
                row.setAttribute('data-category', expense.category_id);
                row.setAttribute('data-subcategory', expense.subcategory_id);
                row.setAttribute('data-date', expense.date);
                row.setAttribute('data-amount', expense.amount);
                
                const formattedDate = new Date(expense.date).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
                
                row.innerHTML = `
                    <td class="px-4 py-2 border">${expense.id}</td>
                    <td class="px-4 py-2 border">
                        <span class="category-display font-medium">${expense.category_name}</span>
                        <select name="category_id" class="category-select w-full border border-gray-300 rounded p-1 hidden" disabled>
                            ${generateCategoryOptions(expense.category_id)}
                        </select>
                    </td>
                    <td class="px-4 py-2 border">
                        <span class="subcategory-display">${expense.subcategory_name}</span>
                        <select name="subcategory_id" class="subcategory-select w-full border border-gray-300 rounded p-1 hidden" disabled>
                            ${generateSubcategoryOptions(expense.category_id, expense.subcategory_id)}
                        </select>
                    </td>
                    <td class="px-4 py-2 border">
                        <span class="amount-display">${parseFloat(expense.amount).toFixed(2)}</span>
                        <div class="flex items-center hidden">
                            <input type="number" step="0.01" name="amount" value="${expense.amount}"
                                   class="w-24 border border-gray-300 rounded px-2 py-1">
                        </div>
                    </td>
                    <td class="px-4 py-2 border">
                        <span class="date-display">${formattedDate}</span>
                        <input type="date" name="expense_date" value="${expense.date}"
                               class="w-full border border-gray-300 rounded px-2 py-1 hidden">
                    </td>
                    <td class="px-4 py-2 border">
                        <span class="description-display">${expense.description || ''}</span>
                        <textarea name="description"
                                  class="w-full border border-gray-300 rounded px-2 py-1 resize-none h-16 hidden">${expense.description || ''}</textarea>
                    </td>
                    <td class="px-4 py-2 border flex space-x-2">
                        <button type="button"
                                class="edit-button bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition-colors duration-200"
                                onclick="enableExpenseEdit(this)">Edit</button>
                        
                        <!-- Edit Form with proper Laravel structure -->
                        <form action="${expense.update_url}" method="POST" class="edit-form hidden">
                            <input type="hidden" name="_token" value="${expense.csrf_token}">
                            <input type="hidden" name="_method" value="PUT">
                            <button type="submit"
                                    class="save-button bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors duration-200">
                                Save
                            </button>
                        </form>

                        <!-- Delete Form with proper Laravel structure -->
                        <form action="${expense.delete_url}" method="POST">
                            <input type="hidden" name="_token" value="${expense.csrf_token}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors duration-200"
                                    onclick="return confirm('Are you sure you want to delete this expense?')">
                                Delete
                            </button>
                        </form>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
            
            totalAmount.textContent = `$${newTotal.toFixed(2)}`;
        }

        function generateCategoryOptions(selectedId) {
            let options = '<option value="">Select Category</option>';
            
            allCategories.forEach(cat => {
                const selected = cat.id == selectedId ? 'selected' : '';
                options += `<option value="${cat.id}" ${selected}>${cat.name}</option>`;
            });
            
            return options;
        }

        function generateSubcategoryOptions(categoryId, selectedId) {
            let options = '<option value="">Select Subcategory</option>';
            
            const filteredSubcategories = allSubcategories.filter(sub => sub.category_id == categoryId);
            filteredSubcategories.forEach(sub => {
                const selected = sub.id == selectedId ? 'selected' : '';
                options += `<option value="${sub.id}" ${selected}>${sub.name}</option>`;
            });
            
            return options;
        }

        function enableExpenseEdit(button) {
            const row = button.closest('tr');
            
            // Hide display elements
            row.querySelector('.category-display').classList.add('hidden');
            row.querySelector('.subcategory-display').classList.add('hidden');
            row.querySelector('.amount-display').classList.add('hidden');
            row.querySelector('.date-display').classList.add('hidden');
            row.querySelector('.description-display').classList.add('hidden');
            
            // Show form elements
            row.querySelector('.category-select').classList.remove('hidden');
            row.querySelector('.subcategory-select').classList.remove('hidden');
            row.querySelector('.flex.items-center').classList.remove('hidden');
            row.querySelector('input[name="expense_date"]').classList.remove('hidden');
            row.querySelector('textarea[name="description"]').classList.remove('hidden');
            
            // Enable form fields
            row.querySelector('.category-select').disabled = false;
            row.querySelector('.subcategory-select').disabled = false;
            row.querySelector('input[name="amount"]').disabled = false;
            row.querySelector('input[name="expense_date"]').disabled = false;
            row.querySelector('textarea[name="description"]').disabled = false;
            
            // Add event listener for category change to update subcategories
            const categorySelect = row.querySelector('.category-select');
            const subcategorySelect = row.querySelector('.subcategory-select');
            
            categorySelect.addEventListener('change', function() {
                const selectedCategoryId = this.value;
                subcategorySelect.innerHTML = generateSubcategoryOptions(selectedCategoryId, '');
            });
            
            // Toggle buttons
            button.classList.add('hidden');
            row.querySelector('.edit-form').classList.remove('hidden');
            
            // Update the edit form with current values when Save is clicked
            const editForm = row.querySelector('.edit-form');
            editForm.onsubmit = function() {
                // Add hidden inputs with current form values to the edit form
                const categoryId = row.querySelector('.category-select').value;
                const subcategoryId = row.querySelector('.subcategory-select').value;
                const amount = row.querySelector('input[name="amount"]').value;
                const expenseDate = row.querySelector('input[name="expense_date"]').value;
                const description = row.querySelector('textarea[name="description"]').value;
                
                // Create hidden inputs for the form submission
                const categoryInput = document.createElement('input');
                categoryInput.type = 'hidden';
                categoryInput.name = 'category_id';
                categoryInput.value = categoryId;
                
                const subcategoryInput = document.createElement('input');
                subcategoryInput.type = 'hidden';
                subcategoryInput.name = 'subcategory_id';
                subcategoryInput.value = subcategoryId;
                
                const amountInput = document.createElement('input');
                amountInput.type = 'hidden';
                amountInput.name = 'amount';
                amountInput.value = amount;
                
                const dateInput = document.createElement('input');
                dateInput.type = 'hidden';
                dateInput.name = 'expense_date';
                dateInput.value = expenseDate;
                
                const descriptionInput = document.createElement('input');
                descriptionInput.type = 'hidden';
                descriptionInput.name = 'description';
                descriptionInput.value = description;
                
                // Add inputs to form
                editForm.appendChild(categoryInput);
                editForm.appendChild(subcategoryInput);
                editForm.appendChild(amountInput);
                editForm.appendChild(dateInput);
                editForm.appendChild(descriptionInput);
                
                // Form will now submit with all data and trigger page reload
                return true;
            };
        }

        // Dynamic Subcategory Dropdown for Modal
        const categorySelect = document.getElementById('category_id');
        const subcategorySelect = document.getElementById('subcategory_id');

        categorySelect?.addEventListener('change', function () {
            const selectedCategoryId = this.value;
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

            allSubcategories.forEach(sub => {
                if (sub.category_id == selectedCategoryId) {
                    const option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.name;
                    subcategorySelect.appendChild(option);
                }
            });
        });

        // Dynamic Subcategory Filter
        const categoryFilter = document.getElementById('category_filter');
        const subcategoryFilter = document.getElementById('subcategory_filter');

        categoryFilter?.addEventListener('change', function () {
            const selectedCategoryId = this.value;
            const currentOptions = subcategoryFilter.querySelectorAll('option');
            
            currentOptions.forEach(option => {
                if (option.value === '') return; // Keep "All Subcategories" option
                
                if (selectedCategoryId === '' || option.getAttribute('data-category') === selectedCategoryId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
            
            // Reset subcategory filter when category changes
            subcategoryFilter.value = '';
            applyFilters();
        });

        // Date range selector functionality
        const dateRangeSelect = document.getElementById('date_range');
        const customDateRange = document.getElementById('custom-date-range');
        const customDateRangeEnd = document.getElementById('custom-date-range-end');

        dateRangeSelect?.addEventListener('change', function() {
            const value = this.value;
            
            if (value === 'custom') {
                customDateRange.classList.remove('hidden');
                customDateRangeEnd.classList.remove('hidden');
            } else {
                customDateRange.classList.add('hidden');
                customDateRangeEnd.classList.add('hidden');
                
                // Auto-apply filters when predefined range is selected
                applyFilters();
            }
        });

        // Event Listeners
        document.getElementById('apply-filters').addEventListener('click', applyFilters);
        
        document.getElementById('reset-filters').addEventListener('click', function() {
    document.getElementById('date_range').value = 'custom'; // Changed from 'lifetime' to 'custom'
    document.getElementById('start_date').value = '';
    document.getElementById('end_date').value = '';
    document.getElementById('category_filter').value = '';
    document.getElementById('subcategory_filter').value = '';
    
    // Show custom date inputs since custom range is selected
    customDateRange.classList.remove('hidden');
    customDateRangeEnd.classList.remove('hidden');
    
    // Show all options in subcategory filter
    const subcategoryOptions = subcategoryFilter.querySelectorAll('option');
    subcategoryOptions.forEach(option => {
        option.style.display = '';
    });
    
    applyFilters();
});

        // Auto-apply filters when inputs change
        document.getElementById('date_range').addEventListener('change', applyFilters);
        document.getElementById('start_date').addEventListener('change', applyFilters);
        document.getElementById('end_date').addEventListener('change', applyFilters);
        document.getElementById('category_filter').addEventListener('change', applyFilters);
        document.getElementById('subcategory_filter').addEventListener('change', applyFilters);

document.addEventListener('DOMContentLoaded', function() {
    const expenseDateInput = document.getElementById('expense_date');
    if (expenseDateInput && !expenseDateInput.value) {
        expenseDateInput.value = new Date().toISOString().split('T')[0];
    }
    
    // Show custom date inputs by default since "Custom Range" is selected
    const dateRangeSelect = document.getElementById('date_range');
    const customDateRange = document.getElementById('custom-date-range');
    const customDateRangeEnd = document.getElementById('custom-date-range-end');
    
    if (dateRangeSelect && dateRangeSelect.value === 'custom') {
        customDateRange.classList.remove('hidden');
        customDateRangeEnd.classList.remove('hidden');
    }
    
    // Apply filters on page load
    applyFilters();
});
    </script>
</x-app-layout>