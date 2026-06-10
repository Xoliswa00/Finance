@extends('layouts.Admin')
@section('page-title', 'Manage Users')
@section('content')

<div class="container-fluid py-2">

  {{-- ── Friends / Regular Users ─────────────────────────────────── --}}
  <div class="card mb-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
        <h6 class="text-white text-capitalize mb-0">Users ({{ $friends->count() }})</h6>
      </div>
    </div>
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
        <table class="table table-hover align-items-center mb-0">
          <thead>
            <tr class="bg-gradient-dark">
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">User</th>
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Role</th>
              <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-7">Status</th>
              <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-7">Activity</th>
              <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-7">Joined</th>
              <th class="text-secondary opacity-7">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($friends as $u)
            @include('Admin.Users._user_row', ['u' => $u, 'showRolePromotion' => true])
            @empty
            <tr><td colspan="6" class="text-center py-4 text-sm text-secondary">No users found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- ── Admin Accounts ───────────────────────────────────────────── --}}
  @if($admins->isNotEmpty())
  <div class="card mb-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
      <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
        <h6 class="text-white text-capitalize mb-0">Admin Accounts ({{ $admins->count() }})</h6>
      </div>
    </div>
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
        <table class="table table-hover align-items-center mb-0">
          <thead>
            <tr class="bg-gradient-dark">
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">User</th>
              <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Role</th>
              <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-7">Status</th>
              <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-7">Activity</th>
              <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-7">Joined</th>
              <th class="text-secondary opacity-7">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($admins as $u)
            @include('Admin.Users._user_row', ['u' => $u, 'showRolePromotion' => false])
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif

</div>

{{-- ── Suspend Modal ────────────────────────────────────────────── --}}
<div class="modal fade" id="suspendModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Suspend User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" id="suspendForm">
        @csrf
        <div class="modal-body">
          <p>You are suspending <strong id="suspendUserName"></strong>. They will be immediately signed out.</p>
          <div class="mb-3">
            <label class="form-label">Reason <span class="text-danger">*</span></label>
            <textarea name="reason" class="form-control" rows="3" placeholder="e.g. Violation of terms of service" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn bg-gradient-danger btn-sm">Suspend Account</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ── Change Role Modal ────────────────────────────────────────── --}}
<div class="modal fade" id="roleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" id="roleForm">
        @csrf
        <div class="modal-body">
          <p>Changing role for <strong id="roleUserName"></strong>.</p>
          <div class="mb-3">
            <label class="form-label">New Role</label>
            <select name="role" class="form-select">
              <option value="friend">Friend (regular user)</option>
              <option value="AdmiX">AdmiX (admin)</option>
              <option value="Master">Master (super admin)</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn bg-gradient-primary btn-sm">Save Role</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  document.querySelectorAll('[data-action="suspend"]').forEach(btn => {
    btn.addEventListener('click', () => {
      document.getElementById('suspendForm').action = btn.dataset.url;
      document.getElementById('suspendUserName').textContent = btn.dataset.name;
      new bootstrap.Modal(document.getElementById('suspendModal')).show();
    });
  });

  document.querySelectorAll('[data-action="role"]').forEach(btn => {
    btn.addEventListener('click', () => {
      document.getElementById('roleForm').action = btn.dataset.url;
      document.getElementById('roleUserName').textContent = btn.dataset.name;
      document.querySelector('#roleForm select[name=role]').value = btn.dataset.role;
      new bootstrap.Modal(document.getElementById('roleModal')).show();
    });
  });
</script>
@endsection
