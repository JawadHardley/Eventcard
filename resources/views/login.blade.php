<x-guest-layout>

    @section('title', 'Sign In')

    <div class="auth-page tap-hero">
        <div class="auth-card fade-up">
            <div class="text-center mb-8">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm bg-gray-900 dark:bg-red-900/30">
                        <img src="{{ asset('storage/logos/logo1.png') }}" alt="Tapeventcard Logo">
                    </div>
                </div>
                <h1 class="dark-txt font-display text-2xl font-bold">Welcome back</h1>
                <p class="dark-sub text-sm mt-1">Sign in to your TapEventCard account</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="space-y-4">

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input @error('email') border-red-500 @enderror"
                            value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror

                    </div>
                    <div>
                        <label class="form-label">Password</label>
                        <input type="password" name="password"
                            class="form-input @error('password') border-red-500 @enderror" required
                            placeholder="········">
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="flex items-center justify-between text-sm mb-2">
                        <label class="flex items-center gap-2 cursor-pointer dark-sub">
                            <input type="checkbox" name="remember" class="accent-[#e8120a] w-4 h-4 rounded-md">
                            <span>Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-[#e8120a] font-medium hover:underline">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-red btn-lg w-full">Sign In</button>
                </div>
            </form>

            <div class="text-center mt-6 text-sm dark-sub">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-[#e8120a] font-semibold hover:underline">Create one</a>
            </div>
        </div>
    </div>
</x-guest-layout>
