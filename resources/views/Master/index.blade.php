@extends('layouts.Nav')

@section('title', 'Master Goals')
@section('page-title', 'Master Goals Overview')

@section('breadcrumb')
<li class="breadcrumb-item active">Master Goals</li>
@endsection

@section('content')

{{-- ── Action Bar ── --}}
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('Master') }}" class="btn btn-primary" style="border-radius:10px;font-weight:600;font-size:.88rem;">
        <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">add</i>
        New Master Goal
    </a>
    <a href="{{ route('section') }}" class="btn btn-outline-primary" style="border-radius:10px;font-weight:600;font-size:.88rem;">
        <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">add</i>
        Add Section
    </a>
</div>

@if($masters->isEmpty())
<div class="card text-center py-5" style="border-radius:16px;border:1px solid #e2e8f0;">
    <i class="material-icons-round" style="font-size:3rem;color:#cbd5e1;">tune</i>
    <h5 class="mt-3 mb-1" style="font-weight:700;color:#334155;">No master goals yet</h5>
    <p style="font-size:.88rem;color:#94a3b8;">Create a master goal to organise projects, investments, or large financial objectives.</p>
    <a href="{{ route('Master') }}" class="btn btn-primary mt-2" style="border-radius:10px;">Create your first master goal</a>
</div>
@else

{{-- ── Summary Chart ── --}}
<div class="card mb-4" style="border-radius:16px;border:1px solid #e2e8f0;">
    <div class="card-body p-4">
        <h6 style="font-weight:700;color:#0f172a;margin-bottom:4px;">Budget vs Actual — All Master Goals</h6>
        <p style="font-size:.82rem;color:#64748b;margin-bottom:20px;">Totals aggregated from all sections within each goal.</p>
        <div style="position:relative;height:260px;">
            <canvas id="masterChart"></canvas>
        </div>
    </div>
</div>

