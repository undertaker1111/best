<div class="min-w-fit">
    <!-- Sidebar backdrop (mobile only) -->
    <div
        class="fixed inset-0 bg-gray-900/30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
        aria-hidden="true"
        x-cloak
    ></div>

    <!-- Sidebar -->
    <div
        id="sidebar"
        class="flex lg:flex! flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:w-64! shrink-0 bg-white dark:bg-gray-800 p-4 transition-all duration-200 ease-in-out {{ $variant === 'v2' ? 'border-r border-gray-200 dark:border-gray-700/60' : 'rounded-r-2xl shadow-xs' }}"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'"
        @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false"
    >
        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-gray-500 hover:text-gray-400" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block" href="{{ route('tickets.dashboard') }}">
                <svg class="fill-violet-500" xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                    <path d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                </svg>                
            </a>
        </div>
        <!-- Links -->
        <div class="space-y-8">
            <!-- Ticketing group -->
            <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Tickets</span>
                </h3>
                <ul class="mt-3">
                    @can('view tickets')
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="{{ route('dashboard') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-violet-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M5.936.278A7.983 7.983 0 0 1 8 0a8 8 0 1 1-8 8c0-.722.104-1.413.278-2.064a1 1 0 1 1 1.932.516A5.99 5.99 0 0 0 2 8a6 6 0 1 0 6-6c-.53 0-1.045.076-1.548.21A1 1 0 1 1 5.936.278Z" />
                                    <path d="M6.068 7.482A2.003 2.003 0 0 0 8 10a2 2 0 1 0-.518-3.932L3.707 2.293a1 1 0 0 0-1.414 1.414l3.775 3.775Z" />
                                </svg>
                                <span class="text-sm font-medium ml-4">Dashboard</span>
                            </div>
                        </a>
                    </li>
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="{{ route('tickets.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-violet-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" />
                                </svg>
                                <span class="text-sm font-medium ml-4">All Tickets</span>
                            </div>
                        </a>
                    </li>
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="{{ route('tickets.my') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-violet-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <rect x="2" y="2" width="12" height="12" rx="2" />
                                </svg>
                                <span class="text-sm font-medium ml-4">My Tickets</span>
                            </div>
                        </a>
                    </li>
                    @can('create tickets')
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="{{ route('tickets.create') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-green-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M8 1v14M1 8h14" />
                                </svg>
                                <span class="text-sm font-medium ml-4">Create Ticket</span>
                            </div>
                        </a>
                    </li>
                    @endcan
                    @endcan
                </ul>
            </div>
            <!-- Profile/Settings group -->
            <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Account</span>
                </h3>
                <ul class="mt-3">
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="{{ route('profile.show') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Z" />
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Profile</span>
                            </div>
                        </a>
                    </li>
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="{{ route('settings') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1Zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10Zm0-9a4 4 0 1 0 0 8A4 4 0 0 0 8 4Z" />
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Settings</span>
                            </div>
                        </a>
                    </li>
                    @can('manage users')
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="{{ route('users.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm6-6a3 3 0 1 0-6 0 3 3 0 0 0 6 0Z" />
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">User Management</span>
                            </div>
                        </a>
                    </li>
                    @endcan
                    @can('manage permissions')
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="{{ route('permissions.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0Zm0 14.5A6.5 6.5 0 1 1 8 1.5a6.5 6.5 0 0 1 0 13Zm0-10a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Z" />
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Permissions</span>
                            </div>
                        </a>
                    </li>
                    @endcan
                    @can('view audits')
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="{{ route('audits.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M2 2h12v12H2z" fill="none"/><path d="M2 2h12v12H2z" stroke="currentColor" stroke-width="2"/><path d="M4 4h8v8H4z" fill="currentColor"/>
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Audits</span>
                            </div>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
            <!-- AI/Automations placeholder -->
            <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">AI & Automations</span>
                </h3>
                <ul class="mt-3">
                    @can('view ai')
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="{{ route('ai.placeholder') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" />
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">AI & Automations</span>
                            </div>
                        </a>
                    </li>
                    @endcan
                    @can('manage ai')
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="{{ route('ai.management') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-green-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <rect x="2" y="2" width="12" height="12" rx="2" />
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">AI Config & Features</span>
                            </div>
                        </a>
                    </li>
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="{{ route('ai.logs') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-blue-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M2 2h12v12H2z" fill="none"/><path d="M2 2h12v12H2z" stroke="currentColor" stroke-width="2"/><path d="M4 4h8v8H4z" fill="currentColor"/>
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">AI Logs</span>
                            </div>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>
</div>