@extends('layouts.Nav')

@section('title', 'Transfers')
@section('page-title', 'Account Transfers')

@section('breadcrumb')
<li class="breadcrumb-item active">Transfers</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        Internal transfers between your tracked accounts — credit card payments, savings deposits, loan repayments.
    </p>
    <a href="{{ route('transfers.create') }}" class="btn btn-primary" style="border-radius:10px;font-weight:600;font-size:.88rem;">
        <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">compare_arrows</i>
        New Transfer
    </a>
</div>

@if($transfers->isEmpty())
<div class="card text-center py-5" style="border-radius:16px;border:1px solid #e2e8f0;">
    <i class="material-icons-round" style="font-size:3rem;color:#cbd5e1;">compare_arrows</i>
    <h5 class="mt-3 mb-1" style="font-weight:700;color:#334155;">No transfers yet</h5>
    <p style="font-size:.88rem;color:#94a3b8;max-width:420px;margin:8px auto 0;">
        Use transfers to record movements between your accounts — paying off a credit card, moving money to savings, or recording a loan repayment.
    </p>
    <a href="{{ route('transfers.create') }}" class="btn btn-primary mt-3" style="border-radius:10px;">Record your first transfer</a>
</div>
@else
<div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0" style="font-size:.88rem;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Date</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">From</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;"></th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">To</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Amount</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Description</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transfers as $t)
                    <tr style="border-color:#f8fafc;">
                        <td style="padding:12px 20px;color:#64748b;white-space:nowrap;border-color:#f8fafc;">{{ $t->transfer_date?->format('d M Y') ?? '—' }}</td>
                        <td style="padding:12px 20px;font-weight:600;color:#0f172a;border-color:#f8fafc;">
                            {{ $t->fromCategory->category ?? '—' }}
                            <div style="font-size:.72rem;color:#94a3b8;">{{ $t->fromCategory->Nature ?? '' }}</div>
                        </td>
                        <td style="padding:12px 20px;border-color:#f8fafc;text-align:center;">
                            <i class="material-icons-round" style="font-size:1.1rem;color:#1d4ed8;">arrow_forward</i>
                        </td>
                        <td style="padding:12px 20px;font-weight:600;color:#0f172a;border-color:#f8fafc;">
                            {{ $t->toCategory->category ?? '—' }}
                            <div style="font-size:.72rem;color:#94a3b8;">{{ $t->toCategory->Nature ?? '' }}</div>
                        </td>
                        <td style="padding:12px 20px;font-weight:800;color:#1d4ed8;border-color:#f8fafc;white-space:nowrap;">
                            ZAR {{ number_format($t->amount, 2) }}
                        </td>
                        <td style="padding:12px 20px;color:#64748b;border-color:#f8fafc;">
                            {{ $t->description ?: '—' }}
                            @if($t->reference)
                            <div style="font-size:.72rem;color:#94a3b8;">Ref: {{ $t->reference }}</div>
                            @endif
                        </td>
                        <td style="padding:12px 20px;border-color:#f8fafc;">
                            <form action="{{ route('transfers.destroy', $t->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        style="border-radius:7px;font-size:.75rem;"
                                        onclick="return confirm('Reverse and delete this transfer? Account balances will be restored.')">
                                    Reverse
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $transfers->links() }}</div>
@endif
@endsection
