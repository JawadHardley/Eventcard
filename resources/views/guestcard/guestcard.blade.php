<x-guest-layout>
    @section('title', $event->order_name . ' — Your Invitation')

    {{-- ═══════════════════════════════════════════════════════════
     CINEMATIC INTRO OVERLAY  (fades out after ~1.8s)
════════════════════════════════════════════════════════════ --}}
    <div id="gc-intro" aria-hidden="true">
        <div id="gc-intro-logo">

            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm">
                <img src="{{ asset('storage/logos/logo1.png') }}" alt="Tapeventcard Logo">
            </div>
            <span>TapEventCard</span>
        </div>
        <div id="gc-intro-title">{{ $event->order_name }}</div>
        <div id="gc-intro-line"></div>
        <div id="gc-intro-sub">Your personal invitation awaits</div>
        <div id="gc-intro-sweep"></div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
     FLOATING PERSISTENT PANEL
════════════════════════════════════════════════════════════ --}}
    <div id="gc-float-bar" class="gc-float-bar">
        <div class="gc-float-code" id="gc-float-copy" onclick="gcCopyCode()" title="Copy invitation code">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24">
                <rect x="9" y="9" width="13" height="13" rx="2" stroke="currentColor" stroke-width="2" />
                <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" stroke="currentColor" stroke-width="2" />
            </svg>
            <span id="gc-float-code-text">{{ $guest->invitation_code }}</span>
        </div>
        <a href="#rsvp" class="gc-float-rsvp">RSVP</a>
        <button id="gc-music-btn" class="gc-float-music" onclick="gcToggleMusic()" title="Toggle ambient music">
            <svg id="gc-music-icon-on" width="15" height="15" fill="none" viewBox="0 0 24 24">
                <path d="M9 18V5l12-2v13" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                <circle cx="6" cy="18" r="3" stroke="currentColor" stroke-width="2" />
                <circle cx="18" cy="16" r="3" stroke="currentColor" stroke-width="2" />
            </svg>
            <svg id="gc-music-icon-off" width="15" height="15" fill="none" viewBox="0 0 24 24"
                style="display:none">
                <path d="M9 18V5l12-2v13M3 3l18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>
    </div>

    {{-- hidden audio (replace src with your ambient track) --}}
    <audio id="gc-audio" loop preload="none">
        <source src="https://cdn.pixabay.com/download/audio/2022/03/15/audio_8f6a29cd52.mp3" type="audio/mpeg">
    </audio>

    {{-- ═══════════════════════════════════════════════════════════
     HERO
════════════════════════════════════════════════════════════ --}}
    <section id="gc-hero" class="gc-hero" style="--hero-bg:url('{{ asset('storage/images/event-hero.jpg') }}')">

        {{-- layered bg --}}
        <div class="gc-hero-bg-img"></div>
        <div class="gc-hero-overlay"></div>
        <div class="gc-hero-noise"></div>

        {{-- particles --}}
        <canvas id="gc-particles" class="gc-particles-canvas" aria-hidden="true"></canvas>

        {{-- content --}}
        <div class="gc-hero-content">
            <div class="gc-hero-eyebrow fade-up delay-1">
                <span class="gc-dot-pulse"></span>
                You're Invited
            </div>

            <h1 class="gc-hero-title fade-up delay-2">{{ $event->order_name }}</h1>

            <p class="gc-hero-host fade-up delay-3">
                Hosted by <strong>{{ $event->event_host }}</strong>
            </p>

            <p class="gc-hero-guest fade-up delay-4">
                Dear <em>{{ $guest->full_name }}</em>, welcome.
            </p>

            {{-- Countdown --}}
            <div class="gc-countdown fade-up delay-5" id="gc-countdown-wrap">
                <div class="gc-cd-box"><span class="gc-cd-num" id="days">00</span><span
                        class="gc-cd-lbl">Days</span></div>
                <div class="gc-cd-sep">:</div>
                <div class="gc-cd-box"><span class="gc-cd-num" id="hours">00</span><span
                        class="gc-cd-lbl">Hours</span></div>
                <div class="gc-cd-sep">:</div>
                <div class="gc-cd-box"><span class="gc-cd-num" id="minutes">00</span><span
                        class="gc-cd-lbl">Min</span></div>
                <div class="gc-cd-sep">:</div>
                <div class="gc-cd-box"><span class="gc-cd-num" id="seconds">00</span><span
                        class="gc-cd-lbl">Sec</span></div>
            </div>

            <div class="gc-hero-cta fade-up delay-5">
                <a href="#details" class="gc-btn-primary">
                    <span>View Details</span>
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                        <path d="M12 5v14m-7-7l7 7 7-7" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- scroll hint --}}
        <div class="gc-scroll-hint" aria-hidden="true">
            <div class="gc-scroll-line"></div>
            <span>Scroll</span>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
     EVENT DETAILS
