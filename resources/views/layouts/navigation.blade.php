<nav x-data="{ sidebarOpen: true, open: false }" class="fixed right-0 top-0 h-screen bg-white border-l border-gray-200 flex flex-col shadow-lg transition-all duration-300"
     :class="sidebarOpen ? 'w-64' : 'w-16'">
    
    <div class="flex items-center justify-between p-4 border-b border-gray-200">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3" x-show="sidebarOpen">
            <span class="text-xl font-bold text-gray-800">DB Monitor</span>
        </a>
        <button @click="sidebarOpen = !sidebarOpen" class="p-1 rounded-md hover:bg-gray-100 text-gray-600">
            <svg x-show="sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
            </svg>
            <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
            </svg>
        </button>
    </div>

    <div class="flex-1 py-4 overflow-y-auto">
        <div class="space-y-1 px-2">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg" :class="!sidebarOpen ? 'justify-center' : ''">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <span x-show="sidebarOpen">{{ __('Dashboard') }}</span>
            </x-nav-link>
            <x-nav-link :href="route('servers')" :active="request()->routeIs('servers')" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg" :class="!sidebarOpen ? 'justify-center' : ''">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                </svg>
                <span x-show="sidebarOpen">{{ __('Servers') }}</span>
            </x-nav-link>
            <x-nav-link :href="route('databases')" :active="request()->routeIs('databases')" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg" :class="!sidebarOpen ? 'justify-center' : ''">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                </svg>
                <span x-show="sidebarOpen">{{ __('Databases') }}</span>
            </x-nav-link>
            <x-nav-link :href="route('organisations')" :active="request()->routeIs('organisations')" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg" :class="!sidebarOpen ? 'justify-center' : ''">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                </svg>
                <span x-show="sidebarOpen">{{ __('Organisations') }}</span>
            </x-nav-link>
            <x-nav-link :href="route('branches')" :active="request()->routeIs('branches')" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg" :class="!sidebarOpen ? 'justify-center' : ''">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
                <span x-show="sidebarOpen">{{ __('Branches') }}</span>
            </x-nav-link>
            <x-nav-link :href="route('users')" :active="request()->routeIs('users')" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg" :class="!sidebarOpen ? 'justify-center' : ''">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M15 19H9a6 6 0 0112 0v1H9v-1z"></path>
                </svg>
                <span x-show="sidebarOpen">{{ __('Users') }}</span>
            </x-nav-link>
            <x-nav-link :href="route('audit-logs')" :active="request()->routeIs('audit-logs')" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg" :class="!sidebarOpen ? 'justify-center' : ''">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span x-show="sidebarOpen">{{ __('Audit Logs') }}</span>
            </x-nav-link>
        </div>

        <!-- Animated Clock and Version Display -->
        <div x-show="sidebarOpen" class="mt-4 px-3 py-3 border-t border-gray-200">


            <!-- Version Display -->
            <div class="mt-3 pt-3 border-t border-gray-200 text-xs">
                <span class="text-gray-500">Version</span>
                <div class="font-mono font-semibold text-indigo-600 text-xs">
                    @php
                        $appVersion = \App\Models\AppVersion::orderBy('version')->latest()->first();
                        echo $appVersion?->version ?? 'v1.0.0';
                    @endphp
                </div>
            </div>
        </div>
    </div>

    <div class="p-2 border-t border-gray-200">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center w-full px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 hover:text-gray-900 focus:outline-none transition ease-in-out duration-150" :class="!sidebarOpen ? 'justify-center' : ''">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ms-2">{{ Auth::user()->name }}</span>
                    <svg x-show="sidebarOpen" class="fill-current h-4 w-4 ms-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')" class="text-gray-600">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" class="text-gray-600"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>