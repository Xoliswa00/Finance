@extends('layouts.Nav')

@section('title', 'Categories')
@section('page-title', 'Account Categories')

@section('breadcrumb')
<li class="breadcrumb-item">Setup</li>
<li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <p class="text-muted mb-0" style="font-size:.85rem;">
                    {{ $categories->count() }} categories · organise your transactions, budgets, and reports
                </p>
            </div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary" style="border-radius:10px;font-weight:600;font-size:.88rem;">
                <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">add</i>
                Add Category
            </a>
        </div>

        @if($categories->isEmpty())
        <div class="card border-0 shadow-none" style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;">
            <div class="card-body text-center py-5">
                <i class="material-icons-round" style="font-size:3rem;color:#cbd5e1;">category</i>
                <h5 class="mt-3 mb-1" style="font-weight:700;color:#334155;">No categories yet</h5>
                <p style="font-size:.88rem;color:#94a3b8;">Add categories to organise your transactions and budgets.</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary mt-2" style="border-radius:10px;">Add your first category</a>
            </div>
        </div>
        @else

        {{-- Group by Nature --}}
        @foreach($categories->groupBy('Nature') as $nature => $group)
        <div class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;">{{ $nature ?: 'Uncategorised' }}</span>
                <span style="font-size:.72rem;background:#f1f5f9;color:#94a3b8;border-radius:50px;padding:2px 8px;font-weight:600;">{{ $group->count() }}</span>
            </div>
            <div class="card" style="border-radius:14px;border:1px solid #e2e8f0;">
                <div class="card-body p-0">
                    <table class="table mb-0" style="font-size:.88rem;">
                        <thead>
                            <tr style="background:#f8fafc;">
                                <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:10px 20px;">Account Name</th>
                                <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:10px 20px;">Nature</th>
                                <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:10px 20px;text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($group as $category)
                            <tr style="border-color:#f8fafc;">
                                <td style="padding:10px 20px;color:#334155;font-weight:500;border-color:#f8fafc;">{{ $category->category }}</td>
                                <td style="padding:10px 20px;border-color:#f8fafc;">
                                    <span style="font-size:.75rem;background:#eff6ff;color:#1d4ed8;border-radius:50px;padding:3px 10px;font-weight:600;">{{ $category->Nature }}</span>
                                </td>
                                <td style="padding:10px 20px;text-align:right;border-color:#f8fafc;">
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                       class="btn btn-sm btn-outline-secondary"
                                       style="border-radius:7px;font-size:.75rem;padding:3px 12px;">Edit</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                style="border-radius:7px;font-size:.75rem;padding:3px 12px;"
                                                onclick="return confirm('Delete \'{{ addslashes($category->category) }}\'?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach

        @endif
    </div>
</div>
@endsection
