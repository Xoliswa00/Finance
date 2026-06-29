@extends('layouts.Admin')
@section('page-title', 'Site Monitor')

@section('head')
<style>
  .site-card {
    background: var(--bf-surface);
    border: 1px solid var(--bf-border);
    border-radius: 10px;
    padding: 1.25rem;
    transition: border-color 200ms ease;
  }

  .site-card:hover { border-color: var(--bf-accent); }

  .site-card.status-online  { border-left: 3px solid var(--bf-accent); }
  .site-card.status-degraded { border-left: 3px solid var(--bf-amber); }
  .site-card.status-offline  { border-left: 3px solid var(--bf-red); }
  .site-card.status-unknown  { border-left: 3px solid var(--bf-muted); }

  .metric-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: .35rem 0;
    border-bottom: 1px solid rgba(51,65,85,.4);
    font-size: .75rem;
  }

  .metric-row:last-child { border-bottom: none; }
  .metric-label { color: var(--bf-text-dim); }
  .metric-value { font-family: 'Fira Code', monospace; color: var(--bf-text); font-weight: 500; }

  .uptime-bar {
    height: 4px;
    background: var(--bf-elevated);
    border-radius: 20px;
    margin-top: .5rem;
    overflow: hidden;
  }

  .uptime-fill { height: 100%; border-radius: 20px; transition: width 600ms ease; }

  .event-item {
    display: flex;
    gap: .75rem;
    padding: .6rem 0;
    border-bottom: 1px solid rgba(51,65,85,.4);
    align-items: flex-start;
  }

  .event-item:last-child { border-bottom: none; }

  .event-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    margin-top: .35rem;
    flex-shrink: 0;
  }

  .refresh-spin { animation: spin 1s linear infinite; }
  @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

  .last-refresh { font-family: 'Fira Code', monospace; font-size: .68rem; color: var(--bf-muted); }
</style>
@endsection

@section('content')

