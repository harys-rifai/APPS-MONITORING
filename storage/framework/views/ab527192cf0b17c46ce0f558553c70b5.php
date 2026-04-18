<div wire:key="dashboard">
  <div class="glass-card">
    <div class="max-w-7xl mx-auto">
      
      <div class="text-center py-12 px-6 mb-12 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-3xl glass-card">
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-4">
          Real-time Monitoring Dashboard
        </h1>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
          Track servers, databases, and alerts across your organization in real-time
        </p>
        <div class="flex flex-wrap justify-center gap-4 text-sm">
          <div class="bg-white/50 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/50">
            Org: <?php echo e(auth()->user()->organisation->name ?? 'Personal'); ?>

          </div>
          <div class="bg-white/50 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/50">
            Last Refresh: <span wire:ignore id="last-refresh"><?php echo e(now()->format('H:i:s')); ?></span>
          </div>
          <div class="bg-emerald-100 px-4 py-2 rounded-xl border border-emerald-200 font-semibold animate-pulse">
            LIVE
          </div>
        </div>
      </div>

      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['total_servers' => ['Servers', 'dns', 'blue'], 'total_databases' => ['Databases', 'storage', 'purple'], 'spike_servers' => ['Server Spikes', 'warning', 'red'], 'recent_spikes' => ['DB Spikes 24h', 'error', 'orange']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="group glass-card p-8 hover:scale-105 transition-all duration-300 hover:shadow-2xl cursor-pointer border-0 hover:border-indigo-200">
            <div class="flex items-center justify-between mb-4">
              <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wide mb-1 opacity-80"><?php echo e($data[0]); ?></p>
                <p class="text-3xl lg:text-4xl font-black bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700 bg-clip-text text-transparent group-hover:from-indigo-600 group-hover:to-purple-600 transition-all duration-500">
                  <?php echo e($stats[$key] ?? 0); ?>

                </p>
              </div>
              <div class="w-16 h-16 bg-gradient-to-br <?php echo e($data[2]); ?>-100 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-rounded text-2xl text-<?php echo e($data[2]); ?>-600"><?php echo e($data[1]); ?></span>
              </div>
            </div>
            <div class="w-full bg-gradient-to-r from-gray-100 to-gray-200 h-1.5 rounded-full overflow-hidden">
              <div class="h-1.5 bg-gradient-to-r <?php echo e($data[2]); ?>-500 rounded-full transition-all duration-700" style="width: min(<?php echo e(($stats[$key] ?? 0) * 10); ?>%, 100%)"></div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>

      

      
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <div class="glass-card p-8">
          <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
              <span class="material-symbols-rounded text-2xl text-indigo-600 animate-spin-slow">dns</span>
              Servers (<?php echo e(count($servers)); ?>)
            </h2>
              <a href="<?php echo e(route('servers')); ?>" wire:navigate class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 text-sm">
                <span class="material-symbols-rounded text-sm">arrow_forward</span> View All
              </a>
            </div>
            <div class="space-y-4 max-h-96 overflow-y-auto">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $servers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $server): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="group bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-white/50 hover:bg-white hover:shadow-xl hover:scale-[1.02] transition-all duration-300 cursor-pointer hover:border-indigo-200" wire:navigate.hover="$toggle('server-<?php echo e($server['id']); ?>')">
                  <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-4">
                      <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <span class="material-symbols-rounded text-white text-lg"><?php echo e($server['status'] === 'spike' ? 'warning' : 'check_circle'); ?></span>
                      </div>
                      <div>
                        <h4 class="font-bold text-xl text-gray-800 group-hover:text-indigo-600 transition-colors"><?php echo e($server['name']); ?></h4>
                        <p class="text-sm text-gray-500"><?php echo e($server['ip']); ?> • <?php echo e($server['os']); ?></p>
                      </div>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-bold <?php echo e($server['status'] === 'spike' ? 'bg-red-100 text-red-700 animate-pulse' : 'bg-emerald-100 text-emerald-700'); ?> shadow-sm">
                      <?php echo e(ucfirst($server['status'])); ?>

                    </span>
                  </div>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($server['latestMetrics'])): ?>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                      <?php 
                        $metrics = ['cpu_usage' => ['CPU', $server['cpu_threshold'], 'blue'], 'ram_usage' => ['RAM', $server['ram_threshold'], 'purple'], 'disk_usage' => ['Disk', $server['disk_threshold'], 'yellow']];
                      ?>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="text-center group/metrics">
                          <p class="text-xs text-gray-500 uppercase font-medium tracking-wide mb-1"><?php echo e($info[0]); ?></p>
                          <p class="font-mono font-bold text-lg <?php echo e($server['latestMetrics'][$key] > $info[1] ? 'text-red-600 animate-pulse' : 'text-gray-800'); ?>">
                            <?php echo e($server['latestMetrics'][$key]); ?>%
                          </p>
                          <div class="w-full bg-gray-200 rounded-full h-2 mt-1 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-1000 bg-gradient-to-r <?php echo e($server['latestMetrics'][$key] > $info[1] ? 'from-red-500 to-red-700 shadow-red-500/50' : $info[2].'-500 shadow-'.$info[2].'-500/50'); ?>" style="width: <?php echo e(min($server['latestMetrics'][$key], 100)); ?>%"></div>
                          </div>
                          <p class="text-xs text-gray-400 mt-1">Max <?php echo e($info[1]); ?>%</p>
                        </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-16 text-gray-400">
                  <span class="material-symbols-rounded text-6xl opacity-30 mb-6 block">server_off</span>
                  <p class="text-lg font-medium mb-2">No servers configured</p>
                  <a href="<?php echo e(route('servers')); ?>" wire:navigate class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 text-sm">
                    <span class="material-symbols-rounded text-sm">add</span> Add First Server
                  </a>
                </div>
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
          </div>

        <div class="glass-card p-8">
          <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
              <span class="material-symbols-rounded text-2xl text-purple-600">storage</span>
              Databases (<?php echo e(count($databases)); ?>)
            </h2>
            <a href="<?php echo e(route('databases')); ?>" wire:navigate class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 text-sm">
              <span class="material-symbols-rounded text-sm">arrow_forward</span> View All
            </a>
          </div>
          <div class="space-y-4 max-h-96 overflow-y-auto">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $databases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $db): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <div class="group bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-white/50 hover:bg-white hover:shadow-xl hover:scale-[1.02] transition-all duration-300 cursor-pointer">
                <div class="flex items-start justify-between mb-4">
                  <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
                      <span class="material-symbols-rounded text-white text-lg"><?php echo e($db['status'] === 'spike' ? 'warning' : 'check_circle'); ?></span>
                    </div>
                    <div>
                      <h4 class="font-bold text-xl text-gray-800 group-hover:text-purple-600 transition-colors"><?php echo e($db['name']); ?></h4>
                      <p class="text-sm text-gray-500"><?php echo e($db['type']); ?> • <?php echo e($db['host']); ?>:<?php echo e($db['port']); ?></p>
                    </div>
                  </div>
                  <span class="px-4 py-2 rounded-full text-sm font-bold shadow-sm <?php echo e($db['status'] === 'spike' ? 'bg-red-100 text-red-700 animate-pulse' : 'bg-emerald-100 text-emerald-700'); ?>">
                    <?php echo e(ucfirst($db['status'])); ?>

                  </span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($db['latestMetrics'])): ?>
                  <div class="grid grid-cols-1 gap-3">
                    <div class="flex justify-between items-center p-3 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl">
                      <span class="text-sm font-medium text-emerald-700">Active</span>
                      <span class="font-bold text-lg <?php echo e($db['latestMetrics']['active_count'] > $db['active_threshold'] ? 'text-red-600' : 'text-emerald-700'); ?>"><?php echo e(number_format($db['latestMetrics']['active_count'])); ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl">
                      <span class="text-sm font-medium text-blue-700">Idle</span>
                      <span class="font-bold text-lg text-blue-700"><?php echo e(number_format($db['latestMetrics']['idle_count'])); ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gradient-to-r from-red-50 to-rose-50 rounded-xl <?php echo e($db['latestMetrics']['locked_count'] > $db['lock_threshold'] ? 'animate-pulse ring-2 ring-red-200' : ''); ?>">
                      <span class="text-sm font-medium text-red-700">Locked</span>
                      <span class="font-bold text-lg text-red-700"><?php echo e(number_format($db['locked_count'])); ?></span>
                    </div>
                  </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <div class="text-center py-16 text-gray-400">
                <span class="material-symbols-rounded text-6xl opacity-30 mb-6 block">database</span>
                <p class="text-lg font-medium mb-2">No databases configured</p>
                <a href="<?php echo e(route('databases')); ?>" wire:navigate class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 text-sm">
                  <span class="material-symbols-rounded text-sm">add</span> Add First Database
                </a>
              </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
        </div>
      </div>

      
      <div class="glass-card p-8">
        <div class="flex justify-between items-center mb-8">
          <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
            <span class="material-symbols-rounded text-2xl text-rose-600">notifications</span>
            Recent Alerts (<?php echo e(count($recentAlerts) ?? 0); ?>)
          </h2>
          <a href="<?php echo e(route('audit-logs')); ?>" wire:navigate class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 text-sm">
            View Audit Logs
          </a>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($recentAlerts) > 0): ?>
          <div class="overflow-x-auto rounded-2xl border border-gray-200/50">
            <table class="w-full border-collapse">
              <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-white/50 backdrop-blur-sm sticky top-0 z-10">
                  <th class="text-left p-4 font-semibold text-gray-700 border-b border-gray-200">Time</th>
                  <th class="p-4 font-semibold text-gray-700 border-b border-gray-200 text-center">Type</th>
                  <th class="p-4 font-semibold text-gray-700 border-b border-gray-200">Entity</th>
                  <th class="p-4 font-semibold text-gray-700 border-b border-gray-200 text-center">Status</th>
                  <th class="p-4 font-semibold text-gray-700 border-b border-gray-200">Message</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100/50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentAlerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr class="group hover:bg-white/60 transition-all duration-200 hover:shadow-md">
                    <td class="font-mono text-sm text-gray-600 py-4 px-4"><?php echo e(\Carbon\Carbon::parse($alert['created_at'])->format('H:i:s')); ?></td>
                    <td class="text-center">
                      <span class="px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r <?php echo e($alert['type'] === 'server' ? 'from-blue-100 to-indigo-100 text-blue-800' : 'from-purple-100 to-pink-100 text-purple-800'); ?> shadow-sm">
                        <?php echo e(ucfirst($alert['type'])); ?>

                      </span>
                    </td>
                    <td class="font-medium text-gray-800 py-4 px-4 max-w-xs truncate" title="<?php echo e($alert['alertable']['name'] ?? 'Unknown'); ?>">
                      <?php echo e($alert['alertable']['name'] ?? 'N/A'); ?>

                    </td>
                    <td class="text-center">
                      <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo e($alert['status'] === 'spike' ? 'bg-gradient-to-r from-red-100 to-rose-100 text-red-800 shadow-md animate-pulse' : 'bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 shadow-sm'); ?>">
                        <?php echo e(ucfirst($alert['status'])); ?>

                      </span>
                    </td>
                    <td class="text-sm text-gray-600 py-4 px-4 max-w-md" title="<?php echo e($alert['message']); ?>">
                      <?php echo e(\Illuminate\Support\Str::limit($alert['message'], 80)); ?>

                    </td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="text-center py-20 text-gray-400 bg-gradient-to-b from-white/50 rounded-3xl">
            <span class="material-symbols-rounded text-8xl opacity-20 mb-8 block">notifications_off</span>
            <h3 class="text-2xl font-bold text-gray-500 mb-2">All Clear!</h3>
            <p class="text-lg mb-6">No alerts in the last 24 hours</p>
            <div class="inline-flex bg-emerald-100 text-emerald-800 px-6 py-3 rounded-2xl font-semibold shadow-lg animate-bounce">
              <span class="material-symbols-rounded mr-2">check_circle</span>
              System Healthy
            </div>
          </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>

      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12 pt-12 border-t border-gray-200/50">
        <div class="glass-card p-8 text-center group hover:scale-105 transition-all duration-300">
          <a href="<?php echo e(route('servers')); ?>" wire:navigate class="block">
            <span class="material-symbols-rounded text-4xl text-indigo-600 group-hover:rotate-12 transition-transform duration-500 mb-4 block mx-auto">dns</span>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Manage Servers</h3>
            <p class="text-gray-600">Full server monitoring & configuration</p>
          </a>
        </div>
        <div class="glass-card p-8 text-center group hover:scale-105 transition-all duration-300">
          <a href="<?php echo e(route('databases')); ?>" wire:navigate class="block">
            <span class="material-symbols-rounded text-4xl text-purple-600 group-hover:rotate-12 transition-transform duration-500 mb-4 block mx-auto">storage</span>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Database Health</h3>
            <p class="text-gray-600">Query performance & connection monitoring</p>
          </a>
        </div>
        <div class="glass-card p-8 text-center group hover:scale-105 transition-all duration-300">
          <button wire:click="refresh" class="block w-full">
            <span class="material-symbols-rounded text-4xl text-emerald-600 group-hover:rotate-180 transition-transform duration-500 mb-4 block mx-auto">refresh</span>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Force Refresh</h3>
            <p class="text-gray-600">Update all metrics now</p>
          </button>
        </div>
      </div>
    </div>
  </div>
  <template x-teleport="body">
    <script>
      Livewire.hook('morph.updated', () => {
        document.getElementById('last-refresh').textContent = new Date().toLocaleTimeString();
      });
    </script>
  </template>
</div>
<?php /**PATH C:\laragon\www\web\APPS-MONITORING\resources\views/livewire/dashboard.blade.php ENDPATH**/ ?>