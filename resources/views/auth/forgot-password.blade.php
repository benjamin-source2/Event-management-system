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
                <p class="text-gray-400 mt-3 text-sm">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}</p>
            </div>

            <!-- Forgot Password Card -->
            <div class="event-card-bg p-8 md:p-10">
                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                @if(session('reset_url'))
                    <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl">
                        <p class="text-emerald-400 text-sm font-medium mb-2">✅ Password reset link generated! Click below to reset your password:</p>
                        <a href="{{ session('reset_url') }}" class="block w-full text-center px-4 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-emerald-500/30">
                            Reset My Password
                        </a>
                        <p class="text-gray-500 text-xs mt-2">Or copy this link: <code class="text-emerald-400 break-all">{{ session('reset_url') }}</code></p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="input-group">
                        <x-input-label for="email" :value="__('Email')" />
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-primary-300/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <x-text-input id="email" class="block w-full pl-12" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full text-base font-semibold group gap-2">
                        <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ __('Send Password Reset Link') }}
                    </button>

                    <!-- Back to Login -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/10"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 text-gray-400">Remember your password?</span>
                        </div>
                    </div>

                    <a href="{{ route('login') }}"
                       class="btn-secondary w-full text-base font-semibold inline-flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        {{ __('Back to Sign In') }}
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
