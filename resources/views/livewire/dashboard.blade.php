<div wire:key="dashboard">
  <div class="glass-card p-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500 text-sm mt-1">Monitor your infrastructure</p>
      </div>
      <div class="flex items-center gap-3 mt-4 md:mt-0">
        <div class="flex items-center gap-2 px-3 py-2 bg-gray-50 rounded-lg text-sm">
          <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
          <span class="text-gray-600">Live</span>
        </div>
        <button wire:click="refresh" class="btn-soft flex items-center gap-2 text-sm py-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
          </svg>
          Refresh
        </button>
      </div>
    </div>

    {{-- Stats Grid - Horizon UI Style --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-500 text-sm font-medium">Total Servers</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_servers'] ?? 0 }}</p>
          </div>
          <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
            </svg>
          </div>
        </div>
        <div class="mt-3 flex items-center gap-1 text-sm">
          <span class="text-green-600 font-medium">{{ $stats['spike_servers'] ?? 0 }}</span>
          <span class="text-gray-400">with alerts</span>
        </div>
      </div>

      <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-500 text-sm font-medium">Total Databases</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_databases'] ?? 0 }}</p>
          </div>
          <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
            </svg>
          </div>
        </div>
        <div class="mt-3 flex items-center gap-1 text-sm">
          <span class="text-orange-600 font-medium">{{ $stats['recent_spikes'] ?? 0 }}</span>
          <span class="text-gray-400">with alerts</span>
        </div>
      </div>

      <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-500 text-sm font-medium">Organisations</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_organisations'] ?? 0 }}</p>
          </div>
          <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
          </div>
        </div>
        <div class="mt-3 text-sm text-gray-400">
          Active organisations
        </div>
      </div>

      <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-500 text-sm font-medium">Active Users</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_users'] ?? 0 }}</p>
          </div>
          <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
          </div>
        </div>
        <div class="mt-3 text-sm text-gray-400">
          Registered users
        </div>
      </div>
    </div>

    {{-- Server & Database Lists --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      {{-- Servers --}}
      <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
          <h2 class="font-semibold text-gray-800">Servers</h2>
          <a href="{{ route('servers') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">View All</a>
        </div>
        <div class="p-4">
          @forelse(array_slice($servers, 0, 3) as $server)
            <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 {{ $server['status'] === 'spike' ? 'bg-red-50' : 'bg-green-50' }} rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 {{ $server['status'] === 'spike' ? 'text-red-500' : 'text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                  </svg>
                </div>
                <div>
                  <p class="font-medium text-gray-800 text-sm">{{ $server['name'] }}</p>
                  <p class="text-gray-400 text-xs">{{ $server['ip'] }}</p>
                </div>
              </div>
              <span class="px-2 py-1 rounded-full text-xs font-medium {{ $server['status'] === 'spike' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                {{ ucfirst($server['status']) }}
              </span>
            </div>
          @empty
            <div class="text-center py-8 text-gray-400">
              <p class="text-sm">No servers configured</p>
            </div>
          @endforelse
        </div>
      </div>

      {{-- Databases --}}
      <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
          <h2 class="font-semibold text-gray-800">Databases</h2>
          <a href="{{ route('databases') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">View All</a>
        </div>
        <div class="p-4">
          @forelse(array_slice($databases, 0, 3) as $db)
            <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 {{ $db['status'] === 'spike' ? 'bg-red-50' : 'bg-green-50' }} rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 {{ $db['status'] === 'spike' ? 'text-red-500' : 'text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                  </svg>
                </div>
                <div>
                  <p class="font-medium text-gray-800 text-sm">{{ $db['name'] }}</p>
                  <p class="text-gray-400 text-xs">{{ $db['type'] }}</p>
                </div>
              </div>
              <span class="px-2 py-1 rounded-full text-xs font-medium {{ $db['status'] === 'spike' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                {{ ucfirst($db['status']) }}
              </span>
            </div>
          @empty
            <div class="text-center py-8 text-gray-400">
              <p class="text-sm">No databases configured</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>

    {{-- Recent Alerts --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
      <div class="p-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-semibold text-gray-800">Recent Alerts</h2>
        <a href="{{ route('audit-logs') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">View All</a>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="text-left p-3 text-xs font-medium text-gray-500">Time</th>
              <th class="text-left p-3 text-xs font-medium text-gray-500">Type</th>
              <th class="text-left p-3 text-xs font-medium text-gray-500">Entity</th>
              <th class="text-left p-3 text-xs font-medium text-gray-500">Message</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentAlerts as $alert)
              <tr class="border-t border-gray-50">
                <td class="p-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($alert['created_at'])->format('H:i:s') }}</td>
                <td class="p-3">
                  <span class="px-2 py-1 rounded-full text-xs font-medium {{ $alert['type'] === 'server' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                    {{ ucfirst($alert['type']) }}
                  </span>
                </td>
                <td class="p-3 text-sm text-gray-800">{{ $alert['alertable']['name'] ?? 'N/A' }}</td>
                <td class="p-3 text-sm text-gray-600 truncate max-w-xs">{{ $alert['message'] }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="p-8 text-center text-gray-400">
                  <p class="text-sm">No recent alerts</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    Livewire.hook('morph.updated', () => {
      document.getElementById('last-refresh').textContent = new Date().toLocaleTimeString();
    });
  </script>
</div>