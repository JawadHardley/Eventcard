<x-guest-layout>

    <div class="auth-page tap-hero">
        <div class="auth-card fade-up">
            <div class="text-center mb-8">
                <div class="w-10 h-10 rounded-xl bg-[#e8120a] flex items-center justify-center mx-auto mb-4">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="white" stroke-width="2" />
                        <circle cx="12" cy="12" r="3" fill="white" />
                    </svg>
                </div>
                <h1 class="dark-txt font-display text-2xl font-bold">Welcome back</h1>
                <p class="dark-sub text-sm mt-1">Sign in to your TapEventCard account</p>
            </div>
            <form class="space-y-4">
                <div><label class="form-label">Email</label><input type="email" class="form-input"
                        placeholder="jawad@tapeventcard.com" required></div>
                <div><label class="form-label">Password</label><input type="password" class="form-input"
                        placeholder="········" required></div>
                <div class="flex items-center justify-between text-sm mb-2">
                    <label class="flex items-center gap-2 cursor-pointer dark-sub">
                        <input type="checkbox" class="accent-[#e8120a] w-4 h-4 rounded-md"> Remember me
                    </label>
                    <a href="#" class="text-[#e8120a] font-medium hover:underline">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-red btn-lg w-full">Sign In</button>
            </form>
            <div class="text-center mt-6 text-sm dark-sub">
                Don’t have an account? <a href="/register" class="text-[#e8120a] font-semibold hover:underline">Create
                    one</a>
            </div>
        </div>
    </div>
</x-guest-layout>
