@extends('layouts.Nav')

@section('title', 'Cash Budget')
@section('page-title', 'Cash Budget Report')

@section('breadcrumb')
<li class="breadcrumb-item">Reports</li>
<li class="breadcrumb-item active">Cash Budget</li>
@endsection

@php
    function fmt($n) { return 'R ' . number_format($n, 2, '.', ','); }

    // Variance helpers — sign depends on whether the item is income or expense
    // For income:  budget > actual = shortfall = unfavourable (negative)
    // For expense: budget > actual = underspend  = favourable (positive)
    function incomeVar($budget, $actual) { return $actual - $budget; }   // positive = exceeded target
    function expenseVar($budget, $actual) { return $budget - $actual; }  // positive = underspent (good)
    function varClass($v) { return $v >= 0 ? 'text-success' : 'text-danger'; }
    function varIcon($v)  { return $v >= 0 ? '▲' : '▼'; }
@endphp

@section('head')
<style>
    .cb-card { background:#fff; border-radius:16px; border:1px solid #e2e8f0; margin-bottom:20px; overflow:hidden; }
    .cb-card-head {
        background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
        color:#fff; padding:12px 20px;
        display:flex; align-items:center; gap:8px;
        font-size:.88rem; font-weight:700;
    }
    .cb-card-head i { font-size:1rem; }

    .cb-table { width:100%; border-collapse:collapse; font-size:.84rem; }
    .cb-table th {
        background:#f8fafc;
        font-size:.7rem; font-weight:700;
        text-transform:uppercase; letter-spacing:.06em;
        color:#64748b; padding:10px 14px;
        border-bottom:1px solid #e2e8f0;
        text-align:right;
    }
    .cb-table th:first-child { text-align:left; }
    .cb-table td { padding:9px 14px; border-bottom:1px solid #f8fafc; color:#334155; text-align:right; vertical-align:middle; }
    .cb-table td:first-child { text-align:left; color:#0f172a; font-weight:500; }
    .cb-table tr:last-child td { border-bottom:none; }
    .cb-table .section-row td { background:#f8fafc; font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; padding:8px 14px; }
    .cb-table .total-row td { font-weight:700; color:#0f172a; border-top:2px solid #e2e8f0; background:#f8fafc; }
    .cb-table .net-row td { font-weight:800; border-top:2px solid #1d4ed8; color:#1d4ed8; }
    .cb-table .grand-row td { font-weight:800; font-size:.92rem; background: #f0f9ff; border-top:3px double #1d4ed8; }
    .text-success { color:#059669 !important; font-weight:700; }
    .text-danger  { color:#dc2626 !important; font-weight:700; }

    .summary-pill {
        background:#fff; border:1px solid #e2e8f0; border-radius:14px;
        padding:18px 20px; text-align:center;
    }
    .sp-label { font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#94a3b8; margin-bottom:4px; }
    .sp-value { font-size:1.3rem; font-weight:800; line-height:1; }
    .sp-sub   { font-size:.72rem; color:#94a3b8; margin-top:3px; }
</style>
@endsection

@section('content')

{{-- ── Summary Pillboxes ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="summary-pill">
            <div class="sp-label">Opening Balance</div>
            <div class="sp-value" style="color:#1d4ed8;">{{ fmt($data['opening_balance']) }}</div>
            <div class="sp-sub">Bank (Dr) current</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="summary-pill">
            <div class="sp-label">{{ $data['month_1'] }} Inflows</div>
            <div class="sp-value" style="color:#059669;">{{ fmt($data['m1_income_budget']) }}</div>
            <div class="sp-sub">Budgeted income</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="summary-pill">
            <div class="sp-label">{{ $data['month_1'] }} Outflows</div>
            <div class="sp-value" style="color:#dc2626;">{{ fmt($data['m1_expense_budget']) }}</div>
            <div class="sp-sub">Budgeted expenses</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="summary-pill">
            @php $closing = $data['closing_balance']; @endphp
            <div class="sp-label">Projected Closing</div>
            <div class="sp-value" style="color:{{ $closing >= 0 ? '#059669' : '#dc2626' }};">{{ fmt($closing) }}</div>
            <div class="sp-sub">Opening + Net (budget)</div>
        </div>
    </div>
</div>

{{-- ── Main Table ── --}}
<div class="cb-card">
    <div class="cb-card-head">
        <i class="material-icons-round">waterfall_chart</i>
        Cash Budget — {{ $data['month_2'] }} vs {{ $data['month_1'] }}
        <span style="font-size:.72rem;opacity:.75;margin-left:auto;">Prepared by Bright Finance · {{ now()->format('d M Y') }}</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="cb-table">
            <thead>
                <tr>
                    <th style="min-width:200px;">Description</th>
                    <th>{{ $data['month_2'] }}<br><span style="font-weight:400;font-size:.65rem;">Budget</span></th>
                    <th>{{ $data['month_2'] }}<br><span style="font-weight:400;font-size:.65rem;">Actual</span></th>
                    <th>{{ $data['month_2'] }}<br><span style="font-weight:400;font-size:.65rem;">Variance</span></th>
                    <th>{{ $data['month_1'] }}<br><span style="font-weight:400;font-size:.65rem;">Budget</span></th>
                    <th>{{ $data['month_1'] }}<br><span style="font-weight:400;font-size:.65rem;">Actual</span></th>
                    <th>{{ $data['month_1'] }}<br><span style="font-weight:400;font-size:.65rem;">Variance</span></th>
                </tr>
            </thead>
            <tbody>

                {{-- ── CASH INFLOWS ── --}}
                <tr class="section-row"><td colspan="7">Cash Inflows</td></tr>

                @foreach($data['budget_data'] as $row)
                @if($row->Nature === 'Income')
                @php
                    $v2 = incomeVar($row->m2_budget, $row->m2_actual);
                    $v1 = incomeVar($row->m1_budget, $row->m1_actual);
                @endphp
                <tr>
                    <td>{{ $row->Description }}</td>
                    <td>{{ fmt($row->m2_budget) }}</td>
                    <td>{{ fmt($row->m2_actual) }}</td>
                    <td class="{{ varClass($v2) }}">{{ varIcon($v2) }} {{ fmt(abs($v2)) }}</td>
                    <td>{{ fmt($row->m1_budget) }}</td>
                    <td>{{ fmt($row->m1_actual) }}</td>
                    <td class="{{ varClass($v1) }}">{{ varIcon($v1) }} {{ fmt(abs($v1)) }}</td>
                </tr>
                @endif
                @endforeach

                @php
                    $m2IncVar = incomeVar($data['m2_income_budget'], $data['m2_income_actual']);
                    $m1IncVar = incomeVar($data['m1_income_budget'], $data['m1_income_actual']);
                @endphp
                <tr class="total-row">
                    <td>Total Cash Inflows</td>
                    <td>{{ fmt($data['m2_income_budget']) }}</td>
                    <td>{{ fmt($data['m2_income_actual']) }}</td>
                    <td class="{{ varClass($m2IncVar) }}">{{ varIcon($m2IncVar) }} {{ fmt(abs($m2IncVar)) }}</td>
                    <td>{{ fmt($data['m1_income_budget']) }}</td>
                    <td>{{ fmt($data['m1_income_actual']) }}</td>
                    <td class="{{ varClass($m1IncVar) }}">{{ varIcon($m1IncVar) }} {{ fmt(abs($m1IncVar)) }}</td>
                </tr>

                {{-- spacer --}}
                <tr><td colspan="7" style="padding:4px;border:none;background:#fff;"></td></tr>

                {{-- ── CASH OUTFLOWS ── --}}
                <tr class="section-row"><td colspan="7">Cash Outflows</td></tr>

                @foreach($data['budget_data'] as $row)
                @if($row->Nature !== 'Income' && ($row->m2_budget > 0 || $row->m1_budget > 0))
                @php
                    $v2 = expenseVar($row->m2_budget, $row->m2_actual);
                    $v1 = expenseVar($row->m1_budget, $row->m1_actual);
                @endphp
                <tr>
                    <td>{{ $row->Description }}</td>
                    <td>{{ fmt($row->m2_budget) }}</td>
                    <td>{{ fmt($row->m2_actual) }}</td>
                    <td class="{{ varClass($v2) }}">{{ varIcon($v2) }} {{ fmt(abs($v2)) }}</td>
                    <td>{{ fmt($row->m1_budget) }}</td>
                    <td>{{ fmt($row->m1_actual) }}</td>
                    <td class="{{ varClass($v1) }}">{{ varIcon($v1) }} {{ fmt(abs($v1)) }}</td>
                </tr>
                @endif
                @endforeach

                @php
                    $m2ExpVar = expenseVar($data['m2_expense_budget'], $data['m2_expense_actual']);
                    $m1ExpVar = expenseVar($data['m1_expense_budget'], $data['m1_expense_actual']);
                @endphp
                <tr class="total-row">
                    <td>Total Cash Outflows</td>
                    <td>{{ fmt($data['m2_expense_budget']) }}</td>
                    <td>{{ fmt($data['m2_expense_actual']) }}</td>
                    <td class="{{ varClass($m2ExpVar) }}">{{ varIcon($m2ExpVar) }} {{ fmt(abs($m2ExpVar)) }}</td>
                    <td>{{ fmt($data['m1_expense_budget']) }}</td>
                    <td>{{ fmt($data['m1_expense_actual']) }}</td>
                    <td class="{{ varClass($m1ExpVar) }}">{{ varIcon($m1ExpVar) }} {{ fmt(abs($m1ExpVar)) }}</td>
                </tr>

                {{-- spacer --}}
                <tr><td colspan="7" style="padding:4px;border:none;background:#fff;"></td></tr>

                {{-- ── NET CASH FLOW ── --}}
                <tr class="net-row">
                    <td style="color:#1d4ed8;">Net Cash Flow</td>
                    <td>{{ fmt($data['m2_net_budget']) }}</td>
                    <td>{{ fmt($data['m2_net_actual']) }}</td>
                    <td></td>
                    <td>{{ fmt($data['m1_net_budget']) }}</td>
                    <td>{{ fmt($data['m1_net_actual']) }}</td>
                    <td></td>
                </tr>

                {{-- ── BALANCES ── --}}
                <tr class="grand-row">
                    <td>Opening Balance</td>
                    <td colspan="3" style="color:#475569;">—</td>
                    <td colspan="3">{{ fmt($data['opening_balance']) }}</td>
                </tr>
                <tr class="grand-row" style="border-top:1px solid #bfdbfe;">
                    <td>Projected Closing Balance</td>
                    <td colspan="3" style="color:#475569;">—</td>
                    @php $cb = $data['closing_balance']; @endphp
                    <td colspan="3" style="color:{{ $cb >= 0 ? '#059669' : '#dc2626' }};">
                        {{ fmt($cb) }}
                        <span style="font-size:.72rem;font-weight:500;"> (Opening + Net budget)</span>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

{{-- ── Variance legend ── --}}
<div style="font-size:.75rem;color:#94a3b8;margin-top:-10px;padding:0 4px;">
    <span class="text-success">▲ Green variance</span> = Income exceeded / Expenses underspent (favourable) &nbsp;·&nbsp;
    <span class="text-danger">▼ Red variance</span> = Income shortfall / Expenses overspent (unfavourable)
</div>

@endsection
