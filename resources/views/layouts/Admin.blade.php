<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BF Admin — @yield('page-title', 'Admin Portal')</title>

  <link rel="icon" type="image/png" href="/assets/images/bright.png">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link id="pagestyle" href="/assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body { font-family: 'Inter', sans-serif; }
    .impersonation-bar { background: #7c3aed; color: #fff; text-align: center; padding: 8px 16px; font-size: .85rem; font-weight: 600; position: sticky; top: 0; z-index: 9999; }
    .impersonation-bar a { color: #e9d5ff; text-decoration: underline; margin-left: 12px; }
    .announce-bar { text-align: center; padding: 9px 16px; font-size: .84rem; font-weight: 500; }
    .nav-section-label { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: rgba(255,255,255,.4); padding: 18px 16px 4px; }
  </style>
  @yield('head')
</head>

<body class="g-sidenav-show bg-gray-300">

{{-- Impersonation banner --}}
@if(session('impersonating_id'))
<div class="impersonation-bar">
  <i class="fas fa-user-secret me-1"></i>
  You are impersonating <strong>{{ auth()->user()->name }}</strong>.
  <form action="{{ route('admin.stop-impersonating') }}" method="POST" style="display:inline">
    @csrf
    <button type="submit" style="background:none;border:none;color:#e9d5ff;text-decoration:underline;cursor:pointer;font-size:.85rem;font-weight:600;">
      Stop Impersonating
    </button>
  </form>
</div>
@endif

{{-- Announcement banner --}}
@if(!empty($activeAnnouncement))
<div class="announce-bar alert-{{ $activeAnnouncement->type }} mb-0 border-radius-0">
  <i class="fas fa-bullhorn me-2"></i>{{ $activeAnnouncement->message }}
</div>
@endif

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-4 fixed-start ms-2 bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="{{ route('admin.dashboard') }}">
      <img src="/assets/images/Bright v4.png" class="navbar-brand-img h-100" alt="logo">
      <span class="ms-1 font-weight-bold text-white">BF : Admin</span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">

  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">

      {{-- Core --}}
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-gradient-primary' : '' }}" href="{{ route('admin.dashboard') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      <div class="nav-section-label">Users</div>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('admin.users') ? 'active bg-gradient-primary' : '' }}" href="{{ route('admin.users') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">group</i>
          </div>
          <span class="nav-link-text ms-1">Manage Users</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('admin.activity-log') ? 'active bg-gradient-primary' : '' }}" href="{{ route('admin.activity-log') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">history</i>
          </div>
          <span class="nav-link-text ms-1">Activity Log</span>
        </a>
      </li>

      <div class="nav-section-label">Platform</div>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('admin.health') ? 'active bg-gradient-primary' : '' }}" href="{{ route('admin.health') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">monitor_heart</i>
          </div>
          <span class="nav-link-text ms-1">Platform Health</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('admin.announcements.*') ? 'active bg-gradient-primary' : '' }}" href="{{ route('admin.announcements.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">campaign</i>
          </div>
          <span class="nav-link-text ms-1">Announcements</span>
        </a>
      </li>

      <div class="nav-section-label">Account</div>

      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('home') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">swap_horiz</i>
          </div>
          <span class="nav-link-text ms-1">Back to App</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">logout</i>
          </div>
          <span class="nav-link-text ms-1">Sign Out</span>
        </a>
        <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
      </li>

    </ul>
  </div>
</aside>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
  {{-- Top bar --}}
  <nav class="navbar navbar-main navbar-expand-lg px-3 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
      <div class="d-flex align-items-center">
        <a href="{{ route('admin.dashboard') }}">
          <img src="/assets/images/Bright v4.png" style="height:3rem;" alt="Bright Finance">
        </a>
      </div>
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav ms-auto justify-content-end">
          <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </a>
          </li>
          <li class="nav-item d-flex align-items-center">
            <span class="nav-link text-body font-weight-bold px-0">
              <i class="material-icons opacity-10 me-1">account_circle</i>
              {{ auth()->user()->name }} <span class="badge bg-gradient-dark ms-1" style="font-size:.65rem;">{{ auth()->user()->Role }}</span>
            </span>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- Flash messages --}}
  <div class="container-fluid px-4 pt-2">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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

  <div class="container-fluid py-4">
    <section>@yield('content')</section>
  </div>
</main>

<script src="/assets/js/core/popper.min.js"></script>
<script src="/assets/js/core/bootstrap.min.js"></script>
<script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="/assets/js/material-dashboard.min.js?v=3.1.0"></script>
@yield('scripts')
</body>
</html>
