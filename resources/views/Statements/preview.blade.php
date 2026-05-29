@extends('layouts.Nav')

@section('title', 'Preview Import')
@section('page-title', 'Review Transactions Before Import')

@section('breadcrumb')
<li class="breadcrumb-item">Transactions</li>
<li class="breadcrumb-item"><a href="{{ route('statements.import') }}">Import</a></li>
<li class="breadcrumb-item active">Preview</li>
@endsection

@section('head')
<style>
    .pv-stats { display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px; }
    .pv-stat {
        background:#fff;border:1px solid #e2e8f0;border-radius:12px;
        padding:12px 18px;flex:1;min-width:120px;text-align:center;
    }
    .pv-stat-val { font-size:1.3rem;font-weight:800;color:#0f172a; }
    .pv-stat-label { font-size:.7rem;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin-top:2px; }

    .pv-table { width:100%;border-collapse:collapse;font-size:.82rem; }
    .pv-table th {
        font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;
        color:#64748b;padding:10px 12px;background:#f8fafc;
        border-bottom:1px solid #e2e8f0;position:sticky;top:0;z-index:1;
    }
    .pv-table td { padding:8px 12px;border-bottom:1px solid #f8fafc;vertical-align:middle; }
    .pv-table tr.skipped { opacity:.4; }
    .pv-table tr.skipped td { text-decoration:line-through; }

    .pv-select {
        border:1px solid #e2e8f0;border-radius:8px;padding:5px 8px;font-size:.78rem;
        width:100%;min-width:140px;
    }
    .pv-select:focus { border-color:#1d4ed8;outline:none; }

    .skip-btn {
        border:none;background:none;padding:4px 6px;cursor:pointer;
        color:#94a3b8;border-radius:6px;font-size:.75rem;
        transition:color .15s,background .15s;
    }
    .skip-btn:hover { color:#ef4444;background:#fef2f2; }
    .skip-btn.active { color:#ef4444; }

    .amount-paid     { color:#dc2626;font-weight:700; }
    .amount-received { color:#059669;font-weight:700; }

    .map-section { background:#fff;border-radius:14px;border:1px solid #e2e8f0;padding:16px 20px;margin-bottom:16px; }
    .map-section h5 { font-size:.85rem;font-weight:700;color:#0f172a;margin-bottom:12px; }
    .map-row { display:flex;align-items:center;gap:10px;margin-bottom:8px;flex-wrap:wrap; }
    .map-label { font-size:.78rem;color:#64748b;min-width:100px; }
    .map-select { border:1px solid #e2e8f0;border-radius:8px;padding:5px 10px;font-size:.8rem; }

    .import-btn {
        background:linear-gradient(135deg,#059669,#10b981);
        color:#fff;font-weight:700;font-size:.95rem;padding:12px 36px;
        border-radius:10px;border:none;cursor:pointer;transition:opacity .15s;
    }
    .import-btn:hover { opacity:.9; }

    .bulk-bar {
        position:sticky;bottom:0;background:#fff;border-top:1px solid #e2e8f0;
        padding:14px 20px;display:flex;align-items:center;justify-content:space-between;
        gap:12px;flex-wrap:wrap;z-index:10;
    }
    .sel-all-btn {
        background:none;border:1.5px solid #e2e8f0;border-radius:8px;
        padding:6px 14px;font-size:.8rem;font-weight:600;color:#475569;cursor:pointer;
    }
    .sel-all-btn:hover { border-color:#94a3b8; }
</style>
@endsection

@section('content')

@php
    $dateCol  = $mapping['date']        ?? array_key_first($headers ?? []);
    $descCol  = $mapping['description'] ?? null;
    $amtCol   = $mapping['amount']      ?? null;
    $debitCol = $mapping['debit']       ?? null;
    $creditCol= $mapping['credit']      ?? null;
    $totalRows = count($rows);
@endphp

{{-- Column mapping (shown if auto-detect may be wrong) --}}
<div class="map-section">
    <h5><i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;color:#64748b;">tune</i>Column Mapping — {{ strtoupper($bank) }}</h5>
    <p style="font-size:.78rem;color:#94a3b8;margin-bottom:12px;">We've auto-detected the columns. Adjust if anything looks wrong.</p>
    <div class="row g-2">
        @foreach([
            ['date',        'Date column'],
            ['description', 'Description column'],
            ['amount',      'Amount column (single)'],
            ['debit',       'Debit column'],
            ['credit',      'Credit column'],
        ] as $col)
        <div class="col-12 col-md-4">
            <div class="map-row">
                <span class="map-label">{{ $col[1] }}</span>
                <select class="map-select" name="col_{{ $col[0] }}" id="map_{{ $col[0] }}" onchange="updateMapping()">
                    <option value="">— None —</option>
                    @foreach(array_keys($rows[0] ?? []) as $h)
                    <option value="{{ $h }}" {{ ($mapping[$col[0]] ?? '') === $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Stats --}}
<div class="pv-stats">
    <div class="pv-stat">
        <div class="pv-stat-val" id="statTotal">{{ $totalRows }}</div>
        <div class="pv-stat-label">Rows found</div>
    </div>
    <div class="pv-stat">
        <div class="pv-stat-val" id="statImporting" style="color:#059669;">{{ $totalRows }}</div>
        <div class="pv-stat-label">Will import</div>
    </div>
    <div class="pv-stat">
        <div class="pv-stat-val" id="statSkipped" style="color:#94a3b8;">0</div>
        <div class="pv-stat-label">Skipped</div>
    </div>
    <div class="pv-stat">
        <div class="pv-stat-val" id="statUncat" style="color:#f59e0b;">{{ collect($suggestions)->filter(fn($v) => !$v)->count() }}</div>
        <div class="pv-stat-label">Uncategorised</div>
    </div>
</div>

{{-- Preview table --}}
<form method="POST" action="{{ route('statements.confirm') }}" id="confirmForm">
    @csrf
    <input type="hidden" name="mapping[date]"        id="hDate"   value="{{ $dateCol }}">
    <input type="hidden" name="mapping[description]" id="hDesc"   value="{{ $descCol }}">
    <input type="hidden" name="mapping[amount]"      id="hAmt"    value="{{ $amtCol }}">
    <input type="hidden" name="mapping[debit]"       id="hDebit"  value="{{ $debitCol }}">
    <input type="hidden" name="mapping[credit]"      id="hCredit" value="{{ $creditCol }}">

    <div class="card" style="border-radius:16px;border:1px solid #e2e8f0;overflow:hidden;">
        <div style="overflow-x:auto;max-height:520px;overflow-y:auto;">
            <table class="pv-table">
                <thead>
                    <tr>
                        <th style="width:36px;">#</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th style="text-align:right;">Amount</th>
                        <th>Category</th>
                        <th style="width:56px;">Skip</th>
                    </tr>
                </thead>
                <tbody id="previewBody">
                    @foreach($rows as $i => $row)
                    @php
                        $date  = $row[$dateCol]  ?? '';
                        $desc  = $row[$descCol]  ?? '';
                        $sugCat = $suggestions[$i] ?? null;

                        if ($amtCol) {
                            $raw = (float) preg_replace('/[^0-9.\-]/', '', str_replace(',', '', $row[$amtCol] ?? '0'));
                            $amt = abs($raw);
                            $isPaid = $raw < 0;
                        } else {
                            $deb = (float) preg_replace('/[^0-9.]/', '', str_replace(',', '', $row[$debitCol ?? ''] ?? '0'));
                            $crd = (float) preg_replace('/[^0-9.]/', '', str_replace(',', '', $row[$creditCol ?? ''] ?? '0'));
                            $amt = max($deb, $crd);
                            $isPaid = $deb > 0;
                        }
                    @endphp
                    <tr id="row-{{ $i }}" class="{{ $sugCat ? '' : '' }}">
                        <td style="color:#94a3b8;">{{ $i + 1 }}</td>
                        <td style="white-space:nowrap;color:#64748b;">{{ $date }}</td>
                        <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $desc }}">{{ $desc }}</td>
                        <td style="text-align:right;" class="{{ $isPaid ? 'amount-paid' : 'amount-received' }}">
                            {{ $isPaid ? '-' : '+' }}R{{ number_format($amt, 2) }}
                        </td>
                        <td>
                            <select name="categories[{{ $i }}]" class="pv-select" id="cat-{{ $i }}" onchange="updateStats()">
                                <option value="">— Assign category —</option>
                                @foreach($categories->groupBy('Nature') as $nature => $grp)
                                <optgroup label="{{ $nature }}">
                                    @foreach($grp as $c)
                                    <option value="{{ $c->id }}" {{ $sugCat == $c->id ? 'selected' : '' }}>
                                        {{ $c->category }}
                                    </option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </td>
                        <td style="text-align:center;">
                            <button type="button" class="skip-btn" id="skip-{{ $i }}" onclick="toggleSkip({{ $i }})" title="Skip this row">
                                ✕
                            </button>
                            <input type="checkbox" name="skip[{{ $i }}]" id="skipInp-{{ $i }}" value="1" style="display:none;">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Sticky bottom bar --}}
    <div class="bulk-bar">
        <div class="d-flex gap-2 align-items-center">
            <button type="button" class="sel-all-btn" onclick="skipAll(false)">Include All</button>
            <button type="button" class="sel-all-btn" onclick="skipAll(true)">Skip All</button>
            <span style="font-size:.78rem;color:#94a3b8;">— or —</span>
            <a href="{{ route('statements.import') }}" style="font-size:.8rem;color:#64748b;text-decoration:none;">Start over</a>
        </div>
        <button type="submit" class="import-btn">
            <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">check_circle</i>
            Import <span id="importCount">{{ $totalRows }}</span> Transactions
        </button>
    </div>
</form>

@endsection

@section('scripts')
<script>
var totalRows = {{ $totalRows }};
var skippedSet = new Set();

function toggleSkip(i) {
    var row  = document.getElementById('row-' + i);
    var inp  = document.getElementById('skipInp-' + i);
    var btn  = document.getElementById('skip-' + i);

    if (skippedSet.has(i)) {
        skippedSet.delete(i);
        row.classList.remove('skipped');
        inp.checked = false;
        btn.classList.remove('active');
    } else {
        skippedSet.add(i);
        row.classList.add('skipped');
        inp.checked = true;
        btn.classList.add('active');
    }
    updateStats();
}

function skipAll(skip) {
    for (var i = 0; i < totalRows; i++) {
        if (skip && !skippedSet.has(i))  toggleSkip(i);
        if (!skip && skippedSet.has(i))  toggleSkip(i);
    }
}

function updateStats() {
    var importing = totalRows - skippedSet.size;
    var uncat = 0;
    for (var i = 0; i < totalRows; i++) {
        if (!skippedSet.has(i)) {
            var sel = document.getElementById('cat-' + i);
            if (sel && !sel.value) uncat++;
        }
    }
    document.getElementById('statImporting').textContent = importing;
    document.getElementById('statSkipped').textContent   = skippedSet.size;
    document.getElementById('statUncat').textContent     = uncat;
    document.getElementById('importCount').textContent   = importing;
}

function updateMapping() {
    document.getElementById('hDate').value   = document.getElementById('map_date').value;
    document.getElementById('hDesc').value   = document.getElementById('map_description').value;
    document.getElementById('hAmt').value    = document.getElementById('map_amount').value;
    document.getElementById('hDebit').value  = document.getElementById('map_debit').value;
    document.getElementById('hCredit').value = document.getElementById('map_credit').value;
}

updateStats();
</script>
@endsection
