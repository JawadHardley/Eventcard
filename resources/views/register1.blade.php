<x-guest-layout>
    {{-- <style>

    </style> --}}

    <div class="auth-page tap-hero">
        <div class="auth-card fade-up">
            <div class="text-center mb-8">
                <div class="w-10 h-10 rounded-xl bg-[#e8120a] flex items-center justify-center mx-auto mb-4">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="white" stroke-width="2" />
                        <circle cx="12" cy="12" r="3" fill="white" />
                    </svg>
                </div>
                <h1 class="dark-txt font-display text-2xl font-bold">Create an account</h1>
                <p class="dark-sub text-sm mt-1">Start building unforgettable invitations</p>
            </div>
            <form class="space-y-4">
                <div><label class="form-label">Full Name</label><input type="text" class="form-input"
                        placeholder="Jawad Mwinyi" required></div>
                <div><label class="form-label">Email</label><input type="email" class="form-input"
                        placeholder="jawad@tapeventcard.com" required></div>
                <div><label class="form-label">Password</label><input type="password" class="form-input"
                        placeholder="Min. 8 characters" required></div>
                <div><label class="form-label">Confirm Password</label><input type="password" class="form-input"
                        placeholder="Same as above" required></div>
                <div class="flex items-center gap-2 text-sm dark-sub mb-2">
                    <input type="checkbox" id="terms" class="accent-[#e8120a] w-4 h-4 rounded-md" required>
                    <label for="terms">I agree to the <a href="#"
                            class="text-[#e8120a] font-medium hover:underline">Terms</a> and <a href="#"
                            class="text-[#e8120a] font-medium hover:underline">Privacy Policy</a></label>
                </div>
                <button type="submit" class="btn btn-red btn-lg w-full">Create Account</button>
            </form>
            <div class="text-center mt-6 text-sm dark-sub">
                Already have an account? <a href="/login" class="text-[#e8120a] font-semibold hover:underline">Sign
                    in</a>
            </div>
        </div>
    </div>
</x-guest-layout>
