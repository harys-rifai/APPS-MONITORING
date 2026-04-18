<x-guest-layout>
    <div class="text-center mb-8">
        <x-auth-session-status class="inline-block mb-4 mx-auto max-w-md" :status="session('status')" />
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="relative">
            <x-text-input 
                id="email" 
                class="peer" 
                type="email" 
                name="email" 
                placeholder=" " 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" />
            <x-input-label for="email" :value="__('Email')" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative mt-2">
            <x-text-input 
                id="password" 
                class="peer" 
                type="password" 
                name="password" 
                placeholder=" " 
                required 
                autocomplete="current-password" />
            <x-input-label for="password" :value="__('Password')" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center space-x-2 cursor-pointer group">
                <input id="remember_me" type="checkbox" class="w-4 h-4 text-indigo-600 bg-white/80 backdrop-blur-sm border-slate-300 rounded focus:ring-indigo-500 shadow-sm cursor-pointer transition-all hover:scale-110" name="remember">
                <span class="text-sm text-slate-700 dark:text-slate-300 font-medium group-hover:text-slate-900">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 pt-4">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="flex-1 btn-secondary text-indigo-700 hover:text-indigo-800 font-medium text-sm transition-colors group-hover:no-underline">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="flex-1 sm:ms-0">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
