<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Reminders — Bright Finance</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;color:#334155;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:32px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

                {{-- Header --}}
                <tr>
                    <td style="background:linear-gradient(135deg,#1e3a8a,#1d4ed8);border-radius:16px 16px 0 0;padding:32px 36px;text-align:center;">
                        <div style="font-size:28px;font-weight:800;color:#ffffff;letter-spacing:-0.5px;">
                            💡 Bright Finance
                        </div>
                        <div style="font-size:14px;color:rgba(255,255,255,0.75);margin-top:6px;">
                            Your financial companion
                        </div>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="background:#ffffff;padding:32px 36px;">

                        <p style="font-size:16px;font-weight:600;color:#0f172a;margin:0 0 6px;">
                            Hi {{ $user->name }} 👋
                        </p>
                        <p style="font-size:14px;color:#64748b;margin:0 0 28px;line-height:1.7;">
                            You have some upcoming items due in the next 7 days. Here's a quick heads-up so nothing catches you off guard.
                        </p>

                        {{-- Upcoming Budget Due Dates --}}
                        @if($upcomingBudgets->count() > 0)
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                            <tr>
                                <td style="padding-bottom:12px;">
                                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#64748b;margin-bottom:10px;">
                                        📋 Budget Payments Due
                                    </div>

                                    @foreach($upcomingBudgets as $budget)
                                    @php
                                        $dueDate = \Carbon\Carbon::parse($budget->due_date);
                                        $daysLeft = now()->startOfDay()->diffInDays($dueDate->startOfDay(), false);
                                        $urgency = $daysLeft <= 2 ? '#fef2f2' : ($daysLeft <= 5 ? '#fff7ed' : '#f0f9ff');
                                        $urgencyBorder = $daysLeft <= 2 ? '#fca5a5' : ($daysLeft <= 5 ? '#fed7aa' : '#bae6fd');
                                        $urgencyLabel = $daysLeft === 0 ? 'Due today' : ($daysLeft === 1 ? 'Due tomorrow' : "Due in {$daysLeft} days");
                                    @endphp
                                    <table width="100%" cellpadding="0" cellspacing="0"
                                           style="background:{{ $urgency }};border:1px solid {{ $urgencyBorder }};border-radius:10px;margin-bottom:8px;">
                                        <tr>
                                            <td style="padding:12px 16px;">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <div style="font-size:14px;font-weight:700;color:#0f172a;">
                                                                {{ $budget->Description }}
                                                            </div>
                                                            <div style="font-size:12px;color:#64748b;margin-top:2px;">
                                                                Budgeted: <strong>ZAR {{ number_format($budget->Amount, 2) }}</strong>
                                                                @if($budget->Limit)
                                                                    &nbsp;·&nbsp; Actual: <strong>ZAR {{ number_format($budget->Limit, 2) }}</strong>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td align="right" style="white-space:nowrap;padding-left:12px;">
                                                            <div style="font-size:11px;font-weight:700;color:#475569;">
                                                                {{ $urgencyLabel }}
                                                            </div>
                                                            <div style="font-size:12px;color:#94a3b8;margin-top:2px;">
                                                                {{ $dueDate?->format('d M Y') ?? '—' }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                        @endif

                        {{-- Upcoming Milestones --}}
                        @if($upcomingMilestones->count() > 0)
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                            <tr>
                                <td>
                                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#64748b;margin-bottom:10px;">
                                        🎯 Goal Milestones Due
                                    </div>

                                    @foreach($upcomingMilestones as $ms)
                                    @php
                                        $msDue = \Carbon\Carbon::parse($ms->due_date);
                                        $msDaysLeft = now()->startOfDay()->diffInDays($msDue->startOfDay(), false);
                                        $msLabel = $msDaysLeft === 0 ? 'Due today' : ($msDaysLeft === 1 ? 'Due tomorrow' : "Due in {$msDaysLeft} days");
                                    @endphp
                                    <table width="100%" cellpadding="0" cellspacing="0"
                                           style="background:#fdf4ff;border:1px solid #e9d5ff;border-radius:10px;margin-bottom:8px;">
                                        <tr>
                                            <td style="padding:12px 16px;">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <div style="font-size:14px;font-weight:700;color:#0f172a;">
                                                                {{ $ms->title }}
                                                            </div>
                                                            <div style="font-size:12px;color:#7c3aed;margin-top:2px;">
                                                                Milestone {{ $ms->milestone_number }}
                                                            </div>
                                                        </td>
                                                        <td align="right" style="white-space:nowrap;padding-left:12px;">
                                                            <div style="font-size:11px;font-weight:700;color:#7c3aed;">
                                                                {{ $msLabel }}
                                                            </div>
                                                            <div style="font-size:12px;color:#94a3b8;margin-top:2px;">
                                                                {{ $msDue?->format('d M Y') ?? '—' }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                        @endif

                        {{-- CTA --}}
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" style="padding:8px 0 24px;">
                                    <a href="{{ url('/home') }}"
                                       style="display:inline-block;background:linear-gradient(135deg,#1d4ed8,#0ea5e9);color:#ffffff;font-weight:700;font-size:14px;padding:13px 36px;border-radius:10px;text-decoration:none;">
                                        View My Dashboard →
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <p style="font-size:12px;color:#94a3b8;line-height:1.7;margin:0;border-top:1px solid #f1f5f9;padding-top:18px;">
                            This reminder was sent because you have items due within the next 7 days in Bright Finance.
                            You will receive at most one reminder email per day.
                        </p>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#f8fafc;border-radius:0 0 16px 16px;padding:20px 36px;text-align:center;border-top:1px solid #e2e8f0;">
                        <p style="font-size:12px;color:#94a3b8;margin:0 0 6px;">
                            © {{ date('Y') }} Bright Finance · Built in South Africa 🇿🇦
                        </p>
                        <p style="font-size:12px;color:#94a3b8;margin:0;">
                            <a href="mailto:bester12@outlook.com" style="color:#1d4ed8;text-decoration:none;">Contact Support</a>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
