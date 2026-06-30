@extends('layouts.Admin')
@section('page-title', 'Dashboard')

@section('head')
<style>
/* ── Glassmorphism card upgrade ───────────────────────────────────────── */
.glass {
  background: rgba(15,23,42,0.7) !important;
  backdrop-filter: blur(16px) saturate(180%);
  -webkit-backdrop-filter: blur(16px) saturate(180%);
  border: 1px solid rgba(255,255,255,0.06) !important;
  border-radius: 16px !important;
  box-shadow: 0 4px 24px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.05) !important;
}

/* ── Stat cards ───────────────────────────────────────────────────────── */
.kpi-card {
  background: rgba(15,23,42,0.7);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 16px;
  padding: 1.4rem 1.5rem;
  position: relative;
  overflow: hidden;
  transition: border-color 200ms, box-shadow 200ms;
}
.kpi-card:hover {
  border-color: rgba(255,255,255,0.12);
  box-shadow: 0 8px 32px rgba(0,0,0,.5);
}
.kpi-card .kpi-glow {
  position: absolute;
  width: 80px; height: 80px;
  border-radius: 50%;
  filter: blur(40px);
  opacity: 0.15;
  top: -10px; right: -10px;
  pointer-events: none;
}
.kpi-card .kpi-icon {
  width: 40px; height: 40px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: .9rem;
}
.kpi-card .kpi-label {
  font-size: .68rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .1em;
  color: var(--bf-text-dim);
  margin-bottom: .35rem;
}
.kpi-card .kpi-value {
  font-family: 'Fira Code', monospace;
  font-size: 2rem;
  font-weight: 700;
  color: var(--bf-text);
  line-height: 1;
  margin-bottom: .45rem;
}
.kpi-card .kpi-delta {
  font-size: .72rem;
  display: flex;
  align-items: center;
  gap: .3rem;
}
.kpi-card .kpi-delta .material-icons { font-size: .85rem; }

/* ── Pulse dot ────────────────────────────────────────────────────────── */
@keyframes pulse-green {
  0%,100% { box-shadow: 0 0 0 0 rgba(34,197,94,.5); }
  50%      { box-shadow: 0 0 0 5px rgba(34,197,94,.0); }
}
.pulse-dot {
  width: 8px; height: 8px;
  border-radius: 50%;
  background: var(--bf-accent);
  animation: pulse-green 1.8s ease-in-out infinite;
  display: inline-block;
  vertical-align: middle;
  margin-right: 5px;
}

/* ── Section header ───────────────────────────────────────────────────── */
.section-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}
.section-head h6 {
  font-family: 'Fira Code', monospace;
  font-size: .72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .1em;
  color: var(--bf-text-dim);
  margin: 0;
}
.section-head a {
  font-size: .7rem;
  color: var(--bf-text-dim);
  text-decoration: none;
  border: 1px solid var(--bf-border);
  border-radius: 6px;
  padding: .25rem .6rem;
  transition: all 150ms;
}
.section-head a:hover { color: var(--bf-text); border-color: var(--bf-accent); }

/* ── Feature bar ──────────────────────────────────────────────────────── */
.feat-bar-wrap { margin-bottom: .9rem; }
.feat-bar-meta { display: flex; justify-content: space-between; margin-bottom: .3rem; }
.feat-bar-label { font-size: .76rem; font-weight: 500; color: var(--bf-text); }
.feat-bar-count { font-size: .72rem; font-family: 'Fira Code', monospace; color: var(--bf-text-dim); }
.feat-bar-track {
  height: 4px;
  background: rgba(51,65,85,.5);
  border-radius: 4px;
  overflow: hidden;
}
.feat-bar-fill {
  height: 100%;
  border-radius: 4px;
  transition: width 1s cubic-bezier(.4,0,.2,1);
}

