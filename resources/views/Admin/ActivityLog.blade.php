@extends('layouts.Admin')
@section('page-title', 'Activity Log')
@section('content')

<div class="container-fluid py-2">

  {{-- Top pages summary --}}
  <div class="row g-3 mb-4">
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h6 class="mb-0">Top Pages</h6>
        </div>
        <div class="card-body px-0 pb-0">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Page</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-end">Hits</th>
                </tr>
              </thead>
              <tbody>
                @foreach($topPages as $page)
                <tr>
                  <td><p class="text-xs font-weight-bold mb-0">/{{ $page->page_visited }}</p></td>
                  <td class="text-end"><span class="badge bg-gradient-info">{{ number_format($page->hits) }}</span></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- Filters --}}
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header pb-0">
          <h6 class="mb-0">Filter Log</h6>
        </div>
        <div class="card-body">
          <form method="GET" action="{{ route('admin.activity-log') }}" class="row g-2">
            <div class="col-sm-4">
              <label class="form-label text-xs">User</label>
              <select name="user_id" class="form-select form-select-sm">
                <option value="">All Users</option>
                @foreach($users as $u)
                <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                  {{ $u->name }} {{ $u->Surname }} ({{ $u->email }})
                </option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-3">
              <label class="form-label text-xs">Page contains</label>
              <input type="text" name="page_filter" class="form-control form-control-sm"
                     value="{{ request('page_filter') }}" placeholder="e.g. transactions">
            </div>
            <div class="col-sm-2">
              <label class="form-label text-xs">From</label>
              <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
            </div>
            <div class="col-sm-2">
              <label class="form-label text-xs">To</label>
              <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
            </div>
            <div class="col-sm-1 d-flex align-items-end">
              <button type="submit" class="btn bg-gradient-primary btn-sm w-100">Go</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Log table --}}
  <div class="card">
    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
      <h6 class="mb-0">Activity Log <span class="badge bg-gradient-secondary ms-2">{{ $logs->total() }} entries</span></h6>
      @if(request()->hasAny(['user_id','page_filter','date_from','date_to']))
      <a href="{{ route('admin.activity-log') }}" class="btn btn-sm btn-outline-secondary">Clear Filters</a>
      @endif
    </div>
    <div class="card-body px-0 pb-2">
      <div class="table-responsive">
        <table class="table align-items-center mb-0">
          <thead>
            <tr class="bg-gradient-dark">
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">User</th>
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Page</th>
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">IP Address</th>
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Browser</th>
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">When</th>
            </tr>
          </thead>
          <tbody>
            @forelse($logs as $log)
            <tr>
              <td>
                @if(is_numeric($log->Added_by) && $log->user)
                  <a href="{{ route('admin.users.activity', $log->Added_by) }}" class="text-sm font-weight-bold">
                    {{ $log->user->name ?? '—' }}
                  </a>
                @else
                  <span class="text-xs text-secondary">Guest</span>
                @endif
              </td>
              <td><p class="text-xs font-weight-bold mb-0">/{{ $log->page_visited }}</p></td>
              <td><p class="text-xs text-secondary mb-0">{{ $log->ip_address ?? '—' }}</p></td>
              <td>
                <p class="text-xs text-secondary mb-0" title="{{ $log->user_agent }}">
                  {{ Str::limit($log->user_agent ?? '—', 40) }}
                </p>
              </td>
              <td><p class="text-xs text-secondary mb-0">{{ $log->created_at?->format('d M Y H:i') ?? '—' }}</p></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-4 text-secondary">No activity found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="px-4 pt-3">
        {{ $logs->links() }}
      </div>
    </div>
  </div>

</div>
@endsection
