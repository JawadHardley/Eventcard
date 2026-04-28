<x-guest-layout>

    {{-- ══════════════════════════════════════ --}}
    {{-- HERO                                   --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="tap-hero relative" id="hero">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 w-full">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-10 min-h-[calc(100svh-80px)] py-20 lg:py-0">

                {{-- Left: Copy --}}
                <div class="flex-1 text-center lg:text-left z-10">
                    {{-- Eyebrow badge --}}
                    <div
                        class="h-stat inline-flex items-center gap-2 bg-white dark:bg-white/10 border border-red-100 dark:border-white/[.08] px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-6 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full"
                            style="background:#e8120a;box-shadow:0 0 6px rgba(232,18,10,.5)"></span>
                        <span style="color:#e8120a">Digital Event Invitations</span>
                    </div>

                    {{-- Headline --}}
                    <h1 class="font-display leading-[1.05] font-bold mb-6" style="font-size:clamp(2.6rem,6vw,4.5rem)">
                        <span class="wr block text-gray-900 dark:text-white">
                            <span class="w"><span>Invitations</span></span>
                            <span class="w"><span>&nbsp;That</span></span>
                        </span>
                        <span class="wr block" style="color:#e8120a">
                            <span class="w"><span>Leave</span></span>
                            <span class="w"><span>&nbsp;a</span></span>
                            <span class="w"><span>&nbsp;Mark.</span></span>
                        </span>
                    </h1>

                    <p
                        class="h-sub text-gray-500 dark:text-gray-400 text-lg sm:text-xl mb-8 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                        Replace paper cards with stunning interactive digital experiences. Automated delivery, real-time
                        guest tracking, and an RSVP journey your attendees will never forget.
                    </p>

                    {{-- CTAs --}}
                    <div class="h-cta flex flex-wrap gap-3 justify-center lg:justify-start mb-10">
                        <a href="#catalogue" class="btn btn-red btn-lg">
                            Browse Cards
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                <path d="M5 12h14m-7-7l7 7-7 7" stroke="currentColor" stroke-width="2.2"
                                    stroke-linecap="round" />
                            </svg>
                        </a>
                        <a href="#contact" class="btn btn-ghost btn-lg">Book a Demo</a>
                    </div>

                    {{-- Stats --}}
                    <div class="h-stat flex gap-8 justify-center lg:justify-start">
                        <div>
                            <div class="text-2xl font-bold dark-txt tap-stat-num" data-target="500">0</div>
                            <div class="text-xs dark-sub font-medium">Events Hosted</div>
                        </div>
                        <div class="w-px bg-gray-200 dark:bg-gray-800"></div>
                        <div>
                            <div class="text-2xl font-bold dark-txt tap-stat-num" data-target="20000">0</div>
                            <div class="text-xs dark-sub font-medium">Guests Managed</div>
                        </div>
                        <div class="w-px bg-gray-200 dark:bg-gray-800"></div>
                        <div>
                            <div class="text-2xl font-bold dark-txt">98%</div>
                            <div class="text-xs dark-sub font-medium">Satisfied Clients</div>
                        </div>
                    </div>
                </div>

                {{-- Right: Phone Mockup --}}
                <div class="flex-1 flex justify-center lg:justify-end z-10">
                    <div class="tap-phone-wrap relative" id="tap-phone-tilt">
                        <div class="tap-phone">
                            <div class="tap-phone-screen">
                                <div class="tap-invite">
                                    {{-- Card header --}}
                                    <div class="tap-invite-hdr">
                                        <div
                                            style="font-size:9px;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.65);margin-bottom:4px;position:relative;z-index:1">
                                            You're Invited</div>
                                        <div
                                            style="font-family:'DM Serif Display',serif;font-size:17px;color:#fff;line-height:1.2;margin-bottom:3px;position:relative;z-index:1">
                                            Jawad &amp; Sara's<br>Wedding</div>
                                        <div
                                            style="font-size:8.5px;color:rgba(255,255,255,.65);position:relative;z-index:1">
                                            15 March 2025 — Dar es Salaam</div>
                                        {{-- Countdown --}}
                                        <div class="tap-cdown" style="margin-top:10px;position:relative;z-index:1">
                                            <div class="tap-cb">
                                                <div class="tap-cn" id="phone-d">02</div>
                                                <div class="tap-cl">days</div>
                                            </div>
                                            <div class="tap-cb">
                                                <div class="tap-cn" id="phone-h">14</div>
                                                <div class="tap-cl">hrs</div>
                                            </div>
                                            <div class="tap-cb">
                                                <div class="tap-cn" id="phone-m">36</div>
                                                <div class="tap-cl">min</div>
                                            </div>
                                            <div class="tap-cb">
                                                <div class="tap-cn" id="phone-s">22</div>
                                                <div class="tap-cl">sec</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Card body --}}
                                    <div class="tap-invite-body">
                                        <div style="font-size:9px;color:rgba(255,255,255,.38);margin-bottom:2px">Guest
                                        </div>
                                        <div style="font-size:12px;font-weight:600;color:#fff;margin-bottom:10px">Mr.
                                            Ahmed
                                            Hassan</div>
                                        <div style="height:1px;background:rgba(232,18,10,.18);margin-bottom:10px"></div>
                                        {{-- QR --}}
                                        <div
                                            style="background:rgba(255,255,255,.04);border:1px solid rgba(232,18,10,.18);border-radius:10px;padding:10px;text-align:center">
                                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                                style="display:block;margin:0 auto 6px">
                                                <rect width="56" height="56" rx="6"
                                                    fill="rgba(232,18,10,.07)" />
                                                <rect x="8" y="8" width="16" height="16" rx="2.5"
                                                    stroke="#e8120a" stroke-width="1.5" />
                                                <rect x="11" y="11" width="10" height="10" rx="1.5"
                                                    fill="#e8120a" opacity=".55" />
                                                <rect x="32" y="8" width="16" height="16" rx="2.5"
                                                    stroke="#e8120a" stroke-width="1.5" />
                                                <rect x="35" y="11" width="10" height="10" rx="1.5"
                                                    fill="#e8120a" opacity=".55" />
                                                <rect x="8" y="32" width="16" height="16" rx="2.5"
                                                    stroke="#e8120a" stroke-width="1.5" />
                                                <rect x="11" y="35" width="10" height="10" rx="1.5"
                                                    fill="#e8120a" opacity=".55" />
                                                <rect x="32" y="32" width="5" height="5" rx="1"
                                                    fill="#e8120a" opacity=".45" />
                                                <rect x="39" y="32" width="5" height="5" rx="1"
                                                    fill="#e8120a" opacity=".45" />
                                                <rect x="32" y="39" width="5" height="5" rx="1"
                                                    fill="#e8120a" opacity=".45" />
                                                <rect x="39" y="39" width="5" height="5" rx="1"
                                                    fill="#e8120a" opacity=".45" />
                                                <rect x="45" y="8" width="3" height="16" rx="1"
                                                    fill="#e8120a" opacity=".3" />
                                                <rect x="8" y="50" width="16" height="3" rx="1"
                                                    fill="#e8120a" opacity=".3" />
                                            </svg>
                                            <div
                                                style="font-size:7.5px;color:rgba(255,255,255,.35);letter-spacing:.08em;text-transform:uppercase">
                                                Scan to Verify Entry</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bubble 1: Entry verified --}}
                        <div class="tap-bub tap-bub-1">
                            <div class="tap-bub-icon" style="background:rgba(52,199,89,.12)">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4" stroke="#34c759" stroke-width="2.3"
                                        stroke-linecap="round" />
                                    <circle cx="12" cy="12" r="10" stroke="#34c759"
                                        stroke-width="1.5" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold dark:text-gray-200">Entry
                                    Verified
                                </div>
                                <div style="font-size:9px;color:#6e6e73">Guest #247 checked in</div>
                            </div>
                        </div>

                        {{-- Bubble 2: RSVP --}}
                        <div class="tap-bub tap-bub-2">
                            <div class="tap-bub-icon" style="background:rgba(232,18,10,.1)">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24">
                                    <path
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                                        stroke="#e8120a" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div>
                                <div style="font-size:10px" class="font-bold dark:text-white">New RSVP</div>
                                <div style="font-size:9px;color:#6e6e73">312 / 350 attending</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════ --}}
    {{-- MARQUEE — event types                  --}}
    {{-- ══════════════════════════════════════ --}}
    <div
        class="tap-mq border-y border-gray-100 dark:border-gray-800 bg-white dark:bg-[#0a0a0a] py-4 select-none overflow-hidden">
        <div class="tap-mq-track">
            @foreach (array_fill(0, 2, ['Weddings', 'Corporate Events', 'Birthday Celebrations', 'Anniversaries', 'Graduation Parties', 'Product Launches', 'Private Dinners', 'Cultural Ceremonies']) as $set)
                @foreach ($set as $item)
                    <span
                        class="flex items-center gap-2.5 text-sm font-medium text-gray-400 dark:text-gray-600 whitespace-nowrap">
                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#e8120a"></span>
                        {{ $item }}
                    </span>
                @endforeach
            @endforeach
        </div>
    </div>


    {{-- ══════════════════════════════════════ --}}
    {{-- Card slide — 4 feature cards           --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="py-20 bg-gray-50 dark:bg-[#050505] overflow-hidden" id="event-types">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10 sr-up">
                <div>
                    <div class="section-eyebrow-red">Event Types</div>
                    <h2 class="section-title">One platform,<br class="hidden sm:block"> every occasion.</h2>
                </div>
                <p class="dark-sub text-sm max-w-xs leading-relaxed sm:text-right">
                    Weddings, launches, galas — every event gets an invitation that does it justice.
                    Drag to explore.
                </p>
            </div>
        </div>

        {{-- Horizontal scroll container (full-bleed) --}}
        <div class="tap-hscroll-outer">
            <div class="tap-hscroll-wrap" id="tap-hscroll" data-drag-scroll>
                <div class="tap-hscroll-track pl-4 sm:pl-[calc((100vw-72rem)/2+1.5rem)]">

                    {{-- Card: Wedding --}}
                    <div class="tap-ev-card" data-tilt>
                        <div class="tap-ev-img">
                            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=480&q=80"
                                alt="Wedding" loading="lazy" draggable="false">
                            <div class="tap-ev-img-label">Wedding</div>
                        </div>
                        <div class="tap-ev-body">
                            <div class="tap-ev-pill mb-2">
                                <span class="tap-ev-type-dot" style="background:#e8120a"></span>Premium Tier
                            </div>
                            <p class="dark-sub text-xs leading-relaxed">Animated invites, live guest tracking, and a
                                thank-you card after — for the most important day.</p>
                        </div>
                    </div>

                    {{-- Card: Corporate Event --}}
                    <div class="tap-ev-card" data-tilt>
                        <div class="tap-ev-img">
                            <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=480&q=80"
                                alt="Corporate Event" loading="lazy" draggable="false">
                            <div class="tap-ev-img-label">Corporate Event</div>
                        </div>
                        <div class="tap-ev-body">
                            <div class="tap-ev-pill mb-2">
                                <span class="tap-ev-type-dot" style="background:#0e84e8"></span>All Tiers
                            </div>
                            <p class="dark-sub text-xs leading-relaxed">Professional invitations with branded layouts,
                                bulk
                                delivery, and full attendance reporting.</p>
                        </div>
                    </div>

                    {{-- Card: Birthday Celebration --}}
                    <div class="tap-ev-card" data-tilt>
                        <div class="tap-ev-img">
                            <img src="https://images.unsplash.com/photo-1464349153735-7db50ed83c84?w=480&q=80"
                                alt="Birthday Celebration" loading="lazy" draggable="false">
                            <div class="tap-ev-img-label">Birthday</div>
                        </div>
                        <div class="tap-ev-body">
                            <div class="tap-ev-pill mb-2">
                                <span class="tap-ev-type-dot" style="background:#ff9500"></span>Standard+
                            </div>
                            <p class="dark-sub text-xs leading-relaxed">Vibrant card designs with countdown timers and
                                WhatsApp delivery your friends will actually open.</p>
                        </div>
                    </div>

                    {{-- Card: Anniversary --}}
                    <div class="tap-ev-card" data-tilt>
                        <div class="tap-ev-img">
                            <img src="https://images.unsplash.com/photo-1502635385003-ee1e6a1a742d?w=480&q=80"
                                alt="Anniversary" loading="lazy" draggable="false">
                            <div class="tap-ev-img-label">Anniversary</div>
                        </div>
                        <div class="tap-ev-body">
                            <div class="tap-ev-pill mb-2">
                                <span class="tap-ev-type-dot" style="background:#e8120a"></span>Premium Tier
                            </div>
                            <p class="dark-sub text-xs leading-relaxed">Intimate and elegant. Custom admin-designed
                                layouts
                                that capture the weight of the occasion.</p>
                        </div>
                    </div>

                    {{-- Card: Product Launch --}}
                    <div class="tap-ev-card" data-tilt>
                        <div class="tap-ev-img">
                            <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=480&q=80"
                                alt="Product Launch" loading="lazy" draggable="false">
                            <div class="tap-ev-img-label">Product Launch</div>
                        </div>
                        <div class="tap-ev-body">
                            <div class="tap-ev-pill mb-2">
                                <span class="tap-ev-type-dot" style="background:#34c759"></span>All Tiers
                            </div>
                            <p class="dark-sub text-xs leading-relaxed">Make the announcement land before anyone walks
                                through the door — with invites they screenshot and share.</p>
                        </div>
                    </div>

                    {{-- Card: Cultural Ceremony --}}
                    <div class="tap-ev-card" data-tilt>
                        <div class="tap-ev-img">
                            <img src="https://images.unsplash.com/photo-1531058020387-3be344556be6?w=480&q=80"
                                alt="Cultural Ceremony" loading="lazy" draggable="false">
                            <div class="tap-ev-img-label">Cultural Ceremony</div>
                        </div>
                        <div class="tap-ev-body">
                            <div class="tap-ev-pill mb-2">
                                <span class="tap-ev-type-dot" style="background:#a30d08"></span>Premium Tier
                            </div>
                            <p class="dark-sub text-xs leading-relaxed">Richly designed cards that honour tradition.
                                Fully
                                customized by our design team for your ceremony.</p>
                        </div>
                    </div>

                    {{-- Card: Private Dinner --}}
                    <div class="tap-ev-card" data-tilt>
                        <div class="tap-ev-img">
                            <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=480&q=80"
                                alt="Private Dinner" loading="lazy" draggable="false">
                            <div class="tap-ev-img-label">Private Dinner</div>
                        </div>
                        <div class="tap-ev-body">
                            <div class="tap-ev-pill mb-2">
                                <span class="tap-ev-type-dot" style="background:#1d1d1f"></span>Basic+
                            </div>
                            <p class="dark-sub text-xs leading-relaxed">Discreet, minimal, and polished. Perfect for
                                intimate gatherings where the detail matters most.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Scroll hint --}}
        <div class="max-w-6xl mx-auto px-4 sm:px-6 mt-5 flex items-center gap-2 sr-up sr-d2">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" class="text-gray-400">
                <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            </svg>
            <span class="text-xs dark-sub font-medium">Drag to explore all event types</span>
        </div>
    </section>

    {{-- ══════════════════════════════════════ --}}
    {{-- Mockup area          --}}
    {{-- ══════════════════════════════════════ --}}
    @include('partials.wow2')



    {{-- ══════════════════════════════════════ --}}
    {{-- WHAT WE DO preview feature       --}}
    {{-- ══════════════════════════════════════ --}}

    <section class="py-24 bg-white dark:bg-[#0a0a0a]" id="guest-journey">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16 sr-up">
                <div class="section-eyebrow-red">Guest Experience</div>
                <h2 class="section-title">What your guests<br class="hidden sm:block"> actually feel.</h2>
                <p class="section-sub mt-3 max-w-lg mx-auto">
                    From the moment they receive the invite to when they walk through the door — every step is handled.
                </p>
            </div>

            {{-- Desktop: horizontal row | Mobile: vertical list --}}
            <div class="tap-journey-line-wrap relative">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-0 lg:gap-6 tap-journey-line-h">

                    @foreach ([
        ['01', 'Receive the Card', 'The guest gets a WhatsApp or Email notification with a beautifully designed card image and a unique link — personalised with their name.', 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
        ['02', 'Open the Live Page', 'Tapping the link opens a hosted interactive event page — animated, elegant, and loaded with all event details.', 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
        ['03', 'Watch the Countdown', 'A live countdown timer builds anticipation and reminds them how close the event is. An automated reminder fires the morning of the event.', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['04', 'Arrive and Scan', 'At the venue entrance, staff scans the guest\'s unique QR code. Entry is verified in seconds — no lists, no confusion.', 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 4h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z'],
        ['05', 'Receive Thank You', 'Before the night ends, every guest receives a beautiful animated thank-you card from the host — a lasting memory of the event.', 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
    ] as $i => $step)
                        <div class="tap-journey-item sr-up sr-d{{ min($i + 1, 5) }} relative">
                            {{-- Connector line on desktop (between items, not after last) --}}
                            @if ($i < 4)
                                <div class="hidden lg:block absolute top-5 left-[calc(50%+28px)] right-[-50%] h-0.5"
                                    style="background:linear-gradient(to right,rgba(232,18,10,.25),rgba(232,18,10,.04));z-index:0">
                                </div>
                            @endif

                            <div class="tap-journey-num relative z-10">{{ $step[0] }}</div>

                            <div class="tap-journey-body">
                                <div class="flex lg:justify-center mb-2">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                                        style="background:rgba(232,18,10,.08)">
                                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                                            <path d="{{ $step[3] }}" stroke="#e8120a" stroke-width="1.7"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                                <h4 class="dark-txt font-bold text-sm mb-1.5 leading-snug">{{ $step[1] }}</h4>
                                <p class="dark-sub text-xs leading-relaxed">{{ $step[2] }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>



    {{-- ══════════════════════════════════════ --}}
    {{-- CXXXXXXX preview feature       --}}
    {{-- ══════════════════════════════════════ --}}



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
                    <div class="text-3xl font-bold dark-txt mb-1">$15 <span class="text-base font-normal dark-sub">/
                            event</span></div>
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
                    <div class="text-3xl font-bold dark-txt mb-1">$35 <span class="text-base font-normal dark-sub">/
                            event</span></div>
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
                    <div class="text-3xl font-bold text-white mb-1">$75 <span class="text-base font-normal"
                            style="color:rgba(255,255,255,.5)">/ event</span></div>
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
            <div class="text-center mt-8 fade-up">
                <a href="/pricing" class="text-sm font-semibold" style="color:#e8120a">View full pricing
                    details &rarr;</a>
            </div>
        </div>
    </section>


    {{-- ══════════════════════════════════════ --}}
    {{-- Sample cards           --}}
    {{-- ══════════════════════════════════════ --}}
    @include('partials.cardcat')

    {{-- ══════════════════════════════════════ --}}
    {{-- EVENTS VIDEO                           --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="tap-vid-bg py-24" id="events">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="text-center mb-12 fade-up">
                <div class="section-eyebrow-red">Our Work</div>
                <h2 class="section-title text-white">Events We've Been<br class="hidden sm:block"> Part Of.</h2>
                <p class="mt-3 max-w-lg mx-auto" style="color:rgba(255,255,255,.5)">From intimate weddings to large
                    corporate gatherings — real events, real moments, real impact.</p>
            </div>

            {{-- Event type filters --}}
            <div class="flex flex-wrap gap-2 justify-center mb-8 fade-up">
                @foreach (['All Events', 'Weddings', 'Corporate', 'Celebrations', 'Private Dinners'] as $i => $type)
                    <button class="tap-event-pill {{ $i === 0 ? 'active' : '' }}"
                        onclick="filterEvent(this)">{{ $type }}</button>
                @endforeach
            </div>

            {{-- Video embed --}}
            <div class="max-w-3xl mx-auto fade-up">
                <div class="tap-vid-wrap" id="tap-video" onclick="playVideo()">
                    {{-- Gradient placeholder (replace src with actual YouTube thumbnail) --}}
                    <div
                        style="width:100%;height:100%;background:linear-gradient(135deg,#1a0805 0%,#3d1008 40%,#1a0805 100%);display:flex;align-items:center;justify-content:center">
                        <div style="text-align:center">
                            <div
                                style="font-family:'DM Serif Display',serif;font-size:clamp(1.3rem,4vw,2rem);color:rgba(255,255,255,.25);margin-bottom:.5rem">
                                Jawad &amp; Sara's Wedding</div>
                            <div
                                style="font-size:.8rem;color:rgba(255,255,255,.15);letter-spacing:.1em;text-transform:uppercase">
                                Dar es Salaam · March 2025</div>
                        </div>
                    </div>
                    <div class="tap-vid-play">
                        <div class="tap-play-btn">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path d="M6 4l15 8-15 8V4z" fill="white" />
                            </svg>
                        </div>
                        <span
                            style="font-size:.8rem;color:rgba(255,255,255,.5);letter-spacing:.06em;text-transform:uppercase">Watch
                            Highlight Reel</span>
                    </div>
                </div>
            </div>

            {{-- Stats row --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-12 fade-up">
                @foreach ([['500+', 'Events Handled'], ['20k+', 'Guests Managed'], ['5', 'Cities Covered'], ['100%', 'On-time Delivery']] as $s)
                    <div class="text-center p-5 rounded-2xl"
                        style="background:rgba(255,255,255,.04);border:1px solid rgba(232,18,10,.15)">
                        <div class="text-2xl font-bold text-white mb-1">{{ $s[0] }}</div>
                        <div class="text-xs" style="color:rgba(255,255,255,.4)">{{ $s[1] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════ --}}
    {{-- HOW IT WORKS — 5 steps                 --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="py-24 bg-gray-50 dark:bg-[#050505]" id="how-it-works">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16 fade-up">
                <div class="section-eyebrow-red">How It Works</div>
                <h2 class="section-title">From setup to success<br class="hidden sm:block"> in five steps.</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ([['01', 'Choose a Template', 'Browse Basic, Standard, or Premium card designs and select the one that matches your event aesthetic.'], ['02', 'Add Event Details', 'Fill in your event name, date, venue, and upload photos to personalize your card.'], ['03', 'Upload Guest List', 'Add phone numbers and email addresses. The system assigns each guest a unique identity.'], ['04', 'We Deliver', 'Invitations are sent automatically via WhatsApp and email — 2 days before and on the event day.'], ['05', 'Track Everything', 'Watch live check-ins on your dashboard. Export the full attendance report after your event.']] as $i => $step)
                    <div class="tap-step text-center fade-up relative" style="transition-delay:{{ $i * 0.12 }}s">
                        @if ($i < 4)
                            <div class="tap-steps-line hidden lg:block"></div>
                        @endif
                        <div class="tap-step-num">{{ $step[0] }}</div>
                        <h4 class="font-bold dark-txt text-sm mb-2 leading-snug">{{ $step[1] }}</h4>
                        <p class="dark-sub text-xs leading-relaxed">{{ $step[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════ --}}
    {{-- Dashboard — 4 feature cards           --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="tap-live-bg py-24 relative" id="live-preview">

        {{-- Ambient glows --}}
        <div class="tap-live-glow w-96 h-96 -top-20 -left-20" style="background:rgba(232,18,10,.08)"></div>
        <div class="tap-live-glow w-80 h-80 bottom-10 right-0"
            style="background:rgba(232,18,10,.05);animation-delay:4s;animation-direction:alternate-reverse"></div>
        <div class="tap-live-noise"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">

            {{-- Heading --}}
            <div class="text-center mb-16 sr-up">
                <div class="section-eyebrow-red">Live Platform</div>
                <h2 class="section-title text-white">
                    Every event, watched<br class="hidden sm:block"> in real time.
                </h2>
                <p class="mt-3 max-w-lg mx-auto text-sm leading-relaxed" style="color:rgba(255,255,255,.45)">
                    Your admin dashboard updates the moment a guest checks in. No refresh needed.
                    No guessing. Just live data.
                </p>
            </div>

            {{-- Dashboard mockup grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                {{-- Col 1: Event Stats --}}
                <div class="tap-live-glass p-6 sr-up sr-d1 lg:col-span-1">
                    {{-- Live header --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <div class="text-xs text-white/40 uppercase tracking-widest mb-0.5">Event Dashboard</div>
                            <div class="text-white font-semibold text-sm">Jawad &amp; Sara's Wedding</div>
                        </div>
                        <div
                            class="flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-3 py-1.5">
                            <div class="tap-live-dot"></div>
                            <span class="text-xs text-white/60 font-medium">Live</span>
                        </div>
                    </div>

                    {{-- Stat rows --}}
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-xs mb-2">
                                <span class="text-white/50">Checked In</span>
                                <span class="text-white font-semibold">
                                    <span class="tap-ticker" data-live-count data-from="280" data-to="312"
                                        data-duration="2200">312</span>
                                    <span class="text-white/30"> / 350</span>
                                </span>
                            </div>
                            <div class="tap-live-bar-track">
                                <div class="tap-live-bar-fill" data-live-bar style="width:89%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs mb-2">
                                <span class="text-white/50">Pending Arrival</span>
                                <span class="text-white font-semibold">38</span>
                            </div>
                            <div class="tap-live-bar-track">
                                <div class="tap-live-bar-fill"
                                    style="width:11%;background:linear-gradient(90deg,#ff9500,#ffcc02)"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs mb-2">
                                <span class="text-white/50">Thank-you cards sent</span>
                                <span class="text-white font-semibold">312</span>
                            </div>
                            <div class="tap-live-bar-track">
                                <div class="tap-live-bar-fill"
                                    style="width:100%;background:linear-gradient(90deg,#34c759,#30d158)"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Mini stat row --}}
                    <div class="grid grid-cols-3 gap-3 mt-6">
                        @foreach ([['350', 'Total Invited'], ['312', 'Attended'], ['38', 'Pending']] as $ms)
                            <div class="tap-live-glass-red p-2.5 text-center">
                                <div class="text-white font-bold text-sm">{{ $ms[0] }}</div>
                                <div class="text-xs mt-0.5" style="color:rgba(255,255,255,.35)">{{ $ms[1] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Col 2 + 3: Live Activity Feed --}}
                <div class="tap-live-glass p-6 sr-up sr-d2 lg:col-span-2">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <div class="text-xs text-white/40 uppercase tracking-widest mb-0.5">Check-in Feed</div>
                            <div class="text-white font-semibold text-sm">Live Guest Arrivals</div>
                        </div>
                        <div class="text-xs text-white/30 font-medium">Today</div>
                    </div>

                    <div class="space-y-3" id="tap-live-feed">
                        @foreach ([['A', '#e8120a', 'Ahmed Hassan', 'Seat 14-A — Main Hall', 'just now'], ['F', '#a30d08', 'Fatuma Salim', 'VIP Table — East Wing', '2m ago'], ['D', '#c41009', 'David Ochieng', 'Seat 22-C — Main Hall', '5m ago'], ['R', '#861208', 'Rahma Juma', 'Family Section — Row 3', '8m ago'], ['K', '#e8120a', 'Karimu Mwangi', 'Seat 8-B — Main Hall', '11m ago']] as $fi => $f)
                            <div class="tap-live-feed-item" style="animation-delay:{{ $fi * 0.12 }}s">
                                <div class="tap-live-avatar" style="background:{{ $f[1] }}">
                                    {{ $f[0] }}</div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-white text-xs font-semibold truncate">{{ $f[2] }}</div>
                                    <div class="text-white/35 text-xs truncate">{{ $f[3] }}</div>
                                </div>
                                <div class="tap-live-time">{{ $f[4] }}</div>
                                <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0"
                                    style="background:rgba(52,199,89,.15)">
                                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke="#34c759" stroke-width="2.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Bottom status bar --}}
                    <div class="mt-5 pt-4 border-t border-white/5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="tap-live-dot" style="width:6px;height:6px"></div>
                            <span class="text-xs text-white/40">Updating automatically</span>
                        </div>
                        <span class="text-xs font-semibold" style="color:#e8120a">89% attendance rate</span>
                    </div>
                </div>
            </div>

            {{-- Bottom CTA row --}}
            <div class="mt-10 text-center sr-up sr-d3">
                <p class="text-xs mb-4" style="color:rgba(255,255,255,.3)">Full dashboard available on all tiers — no
                    extra setup required.</p>
                <a href="#catalogue" class="btn btn-red btn-md inline-flex">
                    View Card Plans
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" class="ml-1.5">
                        <path d="M5 12h14m-7-7l7 7-7 7" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                </a>
            </div>
        </div>
    </section>




    {{-- ══════════════════════════════════════ --}}
    {{-- TESTIMONIALS                           --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="py-24 bg-gray-50 dark:bg-[#050505]" id="testimonials">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12 fade-up">
                <div class="section-eyebrow-red">Testimonials</div>
                <h2 class="section-title">Hosts who trusted us<br class="hidden sm:block"> with their big day.</h2>
            </div>
            <div class="tap-testi-scroll -mx-4 px-4 fade-up">
                <div class="tap-testi-track">
                    @foreach ([['Amina Hassan', 'Wedding', 'The digital invitations were absolutely stunning. Our guests kept complimenting the card — and the QR check-in at the venue was flawless.'], ['David Ochieng', 'Corporate Gala', 'We used TapEventCard for our annual gala. The real-time dashboard saved us hours on the day. No paper, no chaos — just a smooth event.'], ['Fatuma Salim', 'Birthday Celebration', 'I was skeptical at first but the Premium card my guests received blew everyone away. The countdown timer and animations made it feel like magic.'], ['Rajiv Mehta', 'Product Launch', 'The automated reminder sequence worked perfectly. We saw a 40% higher attendance rate compared to our last event. Will use again.']] as $t)
                        <div class="tap-testi">
                            <div class="flex gap-0.5 mb-3">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="#e8120a">
                                        <path
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="dark-sub text-sm leading-relaxed mb-4">"{{ $t[2] }}"</p>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                                    style="background:#e8120a">{{ substr($t[0], 0, 1) }}</div>
                                <div>
                                    <div class="dark-txt font-semibold text-sm">{{ $t[0] }}</div>
                                    <div class="dark-sub text-xs">{{ $t[1] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════ --}}
    {{-- CTA BANNER                             --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="py-16 bg-white dark:bg-[#0a0a0a]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 fade-up">
            <div class="tap-cta-bg p-12 sm:p-16 text-center relative z-0">
                <div class="relative z-10">
                    <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
                        Ready to make your event<br class="hidden sm:block"> unforgettable?
                    </h2>
                    <p class="text-white/70 text-lg mb-8 max-w-md mx-auto">Join hundreds of hosts who chose digital
                        over
                        paper — and never looked back.</p>
                    <div class="flex flex-wrap gap-3 justify-center">
                        <a href="#catalogue" class="btn btn-white btn-lg">Browse Cards</a>
                        <a href="/contact" class="btn btn-white-out btn-lg">Talk to Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════ --}}
    {{-- PAGE-SPECIFIC JS                       --}}
    {{-- ══════════════════════════════════════ --}}
    <script>
        /* ── Live countdown inside phone mockup ── */
        (function() {
            const target = new Date();
            target.setDate(target.getDate() + 2);
            target.setHours(14, 36, 22, 0);

            function tick() {
                const now = Date.now();
                const diff = Math.max(0, target - now);
                const d = Math.floor(diff / 864e5);
                const h = Math.floor((diff % 864e5) / 36e5);
                const m = Math.floor((diff % 36e5) / 6e4);
                const s = Math.floor((diff % 6e4) / 1e3);
                const fmt = n => String(n).padStart(2, '0');
                const el = id => document.getElementById(id);
                if (el('phone-d')) el('phone-d').textContent = fmt(d);
                if (el('phone-h')) el('phone-h').textContent = fmt(h);
                if (el('phone-m')) el('phone-m').textContent = fmt(m);
                if (el('phone-s')) el('phone-s').textContent = fmt(s);
            }
            tick();
            setInterval(tick, 1000);
        })();

        /* ── 3D Tilt on phone (desktop only) ── */
        (function() {
            const wrap = document.getElementById('tap-phone-tilt');
            if (!wrap || window.innerWidth < 1024) return;
            const phone = wrap.querySelector('.tap-phone');
            if (!phone) return;
            wrap.addEventListener('mousemove', e => {
                const rect = wrap.getBoundingClientRect();
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const rx = ((e.clientY - cy) / (rect.height / 2)) * -8;
                const ry = ((e.clientX - cx) / (rect.width / 2)) * 8;
                phone.style.transform = `perspective(1000px) rotateX(${rx}deg) rotateY(${ry}deg)`;
            });
            wrap.addEventListener('mouseleave', () => {
                phone.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
            });
        })();

        /* ── Counter animation ── */
        (function() {
            const formatNum = n => n >= 1000 ? Math.round(n / 1000) * 1000 > 1000 ? Math.round(n / 1000) + 'k+' :
                '500+' : n + '+';
            const counters = document.querySelectorAll('.tap-stat-num[data-target]');
            if (!counters.length) return;
            const io = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) return;
                    const el = entry.target;
                    const target = parseInt(el.dataset.target);
                    const dur = 1800;
                    const start = Date.now();
                    (function frame() {
                        const pct = Math.min(1, (Date.now() - start) / dur);
                        const ease = 1 - Math.pow(1 - pct, 3);
                        const cur = Math.round(ease * target);
                        el.textContent = target >= 1000 ? Math.round(cur / 1000) + 'k+' : cur + '+';
                        if (pct < 1) requestAnimationFrame(frame);
                    })();
                    io.unobserve(el);
                });
            }, {
                threshold: 0.5
            });
            counters.forEach(c => io.observe(c));
        })();

        /* ── Event filter pills (visual only) ── */
        function filterEvent(btn) {
            document.querySelectorAll('.tap-event-pill').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
        }

        /* ── Video play (open YouTube) ── */
        function playVideo() {
            // Replace YOUR_VIDEO_ID with actual YouTube video ID
            window.open('https://youtube.com/watch?v=YOUR_VIDEO_ID', '_blank');
        }
    </script>
</x-guest-layout>
