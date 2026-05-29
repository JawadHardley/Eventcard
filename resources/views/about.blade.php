{{-- resources/views/about.blade.php --}}
<x-guest-layout>

    {{-- ============================================================
     TapEventCard — ABOUT PAGE
     ============================================================ --}}

    <style>
        :root {
            --tap-500: #e8120a;
            --tap-600: #c41009
        }

        .section-eyebrow-red {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #e8120a;
            margin-bottom: .45rem
        }

        .tap-about-hero {
            min-height: 52vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
            background: radial-gradient(ellipse 70% 60% at 55% 40%, rgba(232, 18, 10, .09) 0%, transparent 65%), #f5f5f7;
        }

        html.dark .tap-about-hero {
            background: radial-gradient(ellipse 70% 60% at 55% 40%, rgba(232, 18, 10, .14) 0%, transparent 65%), #000
        }

        .tap-about-hero::after {
            content: '';
            pointer-events: none;
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
            opacity: .025
        }

        .tap-stat-card {
            background: #fff;
            border-radius: 18px;
            padding: 1.5rem;
            box-shadow: 0 4px 28px rgba(0, 0, 0, .06);
            text-align: center;
            transition: transform .25s ease, box-shadow .25s ease;
            border: 1px solid rgba(0, 0, 0, .04)
        }

        html.dark .tap-stat-card {
            background: #1c1c1e;
            border-color: rgba(255, 255, 255, .05);
            box-shadow: 0 4px 28px rgba(0, 0, 0, .3)
        }

        .tap-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 48px rgba(0, 0, 0, .1)
        }

        html.dark .tap-stat-card:hover {
            box-shadow: 0 14px 48px rgba(0, 0, 0, .5)
        }

        .tap-team-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 32px rgba(0, 0, 0, .07);
            border: 1px solid rgba(0, 0, 0, .04);
            transition: transform .25s ease, box-shadow .25s ease
        }

        html.dark .tap-team-card {
            background: #1c1c1e;
            border-color: rgba(255, 255, 255, .05);
            box-shadow: 0 4px 32px rgba(0, 0, 0, .3)
        }

        .tap-team-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 22px 64px rgba(0, 0, 0, .1)
        }

        html.dark .tap-team-card:hover {
            box-shadow: 0 22px 64px rgba(0, 0, 0, .5)
        }

        .tap-team-banner {
            height: 120px;
            position: relative
        }

        .tap-team-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 3px solid #fff;
            position: absolute;
            bottom: -36px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff;
            box-shadow: 0 8px 28px rgba(0, 0, 0, .15)
        }

        html.dark .tap-team-avatar {
            border-color: #1c1c1e
        }

        .tap-value-card {
            display: flex;
            gap: .9rem;
            align-items: flex-start;
            padding: 1.25rem;
            border-radius: 16px;
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .04);
            box-shadow: 0 2px 18px rgba(0, 0, 0, .05);
            transition: transform .2s ease
        }

        html.dark .tap-value-card {
            background: #1c1c1e;
            border-color: rgba(255, 255, 255, .05)
        }

        .tap-value-card:hover {
            transform: translateY(-3px)
        }

        .tap-value-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(232, 18, 10, .08);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0
        }

        .tap-cta-bg {
            background: linear-gradient(135deg, #e8120a, #c41009 55%, #861208);
            border-radius: 24px;
            position: relative;
            overflow: hidden
        }

        .tap-cta-bg::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 280px;
            height: 280px;
            background: rgba(255, 255, 255, .05);
            border-radius: 50%
        }

        .tap-cta-bg::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -40px;
            width: 380px;
            height: 380px;
            background: rgba(255, 255, 255, .03);
            border-radius: 50%
        }

        .btn-red {
            background: #e8120a;
            color: #fff;
            box-shadow: 0 4px 20px rgba(232, 18, 10, .3)
        }

        .btn-red:hover {
            background: #c41009;
            transform: translateY(-1px);
            box-shadow: 0 8px 30px rgba(232, 18, 10, .45)
        }

        .btn-white {
            background: #fff;
            color: #e8120a;
            font-weight: 600
        }

        .btn-white:hover {
            background: #f5f5f7;
            transform: translateY(-1px)
        }

        .btn-white-out {
            background: transparent;
            color: #fff;
            border: 1.5px solid rgba(255, 255, 255, .45)
        }

        .btn-white-out:hover {
            background: rgba(255, 255, 255, .12);
            border-color: #fff
        }

        .dark-txt {
            color: #1d1d1f
        }

        html.dark .dark-txt {
            color: #f5f5f7
        }

        .dark-sub {
            color: #6e6e73
        }

        html.dark .dark-sub {
            color: #86868b
        }
    </style>

    {{-- ══════════════════════════════════════ --}}
    {{-- HERO                                   --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="tap-about-hero relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20 relative z-10">
            <div class="max-w-2xl fade-up">
                <div class="section-eyebrow-red">Our Story</div>
                <h1
                    class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold text-gray-900 dark:text-white leading-[1.05] mb-6">
                    We believe events<br><span style="color:#e8120a">deserve better.</span>
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-xl leading-relaxed max-w-xl">
                    TapEventCard was built by a small team tired of watching beautiful events get undermined by
                    last-minute paper logistics. We set out to fix that — one digital invitation at a time.
                </p>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════ --}}
    {{-- STATS                                  --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="py-16 bg-white dark:bg-[#0a0a0a]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 fade-up">
                @foreach ([['500+', 'Events handled', 'across all tiers'], ['20k+', 'Guests managed', 'real verified entries'], ['98%', 'Satisfaction rate', 'from post-event surveys'], ['3', 'Cities active', 'and growing fast']] as $s)
                    <div class="tap-stat-card">
                        <div class="text-3xl font-bold mb-1" style="color:#e8120a">{{ $s[0] }}</div>
                        <div class="dark-txt font-semibold text-sm mb-0.5">{{ $s[1] }}</div>
                        <div class="dark-sub text-xs">{{ $s[2] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════ --}}
    {{-- MISSION & STORY                        --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="py-24 bg-gray-50 dark:bg-[#050505]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                {{-- Left: Text --}}
                <div class="fade-up">
                    <div class="section-eyebrow-red">Our Mission</div>
                    <h2 class="section-title mb-6">Making event memories<br>start before the day.</h2>
                    <p class="dark-sub text-base leading-relaxed mb-5">
                        We started TapEventCard after attending a stunning wedding that nearly fell apart because of
                        guest list confusion and missed reminders. The event was beautiful — the logistics were not.
                    </p>
                    <p class="dark-sub text-base leading-relaxed mb-5">
                        Our mission became clear: build a platform that handles everything from the first invitation to
                        the last check-in, so hosts can focus entirely on what matters — their guests and their moment.
                    </p>
                    <p class="dark-sub text-base leading-relaxed">
                        Today, TapEventCard powers weddings, corporate galas, private dinners, and celebrations across
                        East Africa — and we're just getting started.
                    </p>
                </div>
                {{-- Right: Values --}}
                <div class="space-y-4 fade-up" style="transition-delay:.15s">
                    @foreach ([['Design First', 'Every card tier is crafted to look exceptional. We don\'t ship anything we wouldn\'t put our own name on.', 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z'], ['Automation at Core', 'From delivery to reminders to thank-you cards — every step is automated so nothing falls through the cracks.', 'M13 10V3L4 14h7v7l9-11h-7z'], ['Human When It Counts', 'Premium events get a real human designer. Not everything should be automated — and we know when to step in.', 'M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75']] as $v)
                        <div class="tap-value-card">
                            <div class="tap-value-icon">
                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                                    <path d="{{ $v[2] }}" stroke="#e8120a" stroke-width="1.7"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="dark-txt font-bold text-sm mb-1">{{ $v[0] }}</h4>
                                <p class="dark-sub text-sm leading-relaxed">{{ $v[1] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════ --}}
    {{-- TEAM — 3 members                       --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="py-24 bg-white dark:bg-[#0a0a0a]" id="team">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16 fade-up">
                <div class="section-eyebrow-red">The Team</div>
                <h2 class="section-title">The people behind<br class="hidden sm:block"> every perfect event.</h2>
                <p class="section-sub mt-3 max-w-lg mx-auto">A small, focused team that takes every event personally.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto">
                @foreach ([['Valentine Florentine', 'Founder & CEO', 'Master of Ideas', '#a30d08', 'V'], ['Twity Robert', 'Head of Design', 'Twity leads all Premium card designs. Her obsession with typography and composition ensures every invitation feels like a piece of art.', '#c41009', 'T'], ['Jawad Charles', 'Tech Lead', 'Eyes on the code', '#e8120a', 'J']] as $i => $m)
                    <div class="tap-team-card text-center fade-up" style="transition-delay:{{ $i * 0.12 }}s">
                        {{-- Banner --}}
                        <div class="tap-team-banner" style="background:linear-gradient(135deg,#1a0805,#3d1008)">
                            <div class="tap-team-avatar" style="background:{{ $m[3] }}">{{ $m[4] }}
                            </div>
                        </div>
                        {{-- Info --}}
                        <div class="px-6 pt-12 pb-7">
                            <h3 class="dark-txt font-bold text-lg mb-0.5">{{ $m[0] }}</h3>
                            <div class="text-xs font-semibold uppercase tracking-widest mb-3" style="color:#e8120a">
                                {{ $m[1] }}</div>
                            <p class="dark-sub text-sm leading-relaxed">{{ $m[2] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════ --}}
    {{-- CTA                                    --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="py-16 bg-gray-50 dark:bg-[#050505]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 fade-up">
            <div class="tap-cta-bg p-12 sm:p-16 text-center relative z-0">
                <div class="relative z-10">
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mb-4">Work with people<br>who care
                        about your event.</h2>
                    <p class="text-white/70 text-lg mb-8 max-w-md mx-auto">Get started today or reach out — we'd love to
                        hear about your event.</p>
                    <div class="flex flex-wrap gap-3 justify-center">
                        <a href="/pricing" class="btn btn-white btn-lg">View Pricing</a>
                        <a href="/contact" class="btn btn-white-out btn-lg">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
