@extends('layouts.Nav')

@section('title', 'Transactions')
@section('page-title', 'Transactions')

@section('breadcrumb')
<span>/</span> <span>Transactions</span>
@endsection

@section('content')

{{-- ── Top stats row ──────────────────────────────────────────────────────── --}}
<div class="row mb-4">

    {{-- Bank Balance --}}
    <div class="col-6 col-lg-3 mb-3">
        <div class="card h-100" style="border-radius:14px;border:1px solid #e2e8f0;">
            <div class="card-body p-3">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                    <div style="width:36px;height:36px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                        <i class="material-icons-round" style="font-size:1.1rem;color:#1d4ed8;">account_balance</i>
                    </div>
                    <span style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;">Bank Balance</span>
                </div>
                <div style="font-size:1.3rem;font-weight:800;color:#0f172a;">
                    ZAR {{ $balance ? number_format($balance->Balance, 2) : '0.00' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Credit Card --}}
    <div class="col-6 col-lg-3 mb-3">
        <div class="card h-100" style="border-radius:14px;border:1px solid #e2e8f0;">
            <div class="card-body p-3">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                    <div style="width:36px;height:36px;border-radius:10px;background:#fdf4ff;display:flex;align-items:center;justify-content:center;">
                        <i class="material-icons-round" style="font-size:1.1rem;color:#9333ea;">credit_card</i>
                    </div>
                    <span style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;">Credit Card</span>
                </div>
                <div style="font-size:1.3rem;font-weight:800;color:#0f172a;">
                    ZAR {{ $CreditB ? number_format($CreditB->Balance, 2) : '0.00' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Primary Card --}}
    <div class="col-12 col-lg-6 mb-3">
        @if($main)
        <div class="card h-100" style="border-radius:14px;background:linear-gradient(135deg,#1e3a8a,#1d4ed8);border:none;overflow:hidden;position:relative;">
            <div class="card-body p-3" style="position:relative;z-index:1;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
                    <i class="material-icons-round" style="color:rgba(255,255,255,.6);font-size:1.3rem;">wifi</i>
                    <span style="font-size:.7rem;font-weight:700;color:rgba(255,255,255,.6);letter-spacing:.08em;text-transform:uppercase;">{{ $main->Type }}</span>
                </div>
                <div style="font-family:monospace;font-size:1rem;font-weight:700;color:#fff;letter-spacing:3px;margin-bottom:14px;">
                    {{ substr($main->CardNumber,0,4) }} •••• •••• {{ substr($main->CardNumber,-4) }}
                </div>
                <div style="display:flex;justify-content:space-between;align-items:flex-end;">
                    <div>
                        <div style="font-size:.62rem;color:rgba(255,255,255,.55);text-transform:uppercase;letter-spacing:.06em;">Cardholder</div>
                        <div style="font-size:.82rem;font-weight:600;color:#fff;">{{ $main->Cardholder }}</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:.62rem;color:rgba(255,255,255,.55);text-transform:uppercase;letter-spacing:.06em;">Expires</div>
                        <div style="font-size:.82rem;font-weight:600;color:#fff;">{{ $main->ExpiryDate }}</div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card h-100" style="border-radius:14px;border:1px dashed #cbd5e1;">
            <div class="card-body p-3" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;">
                <i class="material-icons-round" style="font-size:2rem;color:#cbd5e1;">credit_card_off</i>
                <p style="font-size:.82rem;color:#94a3b8;margin:0;">No debit card linked</p>
                <a href="{{ route('cards.create') }}" style="font-size:.78rem;font-weight:600;color:#1d4ed8;text-decoration:none;">Add a card</a>
            </div>
        </div>
        @endif
    </div>

</div>

