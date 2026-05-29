@extends('layouts.Nav')

@section('title', 'New Transfer')
@section('page-title', 'Account Transfer')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('transfers.index') }}">Transfers</a></li>
<li class="breadcrumb-item active">New Transfer</li>
@endsection

@section('head')
<style>
    .transfer-card { background:#fff; border-radius:20px; border:1px solid #e2e8f0; overflow:hidden; max-width:640px; margin:0 auto; }
    .tf-header { background:linear-gradient(135deg,#1e3a8a,#1d4ed8); padding:24px 28px; }
    .tf-header h2 { font-size:1.2rem; font-weight:800; color:#fff; margin:0 0 4px; }
    .tf-header p  { font-size:.84rem; color:rgba(255,255,255,.72); margin:0; }
    .tf-body { padding:28px; }
    .tf-field { margin-bottom:20px; }
    .tf-field label { display:block; font-size:.82rem; font-weight:600; color:#334155; margin-bottom:6px; }
    .tf-field .form-control, .tf-field select {
        border:1.5px solid #e2e8f0; border-radius:10px;
        padding:10px 14px; font-size:.9rem; width:100%;
        transition:border-color .15s, box-shadow .15s;
    }
    .tf-field .form-control:focus, .tf-field select:focus {
        border-color:#1d4ed8; box-shadow:0 0 0 3px rgba(29,78,216,.1); outline:none;
    }
    .tf-field .invalid-feedback { font-size:.78rem; color:#ef4444; margin-top:4px; }
    .tf-field .form-control.is-invalid { border-color:#ef4444; }
    .tf-field .hint { font-size:.75rem; color:#94a3b8; margin-top:4px; }

    .arrow-row {
        display:flex; align-items:center; justify-content:center;
        gap:12px; padding:4px 0 20px;
    }
    .arrow-row .acct-pill {
        flex:1; background:#f8fafc; border:1px solid #e2e8f0;
        border-radius:10px; padding:10px 14px; font-size:.84rem;
        font-weight:600; color:#334155; text-align:center; min-height:44px;
        display:flex; align-items:center; justify-content:center;
    }
    .arrow-row .arrow { flex-shrink:0; color:#1d4ed8; font-size:1.5rem; }

    .tf-submit {
        width:100%; background:linear-gradient(135deg,#1d4ed8,#0ea5e9);
        color:#fff; font-weight:700; font-size:.95rem;
        padding:12px; border-radius:10px; border:none; cursor:pointer;
        transition:opacity .15s;
    }
    .tf-submit:hover { opacity:.9; }

    .acct-option-group { font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#94a3b8; }
</style>
@endsection

@section('content')
<div class="transfer-card">
    <div class="tf-header">
        <h2><i class="material-icons-round me-2" style="font-size:1.1rem;vertical-align:middle;">compare_arrows</i>New Transfer</h2>
        <p>Move money between your accounts. Balances will update instantly.</p>
    </div>

    <div class="tf-body">
        @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:20px;">
            @foreach($errors->all() as $e)
            <div style="font-size:.84rem;color:#991b1b;">{{ $e }}</div>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('transfers.store') }}" id="tfForm">
            @csrf

            {{-- Visual arrow row (updates live via JS) --}}
            <div class="arrow-row">
                <div class="acct-pill" id="fromLabel">— Select source —</div>
                <span class="arrow material-icons-round">arrow_forward</span>
                <div class="acct-pill" id="toLabel">— Select destination —</div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="tf-field">
                        <label for="from_account">From Account</label>
                        <select name="from_account" id="from_account" required
                                class="@error('from_account') is-invalid @enderror"
                                onchange="updateLabels()">
                            <option value="">— Select —</option>
                            @foreach($accounts->groupBy('Nature') as $nature => $grp)
                            <optgroup label="{{ $nature }}" class="acct-option-group">
                                @foreach($grp as $a)
                                <option value="{{ $a->id }}"
                                    data-balance="{{ $a->Balance ?? 0 }}"
                                    data-name="{{ $a->category }}"
                                    {{ old('from_account') == $a->id ? 'selected' : '' }}>
                                    {{ $a->category }} (R{{ number_format($a->Balance ?? 0, 2) }})
                                </option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                        @error('from_account') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="hint" id="fromBalance"></div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="tf-field">
                        <label for="to_account">To Account</label>
                        <select name="to_account" id="to_account" required
                                class="@error('to_account') is-invalid @enderror"
                                onchange="updateLabels()">
                            <option value="">— Select —</option>
                            @foreach($accounts->groupBy('Nature') as $nature => $grp)
                            <optgroup label="{{ $nature }}">
                                @foreach($grp as $a)
                                <option value="{{ $a->id }}"
                                    data-name="{{ $a->category }}"
                                    {{ old('to_account') == $a->id ? 'selected' : '' }}>
                                    {{ $a->category }} (R{{ number_format($a->Balance ?? 0, 2) }})
                                </option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                        @error('to_account') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="tf-field">
                <label for="amount">Amount (ZAR)</label>
                <input type="number" name="amount" id="amount" step="0.01" min="0.01"
                       value="{{ old('amount') }}"
                       class="form-control @error('amount') is-invalid @enderror"
                       placeholder="0.00" required
                       oninput="updatePreview()">
                @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="hint" id="amountPreview"></div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="tf-field">
                        <label for="transfer_date">Transfer Date</label>
                        <input type="date" name="transfer_date" id="transfer_date"
                               value="{{ old('transfer_date', date('Y-m-d')) }}"
                               class="form-control @error('transfer_date') is-invalid @enderror" required>
                        @error('transfer_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="tf-field">
                        <label for="reference">Reference <span style="font-weight:400;color:#94a3b8;">(optional)</span></label>
                        <input type="text" name="reference" id="reference"
                               value="{{ old('reference') }}"
                               class="form-control" placeholder="e.g. TRF-001">
                    </div>
                </div>
            </div>

            <div class="tf-field">
                <label for="description">Description <span style="font-weight:400;color:#94a3b8;">(optional)</span></label>
                <input type="text" name="description" id="description"
                       value="{{ old('description') }}"
                       class="form-control" placeholder="e.g. Credit card payment, savings deposit">
            </div>

            <button type="submit" class="tf-submit">
                <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">compare_arrows</i>
                Record Transfer
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function getSelected(id) {
    var sel = document.getElementById(id);
    var opt = sel.options[sel.selectedIndex];
    return opt && opt.value ? opt : null;
}
function updateLabels() {
    var from = getSelected('from_account');
    var to   = getSelected('to_account');
    document.getElementById('fromLabel').textContent = from ? from.dataset.name : '— Select source —';
    document.getElementById('toLabel').textContent   = to   ? to.dataset.name   : '— Select destination —';
    if (from) {
        var bal = parseFloat(from.dataset.balance || 0);
        document.getElementById('fromBalance').textContent =
            'Current balance: R' + bal.toLocaleString('en-ZA', {minimumFractionDigits:2});
    }
    updatePreview();
}
function updatePreview() {
    var amt  = parseFloat(document.getElementById('amount').value || 0);
    var from = getSelected('from_account');
    var to   = getSelected('to_account');
    if (amt > 0 && from && to) {
        var fromBal = parseFloat(from.dataset.balance || 0);
        document.getElementById('amountPreview').textContent =
            from.dataset.name + ' will go from R' +
            fromBal.toLocaleString('en-ZA',{minimumFractionDigits:2}) + ' → R' +
            (fromBal - amt).toLocaleString('en-ZA',{minimumFractionDigits:2});
    } else {
        document.getElementById('amountPreview').textContent = '';
    }
}
// Init on load if old() values
updateLabels();
</script>
@endsection
