<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <div class="flex items-center justify-between px-10 pt-10">
            <h1 class="text-2xl font-bold">Schedules:</h1>
            <!-- Add Schedule Button -->
            <button data-modal-target="schedule-modal" data-modal-toggle="schedule-modal"
                class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                Add Schedule
            </button>
        </div>

        <!-- Add Schedule Modal -->
        <div id="schedule-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden fixed top-0 left-0 right-0 z-50 w-full overflow-y-auto h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-4xl p-4 max-h-full mx-auto mt-10">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Add Schedules</h3>
                        <button type="button" class="text-gray-400 hover:bg-gray-200 rounded-lg text-sm w-8 h-8"
                            data-modal-hide="schedule-modal">✕</button>
                    </div>

                    <form action="{{ route('schedules.store') }}" method="POST">
                        @csrf
                        <div class="p-6 space-y-4">
                            <div id="scheduleFields">
                                <div class="scheduleRow grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                                    <input type="hidden" name="schedules[0][property_id]" value="{{ $property_id }}">
                                    <div>
                                        <label>Depart Date</label>
                                        <input type="date" name="schedules[0][depart_date]" class="w-full p-2 border rounded" required>
                                    </div>
                                    <div>
                                        <label>Depart Time</label>
                                        <input type="time" name="schedules[0][depart_time]" class="w-full p-2 border rounded" required>
                                    </div>
                                    <div>
                                        <label>Return Date</label>
                                        <input type="date" name="schedules[0][return_date]" class="w-full p-2 border rounded" required>
                                    </div>
                                    <div>
                                        <label>Return Time</label>
                                        <input type="time" name="schedules[0][return_time]" class="w-full p-2 border rounded" required>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <!--<button type="button" id="addScheduleBtn"
                                    class="px-4 py-2 bg-green-600 text-white rounded">Add Another</button>-->
                                <button type="button" id="removeScheduleBtn"
                                    class="px-4 py-2 bg-red-600 text-white rounded">Remove</button>
                            </div>
                        </div>

                        <div class="flex justify-end p-4 border-t">
                            <button type="submit"
                                class="px-5 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">Save Schedules</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabs for months -->
        <div class="mt-10 px-10">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-4" aria-label="Tabs">
                    @foreach($tabs as $monthKey => $monthName)
                        <a href="#tab-{{ $monthKey }}"
                           class="tab-link px-3 py-2 font-medium text-sm rounded-t-lg border 
                               @if ($loop->first) border-blue-700 bg-blue-100 text-blue-700 
                               @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                           data-tab-target="tab-{{ $monthKey }}">
                            {{ $monthName }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="tab-contents mt-4">
                @foreach($groupedSchedules as $monthKey => $schedulesOfMonth)
                    <div id="tab-{{ $monthKey }}" class="tab-content 
                        @if ($loop->first) block @else hidden @endif">
                        <div class="w-full overflow-auto">
                            <table class="table-auto w-full border-collapse border">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 border">ID</th>
                                        <th class="px-4 py-2 border">Depart</th>
                                        <th class="px-4 py-2 border">Return</th>
                                        <th class="px-4 py-2 border">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedulesOfMonth as $schedule)
                                        <tr class="bg-white hover:bg-gray-50">
                                            <td class="border px-4 py-2">{{ $schedule->id }}</td>
                                            <td class="border px-4 py-2">{{ $schedule->depart_date }} {{ $schedule->depart_time }}</td>
                                            <td class="border px-4 py-2">{{ $schedule->return_date }} {{ $schedule->return_time }}</td>
                                            <td class="border px-4 py-2 flex space-x-2">
                                                <!-- Edit Button -->
                                                <button data-modal-target="edit-modal-{{ $schedule->id }}" data-modal-toggle="edit-modal-{{ $schedule->id }}"
                                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>

                                                <!-- Delete -->
                                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div id="edit-modal-{{ $schedule->id }}" tabindex="-1" aria-hidden="true"
                                            class="hidden fixed top-0 left-0 right-0 z-50 w-full overflow-y-auto h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative w-full max-w-2xl p-4 max-h-full mx-auto mt-10">
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <div class="flex items-center justify-between p-4 border-b dark:border-gray-600">
                                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                            Edit Schedule #{{ $schedule->id }}
                                                        </h3>
                                                        <button type="button" class="text-gray-400 hover:bg-gray-200 rounded-lg text-sm w-8 h-8"
                                                            data-modal-hide="edit-modal-{{ $schedule->id }}">✕</button>
                                                    </div>

                                                    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="p-6 space-y-4">
                                                            <input type="hidden" name="property_id" value="{{ $schedule->property_id }}">
                                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                                                <input type="hidden" name="id" value="{{ $schedule->id }}">

                                                                <div>
                                                                    <label>Depart Date</label>
                                                                    <input type="date" name="depart_date" value="{{ $schedule->depart_date }}"
                                                                        class="w-full p-2 border rounded" required>
                                                                </div>
                                                                <div>
                                                                    <label>Depart Time</label>
                                                                    <input type="time" name="depart_time" value="{{ $schedule->depart_time }}"
                                                                        class="w-full p-2 border rounded" required>
                                                                </div>
                                                                <div>
                                                                    <label>Return Date</label>
                                                                    <input type="date" name="return_date" value="{{ $schedule->return_date }}"
                                                                        class="w-full p-2 border rounded" required>
                                                                </div>
                                                                <div>
                                                                    <label>Return Time</label>
                                                                    <input type="time" name="return_time" value="{{ $schedule->return_time }}"
                                                                        class="w-full p-2 border rounded" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex justify-end p-4 border-t">
                                                            <button type="submit"
                                                                class="px-5 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ✅ Fixed JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let scheduleIndex = 1;

            const addBtn = document.getElementById('addScheduleBtn');
            const removeBtn = document.getElementById('removeScheduleBtn');

            if (addBtn) {
                addBtn.addEventListener('click', () => {
                    const container = document.getElementById('scheduleFields');
                    const newRow = document.querySelector('.scheduleRow').cloneNode(true);

                    newRow.querySelectorAll('input').forEach((el) => {
                        const name = el.getAttribute('name');
                        if (name) {
                            const newName = name.replace(/\[\d+\]/, `[${scheduleIndex}]`);
                            el.setAttribute('name', newName);
                            el.value = '';
                        }
                    });

                    container.appendChild(newRow);
                    scheduleIndex++;
                });
            }

            if (removeBtn) {
                removeBtn.addEventListener('click', () => {
                    const rows = document.querySelectorAll('.scheduleRow');
                    if (rows.length > 1) {
                        rows[rows.length - 1].remove();
                        scheduleIndex--;
                    } else {
                        alert('At least one schedule must remain.');
                    }
                });
            }

            // ✅ Tabs switching JS (now works)
            document.querySelectorAll('.tab-link').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = this.getAttribute('data-tab-target');

                    // hide all tab contents
                    document.querySelectorAll('.tab-content').forEach(tc => {
                        tc.classList.add('hidden');
                        tc.classList.remove('block');
                    });

                    // remove active style from all tabs
                    document.querySelectorAll('.tab-link').forEach(l => {
                        l.classList.remove('border-blue-700', 'bg-blue-100', 'text-blue-700');
                        l.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    });

                    // activate clicked tab
                    this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    this.classList.add('border-blue-700', 'bg-blue-100', 'text-blue-700');

                    // show target tab
                    const contentDiv = document.getElementById(target);
                    contentDiv.classList.remove('hidden');
                    contentDiv.classList.add('block');
                });
            });
        });
    </script>
</x-app-layout>
