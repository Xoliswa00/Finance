@extends('layouts.Nav')

@section('title', 'New Goal')
@section('page-title', 'New Financial Goal')

@section('breadcrumb')
<span>/</span>
<a href="{{ route('goals.index') }}">Goals</a>
<span>/</span>
<span>New</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
            <div class="card-body p-4">
                <h5 style="font-weight:700;color:#0f172a;margin-bottom:4px;">Create a goal</h5>
                <p style="font-size:.84rem;color:#94a3b8;margin-bottom:24px;">Define what you're working toward and set a target date.</p>

                <form action="{{ route('goals.save') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Goal Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}" placeholder="e.g. Emergency Fund, Car Loan Payoff" required autofocus>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Description <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="2" placeholder="Brief description of this goal">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Goal Type</label>
                        <select name="goal_category" class="form-select @error('goal_category') is-invalid @enderror" required>
                            <option value="">— Select type —</option>
                            <option value="Saving"    {{ old('goal_category') === 'Saving'    ? 'selected' : '' }}>Saving</option>
                            <option value="Repayment" {{ old('goal_category') === 'Repayment' ? 'selected' : '' }}>Repayment</option>
                            <option value="Investing" {{ old('goal_category') === 'Investing' ? 'selected' : '' }}>Investing</option>
                        </select>
                        @error('goal_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Target Amount (ZAR)</label>
                        <div class="input-group">
                            <span class="input-group-text" style="font-size:.85rem;color:#64748b;">R</span>
                            <input type="number" step="0.01" min="0" name="target_amount"
                                   class="form-control @error('target_amount') is-invalid @enderror"
                                   value="{{ old('target_amount') }}" placeholder="0.00" required>
                            @error('target_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Start Date</label>
                            <input type="date" name="start_date"
                                   class="form-control @error('start_date') is-invalid @enderror"
                                   value="{{ old('start_date', date('Y-m-d')) }}" required>
                            @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Target Date</label>
                            <input type="date" name="end_date"
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   value="{{ old('end_date') }}" required>
                            @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-2">
                        <button type="submit" class="btn btn-primary" style="border-radius:10px;font-weight:600;padding:9px 24px;">
                            Create Goal
                        </button>
                        <a href="{{ route('goals.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;font-weight:600;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
