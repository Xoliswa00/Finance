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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet">
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="/assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <style>
        /* ── Brand tokens ─────────────────────────────────────────────── */
        :root {
            --bf-bg:        #f1f5f9;
            --bf-surface:   #ffffff;
            --bf-elevated:  #f8fafc;
            --bf-border:    #e2e8f0;
            --bf-border-md: #cbd5e1;
            --bf-muted:     #94a3b8;
            --bf-text:      #0f172a;
            --bf-text-dim:  #475569;
            --bf-accent:    #1d4ed8;
            --bf-accent-lt: #eff6ff;
            --bf-green:     #16a34a;
            --bf-red:       #dc2626;
            --bf-amber:     #d97706;
            --bf-radius:    12px;
            --sidebar-w:    256px;
            --topbar-h:     60px;
            /* Sidebar gradient */
            --sb-from:      #1e3a8a;
            --sb-to:        #1d4ed8;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bf-bg);
            color: var(--bf-text);
            margin: 0;
        }

        /* ── Scrollbar ────────────────────────────────────────────────── */
        * { scrollbar-width: thin; scrollbar-color: var(--bf-border) transparent; }
        *::-webkit-scrollbar { width: 4px; height: 4px; }
        *::-webkit-scrollbar-track { background: transparent; }
        *::-webkit-scrollbar-thumb { background: var(--bf-border-md); border-radius: 4px; }

        /* ── Sidebar ──────────────────────────────────────────────────── */
        #sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: linear-gradient(180deg, var(--sb-from) 0%, var(--sb-to) 100%);
            display: flex;
            flex-direction: column;
            z-index: 300;
            overflow: hidden;
            transition: transform .28s cubic-bezier(.4,0,.2,1), box-shadow .28s;
            box-shadow: 2px 0 16px rgba(30,58,138,.15);
        }

        .sb-header {
            padding: 18px 16px 12px;
            border-bottom: 1px solid rgba(255,255,255,.1);
            flex-shrink: 0;
        }
        .sb-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .sb-logo img { height: 2.1rem; flex-shrink: 0; }
        .sb-logo-name { font-size: .92rem; font-weight: 800; color: #fff; line-height: 1.1; }
        .sb-logo-tag  { font-size: .57rem; font-weight: 600; text-transform: uppercase; letter-spacing: .1em; color: rgba(255,255,255,.5); }

        .sb-close {
            display: none;
            position: absolute; top: 14px; right: 14px;
            width: 32px; height: 32px;
            border: none; background: rgba(255,255,255,.15);
            border-radius: 50%; cursor: pointer; color: #fff;
            align-items: center; justify-content: center;
            font-size: 1rem; line-height: 1;
            transition: background .15s;
        }
        .sb-close:hover { background: rgba(255,255,255,.25); }

        /* User card */
        .sb-user {
            margin: 12px 10px 8px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 12px;
            padding: 10px 12px;
            display: flex; align-items: center; gap: 10px;
            flex-shrink: 0;
        }
        .sb-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: rgba(255,255,255,.2);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .88rem; color: #fff;
            flex-shrink: 0;
        }
        .sb-uname { font-size: .82rem; font-weight: 600; color: #fff; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sb-urole { font-size: .65rem; color: rgba(255,255,255,.55); }

        .sb-hr { border: none; border-top: 1px solid rgba(255,255,255,.1); margin: 4px 10px; flex-shrink: 0; }

        .sb-nav { flex: 1; overflow-y: auto; overflow-x: hidden; padding: 4px 8px 80px;
            scrollbar-color: rgba(255,255,255,.15) transparent; }
        .sb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); }

        .sb-label {
            font-size: .6rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .1em;
            color: rgba(255,255,255,.4);
            padding: 14px 10px 4px;
        }

        .sb-item {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 12px;
            border-radius: 10px;
            margin-bottom: 2px;
            text-decoration: none;
            color: rgba(255,255,255,.7);
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
            background: #93c5fd;
        }
        .sb-item .material-icons-round { font-size: 1.05rem; flex-shrink: 0; width: 20px; text-align: center; }
        .sb-item.sb-logout { color: rgba(255,255,255,.5); }
        .sb-item.sb-logout:hover { background: rgba(239,68,68,.2); color: #fca5a5; }

        /* ── Backdrop ─────────────────────────────────────────────────── */
        #sidebarBackdrop {
            display: none;
            position: fixed; inset: 0;
            background: rgba(15,23,42,.5);
            z-index: 299;
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
        }
        #sidebarBackdrop.show { display: block; }

        /* ── Page shell ───────────────────────────────────────────────── */
        .page-shell {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex; flex-direction: column;
            transition: margin-left .28s;
        }

        /* ── Top bar ──────────────────────────────────────────────────── */
        .topbar {
            background: var(--bf-surface);
            border-bottom: 1px solid var(--bf-border);
            height: var(--topbar-h);
            display: flex; align-items: center;
            padding: 0 20px; gap: 12px;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 1px 4px rgba(0,0,0,.05);
        }

        .tb-burger {
            display: none;
            flex-direction: column; justify-content: center; align-items: center;
            width: 38px; height: 38px;
            border: 1px solid var(--bf-border); background: var(--bf-elevated);
            cursor: pointer; border-radius: 8px; gap: 5px; padding: 8px;
            flex-shrink: 0; transition: background .15s;
        }
        .tb-burger:hover { background: var(--bf-border); }
        .tb-burger span {
            display: block; width: 20px; height: 2px;
            background: var(--bf-text-dim); border-radius: 2px;
            transition: transform .25s, opacity .25s;
        }

        .tb-info { flex: 1; min-width: 0; }
        .tb-breadcrumb {
            display: flex; align-items: center; gap: 4px;
            font-size: .68rem; color: var(--bf-muted); margin-bottom: 1px;
        }
        .tb-breadcrumb a { color: var(--bf-muted); text-decoration: none; }
        .tb-breadcrumb a:hover { color: var(--bf-accent); }
        .tb-title { font-size: .95rem; font-weight: 700; color: var(--bf-text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .tb-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

        .tb-btn {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: .8rem; font-weight: 700;
            background: var(--bf-accent); color: #fff;
            border: none; border-radius: 8px;
            padding: 8px 14px; cursor: pointer; text-decoration: none;
            transition: background .15s, transform .15s;
            white-space: nowrap;
        }
        .tb-btn:hover { background: #1e40af; color: #fff; transform: translateY(-1px); }
        .tb-btn .material-icons-round { font-size: .95rem; }

        .tb-icon {
            width: 36px; height: 36px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: var(--bf-muted); text-decoration: none;
            border: 1px solid transparent;
            transition: background .15s, color .15s, border-color .15s;
        }
        .tb-icon:hover { background: var(--bf-elevated); color: var(--bf-text); border-color: var(--bf-border); }
        .tb-icon .material-icons-round { font-size: 1.15rem; }

        /* ── Notification panel ───────────────────────────────────────── */
        .tb-notif-wrap { position: relative; }
        .notif-badge {
            position: absolute; top: 2px; right: 2px;
            min-width: 16px; height: 16px; border-radius: 8px;
            background: var(--bf-red); color: #fff;
            font-size: .6rem; font-weight: 700; line-height: 16px;
            text-align: center; padding: 0 3px; pointer-events: none;
        }
        .notif-panel {
            position: absolute; top: calc(100% + 10px); right: 0;
            width: 340px; max-width: 92vw;
            background: var(--bf-surface);
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0,0,0,.14);
            border: 1px solid var(--bf-border);
            z-index: 500; overflow: hidden;
        }
        .notif-panel-head {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 16px; border-bottom: 1px solid var(--bf-border);
        }
        .notif-panel-head span { font-size: .88rem; font-weight: 700; color: var(--bf-text); }
        .notif-readall {
            font-size: .74rem; font-weight: 600; color: var(--bf-accent);
            background: none; border: none; cursor: pointer; padding: 4px 8px;
            border-radius: 6px; transition: background .15s;
        }
        .notif-readall:hover { background: var(--bf-accent-lt); }
        .notif-scroll { max-height: 320px; overflow-y: auto; }
        .notif-item {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 11px 16px; text-decoration: none;
            border-bottom: 1px solid var(--bf-elevated);
            transition: background .12s;
        }
        .notif-item:hover { background: var(--bf-elevated); }
        .notif-item.unread { background: #f0f7ff; }
        .notif-item.unread:hover { background: #dbeafe; }
        .notif-icon {
            width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
            background: var(--bf-accent-lt);
            display: flex; align-items: center; justify-content: center;
        }
        .notif-icon .material-icons-round { font-size: .95rem; color: var(--bf-accent); }
        .notif-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--bf-accent); flex-shrink: 0; margin-top: 5px; }
        .notif-title  { font-size: .8rem; font-weight: 600; color: var(--bf-text); line-height: 1.3; }
        .notif-msg    { font-size: .75rem; color: var(--bf-text-dim); line-height: 1.35; margin-top: 2px; }
        .notif-time   { font-size: .68rem; color: var(--bf-muted); margin-top: 3px; }
        .notif-empty  { padding: 28px 16px; text-align: center; font-size: .84rem; color: var(--bf-muted); }
        .notif-footer {
            display: block; text-align: center; padding: 10px;
            font-size: .78rem; font-weight: 600; color: var(--bf-accent);
            border-top: 1px solid var(--bf-border); text-decoration: none;
            transition: background .12s;
        }
        .notif-footer:hover { background: var(--bf-elevated); }

        /* ── Content ──────────────────────────────────────────────────── */
        .page-content { flex: 1; padding: 20px 24px; }

        /* ── Flash messages ───────────────────────────────────────────── */
        .flash-wrap { padding: 12px 24px 0; }
        .flash-alert {
            display: flex; align-items: center; gap: 8px;
            border-radius: 10px; padding: 10px 14px;
            font-size: .86rem; font-weight: 500;
            border: 1px solid transparent; position: relative; margin-bottom: 8px;
        }
        .flash-alert.success { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
        .flash-alert.danger  { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
        .flash-alert.info    { background: var(--bf-accent-lt); border-color: #bfdbfe; color: #1e40af; }
        .flash-close {
            position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
            background: none; border: none; font-size: 1rem; cursor: pointer;
            color: inherit; opacity: .6; padding: 0 4px;
        }
        .flash-close:hover { opacity: 1; }

        /* ── Card defaults ────────────────────────────────────────────── */
        .card, .bf-card {
            background: var(--bf-surface) !important;
            border: 1px solid var(--bf-border) !important;
            border-radius: var(--bf-radius) !important;
            box-shadow: 0 2px 12px rgba(0,0,0,.06) !important;
            color: var(--bf-text) !important;
        }
        .card-header {
            background: var(--bf-elevated) !important;
            border-bottom: 1px solid var(--bf-border) !important;
            padding: .9rem 1.25rem !important;
        }
        .card-header h6, .card-header .h6 {
            color: var(--bf-text) !important;
            font-size: .8rem; font-weight: 700; margin: 0;
        }

        /* Tables */
        .table { color: var(--bf-text) !important; }
        .table th {
            background: var(--bf-elevated) !important;
            color: var(--bf-text-dim) !important;
            font-size: .65rem !important; font-weight: 700 !important;
            text-transform: uppercase !important; letter-spacing: .08em !important;
            border-bottom: 1px solid var(--bf-border) !important;
            padding: .6rem 1rem !important;
        }
        .table td {
            border-bottom: 1px solid var(--bf-border) !important;
            padding: .65rem 1rem !important; vertical-align: middle !important;
            color: var(--bf-text) !important;
        }
        .table tbody tr:hover td { background: var(--bf-elevated) !important; }
        .table tbody tr:last-child td { border-bottom: none !important; }

        /* Badges */
        .badge-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; border-radius: 20px; font-size: .68rem; font-weight: 600; padding: .22rem .65rem; }
        .badge-danger  { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; border-radius: 20px; font-size: .68rem; font-weight: 600; padding: .22rem .65rem; }
        .badge-amber   { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; border-radius: 20px; font-size: .68rem; font-weight: 600; padding: .22rem .65rem; }
        .badge-blue    { background: var(--bf-accent-lt); color: #1e40af; border: 1px solid #bfdbfe; border-radius: 20px; font-size: .68rem; font-weight: 600; padding: .22rem .65rem; }

        /* Forms */
        .form-control, .form-select {
            background: var(--bf-surface) !important;
            border: 1.5px solid var(--bf-border) !important;
            border-radius: 8px !important;
            color: var(--bf-text) !important;
            font-family: 'Inter', sans-serif !important;
            font-size: .88rem !important;
            padding: .55rem .85rem !important;
            transition: border-color .15s, box-shadow .15s !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--bf-accent) !important;
            box-shadow: 0 0 0 3px rgba(29,78,216,.1) !important;
            outline: none !important;
        }
        .form-label { color: var(--bf-text-dim); font-size: .8rem; font-weight: 600; margin-bottom: .35rem; }

        /* Buttons */
        .btn-primary {
            background: var(--bf-accent) !important; color: #fff !important;
            border: none !important; border-radius: 8px !important;
            font-weight: 700 !important;
            transition: background .15s, transform .15s !important;
        }
        .btn-primary:hover { background: #1e40af !important; color: #fff !important; transform: translateY(-1px); }
        .btn-outline-secondary {
            border: 1.5px solid var(--bf-border-md) !important;
            color: var(--bf-text-dim) !important;
            background: transparent !important;
            border-radius: 8px !important;
        }
        .btn-outline-secondary:hover { background: var(--bf-elevated) !important; color: var(--bf-text) !important; }
        .btn-danger {
            background: #fee2e2 !important; color: #991b1b !important;
            border: 1px solid #fecaca !important; border-radius: 8px !important;
        }
        .btn-danger:hover { background: #fecaca !important; }

        /* Mono helper */
        .mono { font-family: 'Fira Code', monospace; }

        /* ── App footer ───────────────────────────────────────────────── */
        .app-footer {
            border-top: 1px solid var(--bf-border);
            padding: 12px 24px;
            display: flex; justify-content: space-between; align-items: center;
            font-size: .72rem; color: var(--bf-muted);
            background: var(--bf-surface);
        }

        /* ── Mobile bottom nav ────────────────────────────────────────── */
        .bottom-nav {
            display: none;
            position: fixed; bottom: 0; left: 0; right: 0;
            background: var(--bf-surface);
            border-top: 1px solid var(--bf-border);
            z-index: 200;
            box-shadow: 0 -4px 12px rgba(0,0,0,.08);
        }
        .bn-list { display: flex; list-style: none; margin: 0; padding: 0; }
        .bn-item {
            flex: 1;
            display: flex; flex-direction: column; align-items: center;
            padding: 8px 4px 10px;
            text-decoration: none;
            color: var(--bf-muted);
            font-size: .58rem; font-weight: 600; letter-spacing: .02em;
            gap: 3px; transition: color .15s; position: relative;
        }
        .bn-item:hover, .bn-item.active { color: var(--bf-accent); }
        .bn-item.active::before {
            content: '';
            position: absolute; top: 0; left: 20%; right: 20%;
            height: 2.5px; border-radius: 0 0 3px 3px;
            background: var(--bf-accent);
        }
        .bn-item .material-icons-round { font-size: 1.25rem; }
        .bn-fab {
            width: 44px; height: 44px;
            background: var(--bf-accent); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 2px; margin-top: -10px;
            box-shadow: 0 4px 12px rgba(29,78,216,.4);
            transition: transform .15s, box-shadow .15s;
        }
        .bn-item:hover .bn-fab { transform: scale(1.05); }
        .bn-fab .material-icons-round { font-size: 1.25rem; color: #fff; }

        /* ── Impersonation banner ─────────────────────────────────────── */
        .impersonate-bar {
            background: #faf5ff; border-bottom: 1px solid #e9d5ff;
            color: #7c3aed; text-align: center; padding: 7px 16px;
            font-size: .82rem; font-weight: 600; position: sticky; top: 0; z-index: 9999;
        }

        /* ── Responsive ───────────────────────────────────────────────── */
        @media (max-width: 1024px) { :root { --sidebar-w: 240px; } }
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
                box-shadow: none;
                width: min(var(--sidebar-w), 85vw);
            }
            #sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 32px rgba(30,58,138,.3);
            }
            .sb-close { display: flex; }
            .page-shell { margin-left: 0; }
            .tb-burger { display: flex; }
            .tb-title { font-size: .88rem; }
            .tb-breadcrumb { display: none; }
            .tb-btn .tb-btn-text { display: none; }
            .tb-btn { padding: 8px; border-radius: 8px; }
            .bottom-nav { display: block; }
            .page-content { padding-bottom: 80px; }
            .app-footer { display: none; }
        }
    </style>

    @yield('head')
</head>

<body>

<div id="sidebarBackdrop"></div>

{{-- ══ SIDEBAR ══════════════════════════════════════════════════════════ --}}
<aside id="sidebar" role="navigation" aria-label="Main navigation">
    <div class="sb-header">
        <a class="sb-logo" href="{{ route('home') }}">
            <img src="/assets/images/Bright v4.png" alt="Bright Finance">
            <div>
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
            <div class="sb-urole">{{ ucfirst(strtolower(auth()->user()->role ?? 'Member')) }}</div>
        </div>
    </div>

    <hr class="sb-hr">

    <nav class="sb-nav">
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

        @if(auth()->check() && auth()->user()->isAdmin())
        <div class="sb-label">Admin</div>
        <a class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="material-icons-round">admin_panel_settings</i> Admin Portal
        </a>
        <a class="sb-item {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
            <i class="material-icons-round">group</i> Manage Users
        </a>
        <a class="sb-item {{ request()->routeIs('admin.sites') ? 'active' : '' }}" href="{{ route('admin.sites') }}">
            <i class="material-icons-round">monitor_heart</i> Site Monitor
        </a>
        <a class="sb-item {{ request()->routeIs('admin.activity-log') ? 'active' : '' }}" href="{{ route('admin.activity-log') }}">
            <i class="material-icons-round">history</i> Activity Log
        </a>
        <a class="sb-item {{ request()->routeIs('admin.health') ? 'active' : '' }}" href="{{ route('admin.health') }}">
            <i class="material-icons-round">favorite</i> Platform Health
        </a>
        @endif

        <div class="sb-label">Account</div>
        <a class="sb-item {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
            <i class="material-icons-round">manage_accounts</i> Profile
        </a>
        <a class="sb-item {{ request()->routeIs('About') ? 'active' : '' }}" href="{{ route('About') }}">
            <i class="material-icons-round">info</i> About
        </a>
        <a class="sb-item sb-logout" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('sb-logout-form').submit();">
            <i class="material-icons-round">logout</i> Log Out
        </a>
        <form id="sb-logout-form" action="{{ route('logout') }}" method="POST" hidden>@csrf</form>
    </nav>
</aside>

{{-- ══ PAGE SHELL ════════════════════════════════════════════════════════ --}}
<div class="page-shell">

    @if(session('impersonating_id'))
    <div class="impersonate-bar">
        <i class="material-icons-round" style="font-size:.95rem;vertical-align:middle;margin-right:4px;">person</i>
        Impersonating <strong>{{ auth()->user()->name }}</strong>.
        <form action="{{ route('admin.stop-impersonating') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" style="background:none;border:none;color:#7c3aed;text-decoration:underline;cursor:pointer;font-size:.82rem;font-weight:600;">Stop</button>
        </form>
    </div>
    @endif

    @if(!empty($activeAnnouncement))
    <div style="background:#fef3c7;border-bottom:1px solid #fde68a;color:#92400e;text-align:center;padding:8px 16px;font-size:.82rem;font-weight:500;">
        <i class="material-icons-round" style="font-size:.95rem;vertical-align:middle;margin-right:4px;">campaign</i>
        {{ $activeAnnouncement->message }}
    </div>
    @endif

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

            @php $unreadCount = auth()->user()->unreadNotifications()->count(); @endphp
            <div class="tb-notif-wrap">
                <button class="tb-icon" id="notifBtn" title="Notifications" type="button"
                        style="background:none;border:none;cursor:pointer;position:relative;">
                    <i class="material-icons-round">notifications</i>
                    @if($unreadCount > 0)
                    <span class="notif-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </button>
                <div class="notif-panel" id="notifPanel" style="display:none;">
                    <div class="notif-panel-head">
                        <span>Notifications</span>
                        @if($unreadCount > 0)
                        <form method="POST" action="{{ route('notifications.readAll') }}">
                            @csrf
                            <button type="submit" class="notif-readall">Mark all read</button>
                        </form>
                        @endif
                    </div>
                    <div class="notif-scroll">
                        @forelse(auth()->user()->notifications()->take(8)->get() as $n)
                        @php $d = $n->data; @endphp
                        <a href="{{ route('notifications.read', $n->id) }}"
                           class="notif-item {{ is_null($n->read_at) ? 'unread' : '' }}">
                            <div class="notif-icon">
                                <i class="material-icons-round">{{ $d['icon'] ?? 'notifications' }}</i>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div class="notif-title">{{ $d['title'] ?? 'Notification' }}</div>
                                <div class="notif-msg">{{ $d['message'] ?? '' }}</div>
                                <div class="notif-time">{{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}</div>
                            </div>
                            @if(is_null($n->read_at))<div class="notif-dot"></div>@endif
                        </a>
                        @empty
                        <div class="notif-empty">No notifications yet</div>
                        @endforelse
                    </div>
                    <a href="{{ route('notifications.index') }}" class="notif-footer">View all notifications →</a>
                </div>
            </div>

            <a href="{{ route('profile.index') }}" class="tb-icon" title="Profile">
                <i class="material-icons-round">account_circle</i>
            </a>
        </div>
    </header>

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
        <div class="flash-alert info">{{ session('status') }}
            <button class="flash-close" onclick="this.parentElement.remove()">✕</button>
        </div>
        @endif
    </div>
    @endif

    <main class="page-content">@yield('content')</main>

    <footer class="app-footer">
        <span>© {{ date('Y') }} Bright Finance. All rights reserved.</span>
        <span class="mono" style="font-size:.68rem;">v2.0</span>
    </footer>
</div>

{{-- ══ MOBILE BOTTOM NAV ════════════════════════════════════════════════ --}}
<nav class="bottom-nav" aria-label="Mobile navigation">
    <ul class="bn-list">
        <li>
            <a class="bn-item {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="material-icons-round">dashboard</i><span>Home</span>
            </a>
        </li>
        <li>
            <a class="bn-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                <i class="material-icons-round">swap_horiz</i><span>Transactions</span>
            </a>
        </li>
        <li>
            <a class="bn-item" href="{{ route('transactions.create') }}">
                <div class="bn-fab"><i class="material-icons-round">add</i></div>
                <span style="color:var(--bf-accent)">Add</span>
            </a>
        </li>
        <li>
            <a class="bn-item {{ request()->routeIs('budgets.*') ? 'active' : '' }}" href="{{ route('budgets.index') }}">
                <i class="material-icons-round">account_balance_wallet</i><span>Budgets</span>
            </a>
        </li>
        <li>
            <a class="bn-item" id="bnMore" href="javascript:;" onclick="openSidebar()">
                <i class="material-icons-round">menu</i><span>More</span>
            </a>
        </li>
    </ul>
</nav>

<script src="/assets/js/core/popper.min.js"></script>
<script src="/assets/js/core/bootstrap.min.js"></script>
<script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script>
var sidebar  = document.getElementById('sidebar');
var backdrop = document.getElementById('sidebarBackdrop');
var tbBurger = document.getElementById('tbBurger');
var sbClose  = document.getElementById('sbClose');
function openSidebar() {
    sidebar.classList.add('open'); backdrop.classList.add('show');
    document.body.style.overflow = 'hidden';
    if (tbBurger) tbBurger.setAttribute('aria-expanded','true');
}
function closeSidebar() {
    sidebar.classList.remove('open'); backdrop.classList.remove('show');
    document.body.style.overflow = '';
    if (tbBurger) tbBurger.setAttribute('aria-expanded','false');
}
if (tbBurger) tbBurger.addEventListener('click', function(){ sidebar.classList.contains('open') ? closeSidebar() : openSidebar(); });
if (sbClose)  sbClose.addEventListener('click', closeSidebar);
if (backdrop) backdrop.addEventListener('click', closeSidebar);
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeSidebar(); });
sidebar.querySelectorAll('a.sb-item').forEach(function(a){
    a.addEventListener('click', function(){ if(window.innerWidth<=768) closeSidebar(); });
});
var notifBtn = document.getElementById('notifBtn');
var notifPanel = document.getElementById('notifPanel');
if (notifBtn && notifPanel) {
    notifBtn.addEventListener('click', function(e){
        e.stopPropagation();
        notifPanel.style.display = notifPanel.style.display !== 'none' ? 'none' : 'block';
    });
    document.addEventListener('click', function(e){
        if (!notifBtn.contains(e.target) && !notifPanel.contains(e.target)) notifPanel.style.display = 'none';
    });
}
</script>

@yield('scripts')
</body>
</html>
