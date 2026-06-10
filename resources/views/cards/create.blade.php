@extends('layouts.Nav')

@section('title', 'Add Card')
@section('page-title', 'Add Payment Card')

@section('breadcrumb')
<span>/</span>
<a href="{{ route('cards.index') }}">Cards</a>
<span>/</span>
<span>New</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
            <div class="card-body p-4">
                <h5 style="font-weight:700;color:#0f172a;margin-bottom:4px;">Add Payment Card</h5>
                <p style="font-size:.84rem;color:#94a3b8;margin-bottom:24px;">Register a credit or debit card for transaction tracking.</p>

                <form method="POST" action="{{ route('cards.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Card Type</label>
                        <select name="Type" class="form-select @error('Type') is-invalid @enderror" required>
                            <option value="">— Select type —</option>
                            <option value="Debit Cards"  {{ old('Type') === 'Debit Cards'  ? 'selected' : '' }}>Debit Card</option>
                            <option value="Credit Cards" {{ old('Type') === 'Credit Cards' ? 'selected' : '' }}>Credit Card</option>
                        </select>
                        @error('Type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Card Number</label>
                        <input type="text" name="CardNumber" class="form-control @error('CardNumber') is-invalid @enderror"
                               value="{{ old('CardNumber') }}" placeholder="•••• •••• •••• 1234" required>
                        @error('CardNumber')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small style="display:block;margin-top:6px;color:#94a3b8;">Last 4 digits visible, others masked for security</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Cardholder Name</label>
                        <input type="text" name="Cardholder" class="form-control @error('Cardholder') is-invalid @enderror"
                               value="{{ old('Cardholder') }}" placeholder="Name on card" required>
                        @error('Cardholder')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Expiry Date</label>
                            <input type="text" name="ExpiryDate" class="form-control @error('ExpiryDate') is-invalid @enderror"
                                   value="{{ old('ExpiryDate') }}" placeholder="MM/YY" required>
                            @error('ExpiryDate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">CVC</label>
                            <input type="text" name="CVC" class="form-control @error('CVC') is-invalid @enderror"
                                   value="{{ old('CVC') }}" placeholder="•••" maxlength="4" required>
                            @error('CVC')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Status</label>
                        <select name="Status" class="form-select @error('Status') is-invalid @enderror" required>
                            <option value="Active"   {{ old('Status') === 'Active'   ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('Status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('Status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-2">
                        <button type="submit" class="btn btn-primary" style="border-radius:10px;font-weight:600;padding:9px 24px;">
                            Add Card
                        </button>
                        <a href="{{ route('cards.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;font-weight:600;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
