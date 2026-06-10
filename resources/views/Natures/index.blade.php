@extends('layouts.Nav')

@section('title', 'Natures')
@section('page-title', 'Account Natures')

@section('breadcrumb')
<li class="breadcrumb-item">Setup</li>
<li class="breadcrumb-item active">Natures</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        {{ $natures->count() }} nature{{ $natures->count() !== 1 ? 's' : '' }} · classify your accounts
    </p>
    <a href="{{ route('natures.create') }}" class="btn btn-primary" style="border-radius:10px;font-weight:600;font-size:.88rem;">
        <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">add</i> New Nature
    </a>
</div>

@if($natures->isEmpty())
<div class="card text-center py-5" style="border-radius:16px;border:1px solid #e2e8f0;">
    <i class="material-icons-round" style="font-size:3rem;color:#cbd5e1;">label</i>
    <h5 class="mt-3 mb-1" style="font-weight:700;color:#334155;">No natures yet</h5>
    <p style="font-size:.88rem;color:#94a3b8;max-width:380px;margin:8px auto 0;">
        Create account natures to classify your financial accounts and categories.
    </p>
    <a href="{{ route('natures.create') }}" class="btn btn-primary mt-3" style="border-radius:10px;">Create your first nature</a>
</div>
@else
<div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0" style="font-size:.88rem;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Nature</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Classification</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($natures as $nature)
                    <tr style="border-color:#f8fafc;">
                        <td style="padding:12px 20px;font-weight:600;color:#0f172a;border-color:#f8fafc;">{{ $nature->Nature }}</td>
                        <td style="padding:12px 20px;border-color:#f8fafc;">
                            <span style="font-size:.75rem;background:#eff6ff;color:#1d4ed8;border-radius:50px;padding:3px 10px;font-weight:600;">
                                {{ $nature->Classification }}
                            </span>
                        </td>
                        <td style="padding:12px 20px;border-color:#f8fafc;text-align:right;white-space:nowrap;">
                            <a href="{{ route('natures.edit', $nature->id) }}"
                               class="btn btn-sm btn-outline-secondary"
                               style="border-radius:7px;font-size:.75rem;padding:3px 12px;">Edit</a>
                            <form action="{{ route('natures.destroy', $nature->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        style="border-radius:7px;font-size:.75rem;padding:3px 12px;"
                                        onclick="return confirm('Delete \'{{ addslashes($nature->Nature) }}\'?')">Delete</button>
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
