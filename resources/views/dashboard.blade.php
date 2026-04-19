<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight galaxy-border p-4 rounded-lg">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Card -->
            <div class="glass-card p-8 galaxy-border">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ __("Welcome back!") }}</h3>
                        <p class="text-gray-600">{{ __("You're logged in to your cosmic monitoring dashboard.") }}</p>
                    </div>
                    <div class="text-6xl">🚀</div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass-card p-6 galaxy-border hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">{{ __('Servers') }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $serversCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-6 galaxy-border hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">{{ __('Databases') }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $databasesCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-6 galaxy-border hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">{{ __('Users') }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $usersCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-6 galaxy-border hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">{{ __('Organisations') }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $organisationsCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="glass-card p-8 galaxy-border">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('Recent Activity') }}
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-indigo-50 rounded-lg">
                        <div class="w-2 h-2 bg-indigo-600 rounded-full mr-4"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ __('System initialized successfully') }}</p>
                            <p class="text-xs text-gray-500">{{ __('Just now') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center p-4 bg-green-50 rounded-lg">
                        <div class="w-2 h-2 bg-green-600 rounded-full mr-4"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ __('All servers are online') }}</p>
                            <p class="text-xs text-gray-500">{{ __('2 minutes ago') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                        <div class="w-2 h-2 bg-purple-600 rounded-full mr-4"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ __('Database backup completed') }}</p>
                            <p class="text-xs text-gray-500">{{ __('5 minutes ago') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
