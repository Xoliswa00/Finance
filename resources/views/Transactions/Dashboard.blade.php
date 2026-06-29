@extends('layouts.Nav')

@section('title', 'Transactions')
@section('page-title', 'All Transactions')

@section('breadcrumb')
<span>/</span> <span>Transactions</span>
@endsection

@section('content')

{{-- ── Toolbar: FY filter + actions ────────────────────────────────────────── --}}
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;">

    {{-- FY label + picker --}}
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <span style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;">Financial Year</span>
        @if($userFys->isNotEmpty())
        <form method="GET" action="{{ route('transactions.list') }}" style="margin:0;">
            <select name="fy" onchange="this.form.submit()"
                style="font-size:.82rem;font-weight:600;padding:5px 10px;border-radius:8px;border:1px solid #e2e8f0;background:#fff;color:#0f172a;cursor:pointer;outline:none;">
                @foreach($userFys as $fy)
                    @php
                        $fyNum = (int) substr($fy->label, 2);
                        $fyStart = \Carbon\Carbon::create($fyNum - 1, 7, 1)->format('M Y');
                        $fyEnd   = \Carbon\Carbon::create($fyNum, 6, 30)->format('M Y');
                    @endphp
                    <option value="{{ $fyNum }}" {{ $selectedFy == $fyNum ? 'selected' : '' }}>
                        {{ $fy->label }} ({{ $fyStart }} – {{ $fyEnd }})
                        {{ $fy->status === 'active' ? '· Active' : '· Closed' }}
                    </option>
                @endforeach
            </select>
        </form>
        @else
        <span style="font-size:.82rem;color:#94a3b8;">
            FY{{ $selectedFy ?? '—' }}
            <span style="font-size:.72rem;margin-left:6px;color:#cbd5e1;">(run <code>php artisan fy:rollover --seed</code> to initialise)</span>
        </span>
        @endif
    </div>

    <a href="{{ route('transactions.create') }}"
       style="font-size:.82rem;font-weight:600;padding:7px 16px;background:#1d4ed8;color:#fff;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
        <i class="material-icons-round" style="font-size:.9rem;vertical-align:middle;">add</i> New Transaction
    </a>
</div>

@if($transactions->isEmpty())
<div class="card text-center py-5" style="border-radius:16px;border:1px solid #e2e8f0;">
    <i class="material-icons-round" style="font-size:3rem;color:#cbd5e1;">swap_horiz</i>
    <h5 class="mt-3 mb-1" style="font-weight:700;color:#334155;">No transactions for FY{{ $selectedFy }}</h5>
    <p style="font-size:.88rem;color:#94a3b8;max-width:380px;margin:8px auto 0;">
        Record income, expenses, and transfers — all transactions appear here.
    </p>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mt-3" style="border-radius:10px;">Add transaction</a>
</div>
@else

@php
    $income   = $transactions->filter(fn($t) => in_array($t->Action, ['Received', 'Earned']));
    $expenses = $transactions->filter(fn($t) => in_array($t->Action, ['Paid', 'Bought']));
    $totalIn  = $income->sum(fn($t)   => $t->Amount ?? $t->amount ?? 0);
    $totalOut = $expenses->sum(fn($t)  => $t->Amount ?? $t->amount ?? 0);
@endphp

{{-- ── FY Summary strip ─────────────────────────────────────────────────────── --}}
<div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
    <div style="flex:1;min-width:150px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px 18px;">
        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#16a34a;margin-bottom:4px;">Total Income</div>
        <div style="font-size:1.15rem;font-weight:800;color:#15803d;">+ ZAR {{ number_format($totalIn, 2) }}</div>
    </div>
    <div style="flex:1;min-width:150px;background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:14px 18px;">
        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#dc2626;margin-bottom:4px;">Total Expenses</div>
        <div style="font-size:1.15rem;font-weight:800;color:#b91c1c;">− ZAR {{ number_format($totalOut, 2) }}</div>
    </div>
    <div style="flex:1;min-width:150px;background:{{ $totalIn - $totalOut >= 0 ? '#eff6ff' : '#fff7ed' }};border:1px solid {{ $totalIn - $totalOut >= 0 ? '#bfdbfe' : '#fed7aa' }};border-radius:12px;padding:14px 18px;">
        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:{{ $totalIn - $totalOut >= 0 ? '#1d4ed8' : '#ea580c' }};margin-bottom:4px;">Net</div>
        <div style="font-size:1.15rem;font-weight:800;color:{{ $totalIn - $totalOut >= 0 ? '#1e40af' : '#c2410c' }};">
            {{ $totalIn - $totalOut >= 0 ? '+' : '−' }} ZAR {{ number_format(abs($totalIn - $totalOut), 2) }}
        </div>
    </div>
</div>

