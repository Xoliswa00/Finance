@extends('layouts.Admin')
@section('page-title', 'Dashboard')
@section('content')

{{-- ── Stat cards ────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">

  <div class="col-xl-3 col-sm-6">
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(59,130,246,.12)">
        <i class="material-icons" style="color:#60a5fa;font-size:1.2rem">people</i>
      </div>
      <div class="stat-label">Total Users</div>
      <div class="stat-value">{{ $featureStats['total_users'] }}</div>
      <div class="stat-footer">
        <span class="{{ $percentageChange >= 0 ? '' : '' }}"
              style="color: {{ $percentageChange >= 0 ? 'var(--bf-accent)' : 'var(--bf-red)' }}; font-weight:600;">
          {{ $percentageChange >= 0 ? '+' : '' }}{{ $percentageChange }}%
        </span>
        vs yesterday
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(34,197,94,.12)">
        <i class="material-icons" style="color:var(--bf-accent);font-size:1.2rem">person_add</i>
      </div>
      <div class="stat-label">New This Week</div>
      <div class="stat-value">{{ $newUsersThisWeek }}</div>
      <div class="stat-footer">
        <span style="color: {{ $weekChange >= 0 ? 'var(--bf-accent)' : 'var(--bf-red)' }}; font-weight:600;">
          {{ $weekChange >= 0 ? '+' : '' }}{{ $weekChange }}%
        </span>
        vs last week
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(245,158,11,.12)">
        <i class="material-icons" style="color:var(--bf-amber);font-size:1.2rem">online_prediction</i>
      </div>
      <div class="stat-label">Online Now</div>
      <div class="stat-value">{{ $onlineCount }}</div>
      <div class="stat-footer" style="color:var(--bf-accent)">
        <span class="status-badge online" style="padding:.1rem .4rem;font-size:.62rem;">Live</span>
        active in last 5 min
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(168,85,247,.12)">
        <i class="material-icons" style="color:#a78bfa;font-size:1.2rem">bar_chart</i>
      </div>
      <div class="stat-label">Page Views Today</div>
      <div class="stat-value">{{ number_format($featureStats['page_views_today']) }}</div>
      <div class="stat-footer">{{ number_format($featureStats['page_views_week']) }} this week</div>
    </div>
  </div>

</div>

{{-- ── Charts row ─────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">

  {{-- Feature adoption --}}
  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-header">
        <h6>Feature Adoption</h6>
        <p class="mb-0 text-xs mt-1">Which features users are actually using</p>
      </div>
      <div class="card-body" style="padding: 1rem 1.25rem">
        @php
          $fs    = $featureStats;
          $total = max($fs['total_users'], 1);
          $items = [
            ['Onboarded',       $fs['onboarded'],       'var(--bf-accent)', '#22c55e'],
            ['Active (30 days)',$fs['active_30d'],       '#60a5fa',          '#3b82f6'],
            ['Used Transfers',  $fs['used_transfers'],   '#a78bfa',          '#8b5cf6'],
            ['Suspended',       $fs['suspended'],        '#f87171',          '#ef4444'],
          ];
        @endphp
        @foreach($items as [$label, $count, $color, $bar])
        <div class="mb-4">
          <div class="d-flex justify-content-between mb-1">
            <span style="font-size:.77rem;font-weight:500;color:var(--bf-text)">{{ $label }}</span>
            <span class="mono" style="font-size:.72rem;color:var(--bf-text-dim)">
              {{ $count }}<span style="opacity:.4"> / {{ $total }}</span>
            </span>
          </div>
          <div class="progress">
            <div class="progress-bar" style="width:{{ $total > 0 ? round($count/$total*100) : 0 }}%;background:{{ $bar }};border-radius:20px;"></div>
          </div>
        </div>
        @endforeach

        <hr style="border-color:var(--bf-border);margin:1rem 0">

        <div class="row text-center">
          <div class="col-6">
            <div style="font-size:.68rem;color:var(--bf-text-dim);margin-bottom:.2rem">Transactions</div>
            <div class="mono" style="font-size:1.2rem;font-weight:600">{{ number_format($featureStats['total_transactions']) }}</div>
          </div>
          <div class="col-6" style="border-left:1px solid var(--bf-border)">
            <div style="font-size:.68rem;color:var(--bf-text-dim);margin-bottom:.2rem">Budgets</div>
            <div class="mono" style="font-size:1.2rem;font-weight:600">{{ number_format($featureStats['total_budgets']) }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Signups by day --}}
  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-header">
        <h6>Signups by Day</h6>
        <p class="mb-0 text-xs mt-1">Which days users tend to register</p>
      </div>
      <div class="card-body d-flex align-items-center" style="padding:1rem 1.25rem">
        <canvas id="userStatsChart" height="200" style="width:100%"></canvas>
      </div>
    </div>
  </div>

  {{-- Activity 30 days --}}
  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-header">
        <h6>Activity — 30 Days</h6>
        <p class="mb-0 text-xs mt-1">Page views per day</p>
      </div>
      <div class="card-body d-flex align-items-center" style="padding:1rem 1.25rem">
        <canvas id="activityCount" height="200" style="width:100%"></canvas>
      </div>
    </div>
  </div>

</div>

{{-- ── Bottom row ─────────────────────────────────────────────────────── --}}
<div class="row g-3">

  {{-- Recent failed logins --}}
  <div class="col-lg-7">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6>Recent Failed Logins</h6>
        <a href="{{ route('admin.activity-log') }}" class="btn-ghost" style="font-size:.72rem;padding:.3rem .65rem;text-decoration:none;border-radius:6px;border:1px solid var(--bf-border);color:var(--bf-text-dim);transition:all 150ms">
          View All &rarr;
        </a>
      </div>
      <div class="card-body p-0">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>Email</th>
              <th>IP Address</th>
              <th>When</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentFailedLogins as $attempt)
            <tr>
              <td>
                <span style="font-size:.78rem;font-weight:500">{{ $attempt->email }}</span>
              </td>
              <td>
                <span class="mono" style="font-size:.72rem;color:var(--bf-text-dim)">{{ $attempt->ip_address }}</span>
              </td>
              <td>
                <span style="font-size:.72rem;color:var(--bf-text-dim)">
                  {{ \Carbon\Carbon::parse($attempt->created_at)->diffForHumans() }}
                </span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="3" class="text-center py-4" style="color:var(--bf-muted);font-size:.8rem">
                <i class="material-icons d-block mb-1" style="font-size:1.5rem;opacity:.3">security</i>
                No failed logins recently
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Quick actions --}}
  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header">
        <h6>Quick Actions</h6>
      </div>
      <div class="card-body" style="padding:1rem 1.25rem">
        <div class="d-flex flex-column gap-2">

          <a href="{{ route('admin.users') }}" class="d-flex align-items-center gap-3 p-3 text-decoration-none"
             style="background:var(--bf-elevated);border:1px solid var(--bf-border);border-radius:8px;transition:border-color 150ms;"
             onmouseover="this.style.borderColor='var(--bf-accent)'" onmouseout="this.style.borderColor='var(--bf-border)'">
            <div style="width:34px;height:34px;background:rgba(59,130,246,.12);border-radius:7px;display:flex;align-items:center;justify-content:center">
              <i class="material-icons" style="color:#60a5fa;font-size:1.1rem">group</i>
            </div>
            <div>
              <div style="font-size:.8rem;font-weight:600;color:var(--bf-text)">Manage Users</div>
              <div style="font-size:.7rem;color:var(--bf-muted)">Roles, suspension, activity</div>
            </div>
            <i class="material-icons ms-auto" style="font-size:1rem;color:var(--bf-muted)">chevron_right</i>
          </a>

          <a href="{{ route('admin.sites') }}" class="d-flex align-items-center gap-3 p-3 text-decoration-none"
             style="background:var(--bf-elevated);border:1px solid var(--bf-border);border-radius:8px;transition:border-color 150ms;"
             onmouseover="this.style.borderColor='var(--bf-accent)'" onmouseout="this.style.borderColor='var(--bf-border)'">
            <div style="width:34px;height:34px;background:rgba(34,197,94,.12);border-radius:7px;display:flex;align-items:center;justify-content:center">
              <i class="material-icons" style="color:var(--bf-accent);font-size:1.1rem">monitor_heart</i>
            </div>
            <div>
              <div style="font-size:.8rem;font-weight:600;color:var(--bf-text)">Site Monitor</div>
              <div style="font-size:.7rem;color:var(--bf-muted)">Uptime, errors, all instances</div>
            </div>
            <i class="material-icons ms-auto" style="font-size:1rem;color:var(--bf-muted)">chevron_right</i>
          </a>

          <a href="{{ route('admin.health') }}" class="d-flex align-items-center gap-3 p-3 text-decoration-none"
             style="background:var(--bf-elevated);border:1px solid var(--bf-border);border-radius:8px;transition:border-color 150ms;"
             onmouseover="this.style.borderColor='var(--bf-accent)'" onmouseout="this.style.borderColor='var(--bf-border)'">
            <div style="width:34px;height:34px;background:rgba(168,85,247,.12);border-radius:7px;display:flex;align-items:center;justify-content:center">
              <i class="material-icons" style="color:#a78bfa;font-size:1.1rem">favorite</i>
            </div>
            <div>
              <div style="font-size:.8rem;font-weight:600;color:var(--bf-text)">Platform Health</div>
              <div style="font-size:.7rem;color:var(--bf-muted)">DB, storage, error log</div>
            </div>
            <i class="material-icons ms-auto" style="font-size:1rem;color:var(--bf-muted)">chevron_right</i>
          </a>

          <a href="{{ route('admin.announcements.index') }}" class="d-flex align-items-center gap-3 p-3 text-decoration-none"
             style="background:var(--bf-elevated);border:1px solid var(--bf-border);border-radius:8px;transition:border-color 150ms;"
             onmouseover="this.style.borderColor='var(--bf-amber)'" onmouseout="this.style.borderColor='var(--bf-border)'">
            <div style="width:34px;height:34px;background:rgba(245,158,11,.12);border-radius:7px;display:flex;align-items:center;justify-content:center">
              <i class="material-icons" style="color:var(--bf-amber);font-size:1.1rem">campaign</i>
            </div>
            <div>
              <div style="font-size:.8rem;font-weight:600;color:var(--bf-text)">Announcements</div>
              <div style="font-size:.7rem;color:var(--bf-muted)">Post system-wide banners</div>
            </div>
            <i class="material-icons ms-auto" style="font-size:1rem;color:var(--bf-muted)">chevron_right</i>
          </a>

        </div>
      </div>
    </div>
  </div>

