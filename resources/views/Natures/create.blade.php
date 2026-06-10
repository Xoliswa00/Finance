@extends('layouts.Nav')

@section('title', 'New Nature')
@section('page-title', 'Create Nature')

@section('breadcrumb')
<span>/</span>
<a href="{{ route('natures.index') }}">Natures</a>
<span>/</span>
<span>New</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
            <div class="card-body p-4">
                <h5 style="font-weight:700;color:#0f172a;margin-bottom:4px;">Create Nature</h5>
                <p style="font-size:.84rem;color:#94a3b8;margin-bottom:24px;">Define a new account nature classification.</p>

                <form method="POST" action="{{ route('natures.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Nature Name</label>
                        <input type="text" name="Nature" class="form-control @error('Nature') is-invalid @enderror"
                               value="{{ old('Nature') }}" placeholder="e.g. Asset, Liability, Income" required autofocus>
                        @error('Nature')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Classification</label>
                        <input type="text" name="Classification" class="form-control @error('Classification') is-invalid @enderror"
                               value="{{ old('Classification') }}" placeholder="e.g. Bank Account, Credit Card" required>
                        @error('Classification')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-2">
                        <button type="submit" class="btn btn-primary" style="border-radius:10px;font-weight:600;padding:9px 24px;">
                            Create Nature
                        </button>
                        <a href="{{ route('natures.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;font-weight:600;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
