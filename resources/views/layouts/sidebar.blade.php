<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <div class="flex justify-center items-center">
            <a href="#" class="flex items-center">
                <img src="{{ asset('assets/EBE_LOGO.png') }}" alt="NestFix Logo" class="w-30 h-12">
            </a>
        </div>
        
        
        
        <ul class="mt-6">
            <li class="relative px-6 py-3 {{ request()->routeIs('admin.home') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('admin.home') ? 'text-white' : 'text-gray-800' }}"
                    href="{{ route('admin.home') }}">
                    <i class="fas fa-home w-5 h-5"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>
        {{-- <ul class="mt-6">
            <li class="relative px-6 py-3 {{ request()->routeIs('admin.notification') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('admin.notification') ? 'text-white' : 'text-gray-800' }}"
                    href="{{ route('admin.notification') }}">
                    <i class="fas fa-home w-5 h-5"></i>
                    <span class="ml-4">notification</span>
                </a>
            </li>
        </ul> --}}
        
        <ul>
            <li class="relative px-6 py-3 {{ request()->routeIs('add-ticket') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('add-ticket') ? 'text-white' : 'text-gray-800' }}"
                    href="{{ route('add-ticket') }}">
                    <i class="fas fa-chart-line w-5 h-5"></i>
                    <span class="ml-4">Add Ticket</span>
                </a>
            </li>
            <li class="relative px-6 py-3 {{ request()->routeIs('all-tickets') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('all-tickets') ? 'text-white' : 'text-gray-800' }}"
                    href="{{ route('all-tickets') }}">
                    <i class="fas fa-ticket-alt w-5 h-5"></i>
                    <span class="ml-4">All Tickets</span>
                </a>
            </li>
            <li class="relative px-6 py-3 {{ request()->routeIs('active-tickets') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('active-tickets') ? 'text-white' : 'text-gray-800' }}"
                    href="{{ route('active-tickets') }}">
                    <i class="fas fa-check-circle w-5 h-5"></i>
                    <span class="ml-4">Active Tickets</span>
                </a>
            </li>
            @if (auth()->user()->role === 'admin')
                <!-- Check if the user is an admin -->
                <li
                    class="relative px-6 py-3 {{ request()->routeIs('create-user') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('create-user') ? 'text-white' : 'text-gray-800' }}"
                        href="{{ route('create-user') }}">
                        <i class="fas fa-users w-5 h-5"></i>
                        <span class="ml-4">Create new user</span>
                    </a>
                </li>
                <li
                    class="relative px-6 py-3 {{ request()->routeIs('manage-users') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('manage-users') ? 'text-white' : 'text-gray-800' }}"
                        href="{{ route('manage-users') }}">
                        <i class="fas fa-user-cog w-5 h-5"></i>
                        <span class="ml-4">Manage Users</span>
                    </a>
                </li>
                <li
                    class="relative px-6 py-3 {{ request()->routeIs('add-category') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('add-category') ? 'text-white' : 'text-gray-800' }}"
                        href="{{ route('add-category') }}">
                        <i class="fas fa-tags w-5 h-5 text-purple-400"></i>
                        <span class="ml-4">Add Category</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 {{ request()->routeIs('add-team') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('add-team') ? 'text-white' : 'text-gray-800' }}"
                        href="{{ route('add-team') }}">
                        <i class="fas fa-users w-5 h-5 text-purple-400"></i>
                        <span class="ml-4">Add Team</span>
                    </a>
                </li>
                <li
                    class="relative px-6 py-3 {{ request()->routeIs('add-status') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('add-status') ? 'text-white' : 'text-gray-800' }}"
                        href="{{ route('add-status') }}">
                        <i class="fas fa-tag w-5 h-5 text-purple-400"></i>
                        <span class="ml-4">Add Status</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 {{ request()->routeIs('add-provider') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('add-provider') ? 'text-white' : 'text-gray-800' }}"
                        href="{{ route('add-provider') }}">
                        <i class="fas fa-building w-5 h-5 text-purple-400"></i> <!-- Change the icon here -->
                        <span class="ml-4">Add Provider</span>
                    </a>
                </li>
                
            @endif
            {{-- <div class="absolute bottom-0 left-0 w-full px-6 py-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center w-50 text-sm font-semibold text-gray-800 hover:text-gray-600 transition-colors duration-150">
                        <i class="fas fa-sign-out-alt w-5 h-5"></i>
                        <span class="ml-4">Logout</span>
                    </button>
                </form>
            </div> --}}
        </ul>
        <!-- Logout button -->

    </div>
</aside>

