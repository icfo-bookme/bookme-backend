<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-blue-900 px-6 py-4 flex justify-between">
                    <button type="button" id="enable-edit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Edit Hotel
                    </button>
                    <a href="{{ url('/hotel/' . $destination_id) }}" class="inline-flex items-center px-3 py-1 bg-green-900 text-white rounded hover:bg-yellow-600 text-sm">
                        Back To Hotel List
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
                
                <!-- Main Hotel Edit Form -->
                <form action="{{ route('hotels.update', $hotel->id) }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-200" id="hotelForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Hotel Information Section -->
                    <div class="px-6 py-4">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Hotel Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Hotel Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Hotel Name <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', $hotel->name) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->name }}">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Hotel Categories -->
                            <div>
                                <label for="category_ids" class="block text-sm font-medium text-gray-700 mb-1">Hotel Categories <span class="text-red-500">*</span></label>
                                <div class="flex items-center">
                                    <input type="text" id="selected-categories" readonly 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        value="{{ $hotel->categories->pluck('name')->implode(', ') }}"
                                        data-original-value="{{ $hotel->categories->pluck('id')->toJson() }}">
                                    <button type="button" onclick="document.getElementById('category-modal').classList.remove('hidden')"
                                        class="ml-2 px-4 py-2 bg-blue-600 text-white rounded">Select</button>
                                </div>
                                <input type="hidden" id="category_ids" name="category_ids" value="{{ json_encode($hotel->categories->pluck('id')->toArray()) }}"
                                       data-original-value="{{ json_encode($hotel->categories->pluck('id')->toArray()) }}">
                                @error('category_ids')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="description" name="description" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->description }}">{{ old('description', $hotel->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Phone Number -->
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $hotel->phone_number) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('phone_number') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->phone_number }}">
                                @error('phone_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Number of Floors -->
                            <div>
                                <label for="Number_of_Floors" class="block text-sm font-medium text-gray-700 mb-1">Number of Floors</label>
                                <input type="number" id="Number_of_Floors" name="Number_of_Floors" value="{{ old('Number_of_Floors', $hotel->Number_of_Floors) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('Number_of_Floors') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->Number_of_Floors }}">
                                @error('Number_of_Floors')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Year of Construction -->
                            <div>
                                <label for="Year_of_construction" class="block text-sm font-medium text-gray-700 mb-1">Year of Construction</label>
                                <input type="number" id="Year_of_construction" name="Year_of_construction" value="{{ old('Year_of_construction', $hotel->Year_of_construction) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('Year_of_construction') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->Year_of_construction }}">
                                @error('Year_of_construction')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Near By -->
                            <div>
                                <label for="near_by" class="block text-sm font-medium text-gray-700 mb-1">Near By (Pipe (|) separated)</label>
                                <input type="text" id="near_by" name="near_by" value="{{ old('near_by', $hotel->near_by) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('near_by') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->near_by }}">
                                @error('near_by')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Website URL -->
                            <div>
                                <label for="website_url" class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                                <input type="url" id="website_url" name="website_url" value="{{ old('website_url', $hotel->website_url) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('website_url') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->website_url }}">
                                @error('website_url')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Star Rating Section -->
                    <div class="px-6 py-4">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Star Rating</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Star Rating -->
                            <div>
                                <label for="star_rating" class="block text-sm font-medium text-gray-700 mb-1">Star Rating</label>
                                <select id="star_rating" name="star_rating"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('star_rating') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->star_rating }}">
                                    <option value="">Select Rating</option>
                                    <option value="1" {{ old('star_rating', $hotel->star_rating) == 1 ? 'selected' : '' }}>1 Star</option>
                                    <option value="2" {{ old('star_rating', $hotel->star_rating) == 2 ? 'selected' : '' }}>2 Stars</option>
                                    <option value="3" {{ old('star_rating', $hotel->star_rating) == 3 ? 'selected' : '' }}>3 Stars</option>
                                    <option value="4" {{ old('star_rating', $hotel->star_rating) == 4 ? 'selected' : '' }}>4 Stars</option>
                                    <option value="5" {{ old('star_rating', $hotel->star_rating) == 5 ? 'selected' : '' }}>5 Stars</option>
                                </select>
                                @error('star_rating')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $hotel->email) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->email }}">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Location Section -->
                    <div class="px-6 py-4">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Location</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Country -->
                            <div>
                                <label for="country_id" class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                                <select id="country_id" name="country_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('country_id') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->country_id }}">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id', $hotel->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- City -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                <input type="text" id="city" name="city" value="{{ old('city', $hotel->city) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('city') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->city }}">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Street Address -->
                            <div class="md:col-span-2">
                                <label for="street_address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                <input type="text" id="street_address" name="street_address" value="{{ old('street_address', $hotel->street_address) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('street_address') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->street_address }}">
                                @error('street_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Languages Spoken -->
                            <div>
                                <label for="languages_spoken" class="block text-sm font-medium text-gray-700 mb-1">Languages Spoken</label>
                                <input type="text" id="languages_spoken" name="languages_spoken" value="{{ old('languages_spoken', $hotel->languages_spoken) }}" placeholder="English, French, Spanish"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('languages_spoken') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->languages_spoken }}">
                                @error('languages_spoken')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Location on Map -->
                            <div>
                                <label for="location_on_map" class="block text-sm font-medium text-gray-700 mb-1">Location on Map</label>
                                <input type="text" id="location_on_map" name="location_on_map" value="{{ old('location_on_map', $hotel->location_on_map) }}" placeholder="https://maps.google.com/..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('location_on_map') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->location_on_map }}">
                                @error('location_on_map')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Extra Discount Message -->
                            <div>
                                <label for="extra_discount_msg" class="block text-sm font-medium text-gray-700 mb-1">Extra Discount Message</label>
                                <input type="text" id="extra_discount_msg" name="extra_discount_msg" value="{{ old('extra_discount_msg', $hotel->extra_discount_msg) }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('extra_discount_msg') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->extra_discount_msg }}">
                                @error('extra_discount_msg')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rooms Section -->
                    <div class="px-6 py-4">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Rooms</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Number of Rooms -->
                            <div>
                                <label for="number_of_rooms" class="block text-sm font-medium text-gray-700 mb-1">Number of Rooms</label>
                                <input type="number" id="number_of_rooms" name="number_of_rooms" value="{{ old('number_of_rooms', $hotel->number_of_rooms) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('number_of_rooms') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->number_of_rooms }}">
                                @error('number_of_rooms')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Room Type -->
                            <div>
                                <label for="room_type" class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
                                <input type="text" id="room_type" name="room_type" value="{{ old('room_type', $hotel->room_type) }}" placeholder="Single, Double, Suite, etc."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('room_type') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->room_type }}">
                                @error('room_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Main Image Display -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Main Image</label>
                                @if($hotel->main_photo)
                                    <img src="{{ asset('storage/' . $hotel->main_photo) }}" 
                                         alt="Hotel Photo" 
                                         class="w-full h-32 object-cover rounded"
                                         onerror="this.onerror=null;this.src='https://via.placeholder.com/150?text=Image+Not+Found'">
                                @else
                                    <div class="w-full h-32 bg-gray-200 rounded flex items-center justify-center text-gray-500">
                                        No Image Available
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Update Main Photo -->
                            <div>
                                <label for="main_photo" class="block text-sm font-medium text-gray-700 mb-1">Update Main Photo</label>
                                <input type="file" id="main_photo" name="main_photo" accept="image/*"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('main_photo') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Max size: 4MB (JPEG, PNG, JPG, GIF)</p>
                                @error('main_photo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <div id="mainImagePreview" class="mt-2 hidden">
                                    <img id="mainImagePreviewImg" class="h-32 object-cover rounded border" alt="Main image preview">
                                    <button type="button" onclick="showImagePreview('main')" class="mt-2 text-sm text-blue-600 hover:text-blue-800">Preview & Adjust</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="px-6 py-4">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Vat & Tax, Service Charge </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- vat -->
                            <div>
                                <label for="vat" class="block text-sm font-medium text-gray-700 mb-1">Govt. Vat & Tax</label>
                                <input type="number" id="vat" name="vat" value="{{ old('vat', $hotel->vat) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('vat') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->vat }}">
                                @error('vat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- service_charge -->
                            <div>
                                <label for="service_charge" class="block text-sm font-medium text-gray-700 mb-1">service_charge</label>
                                <input type="text" id="service_charge" name="service_charge" value="{{ old('service_charge', $hotel->service_charge) }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('service_charge') border-red-500 @enderror"
                                    data-original-value="{{ $hotel->service_charge }}">
                                @error('service_charge')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                           
                        </div>
                    </div>
                    
                    <!-- Photos Section -->
                    <div class="px-6 py-4">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Photos For Slider</h2>

                        @if($hotel->photos->count() > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Photos</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    @foreach($hotel->photos as $photo)
                                    <div class="relative group">
                                        <!-- Image -->
                                        <img src="{{ asset('storage/' . $photo->photo) }}" 
                                             alt="Hotel Photo" 
                                             class="w-full h-32 object-cover rounded"
                                             onerror="this.onerror=null;this.src='https://via.placeholder.com/150?text=Image+Not+Found'">

                                        <!-- Hover Delete Button -->
                                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button type="button" class="text-white hover:text-red-400 delete-photo" 
                                                    data-photo-id="{{ $photo->id }}"
                                                    data-hotel-id="{{ $hotel->id }}">
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Additional Photos -->
                            <div>
                                <label for="photos" class="block text-sm font-medium text-gray-700 mb-1">Add More Photos</label>
                                <input type="file" id="photos" name="photos[]" multiple accept="image/*"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('photos.*') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500">You can select multiple files (Max size: 4MB each)</p>
                                @error('photos.*')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <div id="additionalImagesPreview" class="mt-2 hidden grid grid-cols-3 gap-2"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="px-6 py-4 bg-gray-50 flex justify-between">
                        <div></div>
                        <div class="flex space-x-2">
                            <button type="button" id="previewBtn" class="hidden inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 mr-3">
                                Preview Images
                            </button>
                            <button type="button" id="cancel-button" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hidden">
                                Cancel
                            </button>
                            <button type="submit" id="submit-button" disabled class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 opacity-50 cursor-not-allowed">
                                Update Hotel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Category Selection Modal -->
    <div id="category-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded shadow-md w-96">
            <h2 class="text-lg font-semibold mb-4">Select Hotel Categories</h2>
            
            <div class="max-h-96 overflow-y-auto mb-4">
                @php
                    $selectedCategoryIds = old('category_ids') ? json_decode(old('category_ids'), true) : $hotel->categories->pluck('id')->toArray();
                @endphp
                
                @foreach($categories as $category)
                    <div class="mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="category" value="{{ $category->id }}" 
                                   class="mr-2 category-checkbox" 
                                   @if(in_array($category->id, $selectedCategoryIds)) checked @endif>
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="updateSelectedCategories()"
                    class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                <button type="button" onclick="document.getElementById('category-modal').classList.add('hidden')"
                    class="ml-2 px-4 py-2 bg-gray-400 text-white rounded">Cancel</button>
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

        function updateSelectedCategories() {
            const checkboxes = document.querySelectorAll('.category-checkbox:checked');
            const selectedIds = Array.from(checkboxes).map(checkbox => checkbox.value);
            const selectedNames = Array.from(checkboxes).map(checkbox => {
                return checkbox.parentElement.textContent.trim();
            });
            
            // Update the hidden input with JSON array
            document.getElementById('category_ids').value = JSON.stringify(selectedIds);
            
            // Update the visible input with comma-separated names
            document.getElementById('selected-categories').value = selectedNames.join(', ');
            
            // Close the modal
            document.getElementById('category-modal').classList.add('hidden');
        }

        function resetFormToOriginalValues() {
            // Reset all form inputs to their original values
            const formInputs = document.querySelectorAll('input, textarea, select');
            formInputs.forEach(input => {
                if (input.hasAttribute('data-original-value')) {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = input.getAttribute('data-original-value') === 'true';
                    } else if (input.tagName === 'SELECT') {
                        input.value = input.getAttribute('data-original-value');
                    } else {
                        input.value = input.getAttribute('data-original-value');
                    }
                }
            });
            
            // Reset categories
            const originalCategories = JSON.parse(document.getElementById('category_ids').getAttribute('data-original-value'));
            document.getElementById('category_ids').value = JSON.stringify(originalCategories);
            
            // Update the visible categories display
            const categoryNames = Array.from(document.querySelectorAll('.category-checkbox'))
                .filter(checkbox => originalCategories.includes(checkbox.value))
                .map(checkbox => checkbox.parentElement.textContent.trim());
            
            document.getElementById('selected-categories').value = categoryNames.join(', ');
            
            // Uncheck all checkboxes in modal and re-check the original ones
            document.querySelectorAll('.category-checkbox').forEach(checkbox => {
                checkbox.checked = originalCategories.includes(checkbox.value);
            });
            
            // Clear file inputs (can't set value directly due to security restrictions)
            document.getElementById('main_photo').value = '';
            document.getElementById('photos').value = '';
            
            // Clear any validation errors
            const errorElements = document.querySelectorAll('.border-red-500, .text-red-600');
            errorElements.forEach(element => {
                element.classList.remove('border-red-500', 'text-red-600');
            });
            
            const errorMessages = document.querySelectorAll('.text-red-600');
            errorMessages.forEach(msg => {
                msg.textContent = '';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Store original values for all inputs
            const formInputs = document.querySelectorAll('input, textarea, select');
            formInputs.forEach(input => {
                if (input.type !== 'file') { // Skip file inputs
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.setAttribute('data-original-value', input.checked);
                    } else if (input.tagName === 'SELECT') {
                        input.setAttribute('data-original-value', input.value);
                    } else {
                        input.setAttribute('data-original-value', input.value);
                    }
                }
            });
            
            // Disable all form inputs initially
            formInputs.forEach(input => {
                input.disabled = true;
            });
            
            // Enable edit mode
            const enableEditBtn = document.getElementById('enable-edit');
            const submitBtn = document.getElementById('submit-button');
            const cancelBtn = document.getElementById('cancel-button');
            
            enableEditBtn.addEventListener('click', function() {
                formInputs.forEach(input => {
                    input.disabled = false;
                });
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                cancelBtn.classList.remove('hidden');
                enableEditBtn.disabled = true;
                enableEditBtn.classList.add('opacity-50', 'cursor-not-allowed');
            });
            
            // Cancel button handler
            cancelBtn.addEventListener('click', function() {
                resetFormToOriginalValues();
                formInputs.forEach(input => {
                    input.disabled = true;
                });
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                cancelBtn.classList.add('hidden');
                enableEditBtn.disabled = false;
                enableEditBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
            
            // Main photo change handler
            document.getElementById('main_photo').addEventListener('change', function(e) {
                handleImageSelection(e.target.files[0], 'main');
            });

            // Additional photos change handler
            document.getElementById('photos').addEventListener('change', function(e) {
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
            document.getElementById('hotelForm').addEventListener('submit', function(e) {
                const mainImage = document.getElementById('main_photo').files[0];
                const additionalImages = document.getElementById('photos').files;
                
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
                    const photoId = this.getAttribute('data-photo-id');
                    const hotelId = this.getAttribute('data-hotel-id');
                    
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
                            fetch(`/admin/api/hotelsphotos/${photoId}`, {
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
                                    // Remove the photo element from DOM
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
                    document.getElementById('main_photo').value = '';
                    document.getElementById('mainImagePreview').classList.add('hidden');
                } else {
                    document.getElementById('photos').value = '';
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
                        document.getElementById('main_photo').value = '';
                        document.getElementById('mainImagePreview').classList.add('hidden');
                    } else {
                        document.getElementById('photos').value = '';
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
                files = [document.getElementById('main_photo').files[0]];
            } else {
                files = Array.from(document.getElementById('photos').files);
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
                file = document.getElementById('main_photo').files[0];
            } else {
                file = document.getElementById('photos').files[index];
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
                document.getElementById('main_photo').value = '';
                document.getElementById('mainImagePreview').classList.add('hidden');
                compressedMainFile = null;
            } else {
                // Remove specific additional image
                const input = document.getElementById('photos');
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
            if (document.getElementById('main_photo').files.length > 0) {
                allFiles.push({
                    file: document.getElementById('main_photo').files[0],
                    type: 'Main Image',
                    compressed: compressedMainFile,
                    index: null
                });
            }

            const additionalFiles = Array.from(document.getElementById('photos').files);
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
            const hasMainImage = document.getElementById('main_photo').files.length > 0;
            const hasAdditionalImages = document.getElementById('photos').files.length > 0;
            
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
                document.getElementById('main_photo').files = dataTransfer.files;
            }

            // Update additional images if compressed
            if (compressedAdditionalFiles.length > 0) {
                const dataTransfer = new DataTransfer();
                compressedAdditionalFiles.forEach(file => {
                    if (file) dataTransfer.items.add(file);
                });
                document.getElementById('photos').files = dataTransfer.files;
            }

            // Close the modal
            closePreviewModal();

            // Submit the form
            document.getElementById('hotelForm').submit();
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