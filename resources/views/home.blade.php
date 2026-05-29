@extends('layouts.Nav')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('head')
<style>
    .stat-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: box-shadow .2s;
    }
    .stat-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.07); }
    .stat-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .stat-label { font-size: 0.75rem; color: #64748b; font-weight: 500; }
    .stat-value { font-size: 1.3rem; font-weight: 800; color: #0f172a; line-height: 1.2; }
    .stat-change { font-size: 0.72rem; color: #64748b; margin-top: 2px; }
    .stat-change.up { color: #059669; }
    .stat-change.down { color: #dc2626; }

    .section-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }
    .section-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .section-card-header h6 {
        font-size: 0.88rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .section-card-body { padding: 16px 20px; }

    .budget-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .budget-item:last-child { border-bottom: none; }
    .budget-item-icon {
        width: 36px; height: 36px;
        border-radius: 8px;
        background: #eff6ff;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .budget-item-name { font-size: 0.85rem; font-weight: 600; color: #0f172a; }
    .budget-item-sub { font-size: 0.75rem; color: #64748b; }
    .budget-item-amount { font-size: 0.85rem; font-weight: 700; color: #0f172a; white-space: nowrap; }

    .goal-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .goal-row:last-child { border-bottom: none; }
    .goal-name { font-size: 0.85rem; font-weight: 600; color: #0f172a; min-width: 0; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .goal-date { font-size: 0.72rem; color: #94a3b8; white-space: nowrap; }

    .due-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        background: #f8fafc;
        border-radius: 8px;
        margin-bottom: 8px;
    }
    .due-item-dot { width: 8px; height: 8px; border-radius: 50%; background: #f59e0b; flex-shrink: 0; }
    .due-item-name { font-size: 0.83rem; color: #334155; flex: 1; }
    .due-item-date { font-size: 0.75rem; color: #94a3b8; white-space: nowrap; }

    .empty-state { text-align: center; padding: 28px 16px; color: #94a3b8; font-size: 0.85rem; }
    .empty-state i { font-size: 2rem; display: block; margin-bottom: 8px; color: #cbd5e1; }

    .chart-wrapper { position: relative; height: 220px; }
</style>
@endsection

@section('content')

{{-- ── Summary Stats Row ── --}}
<div class="row g-3 mb-4">

    {{-- Bank Balance --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;">
                <i class="material-icons-round" style="color:#1d4ed8;">account_balance</i>
            </div>
            <div>
                <div class="stat-label">Bank Balance</div>
                <div class="stat-value">
                    @forelse($balance as $b)
                        ZAR {{ number_format($b->Balance, 2) }}
                    @empty
                        ZAR 0.00
                    @endforelse
                </div>
                <div class="stat-change">Current balance</div>
            </div>
        </div>
    </div>

    {{-- Credit Card Balance --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef9c3;">
                <i class="material-icons-round" style="color:#d97706;">credit_card</i>
            </div>
            <div>
                <div class="stat-label">Credit Card</div>
                <div class="stat-value">
                    @forelse($CreditB as $c)
                        ZAR {{ number_format($c->Balance, 2) }}
                    @empty
                        ZAR 0.00
                    @endforelse
                </div>
                <div class="stat-change">Available balance</div>
            </div>
        </div>
    </div>

    {{-- Income Budgeted --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">
                <i class="material-icons-round" style="color:#059669;">trending_up</i>
            </div>
            <div>
                <div class="stat-label">Income Budgeted</div>
                <div class="stat-value">
                    ZAR {{ number_format($budget[0]->income_budgeted ?? 0, 2) }}
                </div>
                <div class="stat-change up">Planning phase</div>
            </div>
        </div>
    </div>

    {{-- Expenses Budgeted --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef2f2;">
                <i class="material-icons-round" style="color:#dc2626;">trending_down</i>
            </div>
            <div>
                <div class="stat-label">Expenses Budgeted</div>
                <div class="stat-value">
                    ZAR {{ number_format($budget[0]->expense_budgeted ?? 0, 2) }}
                </div>
                <div class="stat-change down">Planning phase</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Getting Started Checklist (shown until onboarded) ── --}}
@if($checklist && !$checklist['complete'])
<div class="row mb-3">
    <div class="col-12">
        <div class="section-card" style="border:2px solid #bfdbfe;background:linear-gradient(135deg,#eff6ff,#f0f9ff);">
            <div class="section-card-body py-3 px-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                    <div>
                        <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1d4ed8;margin-bottom:2px;">Getting Started</div>
                        <h6 style="font-size:.95rem;font-weight:700;color:#0f172a;margin:0;">Complete your setup — {{ $checklist['done'] }} of {{ $checklist['total'] }} done</h6>
                    </div>
                    <form action="{{ route('onboarding.complete') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary" style="font-size:.75rem;border-radius:8px;">Dismiss</button>
                    </form>
                </div>

                {{-- Progress bar --}}
                <div style="height:6px;background:rgba(29,78,216,.15);border-radius:3px;margin-bottom:20px;overflow:hidden;">
                    <div style="height:100%;width:{{ $checklist['pct'] }}%;background:linear-gradient(90deg,#1d4ed8,#0ea5e9);border-radius:3px;transition:width .5s;"></div>
                </div>

                <div class="row g-2">
                    @foreach($checklist['steps'] as $step)
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div style="background:{{ $step['done'] ? '#fff' : '#fff' }};border:1.5px solid {{ $step['done'] ? '#bbf7d0' : '#e2e8f0' }};border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:10px;height:100%;">
                            <div style="width:32px;height:32px;border-radius:50%;background:{{ $step['done'] ? '#dcfce7' : '#f1f5f9' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                @if($step['done'])
                                    <i class="fas fa-check" style="color:#059669;font-size:.7rem;"></i>
                                @else
                                    <i class="material-icons-round" style="font-size:1rem;color:#94a3b8;">{{ $step['icon'] }}</i>
                                @endif
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:.8rem;font-weight:{{ $step['done'] ? '500' : '600' }};color:{{ $step['done'] ? '#94a3b8' : '#334155' }};text-decoration:{{ $step['done'] ? 'line-through' : 'none' }};line-height:1.3;">{{ $step['label'] }}</div>
                                @if(!$step['done'] && isset($step['route']))
                                <a href="{{ route($step['route']) }}" style="font-size:.72rem;color:#1d4ed8;font-weight:600;text-decoration:none;">{{ $step['action'] }} →</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── Main Grid ── --}}
<div class="row g-3">

    {{-- Left Column --}}
    <div class="col-12 col-lg-8">

        {{-- Budget vs Actual Charts --}}
        <div class="section-card mb-3">
            <div class="section-card-header">
                <h6><i class="material-icons-round me-2" style="font-size:1rem;vertical-align:middle;color:#1d4ed8;">bar_chart</i>Budget vs Actual Overview</h6>
                <a href="{{ route('Report.spending') }}" class="btn btn-sm btn-outline-primary" style="font-size:.75rem;border-radius:8px;">Full Report</a>
            </div>
            <div class="section-card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="chart-wrapper"><canvas id="budgetChart"></canvas></div>
                        <div class="text-center mt-1" style="font-size:.78rem;color:#64748b;">Budget Overview</div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="chart-wrapper"><canvas id="actualChart"></canvas></div>
                        <div class="text-center mt-1" style="font-size:.78rem;color:#64748b;">Actual Overview</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Income/Expense Trend --}}
        <div class="section-card mb-3">
            <div class="section-card-header">
                <h6><i class="material-icons-round me-2" style="font-size:1rem;vertical-align:middle;color:#059669;">show_chart</i>Monthly Income vs Expenses</h6>
                <a href="{{ route('reports.trends') }}" class="btn btn-sm btn-outline-success" style="font-size:.75rem;border-radius:8px;">Trend Report</a>
            </div>
            <div class="section-card-body">
                <div class="chart-wrapper"><canvas id="trendChart"></canvas></div>
            </div>
        </div>

        {{-- Pending Budgets --}}
        <div class="section-card">
            <div class="section-card-header">
                <h6><i class="material-icons-round me-2" style="font-size:1rem;vertical-align:middle;color:#f59e0b;">receipt_long</i>Pending Budget Items</h6>
                <a href="{{ route('budgets.create') }}" class="btn btn-sm btn-primary" style="font-size:.75rem;border-radius:8px;">
                    <i class="material-icons-round" style="font-size:.85rem;vertical-align:middle;">add</i> New
                </a>
            </div>
            <div class="section-card-body">
                @forelse($CurrentB as $budget_item)
                    @if($budget_item->Status === 'Planning')
                    <div class="budget-item">
                        <div class="budget-item-icon">
                            <i class="material-icons-round" style="font-size:1rem;color:#1d4ed8;">priority_high</i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div class="budget-item-name text-uppercase">{{ $budget_item->Description }}</div>
                            <div class="budget-item-sub">Due: {{ $budget_item->due_date }}</div>
                        </div>
                        <div class="text-end">
                            <div class="budget-item-amount" title="Budgeted vs Actual">
                                ZAR {{ number_format($budget_item->Amount, 2) }}
                                <span style="font-size:.72rem;color:#94a3b8;font-weight:400;"> / ZAR {{ number_format($budget_item->Limit, 2) }}</span>
                            </div>
                            <div style="display:flex;gap:4px;justify-content:flex-end;margin-top:4px;">
                                <form action="{{ route('budgets.edit', $budget_item->id) }}" method="GET">
                                    <button type="submit" class="btn btn-sm btn-outline-info" style="padding:2px 8px;font-size:.72rem;border-radius:6px;">Edit</button>
                                </form>
                                <form action="{{ route('budgets.Finalized', $budget_item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-success" style="padding:2px 8px;font-size:.72rem;border-radius:6px;">Finalize</button>
                                </form>
                                <form action="{{ route('budgets.destroy', $budget_item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="padding:2px 8px;font-size:.72rem;border-radius:6px;"
                                            onclick="return confirm('Delete this budget item?')">Del</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @empty
                    <div class="empty-state">
                        <i class="material-icons-round">inbox</i>
                        No pending budget items.
                        <a href="{{ route('budgets.create') }}" class="d-block mt-2 text-primary fw-600">Create your first budget</a>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Right Column --}}
    <div class="col-12 col-lg-4">

        {{-- Primary Card Display --}}
        @if($main)
        <div class="section-card mb-3" style="background:linear-gradient(135deg,#1d4ed8,#0ea5e9);border:none;">
            <div class="section-card-body" style="padding:20px 22px;">
                <div class="d-flex justify-content-between align-items-start">
                    <i class="material-icons-round text-white opacity-75" style="font-size:1.5rem;">wifi</i>
                    <img src="/assets/img/logos/mastercard.png" style="height:28px;opacity:.8;" alt="card network">
                </div>
                <div class="text-white mt-3 mb-2" style="font-size:1.05rem;font-weight:700;letter-spacing:.12em;">
                    @php
                        $cn = $main->CardNumber;
                        echo substr($cn,0,4) . ' **** **** ' . substr($cn,-4);
                    @endphp
                </div>
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <div style="font-size:.68rem;color:rgba(255,255,255,.7);">Card Holder</div>
                        <div class="text-white fw-600" style="font-size:.85rem;">{{ $main->Cardholder }}</div>
                    </div>
                    <div>
                        <div style="font-size:.68rem;color:rgba(255,255,255,.7);">Expires</div>
                        <div class="text-white fw-600" style="font-size:.85rem;">{{ $main->ExpiryDate }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Goals Progress --}}
        <div class="section-card mb-3">
            <div class="section-card-header">
                <h6><i class="material-icons-round me-2" style="font-size:1rem;vertical-align:middle;color:#7c3aed;">flag</i>Active Goals</h6>
                <a href="{{ route('Goals.Matter') }}" class="btn btn-sm btn-outline-secondary" style="font-size:.75rem;border-radius:8px;">View All</a>
            </div>
            <div class="section-card-body">
                @forelse($goals as $goal)
                    @php
                        $pct = $goal->target_amount > 0 ? min(100, round(($goal->current_amount / $goal->target_amount) * 100)) : 0;
                        $color = $pct >= 75 ? '#22c55e' : ($pct >= 40 ? '#f59e0b' : '#1d4ed8');
                    @endphp
                    <div class="goal-row">
                        <div style="flex:1;min-width:0;">
                            <div class="goal-name" title="{{ $goal->title }}">{{ $goal->title }}</div>
                            <div style="height:6px;background:#e2e8f0;border-radius:3px;overflow:hidden;margin-top:5px;">
                                <div style="height:100%;width:{{ $pct }}%;background:{{ $color }};border-radius:3px;transition:width .4s;"></div>
                            </div>
                        </div>
                        <div class="text-end" style="flex-shrink:0;">
                            <div style="font-size:.78rem;font-weight:700;color:{{ $color }};">{{ $pct }}%</div>
                            <div class="goal-date">{{ $goal->end_date }}</div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="material-icons-round">flag</i>
                        No active goals.
                        <a href="{{ route('goals.create') }}" class="d-block mt-2 text-primary">Set a goal</a>
                    </div>
                @endforelse

                @if($goals->hasPages())
                <div class="mt-2 text-center" style="font-size:.75rem;">
                    {{ $goals->links() }}
                </div>
                @endif
            </div>
        </div>

        {{-- Upcoming Payment Due Dates --}}
        <div class="section-card mb-3">
            <div class="section-card-header">
                <h6><i class="material-icons-round me-2" style="font-size:1rem;vertical-align:middle;color:#f59e0b;">event</i>Upcoming Due Dates</h6>
                <a href="{{ route('budgets.index') }}" class="btn btn-sm btn-outline-warning" style="font-size:.75rem;border-radius:8px;">View Budgets</a>
            </div>
            <div class="section-card-body">
                @forelse($budgetDates as $due)
                    <div class="due-item">
                        <div class="due-item-dot"></div>
                        <div class="due-item-name">{{ $due->Description }}</div>
                        <div class="due-item-date">{{ $due->due_date }}</div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="material-icons-round">event_available</i>
                        No upcoming due dates.
                    </div>
                @endforelse

                @if($budgetDates->hasPages())
                <div class="mt-2 text-center" style="font-size:.75rem;">
                    {{ $budgetDates->links() }}
                </div>
                @endif
            </div>
        </div>

        {{-- Milestone Reminders --}}
        @if($milestonedates->count() > 0)
        <div class="section-card">
            <div class="section-card-header">
                <h6><i class="material-icons-round me-2" style="font-size:1rem;vertical-align:middle;color:#dc2626;">notifications_active</i>Milestone Reminders</h6>
            </div>
            <div class="section-card-body">
                @foreach($milestonedates as $ms)
                <div class="due-item">
                    <div class="due-item-dot" style="background:#dc2626;"></div>
                    <div>
                        <div class="due-item-name">{{ $ms->title }}</div>
                        <div style="font-size:.72rem;color:#94a3b8;">Milestone {{ $ms->milestone_number }}</div>
                    </div>
                    <div class="due-item-date">{{ $ms->due_date }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

{{-- Quick Action FAB row --}}
<div class="row mt-3">
    <div class="col-12">
        <div class="section-card">
            <div class="section-card-body py-3">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <span style="font-size:.8rem;font-weight:600;color:#64748b;margin-right:4px;">Quick actions:</span>
                    <a href="{{ route('transactions.create') }}" class="btn btn-sm btn-primary" style="border-radius:8px;font-size:.8rem;">
                        <i class="material-icons-round me-1" style="font-size:.85rem;vertical-align:middle;">add</i>New Transaction
                    </a>
                    <a href="{{ route('budgets.create') }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;font-size:.8rem;">
                        <i class="material-icons-round me-1" style="font-size:.85rem;vertical-align:middle;">add</i>New Budget
                    </a>
                    <a href="{{ route('goals.create') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.8rem;">
                        <i class="material-icons-round me-1" style="font-size:.85rem;vertical-align:middle;">flag</i>New Goal
                    </a>
                    <a href="{{ route('transactions.list') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.8rem;">
                        <i class="material-icons-round me-1" style="font-size:.85rem;vertical-align:middle;">history</i>Transaction History
                    </a>
                    <a href="{{ route('Report.spending') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.8rem;">
                        <i class="material-icons-round me-1" style="font-size:.85rem;vertical-align:middle;">bar_chart</i>View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@php
    $chartData = [
        'incomeBudgeted'  => $budget[0]->income_budgeted  ?? 0,
        'expenseBudgeted' => $budget[0]->expense_budgeted ?? 0,
        'incomeActual'    => $actual[0]->income_actual    ?? 0,
        'expenseActual'   => $actual[0]->expense_actual   ?? 0,
        'labels'          => $labels,
        'incoming'        => $incoming,
        'outgoing'        => $outgoing,
    ];
@endphp
<script>
    var _cd = @json($chartData);

    // Budget Chart
    new Chart(document.getElementById('budgetChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Income Budgeted', 'Expenses Budgeted'],
            datasets: [{
                data: [_cd.incomeBudgeted, _cd.expenseBudgeted],
                backgroundColor: ['#22c55e', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }
        }
    });

    // Actual Chart
    new Chart(document.getElementById('actualChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Income Actual', 'Expenses Actual'],
            datasets: [{
                data: [_cd.incomeActual, _cd.expenseActual],
                backgroundColor: ['#1d4ed8', '#f59e0b'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }
        }
    });

    // Trend Line Chart
    new Chart(document.getElementById('trendChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: _cd.labels,
            datasets: [
                {
                    label: 'Income',
                    data: _cd.incoming,
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#22c55e',
                },
                {
                    label: 'Expenses',
                    data: _cd.outgoing,
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239,68,68,.08)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#ef4444',
                }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'top', labels: { font: { size: 11 } } } },
            scales: {
                y: { beginAtZero: true, ticks: { font: { size: 11 }, callback: v => 'R' + v.toLocaleString() } },
                x: { ticks: { font: { size: 11 } } }
            }
        }
    });
</script>
@endsection
