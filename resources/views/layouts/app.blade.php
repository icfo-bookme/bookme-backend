<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Bookme</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
<!-- {{-- Include Toastify --}} -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.0/css/buttons.dataTables.min.css">
    <!-- Include flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
    /* Style the dropdown directly */
    .dataTables_length select {
    border: 1px solid #d1d5db; /* Tailwind gray-300 */
    border-radius: 0.25rem;
    padding: 0.25rem 1rem;
    background-color: white;
    height: 2.4rem;
    margin-right: 1rem;
    
    /* Remove default dropdown arrows */
    appearance: none;
    -webkit-appearance: none; /* Safari */
    -moz-appearance: none; /* Firefox */
    
    /* Optional: add background icon if you want a custom arrow later */
    background-image: none;
}


    /* Style the label container */
    .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        
    }

    .dataTables_length label::before,
    .dataTables_length label::after {
        content: none !important;
    }

    /* Optional: Hide label text but keep dropdown */
    .dataTables_length label > span {
       
    }
</style>


<body class="font-sans antialiased">
    <div class="min-h-screen max-w-[1480px] mx-auto">
        <!-- Fixed Header -->
        <div class="fixed bg-[#006172] top-0 left-0 w-full z-50">
            @include('layouts.navigation')
        </div>
        
        <!-- Content Area -->
        <div class="pt-16 min-h-screen flex">
            <!-- Sidebar with transition and dynamic width -->
            <div id="sidebar" class="fixed h-[calc(100vh-4rem)] z-40 transition-all duration-300 ease-in-out w-60">
                @include('layouts.sidebar')
            </div>
            
            <!-- Main Content with dynamic margin -->
            <main id="main-content" class="ml-60 flex-1 transition-all duration-300 ease-in-out">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        
        // Check localStorage for saved state
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        
        if (isCollapsed) {
            collapseSidebar();
        }
        
        sidebarToggle.addEventListener('click', function() {
            const isCollapsed = sidebar.classList.contains('w-20');
            
            if (isCollapsed) {
                expandSidebar();
                localStorage.setItem('sidebarCollapsed', 'false');
            } else {
                collapseSidebar();
                localStorage.setItem('sidebarCollapsed', 'true');
            }
        });
        
        function collapseSidebar() {
            sidebar.classList.remove('w-60');
            sidebar.classList.add('w-20');
            mainContent.classList.remove('ml-60');
            mainContent.classList.add('ml-20');
        }
        
        function expandSidebar() {
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-60');
            mainContent.classList.remove('ml-20');
            mainContent.classList.add('ml-60');
        }
    });
    </script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    // DataTables Initialization
    $(document).ready(function() {
       $('#example').DataTable({
    dom: 'lBfrtip',
    lengthChange: true,
    lengthMenu: [ [10, 25, 50, 75, 100, 200, 300, 400, 500], [10, 25, 50, 75, 100, 200, 300, 400, 500] ],
    language: {
        lengthMenu: '_MENU_' // Only the dropdown will be shown
    },
    order: [[0, 'desc']],
    buttons: [
        'copy', 'excel', 'csv', 'pdf', 'print',
        {
            extend: 'colvis',
            text: 'Column Visibility'
        }
    ]
});


    });
    </script>
</body>

</html>