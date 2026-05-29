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

        .tap-pricing-hero {
            min-height: 35vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
            background: radial-gradient(ellipse 70% 55% at 50% 40%, rgba(232, 18, 10, .07) 0%, transparent 65%), #f5f5f7;
        }

        html.dark .tap-pricing-hero {
            background: radial-gradient(ellipse 70% 55% at 50% 40%, rgba(232, 18, 10, .1) 0%, transparent 65%), #000;
        }

        .pricing-card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 32px rgba(0, 0, 0, .06);
            border: 1px solid rgba(0, 0, 0, .04);
            display: flex;
            flex-direction: column;
            transition: transform .25s;
        }

        html.dark .pricing-card {
            background: #1c1c1e;
            border-color: rgba(255, 255, 255, .05);
            box-shadow: 0 4px 32px rgba(0, 0, 0, .3);
        }

        .pricing-card:hover {
            transform: translateY(-6px);
        }

        .pricing-card.popular {
            border: 2px solid #e8120a;
            position: relative;
        }

        .popular-badge {
            position: absolute;
            top: -14px;
            right: 20px;
            background: #e8120a;
            color: #fff;
            font-size: .7rem;
            font-weight: 700;
            padding: .25rem .9rem;
            border-radius: 980px;
            letter-spacing: .05em;
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

        .btn-ghost-red {
            background: rgba(232, 18, 10, .06);
            color: #e8120a;
            border-radius: 980px;
        }

        .btn-ghost-red:hover {
            background: rgba(232, 18, 10, .12);
            transform: translateY(-1px);
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

        .feature-check svg {
            stroke: #e8120a;
            width: 14px;
            height: 14px;
            margin-right: 8px;
            flex-shrink: 0;
        }

        .feature-check {
            display: flex;
            align-items: center;
            font-size: .875rem;
        }

        .accordion-item {
            border-bottom: 1px solid #f0f0f5;
        }

        html.dark .accordion-item {
            border-bottom-color: #2c2c2e;
        }

        .accordion-item:last-child {
            border-bottom: none;
        }

        .accordion-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            font-size: .9rem;
            font-weight: 600;
            color: #1d1d1f;
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            text-align: left;
        }

        html.dark .accordion-btn {
            color: #fff;
        }

        .accordion-icon {
            flex-shrink: 0;
            transition: transform .28s;
        }

        .accordion-item.open .accordion-icon {
            transform: rotate(180deg);
        }

        .accordion-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s;
        }

        .accordion-item.open .accordion-body {
            max-height: 300px;
        }

        .accordion-content {
            padding: .25rem 0 1rem;
            font-size: .875rem;
            color: #6e6e73;
            line-height: 1.65;
        }

        html.dark .accordion-content {
            color: #86868b;
        }
    </style>

    {{-- Hero --}}
    <section class="tap-pricing-hero relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20 relative z-10 text-center">
            <div class="fade-up">
                <div class="section-eyebrow-red">Simple Pricing</div>
                <h1
                    class="font-display text-5xl sm:text-6xl font-bold text-gray-900 dark:text-white leading-[1.05] mb-6">
                    One event,<br><span style="color:#e8120a">one price.</span>
                </h1>
                <p class="dark-sub text-xl max-w-md mx-auto">No subscriptions. No hidden fees. Pay per event.</p>
            </div>
        </div>
    </section>

    {{-- Pricing cards --}}
    {{-- <section class="py-20 bg-white dark:bg-[#0a0a0a]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 fade-up">
                @foreach ([['Basic', 'Small gatherings', '$39', 'up to 50 guests', false, ['Static invitation image', 'QR entry pass', 'WhatsApp & Email delivery']], ['Standard', 'Most popular', '$79', 'unlimited guests', true, ['Everything in Basic', 'Interactive event page', 'Live guest dashboard']], ['Premium', 'Fully animated', '$199', 'unlimited guests', false, ['Everything in Standard', 'Countdown + carousel', 'Dedicated designer support']]] as $plan)
                    <div class="pricing-card {{ $plan[4] ? 'popular' : '' }}">
                        @if ($plan[4])
                            <span class="popular-badge">POPULAR</span>
                        @endif
                        <h3 class="dark-txt font-bold text-xl mb-1">{{ $plan[0] }}</h3>
                        <p class="dark-sub text-sm mb-6">{{ $plan[1] }}</p>
                        <div class="text-4xl font-bold mb-1" style="color:#e8120a">{{ $plan[2] }}<span
                                class="text-lg font-normal dark-sub">/event</span></div>
                        <p class="dark-sub text-xs mb-6">{{ $plan[3] }}</p>
                        <ul class="space-y-3 text-sm dark-txt mb-8 flex-1">
                            @foreach ($plan[5] as $feat)
                                <li class="feature-check"><svg fill="none" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke-width="2.5" stroke-linecap="round" />
                                    </svg>{{ $feat }}</li>
                            @endforeach
                        </ul>
                        <a href="/contact"
                            class="btn {{ $plan[4] ? 'btn-red' : 'btn-ghost-red' }} btn-lg w-full">{{ $plan[4] ? 'Get Started' : 'Choose ' . $plan[0] }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section> --}}

    {{-- ══════════════════════════════════════ --}}
    {{-- CARD CATALOGUE — 3 tiers               --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="py-24 bg-white dark:bg-[#0a0a0a]" id="catalogue">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16 fade-up">
                <div class="section-eyebrow-red">Card Catalogue</div>
                <h2 class="section-title">Three tiers. One perfect<br class="hidden sm:block"> invitation for every
                    event.
                </h2>
                <p class="section-sub mt-3 max-w-lg mx-auto">Each tier includes automated delivery, live tracking, and
                    post-event reporting.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-start">

                {{-- BASIC --}}
                <div class="tap-tier tap-tier-base fade-up" data-tilt>
                    <div class="tap-prev tap-prev-basic">
                        <div class="tap-prev-lines w-4/5">
                            <div class="tap-prev-line bg-gray-300 dark:bg-gray-600" style="width:60%"></div>
                            <div class="tap-prev-line bg-gray-200 dark:bg-gray-700" style="width:80%"></div>
                            <div class="tap-prev-line bg-gray-200 dark:bg-gray-700" style="width:45%"></div>
                        </div>
                    </div>
                    <div class="text-xs font-bold dark-sub uppercase tracking-widest mb-2">Basic</div>
                    <div class="text-3xl font-bold dark-txt mb-1">
                        1,500
                        <span class="text-base font-normal dark-sub">
                            Tsh</span>
                        <span class="text-base font-normal dark-sub">/
                            Card</span>
                    </div>
                    <p class="dark-sub text-sm mb-5">Simple static design, QR verification included.</p>
                    <div class="space-y-0.5 mb-6">
                        @foreach (['Static card design', 'WhatsApp delivery', 'QR code per guest', 'Basic attendance report'] as $f)
                            <div class="tap-tier-feat">
                                <div class="tap-feat-dot-ok"><svg width="10" height="10" fill="none"
                                        viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke="#34c759" stroke-width="2.5"
                                            stroke-linecap="round" />
                                    </svg></div><span class="dark-sub text-sm">{{ $f }}</span>
                            </div>
                        @endforeach
                        @foreach (['Animations', 'Custom layout', 'Admin review'] as $f)
                            <div class="tap-tier-feat">
                                <div class="tap-feat-dot"
                                    style="background:#d1d1d6;width:6px;height:6px;border-radius:50%;flex-shrink:0">
                                </div>
                                <span
                                    class="text-gray-300 dark:text-gray-600 text-sm line-through">{{ $f }}</span>
                            </div>
                        @endforeach
                    </div>
                    <a href="#pricing" class="btn btn-red-out btn-md w-full text-center">Get Started</a>
                </div>

                {{-- STANDARD --}}
                <div class="tap-tier tap-tier-base fade-up" style="transition-delay:.12s">
                    <div class="tap-prev tap-prev-std">
                        <div class="tap-prev-lines w-4/5">
                            <div class="tap-prev-line" style="background:rgba(255,255,255,.18);width:55%"></div>
                            <div class="tap-prev-line" style="background:rgba(255,255,255,.12);width:75%"></div>
                            <div class="tap-prev-line" style="background:rgba(255,255,255,.08);width:40%"></div>
                        </div>
                    </div>
                    <div class="text-xs font-bold dark-sub uppercase tracking-widest mb-2">Standard</div>
                    <div class="text-3xl font-bold dark-txt mb-1">
                        2,300
                        <span class="text-base font-normal dark-sub">
                            Tsh</span>
                        <span class="text-base font-normal dark-sub">/
                            Card</span>
                    </div>
                    <p class="dark-sub text-sm mb-5">Styled layout with light customization and a hosted event page.
                    </p>
                    <div class="space-y-0.5 mb-6">
                        @foreach (['Styled card layout', 'WhatsApp + Email delivery', 'Hosted event link', 'Countdown timer', 'Light customization', 'Full attendance report'] as $f)
                            <div class="tap-tier-feat">
                                <div class="tap-feat-dot-ok"><svg width="10" height="10" fill="none"
                                        viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke="#34c759" stroke-width="2.5"
                                            stroke-linecap="round" />
                                    </svg></div><span class="dark-sub text-sm">{{ $f }}</span>
                            </div>
                        @endforeach
                        @foreach (['Full animations', 'Admin design review'] as $f)
                            <div class="tap-tier-feat">
                                <div style="width:6px;height:6px;border-radius:50%;background:#d1d1d6;flex-shrink:0">
                                </div>
                                <span
                                    class="text-gray-300 dark:text-gray-600 text-sm line-through">{{ $f }}</span>
                            </div>
                        @endforeach
                    </div>
                    <a href="#pricing" class="btn btn-red btn-md w-full text-center">Get Started</a>
                </div>

                {{-- PREMIUM --}}
                <div class="tap-tier tap-tier-prem fade-up" style="transition-delay:.24s">
                    <div class="tap-prem-badge">
                        <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Premium — Best Value
                    </div>
                    <div class="tap-prev tap-prev-prem">
                        <div class="tap-prev-lines w-4/5">
                            <div class="tap-prev-line" style="background:rgba(232,18,10,.5);width:60%"></div>
                            <div class="tap-prev-line" style="background:rgba(232,18,10,.3);width:80%"></div>
                            <div class="tap-prev-line" style="background:rgba(232,18,10,.2);width:50%"></div>
                        </div>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-widest mb-2" style="color:rgba(255,255,255,.5)">
                        Premium</div>
                    <div class="text-3xl font-bold text-white mb-1">
                        3,000
                        <span class="text-base font-normal dark-sub">
                            Tsh</span>
                        <span class="text-base font-normal dark-sub">/
                            Card</span>
                    </div>
                    <p class="text-sm mb-5" style="color:rgba(255,255,255,.6)">Fully animated experience with
                        admin-assisted custom design.</p>
                    <div class="space-y-0.5 mb-6">
                        @foreach (['Full animation suite', 'WhatsApp + Email delivery', 'Custom admin-designed layout', 'Interactive event page', 'Image carousel', 'Countdown timer', 'Live entry tracking', 'Post-event thank-you card', 'Detailed analytics report'] as $f)
                            <div class="tap-tier-feat">
                                <div class="tap-feat-dot-ok" style="background:rgba(232,18,10,.2)"><svg
                                        width="10" height="10" fill="none" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke="#ff6b6b" stroke-width="2.5"
                                            stroke-linecap="round" />
                                    </svg></div><span class="text-sm"
                                    style="color:rgba(255,255,255,.82)">{{ $f }}</span>
                            </div>
                        @endforeach
                    </div>
                    <a href="#pricing" class="btn btn-white btn-md w-full text-center">Get Started</a>
                </div>
            </div>
            {{-- <div class="text-center mt-8 fade-up">
                <a href="/pricing" class="text-sm font-semibold" style="color:#e8120a">View full pricing
                    details &rarr;</a>
            </div> --}}
        </div>
    </section>

    {{-- FAQ --}}
    <section class="py-20 bg-gray-50 dark:bg-[#050505]">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 fade-up">
            <div class="text-center mb-12">
                <div class="section-eyebrow-red">FAQ</div>
                <h2 class="section-title">Quick answers</h2>
            </div>

            <div class="card divide-y divide-gray-50 dark:divide-gray-800 overflow-hidden" id="accordion-demo">
                <div class="accordion-item px-6">
                    <button class="accordion-btn">
                        Can I change my card after purchase?
                        <svg class="accordion-icon" width="18" height="18" fill="none"
                            viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg></button>
                    <div class="accordion-body">
                        <div class="accordion-content">
                            Yes, you can edit event details anytime before the delivery date
                        </div>
                    </div>
                </div>
                <div class="accordion-item px-6">
                    <button class="accordion-btn text-brand-500">
                        How does guest verification work?
                        <svg class="accordion-icon" width="18" height="18" fill="none"
                            viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" stroke="#0e84e8" stroke-width="2" stroke-linecap="round" />
                        </svg></button>
                    <div class="accordion-body">
                        <div class="accordion-content">
                            Each guest gets a unique QR code that can be scanned at the entrance.
                        </div>
                    </div>
                </div>
                <div class="accordion-item px-6">
                    <button class="accordion-btn text-brand-500">
                        What happens after the event?
                        <svg class="accordion-icon" width="18" height="18" fill="none"
                            viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" stroke="#0e84e8" stroke-width="2" stroke-linecap="round" />
                        </svg></button>
                    <div class="accordion-body">
                        <div class="accordion-content">
                            We send automated thank-you cards and generate an attendance report.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
