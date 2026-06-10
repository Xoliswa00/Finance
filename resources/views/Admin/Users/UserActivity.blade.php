@extends('layouts.Admin')
@section('page-title', 'User Activity — ' . $user->name)
@section('content')

<div class="container-fluid py-2">

  {{-- User summary card --}}
  <div class="row g-3 mb-4">
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body text-center pt-4">
          <div class="avatar avatar-xl bg-gradient-dark border-radius-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:64px;height:64px;">
            <i class="material-icons text-white" style="font-size:2rem;">account_circle</i>
          </div>
          <h5 class="mb-0">{{ $user->name }} {{ $user->Surname }}</h5>
          <p class="text-sm text-secondary mb-1">{{ $user->email }}</p>
          <span class="badge bg-gradient-{{ $user->Role === 'Master' ? 'danger' : ($user->Role === 'AdmiX' ? 'warning' : 'secondary') }}">
            {{ $user->Role }}
          </span>
          @if($user->isSuspended())
            <span class="badge bg-gradient-danger ms-1">Suspended</span>
          @endif

          <hr class="my-3">
          <div class="row text-center">
            <div class="col-6">
              <p class="text-xs text-secondary mb-0">Last Seen</p>
              <p class="text-sm font-weight-bold mb-0">
                {{ $user->last_seen ? \Carbon\Carbon::parse($user->last_seen)->diffForHumans() : 'Never' }}
              </p>
            </div>
            <div class="col-6">
              <p class="text-xs text-secondary mb-0">Joined</p>
              <p class="text-sm font-weight-bold mb-0">{{ $user->created_at->format('d M Y') }}</p>
            </div>
          </div>

          @if($user->isSuspended())
          <div class="alert alert-warning text-xs mt-3 mb-0">
            <strong>Suspended:</strong> {{ $user->suspension_reason }}
          </div>
          @endif
        </div>
      </div>
    </div>

    {{-- Login history --}}
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h6 class="mb-0">Login History <span class="text-secondary text-xs">(last 30)</span></h6>
        </div>
        <div class="card-body px-0 pb-0" style="max-height:320px;overflow-y:auto;">
          <table class="table align-items-center mb-0">
            <tbody>
              @forelse($loginHistory as $attempt)
              <tr>
                <td>
                  <span class="badge bg-gradient-{{ $attempt->succeeded ? 'success' : 'danger' }} me-2">
                    {{ $attempt->succeeded ? '✓' : '✗' }}
                  </span>
                  <span class="text-xs">{{ $attempt->ip_address }}</span>
                </td>
                <td class="text-end">
                  <span class="text-xs text-secondary">
                    {{ \Carbon\Carbon::parse($attempt->created_at)->format('d M H:i') }}
                  </span>
                </td>
              </tr>
              @empty
              <tr><td colspan="2" class="text-center text-sm text-secondary py-3">No login history.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Admin notes --}}
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h6 class="mb-0">Admin Notes</h6>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('admin.users.notes.store', $user) }}" class="mb-3">
            @csrf
            <div class="input-group">
              <input type="text" name="note" class="form-control form-control-sm" placeholder="Add a note…" required>
              <button type="submit" class="btn bg-gradient-primary btn-sm">Add</button>
            </div>
          </form>
          <div style="max-height:220px;overflow-y:auto;">
            @forelse($notes as $note)
            <div class="border-radius-md bg-gray-100 p-2 mb-2">
              <p class="text-xs mb-1">{{ $note->note }}</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="text-xxs text-secondary">{{ $note->admin->name }} · {{ $note->created_at->format('d M Y') }}</span>
                <form method="POST" action="{{ route('admin.notes.destroy', $note) }}">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-link btn-sm p-0 text-danger" onclick="return confirm('Delete note?')">
                    <i class="material-icons" style="font-size:14px;">delete</i>
                  </button>
                </form>
              </div>
            </div>
            @empty
            <p class="text-sm text-secondary">No notes yet.</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Page visit history --}}
  <div class="card">
    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
      <h6 class="mb-0">Page Visit History</h6>
      <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-secondary">← Back to Users</a>
    </div>
    <div class="card-body px-0 pb-2">
      <div class="table-responsive">
        <table class="table align-items-center mb-0">
          <thead>
            <tr class="bg-gradient-dark">
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Page</th>
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">IP</th>
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Browser</th>
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">When</th>
            </tr>
          </thead>
          <tbody>
            @forelse($logs as $log)
            <tr>
              <td><p class="text-xs font-weight-bold mb-0">/{{ $log->page_visited }}</p></td>
              <td><p class="text-xs text-secondary mb-0">{{ $log->ip_address ?? '—' }}</p></td>
              <td><p class="text-xs text-secondary mb-0">{{ Str::limit($log->user_agent ?? '—', 50) }}</p></td>
              <td><p class="text-xs text-secondary mb-0">{{ $log->created_at->format('d M Y H:i') }}</p></td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-4 text-secondary">No activity recorded.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="px-4 pt-3">{{ $logs->links() }}</div>
    </div>
  </div>

</div>
@endsection