<!-- Mobile sidebar -->
<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
    x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu"
    @keydown.escape="closeSideMenu">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <div class="flex justify-center items-center">
            <a href="#" class="flex items-center">
                <img src="{{ asset('assets/EBE_LOGO.png') }}" alt="NestFix Logo" class="w-30 h-12">
            </a>
        </div>
        <ul class="mt-6">
            <!-- Dashboard -->
            <li class="relative px-6 py-3 {{ request()->routeIs('admin.home') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('admin.home') ? 'text-white' : 'text-gray-800' }}"
                    href="{{ route('admin.home') }}">
                    <i class="fas fa-home w-5 h-5"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
            
            <!-- Add Ticket -->
            <li class="relative px-6 py-3 {{ request()->routeIs('add-ticket') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('add-ticket') ? 'text-white' : 'text-gray-800' }}"
                    href="{{ route('add-ticket') }}">
                    <i class="fas fa-chart-line w-5 h-5"></i>
                    <span class="ml-4">Add Ticket</span>
                </a>
            </li>
            
            <!-- All Tickets -->
            <li class="relative px-6 py-3 {{ request()->routeIs('all-tickets') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('all-tickets') ? 'text-white' : 'text-gray-800' }}"
                    href="{{ route('all-tickets') }}">
                    <i class="fas fa-ticket-alt w-5 h-5"></i>
                    <span class="ml-4">All Tickets</span>
                </a>
            </li>

            <!-- Active Tickets -->
            <li class="relative px-6 py-3 {{ request()->routeIs('active-tickets') ? 'bg-purple-600 text-white' : '' }}">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('active-tickets') ? 'text-white' : 'text-gray-800' }}"
                    href="{{ route('active-tickets') }}">
                    <i class="fas fa-check-circle w-5 h-5"></i>
                    <span class="ml-4">Active Tickets</span>
                </a>
            </li>
            
            <!-- Admin-Only Items -->
            @if (auth()->user()->role === 'admin')
                <li class="relative px-6 py-3 {{ request()->routeIs('create-user') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('create-user') ? 'text-white' : 'text-gray-800' }}"
                        href="{{ route('create-user') }}">
                        <i class="fas fa-users w-5 h-5"></i>
                        <span class="ml-4">Create new user</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 {{ request()->routeIs('manage-users') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('manage-users') ? 'text-white' : 'text-gray-800' }}"
                        href="{{ route('manage-users') }}">
                        <i class="fas fa-user-cog w-5 h-5"></i>
                        <span class="ml-4">Manage Users</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 {{ request()->routeIs('add-category') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('add-category') ? 'text-white' : 'text-gray-800' }}"
                        href="{{ route('add-category') }}">
                        <i class="fas fa-tags w-5 h-5 text-purple-400"></i>
                        <span class="ml-4">Add Category</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 {{ request()->routeIs('add-team') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('add-team') ? 'text-white' : 'text-gray-800' }}"
                        href="{{ route('add-team') }}">
                        <i class="fas fa-users w-5 h-5 text-purple-400"></i>
                        <span class="ml-4">Add Team</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 {{ request()->routeIs('add-status') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('add-status') ? 'text-white' : 'text-gray-800' }}"
                        href="{{ route('add-status') }}">
                        <i class="fas fa-tag w-5 h-5 text-purple-400"></i>
                        <span class="ml-4">Add Status</span>
                    </a>
                </li>
                <li class="relative px-6 py-3 {{ request()->routeIs('add-provider') ? 'bg-purple-600 text-white' : '' }}">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('add-provider') ? 'text-white' : 'text-gray-800' }}"
                        href="{{ route('add-provider') }}">
                        <i class="fas fa-building w-5 h-5 text-purple-400"></i>
                        <span class="ml-4">Add Provider</span>
                    </a>
                </li>
            @endif
        </ul>
        <!-- Logout button -->
        {{-- 
        <div class="absolute bottom-0 left-0 w-full px-6 py-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="inline-flex items-center w-50 text-sm font-semibold text-gray-800 hover:text-gray-600 transition-colors duration-150">
                    <i class="fas fa-sign-out-alt w-5 h-5"></i>
                    <span class="ml-4">Logout</span>
                </button>
            </form>
        </div> 
        --}}
    </div>
</aside>


<script>
    // JavaScript for toggling mobile sidebar visibility
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileSidebarClose = document.getElementById('mobile-sidebar-close');

    mobileMenuToggle.addEventListener('click', function() {
        mobileSidebar.classList.toggle('hidden');
    });

    mobileSidebarClose.addEventListener('click', function() {
        mobileSidebar.classList.add('hidden');
    });
</script>
