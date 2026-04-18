<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DB Monitoring') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-['figtree'] antialiased overflow-hidden">
        <!-- Animated Background Particles -->
        <div class="fixed inset-0 pointer-events-none z-0">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-purple-900/30 dark:to-slate-900"></div>
            <div id="particles" class="absolute inset-0 opacity-20 dark:opacity-30"></div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            <!-- Logo -->
            <div class="mb-8 text-center animate-float">
                <div class="inline-flex items-center gap-3 bg-white/80 backdrop-blur-sm px-6 py-3 rounded-2xl shadow-2xl border border-white/50">
                    <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-gray-800 to-slate-800 bg-clip-text text-transparent">DB Monitor</h1>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Real-time server & database monitoring</p>
                    </div>
                </div>
            </div>

            <!-- Login Card -->
            <div class="w-full max-w-md">
                <div class="login-glass-card p-8 sm:p-10">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-12 text-center text-sm text-slate-500 dark:text-slate-400">
                <p>&copy; 2024 DB Monitor. All rights reserved.</p>
            </div>
        </div>

        <script>
            // Floating animation for logo
            const floatElements = document.querySelectorAll('.animate-float');
            floatElements.forEach(el => {
                el.style.animation = 'float 6s ease-in-out infinite';
            });

            // Particles animation
            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                for (let i = 0; i < 50; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'w-1 h-1 bg-indigo-300/50 rounded-full absolute animate-pulse';
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.top = Math.random() * 100 + '%';
                    particle.style.animationDelay = Math.random() * 10 + 's';
                    particle.style.animationDuration = (Math.random() * 20 + 10) + 's';
                    particlesContainer.appendChild(particle);
                }
            }
            createParticles();
        </script>

        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
        </style>
    </body>
</html>

