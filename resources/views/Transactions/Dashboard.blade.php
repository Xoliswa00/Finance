@extends('layouts.Nav')

@section('title', 'Transactions')
@section('page-title', 'Recent Transactions')

@section('breadcrumb')
<li class="breadcrumb-item active">Transactions</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        All your income and expenses from the current month
    </p>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary" style="border-radius:10px;font-weight:600;font-size:.88rem;">
        <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">add</i> New Transaction
    </a>
</div>

@if($transactions->isEmpty())
<div class="card text-center py-5" style="border-radius:16px;border:1px solid #e2e8f0;">
    <i class="material-icons-round" style="font-size:3rem;color:#cbd5e1;">swap_horiz</i>
    <h5 class="mt-3 mb-1" style="font-weight:700;color:#334155;">No transactions this month</h5>
    <p style="font-size:.88rem;color:#94a3b8;max-width:380px;margin:8px auto 0;">
        Record income, expenses, and transfers — all transactions appear here.
    </p>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mt-3" style="border-radius:10px;">Add transaction</a>
</div>
@else

<div class="card mb-3" style="border-radius:14px;border:1px solid #e2e8f0;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
        <h6 style="font-weight:700;color:#0f172a;margin:0;font-size:.88rem;">
            <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">expand_less</i> Income & Receipts
        </h6>
    </div>
    <div class="card-body p-0">
        @php $hasIncome = false; @endphp
        @foreach($transactions as $tran)
        @if((date('M', strtotime($tran->bill_date)) == date('M') && date('Y', strtotime($tran->bill_date)) == date('Y')) && ($tran->Action == 'Received' || $tran->Action == 'Earned'))
        @php $hasIncome = true; @endphp
        <div style="padding:12px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;justify-content:space-between;gap:12px;">
            <div style="display:flex;align-items:center;gap:10px;min-width:0;">
                <div style="width:36px;height:36px;border-radius:50%;background:#f0fdf4;display:flex;align-items:center;justify-content:center;color:#16a34a;flex-shrink:0;">
                    <i class="material-icons-round" style="font-size:.95rem;">expand_less</i>
                </div>
                <div style="min-width:0;">
                    <div style="font-weight:600;color:#0f172a;font-size:.88rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $tran->Description }}</div>
                    <div style="font-size:.74rem;color:#94a3b8;">{{ $tran->bill_date }}</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                <span style="font-weight:700;color:#16a34a;white-space:nowrap;">
                    + ZAR {{ number_format($tran->Amount, 2) }}
                </span>
                <form action="{{ route('transactions.destroy', $tran->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:6px;font-size:.7rem;padding:2px 8px;"
                            onclick="return confirm('Delete this transaction?')">
                        <i class="material-icons-round" style="font-size:.7rem;">delete</i>
                    </button>
                </form>
            </div>
        </div>
        @endif
        @endforeach
        @if(!$hasIncome)
        <div style="padding:24px 20px;text-align:center;color:#94a3b8;font-size:.85rem;">No income recorded</div>
        @endif
    </div>
</div>

<div class="card" style="border-radius:14px;border:1px solid #e2e8f0;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
        <h6 style="font-weight:700;color:#0f172a;margin:0;font-size:.88rem;">
            <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">expand_more</i> Expenses & Payments
        </h6>
    </div>
    <div class="card-body p-0">
        @php $hasExpense = false; @endphp
        @foreach($transactions as $tran)
        @if((date('M', strtotime($tran->bill_date)) == date('M') && date('Y', strtotime($tran->bill_date)) == date('Y')) && ($tran->Action == 'Paid' || $tran->Action == 'Bought'))
        @php $hasExpense = true; @endphp
        <div style="padding:12px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;justify-content:space-between;gap:12px;">
            <div style="display:flex;align-items:center;gap:10px;min-width:0;">
                <div style="width:36px;height:36px;border-radius:50%;background:#fff1f2;display:flex;align-items:center;justify-content:center;color:#dc2626;flex-shrink:0;">
                    <i class="material-icons-round" style="font-size:.95rem;">expand_more</i>
                </div>
                <div style="min-width:0;">
                    <div style="font-weight:600;color:#0f172a;font-size:.88rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $tran->Description }}</div>
                    <div style="font-size:.74rem;color:#94a3b8;">{{ $tran->bill_date }}</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                <span style="font-weight:700;color:#dc2626;white-space:nowrap;">
                    - ZAR {{ number_format($tran->Amount, 2) }}
                </span>
                <form action="{{ route('transactions.destroy', $tran->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:6px;font-size:.7rem;padding:2px 8px;"
                            onclick="return confirm('Delete this transaction?')">
                        <i class="material-icons-round" style="font-size:.7rem;">delete</i>
                    </button>
                </form>
            </div>
        </div>
        @endif
        @endforeach
        @if(!$hasExpense)
        <div style="padding:24px 20px;text-align:center;color:#94a3b8;font-size:.85rem;">No expenses recorded</div>
        @endif
    </div>
</div>

<div class="mt-3">{{ $transactions->links() }}</div>
@endif
@endsection
