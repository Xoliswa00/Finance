@extends('layouts.Nav')

@section('title', 'Add Category')
@section('page-title', 'Add Category')

@section('breadcrumb')
<li class="breadcrumb-item">Setup</li>
<li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
<li class="breadcrumb-item active">Add</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-7 col-lg-5">
        <div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
            <div class="card-body p-4">
                <h5 style="font-weight:700;color:#0f172a;margin-bottom:4px;">New Category</h5>
                <p style="font-size:.85rem;color:#64748b;margin-bottom:24px;">Add an account category to organise your transactions and budgets.</p>

                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="category" style="display:block;font-size:.82rem;font-weight:600;color:#334155;margin-bottom:6px;">Category Name</label>
                        <input id="category" type="text" name="category"
                               value="{{ old('category') }}"
                               class="form-control @error('category') is-invalid @enderror"
                               style="border-radius:10px;border:1.5px solid #e2e8f0;padding:10px 14px;"
                               placeholder="e.g. Groceries, Salary, Vehicle" required autofocus>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="Nature" style="display:block;font-size:.82rem;font-weight:600;color:#334155;margin-bottom:6px;">Nature / Type</label>
                        <select id="Nature" name="Nature"
                                class="form-control @error('Nature') is-invalid @enderror"
                                style="border-radius:10px;border:1.5px solid #e2e8f0;padding:10px 14px;" required>
                            <option value="">— Select a type —</option>
                            @foreach($natures as $nature)
                                <option value="{{ $nature->Nature }}" {{ old('Nature') === $nature->Nature ? 'selected' : '' }}>
                                    {{ $nature->Nature }}
                                </option>
                            @endforeach
                        </select>
                        @error('Nature')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill" style="border-radius:10px;font-weight:700;">
                            <i class="material-icons-round me-1" style="font-size:.9rem;vertical-align:middle;">add</i>
                            Create Category
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
