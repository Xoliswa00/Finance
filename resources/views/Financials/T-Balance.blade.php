@extends('layouts.Nav')

@section('title', $account->category . ' — T-Account')
@section('page-title', $account->category . ' — T-Account')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('Balancesheet') }}">Balance Sheet</a></li>
<li class="breadcrumb-item active">T-Account</li>
@endsection

@section('head')
<style>
    .t-wrap {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border: 2px solid #334155;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }
    .t-side { overflow-x: auto; }
    .t-side:first-child { border-right: 2px solid #334155; }

    .t-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 16px;
        font-size: .8rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: .1em;
    }
    .t-header.dr { background: #f0fdf4; color: #166534; border-bottom: 1px solid #bbf7d0; }
    .t-header.cr { background: #fef2f2; color: #991b1b; border-bottom: 1px solid #fecaca; }

    .t-table { width: 100%; border-collapse: collapse; font-size: .83rem; }
    .t-table th {
        font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
        color: #94a3b8; padding: 8px 14px; background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .t-table td { padding: 8px 14px; border-bottom: 1px solid #f8fafc; color: #334155; vertical-align: middle; }
    .t-table tr:last-child td { border-bottom: none; }

    .t-table .cd-row td { font-style: italic; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    .t-table .total-row td { font-weight: 800; border-top: 2px solid #334155; background: #f8fafc; color: #0f172a; }
    .t-table .bd-row td { font-weight: 700; color: #1d4ed8; background: #eff6ff; }

    .account-meta {
        background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
        color: #fff; border-radius: 14px;
        padding: 20px 24px; margin-bottom: 24px;
    }
    .meta-name   { font-size: 1.3rem; font-weight: 800; margin-bottom: 2px; }
    .meta-nature { font-size: .78rem; opacity: .75; }
    .meta-balance-label { font-size: .7rem; opacity: .65; text-transform: uppercase; letter-spacing: .08em; margin-top: 8px; }
    .meta-balance-val   { font-size: 1.5rem; font-weight: 800; }

    .empty-side {
        padding: 32px 16px; text-align: center;
        color: #94a3b8; font-size: .84rem;
    }

    @media (max-width: 640px) {
        .t-wrap { grid-template-columns: 1fr; }
        .t-side:first-child { border-right: none; border-bottom: 2px solid #334155; }
    }
</style>
@endsection

@section('content')

{{-- ── Account Header ── --}}
<div class="account-meta">
    <div class="row align-items-center">
        <div class="col">
            <div class="meta-name">{{ $account->category }}</div>
            <div class="meta-nature">{{ $account->Nature }}</div>
        </div>
        <div class="col-auto text-end">
            <div class="meta-balance-label">Current Balance</div>
            <div class="meta-balance-val">R {{ number_format($account->Balance ?? 0, 2, '.', ',') }}</div>
            <div class="meta-nature">Balance: {{ $balanceSide }}</div>
        </div>
    </div>
</div>

@if($result->isEmpty())
<div class="card text-center py-5" style="border-radius:16px;border:1px solid #e2e8f0;">
    <i class="material-icons-round" style="font-size:3rem;color:#cbd5e1;">receipt_long</i>
    <h5 class="mt-3 mb-1" style="font-weight:700;color:#334155;">No journal entries found</h5>
    <p style="font-size:.88rem;color:#94a3b8;max-width:380px;margin:8px auto 0;">
        No journal entries have been recorded for this account yet. Entries are created automatically when you add transactions.
    </p>
    <a href="{{ route('Balancesheet') }}" class="btn btn-outline-primary mt-3" style="border-radius:10px;">← Back to Balance Sheet</a>
</div>
@else

{{-- ── T-Account ── --}}
@php
    $drEntries = $result->where('Effect', 'Dr');
    $crEntries = $result->where('Effect', 'Cr');
@endphp

<div class="t-wrap">

    {{-- ── DR SIDE ── --}}
    <div class="t-side">
        <div class="t-header dr">
            <span>Dr</span>
            <span>R {{ number_format($totalDr, 2, '.', ',') }}</span>
        </div>
        <table class="t-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Contra</th>
                    <th>Description</th>
                    <th style="text-align:right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drEntries as $entry)
                <tr>
                    <td style="white-space:nowrap;">{{ \Carbon\Carbon::parse($entry->bill_date ?? $entry->entry_date)->format('d M Y') }}</td>
                    <td style="color:#64748b;font-size:.78rem;">{{ $entry->ContraAccount ?? $entry->Action }}</td>
                    <td style="max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $entry->Description }}">{{ $entry->Description }}</td>
                    <td style="text-align:right;font-weight:600;color:#166534;">R {{ number_format($entry->Amount, 2, '.', ',') }}</td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="empty-side">No debit entries</div></td></tr>
                @endforelse

                {{-- Balance c/d on Dr side (only if balance is on Cr) --}}
                @if($cd['side'] === 'Dr' && $cd['amount'] > 0)
                <tr class="cd-row">
                    <td></td>
                    <td>Balance</td>
                    <td>c/d</td>
                    <td style="text-align:right;">R {{ number_format($cd['amount'], 2, '.', ',') }}</td>
                </tr>
                @endif

                <tr class="total-row">
                    <td></td><td></td><td></td>
                    <td style="text-align:right;">R {{ number_format($runningTotal, 2, '.', ',') }}</td>
                </tr>

                {{-- Balance b/d on Dr side (only if balance is on Dr = debit balance) --}}
                @if($bd['side'] === 'Dr' && $bd['amount'] > 0)
                <tr class="bd-row">
                    <td style="white-space:nowrap;">{{ now()->format('d M Y') }}</td>
                    <td>Balance</td>
                    <td>b/d</td>
                    <td style="text-align:right;">R {{ number_format($bd['amount'], 2, '.', ',') }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- ── CR SIDE ── --}}
    <div class="t-side">
        <div class="t-header cr">
            <span>Cr</span>
            <span>R {{ number_format($totalCr, 2, '.', ',') }}</span>
        </div>
        <table class="t-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Contra</th>
                    <th>Description</th>
                    <th style="text-align:right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($crEntries as $entry)
                <tr>
                    <td style="white-space:nowrap;">{{ \Carbon\Carbon::parse($entry->bill_date ?? $entry->entry_date)->format('d M Y') }}</td>
                    <td style="color:#64748b;font-size:.78rem;">{{ $entry->ContraAccount ?? $entry->Action }}</td>
                    <td style="max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $entry->Description }}">{{ $entry->Description }}</td>
                    <td style="text-align:right;font-weight:600;color:#991b1b;">R {{ number_format($entry->Amount, 2, '.', ',') }}</td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="empty-side">No credit entries</div></td></tr>
                @endforelse

                {{-- Balance c/d on Cr side (only if balance is on Dr) --}}
                @if($cd['side'] === 'Cr' && $cd['amount'] > 0)
                <tr class="cd-row">
                    <td></td>
                    <td>Balance</td>
                    <td>c/d</td>
                    <td style="text-align:right;">R {{ number_format($cd['amount'], 2, '.', ',') }}</td>
                </tr>
                @endif

                <tr class="total-row">
                    <td></td><td></td><td></td>
                    <td style="text-align:right;">R {{ number_format($runningTotal, 2, '.', ',') }}</td>
                </tr>

                {{-- Balance b/d on Cr side (only if balance is on Cr = credit balance) --}}
                @if($bd['side'] === 'Cr' && $bd['amount'] > 0)
                <tr class="bd-row">
                    <td style="white-space:nowrap;">{{ now()->format('d M Y') }}</td>
                    <td>Balance</td>
                    <td>b/d</td>
                    <td style="text-align:right;">R {{ number_format($bd['amount'], 2, '.', ',') }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>

{{-- ── Balance Summary ── --}}
<div class="row g-3 mt-3">
    <div class="col-12 col-md-4">
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px 18px;text-align:center;">
            <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#166534;margin-bottom:4px;">Total Debits</div>
            <div style="font-size:1.2rem;font-weight:800;color:#166534;">R {{ number_format($totalDr, 2, '.', ',') }}</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:14px 18px;text-align:center;">
            <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#991b1b;margin-bottom:4px;">Total Credits</div>
            <div style="font-size:1.2rem;font-weight:800;color:#991b1b;">R {{ number_format($totalCr, 2, '.', ',') }}</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:14px 18px;text-align:center;">
            <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#1e40af;margin-bottom:4px;">Balance ({{ $balanceSide }})</div>
            <div style="font-size:1.2rem;font-weight:800;color:#1d4ed8;">R {{ number_format($balanceAmt, 2, '.', ',') }}</div>
        </div>
    </div>
</div>

@endif

<div class="mt-3">
    <a href="{{ route('Balancesheet') }}" class="btn btn-outline-secondary" style="border-radius:10px;font-size:.85rem;">
        ← Back to Balance Sheet
    </a>
</div>

@endsection
