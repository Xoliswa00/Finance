@extends('layouts.Nav')

@section('title', 'Profile')
@section('page-title', 'My Profile')

@section('breadcrumb')
<span>/</span> <span>Profile</span>
@endsection

@section('content')
<div class="row">

    {{-- ─── Left: Profile Card + Edit Form ─────────────────────────────────── --}}
    <div class="col-lg-4 mb-4">
        <div class="card" style="border-radius:14px;border:1px solid #e2e8f0;">
            <div class="card-body p-4">

                {{-- Avatar --}}
                <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,#1d4ed8,#7c3aed);
                            display:flex;align-items:center;justify-content:center;
                            margin-bottom:14px;font-size:1.6rem;font-weight:800;color:#fff;">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>

                <h5 style="font-weight:700;color:#0f172a;margin-bottom:2px;">
                    {{ $user->name }} {{ $user->Surname }}
                </h5>
                <p style="font-size:.8rem;color:#94a3b8;margin-bottom:0;">
                    {{ ucfirst(strtolower($user->Role ?? 'member')) }}
                    @if($user->email_verified_at)
                        &nbsp;<span style="font-size:.7rem;background:#f0fdf4;color:#16a34a;border-radius:50px;padding:1px 7px;font-weight:600;">Verified</span>
                    @else
                        &nbsp;<span style="font-size:.7rem;background:#fef9c3;color:#854d0e;border-radius:50px;padding:1px 7px;font-weight:600;">Unverified</span>
                    @endif
                </p>

                <hr style="border-color:#f1f5f9;margin:16px 0;">

                {{-- Info rows --}}
                <div style="font-size:.82rem;">
                    <div class="prof-row">
                        <span class="prof-label"><i class="material-icons-round" style="font-size:.9rem;vertical-align:middle;">email</i> Email</span>
                        <span class="prof-value">{{ $user->email }}</span>
                    </div>
                    <div class="prof-row">
                        <span class="prof-label"><i class="material-icons-round" style="font-size:.9rem;vertical-align:middle;">phone</i> Mobile</span>
                        <span class="prof-value">{{ $user->Mobile ?? '—' }}</span>
                    </div>
                    <div class="prof-row">
                        <span class="prof-label"><i class="material-icons-round" style="font-size:.9rem;vertical-align:middle;">location_on</i> Location</span>
                        <span class="prof-value">{{ $user->Location ?? '—' }}</span>
                    </div>
                    <div class="prof-row">
                        <span class="prof-label"><i class="material-icons-round" style="font-size:.9rem;vertical-align:middle;">calendar_today</i> Member since</span>
                        <span class="prof-value">{{ $user->created_at?->format('d M Y') ?? '—' }}</span>
                    </div>
                    <div class="prof-row" style="border-bottom:none;">
                        <span class="prof-label"><i class="material-icons-round" style="font-size:.9rem;vertical-align:middle;">verified_user</i> Status</span>
                        <span style="font-size:.72rem;background:#f0fdf4;color:#16a34a;border-radius:50px;padding:2px 8px;font-weight:600;">Active</span>
                    </div>
                </div>

                <hr style="border-color:#f1f5f9;margin:16px 0;">

                {{-- Edit toggle button --}}
                <button type="button" id="editToggleBtn" onclick="toggleEdit()"
                    style="width:100%;display:flex;align-items:center;justify-content:center;gap:6px;
                           font-size:.82rem;font-weight:600;color:#1d4ed8;
                           background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;
                           padding:8px 14px;cursor:pointer;transition:background .15s;">
                    <i class="material-icons-round" style="font-size:1rem;" id="editIcon">edit</i>
                    <span id="editBtnLabel">Edit Profile</span>
                </button>

                {{-- Edit form --}}
                <form id="editForm" method="POST" action="{{ route('profile.update') }}" style="display:none;margin-top:16px;">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom:12px;">
                        <label style="font-size:.75rem;font-weight:600;color:#475569;display:block;margin-bottom:4px;">First Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            style="width:100%;padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#0f172a;outline:none;transition:border .15s;"
                            onfocus="this.style.borderColor='#1d4ed8'" onblur="this.style.borderColor='#e2e8f0'" required>
                        @error('name')<span style="font-size:.72rem;color:#ef4444;">{{ $message }}</span>@enderror
                    </div>

                    <div style="margin-bottom:12px;">
                        <label style="font-size:.75rem;font-weight:600;color:#475569;display:block;margin-bottom:4px;">Surname</label>
                        <input type="text" name="Surname" value="{{ old('Surname', $user->Surname) }}"
                            style="width:100%;padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#0f172a;outline:none;transition:border .15s;"
                            onfocus="this.style.borderColor='#1d4ed8'" onblur="this.style.borderColor='#e2e8f0'" required>
                        @error('Surname')<span style="font-size:.72rem;color:#ef4444;">{{ $message }}</span>@enderror
                    </div>

                    <div style="margin-bottom:12px;">
                        <label style="font-size:.75rem;font-weight:600;color:#475569;display:block;margin-bottom:4px;">Mobile Number</label>
                        <input type="text" name="Mobile" value="{{ old('Mobile', $user->Mobile) }}"
                            style="width:100%;padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#0f172a;outline:none;transition:border .15s;"
                            onfocus="this.style.borderColor='#1d4ed8'" onblur="this.style.borderColor='#e2e8f0'" required>
                        @error('Mobile')<span style="font-size:.72rem;color:#ef4444;">{{ $message }}</span>@enderror
                    </div>

                    <div style="margin-bottom:16px;">
                        <label style="font-size:.75rem;font-weight:600;color:#475569;display:block;margin-bottom:4px;">Location</label>
                        <input type="text" name="Location" value="{{ old('Location', $user->Location) }}"
                            style="width:100%;padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#0f172a;outline:none;transition:border .15s;"
                            onfocus="this.style.borderColor='#1d4ed8'" onblur="this.style.borderColor='#e2e8f0'" required>
                        @error('Location')<span style="font-size:.72rem;color:#ef4444;">{{ $message }}</span>@enderror
                    </div>

                    <button type="submit"
                        style="width:100%;padding:9px;background:#1d4ed8;color:#fff;border:none;border-radius:8px;
                               font-size:.84rem;font-weight:600;cursor:pointer;transition:background .15s;"
                        onmouseover="this.style.background='#1e40af'" onmouseout="this.style.background='#1d4ed8'">
                        Save Changes
                    </button>
                </form>

            </div>
        </div>
    </div>

    {{-- ─── Right: Balances + Cards ─────────────────────────────────────────── --}}
    <div class="col-lg-8 mb-4">

        {{-- Balances --}}
        <div class="row mb-3">
            <div class="col-6">
                <div class="card h-100" style="border-radius:14px;border:1px solid #e2e8f0;">
                    <div class="card-body p-3">
                        <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px;">Bank Balance</div>
                        <div style="font-size:1.35rem;font-weight:800;color:#0f172a;">
                            ZAR {{ $balance ? number_format($balance->Balance, 2) : '0.00' }}
                        </div>
                        <p style="font-size:.74rem;color:#94a3b8;margin:4px 0 0;">Current funds</p>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card h-100" style="border-radius:14px;border:1px solid #e2e8f0;">
                    <div class="card-body p-3">
                        <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px;">Credit Card</div>
                        <div style="font-size:1.35rem;font-weight:800;color:#0f172a;">
                            ZAR {{ $CreditB ? number_format($CreditB->Balance, 2) : '0.00' }}
                        </div>
                        <p style="font-size:.74rem;color:#94a3b8;margin:4px 0 0;">Credit balance</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cards --}}
        <div class="card" style="border-radius:14px;border:1px solid #e2e8f0;">
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <h6 style="font-weight:700;color:#0f172a;margin:0;font-size:.9rem;">Payment Methods</h6>
                <a href="{{ route('cards.create') }}"
                   style="font-size:.78rem;font-weight:600;color:#1d4ed8;background:#eff6ff;
                          border:1px solid #bfdbfe;border-radius:7px;padding:5px 12px;text-decoration:none;
                          display:inline-flex;align-items:center;gap:4px;transition:background .15s;"
                   onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'">
                    <i class="material-icons-round" style="font-size:.85rem;">add</i> Add Card
                </a>
            </div>
            <div class="card-body p-0">
                @if($cards->isEmpty())
                <div style="padding:32px 20px;text-align:center;color:#94a3b8;font-size:.85rem;">
                    No payment methods yet. <a href="{{ route('cards.create') }}" style="color:#1d4ed8;text-decoration:none;font-weight:600;">Add one</a>
                </div>
                @else
                <div style="padding:8px 20px;">
                    @foreach($cards as $card)
                    <div style="padding:12px 0;border-bottom:1px solid #f8fafc;display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:40px;height:40px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                                <i class="material-icons-round" style="color:#1d4ed8;font-size:1.2rem;">credit_card</i>
                            </div>
                            <div>
                                <div style="font-weight:600;color:#0f172a;font-size:.87rem;">{{ $card->Type }}</div>
                                <div style="font-family:monospace;font-size:.75rem;color:#94a3b8;letter-spacing:2px;">
                                    •••• •••• •••• {{ substr($card->CardNumber, -4) }}
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <span style="font-size:.7rem;background:#f0fdf4;color:#16a34a;border-radius:50px;padding:2px 8px;font-weight:600;">
                                {{ $card->Status ?? 'Active' }}
                            </span>
                            <a href="{{ route('cards.edit', $card->id) }}"
                               style="font-size:.74rem;font-weight:600;color:#64748b;background:#f1f5f9;
                                      border:1px solid #e2e8f0;border-radius:6px;padding:4px 10px;text-decoration:none;
                                      transition:background .15s;"
                               onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                                Edit
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

<style>
.prof-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 9px 0;
    border-bottom: 1px solid #f1f5f9;
    gap: 8px;
}
.prof-label {
    color: #64748b;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
    flex-shrink: 0;
}
.prof-value {
    color: #0f172a;
    font-weight: 600;
    text-align: right;
    word-break: break-word;
}
</style>

@section('scripts')
<script>
function toggleEdit() {
    var form    = document.getElementById('editForm');
    var icon    = document.getElementById('editIcon');
    var label   = document.getElementById('editBtnLabel');
    var btn     = document.getElementById('editToggleBtn');
    var isOpen  = form.style.display !== 'none';

    form.style.display  = isOpen ? 'none' : 'block';
    icon.textContent    = isOpen ? 'edit' : 'close';
    label.textContent   = isOpen ? 'Edit Profile' : 'Cancel';
    btn.style.background = isOpen ? '#eff6ff' : '#fef2f2';
    btn.style.borderColor = isOpen ? '#bfdbfe' : '#fecaca';
    btn.style.color      = isOpen ? '#1d4ed8' : '#dc2626';
}

// Auto-open edit form if there are validation errors
@if($errors->any())
document.addEventListener('DOMContentLoaded', function() { toggleEdit(); });
@endif
</script>
@endsection
@endsection
