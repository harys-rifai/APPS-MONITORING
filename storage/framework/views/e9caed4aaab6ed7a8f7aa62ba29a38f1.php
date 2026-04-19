<?php $__env->startSection('title', 'Databases'); ?>
<div class="glass-card" wire:poll.10s>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Database Management</h2>
            <button wire:click="openModal()" class="btn-soft flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Database
            </button>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo e(session('message')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="mb-4">
            <div class="relative max-w-md">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search databases..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
        </div>

        <div class="overflow-x-auto">
<table class="w-full table-auto min-w-[700px]">
                    <thead>
                        <tr class="text-left text-xs uppercase text-gray-500 border-b border-gray-200 font-semibold tracking-wider">
                            <th class="pb-2 px-3">Name</th>
                            <th class="pb-2 px-3">Type</th>
                            <th class="pb-2 px-3">Host</th>
                            <th class="pb-2 px-3 text-center">Active</th>
                            <th class="pb-2 px-3 text-center">Idle</th>
                            <th class="pb-2 px-3 text-center">Locked</th>
                            <th class="pb-2 px-3 text-center">Status</th>
                            <th class="pb-2 px-3 text-center">Action</th>
                            <th class="pb-2 px-3 text-right">
                                
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $databases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $db): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-3">
                                    <div>
                                        <p class="text-xs font-medium text-gray-800 truncate"><?php echo e($db->name); ?></p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($db->server): ?>
                                            <p class="text-xs text-gray-500 truncate"><?php echo e($db->server->name); ?></p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-2 px-3">
                                    <span class="px-1.5 py-0.5 rounded text-xs bg-purple-100 text-purple-700 uppercase"><?php echo e($db->type); ?></span>
                                </td>
                                <td class="py-2 px-3 text-xs text-gray-600 truncate"><?php echo e($db->host); ?>:<?php echo e($db->port); ?></td>
                                <td class="py-2 px-3 text-center text-xs font-semibold <?php echo e(($db->realtime_stats['active'] ?? 0) >= $db->active_threshold ? 'text-red-600' : 'text-gray-700'); ?>">
                                        <?php echo e($db->realtime_stats['active'] ?? 0); ?>

                                    </span>
                                </td>
                                <td class="py-2 px-3 text-center text-xs <?php echo e(($db->realtime_stats['idle'] ?? 0) >= $db->idle_threshold ? 'text-yellow-600' : 'text-gray-700'); ?>">
                                        <?php echo e($db->realtime_stats['idle'] ?? 0); ?>

                                    </span>
                                </td>
                                <td class="py-2 px-3 text-center text-xs text-gray-700"><?php echo e($db->realtime_stats['locked'] ?? 0); ?></td>
                                <td class="py-2 px-3 text-center">
                                    <span class="px-1.5 py-0.5 rounded text-xs font-medium <?php echo e(($db->is_reachable ?? false) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                                        <?php echo e(($db->is_reachable ?? false) ? 'Online' : 'Offline'); ?>

                                    </span>
                                </td>
                                <td class="py-3 text-right">
                                        <div class="flex gap-1 justify-end items-center">
                                            <a href="<?php echo e(route('database.monitor', $db->id)); ?>" class="text-indigo-600 hover:text-indigo-800 p-0.5 rounded-sm hover:bg-indigo-100" title="Monitor">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                            </a>
                                            <button wire:click="openModal(<?php echo e($db->id); ?>)" class="text-blue-600 hover:text-blue-800 p-0.5 rounded-sm hover:bg-blue-100" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button wire:click="confirmDelete(<?php echo e($db->id); ?>)" class="text-red-600 hover:text-red-800 p-0.5 rounded-sm hover:bg-red-100" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-4">
                    <?php if (isset($component)) { $__componentOriginal3011b99be13bef0563dbf9d28356e4b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3011b99be13bef0563dbf9d28356e4b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tailwind-pagination','data' => ['links' => $databases]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tailwind-pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($databases)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3011b99be13bef0563dbf9d28356e4b5)): ?>
<?php $attributes = $__attributesOriginal3011b99be13bef0563dbf9d28356e4b5; ?>
<?php unset($__attributesOriginal3011b99be13bef0563dbf9d28356e4b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3011b99be13bef0563dbf9d28356e4b5)): ?>
<?php $component = $__componentOriginal3011b99be13bef0563dbf9d28356e4b5; ?>
<?php unset($__componentOriginal3011b99be13bef0563dbf9d28356e4b5); ?>
<?php endif; ?>
                </div>
            </div>
        </div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showModal): ?>
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                <div class="fixed inset-0" wire:click="closeModal"></div>
                <div class="bg-white rounded-xl p-6 w-full max-w-md border border-gray-200 shadow-lg relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-100 rounded-lg">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold"><?php echo e($databaseId ? 'Edit Database' : 'Add Database'); ?></h3>
                        </div>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="save" wire:loading.attr="disabled">
                        <div class="space-y-2">
                            <div>
