<x-guest-layout>
    <div class="min-h-screen hero-gradient flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8 pt-28">
        <div class="w-full max-w-md animate-fade-in relative z-10">
            <!-- Brand -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center shadow-lg shadow-primary-500/30 group-hover:shadow-primary-500/50 transition-all duration-300 group-hover:scale-105">
                        <span class="text-white font-bold text-lg">RE</span>
                    </div>
                    <span class="text-2xl font-display font-bold text-white">Rwanda EventHub</span>
                </a>
                <p class="text-gray-400 mt-3 text-sm">Welcome back! Sign in to continue</p>
            </div>

            <!-- Login Card - event-themed with no border-radius -->
            <div class="event-card-bg p-8 md:p-10">
                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="input-group">
                        <x-input-label for="email" :value="__('Email')" />
                        <div class="mt-1">
                            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="input-group">
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="mt-1">
                            <x-text-input id="password" class="block w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password"
                                        placeholder="Enter your password" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer group">
                            <input id="remember_me" type="checkbox" name="remember"
                                   class="w-4 h-4 border-gray-300 dark:border-navy-600 text-primary-500 focus:ring-primary-500 dark:bg-navy-800 dark:focus:ring-offset-navy-800 cursor-pointer">
                            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-primary-400 hover:text-primary-300 transition-colors" href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full text-base font-semibold group gap-2">
                        <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        {{ __('Sign In') }}
                    </button>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/10"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 text-gray-400">New to Rwanda EventHub?</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <a href="{{ route('register') }}"
                       class="btn-secondary w-full text-base font-semibold inline-flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        {{ __('Create an Account') }}
                    </a>
                </form>
            </div>

            <!-- Footer -->
            <p class="text-center mt-6 text-sm text-gray-500">
                &copy; {{ date('Y') }} Rwanda EventHub
            </p>
        </div>
    </div>
</x-guest-layout>
