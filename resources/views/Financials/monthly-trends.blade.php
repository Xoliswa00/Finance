@extends('layouts.Nav')

@section('title', 'Monthly Trends')
@section('page-title', 'Monthly Trends Report')

@section('breadcrumb')
<li class="breadcrumb-item">Reports</li>
<li class="breadcrumb-item active">Monthly Trends</li>
@endsection

@section('head')
<style>
    .summary-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .summary-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .summary-label { font-size: 0.75rem; color: #64748b; font-weight: 500; }
    .summary-value { font-size: 1.4rem; font-weight: 800; color: #0f172a; line-height: 1.2; }

    .report-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }
    .report-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .report-card-header h6 { font-size: 0.9rem; font-weight: 700; color: #0f172a; margin: 0; }
    .report-card-body { padding: 20px; }

    .chart-wrap { position: relative; height: 280px; }

    .month-table th {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #475569;
        background: #f8fafc;
        border: none;
        padding: 10px 14px;
    }
    .month-table td {
        font-size: 0.85rem;
        color: #334155;
        border-color: #f1f5f9;
        padding: 10px 14px;
        vertical-align: middle;
    }
    .month-table .text-income { color: #059669; font-weight: 700; }
    .month-table .text-expense { color: #dc2626; font-weight: 700; }
    .month-table .text-positive { color: #059669; font-weight: 700; }
    .month-table .text-negative { color: #dc2626; font-weight: 700; }

    .cat-bar-wrap { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .cat-bar-label { font-size: 0.82rem; color: #334155; min-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .cat-bar-track { flex: 1; height: 10px; background: #e2e8f0; border-radius: 5px; overflow: hidden; }
    .cat-bar-fill { height: 100%; border-radius: 5px; background: linear-gradient(90deg,#1d4ed8,#0ea5e9); }
    .cat-bar-value { font-size: 0.78rem; font-weight: 700; color: #475569; white-space: nowrap; min-width: 80px; text-align: right; }
</style>
@endsection

@section('content')

{{-- ── Summary Stats ── --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-4">
        <div class="summary-card">
            <div class="summary-icon" style="background:#f0fdf4;">
                <i class="material-icons-round" style="color:#059669;">trending_up</i>
            </div>
            <div>
                <div class="summary-label">Total Income (12m)</div>
                <div class="summary-value" style="color:#059669;">ZAR {{ number_format($totals['income'], 2) }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="summary-card">
            <div class="summary-icon" style="background:#fef2f2;">
                <i class="material-icons-round" style="color:#dc2626;">trending_down</i>
            </div>
            <div>
                <div class="summary-label">Total Expenses (12m)</div>
                <div class="summary-value" style="color:#dc2626;">ZAR {{ number_format($totals['expenses'], 2) }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="summary-card">
            <div class="summary-icon" style="{{ $totals['net'] >= 0 ? 'background:#eff6ff;' : 'background:#fef2f2;' }}">
                <i class="material-icons-round" style="color:{{ $totals['net'] >= 0 ? '#1d4ed8' : '#dc2626' }};">account_balance_wallet</i>
            </div>
            <div>
                <div class="summary-label">Net Position (12m)</div>
                <div class="summary-value" style="color:{{ $totals['net'] >= 0 ? '#1d4ed8' : '#dc2626' }};">
                    ZAR {{ number_format(abs($totals['net']), 2) }}
                    <span style="font-size:.75rem;font-weight:500;">{{ $totals['net'] >= 0 ? 'surplus' : 'deficit' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Charts Row ── --}}
<div class="row g-3 mb-3">

    {{-- Line: Income vs Expenses --}}
    <div class="col-12 col-lg-8">
        <div class="report-card">
            <div class="report-card-header">
                <h6><i class="material-icons-round me-2" style="font-size:1rem;vertical-align:middle;color:#1d4ed8;">show_chart</i>Income vs Expenses — Last 12 Months</h6>
            </div>
            <div class="report-card-body">
                <div class="chart-wrap"><canvas id="trendLine"></canvas></div>
            </div>
        </div>
    </div>

    {{-- Bar: Net Position --}}
    <div class="col-12 col-lg-4">
        <div class="report-card">
            <div class="report-card-header">
                <h6><i class="material-icons-round me-2" style="font-size:1rem;vertical-align:middle;color:#059669;">bar_chart</i>Monthly Net Position</h6>
            </div>
            <div class="report-card-body">
                <div class="chart-wrap"><canvas id="netBar"></canvas></div>
            </div>
        </div>
    </div>

</div>

{{-- ── Category Breakdown ── --}}
@if($categoryBreakdown->count())
<div class="row g-3 mb-3">
    <div class="col-12 col-lg-6">
        <div class="report-card">
            <div class="report-card-header">
                <h6><i class="material-icons-round me-2" style="font-size:1rem;vertical-align:middle;color:#f59e0b;">pie_chart</i>Top Expense Categories (Last 3 Months)</h6>
            </div>
            <div class="report-card-body">
                @php $maxCat = $categoryBreakdown->max('total'); @endphp
                @foreach($categoryBreakdown as $cat)
                <div class="cat-bar-wrap">
                    <div class="cat-bar-label" title="{{ $cat->name }}">{{ $cat->name }}</div>
                    <div class="cat-bar-track">
                        <div class="cat-bar-fill" style="width:{{ $maxCat > 0 ? round(($cat->total / $maxCat) * 100) : 0 }}%;"></div>
                    </div>
                    <div class="cat-bar-value">ZAR {{ number_format($cat->total, 2) }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Doughnut --}}
    <div class="col-12 col-lg-6">
        <div class="report-card">
            <div class="report-card-header">
                <h6><i class="material-icons-round me-2" style="font-size:1rem;vertical-align:middle;color:#7c3aed;">donut_large</i>Expense Distribution</h6>
            </div>
            <div class="report-card-body" style="display:flex;align-items:center;justify-content:center;">
                <div style="height:260px;width:260px;"><canvas id="catDoughnut"></canvas></div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── Monthly Data Table ── --}}
<div class="report-card">
    <div class="report-card-header">
        <h6><i class="material-icons-round me-2" style="font-size:1rem;vertical-align:middle;color:#475569;">table_chart</i>Monthly Breakdown</h6>
    </div>
    <div class="report-card-body p-0">
        <div class="table-responsive">
            <table class="table month-table mb-0">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Income</th>
                        <th>Expenses</th>
                        <th>Net</th>
                        <th>Savings Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($netByMonth as $row)
                    @php
                        $rate = $row['income'] > 0 ? round(($row['net'] / $row['income']) * 100, 1) : 0;
                        $rateColor = $rate >= 20 ? '#059669' : ($rate >= 0 ? '#d97706' : '#dc2626');
                    @endphp
                    <tr>
                        <td><strong>{{ \Carbon\Carbon::createFromFormat('Y-m', $row['month'])->format('M Y') }}</strong></td>
                        <td class="text-income">ZAR {{ number_format($row['income'], 2) }}</td>
                        <td class="text-expense">ZAR {{ number_format($row['expenses'], 2) }}</td>
                        <td class="{{ $row['net'] >= 0 ? 'text-positive' : 'text-negative' }}">
                            {{ $row['net'] >= 0 ? '+' : '' }}ZAR {{ number_format($row['net'], 2) }}
                        </td>
                        <td>
                            <span style="font-weight:700;color:{{ $rateColor }};">{{ $rate }}%</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4" style="color:#94a3b8;">No transaction data for the last 12 months.</td>
                    </tr>
                    @endforelse
                </tbody>
                @if($netByMonth->count())
                <tfoot>
                    <tr style="background:#f8fafc;font-weight:700;">
                        <td>Total</td>
                        <td class="text-income">ZAR {{ number_format($totals['income'], 2) }}</td>
                        <td class="text-expense">ZAR {{ number_format($totals['expenses'], 2) }}</td>
                        <td class="{{ $totals['net'] >= 0 ? 'text-positive' : 'text-negative' }}">
                            {{ $totals['net'] >= 0 ? '+' : '' }}ZAR {{ number_format($totals['net'], 2) }}
                        </td>
                        <td>
                            @php $avgRate = $totals['income'] > 0 ? round(($totals['net'] / $totals['income']) * 100, 1) : 0; @endphp
                            <span style="font-weight:700;color:{{ $avgRate >= 0 ? '#059669' : '#dc2626' }};">{{ $avgRate }}% avg</span>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@php
    $trendData = [
        'labels'   => $netByMonth->pluck('month')->map(fn($m) => \Carbon\Carbon::createFromFormat('Y-m',$m)->format('M y'))->values(),
        'income'   => $netByMonth->pluck('income')->values(),
        'expenses' => $netByMonth->pluck('expenses')->values(),
        'net'      => $netByMonth->pluck('net')->values(),
        'catLabels'=> $categoryBreakdown->pluck('name')->values(),
        'catTotals'=> $categoryBreakdown->pluck('total')->values(),
    ];
@endphp
<script>
var td = @json($trendData);

var palette = ['#1d4ed8','#0ea5e9','#059669','#f59e0b','#ef4444','#7c3aed','#ec4899','#14b8a6','#f97316','#84cc16'];

// Line chart
new Chart(document.getElementById('trendLine').getContext('2d'), {
    type: 'line',
    data: {
        labels: td.labels,
        datasets: [
            { label: 'Income', data: td.income, borderColor: '#059669', backgroundColor: 'rgba(5,150,105,.08)', fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#059669' },
            { label: 'Expenses', data: td.expenses, borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,.06)', fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#ef4444' }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { position: 'top', labels: { font: { size: 11 } } } },
        scales: {
            y: { beginAtZero: true, ticks: { font: { size: 10 }, callback: function(v) { return 'R' + Number(v).toLocaleString(); } } },
            x: { ticks: { font: { size: 10 } } }
        }
    }
});

// Net bar
new Chart(document.getElementById('netBar').getContext('2d'), {
    type: 'bar',
    data: {
        labels: td.labels,
        datasets: [{
            label: 'Net',
            data: td.net,
            backgroundColor: td.net.map(function(v) { return v >= 0 ? 'rgba(5,150,105,.75)' : 'rgba(239,68,68,.75)'; }),
            borderRadius: 6,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { ticks: { font: { size: 10 }, callback: function(v) { return 'R' + Number(v).toLocaleString(); } } },
            x: { ticks: { font: { size: 10 } } }
        }
    }
});

// Category doughnut
if (document.getElementById('catDoughnut') && td.catLabels.length) {
    new Chart(document.getElementById('catDoughnut').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: td.catLabels,
            datasets: [{
                data: td.catTotals,
                backgroundColor: palette.slice(0, td.catLabels.length),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '55%',
            plugins: { legend: { position: 'bottom', labels: { font: { size: 10 }, boxWidth: 12 } } }
        }
    });
}
</script>
@endsection
