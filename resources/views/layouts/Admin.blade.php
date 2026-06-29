<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BF Admin — @yield('page-title', 'Admin Portal')</title>

  <link rel="icon" type="image/png" href="/assets/images/bright.png">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Fira+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link id="pagestyle" href="/assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    :root {
      --bf-bg:       #020617;
      --bf-surface:  #0f172a;
      --bf-elevated: #1e293b;
      --bf-border:   #334155;
      --bf-muted:    #64748b;
      --bf-text:     #f1f5f9;
      --bf-text-dim: #94a3b8;
      --bf-accent:   #22c55e;
      --bf-amber:    #f59e0b;
      --bf-red:      #ef4444;
      --bf-blue:     #3b82f6;
      --bf-radius:   10px;
      --bf-glow:     0 0 0 1px rgba(34,197,94,.15), 0 4px 20px rgba(0,0,0,.4);
    }

    * { box-sizing: border-box; }

    body {
      font-family: 'Fira Sans', sans-serif;
      background: var(--bf-bg) !important;
      color: var(--bf-text);
    }

    /* ── Sidebar ─────────────────────────────────────────────────────── */
    #sidenav-main {
      background: var(--bf-surface) !important;
      border-right: 1px solid var(--bf-border) !important;
      border-radius: 0 !important;
      margin: 0 !important;
      top: 0 !important;
      bottom: 0 !important;
      height: 100vh !important;
    }

    .sidenav-header {
      padding: 1.25rem 1rem;
      border-bottom: 1px solid var(--bf-border);
    }

    .sidenav-header .navbar-brand span {
      font-family: 'Fira Code', monospace;
      font-size: .8rem;
      font-weight: 600;
      color: var(--bf-accent);
      letter-spacing: .04em;
    }

    .nav-section-label {
      font-size: .6rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .12em;
      color: var(--bf-muted);
      padding: 1.4rem 1rem .3rem;
    }

    .sidenav .nav-link {
      color: var(--bf-text-dim) !important;
      border-radius: 8px !important;
      margin: 1px 8px !important;
      padding: .55rem .85rem !important;
      font-size: .82rem;
      font-weight: 500;
      transition: all 150ms ease;
      display: flex;
      align-items: center;
      gap: .5rem;
    }

    .sidenav .nav-link:hover {
      background: var(--bf-elevated) !important;
      color: var(--bf-text) !important;
    }

    .sidenav .nav-link.active {
      background: rgba(34,197,94,.12) !important;
      color: var(--bf-accent) !important;
      box-shadow: inset 3px 0 0 var(--bf-accent);
    }

    .sidenav .nav-link .material-icons {
      font-size: 1.1rem !important;
      opacity: 1 !important;
    }

    .sidenav .nav-link.active .material-icons { color: var(--bf-accent); }

    /* Status dot for Sites nav item */
    .nav-status-dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--bf-accent);
      box-shadow: 0 0 6px var(--bf-accent);
      margin-left: auto;
      flex-shrink: 0;
    }

    /* ── Top bar ─────────────────────────────────────────────────────── */
    #navbarBlur {
      background: var(--bf-surface) !important;
      border-bottom: 1px solid var(--bf-border) !important;
      box-shadow: none !important;
      border-radius: 0 !important;
      margin: 0 !important;
      padding: .65rem 1.5rem !important;
    }

    /* ── Main content ────────────────────────────────────────────────── */
    .main-content {
      background: var(--bf-bg) !important;
      border-radius: 0 !important;
    }

    /* ── Cards ───────────────────────────────────────────────────────── */
    .card {
      background: var(--bf-surface) !important;
      border: 1px solid var(--bf-border) !important;
      border-radius: var(--bf-radius) !important;
      box-shadow: 0 2px 12px rgba(0,0,0,.35) !important;
      color: var(--bf-text) !important;
    }

    .card-header {
      background: transparent !important;
      border-bottom: 1px solid var(--bf-border) !important;
      padding: 1rem 1.25rem .75rem !important;
    }

    .card-header h6, .card-header .h6 {
      color: var(--bf-text) !important;
      font-family: 'Fira Code', monospace;
      font-size: .78rem;
      font-weight: 600;
      letter-spacing: .04em;
      text-transform: uppercase;
      margin: 0;
    }

    .card-header p { color: var(--bf-text-dim) !important; }

    /* Stat cards */
    .stat-card {
      background: var(--bf-surface);
      border: 1px solid var(--bf-border);
      border-radius: var(--bf-radius);
      padding: 1.25rem;
      display: flex;
      flex-direction: column;
      gap: .3rem;
    }

    .stat-card .stat-label {
      font-size: .7rem;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: var(--bf-text-dim);
      font-weight: 600;
    }

    .stat-card .stat-value {
      font-family: 'Fira Code', monospace;
      font-size: 1.9rem;
      font-weight: 600;
      color: var(--bf-text);
      line-height: 1;
    }

    .stat-card .stat-footer {
      font-size: .72rem;
      color: var(--bf-text-dim);
      margin-top: .15rem;
    }

    .stat-card .stat-icon {
      width: 38px; height: 38px;
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: .5rem;
    }

    /* ── Tables ──────────────────────────────────────────────────────── */
    .table {
      color: var(--bf-text) !important;
    }

    .table th {
      background: var(--bf-elevated) !important;
      color: var(--bf-text-dim) !important;
      font-size: .65rem !important;
      font-weight: 700 !important;
      text-transform: uppercase !important;
      letter-spacing: .08em !important;
      border-bottom: 1px solid var(--bf-border) !important;
      padding: .6rem 1rem !important;
    }

    .table td {
      border-bottom: 1px solid rgba(51,65,85,.5) !important;
      padding: .65rem 1rem !important;
      vertical-align: middle !important;
    }

    .table tbody tr:hover td { background: rgba(30,41,59,.5) !important; }
    .table tbody tr:last-child td { border-bottom: none !important; }

    /* ── Badges ──────────────────────────────────────────────────────── */
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: .3rem;
      padding: .22rem .6rem;
      border-radius: 20px;
      font-size: .68rem;
      font-weight: 600;
      letter-spacing: .03em;
    }

    .status-badge::before {
      content: '';
      width: 6px; height: 6px;
      border-radius: 50%;
      flex-shrink: 0;
    }

    .status-badge.online  { background: rgba(34,197,94,.12); color: #4ade80; }
    .status-badge.online::before { background: #22c55e; box-shadow: 0 0 5px #22c55e; }

    .status-badge.degraded { background: rgba(245,158,11,.12); color: #fbbf24; }
    .status-badge.degraded::before { background: #f59e0b; }

    .status-badge.offline { background: rgba(239,68,68,.12); color: #f87171; }
    .status-badge.offline::before { background: #ef4444; }

    /* ── Impersonation / Announce bars ───────────────────────────────── */
    .impersonation-bar {
      background: #4c1d95;
      color: #fff;
      text-align: center;
      padding: 7px 16px;
      font-size: .8rem;
      font-weight: 600;
      position: sticky;
      top: 0;
      z-index: 9999;
      border-bottom: 1px solid rgba(167,139,250,.3);
    }

    .impersonation-bar a { color: #c4b5fd; text-decoration: underline; margin-left: 10px; }
    .announce-bar { text-align: center; padding: 8px 16px; font-size: .82rem; font-weight: 500; }

    /* ── Alerts ──────────────────────────────────────────────────────── */
    .alert-success { background: rgba(34,197,94,.1) !important; border-color: rgba(34,197,94,.25) !important; color: #4ade80 !important; }
    .alert-danger  { background: rgba(239,68,68,.1) !important; border-color: rgba(239,68,68,.25) !important; color: #f87171 !important; }

    /* ── Form controls ───────────────────────────────────────────────── */
    .form-control, .form-select {
      background: var(--bf-elevated) !important;
      border: 1px solid var(--bf-border) !important;
      color: var(--bf-text) !important;
      border-radius: 7px !important;
      font-size: .82rem !important;
    }

    .form-control:focus, .form-select:focus {
      border-color: var(--bf-accent) !important;
      box-shadow: 0 0 0 3px rgba(34,197,94,.15) !important;
    }

    .form-label { color: var(--bf-text-dim) !important; font-size: .78rem !important; font-weight: 500 !important; }

    /* ── Buttons ─────────────────────────────────────────────────────── */
    .btn-accent {
      background: var(--bf-accent);
      color: #0a1a0a;
      border: none;
      font-weight: 600;
      font-size: .8rem;
      border-radius: 7px;
      padding: .45rem .9rem;
      transition: all 150ms ease;
    }

    .btn-accent:hover { background: #16a34a; color: #fff; }

    .btn-ghost {
      background: transparent;
      border: 1px solid var(--bf-border);
      color: var(--bf-text-dim);
      font-size: .78rem;
      border-radius: 7px;
      padding: .4rem .8rem;
      transition: all 150ms ease;
    }

    .btn-ghost:hover { background: var(--bf-elevated); color: var(--bf-text); border-color: var(--bf-accent); }

    /* ── Progress bars ───────────────────────────────────────────────── */
    .progress {
      background: var(--bf-elevated) !important;
      border-radius: 20px !important;
      height: 5px !important;
    }

    /* ── Charts ──────────────────────────────────────────────────────── */
    .chart-wrapper { position: relative; }

    /* ── Scrollbar ───────────────────────────────────────────────────── */
    ::-webkit-scrollbar { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track { background: var(--bf-surface); }
    ::-webkit-scrollbar-thumb { background: var(--bf-border); border-radius: 3px; }

    /* ── Pagination ──────────────────────────────────────────────────── */
    .pagination .page-link {
      background: var(--bf-elevated) !important;
      border-color: var(--bf-border) !important;
      color: var(--bf-text-dim) !important;
      font-size: .78rem;
    }

    .pagination .page-item.active .page-link {
      background: var(--bf-accent) !important;
      border-color: var(--bf-accent) !important;
      color: #0a1a0a !important;
      font-weight: 700;
    }

    /* ── Modals ──────────────────────────────────────────────────────── */
    .modal-content {
      background: var(--bf-surface) !important;
      border: 1px solid var(--bf-border) !important;
      border-radius: var(--bf-radius) !important;
    }

    .modal-header { border-bottom: 1px solid var(--bf-border) !important; }
    .modal-footer { border-top: 1px solid var(--bf-border) !important; }
    .modal-title { color: var(--bf-text) !important; font-family: 'Fira Code', monospace; font-size: .9rem; }
    .btn-close { filter: invert(1); }

    /* ── Code / mono spans ───────────────────────────────────────────── */
    .mono { font-family: 'Fira Code', monospace; }

    /* ── Topbar user chip ────────────────────────────────────────────── */
    .user-chip {
      display: flex;
      align-items: center;
      gap: .5rem;
      background: var(--bf-elevated);
      border: 1px solid var(--bf-border);
      border-radius: 20px;
      padding: .3rem .75rem .3rem .4rem;
      font-size: .78rem;
      color: var(--bf-text-dim);
    }

    .user-chip .avatar {
      width: 26px; height: 26px;
      border-radius: 50%;
      background: var(--bf-accent);
      color: #0a1a0a;
      font-size: .7rem;
      font-weight: 700;
      display: flex; align-items: center; justify-content: center;
    }

    .user-chip .role-tag {
      background: rgba(34,197,94,.12);
      color: var(--bf-accent);
      font-size: .6rem;
      font-weight: 700;
      padding: .1rem .35rem;
      border-radius: 10px;
      letter-spacing: .04em;
    }
  </style>
  @yield('head')
</head>

<body class="g-sidenav-show">

{{-- Impersonation banner --}}
@if(session('impersonating_id'))
<div class="impersonation-bar">
  <i class="fas fa-user-secret me-1"></i>
  Impersonating <strong>{{ auth()->user()->name }}</strong>.
  <form action="{{ route('admin.stop-impersonating') }}" method="POST" style="display:inline">
    @csrf
    <button type="submit" style="background:none;border:none;color:#c4b5fd;text-decoration:underline;cursor:pointer;font-size:.8rem;font-weight:600;">
      Stop Impersonating
    </button>
  </form>
</div>
@endif

{{-- Announcement banner --}}
@if(!empty($activeAnnouncement))
<div class="announce-bar alert-{{ $activeAnnouncement->type }} mb-0">
  <i class="fas fa-bullhorn me-2"></i>{{ $activeAnnouncement->message }}
</div>
@endif

{{-- ── Sidebar ─────────────────────────────────────────────────────── --}}
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start" id="sidenav-main">

  <div class="sidenav-header">
    <a class="navbar-brand m-0 d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
      <img src="/assets/images/Bright v4.png" style="height:28px;" alt="logo">
      <span>BF : Admin</span>
    </a>
  </div>

  <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">

      <div class="nav-section-label">Core</div>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           href="{{ route('admin.dashboard') }}">
          <span class="material-icons">dashboard</span>
          <span>Dashboard</span>
        </a>
      </li>

      <div class="nav-section-label">Users</div>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}"
           href="{{ route('admin.users') }}">
          <span class="material-icons">group</span>
          <span>Manage Users</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.activity-log') ? 'active' : '' }}"
           href="{{ route('admin.activity-log') }}">
          <span class="material-icons">history</span>
          <span>Activity Log</span>
        </a>
      </li>

      <div class="nav-section-label">Platform</div>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.sites') ? 'active' : '' }}"
           href="{{ route('admin.sites') }}">
          <span class="material-icons">monitor_heart</span>
          <span>Site Monitor</span>
          <span class="nav-status-dot"></span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.health') ? 'active' : '' }}"
           href="{{ route('admin.health') }}">
          <span class="material-icons">favorite</span>
          <span>Platform Health</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}"
           href="{{ route('admin.announcements.index') }}">
          <span class="material-icons">campaign</span>
          <span>Announcements</span>
        </a>
      </li>

      <div class="nav-section-label">Account</div>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
          <span class="material-icons">swap_horiz</span>
          <span>Back to App</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();"
           style="color: var(--bf-red) !important;">
          <span class="material-icons">logout</span>
          <span>Sign Out</span>
        </a>
        <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
      </li>

    </ul>
  </div>
</aside>

{{-- ── Main content ─────────────────────────────────────────────────── --}}
<main class="main-content position-relative max-height-vh-100 h-100">

  {{-- Top bar --}}
  <nav class="navbar navbar-main navbar-expand-lg px-0 shadow-none" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1">

      {{-- Mobile hamburger --}}
      <div class="d-xl-none">
        <a href="javascript:;" id="iconNavbarSidenav">
          <div class="sidenav-toggler-inner">
            <i class="sidenav-toggler-line" style="background:var(--bf-text-dim)"></i>
            <i class="sidenav-toggler-line" style="background:var(--bf-text-dim)"></i>
            <i class="sidenav-toggler-line" style="background:var(--bf-text-dim)"></i>
          </div>
        </a>
      </div>

      {{-- Page title breadcrumb --}}
      <div class="d-none d-xl-flex align-items-center gap-2 text-sm" style="color:var(--bf-text-dim)">
        <span class="material-icons" style="font-size:1rem;">admin_panel_settings</span>
        <span>Admin</span>
        <span style="opacity:.4">/</span>
        <span style="color:var(--bf-text)">@yield('page-title', 'Portal')</span>
      </div>

      <div class="ms-auto d-flex align-items-center gap-3">
        {{-- Current time --}}
        <span class="d-none d-lg-block mono text-xs" id="adminClock" style="color:var(--bf-muted)"></span>

        {{-- User chip --}}
        <div class="user-chip">
          <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
          <span>{{ auth()->user()->name }}</span>
          <span class="role-tag">{{ auth()->user()->Role }}</span>
        </div>
      </div>
    </div>
  </nav>

  {{-- Flash messages --}}
  <div class="container-fluid px-4 pt-3">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        @foreach($errors->all() as $err) {{ $err }}<br> @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
  </div>

  <div class="container-fluid py-3 px-4">
    @yield('content')
  </div>
</main>

<script src="/assets/js/core/popper.min.js"></script>
<script src="/assets/js/core/bootstrap.min.js"></script>
<script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="/assets/js/material-dashboard.min.js?v=3.1.0"></script>

<script>
  // Live clock
  (function tick() {
    const el = document.getElementById('adminClock');
    if (el) el.textContent = new Date().toLocaleTimeString('en-ZA', { hour12: false });
    setTimeout(tick, 1000);
  })();
</script>

@yield('scripts')
</body>
</html>