{{-- ── Main content: pending budgets + transactions ───────────────────────── --}}
<div class="row">

    {{-- Pending Budgets ──────────────────────────────────────── --}}
    <div class="col-lg-4 mb-4">
        <div class="card h-100" style="border-radius:14px;border:1px solid #e2e8f0;">
            <div style="padding:14px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <h6 style="font-weight:700;color:#0f172a;margin:0;font-size:.9rem;">Pending Budgets</h6>
                <div style="display:flex;gap:6px;">
                    <a href="{{ route('budgets.Recurring') }}"
                       style="font-size:.72rem;font-weight:600;padding:4px 10px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:6px;text-decoration:none;"
                       title="Process recurring">
                        <i class="material-icons-round" style="font-size:.8rem;vertical-align:middle;">autorenew</i>
                    </a>
                    <a href="{{ route('budgets.create') }}"
                       style="font-size:.72rem;font-weight:600;padding:4px 10px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;border-radius:6px;text-decoration:none;">
                        <i class="material-icons-round" style="font-size:.8rem;vertical-align:middle;">add</i>
                    </a>
                    <a href="{{ route('budgets.index') }}"
                       style="font-size:.72rem;font-weight:600;padding:4px 10px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:6px;text-decoration:none;">
                        All
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @forelse($budgets as $budget)
                <div style="display:flex;align-items:center;gap:12px;padding:12px 18px;border-bottom:1px solid #f8fafc;">
                    <div style="width:36px;height:36px;border-radius:50%;background:#fff7ed;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                        <i class="material-icons-round" style="font-size:1rem;color:#f97316;">priority_high</i>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.84rem;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $budget->Description }}
                        </div>
                        <div style="font-size:.74rem;color:#94a3b8;">
                            {{ \Carbon\Carbon::parse($budget->due_date)->format('d M Y') }}
                            &nbsp;·&nbsp; ZAR {{ number_format($budget->Amount, 2) }}
                        </div>
                    </div>
                    <div style="display:flex;gap:4px;flex-shrink:0;">
                        <form action="{{ route('budgets.Finalized', $budget->id) }}" method="POST">
                            @csrf @method('PUT')
                            <button type="submit" title="Finalise"
                                style="width:30px;height:30px;border-radius:8px;border:1px solid #bbf7d0;background:#f0fdf4;color:#16a34a;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                                <i class="material-icons-round" style="font-size:.9rem;">check</i>
                            </button>
                        </form>
                        <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" title="Delete"
                                style="width:30px;height:30px;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;color:#dc2626;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                                <i class="material-icons-round" style="font-size:.9rem;">close</i>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div style="padding:32px 18px;text-align:center;">
                    <i class="material-icons-round" style="font-size:2rem;color:#cbd5e1;display:block;margin-bottom:8px;">task_alt</i>
                    <p style="font-size:.84rem;color:#94a3b8;margin:0;">No pending budgets</p>
                </div>
                @endforelse
            </div>
            @if($budgets->hasPages())
            <div style="padding:10px 18px;border-top:1px solid #f1f5f9;">
                {{ $budgets->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- Transactions ─────────────────────────────────────────── --}}
    <div class="col-lg-8 mb-4">
        <div class="card" style="border-radius:14px;border:1px solid #e2e8f0;">
            <div style="padding:14px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <h6 style="font-weight:700;color:#0f172a;margin:0;font-size:.9rem;">Recent Transactions</h6>
                <div style="display:flex;gap:6px;">
                    <a href="{{ route('transactions.create') }}"
                       style="font-size:.78rem;font-weight:600;padding:5px 12px;background:#1d4ed8;color:#fff;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
                        <i class="material-icons-round" style="font-size:.85rem;">add</i> New
                    </a>
                    <a href="{{ route('transactions.list') }}"
                       style="font-size:.78rem;font-weight:600;padding:5px 12px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:8px;text-decoration:none;">
                        View all
                    </a>
                </div>
            </div>

            {{-- Income --}}
            @php
                $income = $transactions->filter(fn($t) => in_array($t->Action, ['Received','Earned']));
                $expenses = $transactions->filter(fn($t) => in_array($t->Action, ['Paid','Bought']));
            @endphp

            @if($income->isNotEmpty())
            <div style="padding:10px 18px 4px;display:flex;align-items:center;gap:8px;">
                <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;flex-shrink:0;"></span>
                <span style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;">Income</span>
            </div>
            @foreach($income as $tran)
            <div style="display:flex;align-items:center;gap:12px;padding:10px 18px;border-bottom:1px solid #f8fafc;">
                <div style="width:36px;height:36px;border-radius:50%;background:#f0fdf4;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                    <i class="material-icons-round" style="font-size:1rem;color:#22c55e;">arrow_downward</i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:.84rem;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $tran->description ?? $tran->Description ?? '—' }}
                    </div>
                    <div style="font-size:.74rem;color:#94a3b8;">
                        {{ \Carbon\Carbon::parse($tran->bill_date)->format('d M Y') }}
                        &nbsp;·&nbsp; {{ $tran->Action }}
                    </div>
                </div>
                <div style="font-size:.88rem;font-weight:700;color:#16a34a;white-space:nowrap;">
                    + ZAR {{ number_format($tran->Amount ?? $tran->amount, 2) }}
                </div>
                <a href="{{ route('transactions.edit', $tran->id) }}"
                   style="color:#94a3b8;text-decoration:none;flex-shrink:0;"
                   title="Edit">
                    <i class="material-icons-round" style="font-size:1rem;">edit</i>
                </a>
            </div>
            @endforeach
            @endif

            @if($expenses->isNotEmpty())
            <div style="padding:10px 18px 4px;display:flex;align-items:center;gap:8px;">
                <span style="width:8px;height:8px;border-radius:50%;background:#ef4444;flex-shrink:0;"></span>
                <span style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;">Expenses</span>
            </div>
            @foreach($expenses as $tran)
            <div style="display:flex;align-items:center;gap:12px;padding:10px 18px;border-bottom:1px solid #f8fafc;">
                <div style="width:36px;height:36px;border-radius:50%;background:#fef2f2;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                    <i class="material-icons-round" style="font-size:1rem;color:#ef4444;">arrow_upward</i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:.84rem;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $tran->description ?? $tran->Description ?? '—' }}
                    </div>
                    <div style="font-size:.74rem;color:#94a3b8;">
                        {{ \Carbon\Carbon::parse($tran->bill_date)->format('d M Y') }}
                        &nbsp;·&nbsp; {{ $tran->Action }}
                    </div>
                </div>
                <div style="font-size:.88rem;font-weight:700;color:#dc2626;white-space:nowrap;">
                    − ZAR {{ number_format($tran->Amount ?? $tran->amount, 2) }}
                </div>
                <a href="{{ route('transactions.edit', $tran->id) }}"
                   style="color:#94a3b8;text-decoration:none;flex-shrink:0;"
                   title="Edit">
                    <i class="material-icons-round" style="font-size:1rem;">edit</i>
                </a>
            </div>
            @endforeach
            @endif

            @if($transactions->isEmpty())
            <div style="padding:48px 18px;text-align:center;">
                <i class="material-icons-round" style="font-size:2.5rem;color:#cbd5e1;display:block;margin-bottom:10px;">receipt_long</i>
                <p style="font-size:.88rem;color:#94a3b8;margin:0 0 12px;">No transactions yet</p>
                <a href="{{ route('transactions.create') }}"
                   style="font-size:.82rem;font-weight:600;color:#fff;background:#1d4ed8;border-radius:8px;padding:8px 18px;text-decoration:none;">
                    Add your first transaction
                </a>
            </div>
            @endif

            @if($transactions->hasPages())
            <div style="padding:12px 18px;border-top:1px solid #f1f5f9;">
                {{ $transactions->links() }}
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
