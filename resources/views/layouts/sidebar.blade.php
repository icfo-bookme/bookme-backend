<div id="sidebar" class="flex flex-shrink-0 h-screen sticky top-0 bg-white border-r border-gray-200 shadow-lg z-50">
    <!-- Sidebar Container -->
    <div class="flex flex-col h-full transition-all duration-300 ease-in-out" id="sidebar-container">
        <!-- Sidebar Header -->
        <div id="divHide" class="flex items-center w-60 justify-between h-16 px-4 bg-blue-900 shadow-md">
            <span id="sidebar-logo-text" class="text-white text-xl font-semibold whitespace-nowrap transition-all duration-300 sidebar-text truncate">Admin Panel</span>
            <button id="sidebar-toggle" class="p-2 rounded-md text-white hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-300" title="Collapse sidebar">
                <svg class="w-5 h-5" id="toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <div class="flex flex-col flex-grow px-2 py-4 overflow-y-auto scrollbar-hide" id="nav-container">
            <nav class="flex-1 space-y-1">
                <!-- Dashboard -->
                <div class="px-2">
                    <a href="/dashboard" class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition">
                        <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6zM16 16a2 2 0 012-2h2a2 2 0 012 2v6a2 2 0 01-2 2h-2a2 2 0 01-2-2v-6z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate">Dashboard</span>
                    </a>
                </div>

                <!-- Property Management Section -->
                <div class="px-2 pt-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 ml-3 whitespace-nowrap sidebar-text truncate">Property Management</h3>
                    
                    <!-- Property Management -->
                    <div id="property-dropdown" class="mb-1 relative">
                        <button class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition focus:outline-none">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate text-left">Properties</span>
                            </div>
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 text-gray-500" id="property-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="property-dropdown-list" class="mt-1 space-y-1 pl-8 hidden">
                            <a href="/service_categories"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">All Properties</span>
                            </a>
                            <a href="/property-summary-types"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">summary-types</span>
                            </a>
                              <a href="/icons"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Icons</span>
                            </a>
                        </div>
                        
                    </div>
                </div>

                <!-- Service Management Section -->
                <div class="px-2 pt-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 ml-3 whitespace-nowrap sidebar-text truncate">Services Management</h3>
                    
                    <!-- Hotel Management -->
                    <div id="hotel-dropdown" class="mb-1 relative">
                        <button class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition focus:outline-none">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate text-left">Hotels</span>
                            </div>
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 text-gray-500" id="hotel-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="hotel-dropdown-list" class="mt-1 space-y-1 pl-8 hidden">
                            <a href="/booking/orders"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Manage Order</span>
                            </a>
                            <a href="/get/all/hotels"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">All Hotels</span>
                            </a>
                            <a href="/hoteln/countries"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Countries</span>
                            </a>
                            <a href="/hotel-categories"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Hotel Categories</span>
                            </a>
                          
                            <a href="/feature-categories"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Facilities Categories</span>
                            </a>
                            <a href="/features"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Facilities</span>
                            </a>
                              <a href="/facilities-icons"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">icons</span>
                            </a>
                        </div>
                    </div>
                    
                      <!-- Car Management -->
                    <div id="car-dropdown" class="mb-1 relative">
                        <button class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition focus:outline-none">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate text-left">Cars</span>
                            </div>
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 text-gray-500" id="hotel-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="car-dropdown-list" class="mt-1 space-y-1 pl-8 hidden">
                            <a href="/car-brands"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Cars Brands</span>
                            </a>
                          
                        </div>
                    </div>
                    
                    <!-- Room Management -->
                   <div id="room-dropdown" class="mb-1 relative">
    <button id="room-dropdown-button" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition focus:outline-none">
        <div class="flex items-center">
            <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate text-left">Rooms</span>
        </div>
        <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 text-gray-500" id="room-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <div id="room-dropdown-list" class="mt-1 space-y-1 pl-8 hidden">
        <a href="/room-types"
            class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition hover:text-blue-600">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
            <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Room Types</span>
        </a>
        <a href="/room/features-category"
            class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition hover:text-blue-600">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
            <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Room Facilities Category</span>
        </a>
        <a href="/rooms/features"
            class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition hover:text-blue-600">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
            <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Room Facilities</span>
        </a>
        <a href="/facility/icons"
            class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition hover:text-blue-600">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
            <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Facilities Icon</span>
        </a>
    </div>
