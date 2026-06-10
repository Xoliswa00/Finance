@extends('layouts.Nav')

@section('title', 'Edit Transaction')
@section('page-title', 'Edit Transaction')

@section('breadcrumb')
<span>/</span>
<a href="{{ route('transactions.index') }}">Transactions</a>
<span>/</span>
<span>Edit</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
            <div class="card-body p-4">
                <h5 style="font-weight:700;color:#0f172a;margin-bottom:4px;">{{ $transaction->Description }}</h5>
                <p style="font-size:.84rem;color:#94a3b8;margin-bottom:24px;">Update transaction details.</p>

                <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Description</label>
                        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                               value="{{ old('description', $transaction->Description) }}" required>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Category</label>
                        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $cat->id == $transaction->Category_id ? 'selected' : '' }}>
                                {{ $cat->category }}
                            </option>
                            @endforeach
                        </select>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Amount (ZAR)</label>
                        <div class="input-group">
                            <span class="input-group-text" style="font-size:.85rem;color:#64748b;">R</span>
                            <input type="number" step="0.01" min="0" name="amount"
                                   class="form-control @error('amount') is-invalid @enderror"
                                   value="{{ old('amount', $transaction->Amount) }}" required>
                            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Date</label>
                        <input type="date" name="bill_date"
                               class="form-control @error('bill_date') is-invalid @enderror"
                               value="{{ old('bill_date', $transaction->bill_date) }}" required>
                        @error('bill_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-2">
                        <button type="submit" class="btn btn-primary" style="border-radius:10px;font-weight:600;padding:9px 24px;">
                            Save Changes
                        </button>
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;font-weight:600;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
