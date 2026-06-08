{{-- ============================================================
   TapEventCard — WhatsApp Notification Showcase (red theme, phone mockup)
   ============================================================ --}}
<style>
    .notif-section {
        padding: 100px 0;
        background: linear-gradient(180deg, #f5f5f7 0%, #fff 100%);
        overflow: hidden;
        transition: background .3s;
    }

    html.dark .notif-section {
        background: linear-gradient(180deg, #000 0%, #0a0a0a 100%);
    }

    .notif-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 1.5rem;
        flex-wrap: wrap;
    }

    /* Phone mockup frame */
    .phone-mockup {
        position: relative;
        width: 280px;
        height: 560px;
        background: #1d1d1f;
        border-radius: 48px;
        padding: 18px;
        box-shadow: 0 30px 70px rgba(0, 0, 0, .25), 0 0 0 2px rgba(255, 255, 255, .05);
        transition: transform .3s ease, box-shadow .3s ease;
        z-index: 2;
        flex-shrink: 0;
    }

    html.dark .phone-mockup {
        box-shadow: 0 30px 70px rgba(0, 0, 0, .6), 0 0 0 2px rgba(255, 255, 255, .1);
    }

    .phone-mockup:hover {
        transform: translateY(-6px);
        box-shadow: 0 40px 90px rgba(0, 0, 0, .3), 0 0 0 2px rgba(255, 255, 255, .08);
    }

    .phone-screen {
        width: 100%;
        height: 100%;
        background: #0a0a0a;
        border-radius: 36px;
        overflow: hidden;
        position: relative;
        border: 1px solid #2c2c2e;
    }

    /* Status bar */
    .phone-status-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 18px 4px;
        color: #fff;
        font-size: 11px;
        font-weight: 500;
        background: #1c1c1e;
        border-bottom: 1px solid #2c2c2e;
    }

    /* WhatsApp header */
    .whatsapp-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: #075e54;
        color: #fff;
        font-weight: 600;
        font-size: 13px;
    }

    .whatsapp-header-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #25d366;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
        flex-shrink: 0;
    }

    /* Chat area */
    .chat-area {
        padding: 12px 14px;
        height: calc(100% - 90px);
        overflow-y: auto;
        background: #131313;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    /* Message bubbles */
    .msg-bubble {
        max-width: 85%;
        padding: 8px 12px;
        border-radius: 14px;
        font-size: 11px;
        line-height: 1.4;
        word-break: break-word;
        position: relative;
        opacity: 0;
        transform: translateY(12px);
        animation: msgIn .5s ease forwards;
    }

    .msg-bubble.received {
        background: #1c1c1e;
        color: #e4e4e4;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
    }

    .msg-bubble.sent {
        background: #025c4c;
        color: #d1f0e5;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }

    .msg-time {
        font-size: 9px;
        color: #8e8e93;
        margin-top: 2px;
        text-align: right;
    }

    .msg-image-placeholder {
        background: #2c2c2e;
        border-radius: 10px;
        width: 100%;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: #aaa;
        margin-bottom: 4px;
    }

    /* Staggered animation delays */
    .msg-bubble:nth-child(1) {
        animation-delay: 0.2s;
    }

    .msg-bubble:nth-child(2) {
        animation-delay: 0.5s;
    }

    .msg-bubble:nth-child(3) {
        animation-delay: 0.8s;
    }

    .msg-bubble:nth-child(4) {
        animation-delay: 1.1s;
    }

    .msg-bubble:nth-child(5) {
        animation-delay: 1.4s;
    }

    .msg-bubble:nth-child(6) {
        animation-delay: 1.7s;
    }

    @keyframes msgIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Glow around phone */
    .phone-glow {
        position: absolute;
        inset: -10px;
        border-radius: 56px;
        background: radial-gradient(circle at 50% 50%, rgba(232, 18, 10, .3), transparent 70%);
        filter: blur(20px);
        z-index: -1;
        animation: pulseGlow 3s ease-in-out infinite alternate;
    }

    @keyframes pulseGlow {
        0% {
            opacity: 0.5;
            transform: scale(1);
        }

        100% {
            opacity: 0.8;
            transform: scale(1.03);
        }
    }

    /* Notification badge above phone */
    .notif-badge {
        position: absolute;
        top: -12px;
        right: 24px;
        background: #e8120a;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgba(232, 18, 10, .4);
        animation: badgePop 2s ease-in-out infinite;
    }

    @keyframes badgePop {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    /* Right side text */
    .notif-text {
        max-width: 380px;
        z-index: 1;
        text-align: left;
    }

    .notif-text h2 {
        font-family: 'DM Serif Display', serif;
        color: #1d1d1f;
        font-size: 2.5rem;
        line-height: 1.2;
        margin-bottom: 1rem;
    }

    html.dark .notif-text h2 {
        color: #fff;
    }

    .notif-text p {
        color: #6e6e73;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    html.dark .notif-text p {
        color: #86868b;
    }

    .notif-highlight {
        color: #e8120a;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .notif-container {
            flex-direction: column;
            text-align: center;
        }

        .notif-text {
            text-align: center;
            max-width: 100%;
        }

        .phone-mockup {
            width: 240px;
            height: 480px;
            padding: 14px;
            border-radius: 40px;
        }

        .phone-screen {
            border-radius: 30px;
        }
    }
</style>

<section class="notif-section fade-up">
    <div class="text-center mb-16">
        <div class="section-eyebrow-red" style="display:inline-block;">Seamless Delivery</div>
        <h2 class="font-display text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mt-2 mb-4">
            Invitations that<br><span style="color:#e8120a">reach everyone.</span>
        </h2>
        <p class="dark-sub max-w-lg mx-auto text-lg">Guests receive automated WhatsApp messages with a single card image
            and a one‑tap event link.</p>
    </div>

    <div class="notif-container">
        {{-- Left side: phone mockup --}}
        <div class="phone-mockup">
            <div class="phone-glow"></div>
            <div class="notif-badge">3 NEW</div>
            <div class="phone-screen">
                <div class="phone-status-bar">
                    <span>9:41</span>
                    <span>📶 􀊨 􀋦</span>
                </div>
                <div class="whatsapp-header">
                    <div class="whatsapp-header-avatar">T</div>
                    <div>
                        <div>TapEventCard</div>
                        <div style="font-size:9px;font-weight:400;">online</div>
                    </div>
                </div>
                <div class="chat-area">
                    <div class="msg-bubble received">
                        Hello Jawad! 🎉<br>You’re invited to <strong>Sarah & Ahmed’s Wedding</strong> on Aug 14.
                        <div class="msg-time">10:02 AM</div>
                    </div>
                    <div class="msg-bubble sent">
                        Tap to open your <span class="notif-highlight">digital card</span>
                        <div class="msg-image-placeholder"
                            style="background:linear-gradient(135deg,#e8120a,#c41009);width:100%;height:80px;border-radius:10px;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;">
                            Wedding Invitation</div>
                        <div class="msg-time">10:02 AM</div>
                    </div>
                    <div class="msg-bubble received">
                        We’ll remind you 2 days before and on the big day. See you there!
                        <div class="msg-time">10:03 AM</div>
                    </div>
                    <div class="msg-bubble sent" style="margin-top:12px;">
                        ⏳ <strong>2 days to go!</strong><br>Your live countdown is ready.
                        <div class="msg-time">Aug 12</div>
                    </div>
                    <div class="msg-bubble sent">
                        🎊 <strong>Today is the day!</strong><br>Check‑in with your QR code at the entrance.
                        <div class="msg-image-placeholder"
                            style="background:#fff;width:80px;height:80px;border-radius:10px;position:relative;">
                            <div
                                style="width:100%;height:100%;background:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect x=%2225%22 y=%2225%22 width=%2220%22 height=%2220%22 fill=%22none%22 stroke=%22%23000%22 stroke-width=%224%22/%3E%3Crect x=%2255%22 y=%2225%22 width=%2220%22 height=%2220%22 fill=%22none%22 stroke=%22%23000%22 stroke-width=%224%22/%3E%3Crect x=%2225%22 y=%2255%22 width=%2220%22 height=%2220%22 fill=%22none%22 stroke=%22%23000%22 stroke-width=%224%22/%3E%3Cpath d=%22M55 55h12v12H55zm0 0h12v12H55z%22 fill=%22%23000%22/%3E%3C/svg%3E')">
                            </div>
                        </div>
                        <div class="msg-time">Aug 14</div>
                    </div>
                    <div class="msg-bubble received">
                        Thank you for celebrating with us! ❤️
                        <div class="msg-time">Aug 15</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right side: features list --}}
        <div class="notif-text">
            <h2 class="font-bold" style="font-family:'DM Sans',sans-serif;font-size:2rem;color:#1d1d1f;">Automated.
                Personal. <span style="color:#e8120a">Effortless.</span></h2>
            <div class="space-y-3 mt-6">
                <div class="flex items-start gap-3">
                    <div
                        class="w-6 h-6 rounded-full bg-[#e8120a] flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke="white" stroke-width="2.5" stroke-linecap="round" />
                        </svg>
                    </div>
                    <p class="text-sm dark-sub">Instant WhatsApp & Email delivery — no apps to install.</p>
                </div>
                <div class="flex items-start gap-3">
                    <div
                        class="w-6 h-6 rounded-full bg-[#e8120a] flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke="white" stroke-width="2.5" stroke-linecap="round" />
                        </svg>
                    </div>
                    <p class="text-sm dark-sub">Timed reminders: 2 days before and event day morning.</p>
                </div>
                <div class="flex items-start gap-3">
                    <div
                        class="w-6 h-6 rounded-full bg-[#e8120a] flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke="white" stroke-width="2.5" stroke-linecap="round" />
                        </svg>
                    </div>
                    <p class="text-sm dark-sub">One‑tap card access with QR entry verification.</p>
                </div>
                <div class="flex items-start gap-3">
                    <div
                        class="w-6 h-6 rounded-full bg-[#e8120a] flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke="white" stroke-width="2.5" stroke-linecap="round" />
                        </svg>
                    </div>
                    <p class="text-sm dark-sub">Post‑event thank‑you message automatically sent.</p>
                </div>
            </div>
        </div>
    </div>
</section>
