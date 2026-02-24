<x-app-layout>
    <div class="container w-[95%] mx-auto">
        <h1 class="text-2xl font-bold  pb-3 pt-10 ">Tour Consultation Requests</h1>
        
        <!-- Button to Open Modal for Adding Requests -->
        

       

        <!-- Table to Show Existing Requests -->
        <div class="w-[90%] mt-12 mx-auto">
            <table id="example" class="table-auto w-full mt-6 border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Phone Number</th>
                        <th class="px-4 py-2 border">Address</th>
                        <th class="px-4 py-2 border">Additional Info</th>
                        <th class="px-4 py-2 border">Package</th>
                         <th class="px-4 py-2 border">Requested Date</th>
                         <th class="px-4 py-2 border">Response Time</th>
                        <th class="px-4 py-2 border">Verified By</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                    <tr class="bg-white hover:bg-gray-50">
                        <form action="{{ route('tour-consultation-requests.update', $request->id) }}" method="POST" class="update-form">
                            @csrf
                            @method('PUT')
                            <td class="px-4 py-2 border">
                                <textarea name="" class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ $request->id }}</textarea>
                            </td>
                            <td class="px-4 py-2 border">
                                <textarea name="name" class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ $request->name }}</textarea>
                            </td>
                            <td class="px-4 py-2 border">
                                <textarea name="number" class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ $request->number }}</textarea>
                            </td>
                            <td class="px-4 py-2 border">
                                <textarea name="address" class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ $request->address }}</textarea>
                            </td>
                            <td class="px-4 py-2 border">
                                <textarea name="additional_info" class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ $request->additional_info }}</textarea>
                            </td>
                             <td class="px-4 py-2 border">
                                <textarea name="property_name" class="w-full border border-gray-300 rounded px-2 py-1 resize-none" disabled>{{ $request->property_name }}</textarea>
                            </td>
                            <td class="px-4 py-2 border">
   
    {{ $request->created_at->format('j F Y, h:i A') }}


</td>
<td class="px-4 py-2 border">
    @if($request->verified_by)
        {{ $request->updated_at->diffInHours($request->created_at) }} hours,
        {{ $request->updated_at->diffInMinutes($request->created_at) % 60 }} minutes
    @else
        <span class="text-gray-400">Not Verified</span>
    @endif
</td>


                            <td class="px-4 py-2 border">
                                {{ $request->verified_by }}
                            </td>
                            <td class="px-4 py-2 border flex space-x-2">
                                <!-- Edit Button -->
                                <button type="button" onclick="enableEdit(this)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                <!-- Save Button -->
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-button">Save</button>
                            </form>
                                <!-- Delete Button -->
                                <!--<form action="{{ route('tour-consultation-requests.destroy', $request->id) }}" method="POST" class="inline-block">-->
                                <!--    @csrf-->
                                <!--    @method('DELETE')-->
                                <!--    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>-->
                                <!--</form>-->
    @if($request->verified_by) 
        <span class="text-green-600 font-semibold">Verified</span>
    @else
        <form action="{{ route('consultation.verify-by', $request->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button class="bg-blue-950 text-white px-3 py-1 rounded hover:bg-blue-700" type="submit">
                Verify
            </button>
        </form>
    @endif

                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Enable Edit Functionality
        function enableEdit(button) {
            const row = button.closest('tr');
            row.querySelectorAll('textarea').forEach(textarea => textarea.disabled = false); // Enable all textarea fields
            button.classList.add('hidden'); // Hide the Edit button
            row.querySelector('.save-button').classList.remove('hidden'); // Show the Save button
        }
        
        document.getElementById('verifyBtn').addEventListener('click', function() {
    let id = this.getAttribute('data-id');
    
    axios.put(`/admin/consultation-requests/verifyby/user/${id}`, {}, {
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(function(response) {
        alert('Verified By: ' + response.data.verifyed_by);
    })
    .catch(function(error) {
        console.error(error);
        alert('Something went wrong');
    });
});
    </script>
    
    
</x-app-layout>