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
        
        <style>
            :root {
                --brand-500: #6366f1;
                --brand-600: #4f46e5;
            }
            
            body {
                background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
                min-height: 100vh;
            }
            
            .glass-card {
                background: #ffffff;
                border-radius: 1.5rem;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                border: 1px solid rgba(255, 255, 255, 0.8);
            }
            
            .horizon-input {
                border: 1px solid #e5e7eb;
                border-radius: 0.75rem;
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                transition: all 0.2s ease;
                background: #f9fafb;
            }
            .horizon-input:focus {
                outline: none;
                border-color: #6366f1;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
                background: white;
            }
            
            .horizon-btn {
                background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
                color: white;
                padding: 0.75rem 1.5rem;
                border-radius: 0.75rem;
                font-weight: 600;
                font-size: 0.875rem;
                transition: all 0.3s ease;
                box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4);
            }
            .horizon-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.5);
            }
            
            .checkbox-custom {
                width: 1.25rem;
                height: 1.25rem;
                border-radius: 0.375rem;
                border: 1px solid #d1d5db;
                accent-color: #6366f1;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-6">
                <a href="/">
                    <span class="text-2xl font-bold text-gray-800" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">DB Monitor</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 glass-card">
                <?php echo e($slot); ?>

            </div>
        </div>
    </body>
</html><?php /**PATH F:\www\APPS-MONITORING\resources\views/layouts/guest.blade.php ENDPATH**/ ?>