{{-- ── Header ──────────────────────────────────────────────────────────── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="mb-0" style="font-family:'Fira Code',monospace;color:var(--bf-text)">Site Monitor</h5>
    <p class="mb-0 mt-1" style="font-size:.78rem;color:var(--bf-text-dim)">
      Real-time status for all Bright Finance instances
    </p>
  </div>
  <div class="d-flex align-items-center gap-3">
    <span class="last-refresh" id="lastRefresh">
      Last updated: {{ now()->format('H:i:s') }}
    </span>
    <button class="btn-ghost d-flex align-items-center gap-1" id="refreshBtn" onclick="refreshMonitor()" style="font-size:.78rem;padding:.4rem .8rem;cursor:pointer;background:transparent;border:1px solid var(--bf-border);border-radius:7px;color:var(--bf-text-dim)">
      <i class="material-icons" id="refreshIcon" style="font-size:1rem">refresh</i>
      Refresh
    </button>
  </div>
</div>

@if($error)
  {{-- API unreachable --}}
  <div class="card mb-4">
    <div class="card-body text-center py-5">
      <i class="material-icons d-block mb-3" style="font-size:3rem;color:var(--bf-amber)">cloud_off</i>
      <h6 style="color:var(--bf-text);margin-bottom:.5rem">Monitor API Unreachable</h6>
      <p style="font-size:.82rem;color:var(--bf-text-dim);max-width:440px;margin:0 auto 1.5rem">
        {{ $error }}
      </p>
      <div style="background:var(--bf-elevated);border:1px solid var(--bf-border);border-radius:8px;padding:.75rem 1rem;display:inline-block;text-align:left;margin-bottom:1.5rem">
        <div style="font-size:.68rem;color:var(--bf-muted);margin-bottom:.2rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em">Configure in .env</div>
        <code style="font-size:.78rem;color:var(--bf-accent)">XQUISITE_MONITOR_URL=https://xquisite.brightfinance.co.za/api/monitor</code>
      </div>
      <br>
      <a href="{{ route('admin.sites') }}" class="btn-accent" style="text-decoration:none;padding:.5rem 1.25rem;border-radius:7px;display:inline-flex;align-items:center;gap:.4rem">
        <i class="material-icons" style="font-size:.9rem">refresh</i> Retry
      </a>
    </div>
  </div>

@else

  {{-- ── Summary strip ─────────────────────────────────────────────────── --}}
  @php
    $online   = collect($sites)->where('status', 'online')->count();
    $degraded = collect($sites)->where('status', 'degraded')->count();
    $offline  = collect($sites)->where('status', 'offline')->count();
    $total    = count($sites);
  @endphp

  <div class="row g-3 mb-4">
    <div class="col-sm-3">
      <div class="stat-card" style="border-left:3px solid var(--bf-accent)">
        <div class="stat-label">Sites Monitored</div>
        <div class="stat-value mono">{{ $total }}</div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="stat-card" style="border-left:3px solid var(--bf-accent)">
        <div class="stat-label">Online</div>
        <div class="stat-value mono" style="color:var(--bf-accent)">{{ $online }}</div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="stat-card" style="border-left:3px solid var(--bf-amber)">
        <div class="stat-label">Degraded</div>
        <div class="stat-value mono" style="color:var(--bf-amber)">{{ $degraded }}</div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="stat-card" style="border-left:3px solid var(--bf-red)">
        <div class="stat-label">Offline</div>
        <div class="stat-value mono" style="color:var(--bf-red)">{{ $offline }}</div>
      </div>
    </div>
  </div>

  {{-- ── Site cards ────────────────────────────────────────────────────── --}}
  <div class="row g-3 mb-4">
    @foreach($sites as $site)
    @php
      $status   = $site['status'] ?? 'unknown';
      $uptime   = $site['uptime_percent'] ?? 0;
      $barColor = match($status) {
        'online'   => 'var(--bf-accent)',
        'degraded' => 'var(--bf-amber)',
        'offline'  => 'var(--bf-red)',
        default    => 'var(--bf-muted)',
      };
    @endphp
    <div class="col-xl-4 col-lg-6">
      <div class="site-card status-{{ $status }}">

        {{-- Site header --}}
        <div class="d-flex align-items-start justify-content-between mb-3">
          <div>
            <div style="font-size:.88rem;font-weight:600;color:var(--bf-text);margin-bottom:.2rem">
              {{ $site['name'] ?? 'Unknown' }}
            </div>
            <div style="font-size:.68rem;color:var(--bf-muted);font-family:'Fira Code',monospace">
              {{ $site['url'] ?? '—' }}
            </div>
          </div>
          <span class="status-badge {{ $status }}">{{ ucfirst($status) }}</span>
        </div>

        {{-- Uptime bar --}}
        <div style="margin-bottom:1rem">
          <div style="display:flex;justify-content:space-between;margin-bottom:.3rem">
            <span style="font-size:.68rem;color:var(--bf-muted);font-weight:600;text-transform:uppercase;letter-spacing:.08em">Uptime (30d)</span>
            <span class="mono" style="font-size:.72rem;color:var(--bf-text)">{{ number_format($uptime, 2) }}%</span>
          </div>
          <div class="uptime-bar">
            <div class="uptime-fill" style="width:{{ min($uptime, 100) }}%;background:{{ $barColor }}"></div>
          </div>
        </div>

        {{-- Metrics --}}
        <div>
          <div class="metric-row">
            <span class="metric-label">Response Time</span>
            <span class="metric-value">{{ $site['response_ms'] ?? '—' }} ms</span>
          </div>
          <div class="metric-row">
            <span class="metric-label">Active Users</span>
            <span class="metric-value">{{ $site['active_users'] ?? '—' }}</span>
          </div>
          <div class="metric-row">
            <span class="metric-label">Errors (24h)</span>
            <span class="metric-value" style="color: {{ ($site['errors_24h'] ?? 0) > 0 ? 'var(--bf-red)' : 'var(--bf-accent)' }}">
              {{ $site['errors_24h'] ?? 0 }}
            </span>
          </div>
          <div class="metric-row">
            <span class="metric-label">Disk Used</span>
            <span class="metric-value">{{ $site['disk_used'] ?? '—' }}</span>
          </div>
          <div class="metric-row">
            <span class="metric-label">Last Checked</span>
            <span class="metric-value" style="color:var(--bf-text-dim)">{{ $site['last_checked'] ?? '—' }}</span>
          </div>
        </div>

        {{-- Support tickets if any --}}
        @if(($site['open_tickets'] ?? 0) > 0)
        <div style="margin-top:.75rem;padding:.5rem .75rem;background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.2);border-radius:7px;display:flex;align-items:center;gap:.5rem">
          <i class="material-icons" style="font-size:.9rem;color:var(--bf-amber)">confirmation_number</i>
          <span style="font-size:.72rem;color:var(--bf-amber);font-weight:600">
            {{ $site['open_tickets'] }} open support ticket{{ $site['open_tickets'] > 1 ? 's' : '' }}
          </span>
        </div>
        @endif

      </div>
    </div>
    @endforeach
  </div>

  {{-- ── Event feed ────────────────────────────────────────────────────── --}}
  @if(!empty($events))
  <div class="card">
    <div class="card-header">
      <h6>System Events</h6>
      <p class="mb-0 text-xs mt-1">Recent events across all monitored instances</p>
    </div>
    <div class="card-body" style="padding: 1rem 1.25rem">
      @foreach($events as $event)
      @php
        $dotColor = match($event['level'] ?? 'info') {
          'error'   => 'var(--bf-red)',
          'warning' => 'var(--bf-amber)',
          'success' => 'var(--bf-accent)',
          default   => 'var(--bf-blue)',
        };
      @endphp
      <div class="event-item">
        <div class="event-dot" style="background:{{ $dotColor }}"></div>
        <div style="flex:1;min-width:0">
          <div style="font-size:.78rem;color:var(--bf-text)">{{ $event['message'] ?? '' }}</div>
          <div style="font-size:.68rem;color:var(--bf-muted);margin-top:.15rem">
            <span class="mono">{{ $event['site'] ?? '' }}</span>
            @if(!empty($event['time']))
              &nbsp;·&nbsp; {{ $event['time'] }}
            @endif
          </div>
        </div>
        @if(!empty($event['level']))
        <span style="font-size:.62rem;font-weight:700;text-transform:uppercase;padding:.15rem .45rem;border-radius:10px;
              background: {{ match($event['level']) {
                'error'   => 'rgba(239,68,68,.12)',
                'warning' => 'rgba(245,158,11,.12)',
                'success' => 'rgba(34,197,94,.12)',
                default   => 'rgba(59,130,246,.12)'
              } }};
              color: {{ $dotColor }};">
          {{ $event['level'] }}
        </span>
        @endif
      </div>
      @endforeach
    </div>
  </div>
  @endif

@endif

@endsection

@section('scripts')
<script>
  // Auto-refresh every 60 seconds
  let countdown = 60;
  setInterval(() => {
    countdown--;
    if (countdown <= 0) { location.reload(); }
  }, 1000);

  function refreshMonitor() {
    const icon = document.getElementById('refreshIcon');
    icon.classList.add('refresh-spin');
    setTimeout(() => location.reload(), 300);
  }
</script>
@endsection
