<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DB Monitoring') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <style>
            :root {
                --primary-color: #6366f1;
                --primary-hover: #4f46e5;
                --bg-gradient-start: #f1f5f9;
                --bg-gradient-end: #e2e8f0;
                --sidebar-width: 4rem;
            }
            body {
                background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
                min-height: 100vh;
            }
            .sidebar-hidden { width: 0 !important; overflow: hidden; }
            
            .sidebar-item {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                padding: 0.75rem;
                margin-bottom: 0.25rem;
                border-radius: 0.5rem;
                color: #64748b;
                transition: all 0.2s ease;
                cursor: pointer;
            }
            .sidebar-item:hover {
                background-color: #eef2ff;
                color: var(--primary-color);
            }
            .sidebar-item.active {
                background-color: #eef2ff;
                color: var(--primary-color);
            }
            .sidebar-item::after {
                content: attr(data-label);
                position: absolute;
                left: 100%;
                margin-left: 0.75rem;
                padding: 0.5rem 0.75rem;
                background-color: #1e293b;
                color: white;
                font-size: 0.875rem;
                border-radius: 0.375rem;
                white-space: nowrap;
                opacity: 0;
                visibility: hidden;
                transition: all 0.2s ease;
                z-index: 50;
            }
            .sidebar-item:hover::after {
                opacity: 1;
                visibility: visible;
                left: calc(100% + 0.5rem);
            }
            
            .glass-card {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.5);
                border-radius: 1rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            }
            
            .glass-header {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(8px);
                border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen">
            <nav id="sidebar" class="flex flex-col bg-white border-r border-gray-200 transition-all duration-300" style="width: 4rem;">
                <div class="h-16 flex items-center justify-center border-b border-gray-200" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                        </svg>
                    </a>
                </div>

                <div class="flex-1 py-4">
                    <div class="space-y-1 px-2">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="sidebar-item" data-label="Dashboard">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </x-nav-link>
                        <x-nav-link :href="route('servers')" :active="request()->routeIs('servers')" class="sidebar-item" data-label="Servers">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                        </x-nav-link>
<x-nav-link :href="route('databases')" :active="request()->routeIs('databases')" class="sidebar-item" data-label="Databases">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s8-1.79 8-4"></path>
                            </svg>
                        </x-nav-link>
                        <x-nav-link :href="route('organisations')" :active="request()->routeIs('organisations')" class="sidebar-item" data-label="organisation">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </x-nav-link>
                        <x-nav-link :href="route('users')" :active="request()->routeIs('users')" class="sidebar-item" data-label="Users">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </x-nav-link>
                    </div>
                </div>

                <div class="p-2 border-t border-gray-200">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="sidebar-item" data-label="{{ Auth::user()->name }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </button>
                        <div x-show="open" @click.outside="open = false" class="absolute bottom-full left-0 mb-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50" style="display: none;">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="px-2 py-3 border-t border-gray-200 flex flex-col items-center justify-center opacity-60">
                    <span class="text-[7px] font-bold text-gray-400 uppercase tracking-tighter mb-0.5">Ver.</span>
                    <span class="text-[9px] font-medium text-gray-500">{{ $appVersion }}</span>
                </div>
            </nav>

            <div id="main-wrapper" class="flex-1 flex flex-col">
                <header class="h-16 glass-header sticky top-0 z-40 flex items-center justify-between px-6">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleSidebar()" class="p-2 rounded-md hover:bg-gray-100 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h1 class="text-lg font-semibold text-gray-800">
                            @yield('title', 'Dashboard')
                        </h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <div id="time-display" class="text-[11px] font-bold text-indigo-600 uppercase tracking-wide bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-100 tabular-nums"></div>
                        <div class="border-l border-gray-200 h-6 mx-1"></div>
                        <div id="date-display" class="text-[11px] font-bold text-gray-500 uppercase tracking-wide"></div>
                    </div>
                </header>

                <main id="main-content" class="flex-1 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

        </div>

        @livewireScripts
        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                
                if (sidebar.classList.contains('sidebar-hidden')) {
                    sidebar.classList.remove('sidebar-hidden');
                    sidebar.style.width = '4rem';
                } else {
                    sidebar.classList.add('sidebar-hidden');
                    sidebar.style.width = '0';
                }
            }

            function showViewModal(title, data) {
                let content = '';
                if (typeof data === 'string') {
                    data = JSON.parse(data);
                }
                for (const [key, value] of Object.entries(data)) {
                    content += key.charAt(0).toUpperCase() + key.slice(1).replace(/_/g, ' ') + ': ' + value + '\n';
                }
                document.getElementById('viewModalTitle').textContent = title;
                document.getElementById('viewModalContent').textContent = content;
                document.getElementById('viewModalOverlay').classList.remove('hidden');
            }

            function closeViewModal() {
                document.getElementById('viewModalOverlay').classList.add('hidden');
            }
            function updateClock() {
                const now = new Date();
                
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                
                const timeDisplay = document.getElementById('time-display');
                if (timeDisplay) {
                    timeDisplay.textContent = `TIME : ${hours}:${minutes}:${seconds} WIB`;
                }
                
                const dateDisplay = document.getElementById('date-display');
                if (dateDisplay) {
                    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                    dateDisplay.textContent = now.toLocaleDateString('en-GB', options);
                }
                
                requestAnimationFrame(updateClock);
            }
            updateClock();
        </script>

        <div id="viewModalOverlay" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden" style="display: none;">
            <div class="bg-white rounded-xl p-6 w-full max-w-2xl border border-gray-200 shadow-lg max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h2 id="viewModalTitle" class="text-xl font-semibold text-gray-800"></h2>
                    <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <pre id="viewModalContent" class="text-gray-700 whitespace-pre-wrap font-sans"></pre>
                <div class="flex justify-end mt-6">
                    <button onclick="closeViewModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700">Close</button>
                </div>
            </div>
        </div>
    </body>
</html>
