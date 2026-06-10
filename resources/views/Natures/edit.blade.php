@extends('layouts.Nav')

@section('title', 'Edit Nature')
@section('page-title', 'Edit Nature')

@section('breadcrumb')
<span>/</span>
<a href="{{ route('natures.index') }}">Natures</a>
<span>/</span>
<span>Edit</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
            <div class="card-body p-4">
                <h5 style="font-weight:700;color:#0f172a;margin-bottom:4px;">{{ $nature->Nature }}</h5>
                <p style="font-size:.84rem;color:#94a3b8;margin-bottom:24px;">Update nature details.</p>

                <form method="POST" action="{{ route('natures.update', $nature->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Nature Name</label>
                        <input type="text" name="Nature" class="form-control @error('Nature') is-invalid @enderror"
                               value="{{ old('Nature', $nature->Nature) }}" required autofocus>
                        @error('Nature')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#374151;">Classification</label>
                        <input type="text" name="Classification" class="form-control @error('Classification') is-invalid @enderror"
                               value="{{ old('Classification', $nature->Classification) }}" required>
                        @error('Classification')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-2">
                        <button type="submit" class="btn btn-primary" style="border-radius:10px;font-weight:600;padding:9px 24px;">
                            Save Changes
                        </button>
                        <a href="{{ route('natures.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;font-weight:600;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
