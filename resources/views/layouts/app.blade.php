<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bright Finance') — Smart Financial Management</title>
    <meta name="description" content="@yield('meta-description', 'Bright Finance — take control of your money with smart budgeting, goal tracking, and financial insights.')">

    <link rel="icon" type="image/png" href="/assets/images/bright.png">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b; }

        /* ═══ NAVBAR ═══ */
        .gn {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 999;
            transition: box-shadow .2s;
        }
        .gn.scrolled { box-shadow: 0 2px 16px rgba(0,0,0,.08); }

        .gn-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        /* Logo */
        .gn-logo { display: flex; align-items: center; gap: 8px; text-decoration: none; flex-shrink: 0; }
        .gn-logo img { height: 2.4rem; }
        .gn-logo-text { display: flex; flex-direction: column; }
        .gn-logo-name { font-size: .9rem; font-weight: 800; color: #0f172a; line-height: 1; }
        .gn-logo-tag  { font-size: .58rem; font-weight: 600; text-transform: uppercase; letter-spacing: .1em; color: #94a3b8; }

        /* Desktop links */
        .gn-links {
            display: flex;
            align-items: center;
            gap: 2px;
            list-style: none;
        }
        .gn-links a {
            display: block;
            font-size: .88rem;
            font-weight: 500;
            color: #475569;
            padding: 7px 13px;
            border-radius: 7px;
            text-decoration: none;
            position: relative;
            transition: color .15s, background .15s;
        }
        .gn-links a::after {
            content: '';
            position: absolute;
            bottom: 1px; left: 13px; right: 13px;
            height: 2px;
            border-radius: 2px;
            background: #1d4ed8;
            transform: scaleX(0);
            transition: transform .2s;
        }
        .gn-links a:hover { color: #0f172a; background: #f8fafc; }
        .gn-links a.active { color: #1d4ed8; background: #eff6ff; }
        .gn-links a.active::after { transform: scaleX(1); }

        /* CTA buttons */
        .gn-cta { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
        .btn-ghost {
            font-size: .85rem; font-weight: 600; color: #1d4ed8;
            border: 1.5px solid #1d4ed8; border-radius: 8px;
            padding: 7px 18px; text-decoration: none;
            transition: background .15s, color .15s;
            white-space: nowrap;
        }
        .btn-ghost:hover { background: #1d4ed8; color: #fff; }
        .btn-fill {
            font-size: .85rem; font-weight: 700;
            background: #1d4ed8; color: #fff;
            border: 1.5px solid #1d4ed8; border-radius: 8px;
            padding: 7px 18px; text-decoration: none;
            transition: background .15s;
            white-space: nowrap;
        }
        .btn-fill:hover { background: #1e40af; color: #fff; }

        /* Hamburger */
        .gn-burger {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 40px; height: 40px;
            border: none; background: none; cursor: pointer;
            border-radius: 8px;
            padding: 8px;
            gap: 5px;
        }
        .gn-burger:hover { background: #f1f5f9; }
        .gn-burger span {
            display: block;
            width: 22px; height: 2px;
            background: #475569; border-radius: 2px;
            transition: transform .25s, opacity .25s, width .25s;
            transform-origin: center;
        }
        .gn-burger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .gn-burger.open span:nth-child(2) { opacity: 0; width: 0; }
        .gn-burger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* Mobile drawer */
        .gn-drawer {
            display: none;
            background: #fff;
            border-top: 1px solid #f1f5f9;
            padding: 12px 16px 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
        }
        .gn-drawer.open { display: block; }

        .gn-drawer-links {
            list-style: none;
            margin-bottom: 16px;
        }
        .gn-drawer-links a {
            display: flex; align-items: center; gap: 10px;
            font-size: .9rem; font-weight: 500; color: #334155;
            padding: 11px 12px; border-radius: 10px;
            text-decoration: none;
            transition: background .15s, color .15s;
        }
        .gn-drawer-links a:hover { background: #f8fafc; color: #0f172a; }
        .gn-drawer-links a.active { background: #eff6ff; color: #1d4ed8; font-weight: 600; }
        .gn-drawer-links a .di { width: 20px; text-align: center; font-size: .9rem; }

        .gn-drawer-divider { height: 1px; background: #f1f5f9; margin: 8px 0; }

        .gn-drawer-cta {
            display: flex; flex-direction: column; gap: 8px;
        }
        .gn-drawer-cta a {
            display: block; text-align: center;
            font-size: .9rem; font-weight: 700;
            padding: 12px; border-radius: 10px;
            text-decoration: none;
        }
        .gn-drawer-cta .dc-ghost {
            color: #1d4ed8;
            border: 1.5px solid #1d4ed8;
        }
        .gn-drawer-cta .dc-fill {
            background: #1d4ed8; color: #fff;
        }

        /* Show burger on mobile */
        @media (max-width: 768px) {
            .gn-links, .gn-cta { display: none; }
            .gn-burger { display: flex; }
            .gn-logo-tag { display: none; }
        }

        /* ═══ MAIN / FOOTER ═══ */
        main { min-height: calc(100vh - 64px - 130px); }

        .guest-footer {
            background: #0f172a; color: #94a3b8;
            padding: 44px 0 24px;
        }
        .guest-footer .gf-inner { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .guest-footer a { color: #94a3b8; text-decoration: none; transition: color .15s; }
        .guest-footer a:hover { color: #e2e8f0; }
        .guest-footer .gf-brand { font-size: 1.05rem; font-weight: 800; color: #f1f5f9; }
        .guest-footer .gf-tag   { font-size: .8rem; margin-top: 4px; line-height: 1.5; }
        .guest-footer .gf-head  { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #cbd5e1; margin-bottom: 12px; }
        .guest-footer .gf-link  { display: block; font-size: .84rem; margin-bottom: 7px; }
        .guest-footer .gf-social {
            width: 34px; height: 34px; border-radius: 50%;
            background: rgba(255,255,255,.07);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .85rem; color: #cbd5e1;
            transition: background .15s; margin-right: 6px; margin-top: 10px;
        }
        .guest-footer .gf-social:hover { background: rgba(255,255,255,.16); color: #fff; }
        .guest-footer hr { border-color: rgba(255,255,255,.08); margin: 28px 0 18px; }
        .guest-footer .gf-copy { font-size: .75rem; }
    </style>

    @yield('head')
</head>
<body>

{{-- ═══ NAVBAR ═══ --}}
<nav class="gn" id="guestNav">
    <div class="gn-inner">

        {{-- Logo --}}
        <a class="gn-logo" href="{{ route('welcome') }}">
            <img src="/assets/images/Bright v4.png" alt="Bright Finance">
            <div class="gn-logo-text">
                <span class="gn-logo-name">Bright Finance</span>
                <span class="gn-logo-tag">Smart Money</span>
            </div>
        </a>

        {{-- Desktop links --}}
        <ul class="gn-links">
            <li><a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('features') }}" class="{{ request()->routeIs('features') ? 'active' : '' }}">Features</a></li>
            <li><a href="{{ route('About') }}" class="{{ request()->routeIs('About') ? 'active' : '' }}">About</a></li>
            <li><a href="{{ route('Contact') }}" class="{{ request()->routeIs('Contact') ? 'active' : '' }}">Contact</a></li>
        </ul>

        {{-- Desktop CTA --}}
        <div class="gn-cta">
            @auth
                <a class="btn-fill" href="{{ route('home') }}">Dashboard →</a>
            @else
                @if(Route::has('login'))
                    <a class="btn-ghost" href="{{ route('login') }}">Log In</a>
                @endif
                @if(Route::has('register'))
                    <a class="btn-fill" href="{{ route('register') }}">Sign Up Free</a>
                @endif
            @endauth
        </div>

        {{-- Hamburger (mobile) --}}
        <button class="gn-burger" id="gnBurger" aria-label="Toggle menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>

    {{-- Mobile drawer --}}
    <div class="gn-drawer" id="gnDrawer">
        <ul class="gn-drawer-links">
            <li><a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">
                <span class="di"><i class="fas fa-home"></i></span> Home
            </a></li>
            <li><a href="{{ route('features') }}" class="{{ request()->routeIs('features') ? 'active' : '' }}">
                <span class="di"><i class="fas fa-star"></i></span> Features
            </a></li>
            <li><a href="{{ route('About') }}" class="{{ request()->routeIs('About') ? 'active' : '' }}">
                <span class="di"><i class="fas fa-info-circle"></i></span> About
            </a></li>
            <li><a href="{{ route('Contact') }}" class="{{ request()->routeIs('Contact') ? 'active' : '' }}">
                <span class="di"><i class="fas fa-envelope"></i></span> Contact
            </a></li>
        </ul>

        <div class="gn-drawer-divider"></div>

        <div class="gn-drawer-cta">
            @auth
                <a class="dc-fill" href="{{ route('home') }}">Go to Dashboard →</a>
            @else
                @if(Route::has('login'))
                    <a class="dc-ghost" href="{{ route('login') }}">Log In</a>
                @endif
                @if(Route::has('register'))
                    <a class="dc-fill" href="{{ route('register') }}">Sign Up Free — it's free</a>
                @endif
            @endauth
        </div>
    </div>
</nav>

{{-- Flash --}}
@if(session('status'))
<div style="max-width:1200px;margin:16px auto 0;padding:0 24px;">
    <div class="alert alert-info alert-dismissible fade show rounded-3" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<main>@yield('content')</main>

{{-- ═══ FOOTER ═══ --}}
<footer class="guest-footer">
    <div class="gf-inner">
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:32px;">
            <div>
                <div class="gf-brand">Bright Finance</div>
                <div class="gf-tag">Your trusted companion for smarter<br>money decisions. Built in South Africa.</div>
                <div>
                    <a href="#" class="gf-social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="gf-social"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="gf-social"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="gf-social"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div>
                <div class="gf-head">Product</div>
                <a href="{{ route('features') }}" class="gf-link">Features</a>
                <a href="{{ route('register') }}" class="gf-link">Sign Up</a>
                <a href="{{ route('login') }}" class="gf-link">Log In</a>
            </div>
            <div>
                <div class="gf-head">Company</div>
                <a href="{{ route('About') }}" class="gf-link">About Us</a>
                <a href="{{ route('Contact') }}" class="gf-link">Contact</a>
            </div>
            <div>
                <div class="gf-head">Legal</div>
                <a href="#" class="gf-link">Privacy Policy</a>
                <a href="#" class="gf-link">Terms of Service</a>
            </div>
        </div>
        <hr>
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
            <p class="gf-copy" style="margin:0;">© {{ date('Y') }} Bright Finance. All rights reserved.</p>
            <p class="gf-copy" style="margin:0;">Built in South Africa 🇿🇦</p>
        </div>
    </div>
</footer>

{{-- Mobile footer adjustment --}}
<style>
@media (max-width: 640px) {
    .gf-inner > div:first-child { grid-template-columns: 1fr 1fr !important; }
    .gf-inner > div:first-child > div:first-child { grid-column: 1 / -1; }
}
</style>

<script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<script>
(function () {
    var nav    = document.getElementById('guestNav');
    var burger = document.getElementById('gnBurger');
    var drawer = document.getElementById('gnDrawer');

    // Scroll shadow
    window.addEventListener('scroll', function () {
        nav.classList.toggle('scrolled', window.scrollY > 10);
    }, { passive: true });

    // Hamburger toggle
    burger.addEventListener('click', function () {
        var open = drawer.classList.toggle('open');
        burger.classList.toggle('open', open);
        burger.setAttribute('aria-expanded', open);
        document.body.style.overflow = open ? 'hidden' : '';
    });

    // Close on link click inside drawer
    drawer.querySelectorAll('a').forEach(function (a) {
        a.addEventListener('click', function () {
            drawer.classList.remove('open');
            burger.classList.remove('open');
            burger.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        });
    });

    // Close on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && drawer.classList.contains('open')) {
            drawer.classList.remove('open');
            burger.classList.remove('open');
            burger.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }
    });
})();
</script>

@yield('scripts')
</body>
</html>
