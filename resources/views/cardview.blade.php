{{-- ============================================================
     DROP-IN REPLACEMENT  —  paste this entire file content into
     resources/views/cardview.blade.php  (replaces the existing file)
     ============================================================ --}}

@extends('layouts.admin')

@section('title', 'Card Preview — ' . $guest->full_name)

@section('content')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Cinzel:wght@400;500;600&family=Amiri:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ══════════════════════════════════════════════════════════════
                                                                                                                                                                   PAGE WRAPPER
                                                                                                                                                                ══════════════════════════════════════════════════════════════ */
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

        /* ── Share message panel ── */
        .share-panel {
            width: 100%;
            max-width: 630px;
            margin-bottom: 2rem;
            background: rgba(255, 250, 244, .96);
            border: 1px solid rgba(184, 150, 12, .24);
            border-radius: 12px;
            box-shadow: 0 12px 34px rgba(80, 35, 5, .14);
            overflow: hidden;
        }

        .share-panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.15rem .8rem;
            border-bottom: 1px solid rgba(184, 150, 12, .16);
        }

        .share-panel-title {
            margin: 0;
            color: #5a2d00;
            font-family: 'Cinzel', serif;
            font-size: .82rem;
            letter-spacing: .08em;
        }

        .share-panel-subtitle {
            margin: .25rem 0 0;
            color: #8a6a4c;
            font-family: 'DM Sans', sans-serif;
            font-size: .72rem;
        }

        .share-panel-icon {
            display: grid;
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            place-items: center;
            border-radius: 50%;
            background: rgba(139, 26, 26, .09);
            color: #8b1a1a;
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
            color: #6a4a2a;
            font-family: 'Cinzel', serif;
            font-size: .62rem;
            letter-spacing: .1em;
        }

        .share-copy-button {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            border: 0;
            border-radius: 6px;
            padding: .35rem .55rem;
            background: #8b1a1a;
            color: #fffaf4;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: .66rem;
            font-weight: 600;
        }

        .share-copy-button:hover {
            background: #6f1313;
        }

        .share-message-text {
            width: 100%;
            min-height: 285px;
            resize: vertical;
            box-sizing: border-box;
            border: 1px solid rgba(184, 150, 12, .22);
            border-radius: 8px;
            padding: .75rem;
            background: #fffdf9;
            color: #3a200a;
            font-family: 'DM Sans', sans-serif;
            font-size: .76rem;
            line-height: 1.55;
        }

        .share-message-text:focus {
            outline: 2px solid rgba(139, 26, 26, .18);
            border-color: #8b1a1a;
        }

        @media (max-width: 620px) {
            .share-message-grid {
                grid-template-columns: 1fr;
            }

            .share-message-text {
                min-height: 230px;
            }
        }

        /* ══════════════════════════════════════════════════════════════
                                                                                                                                                                   CARD SHELL  (perspective + entrance animation)
                                                                                                                                                                ══════════════════════════════════════════════════════════════ */
        .invitation-shell {
            perspective: 1200px;
            width: 100%;
            max-width: 630px;
            user-select: none;
        }

        @keyframes cardReveal {
            0% {
                opacity: 0;
                transform: translateY(44px) rotateX(7deg) scale(.96);
            }

            100% {
                opacity: 1;
                transform: translateY(0) rotateX(0) scale(1);
            }
        }

        /* ══════════════════════════════════════════════════════════════
                                                                                                                                                                   THE CARD
                                                                                                                                                                ══════════════════════════════════════════════════════════════ */
        #idcard {
            width: 100%;
            border-radius: 6px;
            overflow: hidden;
            position: relative;
            background: #fdf6ee;
            box-shadow:
                0 2px 0 rgba(255, 255, 255, .14) inset,
                0 36px 90px rgba(80, 35, 5, .42),
                0 8px 28px rgba(0, 0, 0, .22);
            transform-style: preserve-3d;
            transition: transform .5s cubic-bezier(.23, 1, .32, 1), box-shadow .4s ease;
            will-change: transform;
            animation: cardReveal .8s cubic-bezier(.23, 1, .32, 1) both;
            font-family: 'Cormorant Garamond', 'DM Sans', serif;
        }

        /* ── Cream silky background ── */
        .ic-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
            background: linear-gradient(155deg, #fdf8f2 0%, #faeee0 38%, #f7e5cf 68%, #fdf6ee 100%);
        }

        .ic-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(108deg,
                    transparent 0px,
                    rgba(255, 255, 255, .16) 1px,
                    transparent 2px,
                    transparent 58px);
        }

        /* ── Inner gold border frame ── */
        .ic-frame {
            position: absolute;
            top: 14px;
            left: 14px;
            right: 14px;
            bottom: 14px;
            z-index: 2;
            pointer-events: none;
            border: 1px solid rgba(184, 150, 12, .2);
            border-radius: 2px;
        }

        .ic-frame::before,
        .ic-frame::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            border: 1px solid rgba(184, 150, 12, .45);
            transform: rotate(45deg);
            background: #fdf6ee;
        }

        .ic-frame::before {
            top: -5px;
            left: -5px;
        }

        .ic-frame::after {
            top: -5px;
            right: -5px;
        }

        /* ── All content above bg layers ── */
        .ic-content {
            position: relative;
            z-index: 4;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 0 1.8rem;
        }

        /* ══════════════════════════════════════════════════════════════
                                                                                                                                                                   FLORAL CORNERS  (absolute, pointer-events:none)
                                                                                                                                                                ══════════════════════════════════════════════════════════════ */
        .floral-tl,
        .floral-tr,
        .floral-br {
            position: absolute;
            pointer-events: none;
            z-index: 3;
        }

        .floral-tl {
            top: -6px;
            left: -6px;
            width: 210px;
            height: 250px;
        }

        .floral-tr {
            top: -6px;
            right: -6px;
            width: 120px;
            height: 190px;
        }

        .floral-br {
            bottom: -6px;
            right: -6px;
            width: 230px;
            height: 270px;
        }

        /* ── Gold arc (top-right) ── */
        .ic-arc {
            position: absolute;
            top: 0;
            right: 0;
            width: 280px;
            height: 280px;
            z-index: 2;
            pointer-events: none;
        }

        /* ── Mosque silhouette (bottom bg) ── */
        .ic-mosque {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1;
            pointer-events: none;
            opacity: .07;
        }

        /* ── Lanterns (top right, inside arc) ── */
        .ic-lanterns {
            position: absolute;
            top: 18px;
            right: 16px;
            z-index: 5;
            pointer-events: none;
        }

        /* ══════════════════════════════════════════════════════════════
                                                                                                                                                                   TYPOGRAPHY  —  card interior
                                                                                                                                                                ══════════════════════════════════════════════════════════════ */
        .ic-bismillah {
            padding-top: 2.1rem;
            font-family: 'Amiri', serif;
            font-size: 1.45rem;
            color: #8b1a1a;
            text-align: center;
            letter-spacing: .04em;
            line-height: 1.3;
            margin-bottom: .5rem;
        }

        .ic-eyebrow {
            font-family: 'Cinzel', serif;
            font-size: .58rem;
            letter-spacing: .22em;
            color: #7a5a3a;
            text-align: center;
            margin-bottom: .2rem;
        }

        .ic-subline {
            font-family: 'Cormorant Garamond', serif;
            font-size: .92rem;
            font-style: italic;
            color: #5a3a1a;
            text-align: center;
            margin-bottom: .45rem;
        }

        /* ── Event name (hero title) ── */
        .ic-event-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            color: #8b1a1a;
            line-height: 1;
            text-align: center;
            display: block;
            text-shadow: 0 2px 14px rgba(139, 26, 26, .14);
            margin-bottom: -.2rem;
        }

        /* ── Ceremony-style sub label ── */
        .ic-event-type-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: .85rem;
        }

        .ic-type-dash {
            flex: 1;
            max-width: 55px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #b8960c);
        }

        .ic-type-dash.r {
            background: linear-gradient(90deg, #b8960c, transparent);
        }

        .ic-type-label {
            font-family: 'Cinzel', serif;
            font-size: .65rem;
            letter-spacing: .28em;
            color: #b8960c;
        }

        /* ── Ornament row ── */
        .ic-orn {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: .8rem;
        }

        .ic-orn-line {
            width: 22px;
            height: 1px;
            background: #b8960c;
            opacity: .5;
        }

        .ic-orn-diamond {
            width: 5px;
            height: 5px;
            background: #b8960c;
            transform: rotate(45deg);
            opacity: .65;
        }

        /* ── Host line ── */
        .ic-host {
            font-family: 'Cormorant Garamond', serif;
            font-size: .88rem;
            font-style: italic;
            color: #7a5030;
            text-align: center;
            margin-bottom: .7rem;
        }

        /* ── Guest salutation ── */
        .ic-salutation {
            font-family: 'Cinzel', serif;
            font-size: .55rem;
            letter-spacing: .18em;
            color: #a07850;
            text-align: center;
            margin-bottom: .2rem;
        }

        /* ── Guest name (script) ── */
        .ic-guest-name {
            font-family: 'Great Vibes', cursive;
            font-size: 2.6rem;
            color: #5a2d00;
            line-height: 1.1;
            text-align: center;
            margin-bottom: .3rem;
        }

        /* ── Guest title badge ── */
        .ic-guest-badge {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: rgba(139, 26, 26, .08);
            color: #8b1a1a;
            border-radius: 980px;
            padding: .22rem .75rem;
            font-family: 'Cinzel', serif;
            font-size: .58rem;
            letter-spacing: .1em;
            margin-bottom: .9rem;
        }

        /* ── Blessing paragraph ── */
        .ic-blessing {
            font-family: 'Cormorant Garamond', serif;
            font-size: .98rem;
            font-weight: 400;
            color: #4a3020;
            text-align: center;
            line-height: 1.65;
            padding: 0 2.4rem;
            margin-bottom: 1.1rem;
            max-width: 600px;
        }

        /* ── Gold divider rule ── */
        .ic-rule {
            width: 58%;
            height: 1px;
            background: linear-gradient(90deg, transparent, #b8960c 30%, #b8960c 70%, transparent);
            margin-bottom: .9rem;
            opacity: .55;
        }

        /* ══════════════════════════════════════════════════════════════
                                                                                                                                                                   INFO STRIP  (date / time / venue)
                                                                                                                                                                ══════════════════════════════════════════════════════════════ */
        .ic-info-strip {
            display: flex;
            align-items: stretch;
            width: calc(100% - 3rem);
            background: rgba(253, 244, 228, .88);
            border: 1px solid rgba(184, 150, 12, .22);
            border-radius: 10px;
            padding: .8rem 0;
            margin-bottom: 1.2rem;
        }

        .ic-info-block {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            gap: .28rem;
            padding: 0 .7rem;
            position: relative;
        }

        .ic-info-block+.ic-info-block::before {
            content: '';
            position: absolute;
            left: 0;
            top: 10%;
            height: 80%;
            width: 1px;
            background: rgba(184, 150, 12, .28);
        }

        .ic-info-icon {
            color: #8b1a1a;
            font-size: 1.05rem;
        }

        .ic-info-label {
            font-family: 'Cinzel', serif;
            font-size: .52rem;
            letter-spacing: .1em;
            color: #6a4a2a;
            text-align: center;
            line-height: 1.4;
        }

        /* ══════════════════════════════════════════════════════════════
                                                                                                                                                                   QR / TICKET SECTION   (keep existing ticket-stub style)
                                                                                                                                                                ══════════════════════════════════════════════════════════════ */
        .ic-ticket {
            display: flex;
            gap: 1rem;
            align-items: stretch;
            width: calc(100% - 3rem);
            background: rgba(248, 238, 222, .9);
            border: 1px solid rgba(184, 150, 12, .2);
            border-radius: 10px;
            padding: .95rem 1rem;
            margin-bottom: 1.2rem;
            position: relative;
            overflow: hidden;
        }

        /* Ticket punch notches */
        .ic-ticket::before,
        .ic-ticket::after {
            content: '';
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #fdf6ee;
            z-index: 2;
        }

        .ic-ticket::before {
            left: -11px;
        }

        .ic-ticket::after {
            right: -11px;
        }

        .ic-qr-wrap {
            flex-shrink: 0;
        }

        .ic-qr-inner {
            background: #fff;
            border-radius: 10px;
            padding: 7px;
            display: inline-flex;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
        }

        .ic-ticket-sep {
            width: 1px;
            flex-shrink: 0;
            align-self: stretch;
            background: repeating-linear-gradient(to bottom,
                    transparent, transparent 4px,
                    rgba(184, 150, 12, .35) 4px, rgba(184, 150, 12, .35) 8px);
        }

        .ic-ticket-meta {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: .5rem;
            padding: .1rem 0;
        }

        .ic-ticket-label {
            font-family: 'Cinzel', serif;
            font-size: .52rem;
            letter-spacing: .14em;
            color: #a07850;
        }

        .ic-ticket-code {
            font-family: 'DM Sans', monospace;
            font-size: 1.25rem;
            font-weight: 700;
            color: #3a200a;
            letter-spacing: .1em;
            line-height: 1;
        }

        .ic-ticket-admission {
            font-family: 'Cormorant Garamond', serif;
            font-size: .82rem;
            font-weight: 600;
            color: #3a200a;
        }

        .ic-ticket-hint {
            font-family: 'Cormorant Garamond', serif;
            font-size: .7rem;
            font-style: italic;
            color: #a07850;
            line-height: 1.4;
        }

        /* ══════════════════════════════════════════════════════════════
                                                                                                                                                                   CLOSING
                                                                                                                                                                ══════════════════════════════════════════════════════════════ */
        .ic-closing {
            font-family: 'Great Vibes', cursive;
            font-size: 1.55rem;
            color: #4a2a00;
            text-align: center;
            line-height: 1.45;
            padding: 0 1.8rem;
            margin-bottom: 1.1rem;
        }

        .ic-jazakum {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            background: #8b1a1a;
            color: #fdf6ee;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            font-style: italic;
            font-weight: 500;
            letter-spacing: .04em;
            border-radius: 980px;
            padding: .52rem 1.8rem;
        }

        .ic-jazakum-line {
            display: inline-block;
            width: 16px;
            height: 1px;
            background: rgba(253, 246, 238, .45);
            vertical-align: middle;
            flex-shrink: 0;
        }

        /* ── Card footer strip ── */
        .ic-footer {
            padding: .75rem 1.4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(253, 246, 238, .6);
            border-top: 1px solid rgba(184, 150, 12, .15);
        }

        .ic-footer-brand {
            font-family: 'Cinzel', serif;
            font-size: .55rem;
            letter-spacing: .16em;
            color: #c0a060;
        }

        .ic-footer-valid {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            font-family: 'Cinzel', serif;
            font-size: .55rem;
            letter-spacing: .1em;
            color: #a07850;
        }

        .ic-valid-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #34c759;
            flex-shrink: 0;
        }

        /* ══════════════════════════════════════════════════════════════
                                                                                                                                                                   DOWNLOAD OVERLAY
                                                                                                                                                                ══════════════════════════════════════════════════════════════ */
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
            background: #fdf6ee;
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
            border: 3px solid rgba(184, 150, 12, .2);
            border-top-color: #8b1a1a;
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
            font-family: 'Cinzel', serif;
            font-size: .9rem;
            font-weight: 600;
            color: #3a200a;
            margin-bottom: .35rem;
        }

        html.dark .dl-title {
            color: #fff;
        }

        .dl-sub {
            font-size: .78rem;
            color: #a07850;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
        }

        /* ── Download btn wrap ── */
        .download-btn-wrap {
            position: relative;
            display: inline-flex;
        }

        /* ── Fade-up animation hook (matches existing admin layout) ── */
        @media (max-width: 480px) {
            .ic-event-name {
                font-size: 2rem;
            }

            .ic-guest-name {
                font-size: 2rem;
            }

            .ic-info-label {
                font-size: .48rem;
            }
        }
    </style>

    <div class="cardview-page">

        {{-- ── Action Bar ── --}}
        <div class="card-actions fade-up">
            <div class="download-btn-wrap" id="download-btn-wrap">
                <button class="btn btn-primary btn-lg" onclick="triggerDownload()" id="download-btn">
                    <i class="fa-solid fa-download" style="margin-right:.4rem;"></i>
                    Save as Image
                </button>
            </div>

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
            $messageVenue2 = 'Sinza Africasana, Dar es Salaam';
            $messageType = $event->event_type ? ucfirst($event->event_type) : '[Add invitation type]';
            $messageCode = $guest->invitation_code ?: '[Add invitation code]';
            $messageMapUrl = $event->card_link ?: 'https://maps.app.goo.gl/JqaKFPZhVwuCUURo6';
            $messageUrl = $guest->more ?? url('/guest/' . $guest->qrcode);

            $whatsappMessage =
                "*{$event->order_name}*\n\n" .
                "Familia ya {$messageHost}, Wanapenda kukualika *{$guest->full_name}* " .
                "Kwenye harusi ya vijana wao wapendwa *Yasin H. Seif & Upendo S. Juma*\n\n" .
                "Tarehe: {$messageDate} | {$messageTime}\n" .
                "Ukumbi: {$messageVenue}\n" .
                "Mahali: {$messageVenue2}\n" .
                "Dresscode: Dark Purple\n" .
                "S/N: {$messageCode}\n\n" .
                "Location: {$messageMapUrl}\n\n" .
                "Asante na Karibu Sana\n\n" .
                "NOTE: *WATOTO TUNAWAPENDA ILA HAWARUHUSIWI*\n\n" .
                "{$messageUrl}\n" .
                'Designed by TapEventCard 0778515202';

            $smsMessage =
                "{$event->order_name}\n\n" .
                "Familia ya {$messageHost}, Wanapenda kukualika ({$guest->full_name}) " .
                "kwenye harusi ya vijana wao wapendwa *Yasin H. Seif & Upendo S. Juma*.\n\n" .
                "Tarehe: {$messageDate} | {$messageTime}\n" .
                "Ukumbi: {$messageVenue}\n" .
                "Mahali: {$messageVenue2}\n" .
                "Dresscode: Dark Purple\n" .
                "S/N: {$messageCode}\n\n" .
                "Location: {$messageMapUrl}\n\n" .
                "Asante na Karibu Sana\n" .
                "NOTE: WATOTO TUNAWAPENDA ILA HAWARUHUSIWI\n\n" .
                "{$messageUrl}\n" .
                'Designed by TapEventCard 0778515202';
        @endphp

        {{-- ── Copy-ready share messages ── --}}
        <section class="share-panel fade-up delay-1" aria-labelledby="share-panel-title">
            <div class="share-panel-heading">
                <div>
                    <h2 class="share-panel-title" id="share-panel-title">Copy invitation message</h2>
                    <p class="share-panel-subtitle">Edit any placeholder, then copy the version you need.</p>
                </div>
                <span class="share-panel-icon" aria-hidden="true"><i class="fa-solid fa-paper-plane"></i></span>
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

        {{-- ── Card Shell ── --}}
        <div class="invitation-shell fade-up delay-1" id="card-shell">

            @php
                $eventType = strtolower($event->event_type ?? 'event');
                $guestTitle = strtolower($guest->title ?? 'guest');
                $eventDate = \Carbon\Carbon::parse($event->event_date);
                $arrivalTime = \Carbon\Carbon::parse($event->arrival_time);
                $publicUrl = $guest->more ?? url('/guest/' . $guest->qrcode);
                $bgImage = $event->event_image
                    ? asset('storage/' . $event->event_image)
                    : asset('storage/images/background.png');

                /* ── Detect Islamic events for Bismillah display ── */
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

            <div id="idcard">

                {{-- Cream background layer --}}
                <div class="ic-bg"></div>

                {{-- Inner gold border frame --}}
                <div class="ic-frame"></div>

                {{-- Gold arc top-right --}}
                <svg class="ic-arc" viewBox="0 0 280 280" xmlns="http://www.w3.org/2000/svg">
                    <path d="M280 0 Q120 0 95 165" fill="none" stroke="#b8960c" stroke-width="1.4" opacity=".55" />
                    <path d="M280 0 Q135 0 110 170" fill="none" stroke="#b8960c" stroke-width=".5" opacity=".35" />
                    <rect x="271" y="-3" width="6" height="6" transform="rotate(45 274 3)" fill="#b8960c"
                        opacity=".55" />
                    <circle cx="100" cy="165" r="2.5" fill="#b8960c" opacity=".45" />
                </svg>

                {{-- Mosque silhouette bg --}}
                <svg class="ic-mosque" viewBox="0 0 430 180" xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="xMidYMax meet">
                    <ellipse cx="215" cy="115" rx="68" ry="55" fill="#7a4010" />
                    <rect x="147" y="115" width="136" height="65" fill="#7a4010" />
                    <rect x="211" y="52" width="8" height="38" fill="#7a4010" />
                    <polygon points="215,40 207,58 223,58" fill="#7a4010" />
                    <path d="M215 37 C209 31 209 23 215 21 C207 23 207 33 215 37Z" fill="#7a4010" />
                    <rect x="102" y="105" width="13" height="75" fill="#7a4010" />
                    <ellipse cx="108" cy="103" rx="8" ry="12" fill="#7a4010" />
                    <rect x="105" y="85" width="6" height="12" fill="#7a4010" />
                    <polygon points="108,76 104,88 112,88" fill="#7a4010" />
                    <rect x="315" y="105" width="13" height="75" fill="#7a4010" />
                    <ellipse cx="321" cy="103" rx="8" ry="12" fill="#7a4010" />
                    <rect x="318" y="85" width="6" height="12" fill="#7a4010" />
                    <polygon points="321,76 317,88 325,88" fill="#7a4010" />
                    <rect x="56" y="128" width="9" height="52" fill="#7a4010" />
                    <ellipse cx="60" cy="126" rx="6" ry="9" fill="#7a4010" />
                    <rect x="360" y="128" width="9" height="52" fill="#7a4010" />
                    <ellipse cx="364" cy="126" rx="6" ry="9" fill="#7a4010" />
                    <path d="M186 115 Q186 101 200 101 Q214 101 214 115Z" fill="#fdf6ee" opacity=".45" />
                    <path d="M216 115 Q216 101 230 101 Q244 101 244 115Z" fill="#fdf6ee" opacity=".45" />
                </svg>

                {{-- Floral top-left --}}
                <svg class="floral-tl" viewBox="0 0 210 250" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 220 Q55 155 85 95 Q115 45 145 8" fill="none" stroke="#7a8a5a" stroke-width="1.8" />
                    <path d="M28 232 Q66 178 95 138" fill="none" stroke="#6a7a4a" stroke-width="1.4" />
                    <ellipse cx="77" cy="108" rx="20" ry="8" fill="#6a7a4a"
                        transform="rotate(-40 77 108)" opacity=".85" />
                    <ellipse cx="107" cy="62" rx="17" ry="7" fill="#8a9a5a"
                        transform="rotate(-60 107 62)" opacity=".8" />
                    <ellipse cx="57" cy="152" rx="15" ry="6" fill="#5a6a3a"
                        transform="rotate(-20 57 152)" opacity=".75" />
                    <ellipse cx="138" cy="28" rx="13" ry="5" fill="#7a8a5a"
                        transform="rotate(-70 138 28)" opacity=".7" />
                    <circle cx="92" cy="76" r="3.5" fill="#8b1a1a" opacity=".8" />
                    <circle cx="100" cy="70" r="2.8" fill="#8b1a1a" opacity=".7" />
                    <circle cx="97" cy="81" r="2.5" fill="#a02020" opacity=".6" />
                    <circle cx="150" cy="12" r="2.5" fill="#8b1a1a" opacity=".7" />
                    {{-- Large dark-red rose --}}
                    <g transform="translate(12,152) rotate(-10)">
                        <circle cx="36" cy="36" r="32" fill="#6b1010" opacity=".8" />
                        <circle cx="36" cy="36" r="24" fill="#8b1a1a" />
                        <ellipse cx="36" cy="21" rx="15" ry="17" fill="#a02020" />
                        <ellipse cx="21" cy="43" rx="15" ry="13" fill="#9a1818" />
                        <ellipse cx="50" cy="40" rx="14" ry="13" fill="#9a1818" />
                        <ellipse cx="36" cy="52" rx="13" ry="9" fill="#8b1a1a" />
                        <ellipse cx="36" cy="27" rx="7" ry="11" fill="#c03030" />
                        <ellipse cx="29" cy="36" rx="6" ry="9" fill="#b02020" />
                        <ellipse cx="43" cy="36" rx="6" ry="9" fill="#b02020" />
                    </g>
                    {{-- Cream rose --}}
                    <g transform="translate(78,28) rotate(15)">
                        <circle cx="26" cy="26" r="22" fill="#e8ddd0" opacity=".9" />
                        <circle cx="26" cy="26" r="15" fill="#f0e6d8" />
                        <ellipse cx="26" cy="15" rx="10" ry="12" fill="#f5ede0" />
                        <ellipse cx="16" cy="31" rx="10" ry="9" fill="#ede3d5" />
                        <ellipse cx="36" cy="29" rx="9" ry="9" fill="#ede3d5" />
                        <ellipse cx="26" cy="26" rx="5" ry="7" fill="#fff5ea" />
                    </g>
                    {{-- Small bud --}}
                    <g transform="translate(140,-2) rotate(20)">
                        <ellipse cx="16" cy="22" rx="9" ry="13" fill="#8b1a1a"
                            opacity=".72" />
                        <ellipse cx="16" cy="16" rx="6" ry="9" fill="#a02020"
                            opacity=".78" />
                        <path d="M12 27 Q16 33 20 27" fill="#6a7a4a" />
                    </g>
                </svg>

                {{-- Floral top-right (small spray) --}}
                <svg class="floral-tr" viewBox="0 0 120 190" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 8 Q70 60 60 110 Q52 150 55 185" fill="none" stroke="#7a8a5a" stroke-width="1.4" />
                    <ellipse cx="75" cy="55" rx="14" ry="6" fill="#6a7a4a"
                        transform="rotate(50 75 55)" opacity=".8" />
                    <ellipse cx="65" cy="100" rx="12" ry="5" fill="#8a9a5a"
                        transform="rotate(30 65 100)" opacity=".75" />
                    <circle cx="82" cy="40" r="3" fill="#8b1a1a" opacity=".75" />
                    <circle cx="90" cy="35" r="2.5" fill="#8b1a1a" opacity=".65" />
                    {{-- Small red bud --}}
                    <g transform="translate(88,5) rotate(-15)">
                        <ellipse cx="12" cy="18" rx="8" ry="12" fill="#8b1a1a"
                            opacity=".7" />
                        <ellipse cx="12" cy="13" rx="5" ry="8" fill="#a02020"
                            opacity=".75" />
                    </g>
                </svg>

                {{-- Floral bottom-right --}}
                <svg class="floral-br" viewBox="0 0 230 270" xmlns="http://www.w3.org/2000/svg">
                    <path d="M230 270 Q172 215 135 155 Q106 106 87 48" fill="none" stroke="#7a8a5a"
                        stroke-width="1.8" />
                    <path d="M230 255 Q185 205 155 162" fill="none" stroke="#6a7a4a" stroke-width="1.4" />
                    <ellipse cx="153" cy="168" rx="21" ry="8" fill="#6a7a4a"
                        transform="rotate(40 153 168)" opacity=".85" />
                    <ellipse cx="124" cy="126" rx="18" ry="7" fill="#8a9a5a"
                        transform="rotate(60 124 126)" opacity=".8" />
                    <ellipse cx="182" cy="210" rx="16" ry="6" fill="#5a6a3a"
                        transform="rotate(25 182 210)" opacity=".75" />
                    <circle cx="140" cy="142" r="3.5" fill="#8b1a1a" opacity=".8" />
                    <circle cx="148" cy="137" r="2.8" fill="#8b1a1a" opacity=".7" />
                    <circle cx="144" cy="148" r="2.5" fill="#a02020" opacity=".6" />
                    {{-- Large dark-red rose --}}
                    <g transform="translate(122,170) rotate(10)">
                        <circle cx="38" cy="38" r="34" fill="#6b1010" opacity=".8" />
                        <circle cx="38" cy="38" r="26" fill="#8b1a1a" />
                        <ellipse cx="38" cy="22" rx="16" ry="18" fill="#a02020" />
                        <ellipse cx="22" cy="45" rx="16" ry="14" fill="#9a1818" />
                        <ellipse cx="52" cy="43" rx="15" ry="14" fill="#9a1818" />
                        <ellipse cx="38" cy="54" rx="14" ry="10" fill="#8b1a1a" />
                        <ellipse cx="38" cy="28" rx="8" ry="12" fill="#c03030" />
                        <ellipse cx="30" cy="38" rx="7" ry="10" fill="#b02020" />
                        <ellipse cx="46" cy="38" rx="7" ry="10" fill="#b02020" />
                    </g>
                    {{-- Cream rose --}}
                    <g transform="translate(176,210) rotate(-15)">
                        <circle cx="26" cy="26" r="22" fill="#e8ddd0" opacity=".9" />
                        <circle cx="26" cy="26" r="15" fill="#f0e6d8" />
                        <ellipse cx="26" cy="15" rx="10" ry="12" fill="#f5ede0" />
                        <ellipse cx="16" cy="31" rx="10" ry="9" fill="#ede3d5" />
                        <ellipse cx="36" cy="29" rx="9" ry="9" fill="#ede3d5" />
                        <ellipse cx="26" cy="26" rx="5" ry="7" fill="#fff5ea" />
                    </g>
                    {{-- Bud top --}}
                    <g transform="translate(82,42) rotate(-25)">
                        <ellipse cx="16" cy="22" rx="9" ry="13" fill="#8b1a1a"
                            opacity=".72" />
                        <ellipse cx="16" cy="16" rx="6" ry="9" fill="#a02020"
                            opacity=".78" />
                        <path d="M12 27 Q16 33 20 27" fill="#6a7a4a" />
                    </g>
                    {{-- Mini bud mid --}}
                    <g transform="translate(168,155) rotate(28)">
                        <circle cx="12" cy="12" r="10" fill="#8b1a1a" opacity=".78" />
                        <circle cx="12" cy="12" r="7" fill="#a02020" />
                        <ellipse cx="12" cy="7" rx="5" ry="7" fill="#c03030"
                            opacity=".75" />
                    </g>
                </svg>

                {{-- Lanterns --}}
                <svg class="ic-lanterns" width="68" height="135" viewBox="0 0 68 135"
                    xmlns="http://www.w3.org/2000/svg">
                    <line x1="28" y1="0" x2="28" y2="17" stroke="#b8960c"
                        stroke-width="1.4" />
                    <line x1="50" y1="0" x2="50" y2="28" stroke="#b8960c"
                        stroke-width="1.4" />
                    {{-- Lantern 1 --}}
                    <g transform="translate(28,17)">
                        <polygon points="0,-4 13,0 13,38 0,42 -13,38 -13,0" fill="#c9920c" />
                        <rect x="-9" y="0" width="18" height="38" rx="2" fill="none" stroke="#d4a017"
                            stroke-width=".5" />
                        <line x1="-13" y1="10" x2="13" y2="10" stroke="#d4a017"
                            stroke-width=".5" opacity=".55" />
                        <line x1="-13" y1="20" x2="13" y2="20" stroke="#d4a017"
                            stroke-width=".5" opacity=".55" />
                        <line x1="-13" y1="30" x2="13" y2="30" stroke="#d4a017"
                            stroke-width=".5" opacity=".55" />
                        <ellipse cx="0" cy="19" rx="7" ry="11"
                            fill="rgba(255,220,80,.3)" />
                        <rect x="-5" y="-7" width="10" height="6" rx="1" fill="#b8960c" />
                        <line x1="-7" y1="42" x2="-7" y2="50" stroke="#b8960c"
                            stroke-width="1.1" />
                        <line x1="-2" y1="42" x2="-2" y2="52" stroke="#b8960c"
                            stroke-width="1.1" />
                        <line x1="3" y1="42" x2="3" y2="50" stroke="#b8960c"
                            stroke-width="1.1" />
                        <line x1="8" y1="42" x2="8" y2="49" stroke="#b8960c"
                            stroke-width="1.1" />
                    </g>
                    {{-- Lantern 2 (smaller) --}}
                    <g transform="translate(50,28)">
                        <polygon points="0,-3 9,0 9,28 0,31 -9,28 -9,0" fill="#c9920c" />
                        <rect x="-6" y="0" width="12" height="28" rx="2" fill="none" stroke="#d4a017"
                            stroke-width=".5" />
                        <line x1="-9" y1="8" x2="9" y2="8" stroke="#d4a017"
                            stroke-width=".5" opacity=".55" />
                        <line x1="-9" y1="16" x2="9" y2="16" stroke="#d4a017"
                            stroke-width=".5" opacity=".55" />
                        <line x1="-9" y1="24" x2="9" y2="24" stroke="#d4a017"
                            stroke-width=".5" opacity=".55" />
                        <ellipse cx="0" cy="14" rx="4.5" ry="7"
                            fill="rgba(255,220,80,.28)" />
                        <rect x="-3.5" y="-5" width="7" height="4" rx="1" fill="#b8960c" />
                        <line x1="-5" y1="31" x2="-5" y2="37" stroke="#b8960c"
                            stroke-width="1.1" />
                        <line x1="0" y1="31" x2="0" y2="39" stroke="#b8960c"
                            stroke-width="1.1" />
                        <line x1="5" y1="31" x2="5" y2="37" stroke="#b8960c"
                            stroke-width="1.1" />
                    </g>
                </svg>

                {{-- ══════ MAIN CARD CONTENT ══════ --}}
                <div class="ic-content">

                    {{-- Bismillah — shown for Islamic event types --}}
                    @if ($isIslamic)
                        <div class="ic-bismillah">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</div>
                    @endif

                    {{-- "Together with our families" --}}
                    <div class="ic-eyebrow" style="margin-top:{{ $isIslamic ? '0' : '2.2rem' }}">
                        Together With Our Families
                    </div>
                    <div class="ic-subline">We cordially invite you to</div>

                    {{-- Event name in Great Vibes script --}}
                    <span class="ic-event-name">{{ $event->order_name }}</span>

                    {{-- Event type label with gold dashes --}}
                    <div class="ic-event-type-row">
                        <div class="ic-type-dash"></div>
                        <span class="ic-type-label">{{ ucfirst($eventType) }}</span>
                        <div class="ic-type-dash r"></div>
                    </div>

                    {{-- Ornament --}}
                    <div class="ic-orn">
                        <div class="ic-orn-line"></div>
                        <div class="ic-orn-diamond"></div>
                        <svg width="12" height="8" viewBox="0 0 12 8" style="opacity:.55">
                            <path d="M6 1 C4 2.5 1 3.5 1 5.5 C1 7 3.5 7.5 6 7.5 C8.5 7.5 11 7 11 5.5 C11 3.5 8 2.5 6 1Z"
                                fill="none" stroke="#b8960c" stroke-width=".8" />
                        </svg>
                        <div class="ic-orn-diamond"></div>
                        <div class="ic-orn-line"></div>
                    </div>

                    {{-- Host line --}}
                    @if ($event->event_host)
                        <div class="ic-host">Hosted by {{ $event->event_host }}</div>
                    @endif

                    {{-- Guest salutation + name --}}
                    <div class="ic-salutation">You are cordially invited,</div>
                    <div class="ic-guest-name">{{ $guest->full_name }}</div>

                    @if ($guestTitle && $guestTitle !== 'guest')
                        <div style="text-align:center; margin-bottom:.9rem;">
                            <span class="ic-guest-badge">
                                <i class="fa-solid fa-star" style="font-size:.5rem;"></i>
                                {{ ucfirst($guestTitle) }}
                            </span>
                        </div>
                    @endif

                    {{-- Ornament divider --}}
                    <div class="ic-orn" style="margin-bottom:.85rem;">
                        <div class="ic-orn-line"></div>
                        <div class="ic-orn-diamond"></div>
                        <div class="ic-orn-diamond"></div>
                        <div class="ic-orn-line"></div>
                    </div>

                    {{-- Blessing / description --}}
                    <p class="ic-blessing">
                        @if ($event->event_desc)
                            {{ $event->event_desc }}
                        @else
                            With the blessings of Allah, we request the honor
                            of your presence at the celebration of our dear ones.
                        @endif
                    </p>

                    {{-- Gold rule --}}
                    <div class="ic-rule"></div>

                    {{-- Date / Time / Venue info strip --}}
                    <div class="ic-info-strip">
                        <div class="ic-info-block">
                            <i class="fa-regular fa-calendar-days ic-info-icon"></i>
                            <div class="ic-info-label">
                                {{ $eventDate->format('l') }}<br>
                                {{ $eventDate->format('M j, Y') }}
                            </div>
                        </div>
                        <div class="ic-info-block">
                            <i class="fa-regular fa-clock ic-info-icon"></i>
                            <div class="ic-info-label">
                                At {{ $arrivalTime->format('g:i A') }}
                            </div>
                        </div>
                        <div class="ic-info-block">
                            <i class="fa-solid fa-location-dot ic-info-icon"></i>
                            <div class="ic-info-label">
                                {{ $event->event_location }}
                            </div>
                        </div>
                    </div>

                    {{-- Closing italic quote --}}
                    <div class="ic-closing">
                        Watoto tunawapena ila hawaruhusiwi.
                    </div>

                    {{-- Small ornament --}}
                    {{-- <div class="ic-orn" style="margin-bottom:.9rem;">
                        <div class="ic-orn-line"></div>
                        <div class="ic-orn-diamond"></div>
                        <svg width="10" height="10" viewBox="0 0 10 10" style="opacity:.55">
                            <path d="M5 1 L5 9 M1 5 L9 5" stroke="#b8960c" stroke-width=".8" />
                            <circle cx="5" cy="5" r="1.5" fill="#b8960c" opacity=".7" />
                        </svg>
                        <div class="ic-orn-diamond"></div>
                        <div class="ic-orn-line"></div>
                    </div> --}}

                    {{-- Jazakum Allah Khair pill --}}
                    @if ($isIslamic)
                        <div class="ic-jazakum">
                            <span class="ic-jazakum-line"></span>
                            Asante na Karibu Sana
                            <span class="ic-jazakum-line"></span>
                        </div>
                    @else
                        <div class="ic-jazakum">
                            <span class="ic-jazakum-line"></span>
                            We look forward to seeing you
                            <span class="ic-jazakum-line"></span>
                        </div>
                    @endif

                </div>{{-- /.ic-content --}}

                {{-- ══════ QR / TICKET SECTION ══════ --}}
                <div style="padding: 0 1.4rem; position:relative; z-index:4; margin-bottom:.2rem;">
                    <div class="ic-ticket">
                        <div class="ic-qr-wrap">
                            <div class="ic-qr-inner">
                                {!! QrCode::size(100)->generate($publicUrl) !!}
                            </div>
                        </div>

                        <div class="ic-ticket-sep"></div>

                        <div class="ic-ticket-meta">
                            <div>
                                <div class="ic-ticket-label">Invitation Code</div>
                                <div class="ic-ticket-code">{{ $guest->invitation_code }}</div>
                            </div>
                            <div>
                                <div class="ic-ticket-label">Admission</div>
                                <div class="ic-ticket-admission">{{ $guest->counter ?? '1 Person' }}</div>
                            </div>
                            <div class="ic-ticket-hint">
                                Scan QR or present code<br>at the entrance
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════ CARD FOOTER ══════ --}}
                <div class="ic-footer" style="position:relative;z-index:4;">
                    <span class="ic-footer-brand">TapEvent Card</span>
                    <span class="ic-footer-valid">
                        <span class="ic-valid-dot"></span>
                        Valid Invitation
                    </span>
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
    <script>
        /* ── 3-D tilt on hover ── */
        (function() {
            const shell = document.getElementById('card-shell');
            const card = document.getElementById('idcard');
            if (!shell || !card) return;
            shell.addEventListener('mousemove', (e) => {
                const r = shell.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - .5;
                const y = (e.clientY - r.top) / r.height - .5;
                card.style.transform = `rotateY(${x*9}deg) rotateX(${-y*7}deg) scale(1.013)`;
                card.style.boxShadow =
                    `${-x*22}px ${-y*18}px 55px rgba(80,30,0,.28), 0 36px 90px rgba(80,35,5,.42)`;
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
                navigator.clipboard.writeText(message.value).then(copied).catch(() => fallbackCopy());
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
            const card = document.getElementById('idcard');
            const button = document.getElementById('download-btn');

            if (!card || typeof html2canvas !== 'function') {
                if (window.showToast) showToast('Image export is unavailable in this browser', 'error');
                return;
            }

            overlay.classList.add('show');
            button.disabled = true;
            title.textContent = 'Generating high-quality image…';
            sub.textContent = 'Preparing the card in your browser';

            const exportWidth = 630;
            const exportStage = document.createElement('div');
            const exportCard = card.cloneNode(true);

            exportStage.style.cssText = [
                'position:fixed',
                'left:-10000px',
                'top:0',
                `width:${exportWidth}px`,
                'min-width:630px',
                'visibility:visible',
                'pointer-events:none',
                'z-index:-1',
                'overflow:visible',
            ].join(';');
            exportCard.style.cssText += [
                `width:${exportWidth}px`,
                'min-width:630px',
                'max-width:630px',
                'transform:none',
                'transition:none',
                'animation:none',
                'margin:0',
            ].join(';');
            exportStage.appendChild(exportCard);
            document.body.appendChild(exportStage);

            const renderCard = async () => {
                if (document.fonts && document.fonts.ready) {
                    await document.fonts.ready;
                }

                const exportHeight = Math.max(1, Math.ceil(exportCard.getBoundingClientRect().height));

                return html2canvas(exportCard, {
                    backgroundColor: '#fdf6ee',
                    scale: 2,
                    width: exportWidth,
                    height: exportHeight,
                    windowWidth: exportWidth,
                    windowHeight: exportHeight,
                    x: 0,
                    y: 0,
                    useCORS: true,
                    logging: false,
                    imageTimeout: 15000,
                    removeContainer: true,
                    onclone: clonedDocument => {
                        clonedDocument.querySelectorAll('link[rel="stylesheet"], style').forEach(
                            stylesheet => {
                                const href = stylesheet.getAttribute('href') || '';
                                const cssText = stylesheet.textContent || '';
                                const isFontStylesheet = href.includes(
                                        'fonts.googleapis.com') ||
                                    href.includes('cdnjs.cloudflare.com');

                                if (stylesheet.tagName === 'LINK' && !isFontStylesheet) {
                                    stylesheet.remove();
                                } else if (!isFontStylesheet && /oklch\(/i.test(cssText)) {
                                    stylesheet.remove();
                                }
                            });

                        const colorCanvas = clonedDocument.createElement('canvas');
                        const colorContext = colorCanvas.getContext('2d');
                        const colorProperties = [
                            'color',
                            'backgroundColor',
                            'borderTopColor',
                            'borderRightColor',
                            'borderBottomColor',
                            'borderLeftColor',
                            'outlineColor',
                            'textDecorationColor',
                            'fill',
                            'stroke',
                        ];

                        const normalizeColor = value => {
                            if (!value || !/oklch\(/i.test(value) || !colorContext)
                                return value;
                            colorContext.fillStyle = '#000000';
                            colorContext.fillStyle = value;
                            return colorContext.fillStyle;
                        };

                        clonedDocument.querySelectorAll('*').forEach(element => {
                            const computedStyle = clonedDocument.defaultView
                                .getComputedStyle(element);

                            colorProperties.forEach(property => {
                                const value = normalizeColor(computedStyle[
                                    property]);
                                if (value && value !== computedStyle[property]) {
                                    element.style[property] = value;
                                }
                            });

                            if (/oklch\(/i.test(computedStyle.backgroundImage)) {
                                element.style.backgroundImage = 'none';
                            }

                            if (/oklch\(/i.test(computedStyle.boxShadow)) {
                                element.style.boxShadow = 'none';
                            }

                            if (/oklch\(/i.test(computedStyle.textShadow)) {
                                element.style.textShadow = 'none';
                            }
                        });

                        const captureStyle = clonedDocument.createElement('style');
                        captureStyle.textContent = `
                            *, *::before, *::after { box-sizing: border-box !important; }
                            #idcard {
                                width: ${exportWidth}px !important;
                                min-width: ${exportWidth}px !important;
                                max-width: ${exportWidth}px !important;
                                transform: none !important;
                                animation: none !important;
                            }
                            #idcard .ic-qr-inner,
                            #idcard .ic-qr-inner svg {
                                width: 100px !important;
                                height: 100px !important;
                                min-width: 100px !important;
                                min-height: 100px !important;
                                display: block !important;
                            }
                        `;
                        clonedDocument.head.appendChild(captureStyle);
                    },
                });
            };

            renderCard()
                .then(canvas => new Promise((resolve, reject) => {
                    canvas.toBlob(blob => blob ? resolve(blob) : reject(new Error(
                        'The image could not be created')), 'image/png');
                }))
                .then(blob => {
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = `invitation-card-{{ $guest->invitation_code ?? 'export' }}.png`;
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    URL.revokeObjectURL(url);

                    spinner.classList.add('done');
                    title.textContent = 'Ready!';
                    sub.textContent = 'Your HD card has been downloaded';
                    setTimeout(() => overlay.classList.remove('show'), 1500);
                })
                .catch(error => {
                    overlay.classList.remove('show');
                    if (window.showToast) showToast(error.message || 'Failed to generate image', 'error');
                })
                .finally(() => {
                    exportStage.remove();
                    button.disabled = false;
                });
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
