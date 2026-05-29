<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Bright Finance</title>
    <meta name="description" content="Bright Finance — smart financial management">

    <link rel="icon" type="image/png" href="/assets/images/bright.png">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet">
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="/assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            margin: 0;
            --sidebar-w: 260px;
            --topbar-h: 60px;
        }

        /* ═══ SIDEBAR ═══ */
        #sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: linear-gradient(180deg, #1e3a8a 0%, #1d4ed8 100%);
            display: flex;
            flex-direction: column;
            z-index: 300;
            overflow: hidden;
            transition: transform .28s cubic-bezier(.4,0,.2,1), box-shadow .28s;
        }

        /* Sidebar header */
        .sb-header {
            padding: 18px 16px 12px;
            flex-shrink: 0;
        }
        .sb-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .sb-logo img { height: 2.2rem; flex-shrink: 0; }
        .sb-logo-text {}
        .sb-logo-name { font-size: .92rem; font-weight: 800; color: #fff; line-height: 1.1; }
        .sb-logo-tag  { font-size: .57rem; font-weight: 600; text-transform: uppercase; letter-spacing: .1em; color: rgba(255,255,255,.55); }

        /* Close button (mobile only) */
        .sb-close {
            display: none;
            position: absolute;
            top: 14px; right: 14px;
            width: 32px; height: 32px;
            border: none; background: rgba(255,255,255,.12);
            border-radius: 50%; cursor: pointer; color: #fff;
            align-items: center; justify-content: center;
            font-size: 1rem; line-height: 1;
            transition: background .15s;
        }
        .sb-close:hover { background: rgba(255,255,255,.22); }

        /* User card */
        .sb-user {
            margin: 0 12px 8px;
            background: rgba(255,255,255,.1);
            border-radius: 12px;
            padding: 10px 12px;
            display: flex; align-items: center; gap: 10px;
            flex-shrink: 0;
        }
        .sb-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(255,255,255,.25);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .88rem; color: #fff;
            flex-shrink: 0;
        }
        .sb-uname { font-size: .82rem; font-weight: 600; color: #fff; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sb-urole { font-size: .68rem; color: rgba(255,255,255,.6); }

        /* Divider */
        .sb-hr { border: none; border-top: 1px solid rgba(255,255,255,.12); margin: 4px 12px; flex-shrink: 0; }

        /* Scrollable nav body */
        .sb-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 4px 8px 80px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.15) transparent;
        }
        .sb-nav::-webkit-scrollbar { width: 4px; }
        .sb-nav::-webkit-scrollbar-track { background: transparent; }
        .sb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 4px; }

        /* Section label */
        .sb-label {
            font-size: .62rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .1em;
            color: rgba(255,255,255,.45);
            padding: 14px 12px 4px;
        }

        /* Nav item */
        .sb-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            margin-bottom: 2px;
            text-decoration: none;
            color: rgba(255,255,255,.75);
            font-size: .84rem; font-weight: 500;
            transition: background .15s, color .15s, padding-left .15s;
            position: relative;
        }
        .sb-item:hover {
            background: rgba(255,255,255,.12);
            color: #fff;
            padding-left: 16px;
        }
        .sb-item.active {
            background: rgba(255,255,255,.18);
            color: #fff;
            font-weight: 600;
        }
        .sb-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 6px; bottom: 6px;
            width: 3px; border-radius: 0 3px 3px 0;
            background: #7dd3fc;
        }
        .sb-item i {
            font-size: 1.05rem;
            flex-shrink: 0;
            width: 20px; text-align: center;
        }

        /* Logout special */
        .sb-item.sb-logout { color: rgba(255,255,255,.55); }
        .sb-item.sb-logout:hover { background: rgba(239,68,68,.2); color: #fca5a5; }

        /* ═══ BACKDROP ═══ */
        #sidebarBackdrop {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 299;
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }
        #sidebarBackdrop.show { display: block; }

        /* ═══ PAGE SHELL ═══ */
        .page-shell {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left .28s;
        }

        /* ═══ TOP BAR ═══ */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e8eef4;
            height: var(--topbar-h);
            display: flex; align-items: center;
            padding: 0 20px;
            gap: 12px;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 1px 0 #e8eef4;
        }

        /* Hamburger (mobile) */
        .tb-burger {
            display: none;
            flex-direction: column; justify-content: center; align-items: center;
            width: 38px; height: 38px;
            border: none; background: none; cursor: pointer;
            border-radius: 8px; gap: 5px; padding: 8px;
            flex-shrink: 0;
        }
        .tb-burger:hover { background: #f1f5f9; }
        .tb-burger span {
            display: block; width: 20px; height: 2px;
            background: #475569; border-radius: 2px;
            transition: transform .25s, opacity .25s;
        }

        /* Page info */
        .tb-info { flex: 1; min-width: 0; }
        .tb-breadcrumb {
            display: flex; align-items: center; gap: 4px;
            font-size: .72rem; color: #94a3b8; margin-bottom: 1px;
        }
        .tb-breadcrumb a { color: #94a3b8; text-decoration: none; }
        .tb-breadcrumb a:hover { color: #1d4ed8; }
        .tb-breadcrumb span { color: #cbd5e1; }
        .tb-title { font-size: 1rem; font-weight: 700; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        /* Right actions */
        .tb-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
        .tb-btn {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: .8rem; font-weight: 600;
            background: #1d4ed8; color: #fff;
            border: none; border-radius: 8px;
            padding: 7px 14px; cursor: pointer; text-decoration: none;
            transition: background .15s;
            white-space: nowrap;
        }
        .tb-btn:hover { background: #1e40af; color: #fff; }
        .tb-btn i { font-size: .9rem; }
        .tb-icon {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #64748b; text-decoration: none;
            transition: background .15s, color .15s;
        }
        .tb-icon:hover { background: #f1f5f9; color: #0f172a; }
        .tb-icon i { font-size: 1.2rem; }

        /* ═══ CONTENT ═══ */
        .page-content { flex: 1; padding: 20px 24px; }

        /* Flash */
        .flash-wrap { padding: 0 24px; margin-top: 12px; }
        .flash-alert {
            display: flex; align-items: center; gap: 8px;
            border-radius: 10px; padding: 10px 14px;
            font-size: .86rem; font-weight: 500;
            border: 1px solid transparent;
            position: relative;
        }
        .flash-alert.success { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
        .flash-alert.danger  { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
        .flash-alert.info    { background: #eff6ff; border-color: #bfdbfe; color: #1e40af; }
        .flash-close {
            position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
            background: none; border: none; font-size: 1rem; cursor: pointer;
            color: inherit; opacity: .6; padding: 0 4px;
        }
        .flash-close:hover { opacity: 1; }

        /* ═══ APP FOOTER ═══ */
        .app-footer {
            border-top: 1px solid #e8eef4;
            padding: 12px 24px;
            display: flex; justify-content: space-between; align-items: center;
            font-size: .75rem; color: #94a3b8;
            background: #fff;
        }

        /* ═══ MOBILE BOTTOM NAV ═══ */
        .bottom-nav {
            display: none;
            position: fixed; bottom: 0; left: 0; right: 0;
            background: #fff;
            border-top: 1px solid #e2e8f0;
            z-index: 200;
            box-shadow: 0 -4px 12px rgba(0,0,0,.06);
        }
        .bn-list {
            display: flex; list-style: none;
            margin: 0; padding: 0;
        }
        .bn-item {
            flex: 1;
            display: flex; flex-direction: column; align-items: center;
            padding: 8px 4px 6px;
            text-decoration: none;
            color: #94a3b8;
            font-size: .6rem; font-weight: 600;
            gap: 3px;
            transition: color .15s;
            position: relative;
        }
        .bn-item:hover, .bn-item.active { color: #1d4ed8; }
        .bn-item.active::before {
            content: '';
            position: absolute; top: 0; left: 20%; right: 20%;
            height: 2.5px; border-radius: 0 0 3px 3px;
            background: #1d4ed8;
        }
        .bn-item i { font-size: 1.3rem; }
        .bn-more i { font-size: 1.3rem; }

        /* ═══ RESPONSIVE ═══ */
        @media (max-width: 1024px) {
            body { --sidebar-w: 240px; }
        }

        @media (max-width: 768px) {
            /* Sidebar becomes off-canvas drawer */
            #sidebar {
                transform: translateX(-100%);
                box-shadow: none;
                width: min(var(--sidebar-w), 85vw);
            }
            #sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 32px rgba(0,0,0,.2);
            }
            .sb-close { display: flex; }

            /* Page shell no longer offset */
            .page-shell { margin-left: 0; }

            /* Show hamburger */
            .tb-burger { display: flex; }

            /* Shrink topbar text on small screens */
            .tb-title { font-size: .9rem; }
            .tb-breadcrumb { display: none; }

            /* Hide desktop "New Transaction" label, keep icon */
            .tb-btn .tb-btn-text { display: none; }
            .tb-btn { padding: 7px; border-radius: 8px; }

            /* Bottom nav */
            .bottom-nav { display: block; }

            /* Extra bottom padding so content isn't behind bottom nav */
            .page-content { padding-bottom: 72px; }
            .app-footer { display: none; }
        }
    </style>

    @yield('head')
</head>

<body>

{{-- ═══ BACKDROP ═══ --}}
<div id="sidebarBackdrop"></div>

{{-- ═══ SIDEBAR ═══ --}}
<aside id="sidebar" role="navigation" aria-label="Main navigation">

    <div class="sb-header">
        <a class="sb-logo" href="{{ route('home') }}">
            <img src="/assets/images/Bright v4.png" alt="Bright Finance">
            <div class="sb-logo-text">
                <div class="sb-logo-name">Bright Finance</div>
                <div class="sb-logo-tag">Smart Money</div>
            </div>
        </a>
        <button class="sb-close" id="sbClose" aria-label="Close sidebar">✕</button>
    </div>

    <div class="sb-user">
        <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
        <div style="min-width:0;">
            <div class="sb-uname">{{ auth()->user()->name ?? 'User' }}</div>
            <div class="sb-urole">{{ ucfirst(strtolower(auth()->user()->role ?? 'member')) }}</div>
        </div>
    </div>

    <hr class="sb-hr">

    <nav class="sb-nav">

        {{-- Core --}}
        <div class="sb-label">Core</div>

        <a class="sb-item {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
            <i class="material-icons-round">dashboard</i> Dashboard
        </a>
        <a class="sb-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
            <i class="material-icons-round">swap_horiz</i> Transactions
        </a>
        <a class="sb-item {{ request()->routeIs('budgets.*') ? 'active' : '' }}" href="{{ route('budgets.index') }}">
            <i class="material-icons-round">account_balance_wallet</i> Budgets
        </a>
        <a class="sb-item {{ request()->routeIs('Goals.Matter') || request()->routeIs('goals.*') ? 'active' : '' }}" href="{{ route('Goals.Matter') }}">
            <i class="material-icons-round">flag</i> Goals
        </a>
        <a class="sb-item {{ request()->routeIs('transfers.*') ? 'active' : '' }}" href="{{ route('transfers.index') }}">
            <i class="material-icons-round">compare_arrows</i> Transfers
        </a>
        <a class="sb-item {{ request()->routeIs('statements.*') ? 'active' : '' }}" href="{{ route('statements.import') }}">
            <i class="material-icons-round">upload_file</i> Import Statement
        </a>
        <a class="sb-item {{ request()->routeIs('cards.*') ? 'active' : '' }}" href="{{ route('cards.index') }}">
            <i class="material-icons-round">credit_card</i> Cards
        </a>

        {{-- Reports --}}
        <div class="sb-label">Reports</div>

        <a class="sb-item {{ request()->routeIs('Report.spending') ? 'active' : '' }}" href="{{ route('Report.spending') }}">
            <i class="material-icons-round">bar_chart</i> Income & Expenses
        </a>
        <a class="sb-item {{ request()->routeIs('reports.trends') ? 'active' : '' }}" href="{{ route('reports.trends') }}">
            <i class="material-icons-round">trending_up</i> Monthly Trends
        </a>
        <a class="sb-item {{ request()->routeIs('forecast') ? 'active' : '' }}" href="{{ route('forecast') }}">
            <i class="material-icons-round">waterfall_chart</i> Cash Budget
        </a>
        <a class="sb-item {{ request()->routeIs('Balancesheet') ? 'active' : '' }}" href="{{ route('Balancesheet') }}">
            <i class="material-icons-round">balance</i> Balance Sheet
        </a>

        {{-- Setup --}}
        <div class="sb-label">Setup</div>

        <a class="sb-item {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
            <i class="material-icons-round">category</i> Categories
        </a>
        <a class="sb-item {{ request()->routeIs('natures.*') ? 'active' : '' }}" href="{{ route('natures.index') }}">
            <i class="material-icons-round">label</i> Natures
        </a>
        <a class="sb-item {{ request()->routeIs('master.*') || request()->routeIs('Master') ? 'active' : '' }}" href="{{ route('master.index') }}">
            <i class="material-icons-round">tune</i> Master Records
        </a>

        @if(in_array(auth()->user()->role ?? '', ['Master', 'Admin', 'AdmiX']))
        {{-- Admin --}}
        <div class="sb-label">Admin</div>

        <a class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="material-icons-round">admin_panel_settings</i> Admin Dashboard
        </a>
        <a class="sb-item {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
            <i class="material-icons-round">group</i> Manage Users
        </a>
        @endif

        {{-- Account --}}
        <div class="sb-label">Account</div>

        <a class="sb-item {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
            <i class="material-icons-round">manage_accounts</i> Profile
        </a>

        <a class="sb-item sb-logout" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('sb-logout-form').submit();">
            <i class="material-icons-round">logout</i> Log Out
        </a>
        <form id="sb-logout-form" action="{{ route('logout') }}" method="POST" hidden>@csrf</form>

    </nav>
</aside>

{{-- ═══ PAGE SHELL ═══ --}}
<div class="page-shell">

    {{-- Top bar --}}
    <header class="topbar">
        <button class="tb-burger" id="tbBurger" aria-label="Open sidebar" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        <div class="tb-info">
            <div class="tb-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                @yield('breadcrumb')
            </div>
            <div class="tb-title">@yield('page-title', 'Dashboard')</div>
        </div>

        <div class="tb-actions">
            <a href="{{ route('transactions.create') }}" class="tb-btn" title="New Transaction">
                <i class="material-icons-round">add</i>
                <span class="tb-btn-text">New Transaction</span>
            </a>
            <a href="{{ route('profile.index') }}" class="tb-icon" title="Profile">
                <i class="material-icons-round">account_circle</i>
            </a>
        </div>
    </header>

    {{-- Flash messages --}}
    @if(session('success') || session('error') || session('status'))
    <div class="flash-wrap">
        @if(session('success'))
        <div class="flash-alert success">
            <i class="material-icons-round" style="font-size:1rem;flex-shrink:0;">check_circle</i>
            {{ session('success') }}
            <button class="flash-close" onclick="this.parentElement.remove()">✕</button>
        </div>
        @endif
        @if(session('error'))
        <div class="flash-alert danger">
            <i class="material-icons-round" style="font-size:1rem;flex-shrink:0;">error</i>
            {{ session('error') }}
            <button class="flash-close" onclick="this.parentElement.remove()">✕</button>
        </div>
        @endif
        @if(session('status'))
        <div class="flash-alert info">
            {{ session('status') }}
            <button class="flash-close" onclick="this.parentElement.remove()">✕</button>
        </div>
        @endif
    </div>
    @endif

    {{-- Content --}}
    <main class="page-content">
        @yield('content')
    </main>

    {{-- Desktop footer --}}
    <footer class="app-footer">
        <span>© {{ date('Y') }} Bright Finance. All rights reserved.</span>
        <span style="color:#cbd5e1;">v2.0</span>
    </footer>

</div>

{{-- ═══ MOBILE BOTTOM NAV ═══ --}}
<nav class="bottom-nav" aria-label="Mobile navigation">
    <ul class="bn-list">
        <li>
            <a class="bn-item {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="material-icons-round">dashboard</i>
                <span>Home</span>
            </a>
        </li>
        <li>
            <a class="bn-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                <i class="material-icons-round">swap_horiz</i>
                <span>Transactions</span>
            </a>
        </li>
        <li>
            <a class="bn-item {{ request()->routeIs('transactions.create') ? 'active' : '' }}" href="{{ route('transactions.create') }}"
               style="color:#1d4ed8;">
                <span style="width:40px;height:40px;background:#1d4ed8;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:2px;margin-top:-8px;box-shadow:0 4px 12px rgba(29,78,216,.4);">
                    <i class="material-icons-round" style="font-size:1.3rem;color:#fff;">add</i>
                </span>
                <span style="color:#1d4ed8;">Add</span>
            </a>
        </li>
        <li>
            <a class="bn-item {{ request()->routeIs('budgets.*') ? 'active' : '' }}" href="{{ route('budgets.index') }}">
                <i class="material-icons-round">account_balance_wallet</i>
                <span>Budgets</span>
            </a>
        </li>
        <li>
            <a class="bn-item bn-more" id="bnMore" href="javascript:;" onclick="openSidebar()">
                <i class="material-icons-round">menu</i>
                <span>More</span>
            </a>
        </li>
    </ul>
</nav>

{{-- Scripts --}}
<script src="/assets/js/core/popper.min.js"></script>
<script src="/assets/js/core/bootstrap.min.js"></script>
<script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script>
var sidebar  = document.getElementById('sidebar');
var backdrop = document.getElementById('sidebarBackdrop');
var tbBurger = document.getElementById('tbBurger');
var sbClose  = document.getElementById('sbClose');

function openSidebar() {
    sidebar.classList.add('open');
    backdrop.classList.add('show');
    document.body.style.overflow = 'hidden';
    tbBurger && tbBurger.setAttribute('aria-expanded', 'true');
}

function closeSidebar() {
    sidebar.classList.remove('open');
    backdrop.classList.remove('show');
    document.body.style.overflow = '';
    tbBurger && tbBurger.setAttribute('aria-expanded', 'false');
}

tbBurger && tbBurger.addEventListener('click', function () {
    sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
});

sbClose  && sbClose.addEventListener('click', closeSidebar);
backdrop && backdrop.addEventListener('click', closeSidebar);

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeSidebar();
});

// Close sidebar on nav link click (mobile)
sidebar.querySelectorAll('a.sb-item').forEach(function (a) {
    a.addEventListener('click', function () {
        if (window.innerWidth <= 768) closeSidebar();
    });
});

// Smooth scrollbar on desktop sidebar if win
var win = navigator.platform.indexOf('Win') > -1;
if (win && typeof Scrollbar !== 'undefined' && document.querySelector('.sb-nav')) {
    try { Scrollbar.init(document.querySelector('.sb-nav'), { damping: 0.5 }); } catch(e) {}
}
</script>

@yield('scripts')
</body>
</html>