/* ── Quick action rows ────────────────────────────────────────────────── */
.qa-row {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: .75rem 1rem;
  border-radius: 10px;
  background: rgba(30,41,59,0.5);
  border: 1px solid rgba(255,255,255,0.04);
  text-decoration: none;
  transition: all 150ms;
  margin-bottom: .5rem;
}
.qa-row:hover {
  background: rgba(30,41,59,0.9);
  border-color: var(--bf-accent);
  transform: translateX(2px);
}
.qa-icon {
  width: 36px; height: 36px;
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.qa-text { flex: 1; min-width: 0; }
.qa-title { font-size: .8rem; font-weight: 600; color: var(--bf-text); }
.qa-sub   { font-size: .68rem; color: var(--bf-muted); margin-top: .1rem; }

/* ── Table tweaks for glass context ──────────────────────────────────── */
.glass .table { margin: 0; }
.glass .table th {
  background: rgba(30,41,59,0.5) !important;
  font-size: .62rem !important;
}

/* ── Count-up number ──────────────────────────────────────────────────── */
.countup { display: inline-block; }
</style>
@endsection

@section('content')

{{-- ── KPI strip ────────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">

  {{-- Total Users --}}
  <div class="col-xl-3 col-sm-6">
    <div class="kpi-card">
      <div class="kpi-glow" style="background:#3b82f6"></div>
      <div class="kpi-icon" style="background:rgba(59,130,246,.12)">
        <i class="material-icons-round" style="color:#60a5fa;font-size:1.15rem">people</i>
      </div>
      <div class="kpi-label">Total Users</div>
      <div class="kpi-value"><span class="countup" data-target="{{ $featureStats['total_users'] }}">0</span></div>
      <div class="kpi-delta" style="color:{{ $percentageChange >= 0 ? 'var(--bf-accent)' : 'var(--bf-red)' }}">
        <i class="material-icons-round">{{ $percentageChange >= 0 ? 'trending_up' : 'trending_down' }}</i>
        {{ $percentageChange >= 0 ? '+' : '' }}{{ $percentageChange }}% vs yesterday
      </div>
    </div>
  </div>

  {{-- New This Week --}}
  <div class="col-xl-3 col-sm-6">
    <div class="kpi-card">
      <div class="kpi-glow" style="background:#22c55e"></div>
      <div class="kpi-icon" style="background:rgba(34,197,94,.12)">
        <i class="material-icons-round" style="color:#4ade80;font-size:1.15rem">person_add</i>
      </div>
      <div class="kpi-label">New This Week</div>
      <div class="kpi-value"><span class="countup" data-target="{{ $newUsersThisWeek }}">0</span></div>
      <div class="kpi-delta" style="color:{{ $weekChange >= 0 ? 'var(--bf-accent)' : 'var(--bf-red)' }}">
        <i class="material-icons-round">{{ $weekChange >= 0 ? 'trending_up' : 'trending_down' }}</i>
        {{ $weekChange >= 0 ? '+' : '' }}{{ $weekChange }}% vs last week
      </div>
    </div>
  </div>

  {{-- Online Now --}}
  <div class="col-xl-3 col-sm-6">
    <div class="kpi-card">
      <div class="kpi-glow" style="background:#f59e0b"></div>
      <div class="kpi-icon" style="background:rgba(245,158,11,.12)">
        <i class="material-icons-round" style="color:#fbbf24;font-size:1.15rem">sensors</i>
      </div>
      <div class="kpi-label">Online Now</div>
      <div class="kpi-value"><span class="countup" data-target="{{ $onlineCount }}">0</span></div>
      <div class="kpi-delta" style="color:var(--bf-accent)">
        <span class="pulse-dot"></span> Live · updated every 5 min
      </div>
    </div>
  </div>

  {{-- Page Views Today --}}
  <div class="col-xl-3 col-sm-6">
    <div class="kpi-card">
      <div class="kpi-glow" style="background:#a78bfa"></div>
      <div class="kpi-icon" style="background:rgba(168,85,247,.12)">
        <i class="material-icons-round" style="color:#a78bfa;font-size:1.15rem">bar_chart</i>
      </div>
      <div class="kpi-label">Page Views Today</div>
      <div class="kpi-value"><span class="countup" data-target="{{ $featureStats['page_views_today'] }}">0</span></div>
      <div class="kpi-delta" style="color:var(--bf-text-dim)">
        <i class="material-icons-round" style="color:var(--bf-muted)">calendar_view_week</i>
        {{ number_format($featureStats['page_views_week']) }} this week
      </div>
    </div>
  </div>

</div>

{{-- ── Charts row ───────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">

  {{-- Activity sparkline — wide --}}
  <div class="col-lg-8">
    <div class="glass card h-100">
      <div class="card-body" style="padding:1.25rem 1.5rem">
        <div class="section-head">
          <h6>Platform Activity — Last 30 Days</h6>
          <a href="{{ route('admin.activity-log') }}">Full log →</a>
        </div>
        <div style="position:relative;height:180px">
          <canvas id="activityChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- Signups by day of week --}}
  <div class="col-lg-4">
    <div class="glass card h-100">
      <div class="card-body" style="padding:1.25rem 1.5rem">
        <div class="section-head">
          <h6>Signups by Day</h6>
        </div>
        <div style="position:relative;height:180px">
          <canvas id="signupsChart"></canvas>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ── Bottom row ───────────────────────────────────────────────────────── --}}
<div class="row g-3">

  {{-- Feature adoption --}}
  <div class="col-lg-4">
    <div class="glass card h-100">
      <div class="card-body" style="padding:1.25rem 1.5rem">
        <div class="section-head mb-3">
          <h6>Feature Adoption</h6>
          <span style="font-size:.68rem;color:var(--bf-muted)">of {{ $featureStats['total_users'] }} users</span>
        </div>
        @php
          $total = max($featureStats['total_users'], 1);
          $bars = [
            ['Onboarded',        $featureStats['onboarded'],       '#22c55e'],
            ['Active (30 days)', $featureStats['active_30d'],       '#3b82f6'],
            ['Used Transfers',   $featureStats['used_transfers'],   '#a78bfa'],
            ['Suspended',        $featureStats['suspended'],        '#ef4444'],
          ];
        @endphp
        @foreach($bars as [$label, $count, $color])
        <div class="feat-bar-wrap">
          <div class="feat-bar-meta">
            <span class="feat-bar-label">{{ $label }}</span>
            <span class="feat-bar-count">{{ $count }} / {{ $total }}</span>
          </div>
          <div class="feat-bar-track">
            <div class="feat-bar-fill" style="width:0%;background:{{ $color }}"
                 data-width="{{ $total > 0 ? round($count/$total*100) : 0 }}"></div>
          </div>
        </div>
        @endforeach

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-top:1.25rem">
          <div style="background:rgba(30,41,59,.5);border-radius:10px;padding:.75rem;text-align:center">
            <div style="font-size:.62rem;color:var(--bf-muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.3rem">Transactions</div>
            <div class="countup" data-target="{{ $featureStats['total_transactions'] }}"
                 style="font-family:'Fira Code',monospace;font-size:1.3rem;font-weight:700;color:var(--bf-text)">0</div>
          </div>
          <div style="background:rgba(30,41,59,.5);border-radius:10px;padding:.75rem;text-align:center">
            <div style="font-size:.62rem;color:var(--bf-muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.3rem">Budgets</div>
            <div class="countup" data-target="{{ $featureStats['total_budgets'] }}"
                 style="font-family:'Fira Code',monospace;font-size:1.3rem;font-weight:700;color:var(--bf-text)">0</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Recent failed logins --}}
  <div class="col-lg-5">
    <div class="glass card h-100">
      <div class="card-body p-0" style="padding:1.25rem 1.5rem !important">
        <div class="section-head">
          <h6>Recent Failed Logins</h6>
          <a href="{{ route('admin.activity-log') }}">View all →</a>
        </div>
      </div>
      <div style="overflow:hidden;border-radius:0 0 16px 16px">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>Email</th>
              <th>IP</th>
              <th>When</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentFailedLogins as $attempt)
            <tr>
              <td style="font-size:.78rem;font-weight:500">{{ $attempt->email }}</td>
              <td><span class="mono" style="font-size:.71rem;color:var(--bf-text-dim)">{{ $attempt->ip_address }}</span></td>
              <td><span style="font-size:.71rem;color:var(--bf-text-dim)">{{ \Carbon\Carbon::parse($attempt->created_at)->diffForHumans() }}</span></td>
            </tr>
            @empty
            <tr>
              <td colspan="3" style="text-align:center;padding:2rem;color:var(--bf-muted);font-size:.8rem">
                <i class="material-icons-round" style="font-size:1.5rem;display:block;margin-bottom:.4rem;opacity:.3">shield</i>
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
  <div class="col-lg-3">
    <div class="glass card h-100">
      <div class="card-body" style="padding:1.25rem 1.5rem">
        <div class="section-head mb-3"><h6>Quick Actions</h6></div>

        <a href="{{ route('admin.users') }}" class="qa-row">
          <div class="qa-icon" style="background:rgba(59,130,246,.15)">
            <i class="material-icons-round" style="color:#60a5fa;font-size:1.1rem">group</i>
          </div>
          <div class="qa-text">
            <div class="qa-title">Users</div>
            <div class="qa-sub">Roles & suspension</div>
          </div>
          <i class="material-icons-round" style="color:var(--bf-border);font-size:.95rem">chevron_right</i>
        </a>

        <a href="{{ route('admin.sites') }}" class="qa-row">
          <div class="qa-icon" style="background:rgba(34,197,94,.15)">
            <i class="material-icons-round" style="color:#4ade80;font-size:1.1rem">monitor_heart</i>
          </div>
          <div class="qa-text">
            <div class="qa-title">Site Monitor</div>
            <div class="qa-sub">Uptime & errors</div>
          </div>
          <i class="material-icons-round" style="color:var(--bf-border);font-size:.95rem">chevron_right</i>
        </a>

        <a href="{{ route('admin.health') }}" class="qa-row">
          <div class="qa-icon" style="background:rgba(168,85,247,.15)">
            <i class="material-icons-round" style="color:#a78bfa;font-size:1.1rem">favorite</i>
          </div>
          <div class="qa-text">
            <div class="qa-title">Health</div>
            <div class="qa-sub">DB & storage</div>
          </div>
          <i class="material-icons-round" style="color:var(--bf-border);font-size:.95rem">chevron_right</i>
        </a>

        <a href="{{ route('admin.announcements.index') }}" class="qa-row">
          <div class="qa-icon" style="background:rgba(245,158,11,.15)">
            <i class="material-icons-round" style="color:#fbbf24;font-size:1.1rem">campaign</i>
          </div>
          <div class="qa-text">
            <div class="qa-title">Announcements</div>
            <div class="qa-sub">System banners</div>
          </div>
          <i class="material-icons-round" style="color:var(--bf-border);font-size:.95rem">chevron_right</i>
        </a>

      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
