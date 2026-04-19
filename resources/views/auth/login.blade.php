<x-guest-layout>
    <div class="text-center mb-6">
        <x-auth-session-status class="inline-block mb-4 mx-auto max-w-md" :status="session('status')" />
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                class="horizon-input w-full"
                placeholder="name@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-500" />
        </div>

        <div class="relative">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="relative">
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password" 
                    class="horizon-input w-full pr-10"
                    placeholder="••••••••">
                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" onclick="togglePassword()">
                    <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-.77 2.255-2.115 4.013-3.826 5.11M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-500" />
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="checkbox-custom" name="remember">
                <span class="text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 pt-2">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="flex-1 text-center py-3 text-sm text-gray-500 hover:text-gray-700 rounded-lg border border-gray-200 hover:border-gray-300 transition-colors">
                    Forgot password?
                </a>
            @endif

            <button type="submit" class="horizon-btn flex-1 text-center">
                Sign In
            </button>
        </div>
    </form>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L19.5 19.5M9.88 9.88l3.354-3.354" stroke="currentColor" fill="none" />';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-.77 2.255-2.115 4.013-3.826 5.11M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke="currentColor" fill="none" />';
            }
        }
    </script>
</x-guest-layout>