@extends('layouts.Nav')

@section('title', 'Budgets')
@section('page-title', 'Budget Management')

@section('breadcrumb')
<li class="breadcrumb-item active">Budgets</li>
@endsection

@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')

@if($CurrentB->isEmpty())
<div class="card text-center py-5" style="border-radius:16px;border:1px solid #e2e8f0;">
    <i class="material-icons-round" style="font-size:3rem;color:#cbd5e1;">account_balance_wallet</i>
    <h5 class="mt-3 mb-1" style="font-weight:700;color:#334155;">No budget items yet</h5>
    <p style="font-size:.88rem;color:#94a3b8;max-width:380px;margin:8px auto 0;">
        Start planning by adding budget items — set amounts for income and expenses.
    </p>
    <div class="mt-3 d-flex justify-content-center gap-2 flex-wrap">
        <a href="{{ route('budgets.create') }}" class="btn btn-primary" style="border-radius:10px;">Add Budget Item</a>
        <a href="{{ route('budgets.Recurring') }}" class="btn btn-outline-secondary" style="border-radius:10px;">Recurring Items</a>
    </div>
</div>
@else

{{-- ─── Action Bar ───────────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <p class="text-muted mb-0" style="font-size:.85rem;">Plan, track, and finalise your budget items each month.</p>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('budgets.Recurring') }}" class="btn btn-outline-secondary" style="border-radius:10px;font-size:.85rem;font-weight:600;">
            <i class="material-icons-round me-1" style="font-size:.9rem;vertical-align:middle;">repeat</i> Recurring Items
        </a>
        <a href="{{ route('budgets.create') }}" class="btn btn-primary" style="border-radius:10px;font-size:.85rem;font-weight:600;">
            <i class="material-icons-round me-1" style="font-size:.9rem;vertical-align:middle;">add</i> Add Budget Item
        </a>
    </div>
</div>

