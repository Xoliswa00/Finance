@extends('layouts.Nav')

@section('title', 'Balance Sheet')
@section('page-title', 'Balance Sheet')

@section('breadcrumb')
<li class="breadcrumb-item">Reports</li>
<li class="breadcrumb-item active">Balance Sheet</li>
@endsection

@section('head')
<style>
    .bs-section { background:#fff; border-radius:16px; border:1px solid #e2e8f0; margin-bottom:16px; overflow:hidden; }
    .bs-section-head {
        padding:10px 20px; font-size:.72rem; font-weight:700;
        text-transform:uppercase; letter-spacing:.08em; color:#fff;
        display:flex; align-items:center; gap:8px;
    }
    .bs-table { width:100%; border-collapse:collapse; font-size:.84rem; }
    .bs-table th {
        font-size:.68rem; font-weight:700; text-transform:uppercase;
        letter-spacing:.06em; color:#94a3b8; padding:9px 20px;
        background:#f8fafc; border-bottom:1px solid #e2e8f0;
        text-align:right;
    }
    .bs-table th:first-child { text-align:left; }
    .bs-table td { padding:9px 20px; border-bottom:1px solid #f8fafc; color:#334155; text-align:right; }
    .bs-table td:first-child { text-align:left; }
    .bs-table tr:last-child td { border-bottom:none; }
    .bs-table .nature-row td { background:#f8fafc; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; padding:7px 20px; }
    .bs-table .subtotal-row td { font-weight:700; color:#0f172a; border-top:1px solid #e2e8f0; background:#f8fafc; }
    .bs-table .grand-row td { font-weight:800; font-size:.9rem; border-top:2px solid #334155; }
    .bs-link { color:#1d4ed8; text-decoration:none; font-weight:500; }
    .bs-link:hover { text-decoration:underline; }
    .check-ok   { color:#059669; font-weight:700; }
    .check-fail { color:#dc2626; font-weight:700; }

    .eq-check {
        border-radius:12px; padding:16px 20px;
        display:flex; align-items:center; gap:12px;
        margin-top:4px;
    }
    .eq-check.ok   { background:#f0fdf4; border:1px solid #bbf7d0; }
    .eq-check.fail { background:#fef2f2; border:1px solid #fecaca; }
</style>
@endsection

@section('content')

@php
    // Group balances by Nature
    $grouped = $balances->groupBy('Nature');

    // Section definitions: label, natures included, header colour
    $assetSections = [
        ['label' => 'Non-Current Assets', 'natures' => ['Non-Current Assets']],
        ['label' => 'Current Assets',     'natures' => ['Current Assets']],
    ];
    $equitySections = [
        ['label' => 'Capital',   'natures' => ['Capital']],
        ['label' => 'Drawings',  'natures' => ['Drawings']],
    ];
    $liabilitySections = [
        ['label' => 'Non-Current Liabilities', 'natures' => ['Non-Current Liabilities']],
        ['label' => 'Current Liabilities',     'natures' => ['Current Liabilities']],
    ];

    $fmt = fn($n) => 'R ' . number_format($n, 2, '.', ',');

    // Total assets, equity, liabilities
    $totalAssets     = 0;
    $totalEquity     = 0;
    $totalLiabilities = 0;

    foreach ($grouped as $nature => $rows) {
        $sum = $rows->sum('Current') + $rows->sum('LastMonth');
        if (in_array($nature, ['Non-Current Assets','Current Assets']))
            $totalAssets += $sum;
        elseif (in_array($nature, ['Capital','Drawings']))
            $totalEquity += $sum;
        elseif (in_array($nature, ['Non-Current Liabilities','Current Liabilities']))
            $totalLiabilities += $sum;
    }

    $balanced = abs($totalAssets - ($totalEquity + $totalLiabilities)) < 0.01;
@endphp

{{-- ── ASSETS ── --}}
<div class="bs-section">
    <div class="bs-section-head" style="background:linear-gradient(135deg,#1e3a8a,#1d4ed8);">
        <i class="material-icons-round" style="font-size:1rem;">account_balance</i>
        Assets
    </div>
    <table class="bs-table">
        <thead>
            <tr>
                <th>Account</th>
                <th>{{ $lastMonth }}</th>
                <th>{{ $currentMonth }}</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @php $assetTotal = 0; @endphp
        @foreach($assetSections as $sec)
            @php $rows = collect(); foreach($sec['natures'] as $n) { $rows = $rows->merge($grouped[$n] ?? []); } @endphp
            @if($rows->isNotEmpty())
            <tr class="nature-row"><td colspan="5">{{ $sec['label'] }}</td></tr>
            @foreach($rows as $row)
            @php
                $rowTotal = $row->LastMonth + $row->Current;
                $assetTotal += $rowTotal;
            @endphp
            <tr>
                <td>
                    <a href="{{ route('T-Balance', $row->id) }}" class="bs-link">{{ $row->category }}</a>
                </td>
                <td>{{ $fmt($row->LastMonth) }}</td>
                <td>{{ $fmt($row->Current) }}</td>
                <td>{{ $fmt($rowTotal) }}</td>
                <td style="width:32px;"></td>
            </tr>
            @endforeach
            @endif
        @endforeach
        <tr class="grand-row">
            <td>Total Assets</td>
            <td></td>
            <td></td>
            <td>{{ $fmt($assetTotal) }}</td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>

{{-- ── EQUITY ── --}}
<div class="bs-section">
    <div class="bs-section-head" style="background:linear-gradient(135deg,#5b21b6,#7c3aed);">
        <i class="material-icons-round" style="font-size:1rem;">account_balance_wallet</i>
        Equity
    </div>
    <table class="bs-table">
        <thead>
            <tr>
                <th>Account</th>
                <th>{{ $lastMonth }}</th>
                <th>{{ $currentMonth }}</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @php $equityTotal = 0; @endphp
        @foreach($equitySections as $sec)
            @php $rows = collect(); foreach($sec['natures'] as $n) { $rows = $rows->merge($grouped[$n] ?? []); } @endphp
            @if($rows->isNotEmpty())
            <tr class="nature-row"><td colspan="5">{{ $sec['label'] }}</td></tr>
            @foreach($rows as $row)
            @php $rowTotal = $row->LastMonth + $row->Current; $equityTotal += $rowTotal; @endphp
            <tr>
                <td><a href="{{ route('T-Balance', $row->id) }}" class="bs-link">{{ $row->category }}</a></td>
                <td>{{ $fmt($row->LastMonth) }}</td>
                <td>{{ $fmt($row->Current) }}</td>
                <td>{{ $fmt($rowTotal) }}</td>
                <td></td>
            </tr>
            @endforeach
            @endif
        @endforeach
        <tr class="grand-row">
            <td>Total Equity</td>
            <td></td>
            <td></td>
            <td>{{ $fmt($equityTotal) }}</td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>

{{-- ── LIABILITIES ── --}}
<div class="bs-section">
    <div class="bs-section-head" style="background:linear-gradient(135deg,#b45309,#d97706);">
        <i class="material-icons-round" style="font-size:1rem;">credit_card</i>
        Liabilities
    </div>
    <table class="bs-table">
        <thead>
            <tr>
                <th>Account</th>
                <th>{{ $lastMonth }}</th>
                <th>{{ $currentMonth }}</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @php $liabilityTotal = 0; @endphp
        @foreach($liabilitySections as $sec)
            @php $rows = collect(); foreach($sec['natures'] as $n) { $rows = $rows->merge($grouped[$n] ?? []); } @endphp
            @if($rows->isNotEmpty())
            <tr class="nature-row"><td colspan="5">{{ $sec['label'] }}</td></tr>
            @foreach($rows as $row)
            @php $rowTotal = $row->LastMonth + $row->Current; $liabilityTotal += $rowTotal; @endphp
            <tr>
                <td><a href="{{ route('T-Balance', $row->id) }}" class="bs-link">{{ $row->category }}</a></td>
                <td>{{ $fmt($row->LastMonth) }}</td>
                <td>{{ $fmt($row->Current) }}</td>
                <td>{{ $fmt($rowTotal) }}</td>
                <td></td>
            </tr>
            @endforeach
            @endif
        @endforeach
        <tr class="grand-row">
            <td>Total Liabilities</td>
            <td></td>
            <td></td>
            <td>{{ $fmt($liabilityTotal) }}</td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>

{{-- ── ACCOUNTING EQUATION CHECK ── --}}
<div class="eq-check {{ $balanced ? 'ok' : 'fail' }}">
    <i class="material-icons-round" style="font-size:1.4rem;{{ $balanced ? 'color:#059669' : 'color:#dc2626' }};">
        {{ $balanced ? 'check_circle' : 'warning' }}
    </i>
    <div>
        <div style="font-size:.85rem;font-weight:700;{{ $balanced ? 'color:#166534' : 'color:#991b1b' }};">
            Assets {{ $balanced ? '=' : '≠' }} Equity + Liabilities
        </div>
        <div style="font-size:.78rem;color:#64748b;margin-top:2px;">
            Assets: {{ $fmt($assetTotal) }} &nbsp;·&nbsp;
            Equity + Liabilities: {{ $fmt($equityTotal + $liabilityTotal) }}
            @if(!$balanced)
            &nbsp;·&nbsp; <span style="color:#dc2626;">Difference: {{ $fmt(abs($assetTotal - ($equityTotal + $liabilityTotal))) }}</span>
            @endif
        </div>
    </div>
</div>

@if($balances->isEmpty())
<div class="card text-center py-5 mt-3" style="border-radius:16px;border:1px solid #e2e8f0;">
    <i class="material-icons-round" style="font-size:3rem;color:#cbd5e1;">balance</i>
    <h5 class="mt-3 mb-1" style="font-weight:700;color:#334155;">No balances yet</h5>
    <p style="font-size:.88rem;color:#94a3b8;max-width:380px;margin:8px auto 0;">
        Category balances are updated automatically as you record transactions. Add some transactions to see your balance sheet.
    </p>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mt-3" style="border-radius:10px;">Add a Transaction</a>
</div>
@endif

@endsection