</div>
 <!-- flight Management -->
                   <div id="flight-dropdown" class="mb-1 relative">
    <button id="flight-dropdown-button" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition focus:outline-none">
        <div class="flex items-center">
            <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate text-left">Flight</span>
        </div>
        <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 text-gray-500" id="flight-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <div id="flight-dropdown-list" class="mt-1 space-y-1 pl-8 hidden">
        <a href="/flight-routes"
            class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition hover:text-blue-600">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
            <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Flight Routes</span>
        </a>
        
    </div>
</div>


                
                </div>

                <!-- Houseboat Management Section -->
                <div class="px-2 pt-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 ml-3 whitespace-nowrap sidebar-text truncate">Houseboat Management</h3>
                    
                    <!-- Houseboat Management -->
                    <div id="houseboat-dropdown" class="mb-1 relative">
                        <button class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition focus:outline-none">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate text-left">Houseboats</span>
                            </div>
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 text-gray-500" id="houseboat-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="houseboat-dropdown-list" class="mt-1 space-y-1 pl-8 hidden">
                            <a href="/houseboat"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">All Houseboats</span>
                            </a>
                            
                        </div>
                    </div>
                </div>

                <!-- Content Management Section -->
                <div class="px-2 pt-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 ml-3 whitespace-nowrap sidebar-text truncate">Content Management</h3>
                  
                    <div id="content-dropdown" class="mb-1 relative">
                        <button class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition focus:outline-none">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                                </svg>
                                <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate text-left">Homepage</span>
                            </div>
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 text-gray-500" id="content-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="content-dropdown-list" class="mt-1 space-y-1 pl-8 hidden">
                            <a href="/hot-package"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Featured Packages</span>
                            </a>
                            <a href="/homepage-section-settings"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Display Settings</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Blog Management -->
                    <div id="blog-dropdown" class="mb-1 relative">
                        <button class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition focus:outline-none">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                                <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate text-left">Blog</span>
                            </div>
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 text-gray-500" id="blog-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="blog-dropdown-list" class="mt-1 space-y-1 pl-8 hidden">
                            <a href="/blog-posts"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">All Posts</span>
                            </a>
                            <a href="/blog-categories"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Categories</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Consultation Requests Section -->
                <div class="px-2 pt-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 ml-3 whitespace-nowrap sidebar-text truncate">Consultations</h3>
                    
                    <!-- Consultations -->
                    <div id="consultation-dropdown" class="mb-1 relative">
                        <button class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition focus:outline-none">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                                <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate text-left">Bookme</span>
                            </div>
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 text-gray-500" id="consultation-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="consultation-dropdown-list" class="mt-1 space-y-1 pl-8 hidden">
                            <a href="/visa-consultation-requests" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Visa Requests</span>
                            </a>
                            <a href="/tour-consultation-requests" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Ships Requests</span>
                            </a>

                        </div>
                    </div>
                    
                                        <div id="consultation-ship-dropdown" class="mb-1 relative">
                        <button class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition focus:outline-none">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                                <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate text-left">Separate Ships</span>
                            </div>
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 text-gray-500" id="consultation-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="consultation-ship-dropdown-list" class="mt-1 space-y-1 pl-8 hidden">
                            <a href="/consultation-requests/264" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">MV The Crown</span>
                            </a>
                            <a href="/consultation-requests/263" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">MV The Wave</span>
                            </a>
                            <a href="/consultation-requests/261" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">MV The Glory</span>
                            </a>
                                <a href="/consultation-requests/489" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Aral Sea cruise</span>
                            </a>
                            <a href="/consultation-requests/493" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">Symphony of the wave</span>
                            </a>
                            <a href="/consultation-requests/260" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">MV The Explorer</span>
                            </a>
                            <a href="/consultation-requests/487" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-blue-50 group transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                                <span class="whitespace-nowrap transition-all duration-300 sidebar-text truncate">MV The Rezab</span>
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Settings Section -->
                <div class="px-2 pt-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 ml-3 whitespace-nowrap sidebar-text truncate">Settings</h3>
                    
                    <a href="/contact-attributes" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition mb-1">
                        <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate">Contact Settings</span>
                    </a>
                     <a href="/item-labels" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition mb-1">
                        <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate">Badge/item_labels</span>
                    </a>
                    
                    <a href="/footer-policies" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition mb-1">
                        <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate">Policies</span>
                    </a>
                    
                    <a href="/seo" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition mb-1">
                        <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate">SEO Settings</span>
                    </a>
                    
                    <a href="/users" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition mb-1">
                        <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate">User Management</span>
                    </a>
                    
                    <a href="/user-permissions" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition mb-1">
                        <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate">User Permissions</span>
                    </a>
                     <a href="/expenses" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition mb-1">
                        <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate">Expense Management</span>
                    </a>
                    <a href="/customers" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 group transition mb-1">
                        <svg class="w-5 h-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-all duration-300 sidebar-text truncate">Customers Management</span>
                    </a>

                </div>
            </nav>
        </div>

        <!-- Sidebar Footer (User Profile) -->
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center min-w-0">
                    <div class="relative">
                        <img class="w-10 h-10 rounded-full border-2 border-white" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="User profile">
                        <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-green-400"></span>
                    </div>
                    <div class="ml-3 overflow-hidden sidebar-text">
                        <p class="text-sm font-medium text-gray-900 truncate">Admin User</p>
                        <p class="text-xs font-medium text-gray-500 truncate">admin@example.com</p>
                    </div>
                </div>
                <a href="/bookme/logout" class="text-gray-500 hover:text-gray-700 p-1 rounded-md hover:bg-gray-100 transition" title="Logout">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Completely hide scrollbar but keep functionality */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;  /* Chrome, Safari and Opera */
    }
    
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
    
    /* Rotate dropdown icons when open */
    .rotate-180 {
        transform: rotate(180deg);
    }
    
    /* Hover effects */
    .hover\:bg-blue-50:hover {
        background-color: #f0f9ff;
    }
    
    /* Active menu item styling */
    .bg-blue-50 {
        background-color: #f0f9ff;
    }
    .text-blue-700 {
        color: #1d4ed8;
    }
    
    /* Fix for text cutting */
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
        max-width: 100%;
    }
    
    /* Z-index fixes */
    #sidebar {
        z-index: 100;
    }
    
    /* Expanded menu styles for collapsed sidebar */
    .expanded-menu {
        position: absolute;
        left: 100%;
        top: 0;
        width: 220px;
        background-color: white;
        border-radius: 0 8px 8px 0;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1);
        z-index: 120;
        padding: 8px 0;
    }
    
    .expanded-menu .sidebar-text {
        display: inline !important;
    }
    
    .expanded-menu-item {
        padding: 8px 16px;
        white-space: nowrap;
        display: flex;
        align-items: center;
    }
    
    .expanded-menu-item:hover {
        background-color: #f0f9ff;
    }
    
    .expanded-menu-divider {
        border-top: 1px solid #e5e7eb;
        margin: 4px 0;
    }
    
    /* Collapsed sidebar styles */
    .sidebar-collapsed .sidebar-text {
        display: none !important;
    }
    
    .sidebar-collapsed #nav-container a,
    .sidebar-collapsed #nav-container button {
        justify-content: center;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .sidebar-collapsed #nav-container button {
        justify-content: center !important;
    }
    
    /* Expanded sidebar styles */
    .sidebar-expanded .sidebar-text {
        display: inline !important;
    }
    
    .sidebar-expanded #nav-container a,
    .sidebar-expanded #nav-container button {
        justify-content: flex-start;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    
    .sidebar-expanded #nav-container button {
        justify-content: space-between !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarContainer = document.getElementById('sidebar-container');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const toggleIcon = document.getElementById('toggle-icon');
    const logoText = document.getElementById('sidebar-logo-text');
    const divHide = document.getElementById('divHide');
    const sidebarTexts = document.querySelectorAll('.sidebar-text:not(#sidebar-logo-text)');
    const dropdownContents = document.querySelectorAll('[id$="-dropdown-list"]');
    const dropdownIcons = document.querySelectorAll('[id$="-dropdown-icon"]');
    const navLinks = document.querySelectorAll('#nav-container a[href]');
    
    // Check localStorage for saved state
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    
    // Initialize sidebar state
    if (isCollapsed) {
        collapseSidebar();
    } else {
        expandSidebar();
    }
    
    // Toggle sidebar
    sidebarToggle.addEventListener('click', function() {
        const isCollapsed = sidebarContainer.classList.contains('sidebar-collapsed');
        
        if (isCollapsed) {
            expandSidebar();
            localStorage.setItem('sidebarCollapsed', 'false');
        } else {
            collapseSidebar();
            localStorage.setItem('sidebarCollapsed', 'true');
        }
    });
    
    function collapseSidebar() {
        sidebarContainer.classList.add('sidebar-collapsed');
        sidebarContainer.classList.remove('sidebar-expanded');
        sidebarContainer.classList.add('w-20');
        sidebarContainer.classList.remove('w-60');
        divHide.classList.remove('w-60');
        divHide.classList.add('w-20');
        
        // Change icon to double arrow right
        toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>';
        
        // Hide logo text
        logoText.classList.add('hidden');
        
        // Close all dropdowns
        dropdownContents.forEach(dropdown => dropdown.classList.add('hidden'));
        dropdownIcons.forEach(icon => icon.classList.remove('rotate-180'));
        
        // Remove any existing expanded menus
        document.querySelectorAll('.expanded-menu').forEach(menu => menu.remove());
    }
    
    function expandSidebar() {
        sidebarContainer.classList.remove('sidebar-collapsed');
        sidebarContainer.classList.add('sidebar-expanded');
        sidebarContainer.classList.remove('w-20');
        sidebarContainer.classList.add('w-60');
        divHide.classList.remove('w-20');
        divHide.classList.add('w-60');
        
        // Change icon to double arrow left
        toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>';
        
        // Show logo text
        logoText.classList.remove('hidden');
        
        // Remove any existing expanded menus
        document.querySelectorAll('.expanded-menu').forEach(menu => menu.remove());
    }
    
    // Dropdown toggle functionality - only for expanded sidebar
    document.querySelectorAll('[id$="-dropdown"] button').forEach(button => {
        button.addEventListener('click', function(e) {
            // Only toggle if sidebar is expanded
            if (sidebarContainer.classList.contains('sidebar-expanded')) {
                e.stopPropagation();
                const dropdownId = this.parentElement.id;
                const contentId = `${dropdownId}-list`;
                const iconId = `${dropdownId}-icon`;
                
                const content = document.getElementById(contentId);
                const icon = document.getElementById(iconId);
                
                // Toggle current dropdown
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
                
                // Close all other dropdowns
                document.querySelectorAll('[id$="-dropdown-list"]').forEach(otherContent => {
                    if (otherContent.id !== contentId) {
                        otherContent.classList.add('hidden');
                        const otherIconId = otherContent.id.replace('-list', '-icon');
                        const otherIcon = document.getElementById(otherIconId);
                        if (otherIcon) otherIcon.classList.remove('rotate-180');
                    }
                });
            }
        });
    });
    
    // Close dropdowns when clicking outside - only for expanded sidebar
    document.addEventListener('click', function(e) {
        if (sidebarContainer.classList.contains('sidebar-expanded') && 
            !e.target.closest('[id$="-dropdown"]') &&
            !e.target.closest('[id$="-dropdown-list"]')) {
            dropdownContents.forEach(content => content.classList.add('hidden'));
            dropdownIcons.forEach(icon => icon.classList.remove('rotate-180'));
        }
    });
    
    // Handle hover effects for collapsed sidebar
    document.querySelectorAll('[id$="-dropdown"], #nav-container > nav > div > a').forEach(item => {
        item.addEventListener('mouseenter', function() {
            if (sidebarContainer.classList.contains('sidebar-collapsed')) {
                // Remove any existing expanded menus first
                document.querySelectorAll('.expanded-menu').forEach(menu => menu.remove());
                
                // Create expanded menu container
                const expandedMenu = document.createElement('div');
                expandedMenu.className = 'expanded-menu';
                
                // Get the main item
                const isDropdown = this.id.endsWith('-dropdown');
                const mainItem = isDropdown ? this.querySelector('button') : this;
                
                // Create main menu item
                const mainMenuItem = document.createElement('div');
                mainMenuItem.className = 'expanded-menu-item font-medium text-gray-700';
                
                const mainIcon = mainItem.querySelector('svg').cloneNode(true);
                mainIcon.className = 'w-5 h-5 flex-shrink-0 text-blue-600';
                
                mainMenuItem.appendChild(mainIcon);
                
                const mainTextSpan = document.createElement('span');
                mainTextSpan.className = 'ml-3';
                mainTextSpan.textContent = mainItem.querySelector('.sidebar-text')?.textContent || '';
                mainMenuItem.appendChild(mainTextSpan);
                
                expandedMenu.appendChild(mainMenuItem);
                
                // If this is a dropdown, add its items
                if (isDropdown) {
                    // Add divider
                    const divider = document.createElement('div');
                    divider.className = 'expanded-menu-divider';
                    expandedMenu.appendChild(divider);
                    
                    // Add dropdown items
                    const dropdownList = this.querySelector('[id$="-dropdown-list"]');
                    if (dropdownList) {
                        const dropdownItems = dropdownList.querySelectorAll('a');
                        dropdownItems.forEach(item => {
                            const clonedItem = item.cloneNode(true);
                            clonedItem.className = 'expanded-menu-item text-gray-600 hover:text-blue-600';
                            
                            // Remove any existing classes and add our own
                            const iconSpan = clonedItem.querySelector('span:first-child');
                            if (iconSpan) {
                                iconSpan.className = 'w-1.5 h-1.5 rounded-full bg-blue-500 mr-3';
                            }
                            
                            const textSpan = clonedItem.querySelector('span:last-child');
                            if (textSpan) {
                                textSpan.className = 'whitespace-nowrap';
                            }
                            
                            expandedMenu.appendChild(clonedItem);
                        });
                    }
                }
                
                // Position the expanded menu
                const rect = this.getBoundingClientRect();
                expandedMenu.style.top = `${rect.top}px`;
                expandedMenu.style.left = `${rect.right}px`;
                
                // Add to DOM
                document.body.appendChild(expandedMenu);
                
                // Close when mouse leaves
                expandedMenu.addEventListener('mouseleave', function() {
                    this.remove();
                });
                
                // Also close when leaving the original item
                this.addEventListener('mouseleave', function() {
                    setTimeout(() => {
                        if (!expandedMenu.matches(':hover')) {
                            expandedMenu.remove();
                        }
                    }, 100);
                });
            }
        });
    });
    
    // Highlight active menu item based on current URL
    function setActiveMenuItem() {
        const currentPath = window.location.pathname;
        
        navLinks.forEach(link => {
            const linkPath = link.getAttribute('href');
            if (currentPath === linkPath || (linkPath !== '/' && currentPath.startsWith(linkPath))) {
                link.classList.add('bg-blue-50', 'text-blue-700');
                const icon = link.querySelector('svg');
                if (icon) {
                    icon.classList.add('text-blue-700');
                    icon.classList.remove('text-blue-600');
                }
                
                // If this is a dropdown item, open its parent dropdown
                const dropdownItem = link.closest('[id$="-dropdown-list"]');
                if (dropdownItem) {
                    const dropdownId = dropdownItem.id.replace('-list', '');
                    const dropdownButton = document.querySelector(`#${dropdownId} button`);
                    if (dropdownButton) {
                        const dropdownIcon = document.getElementById(`${dropdownId}-icon`);
                        dropdownItem.classList.remove('hidden');
                        if (dropdownIcon) dropdownIcon.classList.add('rotate-180');
                    }
                }
            }
        });
    }
    
    setActiveMenuItem();
});
</script>