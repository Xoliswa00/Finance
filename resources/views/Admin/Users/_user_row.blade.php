<tr>
  <td>
    <div class="d-flex px-2 py-1">
      <div class="d-flex flex-column justify-content-center">
        <h6 class="mb-0 text-sm">{{ $u->name }} {{ $u->Surname }}</h6>
        <p class="text-xs text-secondary mb-0">{{ $u->email }}</p>
      </div>
    </div>
  </td>
  <td>
    <span class="badge bg-gradient-{{ $u->Role === 'Master' ? 'danger' : ($u->Role === 'AdmiX' ? 'warning' : 'secondary') }}">
      {{ $u->Role }}
    </span>
  </td>
  <td class="align-middle text-center">
    @if($u->isSuspended())
      <span class="badge bg-gradient-danger">Suspended</span>
    @elseif($u->last_seen && \Carbon\Carbon::parse($u->last_seen)->gt(now()->subMinutes(5)))
      <span class="badge bg-gradient-success">Online</span>
    @elseif($u->last_seen)
      <span class="badge bg-gradient-secondary">{{ \Carbon\Carbon::parse($u->last_seen)->diffForHumans() }}</span>
    @else
      <span class="badge bg-gradient-secondary">Never</span>
    @endif
    @if($u->isLocked())
      <span class="badge bg-gradient-warning ms-1">Locked</span>
    @endif
  </td>
  <td class="align-middle text-center">
    <a href="{{ route('admin.users.activity', $u) }}" class="text-info text-xs">
      {{ $u->activity_logs_count }} views
    </a>
  </td>
  <td class="align-middle text-center">
    <span class="text-secondary text-xs">{{ $u->created_at->format('d M Y') }}</span>
  </td>
  <td class="align-middle">
    <div class="dropdown">
      <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Actions
      </button>
      <ul class="dropdown-menu dropdown-menu-end">

        {{-- View activity --}}
        <li>
          <a class="dropdown-item" href="{{ route('admin.users.activity', $u) }}">
            <i class="material-icons text-sm me-1">history</i> View Activity
          </a>
        </li>

        {{-- Impersonate --}}
        @if(auth()->user()->hasRole('Master') && $u->id !== auth()->id())
        <li>
          <form method="POST" action="{{ route('admin.users.impersonate', $u) }}">
            @csrf
            <button type="submit" class="dropdown-item text-purple">
              <i class="material-icons text-sm me-1">supervisor_account</i> Impersonate
            </button>
          </form>
        </li>
        @endif

        {{-- Change role --}}
        @if($showRolePromotion)
        <li>
          <button class="dropdown-item" data-action="role"
                  data-url="{{ route('admin.users.role', $u) }}"
                  data-name="{{ $u->name }}"
                  data-role="{{ $u->Role }}">
            <i class="material-icons text-sm me-1">manage_accounts</i> Change Role
          </button>
        </li>
        @endif

        <li><hr class="dropdown-divider"></li>

        {{-- Force logout --}}
        @if($u->id !== auth()->id())
        <li>
          <form method="POST" action="{{ route('admin.users.force-logout', $u) }}">
            @csrf
            <button type="submit" class="dropdown-item text-warning"
                    onclick="return confirm('Force sign out {{ addslashes($u->name) }}?')">
              <i class="material-icons text-sm me-1">exit_to_app</i> Force Sign Out
            </button>
          </form>
        </li>
        @endif

        {{-- Reset password --}}
        <li>
          <form method="POST" action="{{ route('admin.users.reset-password', $u) }}">
            @csrf
            <button type="submit" class="dropdown-item"
                    onclick="return confirm('Send password reset email to {{ addslashes($u->email) }}?')">
              <i class="material-icons text-sm me-1">lock_reset</i> Send Password Reset
            </button>
          </form>
        </li>

        <li><hr class="dropdown-divider"></li>

        {{-- Suspend / Reactivate --}}
        @if($u->id !== auth()->id())
          @if($u->isSuspended())
          <li>
            <form method="POST" action="{{ route('admin.users.reactivate', $u) }}">
              @csrf
              <button type="submit" class="dropdown-item text-success">
                <i class="material-icons text-sm me-1">check_circle</i> Reactivate
              </button>
            </form>
          </li>
          @else
          <li>
            <button class="dropdown-item text-danger" data-action="suspend"
                    data-url="{{ route('admin.users.suspend', $u) }}"
                    data-name="{{ $u->name }}">
              <i class="material-icons text-sm me-1">block</i> Suspend
            </button>
          </li>
          @endif

          {{-- Delete --}}
          <li>
            <form method="POST" action="{{ route('admin.users.destroy', $u) }}">
              @csrf @method('DELETE')
              <button type="submit" class="dropdown-item text-danger"
                      onclick="return confirm('Anonymise and deactivate {{ addslashes($u->name) }}? This cannot be undone.')">
                <i class="material-icons text-sm me-1">delete</i> Delete Account
              </button>
            </form>
          </li>
        @endif

      </ul>
    </div>
  </td>
</tr>
