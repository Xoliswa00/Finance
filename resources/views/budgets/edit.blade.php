@extends('layouts.Nav')

@section('title', 'Edit Budget')
@section('page-title', 'Edit Budget Item')

@section('breadcrumb')
<span>/</span>
<a href="{{ route('budgets.index') }}">Budgets</a>
<span>/</span>
<span>Edit</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
            <div class="card-body p-4">
                <h5 style="font-weight:700;color:#0f172a;margin-bottom:4px;">{{ $budget->Description }}</h5>
                <p style="font-size:.84rem;color:#94a3b8;margin-bottom:24px;">Update budget details.</p>

                <form action="{{ route('budgets.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Description</label>
                        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                               value="{{ old('description', $budget->Description) }}" readonly>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Budget Amount</label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:.85rem;color:#64748b;">R</span>
                                <input type="number" step="0.01" min="0" name="amount"
                                       class="form-control @error('amount') is-invalid @enderror"
                                       value="{{ old('amount', $budget->Amount) }}">
                                @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Actual Amount</label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:.85rem;color:#64748b;">R</span>
                                <input type="number" step="0.01" min="0" name="limit"
                                       class="form-control @error('limit') is-invalid @enderror"
                                       value="{{ old('limit', $budget->Limit) }}" required>
                                @error('limit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Due Date</label>
                        <input type="date" name="due_date"
                               class="form-control @error('due_date') is-invalid @enderror"
                               value="{{ old('due_date', $budget->due_date) }}" required>
                        @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Recurring</label>
                        <select name="recurring" class="form-select @error('recurring') is-invalid @enderror" required>
                            <option value="Once-off" {{ old('recurring') === 'Once-off' ? 'selected' : '' }}>Once-off</option>
                            <option value="Weekly"   {{ old('recurring') === 'Weekly'   ? 'selected' : '' }}>Weekly</option>
                            <option value="Monthly"  {{ old('recurring') === 'Monthly'  ? 'selected' : '' }}>Monthly</option>
                            <option value="Yearly"   {{ old('recurring') === 'Yearly'   ? 'selected' : '' }}>Yearly</option>
                        </select>
                        @error('recurring')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <input type="hidden" name="id" value="{{ $budget->id }}">

                    <div class="d-flex align-items-center gap-2 mt-2">
                        <button type="submit" class="btn btn-primary" style="border-radius:10px;font-weight:600;padding:9px 24px;">
                            Update Budget Item
                        </button>
                        <a href="{{ route('budgets.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;font-weight:600;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
