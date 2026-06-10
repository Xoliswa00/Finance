@extends('layouts.Admin')
@section('page-title', 'Announcements')
@section('content')

<div class="container-fluid py-2">
  <div class="row g-3">

    {{-- Post new announcement --}}
    <div class="col-lg-5">
      <div class="card">
        <div class="card-header pb-0">
          <h6 class="mb-0">Post Announcement</h6>
          <p class="text-sm text-secondary mb-0">Only one announcement is active at a time. Posting a new one deactivates the current.</p>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('admin.announcements.store') }}">
            @csrf

            <div class="mb-3">
              <label class="form-label text-sm">Type</label>
              <select name="type" class="form-select form-select-sm">
                <option value="info">Info (blue)</option>
                <option value="success">Success (green)</option>
                <option value="warning">Warning (yellow)</option>
                <option value="danger">Danger (red)</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label text-sm">Message</label>
              <textarea name="message" class="form-control" rows="4"
                        placeholder="e.g. We will be performing maintenance on Sunday 2 June at 2am SAST." required></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label text-sm">Expires at <span class="text-secondary">(optional)</span></label>
              <input type="datetime-local" name="expires_at" class="form-control form-control-sm">
            </div>

            {{-- Preview --}}
            <div id="announcePreview" class="alert alert-info mb-3 d-none">
              <i class="fas fa-bullhorn me-2"></i><span id="previewText"></span>
            </div>

            <button type="submit" class="btn bg-gradient-primary btn-sm w-100">
              <i class="material-icons text-sm me-1">campaign</i> Publish Announcement
            </button>
          </form>
        </div>
      </div>
    </div>

    {{-- Announcement history --}}
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header pb-0">
          <h6 class="mb-0">Announcement History</h6>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr class="bg-gradient-dark">
                  <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Message</th>
                  <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Type</th>
                  <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Status</th>
                  <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Posted</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                @forelse($announcements as $ann)
                <tr>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">{{ Str::limit($ann->message, 80) }}</p>
                    @if($ann->expires_at)
                      <p class="text-xxs text-secondary mb-0">Expires: {{ $ann->expires_at->format('d M Y H:i') }}</p>
                    @endif
                  </td>
                  <td>
                    <span class="badge bg-gradient-{{ $ann->type }}">{{ $ann->type }}</span>
                  </td>
                  <td>
                    @if($ann->active && (!$ann->expires_at || $ann->expires_at->isFuture()))
                      <span class="badge bg-gradient-success">Active</span>
                    @elseif($ann->active && $ann->expires_at && $ann->expires_at->isPast())
                      <span class="badge bg-gradient-secondary">Expired</span>
                    @else
                      <span class="badge bg-gradient-secondary">Inactive</span>
                    @endif
                  </td>
                  <td>
                    <p class="text-xs text-secondary mb-0">{{ $ann->created_at->format('d M Y') }}</p>
                    <p class="text-xxs text-secondary mb-0">by {{ $ann->creator->name }}</p>
                  </td>
                  <td>
                    <div class="d-flex gap-1">
                      @if($ann->active)
                      <form method="POST" action="{{ route('admin.announcements.deactivate', $ann) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-warning"
                                onclick="return confirm('Deactivate this announcement?')">
                          <i class="material-icons" style="font-size:14px;">visibility_off</i>
                        </button>
                      </form>
                      @endif
                      <form method="POST" action="{{ route('admin.announcements.destroy', $ann) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Delete this announcement?')">
                          <i class="material-icons" style="font-size:14px;">delete</i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4 text-secondary">No announcements yet.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="px-4 pt-3">{{ $announcements->links() }}</div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('scripts')
<script>
  const msgEl    = document.querySelector('textarea[name=message]');
  const typeEl   = document.querySelector('select[name=type]');
  const preview  = document.getElementById('announcePreview');
  const prevText = document.getElementById('previewText');

  function updatePreview() {
    const msg = msgEl.value.trim();
    if (msg) {
      preview.className = 'alert alert-' + typeEl.value + ' mb-3';
      prevText.textContent = msg;
    } else {
      preview.className = 'alert alert-info mb-3 d-none';
    }
  }

  msgEl.addEventListener('input', updatePreview);
  typeEl.addEventListener('change', updatePreview);
</script>
@endsection
