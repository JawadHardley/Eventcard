<x-guest-layout>
    <style>
        :root {
            --tap-500: #e8120a;
            --tap-600: #c41009;
        }

        .section-eyebrow-red {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #e8120a;
            margin-bottom: .45rem;
        }

        .tap-contact-hero {
            min-height: 40vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
            background: radial-gradient(ellipse 60% 50% at 45% 35%, rgba(232, 18, 10, .08) 0%, transparent 65%), #f5f5f7;
        }

        html.dark .tap-contact-hero {
            background: radial-gradient(ellipse 60% 50% at 45% 35%, rgba(232, 18, 10, .12) 0%, transparent 65%), #000;
        }

        .tap-contact-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 32px rgba(0, 0, 0, .06);
            border: 1px solid rgba(0, 0, 0, .04);
        }

        html.dark .tap-contact-card {
            background: #1c1c1e;
            border-color: rgba(255, 255, 255, .05);
            box-shadow: 0 4px 32px rgba(0, 0, 0, .3);
        }

        .btn-red {
            background: #e8120a;
            color: #fff;
            box-shadow: 0 4px 20px rgba(232, 18, 10, .3);
            border-radius: 980px;
        }

        .btn-red:hover {
            background: #c41009;
            transform: translateY(-1px);
            box-shadow: 0 8px 30px rgba(232, 18, 10, .45);
        }

        .form-input {
            width: 100%;
            border: 1.5px solid #e5e5ea;
            border-radius: 12px;
            padding: .75rem 1rem;
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            color: #1d1d1f;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        html.dark .form-input {
            background: #2c2c2e;
            border-color: #38383a;
            color: #f5f5f7;
        }

        .form-input:focus {
            border-color: #e8120a;
            box-shadow: 0 0 0 3px rgba(232, 18, 10, .12);
        }

        .form-label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: #6e6e73;
            margin-bottom: .35rem;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        html.dark .form-label {
            color: #86868b;
        }

        .dark-txt {
            color: #1d1d1f;
        }

        html.dark .dark-txt {
            color: #f5f5f7;
        }

        .dark-sub {
            color: #6e6e73;
        }

        html.dark .dark-sub {
            color: #86868b;
        }
    </style>

    {{-- Hero --}}
    <section class="tap-contact-hero relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20 relative z-10 text-center">
            <div class="fade-up">
                <div class="section-eyebrow-red">Get in Touch</div>
                <h1
                    class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold text-gray-900 dark:text-white leading-[1.05] mb-6">
                    Let’s talk<br><span style="color:#e8120a">about your event.</span>
                </h1>
                <p class="dark-sub text-xl max-w-md mx-auto">We normally reply within a few hours — fire away.</p>
            </div>
        </div>
    </section>

    {{-- Form + Info --}}
    <section class="py-20 bg-white dark:bg-[#0a0a0a]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 fade-up">
                <div>
                    <form class="space-y-5"
                        onsubmit="event.preventDefault();showToast('Message sent! We’ll reply soon.','success');this.reset()">
                        <div><label class="form-label">Your Name</label><input type="text" class="form-input"
                                placeholder="Jawad Mwinyi" required></div>
                        <div><label class="form-label">Email</label><input type="email" class="form-input"
                                placeholder="jawad@tapeventcard.com" required></div>
                        <div><label class="form-label">Phone (optional)</label><input type="tel" class="form-input"
                                placeholder="+255 712 345 678"></div>
                        <div><label class="form-label">Message</label>
                            <textarea class="form-input h-36 resize-none" placeholder="Tell us about your event, date, number of guests..."
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-red btn-lg w-full">Send Message</button>
                    </form>
                </div>
                <div class="space-y-6 lg:pt-2">
                    <div class="tap-contact-card p-6 space-y-5">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                style="background:rgba(232,18,10,.08)">
                                <svg width="18" height="18" fill="none" stroke="#e8120a" viewBox="0 0 24 24">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" stroke-width="1.8" />
                                    <circle cx="12" cy="10" r="3" stroke-width="1.8" />
                                </svg>
                            </div>
                            <div>
                                <div class="dark-txt font-semibold">Our Office</div>
                                <div class="dark-sub text-sm">Innovation Hub, Dar es Salaam<br>Tanzania</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                style="background:rgba(232,18,10,.08)">
                                <svg width="18" height="18" fill="none" stroke="#e8120a" viewBox="0 0 24 24">
                                    <path
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                        stroke-width="1.8" />
                                </svg>
                            </div>
                            <div>
                                <div class="dark-txt font-semibold">Email</div>
                                <div class="dark-sub text-sm">tapeventcard@gmail.com</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                style="background:rgba(232,18,10,.08)">
                                <svg width="18" height="18" fill="none" stroke="#e8120a" viewBox="0 0 24 24">
                                    <path
                                        d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"
                                        stroke-width="1.8" />
                                </svg>
                            </div>
                            <div>
                                <div class="dark-txt font-semibold">WhatsApp / Call</div>
                                <div class="dark-sub text-sm">+255 778 515 202</div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="tap-contact-card h-48 bg-gray-100 dark:bg-[#2c2c2e] flex items-center justify-center text-sm dark-sub rounded-2xl">
                        Map placeholder
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
