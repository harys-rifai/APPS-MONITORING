<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo e(config('app.name', 'Laravel')); ?></title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

        <style>
            :root { --primary-color: #6366f1; }
            body { background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); min-height: 100vh; }
            .glass-card { background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.5); border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03); }
            .glass-header { background: rgba(255,255,255,0.9); backdrop-filter: blur(8px); border-bottom: 1px solid rgba(226,232,240,0.8); }
            #main-wrapper { margin-left: 5rem; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <?php echo $__env->make('livewire.layout.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div id="main-wrapper">
            <div class="flex-1 flex flex-col min-h-screen">
                <header class="h-16 glass-header sticky top-0 z-40 flex items-center justify-between px-6">
                    <div class="flex items-center gap-4">
                        <h1 class="text-lg font-semibold text-gray-800"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <div id="time-display" class="text-[11px] font-bold text-indigo-600 uppercase tracking-wide bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-100 tabular-nums"></div>
                        <div class="border-l border-gray-200 h-6 mx-1"></div>
                        <div id="date-display" class="text-[11px] font-bold text-gray-500 uppercase tracking-wide"></div>
                    </div>
                </header>
                <main class="flex-1 p-6"><?php echo e($slot); ?></main>
            </div>
        </div>
        <script>
            function updateClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2,'0');
                const minutes = String(now.getMinutes()).padStart(2,'0');
                const seconds = String(now.getSeconds()).padStart(2,'0');
                const ms = String(now.getMilliseconds()).padStart(3,'0');
                const timeDisplay = document.getElementById('time-display');
                if(timeDisplay) timeDisplay.textContent = `TIME : ${hours}:${minutes}:${seconds}.${ms} WIB`;
                const dateDisplay = document.getElementById('date-display');
                if(dateDisplay) {
                    const locale = document.documentElement.lang==='id' ? 'id-ID' : 'en-GB';
                    dateDisplay.textContent = now.toLocaleDateString(locale, {weekday:'long',day:'numeric',month:'long',year:'numeric'});
                }
                requestAnimationFrame(updateClock);
            }
            updateClock();
        </script>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    </body>
</html><?php /**PATH C:\laragon\www\web\APPS-MONITORING\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>