{{-- ── Summary Table ── --}}
<div class="card mb-4" style="border-radius:16px;border:1px solid #e2e8f0;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0" style="font-size:.88rem;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Goal</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Budget (Sections)</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Actual (Sections)</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Variance</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($masters as $m)
                    @php
                        $variance = $m->total_budget - $m->total_actual;
                        $pct = $m->total_budget > 0
                            ? min(100, round(($m->total_actual / $m->total_budget) * 100, 1))
                            : 0;
                        $varColor = $variance >= 0 ? '#059669' : '#dc2626';
                    @endphp
                    <tr style="border-color:#f8fafc;">
                        <td style="padding:12px 20px;font-weight:600;color:#0f172a;border-color:#f8fafc;">{{ $m->Name }}</td>
                        <td style="padding:12px 20px;color:#1d4ed8;font-weight:700;border-color:#f8fafc;">R {{ number_format($m->total_budget, 2) }}</td>
                        <td style="padding:12px 20px;color:#334155;font-weight:700;border-color:#f8fafc;">R {{ number_format($m->total_actual, 2) }}</td>
                        <td style="padding:12px 20px;font-weight:700;color:{{ $varColor }};border-color:#f8fafc;">
                            {{ $variance >= 0 ? '+' : '' }}R {{ number_format($variance, 2) }}
                        </td>
                        <td style="padding:12px 20px;border-color:#f8fafc;min-width:140px;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="flex:1;height:8px;background:#e2e8f0;border-radius:4px;overflow:hidden;">
                                    <div style="height:100%;width:{{ $pct }}%;background:{{ $pct >= 100 ? '#ef4444' : ($pct >= 75 ? '#f59e0b' : '#1d4ed8') }};border-radius:4px;"></div>
                                </div>
                                <span style="font-size:.75rem;font-weight:700;color:#64748b;white-space:nowrap;">{{ $pct }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @php
                        $grandBudget = $masters->sum('total_budget');
                        $grandActual = $masters->sum('total_actual');
                        $grandVar    = $grandBudget - $grandActual;
                    @endphp
                    <tr style="background:#f8fafc;font-weight:700;">
                        <td style="padding:12px 20px;color:#64748b;font-size:.78rem;text-transform:uppercase;letter-spacing:.05em;border-color:#f1f5f9;">Total</td>
                        <td style="padding:12px 20px;color:#1d4ed8;border-color:#f1f5f9;">R {{ number_format($grandBudget, 2) }}</td>
                        <td style="padding:12px 20px;color:#334155;border-color:#f1f5f9;">R {{ number_format($grandActual, 2) }}</td>
                        <td style="padding:12px 20px;color:{{ $grandVar >= 0 ? '#059669' : '#dc2626' }};border-color:#f1f5f9;">
                            {{ $grandVar >= 0 ? '+' : '' }}R {{ number_format($grandVar, 2) }}
                        </td>
                        <td style="border-color:#f1f5f9;"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

{{-- ── Per-Goal Accordion ── --}}
@foreach($masters as $goal)
@php
    $goalSections = $Section->where('master', $goal->id);
    $goalBudget   = $goalSections->sum('budget');
    $goalActual   = $goalSections->sum('actual');
    $goalVariance = $goalBudget - $goalActual;
    $goalPct      = $goalBudget > 0 ? min(100, round(($goalActual / $goalBudget) * 100, 1)) : 0;
@endphp
<div class="card mb-3" style="border-radius:16px;border:1px solid #e2e8f0;">
    {{-- Accordion header --}}
    <div class="card-header d-flex align-items-center justify-content-between"
         style="cursor:pointer;padding:16px 20px;background:#f8fafc;border-bottom:none;border-radius:16px;"
         data-bs-toggle="collapse" data-bs-target="#master-{{ $goal->id }}">
        <div style="flex:1;">
            <div style="font-size:1rem;font-weight:700;color:#0f172a;">{{ $goal->Name }}</div>
            @if($goal->description)
            <div style="font-size:.78rem;color:#94a3b8;margin-top:2px;">{{ $goal->description }}</div>
            @endif
        </div>
        <div class="d-flex align-items-center gap-3 me-3">
            <div class="text-center">
                <div style="font-size:.68rem;color:#94a3b8;">Budget</div>
                <div style="font-size:.88rem;font-weight:700;color:#1d4ed8;">R {{ number_format($goalBudget, 2) }}</div>
            </div>
            <div class="text-center">
                <div style="font-size:.68rem;color:#94a3b8;">Actual</div>
                <div style="font-size:.88rem;font-weight:700;color:#334155;">R {{ number_format($goalActual, 2) }}</div>
            </div>
            <div class="text-center">
                <div style="font-size:.68rem;color:#94a3b8;">Variance</div>
                <div style="font-size:.88rem;font-weight:700;color:{{ $goalVariance >= 0 ? '#059669' : '#dc2626' }};">
                    R {{ number_format($goalVariance, 2) }}
                </div>
            </div>
            <div style="min-width:80px;">
                <div style="height:6px;background:#e2e8f0;border-radius:3px;overflow:hidden;margin-bottom:3px;">
                    <div style="height:100%;width:{{ $goalPct }}%;background:{{ $goalPct >= 100 ? '#ef4444' : '#1d4ed8' }};border-radius:3px;"></div>
                </div>
                <div style="font-size:.7rem;color:#94a3b8;text-align:right;">{{ $goalPct }}%</div>
            </div>
        </div>
        <i class="material-icons-round" style="color:#94a3b8;font-size:1.2rem;">expand_more</i>
    </div>

    {{-- Accordion body --}}
    <div id="master-{{ $goal->id }}" class="collapse">
        <div class="card-body p-4">
            @if($goalSections->isEmpty())
            <div class="text-center py-3">
                <p style="font-size:.85rem;color:#94a3b8;">No sections added yet.</p>
                <a href="{{ route('section') }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;">Add a Section</a>
            </div>
            @else
            <div class="row g-3">
                @foreach($goalSections as $section)
                @php
                    $secPct = $section->budget > 0
                        ? min(100, round(($section->actual / $section->budget) * 100, 1))
                        : 0;
                    $secColor = $secPct >= 100 ? '#ef4444' : ($secPct >= 75 ? '#f59e0b' : '#1d4ed8');
                @endphp
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100" style="border-radius:14px;border:1px solid #e2e8f0;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 style="font-size:.9rem;font-weight:700;color:#0f172a;margin:0;">{{ $section->section }}</h6>
                                <span style="font-size:.72rem;background:#f1f5f9;color:#64748b;border-radius:50px;padding:2px 8px;font-weight:600;white-space:nowrap;margin-left:8px;">
                                    {{ $section->status }}
                                </span>
                            </div>

                            {{-- Progress bar --}}
                            <div style="margin-bottom:10px;">
                                <div style="display:flex;justify-content:space-between;margin-bottom:3px;">
                                    <span style="font-size:.7rem;color:#94a3b8;">Progress</span>
                                    <span style="font-size:.72rem;font-weight:700;color:{{ $secColor }};">{{ $secPct }}%</span>
                                </div>
                                <div style="height:8px;background:#e2e8f0;border-radius:4px;overflow:hidden;">
                                    <div style="height:100%;width:{{ $secPct }}%;background:{{ $secColor }};border-radius:4px;transition:width .4s;"></div>
                                </div>
                            </div>

                            {{-- Amounts --}}
                            <div class="d-flex gap-2 mb-3">
                                <div style="flex:1;background:#f8fafc;border-radius:8px;padding:8px;text-align:center;">
                                    <div style="font-size:.65rem;color:#94a3b8;">Budget</div>
                                    <div style="font-size:.88rem;font-weight:700;color:#1d4ed8;">R {{ number_format($section->budget, 2) }}</div>
                                </div>
                                <div style="flex:1;background:#f8fafc;border-radius:8px;padding:8px;text-align:center;">
                                    <div style="font-size:.65rem;color:#94a3b8;">Actual</div>
                                    <div style="font-size:.88rem;font-weight:700;color:#334155;">R {{ number_format($section->actual, 2) }}</div>
                                </div>
                                <div style="flex:1;background:#f8fafc;border-radius:8px;padding:8px;text-align:center;">
                                    <div style="font-size:.65rem;color:#94a3b8;">Balance</div>
                                    @php $secVar = $section->budget - $section->actual; @endphp
                                    <div style="font-size:.88rem;font-weight:700;color:{{ $secVar >= 0 ? '#059669' : '#dc2626' }};">
                                        R {{ number_format($secVar, 2) }}
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="d-flex gap-1">
                                <a href="{{ route('master.show', $section->id) }}"
                                   class="btn btn-sm btn-outline-info flex-fill"
                                   style="border-radius:7px;font-size:.75rem;">Details</a>
                                <a href="{{ route('section.edit', $section->id) }}"
                                   class="btn btn-sm btn-outline-secondary flex-fill"
                                   style="border-radius:7px;font-size:.75rem;">Edit</a>
                                <form action="{{ route('section.delete', $section->id) }}" method="POST" class="flex-fill">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger w-100"
                                            style="border-radius:7px;font-size:.75rem;"
                                            onclick="return confirm('Delete section \'{{ addslashes($section->section) }}\'?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endforeach

@endif

@endsection

@section('scripts')
@php
    $chartData = [
        'labels'  => $masters->pluck('Name')->values(),
        'budgets' => $masters->pluck('total_budget')->map(fn($v) => (float) $v)->values(),
        'actuals' => $masters->pluck('total_actual')->map(fn($v) => (float) $v)->values(),
    ];
@endphp
<script>
var cd = @json($chartData);

if (document.getElementById('masterChart') && cd.labels.length) {
    new Chart(document.getElementById('masterChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: cd.labels,
            datasets: [
                {
                    label: 'Budget',
                    data: cd.budgets,
                    backgroundColor: 'rgba(29,78,216,0.7)',
                    borderRadius: 6,
                    borderSkipped: false
                },
                {
                    label: 'Actual',
                    data: cd.actuals,
                    backgroundColor: 'rgba(14,165,233,0.7)',
                    borderRadius: 6,
                    borderSkipped: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { font: { size: 11 } } },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ctx.dataset.label + ': R' + Number(ctx.parsed.y).toLocaleString('en-ZA', { minimumFractionDigits: 2 });
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { size: 10 },
                        callback: function(v) { return 'R' + Number(v).toLocaleString(); }
                    }
                },
                x: { ticks: { font: { size: 11 } } }
            }
        }
    });
}
</script>
@endsection
