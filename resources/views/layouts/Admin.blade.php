<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BF Admin — @yield('page-title', 'Admin Portal')</title>

  <link rel="icon" type="image/png" href="/assets/images/bright.png">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link id="pagestyle" href="/assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
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
      --sb-from:      #1e3a8a;
      --sb-to:        #1d4ed8;
    }

    * { box-sizing: border-box; }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bf-bg) !important;
      color: var(--bf-text);
    }

    /* ── Sidebar ─────────────────────────────────────────────────────── */
    #sidenav-main {
      background: linear-gradient(180deg, var(--sb-from) 0%, var(--sb-to) 100%) !important;
      border-right: none !important;
      border-radius: 0 !important;
      margin: 0 !important;
      top: 0 !important; bottom: 0 !important;
      height: 100vh !important;
      box-shadow: 2px 0 16px rgba(30,58,138,.15) !important;
    }

    .sidenav-header {
      padding: 1.25rem 1rem;
      border-bottom: 1px solid rgba(255,255,255,.1);
    }

    .sidenav-header .navbar-brand span {
      font-family: 'Inter', sans-serif;
      font-size: .88rem;
      font-weight: 800;
      color: #fff;
      letter-spacing: .01em;
    }

    .nav-section-label {
      font-size: .6rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .12em;
      color: rgba(255,255,255,.4);
      padding: 1.4rem 1rem .3rem;
    }

    .sidenav .nav-link {
      color: rgba(255,255,255,.7) !important;
      border-radius: 8px !important;
      margin: 1px 8px !important;
      padding: .55rem .85rem !important;
      font-size: .83rem;
      font-weight: 500;
      transition: all 150ms ease;
      display: flex;
      align-items: center;
      gap: .5rem;
    }

    .sidenav .nav-link:hover {
      background: rgba(255,255,255,.12) !important;
      color: #fff !important;
    }

    .sidenav .nav-link.active {
      background: rgba(255,255,255,.18) !important;
      color: #fff !important;
      font-weight: 600;
      box-shadow: inset 3px 0 0 #93c5fd;
    }

    .sidenav .nav-link .material-icons {
      font-size: 1.1rem !important;
      opacity: 1 !important;
    }

    .nav-status-dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: #4ade80;
      box-shadow: 0 0 6px #4ade80;
      margin-left: auto;
      flex-shrink: 0;
    }

    /* ── Top bar ─────────────────────────────────────────────────────── */
    #navbarBlur {
      background: var(--bf-surface) !important;
      border-bottom: 1px solid var(--bf-border) !important;
      box-shadow: 0 1px 4px rgba(0,0,0,.05) !important;
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
      box-shadow: 0 2px 10px rgba(0,0,0,.06) !important;
      color: var(--bf-text) !important;
    }

    .card-header {
      background: var(--bf-elevated) !important;
      border-bottom: 1px solid var(--bf-border) !important;
      padding: .9rem 1.25rem !important;
    }

    .card-header h6, .card-header .h6 {
      color: var(--bf-text) !important;
      font-size: .8rem;
      font-weight: 700;
      margin: 0;
    }

    .card-header p { color: var(--bf-text-dim) !important; }

    /* Stat cards */
    .stat-card {
      background: var(--bf-surface);
      border: 1px solid var(--bf-border);
      border-radius: var(--bf-radius);
      padding: 1.25rem;
      display: flex; flex-direction: column; gap: .3rem;
      box-shadow: 0 2px 10px rgba(0,0,0,.05);
    }
    .stat-card .stat-label {
      font-size: .68rem; text-transform: uppercase;
      letter-spacing: .08em; color: var(--bf-text-dim); font-weight: 700;
    }
    .stat-card .stat-value {
      font-family: 'Fira Code', monospace;
      font-size: 1.9rem; font-weight: 700;
      color: var(--bf-text); line-height: 1;
    }
    .stat-card .stat-footer { font-size: .72rem; color: var(--bf-text-dim); margin-top: .15rem; }
    .stat-card .stat-icon {
      width: 38px; height: 38px; border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: .5rem;
    }

    /* ── Tables ──────────────────────────────────────────────────────── */
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

    /* ── Status badges ───────────────────────────────────────────────── */
    .status-badge {
      display: inline-flex; align-items: center; gap: .3rem;
      padding: .22rem .6rem; border-radius: 20px;
      font-size: .68rem; font-weight: 600; letter-spacing: .03em;
    }
    .status-badge::before {
      content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0;
    }
    .status-badge.online  { background: #dcfce7; color: #166534; }
    .status-badge.online::before { background: #16a34a; }
    .status-badge.degraded { background: #fef3c7; color: #92400e; }
    .status-badge.degraded::before { background: #d97706; }
    .status-badge.offline { background: #fee2e2; color: #991b1b; }
    .status-badge.offline::before { background: #dc2626; }

    /* ── Impersonation / Announce bars ───────────────────────────────── */
    .impersonation-bar {
      background: #faf5ff; border-bottom: 1px solid #e9d5ff;
      color: #7c3aed; text-align: center; padding: 7px 16px;
      font-size: .8rem; font-weight: 600; position: sticky; top: 0; z-index: 9999;
    }
    .impersonation-bar a { color: #7c3aed; text-decoration: underline; margin-left: 10px; }
    .announce-bar { text-align: center; padding: 8px 16px; font-size: .82rem; font-weight: 500;
      background: #fef3c7; border-bottom: 1px solid #fde68a; color: #92400e; }

    /* ── Alerts ──────────────────────────────────────────────────────── */
    .alert-success { background: #f0fdf4 !important; border-color: #bbf7d0 !important; color: #166534 !important; }
    .alert-danger  { background: #fef2f2 !important; border-color: #fecaca !important; color: #991b1b !important; }

    /* ── Form controls ───────────────────────────────────────────────── */
    .form-control, .form-select {
      background: var(--bf-surface) !important;
      border: 1.5px solid var(--bf-border) !important;
      color: var(--bf-text) !important;
      border-radius: 8px !important;
      font-size: .85rem !important;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--bf-accent) !important;
      box-shadow: 0 0 0 3px rgba(29,78,216,.1) !important;
    }
    .form-label { color: var(--bf-text-dim) !important; font-size: .78rem !important; font-weight: 600 !important; }

    /* ── Buttons ─────────────────────────────────────────────────────── */
    .btn-accent {
      background: var(--bf-accent); color: #fff;
      border: none; font-weight: 700; font-size: .82rem;
      border-radius: 8px; padding: .45rem .9rem;
      transition: background .15s, transform .15s;
    }
    .btn-accent:hover { background: #1e40af; color: #fff; transform: translateY(-1px); }

    .btn-ghost {
      background: transparent; border: 1.5px solid var(--bf-border-md);
      color: var(--bf-text-dim); font-size: .78rem; border-radius: 8px; padding: .4rem .8rem;
      transition: all 150ms ease;
    }
    .btn-ghost:hover { background: var(--bf-elevated); color: var(--bf-text); border-color: var(--bf-accent); }

    /* ── Progress bars ───────────────────────────────────────────────── */
    .progress { background: var(--bf-border) !important; border-radius: 20px !important; height: 5px !important; }

    /* ── Scrollbar ───────────────────────────────────────────────────── */
    ::-webkit-scrollbar { width: 4px; height: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--bf-border-md); border-radius: 4px; }

    /* ── Pagination ──────────────────────────────────────────────────── */
    .pagination .page-link {
      background: var(--bf-surface) !important; border-color: var(--bf-border) !important;
      color: var(--bf-text-dim) !important; font-size: .78rem;
    }
    .pagination .page-item.active .page-link {
      background: var(--bf-accent) !important; border-color: var(--bf-accent) !important;
      color: #fff !important; font-weight: 700;
    }

    /* ── Modals ──────────────────────────────────────────────────────── */
    .modal-content {
      background: var(--bf-surface) !important;
      border: 1px solid var(--bf-border) !important;
      border-radius: var(--bf-radius) !important;
      box-shadow: 0 8px 32px rgba(0,0,0,.12) !important;
    }
    .modal-header { border-bottom: 1px solid var(--bf-border) !important; }
    .modal-footer { border-top: 1px solid var(--bf-border) !important; }
    .modal-title { color: var(--bf-text) !important; font-size: .92rem; font-weight: 700; }

    /* ── Code / mono spans ───────────────────────────────────────────── */
    .mono { font-family: 'Fira Code', monospace; }

    /* ── Topbar user chip ────────────────────────────────────────────── */
    .user-chip {
      display: flex; align-items: center; gap: .5rem;
      background: var(--bf-elevated); border: 1px solid var(--bf-border);
      border-radius: 20px; padding: .3rem .75rem .3rem .4rem;
      font-size: .78rem; color: var(--bf-text-dim);
    }
    .user-chip .avatar {
      width: 26px; height: 26px; border-radius: 50%;
      background: var(--bf-accent); color: #fff;
      font-size: .7rem; font-weight: 700;
      display: flex; align-items: center; justify-content: center;
    }
    .user-chip .role-tag {
      background: var(--bf-accent-lt); color: var(--bf-accent);
      font-size: .6rem; font-weight: 700; padding: .1rem .35rem;
      border-radius: 10px; letter-spacing: .04em;
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
