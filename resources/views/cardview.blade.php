{{-- ============================================================
     TapEvent Card — redesigned cardview (reference layout)
     resources/views/cardview.blade.php
     ============================================================ --}}

@extends(isset($export) && $export ? 'layouts.card-export' : 'layouts.admin')

@section('title', 'Card Preview — ' . $guest->full_name)

@section('content')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=DM+Serif+Display:ital@0;1&display=swap"
        rel="stylesheet">

    <style>
        /* ══════════════════════════════════════════════════════════
                                                                                                           PAGE WRAPPER
                                                                                                           ══════════════════════════════════════════════════════════ */
        .cardview-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem 4rem;
            min-height: calc(100vh - 60px);
        }

        .card-actions {
            display: flex;
            gap: .65rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        /* ── Share panel ─────────────────────────────────────────── */
        .share-panel {
            width: 100%;
            max-width: 680px;
            margin-bottom: 2rem;
            background: rgba(255, 252, 248, .96);
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 16px;
            box-shadow: 0 12px 34px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        html.dark .share-panel {
            background: rgba(28, 28, 30, .96);
            border-color: rgba(255, 255, 255, .08);
        }

        .share-panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.15rem .8rem;
            border-bottom: 1px solid rgba(0, 0, 0, .06);
        }

        html.dark .share-panel-heading {
            border-bottom-color: rgba(255, 255, 255, .08);
        }

        .share-panel-title {
            margin: 0;
            color: #1a1a1a;
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .04em;
        }

        html.dark .share-panel-title {
            color: #f5f5f7;
        }

        .share-panel-subtitle {
            margin: .25rem 0 0;
            color: #8a8a8f;
            font-size: .72rem;
        }

        .share-panel-icon {
            display: grid;
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            place-items: center;
            border-radius: 50%;
            background: rgba(14, 132, 232, .1);
            color: #0e84e8;
        }

        .share-message-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .85rem;
            padding: 1rem 1.15rem 1.15rem;
        }

        .share-message-box {
            min-width: 0;
        }

        .share-message-box-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
            margin-bottom: .45rem;
        }

        .share-message-label {
            color: #4a4a4a;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        html.dark .share-message-label {
            color: #a1a1a6;
        }

        .share-copy-button {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            border: 0;
            border-radius: 8px;
            padding: .35rem .65rem;
            background: #1a1a1a;
            color: #fff;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: .66rem;
            font-weight: 600;
        }

        .share-copy-button:hover {
            background: #333;
        }

        html.dark .share-copy-button {
            background: #f5f5f7;
            color: #1a1a1a;
        }

        html.dark .share-copy-button:hover {
            background: #e5e5ea;
        }

        .share-message-text {
            width: 100%;
            min-height: 240px;
            resize: vertical;
            box-sizing: border-box;
            border: 1px solid rgba(0, 0, 0, .08);
            border-radius: 10px;
            padding: .75rem;
            background: #fafafa;
            color: #1a1a1a;
            font-family: 'DM Sans', sans-serif;
            font-size: .76rem;
            line-height: 1.55;
        }

        html.dark .share-message-text {
            background: #2c2c2e;
            border-color: rgba(255, 255, 255, .08);
            color: #f5f5f7;
        }

        .share-message-text:focus {
            outline: 2px solid rgba(14, 132, 232, .2);
            border-color: #0e84e8;
        }

        @media (max-width: 620px) {
            .share-message-grid {
                grid-template-columns: 1fr;
            }

            .share-message-text {
                min-height: 200px;
            }
        }

        /* ══════════════════════════════════════════════════════════
                                                                                                           CARD SHELL
                                                                                                           ══════════════════════════════════════════════════════════ */
        .invitation-shell {
            perspective: 1400px;
            width: 100%;
            max-width: 680px;
            user-select: none;
        }

        @keyframes cardReveal {
            0% {
                opacity: 0;
                transform: translateY(36px) rotateX(6deg) scale(.97);
            }

            100% {
                opacity: 1;
                transform: translateY(0) rotateX(0) scale(1);
            }
        }

        /* ══════════════════════════════════════════════════════════
                                                                                                           THE CARD  —  design tokens
                                                                                                           ══════════════════════════════════════════════════════════ */
        #idcard {
            /* ── Light mode tokens ── */
            --card-bg: #f5efe6;
            --card-surface: #ffffff;
            --card-surface-2: #ede4d3;
            --card-text: #1a1a1a;
            --card-text-secondary: #5a5a5f;
            --card-muted: #8a7f6e;
            --card-border: rgba(0, 0, 0, .07);
            --card-border-strong: rgba(0, 0, 0, .14);
            --card-divider: rgba(0, 0, 0, .08);

            /* ── Accent (overridden by data-event-type) ── */
            --card-accent: #8b1a1a;
            --card-accent-soft: rgba(139, 26, 26, .08);
            --card-accent-ink: #6b1010;

            --card-radius: 22px;
            --card-radius-lg: 14px;
            --card-radius-sm: 10px;

            width: 100%;
            max-width: 680px;
            min-height: 880px;
            border-radius: var(--card-radius);
            overflow: hidden;
            position: relative;
            background: var(--card-bg);
            color: var(--card-text);
            font-family: 'DM Sans', system-ui, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            box-shadow:
                0 1px 0 rgba(255, 255, 255, .5) inset,
                0 24px 60px rgba(80, 40, 10, .14),
                0 8px 20px rgba(0, 0, 0, .07);
            transform-style: preserve-3d;
            transition: transform .5s cubic-bezier(.23, 1, .32, 1), box-shadow .4s ease;
            will-change: transform;
            animation: cardReveal .8s cubic-bezier(.23, 1, .32, 1) both;
        }

        html.dark #idcard {
            --card-bg: #0e0e10;
            --card-surface: #1a1a1c;
            --card-surface-2: #232326;
            --card-text: #f5f5f7;
            --card-text-secondary: #a1a1a6;
            --card-muted: #7a7a7f;
            --card-border: rgba(255, 255, 255, .08);
            --card-border-strong: rgba(255, 255, 255, .16);
            --card-divider: rgba(255, 255, 255, .08);
            box-shadow:
                0 1px 0 rgba(255, 255, 255, .04) inset,
                0 24px 60px rgba(0, 0, 0, .6),
                0 8px 20px rgba(0, 0, 0, .35);
        }

        /* ── Event type accent overrides (subtle, single hue) ── */
        #idcard[data-event-type="birthday"] {
            --card-accent: #8b1a1a;
            --card-accent-soft: rgba(139, 26, 26, .08);
            --card-accent-ink: #6b1010;
        }

        #idcard[data-event-type="wedding"] {
            --card-accent: #b8860b;
            --card-accent-soft: rgba(184, 134, 11, .1);
            --card-accent-ink: #7a5a08;
        }

        #idcard[data-event-type="walima"] {
            --card-accent: #b8860b;
            --card-accent-soft: rgba(184, 134, 11, .1);
            --card-accent-ink: #7a5a08;
        }

        #idcard[data-event-type="nikah"] {
            --card-accent: #1a8a5a;
            --card-accent-soft: rgba(26, 138, 90, .1);
            --card-accent-ink: #0f5c3c;
        }

        #idcard[data-event-type="aqiqah"] {
            --card-accent: #1a8a5a;
            --card-accent-soft: rgba(26, 138, 90, .1);
            --card-accent-ink: #0f5c3c;
        }

        #idcard[data-event-type="khitan"] {
            --card-accent: #1a8a5a;
            --card-accent-soft: rgba(26, 138, 90, .1);
            --card-accent-ink: #0f5c3c;
        }

        #idcard[data-event-type="vip"] {
            --card-accent: #7c5cff;
            --card-accent-soft: rgba(124, 92, 255, .1);
            --card-accent-ink: #4f3aa8;
        }

        #idcard[data-event-type="gala"] {
            --card-accent: #c9a227;
            --card-accent-soft: rgba(201, 162, 39, .12);
            --card-accent-ink: #856b14;
        }

        #idcard[data-event-type="club"] {
            --card-accent: #0e84e8;
            --card-accent-soft: rgba(14, 132, 232, .1);
            --card-accent-ink: #0a5aa0;
        }

        #idcard[data-event-type="party"] {
            --card-accent: #d946a0;
            --card-accent-soft: rgba(217, 70, 160, .1);
            --card-accent-ink: #96286c;
        }

        /* ── Grid: text left, image right ── */
        #idcard {
            display: grid;
            grid-template-columns: 55fr 45fr;
            padding: 26px;
            gap: 0;
        }

        /* ══════════════════════════════════════════════════════════
                                                                                                           LEFT COLUMN
                                                                                                           ══════════════════════════════════════════════════════════ */
        .card-left {
            display: flex;
            flex-direction: column;
            min-width: 0;
            padding: 14px 26px 12px 12px;
        }

        /* ── Eyebrow block ── */
        .eyebrow-block {
            margin-bottom: 20px;
        }

        .eyebrow {
            font-family: 'DM Sans', sans-serif;
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--card-muted);
            line-height: 1.5;
        }

        .eyebrow-rule {
            width: 42px;
            height: 1px;
            background: var(--card-border-strong);
            margin: 10px 0;
        }

        /* ── Guest name ── */
        .guest-name {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: clamp(1.5rem, 3.6vw, 1.9rem);
            line-height: 1.1;
            letter-spacing: -.01em;
            color: var(--card-text);
            margin: 0 0 6px;
            font-weight: 400;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .guest-title-pill {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .28rem .7rem;
            border-radius: 999px;
            background: var(--card-accent-soft);
            color: var(--card-accent-ink);
            font-family: 'DM Sans', sans-serif;
            font-size: .64rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            align-self: flex-start;
            margin: 2px 0 4px;
            max-width: 100%;
        }

        html.dark .guest-title-pill {
            color: var(--card-accent);
        }

        /* ── Event name (hero) ── */
        .event-name {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: clamp(2.2rem, 6.4vw, 3.05rem);
            line-height: 1.02;
            letter-spacing: -.015em;
            color: var(--card-accent);
            margin: 4px 0 14px;
            font-weight: 400;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        html.dark .event-name {
            color: var(--card-accent);
        }

        /* ── Host row ── */
        .event-host-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .event-host {
            font-family: 'DM Sans', sans-serif;
            font-size: .66rem;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--card-text-secondary);
            line-height: 1.5;
            overflow-wrap: anywhere;
            min-width: 0;
            flex: 1 1 auto;
        }

        .event-type-chip {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .25rem .6rem;
            border-radius: 999px;
            background: var(--card-accent-soft);
            color: var(--card-accent-ink);
            font-family: 'DM Sans', sans-serif;
            font-size: .58rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            flex-shrink: 0;
            white-space: nowrap;
        }

        html.dark .event-type-chip {
            color: var(--card-accent);
        }

        /* ── Ornament divider ── */
        .ornament {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 4px 0 16px;
        }

        .ornament-line {
            flex: 1;
            height: 1px;
            background: var(--card-border-strong);
            opacity: .7;
        }

        .ornament-diamond {
            width: 6px;
            height: 6px;
            background: var(--card-accent);
            transform: rotate(45deg);
            flex-shrink: 0;
            opacity: .75;
        }

        /* ── Description ── */
        .event-desc {
            font-family: 'DM Serif Display', Georgia, serif;
            font-style: italic;
            font-size: .96rem;
            line-height: 1.5;
            color: var(--card-text-secondary);
            margin: 0 0 22px;
            overflow-wrap: anywhere;
        }

        /* ══════════════════════════════════════════════════════════
                                                                                                           INFO ROWS  (icon │ text)
                                                                                                           ══════════════════════════════════════════════════════════ */
        .info-list {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-bottom: 20px;
        }

        .info-row {
            display: grid;
            grid-template-columns: 26px 1px 1fr;
            gap: 14px;
            align-items: center;
            padding: 12px 0;
        }

        .info-icon {
            color: var(--card-text);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-icon svg {
            width: 20px;
            height: 20px;
            stroke-width: 1.4;
        }

        .info-bar {
            width: 1px;
            height: 34px;
            background: var(--card-border-strong);
            opacity: .85;
        }

        .info-content {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .info-label {
            font-family: 'DM Sans', sans-serif;
            font-size: .64rem;
            font-weight: 600;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--card-muted);
            line-height: 1.3;
        }

        .info-value {
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem;
            font-weight: 600;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--card-text);
            line-height: 1.4;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        /* ══════════════════════════════════════════════════════════
                                                                                                           TICKET / QR
                                                                                                           ══════════════════════════════════════════════════════════ */
        .ticket {
            margin-top: 4px;
            padding: 16px 16px 14px;
            border-radius: var(--card-radius-lg);
            background: var(--card-surface-2);
            border: 1px solid var(--card-border);
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 16px;
            align-items: center;
        }

        .ticket-qr {
            flex-shrink: 0;
        }

        .ticket-qr-inner {
            background: #ffffff;
            border-radius: 10px;
            padding: 8px;
            box-sizing: border-box;
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        }

        .ticket-qr-inner svg {
            display: block !important;
            width: 100% !important;
            height: 100% !important;
        }

        .ticket-info {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
            justify-content: center;
        }

        .ticket-field {
            min-width: 0;
        }

        .ticket-label {
            font-family: 'DM Sans', sans-serif;
            font-size: .58rem;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--card-muted);
            margin-bottom: 2px;
            line-height: 1.3;
        }

        .ticket-value {
            font-family: 'DM Sans', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--card-text);
            line-height: 1.15;
            letter-spacing: .04em;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .ticket-hint {
            font-family: 'DM Serif Display', Georgia, serif;
            font-style: italic;
            font-size: .72rem;
            line-height: 1.4;
            color: var(--card-muted);
            margin-top: 2px;
            overflow-wrap: anywhere;
        }

        /* ══════════════════════════════════════════════════════════
                                                                                                           CLOSING + FOOTER
                                                                                                           ══════════════════════════════════════════════════════════ */
        .closing {
            font-family: 'DM Serif Display', Georgia, serif;
            font-style: italic;
            font-size: 1.05rem;
            line-height: 1.35;
            color: var(--card-text);
            margin: auto 0 16px;
            padding-top: 22px;
            overflow-wrap: anywhere;
        }

        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-top: 14px;
            border-top: 1px solid var(--card-border);
        }

        .footer-brand {
            font-family: 'DM Sans', sans-serif;
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--card-muted);
        }

        .footer-valid {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-family: 'DM Sans', sans-serif;
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--card-text-secondary);
        }

        .footer-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #d42828;
            flex-shrink: 0;
        }

        /* ══════════════════════════════════════════════════════════
                                                                                                           RIGHT COLUMN  (image)
                                                                                                           ══════════════════════════════════════════════════════════ */
        .card-right {
            position: relative;
            border-radius: var(--card-radius-lg);
            overflow: hidden;
            background: var(--card-surface-2);
            min-height: 100%;
            contain: layout paint;
        }

        .card-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            display: block;
        }

        /* ══════════════════════════════════════════════════════════
                                                                                                           DOWNLOAD OVERLAY
                                                                                                           ══════════════════════════════════════════════════════════ */
        .download-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, .72);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            display: flex;
            align-items: center;
            justify-content: center;
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
            border-radius: 20px;
            padding: 2rem 2.5rem;
            text-align: center;
            box-shadow: 0 32px 80px rgba(0, 0, 0, .35);
            min-width: 280px;
        }

        html.dark .download-overlay-card {
            background: #1c1c1e;
            color: #fff;
        }

        @keyframes spin360 {
            to {
                transform: rotate(360deg);
            }
        }

        .dl-spinner {
            width: 48px;
            height: 48px;
            border: 3px solid rgba(14, 132, 232, .18);
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
            font-size: .9rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: .35rem;
        }

        html.dark .dl-title {
            color: #fff;
        }

        .dl-sub {
            font-size: .78rem;
            color: #8a8a8f;
        }

        /* ══════════════════════════════════════════════════════════
                                                                                                           RESPONSIVE  —  shrink the card gracefully on small screens
                                                                                                           ══════════════════════════════════════════════════════════ */
        @media (max-width: 720px) {
            #idcard {
                grid-template-columns: 1fr;
                padding: 20px;
                min-height: unset;
            }

            .card-left {
                padding: 8px 4px 8px 4px;
            }

            .card-right {
                min-height: 340px;
                aspect-ratio: 4 / 3;
                order: -1;
                margin-bottom: 18px;
            }

            .event-name {
                font-size: clamp(1.9rem, 8vw, 2.4rem);
            }

            .guest-name {
                font-size: clamp(1.3rem, 5.5vw, 1.6rem);
            }
        }

        @media (max-width: 400px) {
            .ticket {
                padding: 14px;
                gap: 12px;
            }

            .ticket-qr-inner {
                width: 88px;
                height: 88px;
            }

            .ticket-value {
                font-size: 1rem;
            }

            .info-row {
                gap: 10px;
            }
        }
    </style>

    <div class="cardview-page">

        {{-- ── Action Bar ── --}}
        <div class="card-actions fade-up">
            <div class="download-btn-wrap" id="download-btn-wrap">
                <button class="btn btn-primary btn-lg" onclick="triggerDownload()" id="download-btn">
                    <i class="fa-solid fa-download" style="margin-right:.4rem;"></i>
                    Download Image
                </button>
            </div>

            <button type="button" onclick="downloadPdf()" class="btn btn-ghost btn-lg">
                <i class="fa-solid fa-file-pdf" style="margin-right:.4rem;"></i>
                Download PDF
            </button>

            <a href="{{ route('showpublic', $guest->qrcode) }}" target="_blank" class="btn btn-ghost btn-lg">
                <i class="fa-solid fa-arrow-up-right-from-square" style="margin-right:.4rem;"></i>
                Public View
            </a>

            <button class="btn btn-ghost btn-lg" onclick="copyLink()">
                <i class="fa-regular fa-copy" style="margin-right:.4rem;"></i>
                Copy Link
            </button>
        </div>

        @php
            $messageDate = $event->event_date
                ? \Carbon\Carbon::parse($event->event_date)->format('l, d-M-Y')
                : '[Add event date]';
            $messageTime = $event->arrival_time
                ? \Carbon\Carbon::parse($event->arrival_time)->format('g:i A')
                : '[Add event time]';
            $messageHost = $event->event_host ?: '[Add family or host name]';
            $messageVenue = $event->event_location ?: '[Add venue]';
            $messageVenue2 = 'Sinza Mugabe, Dar es Salaam';
            $messageCode = $guest->invitation_code ?: '[Add invitation code]';
            $messageMapUrl = $event->card_link ?: 'https://maps.app.goo.gl/qwK3FwZxDmXdG8Uc9?g_st=aw';
            $messageUrl = $guest->more ?? url('/guest/' . $guest->qrcode);
            $allowedPersons = strtolower($guest->title ?? 'single') === 'double' ? 'Double' : 'Single';
            $messageEventName = trim(preg_replace('/\s+wedding\s*$/i', '', $event->order_name));

            $whatsappMessage =
                "*{$messageEventName}*\n\n" .
                "Familia ya {$messageHost}, Wanapenda kukualika *{$guest->full_name}* " .
                "Kwenye harusi ya vijana wao wapendwa *{$messageEventName}*\n\n" .
                "Tarehe: {$messageDate} | {$messageTime}\n" .
                "Ukumbi: {$messageVenue}\n" .
                "Mahali: {$messageVenue2}\n" .
                "Dresscode: Emerald Green\n" .
                "Type: {$allowedPersons}\n" .
                "S/N: {$messageCode}\n\n" .
                "Location: {$messageMapUrl}\n\n" .
                "Asante na Karibu Sana\n\n" .
                "NOTE: *NOTE: UKIPATA HUU UJUMBE USIFUTE NDO KADI YAKO*\n\n" .
                "{$messageUrl}\n" .
                'Designed by TapEventCard 0778515202';

            $smsMessage =
                // "{$messageEventName}\n\n" .
                "Familia ya {$messageHost}, Wanapenda kukualika ({$guest->full_name}) " .
                "Kwenye harusi ya vijana wao wapendwa *{$messageEventName}*\n\n" .
                "Tarehe: {$messageDate} | {$messageTime}\n" .
                "Ukumbi: {$messageVenue}\n" .
                "Mahali: {$messageVenue2}\n" .
                "Dresscode: Emerald Green\n" .
                "Type: {$allowedPersons}\n" .
                "S/N: {$messageCode}\n\n" .
                "Asante na Karibu Sana\n" .
                "NOTE: UKIPATA HUU UJUMBE USIFUTE NDO KADI YAKO\n\n" .
                "TapEventCard 0778515202\n" .
                'Ukipata huu ujumbe usifute ndo Kadi yako';
        @endphp

        {{-- ── Copy-ready share messages ── --}}
        <section class="share-panel fade-up delay-1" aria-labelledby="share-panel-title">
            <div class="share-panel-heading">
                <div>
                    <h2 class="share-panel-title" id="share-panel-title">Copy invitation message</h2>
                    <p class="share-panel-subtitle">Edit any placeholder, then copy the version you need.</p>
                </div>
                <span class="share-panel-icon" aria-hidden="true">
                    <i class="fa-solid fa-paper-plane" style="font-size:.8rem;"></i>
                </span>
            </div>

            <div class="share-message-grid">
                <div class="share-message-box">
                    <div class="share-message-box-header">
                        <label class="share-message-label" for="whatsapp-message">WhatsApp</label>
                        <button type="button" class="share-copy-button" onclick="copyMessage('whatsapp-message', this)">
                            <i class="fa-regular fa-copy"></i> Copy
                        </button>
                    </div>
                    <textarea class="share-message-text" id="whatsapp-message" spellcheck="false">{{ $whatsappMessage }}</textarea>
                </div>

                <div class="share-message-box">
                    <div class="share-message-box-header">
                        <label class="share-message-label" for="sms-message">SMS</label>
                        <button type="button" class="share-copy-button" onclick="copyMessage('sms-message', this)">
                            <i class="fa-regular fa-copy"></i> Copy
                        </button>
                    </div>
                    <textarea class="share-message-text" id="sms-message" spellcheck="false">{{ $smsMessage }}</textarea>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════════════════════════════
         CARD
         ══════════════════════════════════════════════════════ --}}
        <div class="invitation-shell fade-up delay-1" id="card-shell">

            @php
                $eventType = strtolower($event->event_type ?? 'party');
                $guestTitle = strtolower($guest->title ?? 'guest');
                $eventDate = \Carbon\Carbon::parse($event->event_date);
                $arrivalTime = \Carbon\Carbon::parse($event->arrival_time);
                $publicUrl = $guest->more ?? url('/guest/' . $guest->qrcode);
                $bgImage = $event->event_image
                    ? asset('storage/' . $event->event_image) . '?v=' . ($event->updated_at?->timestamp ?? $event->id)
                    : asset('storage/images/willsave.png');

                $islamicTypes = [
                    'nikah',
                    'wedding',
                    'walima',
                    'aqiqah',
                    'khitan',
                    'circumcision',
                    'islamic',
                    'muslim',
                    'eid',
                ];
                $isIslamic = false;
                foreach ($islamicTypes as $kw) {
                    if (str_contains($eventType, $kw)) {
                        $isIslamic = true;
                        break;
                    }
                }
            @endphp

            <div id="idcard" data-event-type="{{ $eventType }}">

                {{-- ══ LEFT: TEXT COLUMN ══ --}}
                <div class="card-left">

                    {{-- Event name (hero) --}}
                    <h2 class="event-name">{{ $event->order_name }}</h2>

                    {{-- Host + event type chip --}}
                    <div class="event-host-row">
                        @if ($event->event_host)
                            <div class="event-host">Hosted by {{ $event->event_host }}</div>
                        @else
                            <div class="event-host">&nbsp;</div>
                        @endif
                        <span class="event-type-chip">{{ ucfirst($eventType) }}</span>
                    </div>

                    {{-- Eyebrows --}}
                    <div class="eyebrow-block">
                        <div class="eyebrow-rule"></div>
                        <div class="eyebrow">We Cordially Invite You To</div>
                    </div>

                    {{-- Guest name --}}
                    <h1 class="guest-name">{{ $guest->full_name }}</h1>

                    @if ($guestTitle && $guestTitle !== 'guest')
                        <span class="guest-title-pill">
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M12 2l2.39 7.36H22l-6.18 4.49 2.36 7.27L12 16.63 5.82 21.12l2.36-7.27L2 9.36h7.61L12 2z" />
                            </svg>
                            {{ ucfirst($guestTitle) }}
                        </span>
                    @endif

                    {{-- Ornament divider --}}
                    <div class="ornament">
                        <span class="ornament-line"></span>
                        <span class="ornament-diamond"></span>
                        <span class="ornament-line"></span>
                    </div>

                    {{-- Description (optional) --}}
                    @if ($event->event_desc)
                        <p class="event-desc">{{ $event->event_desc }}</p>
                    @endif

                    {{-- Info rows --}}
                    <div class="info-list">
                        <div class="info-row">
                            <div class="info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" aria-hidden="true">
                                    <rect x="3" y="4.5" width="18" height="16" rx="2" />
                                    <line x1="16" y1="2.5" x2="16" y2="6.5" />
                                    <line x1="8" y1="2.5" x2="8" y2="6.5" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                            </div>
                            <div class="info-bar"></div>
                            <div class="info-content">
                                <div class="info-label">{{ $eventDate->format('l') }}</div>
                                <div class="info-value">{{ $eventDate->format('F j, Y') }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="9.5" />
                                    <polyline points="12 6.5 12 12 15.5 14" />
                                </svg>
                            </div>
                            <div class="info-bar"></div>
                            <div class="info-content">
                                <div class="info-label">Time</div>
                                <div class="info-value">At {{ $arrivalTime->format('g:i A') }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20.5 10c0 6.5-8.5 12-8.5 12s-8.5-5.5-8.5-12a8.5 8.5 0 1 1 17 0z" />
                                    <circle cx="12" cy="10" r="2.8" />
                                </svg>
                            </div>
                            <div class="info-bar"></div>
                            <div class="info-content">
                                <div class="info-label">Venue</div>
                                <div class="info-value">{{ $event->event_location }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Ticket / QR --}}
                    <div class="ticket">
                        <div class="ticket-qr">
                            <div class="ticket-qr-inner">
                                {!! QrCode::size(100)->generate($publicUrl) !!}
                            </div>
                        </div>
                        <div class="ticket-info">
                            <div class="ticket-field">
                                <div class="ticket-label">Invitation Code</div>
                                <div class="ticket-value">{{ $guest->invitation_code }}</div>
                            </div>
                            <div class="ticket-field">
                                <div class="ticket-label">Allowed Persons</div>
                                <div class="ticket-value">
                                    {{ strtolower($guest->title ?? 'single') === 'double' ? '2 Persons' : '1 Person' }}
                                </div>
                            </div>
                            <div class="ticket-hint">Scan QR or present code at the entrance</div>
                        </div>
                    </div>

                    {{-- Closing --}}
                    <div class="closing">
                        {{ $isIslamic ? 'Asante na Karibu Sana.' : 'We look forward to seeing you.' }}
                    </div>

                    {{-- Footer --}}
                    <div class="card-footer">
                        <span class="footer-brand">TapEvent Card</span>
                        <span class="footer-valid">
                            <span class="footer-dot"></span>
                            Valid Invitation
                        </span>
                    </div>

                </div>{{-- /.card-left --}}

                {{-- ══ RIGHT: IMAGE COLUMN ══ --}}
                <div class="card-right">
                    <img src="{{ $bgImage }}" alt="{{ $event->order_name }}" class="card-image" loading="lazy"
                        decoding="async">
                </div>

            </div>{{-- /#idcard --}}
        </div>{{-- /.invitation-shell --}}

    </div>{{-- /.cardview-page --}}

    {{-- Download overlay --}}
    <div class="download-overlay" id="download-overlay">
        <div class="download-overlay-card">
            <div class="dl-spinner" id="dl-spinner"></div>
            <div class="dl-title" id="dl-title">Preparing your card…</div>
            <div class="dl-sub" id="dl-sub">High quality export in progress</div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        /* ── 3-D tilt on hover (desktop only) ── */
        (function() {
            const shell = document.getElementById('card-shell');
            const card = document.getElementById('idcard');
            if (!shell || !card) return;
            shell.addEventListener('mousemove', (e) => {
                if (window.innerWidth < 720) return;
                const r = shell.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - .5;
                const y = (e.clientY - r.top) / r.height - .5;
                card.style.transform = `rotateY(${x*5}deg) rotateX(${-y*4}deg) scale(1.008)`;
                card.style.boxShadow =
                    `${-x*16}px ${-y*12}px 44px rgba(0,0,0,.16), 0 24px 60px rgba(0,0,0,.14)`;
            });
            shell.addEventListener('mouseleave', () => {
                card.style.transform = '';
                card.style.boxShadow = '';
            });
        })();

        /* ── Copy share message ── */
        window.copyMessage = function(messageId, button) {
            const message = document.getElementById(messageId);
            if (!message) return;

            const copied = () => {
                const original = button.innerHTML;
                button.innerHTML = '<i class="fa-solid fa-check"></i> Copied';
                if (window.showToast) showToast('Message copied!', 'success');
                setTimeout(() => button.innerHTML = original, 1600);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(message.value).then(copied).catch(fallbackCopy);
            } else {
                fallbackCopy();
            }

            function fallbackCopy() {
                message.focus();
                message.select();
                if (document.execCommand('copy')) copied();
                message.setSelectionRange(message.value.length, message.value.length);
            }
        };

        /* ── Download ── */
        window.triggerDownload = function() {
            const overlay = document.getElementById('download-overlay');
            const spinner = document.getElementById('dl-spinner');
            const title = document.getElementById('dl-title');
            const sub = document.getElementById('dl-sub');
            const button = document.getElementById('download-btn');

            overlay.classList.add('show');
            button.disabled = true;
            title.textContent = 'Generating high-quality image…';
            sub.textContent = 'Preparing the card in your browser';

            const card = document.getElementById('idcard');
            const image = card ? card.querySelector('.card-image') : null;
            const originalTransform = card ? card.style.transform : '';
            const originalBoxShadow = card ? card.style.boxShadow : '';

            const finish = () => {
                overlay.classList.remove('show');
                spinner.classList.remove('done');
                button.disabled = false;
            };

            if (!card || typeof html2canvas !== 'function') {
                finish();
                showToast('Image export is unavailable in this browser', 'error');
                return;
            }

            const render = async () => {
                if (image) {
                    image.loading = 'eager';
                    image.fetchPriority = 'high';
                }
                if (image && !image.complete) {
                    await new Promise(resolve => {
                        image.addEventListener('load', resolve, {
                            once: true
                        });
                        image.addEventListener('error', resolve, {
                            once: true
                        });
                    });
                }
                if (document.fonts && document.fonts.ready) await document.fonts.ready;

                card.style.transform = 'none';
                card.style.boxShadow = 'none';

                const canvas = await html2canvas(card, {
                    backgroundColor: null,
                    scale: Math.min(3, window.devicePixelRatio || 2),
                    useCORS: true,
                    allowTaint: false,
                    imageTimeout: 20000,
                    logging: false,
                    width: card.scrollWidth,
                    height: card.scrollHeight,
                    windowWidth: Math.max(800, card.scrollWidth),
                    windowHeight: Math.max(1000, card.scrollHeight)
                });

                const link = document.createElement('a');
                link.download = 'invitation-card-{{ $guest->invitation_code ?? 'export' }}.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            };

            render()
                .then(() => {
                    title.textContent = 'Ready!';
                    spinner.classList.add('done');
                })
                .catch(() => showToast('Could not create the card image', 'error'))
                .finally(() => {
                    card.style.transform = originalTransform;
                    card.style.boxShadow = originalBoxShadow;
                    setTimeout(finish, 900);
                });
        };

        window.downloadPdf = function() {
            const overlay = document.getElementById('download-overlay');
            const spinner = document.getElementById('dl-spinner');
            const title = document.getElementById('dl-title');
            const sub = document.getElementById('dl-sub');
            const card = document.getElementById('idcard');
            const image = card ? card.querySelector('.card-image') : null;

            if (!card || typeof html2canvas !== 'function' || !window.jspdf) {
                showToast('PDF export is unavailable in this browser', 'error');
                return;
            }

            overlay.classList.add('show');
            title.textContent = 'Generating PDF…';
            sub.textContent = 'Preparing the card in your browser';

            const originalTransform = card.style.transform;
            const originalBoxShadow = card.style.boxShadow;
            const restore = () => {
                card.style.transform = originalTransform;
                card.style.boxShadow = originalBoxShadow;
                overlay.classList.remove('show');
                spinner.classList.remove('done');
            };

            const renderPdf = async () => {
                if (image) {
                    image.loading = 'eager';
                    image.fetchPriority = 'high';
                }
                if (image && !image.complete) {
                    await new Promise(resolve => {
                        image.addEventListener('load', resolve, {
                            once: true
                        });
                        image.addEventListener('error', resolve, {
                            once: true
                        });
                    });
                }
                if (document.fonts && document.fonts.ready) await document.fonts.ready;
                card.style.transform = 'none';
                card.style.boxShadow = 'none';

                const canvas = await html2canvas(card, {
                    backgroundColor: null,
                    scale: Math.min(3, window.devicePixelRatio || 2),
                    useCORS: true,
                    allowTaint: false,
                    imageTimeout: 20000,
                    logging: false,
                    width: card.scrollWidth,
                    height: card.scrollHeight,
                    windowWidth: Math.max(800, card.scrollWidth),
                    windowHeight: Math.max(1000, card.scrollHeight)
                });
                const pdf = new window.jspdf.jsPDF({
                    orientation: 'portrait',
                    unit: 'px',
                    format: [canvas.width, canvas.height],
                    compress: true
                });
                pdf.addImage(canvas.toDataURL('image/jpeg', 0.95), 'JPEG', 0, 0, canvas.width, canvas.height);
                pdf.save('invitation-card-{{ $guest->invitation_code ?? 'export' }}.pdf');
            };

            renderPdf()
                .then(() => {
                    title.textContent = 'Ready!';
                    spinner.classList.add('done');
                })
                .catch(() => showToast('Could not create the card PDF', 'error'))
                .finally(() => setTimeout(restore, 900));
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

        /* ── Close overlay on backdrop click or Escape ── */
        document.getElementById('download-overlay').addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('show');
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') document.getElementById('download-overlay').classList.remove('show');
        });
    </script>

@endsection
