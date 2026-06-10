@extends('layouts.Nav')

@section('title', 'Cards')
@section('page-title', 'Payment Cards')

@section('breadcrumb')
<li class="breadcrumb-item active">Cards</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        {{ $cards->count() }} card{{ $cards->count() !== 1 ? 's' : '' }} · track all payment methods
    </p>
    <a href="{{ route('cards.create') }}" class="btn btn-primary" style="border-radius:10px;font-weight:600;font-size:.88rem;">
        <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">add</i> Add Card
    </a>
</div>

@if($cards->isEmpty())
<div class="card text-center py-5" style="border-radius:16px;border:1px solid #e2e8f0;">
    <i class="material-icons-round" style="font-size:3rem;color:#cbd5e1;">credit_card</i>
    <h5 class="mt-3 mb-1" style="font-weight:700;color:#334155;">No cards added yet</h5>
    <p style="font-size:.88rem;color:#94a3b8;max-width:380px;margin:8px auto 0;">
        Add credit or debit cards to track transactions by payment method.
    </p>
    <a href="{{ route('cards.create') }}" class="btn btn-primary mt-3" style="border-radius:10px;">Add your first card</a>
</div>
@else
<div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0" style="font-size:.88rem;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Type</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Card Number</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Holder</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Expiry</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Status</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cards as $card)
                    <tr style="border-color:#f8fafc;">
                        <td style="padding:12px 20px;color:#334155;border-color:#f8fafc;">
                            <span style="font-weight:600;">{{ $card->Type }}</span>
                        </td>
                        <td style="padding:12px 20px;font-family:monospace;font-weight:600;color:#0f172a;border-color:#f8fafc;letter-spacing:1px;">
                            •••• •••• •••• {{ substr($card->CardNumber, -4) }}
                        </td>
                        <td style="padding:12px 20px;color:#64748b;border-color:#f8fafc;">{{ $card->Cardholder }}</td>
                        <td style="padding:12px 20px;color:#64748b;border-color:#f8fafc;">{{ $card->ExpiryDate }}</td>
                        <td style="padding:12px 20px;border-color:#f8fafc;">
                            @if($card->Status === 'Active' || $card->Status === 'active')
                            <span style="font-size:.75rem;background:#f0fdf4;color:#16a34a;border-radius:50px;padding:3px 10px;font-weight:600;">Active</span>
                            @else
                            <span style="font-size:.75rem;background:#fef2f2;color:#dc2626;border-radius:50px;padding:3px 10px;font-weight:600;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding:12px 20px;border-color:#f8fafc;text-align:right;white-space:nowrap;">
                            <a href="{{ route('cards.edit', $card->id) }}"
                               class="btn btn-sm btn-outline-secondary"
                               style="border-radius:7px;font-size:.75rem;padding:3px 12px;">Edit</a>
                            <form action="{{ route('cards.destroy', $card->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        style="border-radius:7px;font-size:.75rem;padding:3px 12px;"
                                        onclick="return confirm('Delete card ending in {{ substr($card->CardNumber, -4) }}?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection
