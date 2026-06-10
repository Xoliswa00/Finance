@extends('layouts.Nav')

@section('title', 'Goal Milestones')
@section('page-title', 'Goal Milestones')

@section('breadcrumb')
<span>/</span>
<a href="{{ route('goals.index') }}">Goals</a>
<span>/</span>
<span>Milestones</span>
@endsection

@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h6 style="font-weight:700;color:#0f172a;margin-bottom:2px;">{{ $goal->title }}</h6>
        <p style="font-size:.83rem;color:#94a3b8;margin:0;">Target: ZAR {{ number_format($goal->target_amount, 2) }} · Due {{ $goal->end_date }}</p>
    </div>
    <a href="{{ route('goals.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;font-size:.85rem;font-weight:600;">
        <i class="material-icons-round me-1" style="font-size:.9rem;vertical-align:middle;">arrow_back</i> Back to Goals
    </a>
</div>

<div class="card mb-4" style="border-radius:16px;border:1px solid #e2e8f0;">
    <div class="card-body p-4">
        <h6 style="font-weight:700;color:#0f172a;margin-bottom:16px;">Progress Chart</h6>
        <div style="position:relative;height:320px;">
            <canvas id="milestonesChart"></canvas>
        </div>
    </div>
</div>

<div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0" style="font-size:.88rem;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">#</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Date</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Amount</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($milestonesData as $milestone)
                    <tr style="border-color:#f8fafc;">
                        <td style="padding:12px 20px;color:#94a3b8;border-color:#f8fafc;">{{ $loop->iteration }}</td>
                        <td style="padding:12px 20px;color:#64748b;border-color:#f8fafc;">{{ $milestone['date'] }}</td>
                        <td style="padding:12px 20px;font-weight:700;color:#0f172a;border-color:#f8fafc;">
                            ZAR {{ number_format($milestone['amount'], 2) }}
                        </td>
                        <td style="padding:12px 20px;border-color:#f8fafc;">
                            @if($milestone['status'] === 'current')
                            <span style="font-size:.75rem;background:#eff6ff;color:#1d4ed8;border-radius:50px;padding:3px 10px;font-weight:600;">Current Balance</span>
                            @elseif($milestone['status'] === 'Achieved')
                            <span style="font-size:.75rem;background:#f0fdf4;color:#16a34a;border-radius:50px;padding:3px 10px;font-weight:600;">
                                <i class="material-icons-round" style="font-size:.75rem;vertical-align:middle;">check_circle</i> Achieved
                            </span>
                            @else
                            <span style="font-size:.75rem;background:#fef2f2;color:#dc2626;border-radius:50px;padding:3px 10px;font-weight:600;">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
(function () {
    var data = {!! json_encode($milestonesChartData) !!};
    var pointColors = data.map(function (m) {
        if (m.status === 'current')  return '#1d4ed8';
        if (m.status === 'Achieved') return '#16a34a';
        return '#dc2626';
    });

    var ctx = document.getElementById('milestonesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(function (m) { return m.label; }),
            datasets: [{
                label: 'Milestone Progress',
                data: data.map(function (m) { return m.amount; }),
                borderColor: '#1d4ed8',
                borderWidth: 3,
                backgroundColor: 'rgba(29,78,216,.06)',
                fill: true,
                tension: 0.3,
                pointBackgroundColor: pointColors,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 7,
                pointHoverRadius: 9,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (ctx) { return 'ZAR ' + ctx.parsed.y.toFixed(2); }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, title: { display: true, text: 'Milestone' } },
                y: { grid: { color: '#f1f5f9' }, title: { display: true, text: 'Amount (ZAR)' }, ticks: { callback: function (v) { return 'R ' + v.toLocaleString(); } } }
            }
        }
    });
})();
</script>
@endsection
