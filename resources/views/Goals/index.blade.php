@extends('layouts.Nav')

@section('title', 'Goals')
@section('page-title', 'Financial Goals')

@section('breadcrumb')
<li class="breadcrumb-item active">Goals</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        {{ $goals->total() }} goal{{ $goals->total() !== 1 ? 's' : '' }} · savings, repayments &amp; investments
    </p>
    <a href="{{ route('goals.create') }}" class="btn btn-primary" style="border-radius:10px;font-weight:600;font-size:.88rem;">
        <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">add</i> New Goal
    </a>
</div>

@if($goals->isEmpty())
<div class="card text-center py-5" style="border-radius:16px;border:1px solid #e2e8f0;">
    <i class="material-icons-round" style="font-size:3rem;color:#cbd5e1;">flag</i>
    <h5 class="mt-3 mb-1" style="font-weight:700;color:#334155;">No goals yet</h5>
    <p style="font-size:.88rem;color:#94a3b8;max-width:380px;margin:8px auto 0;">
        Set a financial goal to start tracking your progress — savings, debt repayment, or investments.
    </p>
    <a href="{{ route('goals.create') }}" class="btn btn-primary mt-3" style="border-radius:10px;">Create your first goal</a>
</div>
@else
<div class="card" style="border-radius:16px;border:1px solid #e2e8f0;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0" style="font-size:.88rem;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Goal</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Type</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Progress</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Target</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Target Date</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;">Status</th>
                        <th style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border:none;padding:12px 20px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($goals as $goal)
                    @php
                        $isRepayment = $goal->goal_category === 'Repayment';
                        $target = abs($goal->target_amount);
                        $current = abs($goal->current_amount);
                        $pct = $target > 0 ? min(100, round(($current / $target) * 100)) : 0;
                        $achieved = $isRepayment ? ($goal->target_amount >= ($goal->current_amount) * -1) === false : $current >= $target;
                    @endphp
                    <tr style="border-color:#f8fafc;">
                        <td style="padding:14px 20px;border-color:#f8fafc;">
                            <div style="font-weight:600;color:#0f172a;">{{ $goal->title }}</div>
                            @if($goal->description)
                            <div style="font-size:.75rem;color:#94a3b8;margin-top:2px;">{{ Str::limit($goal->description, 55) }}</div>
                            @endif
                        </td>
                        <td style="padding:14px 20px;border-color:#f8fafc;">
                            @php
                                $typeCfg = [
                                    'Saving'     => ['bg'=>'#f0fdf4','color'=>'#16a34a'],
                                    'Repayment'  => ['bg'=>'#fff1f2','color'=>'#e11d48'],
                                    'Investing'  => ['bg'=>'#eff6ff','color'=>'#1d4ed8'],
                                ];
                                $cfg = $typeCfg[$goal->goal_category] ?? ['bg'=>'#f1f5f9','color'=>'#64748b'];
                            @endphp
                            <span style="font-size:.74rem;background:{{ $cfg['bg'] }};color:{{ $cfg['color'] }};border-radius:50px;padding:3px 10px;font-weight:600;">
                                {{ $goal->goal_category }}
                            </span>
                        </td>
                        <td style="padding:14px 20px;border-color:#f8fafc;min-width:140px;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="flex:1;background:#f1f5f9;border-radius:4px;height:6px;overflow:hidden;">
                                    <div style="width:{{ $pct }}%;height:100%;background:{{ $achieved ? '#16a34a' : '#1d4ed8' }};border-radius:4px;"></div>
                                </div>
                                <span style="font-size:.75rem;font-weight:700;color:{{ $achieved ? '#16a34a' : '#1d4ed8' }};white-space:nowrap;">{{ $pct }}%</span>
                            </div>
                        </td>
                        <td style="padding:14px 20px;border-color:#f8fafc;">
                            <div style="font-weight:700;color:#0f172a;white-space:nowrap;">ZAR {{ number_format($goal->target_amount, 2) }}</div>
                            <div style="font-size:.74rem;color:#94a3b8;">Current: ZAR {{ number_format($goal->current_amount, 2) }}</div>
                        </td>
                        <td style="padding:14px 20px;color:#64748b;white-space:nowrap;border-color:#f8fafc;">{{ $goal->end_date }}</td>
                        <td style="padding:14px 20px;border-color:#f8fafc;">
                            @if($achieved)
                            <span style="font-size:.75rem;background:#f0fdf4;color:#16a34a;border-radius:50px;padding:3px 10px;font-weight:600;">
                                <i class="material-icons-round" style="font-size:.75rem;vertical-align:middle;">check_circle</i> Achieved
                            </span>
                            @else
                            <span style="font-size:.75rem;background:#eff6ff;color:#1d4ed8;border-radius:50px;padding:3px 10px;font-weight:600;">In Progress</span>
                            @endif
                        </td>
                        <td style="padding:14px 20px;border-color:#f8fafc;text-align:right;white-space:nowrap;">
                            <a href="{{ route('goals.edit', $goal->id) }}"
                               class="btn btn-sm btn-outline-secondary"
                               style="border-radius:7px;font-size:.75rem;padding:3px 12px;">Edit</a>
                            <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        style="border-radius:7px;font-size:.75rem;padding:3px 12px;"
                                        onclick="return confirm('Delete goal \'{{ addslashes($goal->title) }}\'?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $goals->links() }}</div>
@endif
@endsection