</div>

@endsection

@section('scripts')
<script>
const chartDefaults = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: { legend: { display: false } },
  scales: {
    x: { grid: { color: 'rgba(51,65,85,.5)', drawBorder: false }, ticks: { color: '#64748b', font: { family: 'Fira Code', size: 10 } } },
    y: { grid: { color: 'rgba(51,65,85,.5)', drawBorder: false }, ticks: { color: '#64748b', font: { family: 'Fira Code', size: 10 } }, beginAtZero: true }
  }
};

new Chart(document.getElementById('userStatsChart'), {
  type: 'bar',
  data: {
    labels: @json(collect($userStatsByDay)->pluck('day_of_week')),
    datasets: [{
      label: 'Signups',
      data: @json(collect($userStatsByDay)->pluck('user_count')),
      backgroundColor: 'rgba(59,130,246,.6)',
      hoverBackgroundColor: '#3b82f6',
      borderRadius: 5,
      borderSkipped: false
    }]
  },
  options: chartDefaults
});

new Chart(document.getElementById('activityCount'), {
  type: 'line',
  data: {
    labels: @json($activityCounts->pluck('date')),
    datasets: [{
      label: 'Page Views',
      data: @json($activityCounts->pluck('count')),
      tension: 0.4,
      borderColor: '#22c55e',
      backgroundColor: 'rgba(34,197,94,.08)',
      borderWidth: 2,
      pointRadius: 0,
      pointHoverRadius: 4,
      pointHoverBackgroundColor: '#22c55e',
      fill: true
    }]
  },
  options: chartDefaults
});
</script>
@endsection