<label class="block text-xs text-gray-600 mb-1">Organisation</label>
                                <select wire:model="organisation_id" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" <?php $__errorArgs = ['organisation_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                                    <option value="">Select organisation</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['organisation_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\organisation::whereRaw('is_active = true')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($organisation->id); ?>"><?php echo e($organisation->name); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Name</label>
                                <input type="text" wire:model="name" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:border-indigo-500" <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Type</label>
                                    <select wire:model="type" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:border-blue-500">
                                        <option value="postgres">PostgreSQL</option>
                                        <option value="mysql">MySQL</option>
                                        <option value="sqlserver">SQL Server</option>
                                        <option value="db2">DB2</option>
                                        <option value="oracle">Oracle</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Server</label>
                                    <select wire:model="server_id" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:border-blue-500">
                                        <option value="">None</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\Server::whereRaw('is_active = true')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $server): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($server->id); ?>"><?php echo e($server->name); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Host</label>
                                    <input type="text" wire:model="host" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:border-indigo-500" <?php $__errorArgs = ['host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Port</label>
                                    <input type="number" wire:model="port" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Username</label>
                                    <input type="text" wire:model="username" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Password</label>
                                    <input type="password" wire:model="password" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Database Name</label>
                                <input type="text" wire:model="database" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Active</label>
                                    <input type="number" wire:model="active_threshold" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Idle</label>
                                    <input type="number" wire:model="idle_threshold" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Locked</label>
                                <input type="number" wire:model="lock_threshold" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" wire:model="is_active" class="rounded bg-gray-50 border-gray-200">
                                    <span class="text-xs text-gray-600">Active</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg" wire:loading.attr="disabled">Cancel</button>
                            <button type="submit" class="btn-soft w-full" wire:loading.attr="disabled">
                                <div wire:loading wire:target="save" class="animate-spin h-4 w-4 text-white mr-2" fill="none">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 6.627 12 14s6.627 14 14 14v-4a8 8 0 01-8 8H4z"></path>
                                </div>
                                <span wire:loading.remove>Saving...</span>
                                <span wire:loading.delay.remove wire:target="save">Save</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDeleteModal): ?>
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                <div class="fixed inset-0 bg-black/30" wire:click="cancelDelete"></div>
                <div class="bg-white rounded-xl p-4 w-full max-w-sm border border-gray-200 shadow-lg relative z-10">
                    <div class="text-center">
                        <div class="p-2 bg-red-100 rounded-full mx-auto w-10 h-10 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold mb-2">Delete Database</h3>
                        <p class="text-gray-600 text-sm mb-4">Are you sure? This action cannot be undone.</p>
                        <div class="flex justify-center gap-2">
                            <button wire:click="cancelDelete" class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm">Cancel</button>
                            <button wire:click="executeDelete" class="px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH F:\www\APPS-MONITORING\resources\views/livewire/database-list.blade.php ENDPATH**/ ?>