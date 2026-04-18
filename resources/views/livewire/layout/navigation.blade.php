<?php
// Version is already passed from AppServiceProvider view composer
// No need to query again for performance
?>

<div class="sidebar fixed left-0 top-0 bottom-0 w-20 bg-white transition-all duration-300 z-50 shadow-lg border-r border-gray-200 overflow-x-hidden">
    
    <!-- Logo -->
    <div class="h-20 flex items-center justify-center border-b border-gray-200 shrink-0">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
            <span class="material-symbols-rounded text-white text-xl">database</span>
        </div>
    </div>

    <!-- Nav Items -->
    <nav class="py-4 px-2 space-y-1 flex flex-col">
        <a href="{{ route('dashboard') }}" wire:navigate 
           class="group flex items-center justify-center px-0 py-3 rounded-xl transition-all duration-200 relative {{ request()->routeIs('dashboard') ? 'text-purple-600' : 'text-gray-500' }}">
            <span class="material-symbols-rounded text-xl transition-transform duration-200 group-hover:scale-110 group-hover:text-blue-600">dashboard</span>
            <span class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none whitespace-nowrap z-50 transition-opacity duration-200">
                Dashboard
            </span>
        </a>
        
        <a href="{{ route('servers') }}" wire:navigate 
           class="group flex items-center justify-center px-0 py-3 rounded-xl transition-all duration-200 relative {{ request()->routeIs('servers') ? 'text-purple-600' : 'text-gray-500' }}">
            <span class="material-symbols-rounded text-xl transition-transform duration-200 group-hover:scale-110 group-hover:text-blue-600">dns</span>
            <span class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none whitespace-nowrap z-50 transition-opacity duration-200">
                Servers
            </span>
        </a>
        
        <a href="{{ route('databases') }}" wire:navigate 
           class="group flex items-center justify-center px-0 py-3 rounded-xl transition-all duration-200 relative {{ request()->routeIs('databases') ? 'text-purple-600' : 'text-gray-500' }}">
            <span class="material-symbols-rounded text-xl transition-transform duration-200 group-hover:scale-110 group-hover:text-blue-600">storage</span>
            <span class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none whitespace-nowrap z-50 transition-opacity duration-200">
                Databases
            </span>
        </a>
        
        <a href="{{ route('organisations') }}" wire:navigate 
           class="group flex items-center justify-center px-0 py-3 rounded-xl transition-all duration-200 relative {{ request()->routeIs('organisations') ? 'text-purple-600' : 'text-gray-500' }}">
            <span class="material-symbols-rounded text-xl transition-transform duration-200 group-hover:scale-110 group-hover:text-blue-600">business</span>
            <span class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none whitespace-nowrap z-50 transition-opacity duration-200">
                Organisations
            </span>
        </a>
        
        <a href="{{ route('users') }}" wire:navigate 
           class="group flex items-center justify-center px-0 py-3 rounded-xl transition-all duration-200 relative {{ request()->routeIs('users') ? 'text-purple-600' : 'text-gray-500' }}">
            <span class="material-symbols-rounded text-xl transition-transform duration-200 group-hover:scale-110 group-hover:text-blue-600">group</span>
            <span class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none whitespace-nowrap z-50 transition-opacity duration-200">
                Users
            </span>
        </a>
        
        <a href="{{ route('audit-logs') }}" wire:navigate 
           class="group flex items-center justify-center px-0 py-3 rounded-xl transition-all duration-200 relative {{ request()->routeIs('audit-logs') ? 'text-purple-600' : 'text-gray-500' }}">
            <span class="material-symbols-rounded text-xl transition-transform duration-200 group-hover:scale-110 group-hover:text-blue-600">receipt_long</span>
            <span class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none whitespace-nowrap z-50 transition-opacity duration-200">
                Audit Logs
            </span>
        </a>
    </nav>

    <!-- Bottom Section -->
    <div class="mt-auto border-t border-gray-200">
        <nav class="py-4 px-2 space-y-1">
            <a href="{{ route('profile.edit') }}" wire:navigate 
               class="group flex items-center justify-center px-0 py-3 rounded-xl transition-all duration-200 relative text-gray-500 group-hover:text-blue-600">
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none whitespace-nowrap z-50 transition-opacity duration-200">
                    {{ auth()->user()->name }}
                </span>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" 
                        class="group w-full flex items-center justify-center px-0 py-3 rounded-xl transition-all duration-200 relative text-gray-500 group-hover:text-red-600">
                    <span class="material-symbols-rounded text-xl transition-transform duration-200 group-hover:scale-110">logout</span>
                    <span class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none whitespace-nowrap z-50 transition-opacity duration-200">
                        Logout
                    </span>
                </button>
            </form>
        </nav>
        
        <div class="py-3 px-3 flex items-center justify-center border-t border-gray-200">
            <span class="text-xs font-bold text-gray-400">{{ $appVersion }}</span>
        </div>
    </div>
</div>