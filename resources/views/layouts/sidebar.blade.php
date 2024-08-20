<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
            NestFix
        </a>
        <ul class="mt-6">
            <li class="relative px-6 py-3 {{ request()->routeIs('dashboard') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-800 dark:text-gray-100' }}"
                   href="{{ route('dashboard') }}">
                    <i class="fas fa-home w-5 h-5"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>
        <ul>
            <li class="relative px-6 py-3 {{ request()->routeIs('inbox') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('inbox') ? 'text-white' : 'text-gray-800 dark:text-gray-100' }}"
                   href="{{ route('inbox') }}">
                    <i class="fas fa-envelope w-5 h-5"></i>
                    <span class="ml-4">Inbox</span>
                </a>
            </li>
            <li class="relative px-6 py-3 {{ request()->routeIs('notifications') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('notifications') ? 'text-white' : 'text-gray-800 dark:text-gray-100' }}"
                   href="{{ route('notifications') }}">
                    <i class="fas fa-bell w-5 h-5"></i>
                    <span class="ml-4">Notification</span>
                </a>
            </li>
            <li class="relative px-6 py-3 {{ request()->routeIs('add-ticket') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('add-ticket') ? 'text-white' : 'text-gray-800 dark:text-gray-100' }}"
                   href="{{ route('add-ticket') }}">
                    <i class="fas fa-chart-line w-5 h-5"></i>
                    <span class="ml-4">Add Ticket</span>
                </a>
            </li>
            <li class="relative px-6 py-3 {{ request()->routeIs('all-tickets') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('all-tickets') ? 'text-white' : 'text-gray-800 dark:text-gray-100' }}"
                   href="{{ route('all-tickets') }}">
                    <i class="fas fa-ticket-alt w-5 h-5"></i>
                    <span class="ml-4">All Tickets</span>
                </a>
            </li>
            <li class="relative px-6 py-3 {{ request()->routeIs('active-tickets') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('active-tickets') ? 'text-white' : 'text-gray-800 dark:text-gray-100' }}"
                   href="{{ route('active-tickets') }}">
                    <i class="fas fa-check-circle w-5 h-5"></i>
                    <span class="ml-4">Active Tickets</span>
                </a>
            </li>
            @if(auth()->user()->role === 'admin') <!-- Check if the user is an admin -->
                <li class="relative px-6 py-3 {{ request()->routeIs('create-user') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('create-user') ? 'text-white' : 'text-gray-800 dark:text-gray-100' }}"
                       href="{{ route('create-user') }}">
                        <i class="fas fa-users w-5 h-5"></i>
                        <span class="ml-4">Create new user</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 {{ request()->routeIs('manage-users') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('manage-users') ? 'text-white' : 'text-gray-800 dark:text-gray-100' }}"
                       href="{{ route('manage-users') }}">
                        <i class="fas fa-user-cog w-5 h-5"></i>
                        <span class="ml-4">Manage Users</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>
