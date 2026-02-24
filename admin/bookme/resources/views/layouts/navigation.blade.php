<nav x-data="{ open: false }" class="bg-[#006172] border-b border-gray-100 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-3xl font-bold text-blue-50">
                    Bookme
                </a>
            </div>
            
            <form action="{{ route('search.submit') }}" method="POST"
      class="flex max-w-md mx-auto">
    @csrf

    <input
        type="number"
        name="number"
        placeholder="Enter Phone number..."
        class="w-96 h-10 px-4 border border-gray-300 rounded-l-md
               focus:outline-none focus:ring-2 focus:ring-blue-400"
        required
    >

    <button
        type="submit"
        class="h-10 px-6 bg-orange-600 text-white rounded-r-md hover:bg-blue-600"
    >
        Search
    </button>
</form>


            <!-- Right Section -->
            <div class="flex items-center space-x-4">

                <!-- Notification -->
                <div class="relative">
                    <button id="notificationButton"
                        class="relative p-2 text-white hover:bg-[#004d5a] rounded-full"
                        data-dropdown-toggle="notificationDropdown"
                        data-dropdown-placement="bottom-end">

                        🔔
                        <span id="notificationBadge"
                            class="hidden absolute -top-1 -right-1 bg-[#F37021] text-white text-xs font-bold px-1.5 py-0.5 rounded-full"></span>
                    </button>

                    <div id="notificationDropdown"
                        class="hidden z-50 w-80 bg-white rounded-lg shadow border">

                        <!-- Header -->
                        <div class="px-4 py-3 border-b">
                            <h3 class="font-semibold text-gray-800">Notifications</h3>
                        </div>

                        <!-- Content -->
                        <div id="notificationContent" class="max-h-96 overflow-y-auto"></div>

                    </div>
                </div>

 <div class="relative ml-3">
                    <button id="dropdownUserButton"
                        class="flex items-center text-white hover:text-[#F37021] focus:outline-none transition-colors duration-200 group"
                        type="button"
                        data-dropdown-toggle="dropdownUser"
                        data-dropdown-placement="bottom-end">
                        <div
                            class="h-8 w-8 rounded-full bg-[#F37021] flex items-center justify-center text-white font-medium group-hover:bg-white group-hover:text-[#F37021] transition-colors duration-200">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="ml-2 hidden md:block text-gray-50">{{ Auth::user()->name }}</span>
                        <svg class="ml-1 h-4 w-4 hidden text-gray-50 md:block" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Flowbite Dropdown menu -->
                    <div id="dropdownUser" class="hidden z-50 w-44 bg-white rounded divide-y divide-gray-100 shadow border border-gray-200" data-dropdown-content>
                        <div class="py-3 px-4 text-sm text-gray-900">
                            <div class="font-medium text-gray-950">{{ Auth::user()->name }}</div>
                            <div class="truncate text-gray-600">{{ Auth::user()->email }}</div>
                        </div>
                        <ul class="py-1 text-sm text-gray-700" aria-labelledby="dropdownUserButton">
                            <li>
                                <x-dropdown-link :href="route('profile.edit')"
                                    class="block py-2 px-4 hover:bg-gray-100 hover:text-[#F37021] transition-colors duration-200">
                                    {{ __('Profile Settings') }}
                                </x-dropdown-link>
                            </li>
                            <li>
                                <x-dropdown-link href="#"
                                    class="block py-2 px-4 hover:bg-gray-100 hover:text-[#F37021] transition-colors duration-200">
                                    {{ __('Preferences') }}
                                </x-dropdown-link>
                            </li>
                        </ul>
                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#F37021] transition-colors duration-200">
                                    {{ __('Sign out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<script>
    let notifications = [];
    let notificationCount = 0;

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('notificationButton')
            .addEventListener('click', () => {
                setTimeout(loadNotifications, 100);
            });

        checkNewNotifications();
        setInterval(checkNewNotifications, 15000);
    });

    function loadNotifications() {
        const content = document.getElementById('notificationContent');

        content.innerHTML = `<p class="p-4 text-center text-gray-500">Loading...</p>`;

        fetch('/admin/notifications')
            .then(res => res.json())
            .then(data => {
                notifications = data.data || [];
                notificationCount = data.count || 0;
                updateNotificationBadge();
                displayNotifications(content);
            });
    }

    function displayNotifications(content) {
        if (notifications.length === 0) {
            content.innerHTML = `
                <p class="p-6 text-center text-gray-500">
                    No notifications
                </p>`;
            return;
        }

        let html = '';

        notifications.forEach(n => {
            const active = (n.isActive === 1 || n.isActive === true);

            html += `
<div class="notification-item px-4 py-3 border-b
    ${active ? 'bg-blue-900 text-gray-200' : 'hover:bg-gray-50'}"
    data-id="${n.id}">

    <a href="/admin/notification/verify/${n.id}" class="block">
        <p class="text-sm font-medium">
            ${n.notification}
        </p>
        <p class="text-xs ${active ? 'text-blue-100' : 'text-gray-500'}">
            ${getTimeAgo(n.created_at)}
        </p>
    </a>
</div>
`;

           
        });

        content.innerHTML = html;

        document.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                markAsRead(btn.dataset.id);
            });
        });
    }

    function markAsRead(id) {
        const notificationItem = document.querySelector(`.notification-item[data-id="${id}"]`);
        if (notificationItem) {
            notificationItem.remove();
            notificationCount--;
            updateNotificationBadge();

            fetch(`/admin/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
        }
    }

    function updateNotificationBadge() {
        const badge = document.getElementById('notificationBadge');
        if (notificationCount > 0) {
            badge.textContent = notificationCount;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    function checkNewNotifications() {
        fetch('/admin/notifications')
            .then(res => res.json())
            .then(data => {
                if (data.count !== notificationCount) {
                    notificationCount = data.count;
                    updateNotificationBadge();
                }
            });
    }

    function getTimeAgo(date) {
        const diff = (new Date() - new Date(date)) / 60000;
        if (diff < 1) return 'Just now';
        if (diff < 60) return Math.floor(diff) + ' min ago';
        if (diff < 1440) return Math.floor(diff / 60) + ' hours ago';
        return Math.floor(diff / 1440) + ' days ago';
    }
</script>