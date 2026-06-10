@extends('layouts.Admin')
@section('page-title', 'Dashboard')
@section('content')

<div class="container-fluid py-2">

  {{-- ── Stat Cards ─────────────────────────────────────────────── --}}
  <div class="row g-3 mb-4">

    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-header bg-gradient-primary p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">people</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm text-white mb-0">Total Users</p>
            <h4 class="mb-0 text-white">{{ $featureStats['total_users'] }}</h4>
          </div>
        </div>
        <div class="card-footer p-3">
          <p class="mb-0 text-sm">
            <span class="{{ $percentageChange >= 0 ? 'text-success' : 'text-danger' }} font-weight-bolder">
              {{ $percentageChange >= 0 ? '+' : '' }}{{ $percentageChange }}%
            </span> vs yesterday
          </p>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-header bg-gradient-success p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">person_add</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm text-white mb-0">New This Week</p>
            <h4 class="mb-0 text-white">{{ $newUsersThisWeek }}</h4>
          </div>
        </div>
        <div class="card-footer p-3">
          <p class="mb-0 text-sm">
            <span class="{{ $weekChange >= 0 ? 'text-success' : 'text-danger' }} font-weight-bolder">
              {{ $weekChange >= 0 ? '+' : '' }}{{ $weekChange }}%
            </span> vs last week
          </p>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-header bg-gradient-info p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">online_prediction</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm text-white mb-0">Online Now</p>
            <h4 class="mb-0 text-white">{{ $onlineCount }}</h4>
          </div>
        </div>
        <div class="card-footer p-3">
          <p class="mb-0 text-sm text-secondary">Active in last 5 minutes</p>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-header bg-gradient-warning p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">bar_chart</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm text-white mb-0">Page Views Today</p>
            <h4 class="mb-0 text-white">{{ $featureStats['page_views_today'] }}</h4>
          </div>
        </div>
        <div class="card-footer p-3">
          <p class="mb-0 text-sm text-secondary">{{ $featureStats['page_views_week'] }} this week</p>
        </div>
      </div>
    </div>

  </div>

  {{-- ── Feature Usage & Charts ──────────────────────────────────── --}}
  <div class="row g-3 mb-4">

    {{-- Feature usage breakdown --}}
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h6 class="mb-0">Feature Adoption</h6>
          <p class="text-sm text-secondary mb-0">Which features users are actually using</p>
        </div>
        <div class="card-body">
          @php
            $fs = $featureStats;
            $total = max($fs['total_users'], 1);
            $items = [
              ['Onboarded',         $fs['onboarded'],         'success'],
              ['Active (30 days)',   $fs['active_30d'],        'info'],
              ['Used Transfers',     $fs['used_transfers'],    'primary'],
              ['Suspended',         $fs['suspended'],         'danger'],
            ];
          @endphp
          @foreach($items as [$label, $count, $color])
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="text-sm font-weight-bold">{{ $label }}</span>
              <span class="text-sm text-secondary">{{ $count }} / {{ $total }}</span>
            </div>
            <div class="progress" style="height:6px;">
              <div class="progress-bar bg-gradient-{{ $color }}"
                   style="width:{{ $total > 0 ? round($count / $total * 100) : 0 }}%"></div>
            </div>
          </div>
          @endforeach

          <hr class="my-3">
          <div class="row text-center">
            <div class="col-6">
              <p class="text-sm text-secondary mb-0">Transactions</p>
              <h5 class="mb-0">{{ number_format($featureStats['total_transactions']) }}</h5>
            </div>
            <div class="col-6">
              <p class="text-sm text-secondary mb-0">Budgets</p>
              <h5 class="mb-0">{{ number_format($featureStats['total_budgets']) }}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- User signups by day of week --}}
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h6 class="mb-0">Signups by Day</h6>
          <p class="text-sm text-secondary mb-0">Which days users tend to register</p>
        </div>
        <div class="card-body">
          <canvas id="userStatsChart" height="220"></canvas>
        </div>
      </div>
    </div>

    {{-- Activity over 30 days --}}
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h6 class="mb-0">Activity (30 days)</h6>
          <p class="text-sm text-secondary mb-0">Page views per day</p>
        </div>
        <div class="card-body">
          <canvas id="activityCount" height="220"></canvas>
        </div>
      </div>
    </div>

  </div>

  {{-- ── Recent Failed Logins ────────────────────────────────────── --}}
  <div class="row g-3">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Recent Failed Logins</h6>
          <a href="{{ route('admin.activity-log') }}" class="btn btn-sm btn-outline-dark">View All</a>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Email</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder">IP</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder">When</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentFailedLogins as $attempt)
                <tr>
                  <td><p class="text-xs font-weight-bold mb-0">{{ $attempt->email }}</p></td>
                  <td><p class="text-xs text-secondary mb-0">{{ $attempt->ip_address }}</p></td>
                  <td><p class="text-xs text-secondary mb-0">{{ \Carbon\Carbon::parse($attempt->created_at)->diffForHumans() }}</p></td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-sm text-secondary py-3">No failed logins recently.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- Quick links --}}
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header pb-0">
          <h6 class="mb-0">Quick Actions</h6>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <a href="{{ route('admin.users') }}" class="btn bg-gradient-primary btn-sm">
              <i class="material-icons text-sm me-1">group</i> Manage Users
            </a>
            <a href="{{ route('admin.activity-log') }}" class="btn bg-gradient-info btn-sm">
              <i class="material-icons text-sm me-1">history</i> Full Activity Log
            </a>
            <a href="{{ route('admin.health') }}" class="btn bg-gradient-dark btn-sm">
              <i class="material-icons text-sm me-1">monitor_heart</i> Platform Health
            </a>
            <a href="{{ route('admin.announcements.index') }}" class="btn bg-gradient-warning btn-sm">
              <i class="material-icons text-sm me-1">campaign</i> Post Announcement
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection

@section('scripts')
<script>
  // Signups by day
  new Chart(document.getElementById('userStatsChart'), {
    type: 'bar',
    data: {
      labels: @json(collect($userStatsByDay)->pluck('day_of_week')),
      datasets: [{ label: 'Signups', data: @json(collect($userStatsByDay)->pluck('user_count')),
        backgroundColor: 'rgba(99,102,241,.7)', borderRadius: 4, borderSkipped: false }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
  });

  // Activity line
  new Chart(document.getElementById('activityCount'), {
    type: 'line',
    data: {
      labels: @json($activityCounts->pluck('date')),
      datasets: [{ label: 'Page Views', data: @json($activityCounts->pluck('count')),
        tension: 0.4, borderColor: 'rgba(16,185,129,1)', backgroundColor: 'rgba(16,185,129,.1)', fill: true }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
  });
</script>
@endsection
