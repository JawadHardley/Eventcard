@extends('layouts.admin')

@section('title', 'Card Preview — ' . $guest->full_name)

@section('content')

    <style>
        /* ── Card Page Wrapper ── */
        .cardview-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem 4rem;
            min-height: calc(100vh - 60px);
        }

        /* ── Action Bar ── */
        .card-actions {
            display: flex;
            gap: .65rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        /* ── Card Outer Shell ── */
        .invitation-shell {
            perspective: 1200px;
            width: 100%;
            max-width: 420px;
            cursor: default;
        }

        /* ── The Card Itself ── */
        #idcard {
            width: 100%;
            max-width: 420px;
            border-radius: 28px;
            overflow: hidden;
            position: relative;
            background: #fff;
            box-shadow:
                0 2px 0 rgba(255, 255, 255, .12) inset,
                0 32px 80px rgba(0, 0, 0, .32),
                0 8px 24px rgba(0, 0, 0, .18);
            transform-style: preserve-3d;
            transition: transform .5s cubic-bezier(.23, 1, .32, 1), box-shadow .4s ease;
            will-change: transform;
        }

        html.dark #idcard {
            box-shadow:
                0 2px 0 rgba(255, 255, 255, .06) inset,
                0 40px 100px rgba(0, 0, 0, .7),
                0 8px 24px rgba(0, 0, 0, .5);
            background: #201e1e6b;
        }

        /* ── Card entrance animation ── */
        @keyframes cardReveal {
            0% {
                opacity: 0;
                transform: translateY(40px) rotateX(8deg) scale(.96);
            }

            100% {
                opacity: 1;
                transform: translateY(0) rotateX(0) scale(1);
            }
        }

        #idcard {
            animation: cardReveal .75s cubic-bezier(.23, 1, .32, 1) both;
        }

        /* ── Hero Photo Section ── */
        .card-hero {
            position: relative;
            width: 100%;
            height: 280px;
            overflow: hidden;
        }

        .card-hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            display: block;
            transition: transform 8s ease;
        }

        #idcard:hover .card-hero-img {
            transform: scale(1.04);
        }

        /* Cinematic gradient overlays */
        .card-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(to bottom,
                    rgba(0, 0, 0, .08) 0%,
                    rgba(0, 0, 0, .0) 30%,
                    rgba(0, 0, 0, .55) 75%,
                    rgba(0, 0, 0, .82) 100%);
        }

        /* Ambient color tint — changes per event type */
        .card-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 1;
            background: var(--theme-tint, rgba(180, 20, 20, .18));
            mix-blend-mode: multiply;
            pointer-events: none;
        }

        /* ── Hero Badge ── */
        .hero-badge {
            position: absolute;
            top: 18px;
            right: 18px;
            z-index: 4;
            background: rgba(0, 0, 0, .55);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 980px;
            padding: .35rem .85rem;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #fff;
        }

        /* ── Hero Bottom Info ── */
        .hero-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 4;
            padding: 0 1.4rem 1.4rem;
        }

        .hero-event-name {
            font-family: 'DM Serif Display', serif;
            font-size: 1.6rem;
            font-weight: 400;
            color: #fff;
            line-height: 1.15;
            text-shadow: 0 2px 20px rgba(0, 0, 0, .4);
            margin-bottom: .2rem;
        }

        .hero-event-sub {
            font-size: .72rem;
            color: rgba(255, 255, 255, .72);
            font-weight: 500;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        /* ── Card Body ── */
        .card-body-inner {
            background: #fff;
            padding: 1.4rem 1.4rem 0;
            position: relative;
        }

        html.dark .card-body-inner {
            background: #111113;
        }

        /* Holographic shimmer bar */
        @keyframes shimmer-move {
            0% {
                background-position: -400px 0;
            }

            100% {
                background-position: 400px 0;
            }
        }

        /* .card-shimmer-bar {
                                height: 2px;
                                background: linear-gradient(90deg,
                                        transparent 0%,
                                        rgba(255, 255, 255, .0) 20%,
                                        rgba(200, 160, 255, .9) 35%,
                                        rgba(130, 210, 255, .9) 50%,
                                        rgba(255, 180, 100, .9) 65%,
                                        rgba(255, 255, 255, .0) 80%,
                                        transparent 100%);
                                background-size: 800px 100%;
                                animation: shimmer-move 3.5s linear infinite;
                                margin: 0 -1.4rem;
                                margin-bottom: 1.25rem;
                            } */

        /* ── Guest Name Section ── */
        .guest-salutation {
            font-size: .7rem;
            color: #aeaeb2;
            font-weight: 500;
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: .2rem;
        }

        html.dark .guest-salutation {
            color: #636366;
        }

        .guest-name {
            font-family: 'DM Serif Display', serif;
            font-size: 1.5rem;
            font-weight: 400;
            color: #1d1d1f;
            line-height: 1.15;
            margin-bottom: .25rem;
        }

        html.dark .guest-name {
            color: #f5f5f7;
        }

        .guest-title-badge {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: rgba(14, 132, 232, .09);
            color: #0e84e8;
            border-radius: 980px;
            padding: .22rem .72rem;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            margin-bottom: 1.1rem;
        }

        html.dark .guest-title-badge {
            background: rgba(14, 132, 232, .18);
            color: #38a3f7;
        }

        /* ── Divider with ornament ── */
        .card-ornament-divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.1rem;
        }

        .ornament-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e8e8ed 60%);
        }

        .ornament-line.right {
            background: linear-gradient(90deg, #e8e8ed 40%, transparent);
        }

        html.dark .ornament-line {
            background: linear-gradient(90deg, transparent, #2c2c2e 60%);
        }

        html.dark .ornament-line.right {
            background: linear-gradient(90deg, #2c2c2e 40%, transparent);
        }

        .ornament-icon {
            color: #d1d1d6;
            font-size: .7rem;
            flex-shrink: 0;
        }

        html.dark .ornament-icon {
            color: #38383a;
        }

        /* ── Detail rows ── */
        .card-details {
            display: flex;
            flex-direction: column;
            gap: .6rem;
            margin-bottom: 1.25rem;
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .detail-icon-wrap {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            background: #f5f5f7;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #6e6e73;
        }

        html.dark .detail-icon-wrap {
            background: #1c1c1e;
            color: #86868b;
        }

        .detail-icon-wrap svg {
            width: 13px;
            height: 13px;
        }

        .detail-label {
            font-size: .65rem;
            color: #aeaeb2;
            font-weight: 600;
            letter-spacing: .07em;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: .08rem;
        }

        html.dark .detail-label {
            color: #48484a;
        }

        .detail-value {
            font-size: .8rem;
            font-weight: 600;
            color: #1d1d1f;
            line-height: 1.2;
        }

        html.dark .detail-value {
            color: #f5f5f7;
        }

        /* ── QR + Code Section ── */
        .card-qr-section {
            display: flex;
            gap: 1rem;
            align-items: stretch;
            padding: 1rem 1.4rem;
            background: #f5f5f7;
            margin: 0 -1.4rem;
            position: relative;
            overflow: hidden;
        }

        html.dark .card-qr-section {
            background: #0a0a0a;
        }

        /* Ticket cut notches */
        .card-qr-section::before,
        .card-qr-section::after {
            content: '';
            position: absolute;
            top: -14px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #fff;
            z-index: 2;
        }

        html.dark .card-qr-section::before,
        html.dark .card-qr-section::after {
            background: #111113;
        }

        .card-qr-section::before {
            left: -14px;
        }

        .card-qr-section::after {
            right: -14px;
        }

        /* Dashed separator line inside QR section */
        .qr-separator {
            width: 1px;
            background: repeating-linear-gradient(to bottom,
                    transparent,
                    transparent 4px,
                    #d1d1d6 4px,
                    #d1d1d6 8px);
            flex-shrink: 0;
            align-self: stretch;
        }

        html.dark .qr-separator {
            background: repeating-linear-gradient(to bottom,
                    transparent,
                    transparent 4px,
                    #2c2c2e 4px,
                    #2c2c2e 8px);
        }

        /* QR code wrap */
        .qr-wrap {
            flex-shrink: 0;
            position: relative;
        }

        .qr-inner {
            background: #fff;
            border-radius: 12px;
            padding: 8px;
            display: inline-flex;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .1);
        }

        /* Animated scan line */
        @keyframes scan-line {
            0% {
                top: 8px;
                opacity: .9;
            }

            50% {
                opacity: .5;
            }

            100% {
                top: calc(100% - 12px);
                opacity: .9;
            }
        }

        .qr-scan-line {
            position: absolute;
            left: 8px;
            right: 8px;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(14, 132, 232, .8), transparent);
            border-radius: 2px;
            animation: scan-line 2.5s ease-in-out infinite alternate;
            z-index: 2;
            pointer-events: none;
        }

        /* Code meta */
        .qr-meta {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: .5rem;
            padding: .2rem 0;
        }

        .qr-meta-label {
            font-size: .6rem;
            color: #aeaeb2;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        html.dark .qr-meta-label {
            color: #48484a;
        }

        .qr-meta-code {
            font-family: 'DM Mono', 'Courier New', monospace;
            font-size: 1.35rem;
            font-weight: 700;
            color: #1d1d1f;
            letter-spacing: .12em;
            line-height: 1;
        }

        html.dark .qr-meta-code {
            color: #f5f5f7;
        }

        .qr-meta-hint {
            font-size: .65rem;
            color: #aeaeb2;
            line-height: 1.4;
        }

        /* ── Card Footer ── */
        .card-footer-strip {
            padding: .9rem 1.4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
        }

        html.dark .card-footer-strip {
            background: #111113;
        }

        .card-brand {
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #d1d1d6;
        }

        html.dark .card-brand {
            color: #2c2c2e;
        }

        .card-counter {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            font-size: .68rem;
            font-weight: 600;
            color: #aeaeb2;
            background: #f5f5f7;
            border-radius: 980px;
            padding: .2rem .65rem;
        }

        html.dark .card-counter {
            background: #1c1c1e;
            color: #636366;
        }

        .counter-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #34c759;
        }

        /* ── Download Button Premium ── */
        .download-btn-wrap {
            position: relative;
            display: inline-flex;
        }

        .download-progress-ring {
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: 0;
            transition: opacity .2s;
        }

        .download-btn-wrap.loading .download-progress-ring {
            opacity: 1;
        }

        .download-btn-wrap.loading .btn-primary {
            opacity: .7;
            pointer-events: none;
        }

        .download-btn-wrap.done .btn-primary {
            background: #34c759 !important;
        }

        /* ── Theme variants per event type ── */
        [data-event-type="birthday"] {
            --theme-tint: rgba(255, 100, 0, .15);
        }

        [data-event-type="wedding"] {
            --theme-tint: rgba(220, 180, 80, .18);
        }

        [data-event-type="vip"] {
            --theme-tint: rgba(100, 60, 200, .22);
        }

        [data-event-type="gala"] {
            --theme-tint: rgba(30, 30, 30, .25);
        }

        [data-event-type="club"] {
            --theme-tint: rgba(0, 120, 255, .2);
        }

        [data-event-type="party"] {
            --theme-tint: rgba(220, 0, 100, .15);
        }

        /* ── Tilt cursor ── */
        .invitation-shell {
            user-select: none;
        }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .card-hero {
                height: 240px;
            }

            .hero-event-name {
                font-size: 1.35rem;
            }

            .guest-name {
                font-size: 1.3rem;
            }
        }

        /* ── Download overlay ── */
        .download-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, .72);
            backdrop-filter: blur(18px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease;
        }

        .download-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .download-overlay-card {
            background: #fff;
            border-radius: 24px;
            padding: 2rem 2.5rem;
            text-align: center;
            box-shadow: 0 32px 80px rgba(0, 0, 0, .35);
            min-width: 280px;
        }

        html.dark .download-overlay-card {
            background: #1c1c1e;
        }

        @keyframes spin360 {
            to {
                transform: rotate(360deg);
            }
        }

        .dl-spinner {
            width: 48px;
            height: 48px;
            border: 3px solid #e5e5ea;
            border-top-color: #0e84e8;
            border-radius: 50%;
            margin: 0 auto 1rem;
            animation: spin360 .8s linear infinite;
        }

        .dl-spinner.done {
            border-color: #34c759;
            border-top-color: #34c759;
            animation: none;
        }

        .dl-title {
            font-weight: 700;
            font-size: 1rem;
            color: #1d1d1f;
            margin-bottom: .35rem;
        }

        html.dark .dl-title {
            color: #fff;
        }

        .dl-sub {
            font-size: .8rem;
            color: #aeaeb2;
        }
    </style>

    <div class="cardview-page">

        <!-- Action bar -->
        <div class="card-actions fade-up">
            <div class="download-btn-wrap" id="download-btn-wrap">
                <button class="btn btn-primary btn-lg" onclick="triggerDownload()" id="download-btn">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                        <path d="M12 3v13m-5-5 5 5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        <path d="M4 20h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    Save as Image
                </button>
            </div>

            <a href="{{ route('showpublic', $guest->qrcode) }}" target="_blank" class="btn btn-ghost btn-lg">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                    <path d="M15 3h6m0 0v6m0-6L10 14M9 5H5a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-4"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                Public View
            </a>

            <button class="btn btn-ghost btn-lg" onclick="copyLink()">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                    <rect x="9" y="9" width="13" height="13" rx="2" stroke="currentColor" stroke-width="2" />
                    <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" stroke="currentColor" stroke-width="2" />
                </svg>
                Copy Link
            </button>
        </div>

        <!-- Card shell with tilt -->
        <div class="invitation-shell fade-up delay-1" id="card-shell">

            @php
                $eventType = strtolower($event->event_type ?? 'party');
                $guestTitle = strtolower($guest->title ?? 'guest');
                $eventDate = \Carbon\Carbon::parse($event->event_date);
                $arrivalTime = \Carbon\Carbon::parse($event->arrival_time);
                $publicUrl = $guest->more ?? url('/guest/' . $guest->qrcode);
                $bgImage = $event->event_image
                    ? asset('storage/' . $event->event_image)
                    : asset('storage/images/background.png');
            @endphp

            <div id="idcard" data-event-type="{{ $eventType }}">

                <!-- Hero image section -->
                <div class="card-hero">
                    <img src="{{ $bgImage }}" alt="{{ $event->order_name }}" class="card-hero-img" id="hero-img">

                    <!-- Event type badge -->
                    <div class="hero-badge">
                        @if (str_contains($eventType, 'birthday'))
                            🎂 Birthday
                        @elseif(str_contains($eventType, 'wedding'))
                            💍 Wedding
                        @elseif(str_contains($eventType, 'vip'))
                            ★ VIP
                        @elseif(str_contains($eventType, 'gala'))
                            ✦ Gala
                        @else
                            {{ ucfirst($eventType) }}
                        @endif
                    </div>

                    <!-- Event name at bottom of hero -->
                    <div class="hero-info">
                        <div class="hero-event-name">{{ $event->order_name }}</div>
                        @if ($event->event_host)
                            <div class="hero-event-sub">Hosted by {{ $event->event_host }}</div>
                        @endif
                    </div>
                </div>

                <!-- Card body -->
                <div class="card-body-inner">
                    <div class="card-shimmer-bar"></div>

                    <!-- Guest identity -->
                    <div class="guest-salutation">You are cordially invited,</div>
                    <div class="guest-name">{{ $guest->full_name }}</div>
                    @if ($guestTitle && $guestTitle !== 'guest')
                        <div class="guest-title-badge">
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3 6 7 1-5 5 1 7-6-3-6 3 1-7-5-5 7-1z" />
                            </svg>
                            {{ ucfirst($guestTitle) }}
                        </div>
                    @endif

                    <!-- Ornament divider -->
                    <div class="card-ornament-divider">
                        <div class="ornament-line"></div>
                        <svg class="ornament-icon" width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z" />
                        </svg>
                        <div class="ornament-line right"></div>
                    </div>

                    <!-- Detail rows -->
                    <div class="card-details">
                        <div class="detail-row">
                            <div class="detail-icon-wrap">
                                <svg fill="none" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="3" stroke="currentColor"
                                        stroke-width="2" />
                                    <path d="M3 9h18M8 2v4m8-4v4" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                            </div>
                            <div>
                                <div class="detail-label">Date</div>
                                <div class="detail-value">{{ $eventDate->format('l, j F Y') }}</div>
                            </div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-icon-wrap">
                                <svg fill="none" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
                                    <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div>
                                <div class="detail-label">Time</div>
                                <div class="detail-value">{{ $arrivalTime->format('g:i A') }}</div>
                            </div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-icon-wrap">
                                <svg fill="none" viewBox="0 0 24 24">
                                    <path d="M12 21s-7-6.5-7-11a7 7 0 0114 0c0 4.5-7 11-7 11z" stroke="currentColor"
                                        stroke-width="2" />
                                    <circle cx="12" cy="10" r="2.5" stroke="currentColor"
                                        stroke-width="2" />
                                </svg>
                            </div>
                            <div>
                                <div class="detail-label">Venue</div>
                                <div class="detail-value">{{ $event->event_location }}</div>
                            </div>
                        </div>

                        @if ($event->event_desc)
                            <div class="detail-row" style="align-items:flex-start;">
                                <div class="detail-icon-wrap" style="margin-top:2px;">
                                    <svg fill="none" viewBox="0 0 24 24">
                                        <path d="M8 12h8M8 8h5M5 3h14a2 2 0 012 2v16l-4-2-4 2-4-2-4 2V5a2 2 0 012-2z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="detail-label">Note</div>
                                    <div class="detail-value" style="font-weight:400;font-size:.76rem;color:#6e6e73;">
                                        {{ $event->event_desc }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- QR + Code ticket section -->
                <div class="card-qr-section px-5">
                    <div class="qr-wrap ps-2">
                        <div class="qr-inner">
                            {{-- <div class="qr-scan-line"></div> --}}
                            {!! QrCode::size(100)->generate($publicUrl) !!}
                        </div>
                    </div>

                    <div class="qr-separator"></div>

                    <div class="qr-meta">
                        <div>
                            <div class="qr-meta-label">Invitation Code</div>
                            <div class="qr-meta-code">{{ $guest->invitation_code }}</div>
                        </div>
                        <div>
                            <div class="qr-meta-label">Admission</div>
                            <div style="font-size:.72rem;font-weight:600;color:#1d1d1f;" class="dark:text-white">
                                {{ $guest->counter ?? '1 Person' }}
                            </div>
                        </div>
                        <div class="qr-meta-hint">Scan QR or present<br>code at the entrance</div>
                    </div>
                </div>

                <!-- Card footer -->
                <div class="card-footer-strip">
                    <span class="card-brand">TapEvent Card</span>
                    <span class="card-counter">
                        <span class="counter-dot"></span>
                        Valid Invitation
                    </span>
                </div>

            </div><!-- /#idcard -->
        </div><!-- /.invitation-shell -->

    </div><!-- /.cardview-page -->

    <!-- Download overlay -->
    <div class="download-overlay" id="download-overlay">
        <div class="download-overlay-card">
            <div class="dl-spinner" id="dl-spinner"></div>
            <div class="dl-title" id="dl-title">Preparing your card…</div>
            <div class="dl-sub" id="dl-sub">High quality export in progress</div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        /* ── Tilt effect ── */
        (function() {
            const shell = document.getElementById('card-shell');
            const card = document.getElementById('idcard');
            if (!shell || !card) return;

            shell.addEventListener('mousemove', (e) => {
                const rect = shell.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - .5;
                const y = (e.clientY - rect.top) / rect.height - .5;
                card.style.transform = `
            rotateY(${x * 10}deg)
            rotateX(${-y * 8}deg)
            scale(1.015)
        `;
                card.style.boxShadow = `
            ${-x * 20}px ${-y * 20}px 60px rgba(0,0,0,.25),
            0 32px 80px rgba(0,0,0,.3)
        `;
            });

            shell.addEventListener('mouseleave', () => {
                card.style.transform = '';
                card.style.boxShadow = '';
            });
        })();

        /* ── Download ── */
        window.triggerDownload = function() {
            const overlay = document.getElementById('download-overlay');
            const spinner = document.getElementById('dl-spinner');
            const title = document.getElementById('dl-title');
            const sub = document.getElementById('dl-sub');

            overlay.classList.add('show');
            title.textContent = 'Preparing your card…';
            sub.textContent = 'High quality export in progress';
            spinner.classList.remove('done');

            const card = document.getElementById('idcard');

            // Temporarily reset tilt for clean export
            const savedTransform = card.style.transform;
            card.style.transform = 'none';
            card.style.transition = 'none';

            setTimeout(() => {
                html2canvas(card, {
                    scale: 3,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: null,
                    logging: false,
                    imageTimeout: 5000,
                }).then(canvas => {
                    card.style.transform = savedTransform;
                    card.style.transition = '';

                    spinner.classList.add('done');
                    title.textContent = '✓ Card ready!';
                    sub.textContent = 'Your download is starting…';

                    const link = document.createElement('a');
                    link.download =
                        `invite-{{ Str::slug($guest->full_name) }}-{{ $event->id }}.png`;
                    link.href = canvas.toDataURL('image/png', 1.0);
                    link.click();

                    setTimeout(() => {
                        overlay.classList.remove('show');
                    }, 1400);

                }).catch(() => {
                    card.style.transform = savedTransform;
                    card.style.transition = '';
                    overlay.classList.remove('show');
                    if (window.showToast) showToast('Export failed — please try again', 'error');
                });
            }, 100);
        };

        /* ── Copy link ── */
        window.copyLink = function() {
            const url = '{{ $guest->more ?? url('/guest/' . $guest->qrcode) }}';
            navigator.clipboard.writeText(url).then(() => {
                if (window.showToast) showToast('Invitation link copied!', 'success');
            }).catch(() => {
                if (window.showToast) showToast('Could not copy link', 'error');
            });
        };

        /* ── Close overlay on click ── */
        document.getElementById('download-overlay').addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('show');
        });

        /* ── Escape closes overlay ── */
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                document.getElementById('download-overlay').classList.remove('show');
            }
        });
    </script>

@endsection
