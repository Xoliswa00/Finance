@extends('layouts.Nav')

@section('title', 'Import Bank Statement')
@section('page-title', 'Import Bank Statement')

@section('breadcrumb')
<li class="breadcrumb-item">Transactions</li>
<li class="breadcrumb-item active">Import Statement</li>
@endsection

@section('head')
<style>
    .imp-card { background:#fff; border-radius:20px; border:1px solid #e2e8f0; overflow:hidden; max-width:680px; margin:0 auto; }
    .imp-header { background:linear-gradient(135deg,#059669,#10b981); padding:24px 28px; }
    .imp-header h2 { font-size:1.2rem;font-weight:800;color:#fff;margin:0 0 4px; }
    .imp-header p  { font-size:.84rem;color:rgba(255,255,255,.75);margin:0; }
    .imp-body { padding:28px; }
    .imp-field { margin-bottom:20px; }
    .imp-field label { display:block;font-size:.82rem;font-weight:600;color:#334155;margin-bottom:6px; }
    .imp-field select, .imp-field input[type=file] {
        border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:.9rem;width:100%;
        transition:border-color .15s;
    }
    .imp-field select:focus, .imp-field input[type=file]:focus {
        border-color:#059669; box-shadow:0 0 0 3px rgba(5,150,105,.1); outline:none;
    }
    .imp-field .hint { font-size:.75rem;color:#94a3b8;margin-top:4px; }
    .imp-submit {
        width:100%; background:linear-gradient(135deg,#059669,#10b981);
        color:#fff;font-weight:700;font-size:.95rem;padding:12px;border-radius:10px;
        border:none;cursor:pointer;transition:opacity .15s;
    }
    .imp-submit:hover { opacity:.9; }
    .bank-card {
        border:1.5px solid #e2e8f0; border-radius:12px; padding:14px;
        cursor:pointer; transition:border-color .15s,background .15s;
        text-align:center; position:relative;
    }
    .bank-card:hover { border-color:#059669; background:#f0fdf4; }
    .bank-card.selected { border-color:#059669; background:#f0fdf4; }
    .bank-card input[type=radio] { position:absolute;opacity:0; }
    .bank-card .bank-name { font-size:.88rem;font-weight:700;color:#334155;margin-top:4px; }
    .bank-card .bank-tag  { font-size:.7rem;color:#94a3b8;margin-top:2px; }
    .step-badge {
        display:inline-flex;align-items:center;justify-content:center;
        width:28px;height:28px;border-radius:50%;
        background:#f0fdf4;color:#059669;font-weight:800;font-size:.85rem;
        flex-shrink:0;
    }
    .step-row { display:flex;align-items:flex-start;gap:14px;margin-bottom:20px; }
    .step-row .step-text h5 { font-size:.9rem;font-weight:700;color:#0f172a;margin-bottom:2px; }
    .step-row .step-text p  { font-size:.82rem;color:#64748b;margin:0; }

    .dropzone {
        border:2px dashed #e2e8f0; border-radius:14px;
        padding:36px 20px; text-align:center;
        transition:border-color .15s,background .15s;
        cursor:pointer;
    }
    .dropzone:hover, .dropzone.dragover { border-color:#059669; background:#f0fdf4; }
    .dropzone i { font-size:2.5rem;color:#cbd5e1;display:block;margin-bottom:10px; }
    .dropzone .dz-main { font-size:.9rem;font-weight:600;color:#334155; }
    .dropzone .dz-sub  { font-size:.78rem;color:#94a3b8;margin-top:4px; }
    #fileInput { display:none; }
    .file-chosen { font-size:.84rem;color:#059669;font-weight:600;margin-top:8px; }
</style>
@endsection

@section('content')
<div class="imp-card">
    <div class="imp-header">
        <h2><i class="material-icons-round me-2" style="font-size:1.1rem;vertical-align:middle;">upload_file</i>Import Bank Statement</h2>
        <p>Download your CSV statement from online banking, upload it here, and we'll parse and categorise the transactions for you.</p>
    </div>

    <div class="imp-body">

        {{-- How it works --}}
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:16px 18px;margin-bottom:24px;">
            <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#166534;margin-bottom:12px;">How this works</div>
            <div class="step-row">
                <div class="step-badge">1</div>
                <div class="step-text">
                    <h5>Download your CSV</h5>
                    <p>Log into your online banking (FNB, Capitec, Standard Bank, ABSA, Nedbank) and download your statement as CSV or Excel (saved as CSV).</p>
                </div>
            </div>
            <div class="step-row">
                <div class="step-badge">2</div>
                <div class="step-text">
                    <h5>Upload it here</h5>
                    <p>Select your bank and upload the file. We'll auto-detect the column layout.</p>
                </div>
            </div>
            <div class="step-row" style="margin-bottom:0;">
                <div class="step-badge">3</div>
                <div class="step-text">
                    <h5>Review and import</h5>
                    <p>Preview all transactions, assign categories, skip any you don't want, then import in bulk. Duplicates are automatically detected and skipped.</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('statements.upload') }}" enctype="multipart/form-data" id="impForm">
            @csrf

            {{-- Bank selector --}}
            <div class="imp-field">
                <label>Your Bank</label>
                <div class="row g-2">
                    @foreach([
                        ['fnb',          'FNB',           'First National Bank'],
                        ['standard_bank','Standard Bank', 'Standard Bank SA'],
                        ['absa',         'ABSA',          'ABSA Bank'],
                        ['nedbank',      'Nedbank',        'Nedbank SA'],
                        ['capitec',      'Capitec',        'Capitec Bank'],
                        ['other',        'Other',          'Generic CSV format'],
                    ] as $b)
                    <div class="col-6 col-md-4">
                        <label class="bank-card" id="card-{{ $b[0] }}" onclick="selectBank('{{ $b[0] }}')">
                            <input type="radio" name="bank" value="{{ $b[0] }}" id="bank-{{ $b[0] }}" {{ old('bank') === $b[0] ? 'checked' : '' }}>
                            <div class="bank-name">{{ $b[1] }}</div>
                            <div class="bank-tag">{{ $b[2] }}</div>
                        </label>
                    </div>
                    @endforeach
                </div>
                @error('bank') <div style="font-size:.78rem;color:#ef4444;margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            {{-- File upload --}}
            <div class="imp-field">
                <label>CSV Statement File</label>
                <div class="dropzone" id="dropzone" onclick="document.getElementById('fileInput').click()"
                     ondragover="event.preventDefault();this.classList.add('dragover')"
                     ondragleave="this.classList.remove('dragover')"
                     ondrop="handleDrop(event)">
                    <i class="material-icons-round">cloud_upload</i>
                    <div class="dz-main">Click to browse or drag your CSV here</div>
                    <div class="dz-sub">CSV or TXT file · max 4 MB</div>
                    <div class="file-chosen" id="fileChosen" style="display:none;"></div>
                </div>
                <input type="file" name="statement" id="fileInput" accept=".csv,.txt" onchange="showFile(this)">
                @error('statement') <div style="font-size:.78rem;color:#ef4444;margin-top:4px;">{{ $message }}</div> @enderror
                <div class="hint">Most SA banks let you export statements as CSV from their website or app.</div>
            </div>

            <button type="submit" class="imp-submit" id="impBtn" disabled>
                <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">upload</i>
                Upload and Preview
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
var selectedBank = '{{ old('bank', '') }}';

function selectBank(val) {
    selectedBank = val;
    document.querySelectorAll('.bank-card').forEach(function(c) { c.classList.remove('selected'); });
    document.getElementById('card-' + val).classList.add('selected');
    document.getElementById('bank-' + val).checked = true;
    checkReady();
}

function showFile(input) {
    if (input.files && input.files[0]) {
        var el = document.getElementById('fileChosen');
        el.textContent = '✓ ' + input.files[0].name;
        el.style.display = 'block';
    }
    checkReady();
}

function handleDrop(e) {
    e.preventDefault();
    document.getElementById('dropzone').classList.remove('dragover');
    var dt = e.dataTransfer;
    if (dt.files && dt.files[0]) {
        var inp = document.getElementById('fileInput');
        // Create a new DataTransfer to assign files to input
        var dtn = new DataTransfer();
        dtn.items.add(dt.files[0]);
        inp.files = dtn.files;
        showFile(inp);
    }
}

function checkReady() {
    var hasFile = document.getElementById('fileInput').files.length > 0;
    document.getElementById('impBtn').disabled = !(selectedBank && hasFile);
}

// Restore selection on back
if (selectedBank) selectBank(selectedBank);
</script>
@endsection
