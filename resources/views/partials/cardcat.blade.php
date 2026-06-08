{{-- ============================================================
   TapEventCard — Floating Moments Gallery (red theme, highly animated)
   Place this partial on your home page: @include('partials._floating_gallery')
   ============================================================ --}}
<style>
    /* ---------- Gallery Section ---------- */
    .float-gallery {
        position: relative;
        padding: 100px 0;
        background: radial-gradient(ellipse 80% 50% at 50% 30%, rgba(232, 18, 10, .06) 0%, transparent 60%), #fff;
        overflow: hidden;
        transition: background .3s;
    }

    html.dark .float-gallery {
        background: radial-gradient(ellipse 80% 50% at 50% 30%, rgba(232, 18, 10, .1) 0%, transparent 60%), #000;
    }

    /* ---------- Container for floating cards ---------- */
    .float-stage {
        position: relative;
        max-width: 1000px;
        margin: 0 auto;
        height: 500px;
        /* fixed height for the floating area */
    }

    /* ---------- Individual floating card ---------- */
    .float-card {
        position: absolute;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, .15), 0 4px 10px rgba(0, 0, 0, .05);
        overflow: hidden;
        transition: box-shadow .5s ease, transform .5s ease;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
        animation-direction: alternate;
        will-change: transform;
        cursor: default;
        border: 1px solid rgba(255, 255, 255, .4);
        backdrop-filter: blur(0px);
        background: #fff;
        /* fallback for images */
    }

    html.dark .float-card {
        border-color: rgba(255, 255, 255, .08);
        background: #1c1c1e;
        box-shadow: 0 20px 50px rgba(0, 0, 0, .5), 0 4px 10px rgba(0, 0, 0, .3);
    }

    .float-card img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ---------- Custom floating keyframes ---------- */
    @keyframes float1 {
        0% {
            transform: translateY(0px) rotate(-2deg);
        }

        100% {
            transform: translateY(-25px) rotate(1deg);
        }
    }

    @keyframes float2 {
        0% {
            transform: translateY(0px) rotate(3deg) scale(1);
        }

        100% {
            transform: translateY(-35px) rotate(-1deg) scale(1.02);
        }
    }

    @keyframes float3 {
        0% {
            transform: translateY(0px) rotate(-4deg);
        }

        100% {
            transform: translateY(-18px) rotate(2deg);
        }
    }

    @keyframes float4 {
        0% {
            transform: translateY(0px) rotate(1.5deg);
        }

        100% {
            transform: translateY(-30px) rotate(-2deg);
        }
    }

    @keyframes float5 {
        0% {
            transform: translateY(0px) rotate(-1deg) scale(1);
        }

        100% {
            transform: translateY(-22px) rotate(3deg) scale(1.04);
        }
    }

    @keyframes float6 {
        0% {
            transform: translateY(0px) rotate(2deg);
        }

        100% {
            transform: translateY(-28px) rotate(-3deg);
        }
    }

    /* ---------- Mobile adjustments ---------- */
    @media (max-width: 768px) {
        .float-stage {
            height: 400px;
        }

        .float-card {
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .1);
        }
    }
</style>

<section class="float-gallery fade-up">
    <div class="text-center mb-10">
        <div class="section-eyebrow-red" style="display:inline-block;">Moments That Shine</div>
        <h2 class="font-display text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mt-2 mb-4">
            Every event tells a story
        </h2>
        <p class="dark-sub max-w-lg mx-auto text-lg">Our cards capture the heart of your celebration — here are a few
            favourites.</p>
    </div>

    <div class="float-stage">
        {{-- Card 1 (largest, center-left) --}}
        <div class="float-card"
            style="
            width: 260px; height: 350px;
            top: 40px; left: 5%;
            animation-name: float1;
            animation-duration: 5.5s;
            animation-delay: -1s;
            z-index: 5;
        ">
            <img src="https://images.unsplash.com/photo-1699730164892-d7c433524ff3?q=80&w=1472&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Wedding toast">
        </div>

        {{-- Card 2 (small, top right) --}}
        <div class="float-card"
            style="
            width: 180px; height: 240px;
            top: 10px; right: 10%;
            animation-name: float2;
            animation-duration: 6.2s;
            animation-delay: -0.5s;
            z-index: 4;
        ">
            <img src="https://images.unsplash.com/photo-1529636798458-92182e662485?w=300&h=400&fit=crop"
                alt="Corporate dinner">
        </div>

        {{-- Card 3 (medium, bottom left) --}}
        <div class="float-card"
            style="
            width: 220px; height: 300px;
            bottom: 30px; left: 18%;
            animation-name: float3;
            animation-duration: 7s;
            animation-delay: -2s;
            z-index: 6;
        ">
            <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=350&h=450&fit=crop"
                alt="Outdoor party">
        </div>

        {{-- Card 4 (large, center-right) --}}
        <div class="float-card"
            style="
            width: 240px; height: 330px;
            top: 60px; right: 5%;
            animation-name: float4;
            animation-duration: 5.8s;
            animation-delay: -0.2s;
            z-index: 7;
        ">
            <img src="https://images.unsplash.com/photo-1541532713592-79a0317b6b77?q=80&w=1288&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Birthday celebration">
        </div>

        {{-- Card 5 (small, bottom right) --}}
        <div class="float-card"
            style="
            width: 160px; height: 210px;
            bottom: 60px; right: 25%;
            animation-name: float5;
            animation-duration: 6.8s;
            animation-delay: -1.8s;
            z-index: 3;
        ">
            <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=250&h=350&fit=crop"
                alt="Gala dinner">
        </div>

        {{-- Card 6 (tiny, center floating) --}}
        <div class="float-card"
            style="
            width: 140px; height: 190px;
            top: 120px; left: 45%;
            animation-name: float6;
            animation-duration: 7.4s;
            animation-delay: -0.8s;
            z-index: 2;
        ">
            <img src="https://images.unsplash.com/photo-1607190074257-dd4b7af0309f?q=80&w=1287&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Small gathering">
        </div>
    </div>
</section>
