<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-blue-900 px-6 py-4 flex justify-between">
                    <button type="button" id="enable-edit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Edit Room
                    </button>
                    <a href="{{ url('/rooms/' . $hotel_id) }}" class="inline-flex items-center px-3 py-1 bg-green-900 text-white rounded hover:bg-yellow-600 text-sm">
                        Back To Room List
                    </a>
                </div>
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Main Room Edit Form -->
                <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-200" id="roomForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="hotel_id" value="{{ $room->hotel_id }}">
                    
                    <!-- Basic Information Section -->
                    <div class="px-6 py-4">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Room Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Room Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Room Name <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', $room->name) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Room Type -->
                            <div>
                                <label for="room_type" class="block text-sm font-medium text-gray-700 mb-1">
                                    Room Type <span class="text-red-500">*</span>
                                </label>
                                <select id="room_type" name="room_type" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('room_type') border-red-500 @enderror">
                                    <option value="">-- Select Room Type --</option>
                                    @foreach ($roomType as $type)
                                        <option value="{{ $type->id }}" {{ (old('room_type', $room->room_type) == $type->id) ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Max Adults -->
                            <div>
                                <label for="max_adults" class="block text-sm font-medium text-gray-700 mb-1">Max Adults <span class="text-red-500">*</span></label>
                                <input type="number" id="max_adults" name="max_adults" value="{{ old('max_adults', $room->max_adults) }}" min="1" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('max_adults') border-red-500 @enderror">
                                @error('max_adults')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Max Guests Allowed -->
                            <div>
                                <label for="max_guests_allowed" class="block text-sm font-medium text-gray-700 mb-1">Max Guests Allowed <span class="text-red-500">*</span></label>
                                <input type="number" id="max_guests_allowed" name="max_guests_allowed" value="{{ old('max_guests_allowed', $room->max_guests_allowed) }}" min="0" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('max_guests_allowed') border-red-500 @enderror">
                                @error('max_guests_allowed')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Complementary Child Occupancy -->
                            <div>
                                <label for="complementary_child_occupancy" class="block text-sm font-medium text-gray-700 mb-1">Child Occupancy <span class="text-red-500">*</span></label>
                                <input type="number" id="complementary_child_occupancy" name="complementary_child_occupancy" value="{{ old('complementary_child_occupancy', $room->complementary_child_occupancy) }}" min="0" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('complementary_child_occupancy') border-red-500 @enderror">
                                @error('complementary_child_occupancy')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Extra Bed Available -->
                            <div>
                                <label for="extra_bed_available" class="block text-sm font-medium text-gray-700 mb-1">Extra Bed Available <span class="text-red-500">*</span></label>
                                <select id="extra_bed_available" name="extra_bed_available" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('extra_bed_available') border-red-500 @enderror">
                                    <option value="0" {{ old('extra_bed_available', $room->extra_bed_available) == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('extra_bed_available', $room->extra_bed_available) == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                                @error('extra_bed_available')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Smoking Status -->
                            <div>
                                <label for="smoking_status" class="block text-sm font-medium text-gray-700 mb-1">Smoking Status <span class="text-red-500">*</span></label>
                                <select id="smoking_status" name="smoking_status" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('smoking_status') border-red-500 @enderror">
                                    <option value="0" {{ old('smoking_status', $room->smoking_status) == '0' ? 'selected' : '' }}>Non-Smoking</option>
                                    <option value="1" {{ old('smoking_status', $room->smoking_status) == '1' ? 'selected' : '' }}>Smoking</option>
                                </select>
                                @error('smoking_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="breakfast_status" class="block text-sm font-medium text-gray-700 mb-1">
                                    Breakfast Status <span class="text-red-500">*</span>
                                </label>
                                <select id="breakfast_status" name="breakfast_status" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('breakfast_status') border-red-500 @enderror">
                                    <option value="included" {{ old('breakfast_status', $room->breakfast_status) == 'included' ? 'selected' : '' }}>Included</option>
                                    <option value="not included" {{ old('breakfast_status', $room->breakfast_status) == 'not included' ? 'selected' : '' }}>Not Included</option>
                                </select>
                                @error('breakfast_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Room Size -->
                            <div class="relative">
                                <label for="room_size_sqft" class="block text-sm font-medium text-gray-700 mb-1">Room Size (sqft)</label>
                                <div class="flex">
                                    <input type="number" id="room_size_sqft" name="room_size_sqft" value="{{ old('room_size_sqft', $room->room_size_sqft) }}" min="0" step="0.01"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-l-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('room_size_sqft') border-red-500 @enderror">
                                    <button type="button" onclick="convertM2ToSqft()" 
                                        class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 bg-gray-100 text-gray-700 rounded-r-md hover:bg-gray-200 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        Convert m² to sqft
                                    </button>
                                </div>
                                @error('room_size_sqft')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Room View -->
                            <div>
                                <label for="room_view" class="block text-sm font-medium text-gray-700 mb-1">Room View</label>
                                <input type="text" id="room_view" name="room_view" value="{{ old('room_view', $room->room_view) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('room_view') border-red-500 @enderror">
                                @error('room_view')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <h2 class="text-lg font-medium text-gray-900 my-4">Room Price Section</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                <input type="number" id="price" name="price" value="{{ old('price', $room->price) }}" min="0" step="1"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror">
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="discount" class="block text-sm font-medium text-gray-700 mb-1">Discount %</label>
                                <input type="number" id="discouont" name="discouont" value="{{ old('discouont', $room->discouont) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('discount') border-red-500 @enderror">
                                @error('discount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Room Characteristics -->
                        <div class="mt-6">
                            <label for="room_characteristics" class="block text-sm font-medium text-gray-700 mb-1">Room Characteristics</label>
                            <textarea id="room_characteristics" name="room_characteristics" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('room_characteristics') border-red-500 @enderror">{{ old('room_characteristics', $room->room_characteristics) }}</textarea>
                            @error('room_characteristics')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $room->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Photos Section -->
                    <div class="px-6 py-4">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Photos</h2>

                        <!-- Current Main Photo -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Main Photo</label>
                            <div class="flex items-center">
                                <img src="{{ asset('storage/' . $room->main_image) }}" 
                                     alt="Room Main Photo" 
                                     class="h-32 w-32 object-cover rounded-md"
                                     onerror="this.onerror=null;this.src='https://via.placeholder.com/150?text=Image+Not+Found'">
                                <div class="ml-4">
                                    <label for="main_image" class="block text-sm font-medium text-gray-700 mb-1">Update Main Photo</label>
                                    <input type="file" id="main_image" name="main_image" accept="image/*"
                                        class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('main_image') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-gray-500">Max size: 4MB (JPEG, PNG, JPG, GIF)</p>
                                    @error('main_image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <div id="mainImagePreview" class="mt-2 hidden">
                                        <img id="mainImagePreviewImg" class="h-32 object-cover rounded border" alt="Main image preview">
                                        <button type="button" onclick="showImagePreview('main')" class="mt-2 text-sm text-blue-600 hover:text-blue-800">Preview & Adjust</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Photos -->
                        @if($room->images->count() > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Additional Photos</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    @foreach($room->images as $image)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             alt="Room Photo" 
                                             class="w-full h-32 object-cover rounded"
                                             onerror="this.onerror=null;this.src='https://via.placeholder.com/150?text=Image+Not+Found'">
                                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button type="button" class="text-white hover:text-red-400 delete-photo" 
                                                    data-image-id="{{ $image->id }}"
                                                    data-room-id="{{ $room->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Add More Photos</label>
                            <input type="file" id="images" name="images[]" multiple accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('images.*') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">You can select multiple files (Max size: 4MB each)</p>
                            @error('images.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div id="additionalImagesPreview" class="mt-2 hidden grid grid-cols-3 gap-2"></div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="px-6 py-4 bg-gray-50 flex justify-between">
                        <div></div>
                        <div class="flex space-x-2">
                            <button type="button" id="previewBtn" class="hidden inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 mr-3">
                                Preview Images
                            </button>
                            <button type="submit" id="submit-button" disabled class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 opacity-50 cursor-not-allowed">
                                Update Room
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 max-w-4xl w-full max-h-[90vh] overflow-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Image Quality Preview</h3>
                <button onclick="closePreviewModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="previewContainer" class="space-y-4"></div>
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closePreviewModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button id="confirmUploadBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Confirm Upload</button>
            </div>
        </div>
    </div>

    <script>
        // Global variables for image handling
        let compressedMainFile = null;
        let compressedAdditionalFiles = [];
        const MAX_IMAGE_SIZE_MB = 2; // Target size after compression (2MB)
        const MAX_IMAGE_SIZE_BYTES = MAX_IMAGE_SIZE_MB * 1024 * 1024;
        const ABSOLUTE_MAX_SIZE_MB = 4; // Absolute max size before compression (4MB)
        const ABSOLUTE_MAX_SIZE_BYTES = ABSOLUTE_MAX_SIZE_MB * 1024 * 1024;

        // Initialize event listeners when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Disable all form inputs initially
            const formInputs = document.querySelectorAll('input, textarea, select');
            formInputs.forEach(input => {
                input.disabled = true;
            });
            
            // Enable edit mode
            const enableEditBtn = document.getElementById('enable-edit');
            const submitBtn = document.getElementById('submit-button');
            
            enableEditBtn.addEventListener('click', function() {
                formInputs.forEach(input => {
                    input.disabled = false;
                });
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                enableEditBtn.disabled = true;
                enableEditBtn.classList.add('opacity-50', 'cursor-not-allowed');
            });

            // Main image change handler
            document.getElementById('main_image').addEventListener('change', function(e) {
                handleImageSelection(e.target.files[0], 'main');
            });

            // Additional images change handler
            document.getElementById('images').addEventListener('change', function(e) {
                handleMultipleImageSelection(Array.from(e.target.files), 'additional');
            });

            // Confirm upload button handler
            document.getElementById('confirmUploadBtn').addEventListener('click', function() {
                prepareAndSubmitForm();
            });

            // Preview button handler
            document.getElementById('previewBtn').addEventListener('click', function() {
                showAllImagesPreview();
            });

            // Form submission handler
            document.getElementById('roomForm').addEventListener('submit', function(e) {
                const mainImage = document.getElementById('main_image').files[0];
                const additionalImages = document.getElementById('images').files;
                
                // Check if main image exceeds absolute max size
                if (mainImage && mainImage.size > ABSOLUTE_MAX_SIZE_BYTES) {
                    e.preventDefault();
                    showSizeError('Main image exceeds maximum allowed size of 4MB. Please choose a smaller image.');
                    return;
                }
                
                // Check additional images
                if (additionalImages.length > 0) {
                    for (let i = 0; i < additionalImages.length; i++) {
                        if (additionalImages[i].size > ABSOLUTE_MAX_SIZE_BYTES) {
                            e.preventDefault();
                            showSizeError(`Image "${additionalImages[i].name}" exceeds maximum allowed size of 4MB. Please choose a smaller image.`);
                            return;
                        }
                    }
                }
                
                // Check if we need to compress images (only if they're > 2MB)
                let needsCompression = false;
                
                if (mainImage && mainImage.size > MAX_IMAGE_SIZE_BYTES && !compressedMainFile) {
                    needsCompression = true;
                }
                
                if (additionalImages.length > 0) {
                    for (let i = 0; i < additionalImages.length; i++) {
                        if (additionalImages[i].size > MAX_IMAGE_SIZE_BYTES && 
                            (!compressedAdditionalFiles[i] || compressedAdditionalFiles[i].name !== additionalImages[i].name)) {
                            needsCompression = true;
                            break;
                        }
                    }
                }
                
                if (needsCompression) {
                    e.preventDefault();
                    showAllImagesPreview();
                }
            });

            // Photo deletion using JavaScript fetch API
            document.querySelectorAll('.delete-photo').forEach(button => {
                button.addEventListener('click', function() {
                    const imageId = this.getAttribute('data-image-id');
                    const roomId = this.getAttribute('data-room-id');
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/api/roomsphotos/${imageId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    // Remove the image element from DOM
                                    this.closest('.relative').remove();
                                    // Show success message
                                    Swal.fire(
                                        'Deleted!',
                                        'The photo has been deleted.',
                                        'success'
                                    );
                                } else {
                                    throw new Error(data.message || 'Failed to delete photo');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete photo: ' + error.message,
                                    'error'
                                );
                            });
                        }
                    });
                });
            });
        });

        // Handle single image selection
        function handleImageSelection(file, type) {
            if (!file) return;

            // First check if file exceeds absolute max size (4MB)
            if (file.size > ABSOLUTE_MAX_SIZE_BYTES) {
                showAbsoluteSizeError(file, type);
                return;
            }

            // Show preview immediately
            showImagePreviewThumbnail(file, type);

            // If image is larger than 2MB but less than 4MB, we'll compress it
            if (file.size > MAX_IMAGE_SIZE_BYTES) {
                showSizeWarning(file, type);
            } else {
                // If image is <= 2MB, use it as-is
                if (type === 'main') {
                    compressedMainFile = file;
                }
                updatePreviewButton();
            }
        }

        // Handle multiple image selection
        function handleMultipleImageSelection(files, type) {
            if (!files || files.length === 0) return;

            // First check for any files that exceed absolute max size (4MB)
            const oversizedFiles = files.filter(file => file.size > ABSOLUTE_MAX_SIZE_BYTES);
            if (oversizedFiles.length > 0) {
                showAbsoluteSizeError(oversizedFiles[0], type);
                return;
            }

            // Clear previous previews
            const previewContainer = document.getElementById('additionalImagesPreview');
            previewContainer.innerHTML = '';

            // Show previews immediately
            files.forEach((file, index) => {
                showImagePreviewThumbnail(file, type, index);
            });

            // Check if any files need compression (>2MB)
            let hasLargeFiles = files.some(file => file.size > MAX_IMAGE_SIZE_BYTES);

            if (hasLargeFiles) {
                showSizeWarning(files[0], type);
            } else {
                // If all files are <= 2MB, use them as-is
                if (type === 'additional') {
                    compressedAdditionalFiles = files;
                }
                updatePreviewButton();
            }
        }

        // Show image preview thumbnail
        function showImagePreviewThumbnail(file, type, index = null) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (type === 'main') {
                    const previewDiv = document.getElementById('mainImagePreview');
                    const previewImg = document.getElementById('mainImagePreviewImg');
                    previewImg.src = e.target.result;
                    previewDiv.classList.remove('hidden');
                } else {
                    const previewContainer = document.getElementById('additionalImagesPreview');
                    previewContainer.classList.remove('hidden');
                    
                    const previewItem = document.createElement('div');
                    previewItem.className = 'relative';
                    previewItem.innerHTML = `
                        <img src="${e.target.result}" class="h-24 w-full object-cover rounded border">
                        <button type="button" onclick="confirmRemoveImage('${type}', ${index !== null ? index : ''})" class="absolute bottom-1 right-1 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded hover:bg-opacity-70">
                            Remove
                        </button>
                    `;
                    previewContainer.appendChild(previewItem);
                }
            };
            reader.readAsDataURL(file);
        }

        // Show absolute size error (for files > 4MB)
        function showAbsoluteSizeError(file, type) {
            const fileName = file.name;
            const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
            
            Swal.fire({
                title: 'Image Too Large',
                html: `The image <strong>${fileName}</strong> is ${fileSizeMB} MB which exceeds the maximum allowed size of ${ABSOLUTE_MAX_SIZE_MB} MB.<br><br>Please choose a smaller image.`,
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700'
                },
                buttonsStyling: false
            }).then(() => {
                if (type === 'main') {
                    document.getElementById('main_image').value = '';
                    document.getElementById('mainImagePreview').classList.add('hidden');
                } else {
                    document.getElementById('images').value = '';
                    document.getElementById('additionalImagesPreview').classList.add('hidden');
                }
            });
        }

        // Show size warning alert (for files > 2MB but <= 4MB)
        function showSizeWarning(file, type) {
            const fileName = file.name;
            const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
            
            Swal.fire({
                title: 'Large Image Detected',
                html: `The image <strong>${fileName}</strong> is ${fileSizeMB} MB (max ${MAX_IMAGE_SIZE_MB} MB recommended).<br><br>We'll automatically compress it while maintaining quality.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Continue',
                cancelButtonText: 'Choose Different Image',
                customClass: {
                    confirmButton: 'px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700',
                    cancelButton: 'px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 mr-3'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    compressAndPreviewImages(type);
                } else {
                    if (type === 'main') {
                        document.getElementById('main_image').value = '';
                        document.getElementById('mainImagePreview').classList.add('hidden');
                    } else {
                        document.getElementById('images').value = '';
                        document.getElementById('additionalImagesPreview').classList.add('hidden');
                    }
                }
            });
        }

        // Show general size error
        function showSizeError(message) {
            Swal.fire({
                title: 'Image Size Error',
                text: message,
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700'
                },
                buttonsStyling: false
            });
        }

        // Compress images and show preview (only for images > 2MB)
        async function compressAndPreviewImages(type) {
            let files = [];
            
            if (type === 'main') {
                files = [document.getElementById('main_image').files[0]];
            } else {
                files = Array.from(document.getElementById('images').files);
            }
            
            // Filter only files that need compression (>2MB)
            const filesToCompress = files.filter(file => file.size > MAX_IMAGE_SIZE_BYTES);
            
            // Files that don't need compression (<=2MB)
            const filesToKeep = files.filter(file => file.size <= MAX_IMAGE_SIZE_BYTES);

            // Show loading state
            Swal.fire({
                title: 'Processing Images',
                html: 'Compressing large images to optimal size...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                // Process only files that need compression
                const compressionPromises = filesToCompress.map(file => 
                    compressImage(file, MAX_IMAGE_SIZE_BYTES)
                );
                
                const compressedFiles = await Promise.all(compressionPromises);

                // Combine compressed files with files that didn't need compression
                const allFiles = [...compressedFiles, ...filesToKeep];
                
                // Store files in the appropriate variables
                if (type === 'main') {
                    compressedMainFile = allFiles[0];
                    showImagePreviewThumbnail(compressedMainFile, 'main');
                } else {
                    compressedAdditionalFiles = allFiles;
                    const previewContainer = document.getElementById('additionalImagesPreview');
                    previewContainer.innerHTML = '';
                    compressedAdditionalFiles.forEach((file, index) => {
                        showImagePreviewThumbnail(file, 'additional', index);
                    });
                }

                // Update UI
                Swal.close();
                updatePreviewButton();
            } catch (error) {
                Swal.fire({
                    title: 'Compression Error',
                    text: 'An error occurred while compressing images. Please try again with different images.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('Image compression error:', error);
            }
        }

        // Image compression function (only called for images > 2MB)
        function compressImage(file, maxSizeBytes) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    const img = new Image();
                    img.src = event.target.result;
                    
                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        
                        // Calculate new dimensions while maintaining aspect ratio
                        const MAX_WIDTH = 1600;
                        const MAX_HEIGHT = 1200;
                        let width = img.width;
                        let height = img.height;

                        if (width > height) {
                            if (width > MAX_WIDTH) {
                                height *= MAX_WIDTH / width;
                                width = MAX_WIDTH;
                            }
                        } else {
                            if (height > MAX_HEIGHT) {
                                width *= MAX_HEIGHT / height;
                                height = MAX_HEIGHT;
                            }
                        }
                        
                        canvas.width = width;
                        canvas.height = height;
                        
                        // Draw image on canvas with new dimensions
                        ctx.drawImage(img, 0, 0, width, height);
                        
                        // Start with high quality
                        let quality = 0.9;
                        let attempts = 0;
                        const MAX_ATTEMPTS = 10;
                        
                        const compressIteration = () => {
                            canvas.toBlob((blob) => {
                                attempts++;
                                
                                // If we're within target size or reached minimum quality/max attempts
                                if (blob.size <= maxSizeBytes || quality <= 0.5 || attempts >= MAX_ATTEMPTS) {
                                    const compressedFile = new File([blob], file.name, {
                                        type: 'image/jpeg', // Force JPEG for better compression
                                        lastModified: Date.now()
                                    });
                                    resolve(compressedFile);
                                } else {
                                    // Reduce quality more aggressively if we're way over
                                    if (blob.size > maxSizeBytes * 2) {
                                        quality -= 0.15;
                                    } else {
                                        quality -= 0.05;
                                    }
                                    
                                    setTimeout(compressIteration, 0);
                                }
                            }, 'image/jpeg', quality);
                        };
                        
                        compressIteration();
                    };
                    
                    img.onerror = function() {
                        reject(new Error('Failed to load image'));
                    };
                };
                
                reader.onerror = function() {
                    reject(new Error('Failed to read file'));
                };
                
                reader.readAsDataURL(file);
            });
        }

        // Show image preview in modal
        function showImagePreview(type, index = null) {
            const modal = document.getElementById('imagePreviewModal');
            const container = document.getElementById('previewContainer');
            container.innerHTML = '';

            let file;
            if (type === 'main') {
                file = document.getElementById('main_image').files[0];
            } else {
                file = document.getElementById('images').files[index];
            }

            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const fileSizeKB = Math.round(file.size / 1024);
                const isCompressed = type === 'main' 
                    ? (compressedMainFile && file.name === compressedMainFile.name)
                    : (compressedAdditionalFiles[index] && file.name === compressedAdditionalFiles[index].name);
                
                container.innerHTML = `
                    <div class="border rounded-lg p-4 relative">
                        <button type="button" onclick="confirmRemoveImage('${type}', ${index !== null ? index : ''})" 
                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-medium">${type === 'main' ? 'Main Image' : 'Additional Image ' + (index + 1)}</h4>
                                <div class="text-sm text-gray-600">${file.name}</div>
                            </div>
                            <div class="text-sm text-gray-600 text-right">
                                <div>${fileSizeKB} KB</div>
                                ${isCompressed ? '<div class="text-xs text-green-600">(Compressed)</div>' : ''}
                                ${file.size > MAX_IMAGE_SIZE_BYTES && !isCompressed ? 
                                    `<div class="text-xs text-yellow-600">Will be compressed</div>` : ''}
                            </div>
                        </div>
                        <div class="flex justify-center bg-gray-100 p-2 rounded">
                            <img src="${e.target.result}" class="max-h-[60vh] max-w-full object-contain" alt="Preview">
                        </div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);

            modal.classList.remove('hidden');
        }

        // Confirm image removal with alert
        function confirmRemoveImage(type, index) {
            Swal.fire({
                title: 'Remove Image?',
                text: 'Are you sure you want to remove this image?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it',
                cancelButtonText: 'No, keep it',
                customClass: {
                    confirmButton: 'px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700',
                    cancelButton: 'px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 mr-3'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    removeImage(type, index);
                }
            });
        }

        // Remove image from selection
        function removeImage(type, index) {
            if (type === 'main') {
                // Reset main image
                document.getElementById('main_image').value = '';
                document.getElementById('mainImagePreview').classList.add('hidden');
                compressedMainFile = null;
            } else {
                // Remove specific additional image
                const input = document.getElementById('images');
                const files = Array.from(input.files);
                files.splice(index, 1);
                
                // Update the file input
                const dataTransfer = new DataTransfer();
                files.forEach(file => dataTransfer.items.add(file));
                input.files = dataTransfer.files;
                
                // Update compressed files array
                compressedAdditionalFiles.splice(index, 1);
                
                // Update preview
                const previewContainer = document.getElementById('additionalImagesPreview');
                previewContainer.innerHTML = '';
                files.forEach((file, idx) => {
                    showImagePreviewThumbnail(file, 'additional', idx);
                });
                
                if (files.length === 0) {
                    previewContainer.classList.add('hidden');
                }
            }
            
            // Refresh the preview modal if it's open
            if (!document.getElementById('imagePreviewModal').classList.contains('hidden')) {
                showAllImagesPreview();
            }
            
            updatePreviewButton();
            
            // Show success message
            Swal.fire({
                title: 'Image Removed',
                text: 'The image has been removed from your selection.',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700'
                },
                buttonsStyling: false
            });
        }

        // Show all images preview before submission
        function showAllImagesPreview() {
            const modal = document.getElementById('imagePreviewModal');
            const container = document.getElementById('previewContainer');
            container.innerHTML = '';

            const allFiles = [];
            if (document.getElementById('main_image').files.length > 0) {
                allFiles.push({
                    file: document.getElementById('main_image').files[0],
                    type: 'Main Image',
                    compressed: compressedMainFile,
                    index: null
                });
            }

            const additionalFiles = Array.from(document.getElementById('images').files);
            additionalFiles.forEach((file, index) => {
                allFiles.push({
                    file: file,
                    type: `Additional Image ${index + 1}`,
                    compressed: compressedAdditionalFiles[index],
                    index: index
                });
            });

            if (allFiles.length === 0) {
                container.innerHTML = '<p class="text-gray-500">No images to preview</p>';
                modal.classList.remove('hidden');
                return;
            }

            // Process all files to show previews
            const previewPromises = allFiles.map(item => {
                return new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const fileSizeKB = Math.round(item.file.size / 1024);
                        const compressedSizeKB = item.compressed ? Math.round(item.compressed.size / 1024) : fileSizeKB;
                        const isCompressed = item.compressed && item.file.name === item.compressed.name;
                        const willCompress = item.file.size > MAX_IMAGE_SIZE_BYTES && !isCompressed;

                        const previewItem = document.createElement('div');
                        previewItem.className = 'border rounded-lg p-4 mb-4 relative';
                        previewItem.innerHTML = `
                            <button type="button" onclick="confirmRemoveImage('${item.index === null ? 'main' : 'additional'}', ${item.index !== null ? item.index : ''})" 
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-medium">${item.type}</h4>
                                    <div class="text-sm text-gray-600">${item.file.name}</div>
                                </div>
                                <div class="text-sm text-gray-600 text-right">
                                    <div>Original: ${fileSizeKB} KB</div>
                                    ${isCompressed ? `<div>Compressed: ${compressedSizeKB} KB</div>` : ''}
                                    ${isCompressed ? `<div class="text-xs text-green-600">Compressed</div>` : ''}
                                    ${willCompress ? `<div class="text-xs text-yellow-600">Will be compressed</div>` : ''}
                                </div>
                            </div>
                            <div class="flex justify-center bg-gray-100 p-2 rounded">
                                <img src="${e.target.result}" class="max-h-60 max-w-full object-contain" alt="Preview">
                            </div>
                        `;
                        container.appendChild(previewItem);
                        resolve();
                    };
                    reader.readAsDataURL(item.file);
                });
            });

            Promise.all(previewPromises).then(() => {
                modal.classList.remove('hidden');
            });
        }

        // Close preview modal
        function closePreviewModal() {
            document.getElementById('imagePreviewModal').classList.add('hidden');
        }

        // Update preview button visibility
        function updatePreviewButton() {
            const previewBtn = document.getElementById('previewBtn');
            const hasMainImage = document.getElementById('main_image').files.length > 0;
            const hasAdditionalImages = document.getElementById('images').files.length > 0;
            
            if (hasMainImage || hasAdditionalImages) {
                previewBtn.classList.remove('hidden');
            } else {
                previewBtn.classList.add('hidden');
            }
        }

        // Prepare form data and submit
        function prepareAndSubmitForm() {
            // Update main image if compressed
            if (compressedMainFile) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(compressedMainFile);
                document.getElementById('main_image').files = dataTransfer.files;
            }

            // Update additional images if compressed
            if (compressedAdditionalFiles.length > 0) {
                const dataTransfer = new DataTransfer();
                compressedAdditionalFiles.forEach(file => {
                    if (file) dataTransfer.items.add(file);
                });
                document.getElementById('images').files = dataTransfer.files;
            }

            // Close the modal
            closePreviewModal();

            // Submit the form
            document.getElementById('roomForm').submit();
        }

        // Square meters to square feet conversion
        function convertM2ToSqft() {
            const roomSizeInput = document.getElementById('room_size_sqft');
            const m2Value = parseFloat(roomSizeInput.value);
            
            if (!isNaN(m2Value)) {
                const sqftValue = m2Value * 10.7639;
                roomSizeInput.value = sqftValue.toFixed(2);
            }
        }
    </script>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #imagePreviewModal {
            transition: opacity 0.3s ease;
        }
        #previewContainer img {
            max-height: 300px;
            object-fit: contain;
        }
        #imagePreviewModal .bg-red-500 {
            transition: background-color 0.2s;
        }
        #imagePreviewModal .bg-red-500:hover {
            background-color: #dc2626;
        }
        #additionalImagesPreview img {
            transition: transform 0.2s;
        }
        #additionalImagesPreview img:hover {
            transform: scale(1.05);
        }
    </style>
</x-app-layout>