// ── Count-up animation ────────────────────────────────────────────────
document.querySelectorAll('.countup').forEach(el => {
  const target = parseInt(el.dataset.target, 10) || 0;
  const duration = 1200;
  const start = performance.now();
  const fmt = n => n >= 1000 ? n.toLocaleString() : n;
  (function step(now) {
    const progress = Math.min((now - start) / duration, 1);
    const eased = 1 - Math.pow(1 - progress, 3);
    el.textContent = fmt(Math.round(target * eased));
    if (progress < 1) requestAnimationFrame(step);
  })(start);
});

// ── Feature bar animations ────────────────────────────────────────────
document.querySelectorAll('.feat-bar-fill').forEach(el => {
  setTimeout(() => { el.style.width = el.dataset.width + '%'; }, 200);
});

// ── Chart defaults ────────────────────────────────────────────────────
const gridColor  = 'rgba(51,65,85,.35)';
const tickColor  = '#475569';
const fontMono   = 'Fira Code';

const baseScales = {
  x: { grid: { color: gridColor, drawBorder: false }, ticks: { color: tickColor, font: { family: fontMono, size: 10 } } },
  y: { grid: { color: gridColor, drawBorder: false }, ticks: { color: tickColor, font: { family: fontMono, size: 10 } }, beginAtZero: true }
};

