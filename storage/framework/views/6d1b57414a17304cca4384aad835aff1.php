<?php $__env->startSection('title', 'Realtime Database Monitor'); ?>
<div class="glass-card" wire:poll.5s="loadData">
    <div class="max-w-7xl mx-auto p-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Error:</strong> <?php echo e($error); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($database): ?>
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800"><?php echo e($database->name); ?></h2>
                <p class="text-gray-500"><?php echo e($database->host); ?>:<?php echo e($database->port); ?> (<?php echo e($database->type); ?>)</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <p class="text-gray-500 text-sm">Total Connections</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo e($stats['total'] ?? 0); ?></p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <p class="text-gray-500 text-sm">Active</p>
                    <p class="text-2xl font-bold text-green-600"><?php echo e($stats['active'] ?? 0); ?></p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <p class="text-gray-500 text-sm">Idle</p>
                    <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['idle'] ?? 0); ?></p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <p class="text-gray-500 text-sm">Locked</p>
                    <p class="text-2xl font-bold text-red-600"><?php echo e($stats['locked'] ?? 0); ?></p>
                </div>
            </div>

            <!-- Database Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Database Info</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Version</span>
                            <span class="text-gray-800 font-medium"><?php echo e($info['version'] ?? '-'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Size</span>
                            <span class="text-gray-800 font-medium"><?php echo e($info['size'] ?? 0); ?> bytes</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tables</span>
                            <span class="text-gray-800 font-medium"><?php echo e($info['tables'] ?? 0); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Max Connections</span>
                            <span class="text-gray-800 font-medium"><?php echo e($info['max_connections'] ?? 0); ?></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Connection Status</h3>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full <?php echo e($isConnected ? 'bg-green-500' : 'bg-red-500'); ?>"></span>
                            <span class="text-gray-800"><?php echo e($isConnected ? 'Connected' : 'Disconnected'); ?></span>
                            <button wire:click="loadData" class="ml-auto text-indigo-600 hover:text-indigo-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Uptime</span>
                            <span class="text-gray-800 font-medium"><?php echo e($uptime); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Current Time</span>
                            <span class="text-gray-800 font-medium"><?php echo e(now()->format('l, F j, Y H:i:s')); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Connections -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6">
                <div class="p-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Active Connections (<?php echo e(count($connections)); ?>)</h3>
                </div>
                <div class="p-5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($connections) > 0): ?>
                    <div class="overflow-x-auto">
<table class="w-full table-auto min-w-[800px]">
                            <thead>
                                <tr class="text-left text-xs uppercase text-gray-500 border-b border-gray-200 font-semibold tracking-wider">
                                    <th class="pb-1.5 px-3">PID</th>
                                    <th class="pb-1.5 px-3">User</th>
                                    <th class="pb-1.5 px-3">App</th>
                                    <th class="pb-1.5 px-3">Client IP</th>
                                    <th class="pb-1.5 px-3 text-center">State</th>
                                    <th class="pb-1.5 px-3">Query</th>
                                    <th class="pb-1.5 px-3 text-right">Duration</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->getPaginatedConnections(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-1.5 px-3 text-xs text-gray-600"><?php echo e($conn['pid']); ?></td>
                                    <td class="py-1.5 px-3 text-xs text-gray-600 truncate"><?php echo e($conn['username']); ?></td>
                                    <td class="py-1.5 px-3 text-xs text-gray-600 truncate max-w-[100px]"><?php echo e($conn['application_name']); ?></td>
                                    <td class="py-1.5 px-3 text-xs text-gray-600 truncate"><?php echo e($conn['client_ip']); ?></td>
                                    <td class="py-1.5 px-3 text-center">
                                        <span class="px-1.5 py-0.5 rounded text-xs font-medium 
                                            <?php echo e($conn['state'] === 'active' ? 'bg-green-100 text-green-700' : 
                                            ($conn['state'] === 'idle' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')); ?>">
                                            <?php echo e($conn['state']); ?>

                                        </span>
                                    </td>
                                    <td class="py-1.5 px-3 text-xs text-gray-600 max-w-[200px] truncate" title="<?php echo e($conn['query']); ?>"><?php echo e($conn['query']); ?></td>
                                    <td class="py-1.5 px-3 text-xs text-gray-600 text-right"><?php echo e($conn['duration']); ?></td>
                                </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->getTotalConnectionsPages() > 1): ?>
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            Page <?php echo e($connectionsPage); ?> of <?php echo e($this->getTotalConnectionsPages()); ?>

                        </div>
                        <div class="flex gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($connectionsPage > 1): ?>
                            <button wire:click="$set('connectionsPage', <?php echo e($connectionsPage - 1); ?>)" class="px-3 py-1 text-sm rounded border border-gray-300 hover:bg-gray-50">Previous</button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($connectionsPage < $this->getTotalConnectionsPages()): ?>
                            <button wire:click="$set('connectionsPage', <?php echo e($connectionsPage + 1); ?>)" class="px-3 py-1 text-sm rounded border border-gray-300 hover:bg-gray-50">Next</button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                    <div class="text-center py-8 text-gray-500">
                        No active connections
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Tables -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6">
                <div class="p-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Tables (<?php echo e(count($tables)); ?>)</h3>
                </div>
                <div class="p-5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($tables) > 0): ?>
                    <div class="overflow-x-auto">
<table class="w-full table-auto min-w-[700px]">
                            <thead>
                                <tr class="text-left text-xs uppercase text-gray-500 border-b border-gray-200 font-semibold tracking-wider">
                                    <th class="pb-1.5 px-3">#</th>
                                    <th class="pb-1.5 px-3">Table</th>
                                    <th class="pb-1.5 px-3">Table Size</th>
                                    <th class="pb-1.5 px-3">Index Size</th>
                                    <th class="pb-1.5 px-3 text-right">Total Size</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->getPaginatedTables(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-1.5 px-3 text-xs text-gray-600"><?php echo e($table['n']); ?></td>
                                    <td class="py-1.5 px-3 text-xs font-medium text-gray-800 truncate"><?php echo e($table['name']); ?></td>
                                    <td class="py-1.5 px-3 text-xs text-gray-600 truncate"><?php echo e($table['table_size'] ?? '-'); ?></td>
                                    <td class="py-1.5 px-3 text-xs text-gray-600 truncate"><?php echo e($table['index_size'] ?? '-'); ?></td>
                                    <td class="py-1.5 px-3 text-xs font-medium text-gray-800 text-right"><?php echo e($table['total_size'] ?? '-'); ?></td>
                                </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->getTotalTablesPages() > 1): ?>
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            Page <?php echo e($tablesPage); ?> of <?php echo e($this->getTotalTablesPages()); ?>

                        </div>
                        <div class="flex gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tablesPage > 1): ?>
                            <button wire:click="$set('tablesPage', <?php echo e($tablesPage - 1); ?>)" class="px-3 py-1 text-sm rounded border border-gray-300 hover:bg-gray-50">Previous</button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tablesPage < $this->getTotalTablesPages()): ?>
                            <button wire:click="$set('tablesPage', <?php echo e($tablesPage + 1); ?>)" class="px-3 py-1 text-sm rounded border border-gray-300 hover:bg-gray-50">Next</button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                    <div class="text-center py-8 text-gray-500">
                        No tables found
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-8 text-gray-500">
                Database not found
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH F:\www\APPS-MONITORING\resources\views/livewire/realtime-database-monitor.blade.php ENDPATH**/ ?>