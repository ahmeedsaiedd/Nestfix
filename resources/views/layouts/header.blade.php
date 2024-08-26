<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
    <div class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
        <!-- Mobile hamburger -->
        <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
            @click="toggleSideMenu" aria-label="Menu">
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
        <!-- Search input -->
        <div class="flex justify-center flex-1 lg:mr-32">
            <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input
                    class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                    type="text" placeholder="Search for projects" aria-label="Search" />
            </div>
        </div>
        <ul class="flex items-center flex-shrink-0 space-x-6">
            <!-- Theme toggler (if needed) -->
            {{-- <li class="flex">
                <button class="rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="toggleTheme" aria-label="Toggle color mode">
                    <template x-if="!dark">
                        <svg class="w-6 h-6 text-gray-700" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v1.5a6.5 6.5 0 010 13V21h-1.5v-3.5a8 8 0 000-13V3H12zM5 12a7 7 0 0114 0H5z"></path>
                        </svg>
                    </template>
                    <template x-if="dark">
                        <svg class="w-6 h-6 text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4V3a9 9 0 100 18v-1a8 8 0 010-16zM4.5 12A7.5 7.5 0 0112 4.5a7.5 7.5 0 010 15A7.5 7.5 0 014.5 12z"></path>
                        </svg>
                    </template>
                </button>
            </li> --}}
        
            <!-- Profile menu -->
            <li class="relative">
                <!-- Dropdown menu (always visible) -->
                <div id="user-menu" class="absolute right-0 w-48 mt-2 origin-top-right  move-up">
                    <div class="py-1" role="none">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            @method('POST')
                
                            <button type="submit" class="flex items-center px-4 text-sm font-medium text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 w-full text-left" role="menuitem">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </li>
            
            
            
        </ul>
        
    </div>
</header>