════════════════════════════════════════════════════════════ --}}
    <section id="details" class="gc-section">
        <div class="gc-container">
            <div class="gc-eyebrow sr-up">The Details</div>
            <h2 class="gc-section-title sr-up">Everything you need to know</h2>

            <div class="gc-details-grid">
                {{-- Info cards --}}
                <div class="gc-info-cards">
                    <div class="gc-info-card sr-up" data-tilt>
                        <div class="gc-info-icon" style="--ic:#e8120a">
                            <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="3" stroke="currentColor"
                                    stroke-width="1.8" />
                                <path d="M3 9h18M8 2v4M16 2v4" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <div>
                            <div class="gc-info-label">Date</div>
                            <div class="gc-info-value">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('l, j F Y') }}</div>
                        </div>
                    </div>

                    <div class="gc-info-card sr-up" data-tilt>
                        <div class="gc-info-icon" style="--ic:#e8a80a">
                            <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" stroke="currentColor"
                                    stroke-width="1.8" />
                                <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <div>
                            <div class="gc-info-label">Arrival Time</div>
                            <div class="gc-info-value">
                                {{ \Carbon\Carbon::parse($event->arrival_time)->format('g:i A') }}</div>
                        </div>
                    </div>

                    <div class="gc-info-card sr-up" data-tilt>
                        <div class="gc-info-icon" style="--ic:#0ae870">
                            <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                                    stroke="currentColor" stroke-width="1.8" />
                                <circle cx="12" cy="9" r="2.5" stroke="currentColor"
                                    stroke-width="1.8" />
                            </svg>
                        </div>
                        <div>
                            <div class="gc-info-label">Venue</div>
                            <div class="gc-info-value">{{ $event->event_location }}</div>
                        </div>
                    </div>

                    @if ($event->dress_code ?? false)
                        <div class="gc-info-card sr-up" data-tilt>
                            <div class="gc-info-icon" style="--ic:#a00ae8">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                                    <path d="M4 21L8 3l4 3 4-3 4 18" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div>
                                <div class="gc-info-label">Dress Code</div>
                                <div class="gc-info-value">{{ $event->dress_code }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($event->event_desc ?? false)
                        <div class="gc-info-card gc-info-card--wide sr-up">
                            <div class="gc-info-icon" style="--ic:#0a8ce8">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"
                                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div>
                                <div class="gc-info-label">Message from the Host</div>
                                <div class="gc-info-value" style="font-style:italic;opacity:.85">
                                    {{ $event->event_desc }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- QR card --}}
                <div class="gc-qr-card sr-up" data-tilt>
                    <div class="gc-qr-badge">Entrance Pass</div>
                    <div class="gc-qr-wrap">
                        {!! QrCode::size(170)->generate($guest->more ?? url('/guest/' . $guest->qrcode)) !!}
                    </div>
                    <div class="gc-qr-name">{{ $guest->full_name }}</div>
                    <div class="gc-qr-type">{{ ucfirst($guest->title ?? 'Guest') }}</div>
                    <div class="gc-qr-code-row">
                        <span class="gc-qr-code-label">Invitation Code</span>
                        <span class="gc-qr-code-value" onclick="gcCopyCode()">{{ $guest->invitation_code }}</span>
                    </div>
                    <p class="gc-qr-hint">Present at entrance</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
     GALLERY / IMAGE SHOWCASE
════════════════════════════════════════════════════════════ --}}
    <section id="gallery" class="gc-section gc-section--dark">
        <div class="gc-container">
            <div class="gc-eyebrow gc-eyebrow--light sr-up">Gallery</div>
            <h2 class="gc-section-title gc-section-title--light sr-up">Memories in the Making</h2>
        </div>

        <div class="gc-gallery-outer sr-up">
            <div class="gc-gallery-track" id="gc-gallery-track">
                @php
                    $images = [
                        asset('storage/images/img1.png'),
                        asset('storage/images/img2.png'),
                        asset('storage/images/img3.png'),
                    ];
                @endphp
                @foreach ($images as $i => $img)
                    <div class="gc-gallery-slide {{ $i === 0 ? 'active' : '' }}"
                        style="--slide-img:url('{{ $img }}')">
                        <div class="gc-gallery-slide-inner"></div>
                        <div class="gc-gallery-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    </div>
                @endforeach
            </div>

            <button class="gc-gallery-btn gc-gallery-btn--prev" onclick="gcGalleryPrev()" aria-label="Previous">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
            <button class="gc-gallery-btn gc-gallery-btn--next" onclick="gcGalleryNext()" aria-label="Next">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                    <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>

            <div class="gc-gallery-dots" id="gc-gallery-dots">
                @foreach ($images as $i => $img)
                    <button class="gc-gdot {{ $i === 0 ? 'active' : '' }}"
                        onclick="gcGalleryGo({{ $i }})" aria-label="Slide {{ $i + 1 }}"></button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
     LOCATION
════════════════════════════════════════════════════════════ --}}
    <section id="location" class="gc-section">
        <div class="gc-container">
            <div class="gc-eyebrow sr-up">Location</div>
            <h2 class="gc-section-title sr-up">Find your way</h2>

            <div class="gc-location-grid sr-up">
                <div class="gc-location-info">
                    <div class="gc-location-place">{{ $event->event_location }}</div>
                    @if ($event->event_address ?? false)
                        <div class="gc-location-address">{{ $event->event_address }}</div>
                    @endif
                    <a href="https://maps.google.com/?q={{ urlencode($event->event_location) }}" target="_blank"
                        rel="noopener" class="gc-btn-primary gc-btn-primary--sm"
                        style="margin-top:1.5rem;display:inline-flex">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                                stroke="currentColor" stroke-width="2" />
                            <circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="2" />
                        </svg>
                        Get Directions
                    </a>
                </div>
                <div class="gc-map-embed">
                    <iframe title="Event location" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        src="https://maps.google.com/maps?q={{ urlencode($event->event_location) }}&output=embed&z=15"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
     RSVP
════════════════════════════════════════════════════════════ --}}
    <section id="rsvp" class="gc-section gc-section--rsvp">
        <div class="gc-rsvp-glow" aria-hidden="true"></div>
        <div class="gc-container" style="position:relative;z-index:1">
            <div class="gc-eyebrow gc-eyebrow--light sr-up">RSVP</div>
            <h2 class="gc-section-title gc-section-title--light sr-up">Will you be joining us?</h2>
            <p class="gc-rsvp-sub sr-up">Dear <strong>{{ $guest->full_name }}</strong>, we'd love to have you there.
            </p>

            <div class="gc-rsvp-btns sr-up">
                <button class="gc-rsvp-yes" id="gc-rsvp-yes" onclick="gcRsvp('yes')">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                    I'll be there!
                </button>
                <button class="gc-rsvp-no" id="gc-rsvp-no" onclick="gcRsvp('no')">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
                        <path d="M15 9l-6 6M9 9l6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    Unable to attend
                </button>
            </div>
            <div id="gc-rsvp-msg" class="gc-rsvp-confirm" style="display:none"></div>

            <div class="gc-calendar-cta sr-up">
                <button onclick="gcAddToCalendar()" class="gc-btn-ghost">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="3" stroke="currentColor"
                            stroke-width="2" />
                        <path d="M3 9h18M8 2v4M16 2v4M12 14v4M10 16h4" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                    Add to Calendar
                </button>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
     FOOTER
