<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'DB Monitoring')); ?></title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

        <style>
            :root {
                --brand-500: #6366f1;
                --brand-600: #4f46e5;
                --brand-700: #4338ca;
            }
            
            body {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                min-height: 100vh;
            }
            
            /* Horizon UI Card */
            .glass-card {
                background: #ffffff;
                border-radius: 1rem;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                border: 1px solid rgba(226, 232, 240, 0.8);
            }
            
            /* Horizon Header */
            .glass-header {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(8px);
                border-bottom: 1px solid #e2e8f0;
            }
            
            /* Horizon Buttons */
            .btn-soft {
                background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
                color: white;
                padding: 0.625rem 1.25rem;
                border-radius: 0.75rem;
                font-weight: 600;
                font-size: 0.875rem;
                letter-spacing: 0.025em;
                transition: all 0.3s ease;
                box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4);
            }
            .btn-soft:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.5);
            }
            
            /* Horizon Table */
            .soft-table {
                width: 100%;
                border-collapse: collapse;
            }
            .soft-table thead th {
                background: #f9fafb;
                color: #6b7280;
                font-weight: 600;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                padding: 1rem;
                text-align: left;
                border-bottom: 1px solid #e5e7eb;
            }
            .soft-table tbody td {
                padding: 1rem;
                color: #374151;
                font-size: 0.875rem;
                border-bottom: 1px solid #f3f4f6;
            }
            .soft-table tbody tr:hover {
                background: #f9fafb;
            }
            
            /* Horizon Badges */
            .badge-success {
                background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
                color: #065f46;
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.75rem;
                font-weight: 600;
            }
            .badge-warning {
                background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
                color: #92400e;
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.75rem;
                font-weight: 600;
            }
            .badge-danger {
                background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
                color: #991b1b;
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.75rem;
                font-weight: 600;
            }
            .badge-info {
                background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
                color: #1e40af;
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.75rem;
                font-weight: 600;
            }
            
            /* Horizon Input */
            .soft-input {
                border: 1px solid #e5e7eb;
                border-radius: 0.75rem;
                padding: 0.625rem 1rem;
                font-size: 0.875rem;
                transition: all 0.2s ease;
                background: #ffffff;
            }
            .soft-input:focus {
                outline: none;
                border-color: #6366f1;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            }
            
            /* Horizon Sidebar */
            .sidebar-item {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                padding: 0.75rem;
                margin-bottom: 0.25rem;
                border-radius: 0.75rem;
                color: #94a3b8;
                transition: all 0.2s ease;
                cursor: pointer;
            }
            .sidebar-item:hover {
                background: rgba(255, 255, 255, 0.1);
                color: white;
            }
            .sidebar-item.active {
                background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
                color: white;
                box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4);
            }
            .sidebar-item::after {
                content: attr(data-label);
                position: absolute;
                left: 100%;
                margin-left: 0.75rem;
                padding: 0.5rem 0.75rem;
                background-color: #0f172a;
                color: white;
                font-size: 0.75rem;
                border-radius: 0.5rem;
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
            
            /* Horizon Modal */
            .soft-modal {
                background: white;
                border-radius: 1.5rem;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }
        </style>
    </head>
<body class="font-sans antialiased overflow-hidden">
    <?php echo $__env->yieldPushContent('modals'); ?>
    <div class="flex min-h-screen bg-gray-50">
        <nav id="sidebar" class="flex flex-col transition-all duration-300 shadow-xl" style="width: 4rem; background-color: #1e293b;">
            <div class="h-16 flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                    </svg>
                </a>
            </div>

                <div class="flex-1 py-4">
                    <div class="space-y-1 px-2">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view dashboard')): ?>
                        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('dashboard'),'active' => request()->routeIs('dashboard'),'class' => 'sidebar-item','dataLabel' => ''.e(__('Dashboard')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('dashboard')),'class' => 'sidebar-item','data-label' => ''.e(__('Dashboard')).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                        <?php endif; ?>
                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view servers')): ?>
                        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('servers'),'active' => request()->routeIs('servers'),'class' => 'sidebar-item','dataLabel' => ''.e(__('Servers')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('servers')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('servers')),'class' => 'sidebar-item','data-label' => ''.e(__('Servers')).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view databases')): ?>
                        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('databases'),'active' => request()->routeIs('databases'),'class' => 'sidebar-item','dataLabel' => ''.e(__('Databases')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('databases')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('databases')),'class' => 'sidebar-item','data-label' => ''.e(__('Databases')).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view organisations')): ?>
                        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('organisations'),'active' => request()->routeIs('organisations'),'class' => 'sidebar-item','dataLabel' => ''.e(__('Organisations')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('organisations')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('organisations')),'class' => 'sidebar-item','data-label' => ''.e(__('Organisations')).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view users')): ?>
                        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('users'),'active' => request()->routeIs('users'),'class' => 'sidebar-item','dataLabel' => ''.e(__('Users')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('users')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('users')),'class' => 'sidebar-item','data-label' => ''.e(__('Users')).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view audit logs')): ?>
                        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('audit-logs'),'active' => request()->routeIs('audit-logs'),'class' => 'sidebar-item','dataLabel' => ''.e(__('Audit Logs')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('audit-logs')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('audit-logs')),'class' => 'sidebar-item','data-label' => ''.e(__('Audit Logs')).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="p-2 border-t border-gray-200">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="sidebar-item" data-label="<?php echo e(Auth::user()->name); ?>">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </button>
                        <div x-show="open" @click.outside="open = false" class="absolute bottom-full left-0 mb-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50" style="display: none;">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <p class="text-sm font-medium text-gray-800"><?php echo e(Auth::user()->name); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e(Auth::user()->email); ?></p>
                            </div>
                            <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><?php echo e(__('Profile')); ?></a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <div class="px-4 py-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest"><?php echo e(__('Language')); ?></div>
                            <div class="flex items-center px-4 py-1 gap-2">
                                <a href="<?php echo e(route('language.switch', 'en')); ?>" class="px-2 py-0.5 rounded text-[10px] font-bold <?php echo e(app()->getLocale() == 'en' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>">EN</a>
                                <a href="<?php echo e(route('language.switch', 'id')); ?>" class="px-2 py-0.5 rounded text-[10px] font-bold <?php echo e(app()->getLocale() == 'id' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>">ID</a>
                            </div>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><?php echo e(__('Log Out')); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="px-2 py-3 border-t border-gray-200 flex flex-col items-center justify-center opacity-60">
                    <span class="text-[7px] font-bold text-gray-400 uppercase tracking-tighter mb-0.5">Ver.</span>
                    <span class="text-[9px] font-medium text-gray-500"><?php echo e($appVersion); ?></span>
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
                            <?php echo $__env->yieldContent('title', 'Dashboard'); ?>
                        </h1>
                    </div>

                </header>

                <main id="main-content" class="flex-1 p-6">
                    <?php echo e($slot); ?>

                </main>
            </div>
        </div>

        </div>

        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

        <script>
        document.addEventListener('livewire:navigated', () => {
            document.body.classList.remove('overflow-hidden');
        });

        Livewire.on('modalOpened', () => {
            document.body.classList.add('overflow-hidden');
        });

        Livewire.on('modalClosed', () => {
            document.body.classList.remove('overflow-hidden');
        });
        </script>
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

            // Astro enhancements
            function createStars() {
                const container = document.body;
                if (!container) return;

                const starsContainer = document.createElement('div');
                starsContainer.className = 'astro-stars';
                container.appendChild(starsContainer);

                for (let i = 0; i < 50; i++) {
                    const star = document.createElement('div');
                    star.className = 'astro-star';
                    star.style.left = Math.random() * 100 + '%';
                    star.style.top = Math.random() * 100 + '%';
                    star.style.width = (Math.random() * 3 + 1) + 'px';
                    star.style.height = star.style.width;
                    star.style.animationDelay = Math.random() * 2 + 's';
                    starsContainer.appendChild(star);
                }
            }

            function createMeteor() {
                const container = document.body;
                if (!container) return;

                const meteor = document.createElement('div');
                meteor.className = 'meteor-shower';
                meteor.style.animationDelay = Math.random() * 5 + 's';
                container.appendChild(meteor);

                setTimeout(() => {
                    meteor.remove();
                }, 3000);
            }

            // Initialize astro effects
            document.addEventListener('DOMContentLoaded', () => {
                createStars();
                setInterval(createMeteor, 10000); // Less frequent meteors for dashboard
            });
        </script>

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
<?php /**PATH F:\www\APPS-MONITORING\resources\views/layouts/app.blade.php ENDPATH**/ ?>