const tooltip = {
  backgroundColor: 'rgba(15,23,42,0.95)',
  borderColor: 'rgba(51,65,85,.8)',
  borderWidth: 1,
  titleColor: '#f1f5f9',
  bodyColor: '#94a3b8',
  padding: 10,
  cornerRadius: 8,
  titleFont: { family: fontMono, size: 11 },
  bodyFont: { family: fontMono, size: 11 },
};

// ── Activity chart ────────────────────────────────────────────────────
new Chart(document.getElementById('activityChart'), {
  type: 'line',
  data: {
    labels: @json($activityCounts->pluck('date')),
    datasets: [{
      label: 'Page Views',
      data: @json($activityCounts->pluck('count')),
      tension: 0.4,
      borderColor: '#22c55e',
      backgroundColor: (ctx) => {
        const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 180);
        g.addColorStop(0, 'rgba(34,197,94,.25)');
        g.addColorStop(1, 'rgba(34,197,94,.0)');
        return g;
      },
      borderWidth: 2,
      pointRadius: 0,
      pointHoverRadius: 5,
      pointHoverBackgroundColor: '#22c55e',
      pointHoverBorderColor: '#020617',
      pointHoverBorderWidth: 2,
      fill: true
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    plugins: { legend: { display: false }, tooltip },
    scales: baseScales
  }
});

// ── Signups by day chart ──────────────────────────────────────────────
new Chart(document.getElementById('signupsChart'), {
  type: 'bar',
  data: {
    labels: @json(collect($userStatsByDay)->pluck('day_of_week')),
    datasets: [{
      label: 'Signups',
      data: @json(collect($userStatsByDay)->pluck('user_count')),
      backgroundColor: (ctx) => {
        const max = Math.max(...ctx.chart.data.datasets[0].data);
        return ctx.raw === max ? 'rgba(34,197,94,.8)' : 'rgba(59,130,246,.5)';
      },
      hoverBackgroundColor: '#22c55e',
      borderRadius: 6,
      borderSkipped: false
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    plugins: { legend: { display: false }, tooltip },
    scales: baseScales
  }
});
</script>
@endsection