{{-- ── Income ────────────────────────────────────────────────────────────────── --}}
<div class="card mb-4" style="border-radius:14px;border:1px solid #e2e8f0;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;">
        <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;flex-shrink:0;"></span>
        <h6 style="font-weight:700;color:#0f172a;margin:0;font-size:.88rem;">Income &amp; Receipts</h6>
        <span style="margin-left:auto;font-size:.78rem;font-weight:600;color:#16a34a;">{{ $income->count() }} entries</span>
    </div>
    <div class="card-body p-0">
        @forelse($income as $tran)
        <div style="padding:11px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;justify-content:space-between;gap:12px;">
            <div style="display:flex;align-items:center;gap:10px;min-width:0;">
                <div style="width:34px;height:34px;border-radius:50%;background:#f0fdf4;display:flex;align-items:center;justify-content:center;color:#16a34a;flex-shrink:0;">
                    <i class="material-icons-round" style="font-size:.9rem;">arrow_downward</i>
                </div>
                <div style="min-width:0;">
                    <div style="font-weight:600;color:#0f172a;font-size:.86rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:340px;">
                        {{ $tran->Description ?? $tran->description ?? '—' }}
                    </div>
                    <div style="font-size:.73rem;color:#94a3b8;">
                        {{ \Carbon\Carbon::parse($tran->bill_date)->format('d M Y') }}
                        &nbsp;·&nbsp; {{ $tran->Action }}
                        &nbsp;·&nbsp; FY{{ $tran->FY ?? '—' }}
                    </div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                <span style="font-weight:700;color:#16a34a;white-space:nowrap;font-size:.88rem;">
                    + ZAR {{ number_format($tran->Amount ?? $tran->amount, 2) }}
                </span>
                <a href="{{ route('transactions.edit', $tran->id) }}"
                   style="color:#94a3b8;text-decoration:none;" title="Edit">
                    <i class="material-icons-round" style="font-size:.9rem;">edit</i>
                </a>
                <form action="{{ route('transactions.destroy', $tran->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit"
                        style="background:none;border:none;color:#fca5a5;cursor:pointer;padding:0;"
                        onclick="return confirm('Delete this transaction?')" title="Delete">
                        <i class="material-icons-round" style="font-size:.9rem;">delete_outline</i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="padding:24px 20px;text-align:center;color:#94a3b8;font-size:.85rem;">No income recorded for this period</div>
        @endforelse
    </div>
</div>

{{-- ── Expenses ──────────────────────────────────────────────────────────────── --}}
<div class="card mb-4" style="border-radius:14px;border:1px solid #e2e8f0;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;">
        <span style="width:8px;height:8px;border-radius:50%;background:#ef4444;flex-shrink:0;"></span>
        <h6 style="font-weight:700;color:#0f172a;margin:0;font-size:.88rem;">Expenses &amp; Payments</h6>
        <span style="margin-left:auto;font-size:.78rem;font-weight:600;color:#dc2626;">{{ $expenses->count() }} entries</span>
    </div>
    <div class="card-body p-0">
        @forelse($expenses as $tran)
        <div style="padding:11px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;justify-content:space-between;gap:12px;">
            <div style="display:flex;align-items:center;gap:10px;min-width:0;">
                <div style="width:34px;height:34px;border-radius:50%;background:#fff1f2;display:flex;align-items:center;justify-content:center;color:#dc2626;flex-shrink:0;">
                    <i class="material-icons-round" style="font-size:.9rem;">arrow_upward</i>
                </div>
                <div style="min-width:0;">
                    <div style="font-weight:600;color:#0f172a;font-size:.86rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:340px;">
                        {{ $tran->Description ?? $tran->description ?? '—' }}
                    </div>
                    <div style="font-size:.73rem;color:#94a3b8;">
                        {{ \Carbon\Carbon::parse($tran->bill_date)->format('d M Y') }}
                        &nbsp;·&nbsp; {{ $tran->Action }}
                        &nbsp;·&nbsp; FY{{ $tran->FY ?? '—' }}
                    </div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                <span style="font-weight:700;color:#dc2626;white-space:nowrap;font-size:.88rem;">
                    − ZAR {{ number_format($tran->Amount ?? $tran->amount, 2) }}
                </span>
                <a href="{{ route('transactions.edit', $tran->id) }}"
                   style="color:#94a3b8;text-decoration:none;" title="Edit">
                    <i class="material-icons-round" style="font-size:.9rem;">edit</i>
                </a>
                <form action="{{ route('transactions.destroy', $tran->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit"
                        style="background:none;border:none;color:#fca5a5;cursor:pointer;padding:0;"
                        onclick="return confirm('Delete this transaction?')" title="Delete">
                        <i class="material-icons-round" style="font-size:.9rem;">delete_outline</i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="padding:24px 20px;text-align:center;color:#94a3b8;font-size:.85rem;">No expenses recorded for this period</div>
        @endforelse
    </div>
</div>

<div class="mt-2">{{ $transactions->links() }}</div>
@endif
@endsection