════════════════════════════════════════════════════════════ --}}
    <footer class="gc-footer">
        <div class="gc-footer-inner">
            <div class="gc-footer-logo">
                <svg width="20" height="20" viewBox="0 0 36 36" fill="none">
                    <circle cx="18" cy="18" r="16" stroke="currentColor" stroke-width="1.5"
                        opacity=".4" />
                    <circle cx="18" cy="18" r="5" fill="currentColor" />
                </svg>
                TapEventCard
            </div>
            <p class="gc-footer-note">This invitation was sent personally to <strong>{{ $guest->full_name }}</strong>.
                Please do not share.</p>
            <p class="gc-footer-copy">© {{ date('Y') }} TapEventCard</p>
        </div>
    </footer>

    {{-- ═══════════════════════════════════════════════════════════
     STYLES
════════════════════════════════════════════════════════════ --}}
    <style>
        /* ── Fonts ── */
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500;600&display=swap');

        /* ── Tokens ── */
        :root {
            --gc-red: #e8120a;
            --gc-red2: #c41009;
            --gc-gold: #c9a84c;
            --gc-dark: #080808;
            --gc-dark2: #111;
            --gc-surface: rgba(255, 255, 255, .06);
            --gc-border: rgba(255, 255, 255, .1);
            --gc-blur: blur(24px) saturate(180%);
            --gc-radius: 24px;
            --gc-font-display: 'Playfair Display', Georgia, serif;
            --gc-font-body: 'DM Sans', sans-serif;
        }

        /* ── Page base ── */
        html,
        body {
            scroll-behavior: smooth;
        }

        body {
            background: #000;
            color: #fff;
            font-family: var(--gc-font-body);
        }

        /* ─────────── INTRO OVERLAY ─────────── */
        #gc-intro {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: #000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .75rem;
            transition: opacity .7s ease, visibility .7s ease;
            overflow: hidden;
        }

        #gc-intro.gc-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        #gc-intro-sweep {
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255, 255, 255, .07) 50%, transparent 60%);
            transform: translateX(-100%);
            animation: gcSweep 1.4s ease .3s forwards;
        }

        @keyframes gcSweep {
            to {
                transform: translateX(200%);
            }
        }

        #gc-intro-logo {
            display: flex;
            align-items: center;
            gap: .6rem;
            color: rgba(255, 255, 255, .45);
            font-size: .8rem;
            letter-spacing: .14em;
            text-transform: uppercase;
            opacity: 0;
            animation: gcFadeUp .5s ease .1s forwards;
        }

        #gc-intro-title {
            font-family: var(--gc-font-display);
            font-size: clamp(1.8rem, 6vw, 4rem);
            font-weight: 700;
            color: #fff;
            text-align: center;
            opacity: 0;
            animation: gcFadeUp .6s ease .4s forwards;
        }

        #gc-intro-line {
            width: 0;
            height: 1px;
            background: var(--gc-gold);
            animation: gcLine .8s ease .7s forwards;
        }

        @keyframes gcLine {
            to {
                width: 120px;
            }
        }

        #gc-intro-sub {
            font-size: .78rem;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .35);
            opacity: 0;
            animation: gcFadeUp .5s ease 1s forwards;
        }

        @keyframes gcFadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ─────────── FLOAT BAR ─────────── */
        .gc-float-bar {
            position: fixed;
            bottom: 1.5rem;
            left: 50%;
            transform: translateX(-50%) translateY(120px);
            z-index: 500;
            display: flex;
            align-items: center;
            gap: .5rem;
            background: rgba(10, 10, 10, .82);
            backdrop-filter: var(--gc-blur);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 980px;
            padding: .45rem .55rem;
            transition: transform .6s cubic-bezier(.34, 1.56, .64, 1), opacity .4s;
            opacity: 0;
        }

        .gc-float-bar.gc-visible {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .gc-float-code {
            display: flex;
            align-items: center;
            gap: .4rem;
            background: rgba(255, 255, 255, .07);
            border-radius: 980px;
            padding: .35rem .85rem;
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .08em;
            color: rgba(255, 255, 255, .7);
            cursor: pointer;
            transition: background .2s, color .2s;
            white-space: nowrap;
        }

        .gc-float-code:hover {
            background: rgba(255, 255, 255, .14);
            color: #fff;
        }

        .gc-float-rsvp {
            background: var(--gc-red);
            color: #fff;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            border-radius: 980px;
            padding: .4rem 1.1rem;
            text-decoration: none;
            transition: background .2s, transform .15s;
        }

        .gc-float-rsvp:hover {
            background: var(--gc-red2);
            transform: scale(1.04);
        }

        .gc-float-music {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, .6);
            transition: background .2s, color .2s;
        }

        .gc-float-music:hover {
            background: rgba(255, 255, 255, .16);
            color: #fff;
        }

        .gc-float-music.gc-playing {
            background: rgba(232, 18, 10, .25);
            color: var(--gc-red);
        }

        /* ─────────── HERO ─────────── */
        .gc-hero {
            position: relative;
            min-height: 100svh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            isolation: isolate;
        }

        .gc-hero-bg-img {
            position: absolute;
            inset: -5%;
            background: var(--hero-bg) center/cover no-repeat;
            transform: scale(1.1);
            transition: transform 8s ease;
            will-change: transform;
        }

        .gc-hero-bg-img.gc-loaded {
            transform: scale(1);
        }

        .gc-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(0, 0, 0, .35) 0%,
                    rgba(0, 0, 0, .55) 50%,
                    rgba(0, 0, 0, .9) 100%);
        }

        .gc-hero-noise {
            position: absolute;
            inset: 0;
            opacity: .04;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        .gc-particles-canvas {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .gc-hero-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 2rem 1.5rem;
            max-width: 820px;
        }

        .gc-hero-eyebrow {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .72rem;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .6);
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 980px;
            padding: .35rem 1rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, .07);
        }

        .gc-dot-pulse {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--gc-red);
            box-shadow: 0 0 0 0 rgba(232, 18, 10, .6);
            animation: gcPulse 2s infinite;
        }

        @keyframes gcPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(232, 18, 10, .6);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(232, 18, 10, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(232, 18, 10, 0);
            }
        }

        .gc-hero-title {
            font-family: var(--gc-font-display);
            font-size: clamp(2.8rem, 8vw, 6rem);
            font-weight: 900;
            line-height: 1.05;
            color: #fff;
            margin-bottom: 1rem;
            text-shadow: 0 4px 60px rgba(0, 0, 0, .5);
            letter-spacing: -.02em;
        }

        .gc-hero-host {
            font-size: clamp(.95rem, 2.5vw, 1.2rem);
            color: rgba(255, 255, 255, .65);
            margin-bottom: .5rem;
        }

        .gc-hero-guest {
            font-size: clamp(1.05rem, 2.5vw, 1.35rem);
            color: rgba(255, 255, 255, .85);
            margin-bottom: 2.5rem;
        }

        .gc-hero-guest em {
            font-style: normal;
            color: var(--gc-gold);
            font-family: var(--gc-font-display);
        }

        /* Countdown */
        .gc-countdown {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: 2.5rem;
        }

        .gc-cd-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(0, 0, 0, .55);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 16px;
            padding: .9rem 1.3rem;
            min-width: 72px;
        }

        .gc-cd-num {
            font-family: var(--gc-font-display);
            font-size: 2.2rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
            font-variant-numeric: tabular-nums;
        }

        .gc-cd-lbl {
            font-size: .62rem;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .4);
            margin-top: .3rem;
        }

        .gc-cd-sep {
            font-size: 2rem;
            color: rgba(255, 255, 255, .2);
            font-weight: 300;
            margin-top: -.4rem;
        }

        /* CTA */
        .gc-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: var(--gc-red);
            color: #fff;
            font-weight: 600;
            font-size: .95rem;
            border-radius: 980px;
            padding: .85rem 2rem;
            text-decoration: none;
            transition: background .2s, transform .2s, box-shadow .2s;
            box-shadow: 0 8px 32px rgba(232, 18, 10, .35);
        }

        .gc-btn-primary:hover {
            background: var(--gc-red2);
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(232, 18, 10, .5);
        }

        .gc-btn-primary--sm {
            padding: .6rem 1.4rem;
            font-size: .85rem;
        }

        /* Scroll hint */
        .gc-scroll-hint {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .4rem;
            font-size: .65rem;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .3);
            animation: gcBob 2.2s ease-in-out infinite;
        }

        .gc-scroll-line {
            width: 1px;
            height: 36px;
            background: linear-gradient(to bottom, rgba(255, 255, 255, .4), transparent);
        }

        @keyframes gcBob {

            0%,
            100% {
                transform: translateX(-50%) translateY(0)
            }

            50% {
                transform: translateX(-50%) translateY(8px)
            }
        }

        /* ─────────── SECTIONS ─────────── */
        .gc-section {
            padding: 7rem 0;
            background: #fff;
        }

        html.dark .gc-section {
            background: #0a0a0a;
        }

        .gc-section--dark {
            background: var(--gc-dark2);
        }

        .gc-container {
            max-width: 1080px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .gc-eyebrow {
            font-size: .68rem;
            letter-spacing: .2em;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--gc-red);
            margin-bottom: .4rem;
        }

        .gc-eyebrow--light {
            color: rgba(255, 255, 255, .4);
        }

        .gc-section-title {
            font-family: var(--gc-font-display);
            font-size: clamp(1.9rem, 4vw, 3rem);
            font-weight: 700;
            color: #1d1d1f;
            line-height: 1.15;
            margin-bottom: 3rem;
            transition: color .3s;
        }

        html.dark .gc-section-title {
            color: #fff;
        }

        .gc-section-title--light {
            color: #fff;
        }

        /* ─────────── DETAILS GRID ─────────── */
        .gc-details-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 2.5rem;
            align-items: start;
        }

        @media (max-width:860px) {
            .gc-details-grid {
                grid-template-columns: 1fr;
            }
        }

        .gc-info-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width:540px) {
            .gc-info-cards {
                grid-template-columns: 1fr;
            }
        }

        .gc-info-card {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 20px;
            padding: 1.4rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: transform .3s ease, box-shadow .3s ease, background .3s;
            will-change: transform;
            transform-style: preserve-3d;
        }

        html.dark .gc-info-card {
            background: #1a1a1a;
            border-color: rgba(255, 255, 255, .06);
        }

        .gc-info-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 56px rgba(0, 0, 0, .1);
        }

        .gc-info-card--wide {
            grid-column: 1 / -1;
        }

        .gc-info-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: color-mix(in srgb, var(--ic) 12%, transparent);
            color: var(--ic);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .gc-info-label {
            font-size: .68rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            font-weight: 700;
            color: #86868b;
            margin-bottom: .25rem;
        }

        .gc-info-value {
            font-size: .95rem;
            font-weight: 500;
            color: #1d1d1f;
            line-height: 1.4;
        }

        html.dark .gc-info-value {
            color: #f5f5f7;
        }

        /* QR Card */
        .gc-qr-card {
            background: linear-gradient(145deg, #111 0%, #1c1c1c 100%);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: var(--gc-radius);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            will-change: transform;
            transform-style: preserve-3d;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .gc-qr-card:hover {
            transform: perspective(900px) rotateX(-2deg) translateY(-4px);
            box-shadow: 0 32px 80px rgba(0, 0, 0, .5);
        }

        .gc-qr-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gc-red);
            color: #fff;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            border-radius: 980px;
            padding: .25rem .9rem;
        }

        .gc-qr-wrap {
            background: #fff;
            border-radius: 16px;
            padding: 1rem;
            margin: 1.5rem 0 1rem;
        }

        .gc-qr-wrap svg {
            display: block;
        }

        .gc-qr-name {
            font-family: var(--gc-font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: .25rem;
        }

        .gc-qr-type {
            font-size: .72rem;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .35);
            margin-bottom: 1.25rem;
        }

        .gc-qr-code-row {
            width: 100%;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .09);
            border-radius: 12px;
            padding: .7rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .gc-qr-code-label {
            font-size: .68rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .35);
        }

        .gc-qr-code-value {
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: .12em;
            color: var(--gc-gold);
            cursor: pointer;
            transition: color .2s;
        }

        .gc-qr-code-value:hover {
            color: #fff;
        }

        .gc-qr-hint {
            font-size: .72rem;
            color: rgba(255, 255, 255, .25);
            margin-top: .75rem;
        }

        /* ─────────── GALLERY ─────────── */
        .gc-gallery-outer {
            position: relative;
            overflow: hidden;
            height: clamp(320px, 55vw, 600px);
            margin-top: 2rem;
        }

        .gc-gallery-track {
            height: 100%;
        }

        .gc-gallery-slide {
            position: absolute;
            inset: 0;
            background: var(--slide-img) center/cover no-repeat;
            opacity: 0;
            transition: opacity .7s ease;
        }

        .gc-gallery-slide.active {
            opacity: 1;
        }

        .gc-gallery-slide-inner {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, .6) 0%, transparent 55%);
        }

        .gc-gallery-num {
            position: absolute;
            bottom: 1.75rem;
            right: 2rem;
            font-family: var(--gc-font-display);
            font-size: 4rem;
            font-weight: 900;
            line-height: 1;
            color: rgba(255, 255, 255, .12);
            pointer-events: none;
            letter-spacing: -.04em;
        }

        .gc-gallery-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, .55);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, .12);
            color: #fff;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: background .2s, transform .2s;
        }

        .gc-gallery-btn:hover {
            background: rgba(0, 0, 0, .8);
            transform: translateY(-50%) scale(1.08);
        }

        .gc-gallery-btn--prev {
            left: 1.5rem;
        }

        .gc-gallery-btn--next {
            right: 1.5rem;
        }

        .gc-gallery-dots {
            position: absolute;
            bottom: 1.5rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: .5rem;
            z-index: 10;
        }

        .gc-gdot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .3);
            border: none;
            cursor: pointer;
            transition: background .2s, transform .2s;
            padding: 0;
        }

        .gc-gdot.active {
            background: #fff;
            transform: scale(1.4);
        }

        /* ─────────── LOCATION ─────────── */
        .gc-location-grid {
            display: grid;
            grid-template-columns: 1fr 1.6fr;
            gap: 2rem;
            align-items: center;
        }

        @media (max-width:720px) {
            .gc-location-grid {
                grid-template-columns: 1fr;
            }
        }

        .gc-location-place {
            font-family: var(--gc-font-display);
            font-size: 1.6rem;
            font-weight: 700;
            color: #1d1d1f;
            margin-bottom: .5rem;
        }

        html.dark .gc-location-place {
            color: #fff;
        }

        .gc-location-address {
            color: #6e6e73;
            font-size: .9rem;
        }

        html.dark .gc-location-address {
            color: #86868b;
        }

        .gc-map-embed {
            border-radius: var(--gc-radius);
            overflow: hidden;
            aspect-ratio: 16/9;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .12);
            border: 1px solid rgba(0, 0, 0, .07);
        }

        html.dark .gc-map-embed {
            border-color: rgba(255, 255, 255, .08);
        }

        .gc-map-embed iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }

        /* ─────────── RSVP SECTION ─────────── */
        .gc-section--rsvp {
            background: var(--gc-dark);
            text-align: center;
            padding: 7rem 0;
            position: relative;
            overflow: hidden;
        }

        .gc-rsvp-glow {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: radial-gradient(ellipse 70% 60% at 50% 50%, rgba(232, 18, 10, .12), transparent 70%);
        }

        .gc-rsvp-sub {
            color: rgba(255, 255, 255, .55);
            font-size: 1rem;
            margin-bottom: 2.5rem;
        }

        .gc-rsvp-sub strong {
            color: rgba(255, 255, 255, .8);
        }

        .gc-rsvp-btns {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .gc-rsvp-yes {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            background: #34c759;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            border-radius: 980px;
            padding: .9rem 2.2rem;
            cursor: pointer;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 8px 28px rgba(52, 199, 89, .3);
        }

        .gc-rsvp-yes:hover {
            background: #28a745;
            transform: translateY(-2px);
            box-shadow: 0 12px 36px rgba(52, 199, 89, .45);
        }

        .gc-rsvp-no {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, .14);
            color: rgba(255, 255, 255, .7);
            font-weight: 600;
            font-size: 1rem;
            border-radius: 980px;
            padding: .9rem 2.2rem;
            cursor: pointer;
            transition: background .2s, color .2s;
        }

        .gc-rsvp-no:hover {
            background: rgba(255, 59, 48, .15);
            color: #ff3b30;
            border-color: rgba(255, 59, 48, .3);
        }

        .gc-rsvp-confirm {
            font-size: 1rem;
            color: rgba(255, 255, 255, .7);
            animation: gcFadeUp .4s ease;
        }

        .gc-btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(255, 255, 255, .07);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .6);
            font-size: .85rem;
            font-weight: 500;
            border-radius: 980px;
            padding: .65rem 1.6rem;
            cursor: pointer;
            transition: background .2s, color .2s;
        }

        .gc-btn-ghost:hover {
            background: rgba(255, 255, 255, .12);
            color: #fff;
        }

        /* ─────────── FOOTER ─────────── */
        .gc-footer {
            background: #000;
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .gc-footer-inner {
            max-width: 600px;
            margin: 0 auto;
        }

        .gc-footer-logo {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: rgba(255, 255, 255, .3);
            font-size: .8rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .gc-footer-note {
            font-size: .78rem;
            color: rgba(255, 255, 255, .2);
            margin-bottom: .5rem;
        }

        .gc-footer-copy {
            font-size: .72rem;
            color: rgba(255, 255, 255, .15);
        }

        /* ─────────── SCROLL REVEAL ─────────── */
        .sr-up {
            opacity: 0;
            transform: translateY(36px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .sr-up.sr-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ─────────── FADE-UP (hero) ─────────── */
        .fade-up {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .6s ease, transform .6s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .delay-1 {
            transition-delay: .1s !important;
        }

        .delay-2 {
            transition-delay: .25s !important;
        }

        .delay-3 {
            transition-delay: .4s !important;
        }

        .delay-4 {
            transition-delay: .55s !important;
        }

        .delay-5 {
            transition-delay: .7s !important;
        }

        /* ─────────── MOBILE ─────────── */
        @media (max-width:600px) {
            .gc-countdown {
                gap: .3rem;
            }

            .gc-cd-box {
                padding: .7rem .8rem;
                min-width: 58px;
            }

            .gc-cd-num {
                font-size: 1.6rem;
            }

            .gc-info-cards {
                grid-template-columns: 1fr;
            }

            .gc-details-grid {
                gap: 2rem;
            }

            .gc-gallery-btn {
                width: 38px;
                height: 38px;
            }
        }
    </style>

    {{-- ═══════════════════════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════════════════════════ --}}
    <script>
        (function() {
            'use strict';

            /* ── Intro reveal ── */
            const intro = document.getElementById('gc-intro');
            const floatBar = document.getElementById('gc-float-bar');
            const heroBgImg = document.querySelector('.gc-hero-bg-img');

            window.addEventListener('load', () => {
                setTimeout(() => {
                    intro.classList.add('gc-hidden');
                    // Trigger hero bg zoom-out after intro fades
                    if (heroBgImg) heroBgImg.classList.add('gc-loaded');

                    // Show hero elements
                    document.querySelectorAll('#gc-hero .fade-up').forEach((el, i) => {
                        setTimeout(() => el.classList.add('visible'), 120 + i * 90);
                    });

                    // Show float bar after a moment
                    setTimeout(() => floatBar.classList.add('gc-visible'), 1400);
                }, 2000);
            });

            /* ── Countdown ── */
            function gcCountdown() {
                const eventDate = new Date('{{ $event->event_date }} {{ $event->arrival_time }}').getTime();
                const now = Date.now();
                const diff = Math.max(0, eventDate - now);
                const d = Math.floor(diff / 86400000);
                const h = Math.floor((diff % 86400000) / 3600000);
                const m = Math.floor((diff % 3600000) / 60000);
                const s = Math.floor((diff % 60000) / 1000);
                const pad = n => String(n).padStart(2, '0');

                // Animate only when digit changes
                ['days', 'hours', 'minutes', 'seconds'].forEach((id, i) => {
                    const el = document.getElementById(id);
                    const vals = [d, h, m, s];
                    if (!el) return;
                    const newVal = pad(vals[i]);
                    if (el.textContent !== newVal) {
                        el.textContent = newVal;
                        el.parentElement.classList.remove('gc-cd-tick');
                        void el.parentElement.offsetWidth;
                        el.parentElement.classList.add('gc-cd-tick');
                    }
                });
            }
            setInterval(gcCountdown, 1000);
            gcCountdown();

            /* ── Gallery ── */
            let gcSlide = 0;
            const gcSlides = document.querySelectorAll('.gc-gallery-slide');
            const gcDots = document.querySelectorAll('.gc-gdot');
            const gcLen = gcSlides.length;
            let gcAutoTimer = null;

            function gcGalleryGo(i) {
                gcSlides[gcSlide].classList.remove('active');
                gcDots[gcSlide].classList.remove('active');
                gcSlide = (i + gcLen) % gcLen;
                gcSlides[gcSlide].classList.add('active');
                gcDots[gcSlide].classList.add('active');
                gcResetAuto();
            }
            window.gcGalleryNext = () => gcGalleryGo(gcSlide + 1);
            window.gcGalleryPrev = () => gcGalleryGo(gcSlide - 1);
            window.gcGalleryGo = gcGalleryGo;

            function gcResetAuto() {
                clearInterval(gcAutoTimer);
                gcAutoTimer = setInterval(() => gcGalleryGo(gcSlide + 1), 3000);
            }
            gcResetAuto();

            /* ── Copy code ── */
            window.gcCopyCode = function() {
                const code = '{{ $guest->invitation_code }}';
                if (!navigator.clipboard) return;
                navigator.clipboard.writeText(code).then(() => {
                    const el = document.getElementById('gc-float-code-text');
                    const prev = el.textContent;
                    el.textContent = 'Copied!';
                    setTimeout(() => {
                        el.textContent = prev;
                    }, 1600);
                });
            };

            /* ── Music toggle ── */
            const gcAudio = document.getElementById('gc-audio');
            const gcMusicBtn = document.getElementById('gc-music-btn');
            const gcIconOn = document.getElementById('gc-music-icon-on');
            const gcIconOff = document.getElementById('gc-music-icon-off');
            let gcPlaying = false;

            window.gcToggleMusic = function() {
                if (gcPlaying) {
                    gcAudio.pause();
                    gcPlaying = false;
                    gcMusicBtn.classList.remove('gc-playing');
                    gcIconOn.style.display = '';
                    gcIconOff.style.display = 'none';
                } else {
                    gcAudio.play().then(() => {
                        gcPlaying = true;
                        gcMusicBtn.classList.add('gc-playing');
                        gcIconOn.style.display = 'none';
                        gcIconOff.style.display = '';
                    }).catch(() => {});
                }
            };

            /* ── RSVP ── */
            window.gcRsvp = function(choice) {
                const msg = document.getElementById('gc-rsvp-msg');
                const yes = document.getElementById('gc-rsvp-yes');
                const no = document.getElementById('gc-rsvp-no');
                yes.disabled = no.disabled = true;
                if (choice === 'yes') {
                    yes.style.background = '#28a745';
                    msg.innerHTML = '🎉 Wonderful! We can\'t wait to celebrate with you.';
                } else {
                    no.style.borderColor = 'rgba(255,59,48,.5)';
                    msg.innerHTML = '💛 We\'ll miss you. Thank you for letting us know.';
                }
                msg.style.display = 'block';
            };

            /* ── Add to Calendar ── */
            window.gcAddToCalendar = function() {
                const title = encodeURIComponent('{{ $event->order_name }}');
                const location = encodeURIComponent('{{ $event->event_location }}');
                const start =
                    '{{ \Carbon\Carbon::parse($event->event_date)->format('Ymd') }}T{{ \Carbon\Carbon::parse($event->arrival_time)->format('His') }}';
                window.open(
                    `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${title}&dates=${start}/${start}&location=${location}`,
                    '_blank');
            };

            /* ── Parallax hero bg on scroll ── */
            const heroSection = document.getElementById('gc-hero');
            const heroImg = document.querySelector('.gc-hero-bg-img');
            window.addEventListener('scroll', () => {
                if (!heroImg) return;
                const scrolled = window.scrollY;
                const limit = heroSection ? heroSection.offsetHeight : window.innerHeight;
                if (scrolled < limit) {
                    heroImg.style.transform = `scale(1) translateY(${scrolled * 0.25}px)`;
                }
            }, {
                passive: true
            });

            /* ── Scroll reveal ── */
            (function() {
                const els = document.querySelectorAll('.sr-up');
                const io = new IntersectionObserver(entries => {
                    entries.forEach(e => {
                        if (e.isIntersecting) {
                            e.target.classList.add('sr-visible');
                            io.unobserve(e.target);
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });
                els.forEach(el => io.observe(el));
            })();

            /* ── Tilt cards ── */
            if (!window.matchMedia('(hover:none)').matches) {
                document.querySelectorAll('[data-tilt]').forEach(card => {
                    card.addEventListener('mousemove', e => {
                        const r = card.getBoundingClientRect();
                        const rx = ((e.clientY - r.top - r.height / 2) / (r.height / 2)) * -5;
                        const ry = ((e.clientX - r.left - r.width / 2) / (r.width / 2)) * 5;
                        card.style.transform =
                            `perspective(900px) rotateX(${rx}deg) rotateY(${ry}deg) translateZ(4px)`;
                    });
                    card.addEventListener('mouseleave', () => {
                        card.style.transition = 'transform .5s cubic-bezier(.34,1.56,.64,1)';
                        card.style.transform = '';
                        setTimeout(() => {
                            card.style.transition = '';
                        }, 500);
                    });
                });
            }

            /* ── Particles canvas ── */
            (function() {
                const canvas = document.getElementById('gc-particles');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');
                let W, H, particles = [];

                function resize() {
                    W = canvas.width = canvas.offsetWidth;
                    H = canvas.height = canvas.offsetHeight;
                }
                resize();
                window.addEventListener('resize', resize, {
                    passive: true
                });

                const N = window.innerWidth < 600 ? 30 : 60;
                for (let i = 0; i < N; i++) {
                    particles.push({
                        x: Math.random() * W,
                        y: Math.random() * H,
                        r: Math.random() * 1.5 + .5,
                        vx: (Math.random() - .5) * .3,
                        vy: (Math.random() - .5) * .3,
                        o: Math.random() * .4 + .1,
                    });
                }

                function draw() {
                    ctx.clearRect(0, 0, W, H);
                    particles.forEach(p => {
                        p.x += p.vx;
                        p.y += p.vy;
                        if (p.x < 0) p.x = W;
                        if (p.x > W) p.x = 0;
                        if (p.y < 0) p.y = H;
                        if (p.y > H) p.y = 0;
                        ctx.beginPath();
                        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                        ctx.fillStyle = `rgba(255,255,255,${p.o})`;
                        ctx.fill();
                    });
                    requestAnimationFrame(draw);
                }
                draw();
            })();

        })(); // end IIFE
    </script>
    <!-- ✨ Glitter Pop Burst - Paste anywhere in your Blade template -->
    <script>
        (function() {
            // Prevent duplicate triggers (e.g., on Livewire re-renders)
            if (window.__glitterPopTriggered) return;
            window.__glitterPopTriggered = true;

            // ──────────────────────────────────────
            // Wait 5 seconds, then unleash the magic
            // ──────────────────────────────────────
            setTimeout(() => {
                // Create full-screen overlay canvas
                const canvas = document.createElement('canvas');
                canvas.style.cssText = `
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 99999;
        `;
                document.body.appendChild(canvas);

                const ctx = canvas.getContext('2d');
                const W = (canvas.width = window.innerWidth);
                const H = (canvas.height = window.innerHeight);
                const cx = W / 2;
                const cy = H / 2;

                // ──────────────────────────────────────
                // Glitter color palette
                // ──────────────────────────────────────
                const palette = [
                    '#FFD700', // gold
                    '#FFF8DC', // cornsilk
                    '#FFB6C1', // light pink
                    '#DDA0DD', // plum
                    '#F0E68C', // khaki gold
                    '#FF69B4', // hot pink
                    '#87CEEB', // sky blue shimmer
                    '#FFA07A', // light salmon
                    '#E0B0FF', // mauve
                    '#FFFFFF', // pure white sparkle
                    '#F4C430', // saffron
                    '#C0C0C0', // silver
                    '#FFDAB9', // peach
                    '#B0E0E6', // powder blue
                    '#FFF5EE', // seashell
                ];

                // ──────────────────────────────────────
                // Particle class
                // ──────────────────────────────────────
                class GlitterParticle {
                    constructor(x, y) {
                        // Spawn at burst origin
                        this.x = x;
                        this.y = y;

                        // Random launch angle & speed (radial burst)
                        const angle = Math.random() * Math.PI * 2;
                        const speed = 80 + Math.random() * 520; // px/s

                        // Slight upward bias so it bursts "out and up" prettily
                        const upwardBias = -0.4; // nudge angle upward
                        const adjustedAngle = angle + upwardBias * Math.random();

                        this.vx = Math.cos(adjustedAngle) * speed;
                        this.vy = Math.sin(adjustedAngle) * speed;

                        // Size & type
                        this.size = 2 + Math.random() * 13;
                        this.type = this.size < 4.5 ? 'dot' : 'sparkle';

                        // Color
                        this.color = palette[Math.floor(Math.random() * palette.length)];

                        // Rotation
                        this.rotation = Math.random() * Math.PI * 2;
                        this.rotationSpeed = (Math.random() - 0.5) * 8; // rad/s

                        // Lifetime
                        this.lifetime = 1.8 + Math.random() * 2.4; // seconds
                        this.age = 0;
                        this.alive = true;

                        // Twinkle
                        this.twinkle = Math.random() < 0.4;
                        this.twinkleSpeed = 6 + Math.random() * 14; // Hz
                        this.twinkleOffset = Math.random() * Math.PI * 2;
                    }

                    update(dt) {
                        this.age += dt;
                        if (this.age >= this.lifetime) {
                            this.alive = false;
                            return;
                        }

                        // Physics
                        const gravity = 220; // px/s²
                        const damping = 0.35; // air resistance factor

                        this.vx *= Math.exp(-damping * dt);
                        this.vy *= Math.exp(-damping * dt);
                        this.vy += gravity * dt;

                        this.x += this.vx * dt;
                        this.y += this.vy * dt;

                        // Rotation
                        this.rotation += this.rotationSpeed * dt;
                    }

                    getOpacity() {
                        const lifeRatio = this.age / this.lifetime;
                        // Fade in quickly, hold, then fade out
                        let opacity;
                        if (lifeRatio < 0.08) {
                            opacity = lifeRatio / 0.08; // fade in
                        } else if (lifeRatio > 0.7) {
                            opacity = 1 - (lifeRatio - 0.7) / 0.3; // fade out
                        } else {
                            opacity = 1;
                        }

                        // Twinkle modulation
                        if (this.twinkle) {
                            const twinkleVal =
                                0.55 +
                                0.45 *
                                Math.sin(
                                    this.age * this.twinkleSpeed * Math.PI * 2 +
                                    this.twinkleOffset
                                );
                            opacity *= twinkleVal;
                        }

                        return Math.max(0, Math.min(1, opacity));
                    }

                    draw(ctx) {
                        const opacity = this.getOpacity();
                        if (opacity <= 0.01) return;

                        ctx.save();
                        ctx.globalAlpha = opacity;
                        ctx.translate(this.x, this.y);
                        ctx.rotate(this.rotation);

                        if (this.type === 'dot') {
                            // Tiny glowing dot
                            const gradient = ctx.createRadialGradient(0, 0, 0, 0, 0, this.size);
                            gradient.addColorStop(0, 'rgba(255,255,255,1)');
                            gradient.addColorStop(0.35, this.color);
                            gradient.addColorStop(1, 'rgba(255,255,255,0)');
                            ctx.fillStyle = gradient;
                            ctx.beginPath();
                            ctx.arc(0, 0, this.size * 1.4, 0, Math.PI * 2);
                            ctx.fill();
                        } else {
                            // 4-point sparkle (diamond star)
                            const outer = this.size;
                            const inner = this.size * 0.3;

                            // Draw glow halo first
                            const glow = ctx.createRadialGradient(0, 0, inner * 0.5, 0, 0, outer * 1.5);
                            glow.addColorStop(0, 'rgba(255,255,255,0.9)');
                            glow.addColorStop(0.4, this.color);
                            glow.addColorStop(1, 'rgba(255,255,255,0)');
                            ctx.fillStyle = glow;
                            ctx.beginPath();
                            ctx.arc(0, 0, outer * 1.5, 0, Math.PI * 2);
                            ctx.fill();

                            // Draw the sharp sparkle shape
                            ctx.fillStyle = this.color;
                            ctx.strokeStyle = 'rgba(255,255,255,0.9)';
                            ctx.lineWidth = 0.6;
                            ctx.shadowColor = 'rgba(255,255,255,0.7)';
                            ctx.shadowBlur = outer * 0.5;
                            ctx.beginPath();
                            // Top point
                            ctx.moveTo(0, -outer);
                            // Inner right-top
                            ctx.lineTo(inner * 0.7, -inner * 0.7);
                            // Right point
                            ctx.lineTo(outer, 0);
                            // Inner right-bottom
                            ctx.lineTo(inner * 0.7, inner * 0.7);
                            // Bottom point
                            ctx.lineTo(0, outer);
                            // Inner left-bottom
                            ctx.lineTo(-inner * 0.7, inner * 0.7);
                            // Left point
                            ctx.lineTo(-outer, 0);
                            // Inner left-top
                            ctx.lineTo(-inner * 0.7, -inner * 0.7);
                            ctx.closePath();
                            ctx.fill();
                            ctx.stroke();
                            ctx.shadowBlur = 0;

                            // Tiny white core highlight
                            ctx.fillStyle = 'rgba(255,255,255,0.95)';
                            ctx.beginPath();
                            ctx.arc(0, 0, inner * 0.55, 0, Math.PI * 2);
                            ctx.fill();
                        }

                        ctx.restore();
                    }
                }

                // ──────────────────────────────────────
                // Create particles
                // ──────────────────────────────────────
                const particleCount = 200;
                const particles = [];
                for (let i = 0; i < particleCount; i++) {
                    particles.push(new GlitterParticle(cx, cy));
                }

                // ──────────────────────────────────────
                // Flash / "pop" glow state
                // ──────────────────────────────────────
                const flash = {
                    x: cx,
                    y: cy,
                    age: 0,
                    duration: 0.55, // seconds
                    maxRadius: 220,
                    alive: true,
                };

                // ──────────────────────────────────────
                // Animation loop
                // ──────────────────────────────────────
                let lastTime = performance.now();
                let animFrameId;

                function animate(now) {
                    let dt = (now - lastTime) / 1000;
                    lastTime = now;

                    // Clamp dt to avoid physics explosions
                    if (dt > 0.12) dt = 0.12;
                    if (dt <= 0) dt = 0.016;

                    // Clear canvas
                    ctx.clearRect(0, 0, W, H);

                    // ── Update & draw flash ─────────────────
                    if (flash.alive) {
                        flash.age += dt;
                        const flashProgress = Math.min(flash.age / flash.duration, 1);

                        // Ease-out expansion
                        const easeOut = 1 - Math.pow(1 - flashProgress, 3);
                        const radius = flash.maxRadius * easeOut;

                        // Opacity: quick fade
                        const flashOpacity =
                            flashProgress < 0.3 ?
                            1 - (flashProgress / 0.3) * 0.5 :
                            0.5 * (1 - (flashProgress - 0.3) / 0.7);

                        if (flashProgress >= 1) {
                            flash.alive = false;
                        } else if (flashOpacity > 0.01) {
                            const glowGradient = ctx.createRadialGradient(
                                flash.x, flash.y, 0,
                                flash.x, flash.y, radius
                            );
                            glowGradient.addColorStop(0, `rgba(255,255,245,${flashOpacity})`);
                            glowGradient.addColorStop(0.3, `rgba(255,240,210,${flashOpacity * 0.7})`);
                            glowGradient.addColorStop(0.7, `rgba(255,220,180,${flashOpacity * 0.25})`);
                            glowGradient.addColorStop(1, 'rgba(255,200,150,0)');
                            ctx.fillStyle = glowGradient;
                            ctx.beginPath();
                            ctx.arc(flash.x, flash.y, radius, 0, Math.PI * 2);
                            ctx.fill();
                        }
                    }

                    // ── Update & draw particles ─────────────
                    let aliveCount = 0;
                    for (const p of particles) {
                        if (!p.alive) continue;
                        p.update(dt);
                        if (p.alive) {
                            p.draw(ctx);
                            aliveCount++;
                        }
                    }

                    // ── Cleanup check ──────────────────────
                    if (aliveCount === 0 && !flash.alive) {
                        // All done — remove canvas
                        cancelAnimationFrame(animFrameId);
                        if (canvas.parentNode) {
                            canvas.parentNode.removeChild(canvas);
                        }
                        return;
                    }

                    // Continue loop
                    animFrameId = requestAnimationFrame(animate);
                }

                // Kick off the animation
                animFrameId = requestAnimationFrame(animate);

                // ──────────────────────────────────────
                // Safety cleanup after 5 seconds max
                // ──────────────────────────────────────
                setTimeout(() => {
                    if (canvas.parentNode) {
                        cancelAnimationFrame(animFrameId);
                        canvas.parentNode.removeChild(canvas);
                    }
                }, 3000);
            }, 3000);
        })();
    </script>

</x-guest-layout>
