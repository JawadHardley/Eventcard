<x-guest-layout>

    @section('title', 'Create Account')

    <div class="auth-page tap-hero">
        <div class="auth-card fade-up">
            <div class="text-center mb-8">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm bg-gray-900 dark:bg-red-900/30">
                        <img src="{{ asset('storage/logos/logo1.png') }}" alt="Tapeventcard Logo">
                    </div>
                </div>
                <h1 class="dark-txt font-display text-2xl font-bold">Create an account</h1>
                <p class="dark-sub text-sm mt-1">Start building unforgettable invitations</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-input @error('name') border-red-500 @enderror"
                            value="{{ old('name') }}" required autofocus placeholder="Jawad Mwinyi">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input @error('email') border-red-500 @enderror"
                            value="{{ old('email') }}" required placeholder="you@example.com">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Password</label>
                        <input type="password" name="password"
                            class="form-input @error('password') border-red-500 @enderror" required
                            placeholder="Min. 8 characters">
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-input" required
                            placeholder="Same as above">
                    </div>
                    <div class="flex items-center gap-2 text-sm dark-sub mb-2">
                        <input type="checkbox" id="terms" class="accent-[#e8120a] w-4 h-4 rounded-md" required>
                        <label for="terms">I agree to the
                            <a href="#" class="text-[#e8120a] font-medium hover:underline">Terms</a> and
                            <a href="#" class="text-[#e8120a] font-medium hover:underline">Privacy Policy</a>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-red btn-lg w-full">Create Account</button>
                </div>
            </form>

            <div class="text-center mt-6 text-sm dark-sub">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#e8120a] font-semibold hover:underline">Sign in</a>
            </div>
        </div>
    </div>
</x-guest-layout>
