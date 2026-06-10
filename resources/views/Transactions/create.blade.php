@extends('layouts.Nav')

@section('title', 'New Transaction')
@section('page-title', 'Record Transaction')

@section('breadcrumb')
<span>/</span>
<a href="{{ route('transactions.index') }}">Transactions</a>
<span>/</span>
<span>New</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
            <div class="card-body p-4">
                <h5 style="font-weight:700;color:#0f172a;margin-bottom:4px;">
                    @if($action === 'Yes') Update Goal Balance @else Record Transaction @endif
                </h5>
                <p style="font-size:.84rem;color:#94a3b8;margin-bottom:24px;">Add income or expense to your account.</p>

                <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Type</label>
                        <select name="Action" class="form-select @error('Action') is-invalid @enderror" required>
                            <option value="">— Select type —</option>
                            @if($action === 'Yes')
                                <option value="Paid" {{ old('Action') === 'Paid' ? 'selected' : '' }}>Paid</option>
                            @else
                                <option value="Paid"     {{ old('Action') === 'Paid'     ? 'selected' : '' }}>Paid</option>
                                <option value="Received" {{ old('Action') === 'Received' ? 'selected' : '' }}>Received Income</option>
                            @endif
                        </select>
                        @error('Action')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Category</label>
                        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="">— Select category —</option>
                            @foreach($category as $cat)
                            <option value="{{ $cat->id }}" {{ old('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->Nature }} — {{ $cat->category }}
                            </option>
                            @endforeach
                        </select>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Description</label>
                        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                               value="{{ old('description') }}" placeholder="e.g. Salary, Groceries" required>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Payment Method</label>
                        <select name="Method" class="form-select @error('Method') is-invalid @enderror" required>
                            <option value="Cash" {{ old('Method') === 'Cash' ? 'selected' : '' }}>Cash</option>
                            @foreach($cards as $card)
                            <option value="{{ $card->Type }}" {{ old('Method') === $card->Type ? 'selected' : '' }}>
                                {{ $card->Type === 'Debit Cards' ? 'Debit Card' : $card->Type }} — {{ substr($card->CardNumber, -4) }}
                            </option>
                            @endforeach
                        </select>
                        @error('Method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Amount (ZAR)</label>
                        <div class="input-group">
                            <span class="input-group-text" style="font-size:.85rem;color:#64748b;">R</span>
                            <input type="number" step="0.01" min="0" name="amount"
                                   class="form-control @error('amount') is-invalid @enderror"
                                   value="{{ old('amount') }}" placeholder="0.00" required>
                            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Date</label>
                        <input type="date" name="bill_date"
                               class="form-control @error('bill_date') is-invalid @enderror"
                               value="{{ old('bill_date', date('Y-m-d')) }}" required>
                        @error('bill_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Receipt <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                        <input type="file" name="Invoice_slip" class="form-control @error('Invoice_slip') is-invalid @enderror"
                               accept=".pdf,.jpg,.jpeg,.png">
                        @error('Invoice_slip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small style="display:block;margin-top:6px;color:#94a3b8;">PDF, JPG, or PNG · Max 5MB</small>
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-2">
                        <button type="submit" class="btn btn-primary" style="border-radius:10px;font-weight:600;padding:9px 24px;">
                            Record Transaction
                        </button>
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;font-weight:600;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