<div class="row mb-4">

    {{-- ─── Pending Items ──────────────────────────────────────────── --}}
    <div class="col-lg-6 mb-4">
        <div class="card h-100" style="border-radius:14px;border:1px solid #e2e8f0;">
            <div class="card-body p-0">
                <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-weight:700;color:#0f172a;font-size:.9rem;">Pending Items</span>
                    <span style="font-size:.74rem;background:#fef3c7;color:#92400e;border-radius:50px;padding:2px 10px;font-weight:600;">Planning</span>
                </div>
                @php $hasPending = false; @endphp
                @foreach($CurrentB as $budget)
                @if($budget->Status === 'Planning')
                @php $hasPending = true; @endphp
                <div style="padding:14px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                    <div style="min-width:0;">
                        <div style="font-weight:600;color:#0f172a;font-size:.88rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $budget->Description }}</div>
                        <div style="font-size:.75rem;color:#94a3b8;margin-top:2px;">
                            {{ $budget->due_date }} &nbsp;·&nbsp;
                            BA: ZAR {{ number_format($budget->Amount, 2) }} &nbsp;
                            <span title="Actual Amount">AA: ZAR {{ number_format($budget->Limit, 2) }}</span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:4px;flex-shrink:0;">
                        <a href="{{ route('budgets.edit', $budget->id) }}"
                           class="btn btn-sm btn-outline-secondary"
                           style="border-radius:7px;font-size:.74rem;padding:3px 10px;">Edit</a>
                        <form action="{{ route('budgets.Finalized', $budget->id) }}" method="POST" class="d-inline">
                            @csrf @method('PUT')
                            <button type="submit" class="btn btn-sm btn-outline-success"
                                    style="border-radius:7px;font-size:.74rem;padding:3px 10px;"
                                    title="Mark as Finalised">
                                <i class="material-icons-round" style="font-size:.8rem;vertical-align:middle;">check</i>
                            </button>
                        </form>
                        <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                    style="border-radius:7px;font-size:.74rem;padding:3px 10px;"
                                    onclick="return confirm('Delete this budget item?')">
                                <i class="material-icons-round" style="font-size:.8rem;vertical-align:middle;">delete</i>
                            </button>
                        </form>
                    </div>
                </div>
                @endif
                @endforeach
                @if(!$hasPending)
                <div style="padding:32px 20px;text-align:center;color:#94a3b8;font-size:.85rem;">No pending items</div>
                @endif
            </div>
        </div>
    </div>

    {{-- ─── Budget Summary Table ────────────────────────────────────── --}}
    <div class="col-lg-6 mb-4">
        <div class="card h-100" style="border-radius:14px;border:1px solid #e2e8f0;">
            <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;">
                <span style="font-weight:700;color:#0f172a;font-size:.9rem;">Monthly Summary</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0" style="font-size:.82rem;">
                        <thead>
                            <tr style="background:#f8fafc;">
                                <th style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:9px 16px;">Month</th>
                                <th style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:9px 16px;">Budg. Income</th>
                                <th style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:9px 16px;">Budg. Expense</th>
                                <th style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:9px 16px;">Diff.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totI=0; $totE=0; $totN=0; @endphp
                            @foreach($budgetData as $entry)
                            @php $totI+=$entry->income_budgeted; $totE+=$entry->expense_budgeted; $totN+=$entry->net_budgeted; @endphp
                            <tr style="border-color:#f8fafc;">
                                <td style="padding:9px 16px;color:#334155;border-color:#f8fafc;">{{ $entry->month }}</td>
                                <td style="padding:9px 16px;color:#16a34a;font-weight:600;border-color:#f8fafc;">{{ number_format($entry->income_budgeted,2) }}</td>
                                <td style="padding:9px 16px;color:#dc2626;font-weight:600;border-color:#f8fafc;">{{ number_format($entry->expense_budgeted,2) }}</td>
                                <td style="padding:9px 16px;font-weight:700;border-color:#f8fafc;color:{{ $entry->net_budgeted < 0 ? '#dc2626' : '#16a34a' }};">
                                    {{ number_format($entry->net_budgeted,2) }}
                                </td>
                            </tr>
                            @endforeach
                            <tr style="background:#f8fafc;font-weight:700;">
                                <td style="padding:9px 16px;color:#0f172a;border-color:#f1f5f9;">Totals</td>
                                <td style="padding:9px 16px;color:#16a34a;border-color:#f1f5f9;">{{ number_format($totI,2) }}</td>
                                <td style="padding:9px 16px;color:#dc2626;border-color:#f1f5f9;">{{ number_format($totE,2) }}</td>
                                <td style="padding:9px 16px;border-color:#f1f5f9;color:{{ $totN < 0 ? '#dc2626' : '#16a34a' }};">{{ number_format($totN,2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- ─── Finalised Items ─────────────────────────────────────────── --}}
    <div class="col-lg-6 mb-4">
        <div class="card h-100" style="border-radius:14px;border:1px solid #e2e8f0;">
            <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-weight:700;color:#0f172a;font-size:.9rem;">Finalised Items</span>
                <span style="font-size:.74rem;background:#f0fdf4;color:#16a34a;border-radius:50px;padding:2px 10px;font-weight:600;">Finalised</span>
            </div>
            @php $hasFinalised = false; @endphp
            @foreach($budgets as $budget)
            @if($budget->Status === 'Finalized')
            @php $hasFinalised = true; @endphp
            <div style="padding:12px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;justify-content:space-between;gap:8px;">
                <div style="min-width:0;">
                    <div style="font-weight:600;color:#0f172a;font-size:.88rem;">{{ $budget->Description }}
                        <span style="font-weight:700;color:#1d4ed8;"> · ZAR {{ number_format($budget->Amount, 2) }}</span>
                    </div>
                    <div style="font-size:.74rem;color:#94a3b8;">{{ $budget->due_date }}</div>
                </div>
                <span style="font-size:.73rem;color:#16a34a;font-weight:600;flex-shrink:0;">Finalised</span>
            </div>
            @endif
            @endforeach
            @if(!$hasFinalised)
            <div style="padding:32px 20px;text-align:center;color:#94a3b8;font-size:.85rem;">No finalised items yet</div>
            @endif
            <div style="padding:12px 20px;">{{ $budgets->links() }}</div>
        </div>
    </div>

    {{-- ─── Trend Chart ─────────────────────────────────────────────── --}}
    <div class="col-lg-6 mb-4">
        <div class="card h-100" style="border-radius:14px;border:1px solid #e2e8f0;">
            <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;">
                <span style="font-weight:700;color:#0f172a;font-size:.9rem;">Budget Trend — Income vs Expense</span>
            </div>
            <div class="card-body p-3" style="position:relative;height:280px;">
                <canvas id="budgetLineChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
(function () {
    var raw = @json($chart);
    if (!raw || !raw.length) return;
    var ctx = document.getElementById('budgetLineChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: raw.map(function (e) { return e.month; }),
            datasets: [
                { label: 'Income Budgeted',  data: raw.map(function (e) { return e.income_budgeted; }),  borderColor: '#16a34a', backgroundColor: 'rgba(22,163,74,.08)',  borderWidth: 2, tension: 0.3, pointRadius: 4, fill: false },
                { label: 'Expense Budgeted', data: raw.map(function (e) { return e.expense_budgeted; }), borderColor: '#dc2626', backgroundColor: 'rgba(220,38,38,.08)',  borderWidth: 2, tension: 0.3, pointRadius: 4, fill: false },
                { label: 'Other Spending',   data: raw.map(function (e) { return e.other_spending; }),   borderColor: '#1d4ed8', backgroundColor: 'rgba(29,78,216,.08)',  borderWidth: 2, tension: 0.3, pointRadius: 4, fill: false }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { color: '#f1f5f9' }, ticks: { callback: function (v) { return 'R' + v.toLocaleString(); } } }
            }
        }
    });
})();
</script>
@endsection
