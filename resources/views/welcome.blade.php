@extends('layouts.app')

@section('title', 'Bright Finance — Know Where Your Money Goes')

@section('head')
<style>
/* ── Hero ── */
.hero {
    background: linear-gradient(150deg, #0f172a 0%, #1e3a8a 55%, #1d4ed8 100%);
    padding: 90px 0 70px;
    position: relative;
    overflow: hidden;
}
.hero::after {
    content: '';
    position: absolute;
    bottom: -2px; left: 0; right: 0;
    height: 60px;
    background: #f8fafc;
    clip-path: ellipse(55% 100% at 50% 100%);
}
.hero-eyebrow {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 50px;
    padding: 6px 14px;
    font-size: .78rem; font-weight: 600; color: #bfdbfe;
    margin-bottom: 22px;
}
.hero-headline {
    font-size: clamp(2rem, 5vw, 3.4rem);
    font-weight: 800; color: #fff; line-height: 1.15;
    margin-bottom: 18px;
}
.hero-headline span { color: #7dd3fc; }
.hero-sub {
    font-size: 1.05rem; color: rgba(255,255,255,.75);
    line-height: 1.75; max-width: 520px; margin-bottom: 34px;
}
.btn-hero-primary {
    background: #fff; color: #1d4ed8;
    font-weight: 700; font-size: .95rem;
    padding: 14px 32px; border-radius: 10px;
    text-decoration: none; display: inline-block;
    transition: transform .15s, box-shadow .15s;
}
.btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,0,0,.2); color: #1d4ed8; }
.btn-hero-ghost {
    color: rgba(255,255,255,.85); font-weight: 500; font-size: .95rem;
    padding: 14px 22px; border-radius: 10px; text-decoration: none;
    border: 1.5px solid rgba(255,255,255,.3); display: inline-block;
    transition: background .15s;
}
.btn-hero-ghost:hover { background: rgba(255,255,255,.1); color: #fff; }

/* pain points strip */
.pain-strip {
    display: flex; flex-wrap: wrap; gap: 10px; margin-top: 40px;
}
.pain-chip {
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 50px;
    padding: 6px 14px;
    font-size: .8rem; color: rgba(255,255,255,.7);
    display: inline-flex; align-items: center; gap: 6px;
}
.pain-chip::before { content: '✗'; color: #f87171; font-weight: 700; }

/* ── Dashboard mockup ── */
.mockup-shell {
    background: #fff; border-radius: 18px;
    box-shadow: 0 28px 72px rgba(0,0,0,.3);
    overflow: hidden;
}
.mockup-bar {
    background: #f1f5f9; padding: 10px 14px;
    display: flex; align-items: center; gap: 6px;
    border-bottom: 1px solid #e2e8f0;
}
.mdot { width: 10px; height: 10px; border-radius: 50%; }
.mockup-nav {
    background: linear-gradient(180deg,#1e3a8a,#1d4ed8);
    width: 56px; padding: 14px 0;
    display: flex; flex-direction: column; align-items: center; gap: 16px;
}
.mnav-icon { color: rgba(255,255,255,.6); font-size: 1.1rem; }
.mnav-icon.active { color: #fff; }
.mockup-main { flex: 1; padding: 14px; background: #f8fafc; overflow: hidden; }
.m-stat-row { display: flex; gap: 8px; margin-bottom: 10px; }
.m-stat { flex: 1; background: #fff; border-radius: 8px; padding: 10px; border: 1px solid #f1f5f9; }
.m-stat-l { font-size: .62rem; color: #94a3b8; }
.m-stat-v { font-size: .88rem; font-weight: 800; margin-top: 2px; }
.m-chart-bar {
    background: #fff; border-radius: 8px; padding: 10px;
    border: 1px solid #f1f5f9; margin-bottom: 8px;
}
.m-bar-label { font-size: .65rem; color: #64748b; font-weight: 600; margin-bottom: 6px; }
.m-bar-row { display: flex; align-items: center; gap: 6px; margin-bottom: 5px; }
.m-bar-name { font-size: .62rem; color: #475569; min-width: 68px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.m-bar-track { flex: 1; height: 7px; background: #e2e8f0; border-radius: 4px; overflow: hidden; }
.m-bar-fill { height: 100%; border-radius: 4px; }
.m-bar-val { font-size: .6rem; color: #94a3b8; min-width: 40px; text-align: right; }

/* ── Section scaffolding ── */
.sec { padding: 72px 0; }
.sec-alt { background: #fff; }
.sec-label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #1d4ed8; margin-bottom: 8px; }
.sec-title { font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800; color: #0f172a; margin-bottom: 12px; }
.sec-sub { font-size: .98rem; color: #64748b; max-width: 560px; margin: 0 auto 48px; line-height: 1.7; }

/* ── Problem section ── */
.problem-card {
    background: #fff; border-radius: 16px;
    border: 1.5px solid #e2e8f0;
    padding: 24px 20px; height: 100%;
    transition: border-color .2s, box-shadow .2s;
}
.problem-card:hover { border-color: #fca5a5; box-shadow: 0 6px 20px rgba(239,68,68,.06); }
.problem-card .p-emoji { font-size: 2rem; margin-bottom: 12px; display: block; }
.problem-card h5 { font-size: .95rem; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
.problem-card p { font-size: .83rem; color: #64748b; line-height: 1.65; margin: 0; }

/* ── Feature tour ── */
.tour-wrap { background: #fff; border-radius: 20px; border: 1px solid #e2e8f0; overflow: hidden; }
.tour-tabs-row {
    display: flex; border-bottom: 1px solid #e2e8f0;
    overflow-x: auto; padding: 0 20px;
    background: #f8fafc;
}
.t-tab {
    padding: 14px 18px; font-size: .84rem; font-weight: 600;
    color: #64748b; white-space: nowrap; cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: color .15s, border-color .15s; border-top: none;
    border-left: none; border-right: none;
    background: none; display: flex; align-items: center; gap: 7px;
}
.t-tab:hover { color: #1d4ed8; }
.t-tab.active { color: #1d4ed8; border-bottom-color: #1d4ed8; }
.t-tab i { font-size: .9rem; }

.tour-panel-content { display: none; padding: 28px 28px 24px; }
.tour-panel-content.active { display: flex; gap: 32px; flex-wrap: wrap; align-items: flex-start; }
.tour-text { flex: 1; min-width: 220px; }
.tour-text h3 { font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
.tour-text p  { font-size: .88rem; color: #475569; line-height: 1.75; margin-bottom: 14px; }
.tour-text .check-list { list-style: none; padding: 0; margin: 0 0 20px; }
.tour-text .check-list li { font-size: .85rem; color: #334155; padding: 4px 0; display: flex; gap: 8px; }
.tour-text .check-list li::before { content: '✓'; color: #059669; font-weight: 700; flex-shrink: 0; }
.tour-visual { flex: 0 0 auto; width: 280px; }

@media (max-width: 600px) { .tour-visual { width: 100%; } }

.mock-mini {
    background: #f8fafc; border: 1px solid #e2e8f0;
    border-radius: 12px; overflow: hidden;
}
.mock-mini-bar {
    background: #fff; border-bottom: 1px solid #f1f5f9;
    padding: 7px 10px; display: flex; align-items: center; gap: 5px;
}
.mmbar-dot { width: 7px; height: 7px; border-radius: 50%; }
.mock-mini-body { padding: 12px; }

/* ── How it works ── */
.step-line {
    position: relative;
}
.step-line::before {
    content: '';
    position: absolute;
    left: 23px; top: 48px; bottom: 0;
    width: 2px; background: #e2e8f0;
}
.step-line:last-child::before { display: none; }
.step-num {
    width: 46px; height: 46px; border-radius: 50%;
    background: linear-gradient(135deg,#1d4ed8,#0ea5e9);
    color: #fff; font-weight: 800; font-size: 1.1rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; position: relative; z-index: 1;
}
.step-body h5 { font-size: .95rem; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
.step-body p  { font-size: .85rem; color: #64748b; line-height: 1.65; margin: 0; }

/* ── Trust bar ── */
.trust-bar {
    background: #f8fafc; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;
    padding: 28px 0;
}
.trust-item { text-align: center; }
.trust-num  { font-size: 1.8rem; font-weight: 800; color: #1d4ed8; line-height: 1; }
.trust-label { font-size: .78rem; color: #64748b; margin-top: 4px; }

/* ── Social proof ── */
.quote-card {
    background: #fff; border-radius: 16px; border: 1px solid #e2e8f0;
    padding: 24px 22px; height: 100%;
}
.quote-text { font-size: .9rem; color: #334155; line-height: 1.75; margin-bottom: 16px; font-style: italic; }
.quote-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg,#1d4ed8,#0ea5e9);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .9rem; flex-shrink: 0;
}
.quote-name  { font-size: .84rem; font-weight: 700; color: #0f172a; }
.quote-title { font-size: .75rem; color: #94a3b8; }
.stars { color: #f59e0b; font-size: .85rem; margin-bottom: 12px; letter-spacing: 2px; }

/* ── Final CTA ── */
.final-cta {
    background: linear-gradient(150deg,#0f172a,#1e3a8a 60%,#1d4ed8);
    border-radius: 24px; padding: 64px 40px; text-align: center; color: #fff;
    margin: 60px 0;
}
.final-cta h2 { font-size: clamp(1.6rem, 3.5vw, 2.3rem); font-weight: 800; margin-bottom: 12px; }
.final-cta p  { color: rgba(255,255,255,.75); font-size: 1rem; margin-bottom: 28px; }
</style>
@endsection

@section('content')

{{-- ════ HERO ════ --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <div class="hero-eyebrow">
                    <i class="fas fa-bolt" style="font-size:.7rem;"></i>
                    Built for South Africans
                </div>
                <h1 class="hero-headline">
                    Stop wondering<br>
                    where your<br>
                    <span>money went</span>
                </h1>
                <p class="hero-sub">
                    Bright Finance gives you a clear, honest picture of your finances — what's coming in, what's going out, and whether you're making progress on what actually matters.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="btn-hero-primary">Start for free — takes 2 min</a>
                    <a href="#tour" class="btn-hero-ghost">See how it works ↓</a>
                </div>
                <div class="pain-strip">
                    <span class="pain-chip">No idea where my salary went</span>
                    <span class="pain-chip">Can't stick to a budget</span>
                    <span class="pain-chip">Goals feel impossible</span>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="mockup-shell">
                    <div class="mockup-bar">
                        <div class="mdot" style="background:#ef4444;"></div>
                        <div class="mdot" style="background:#f59e0b;"></div>
                        <div class="mdot" style="background:#22c55e;"></div>
                        <span style="font-size:.7rem;color:#94a3b8;margin-left:8px;">brightfinance.app/home</span>
                    </div>
                    <div class="d-flex" style="min-height:260px;">
                        <div class="mockup-nav">
                            <i class="material-icons-round mnav-icon active" style="font-size:1.1rem;">dashboard</i>
                            <i class="material-icons-round mnav-icon" style="font-size:1.1rem;">swap_horiz</i>
                            <i class="material-icons-round mnav-icon" style="font-size:1.1rem;">account_balance_wallet</i>
                            <i class="material-icons-round mnav-icon" style="font-size:1.1rem;">flag</i>
                            <i class="material-icons-round mnav-icon" style="font-size:1.1rem;">bar_chart</i>
                        </div>
                        <div class="mockup-main">
                            <div class="m-stat-row">
                                <div class="m-stat"><div class="m-stat-l">Bank</div><div class="m-stat-v" style="color:#1d4ed8;">R24,500</div></div>
                                <div class="m-stat"><div class="m-stat-l">Income</div><div class="m-stat-v" style="color:#059669;">R18,200</div></div>
                                <div class="m-stat"><div class="m-stat-l">Expenses</div><div class="m-stat-v" style="color:#dc2626;">R9,400</div></div>
                            </div>
                            <div class="m-chart-bar">
                                <div class="m-bar-label">Budget vs Actual</div>
                                @foreach([['Rent','100%','#22c55e','R8,500'],['Groceries','72%','#f59e0b','R2,160'],['Transport','45%','#22c55e','R900'],['Entertainment','28%','#1d4ed8','R420']] as $b)
                                <div class="m-bar-row">
                                    <div class="m-bar-name">{{ $b[0] }}</div>
                                    <div class="m-bar-track"><div class="m-bar-fill" style="width:{{ $b[1] }};background:{{ $b[2] }};"></div></div>
                                    <div class="m-bar-val">{{ $b[3] }}</div>
                                </div>
                                @endforeach
                            </div>
                            <div style="background:#fff;border-radius:8px;border:1px solid #f1f5f9;padding:8px 10px;">
                                <div class="m-bar-label">Active Goals</div>
                                @foreach([['Emergency Fund','65%','#7c3aed'],['Holiday','85%','#059669']] as $g)
                                <div class="m-bar-row">
                                    <div class="m-bar-name">{{ $g[0] }}</div>
                                    <div class="m-bar-track"><div class="m-bar-fill" style="width:{{ $g[1] }};background:{{ $g[2] }};"></div></div>
                                    <div class="m-bar-val" style="color:{{ $g[2] }};font-weight:700;">{{ $g[1] }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ════ PROBLEM SECTION ════ --}}
<section class="sec" style="background:#f8fafc;">
    <div class="container">
        <div class="text-center">
            <div class="sec-label">The Problem</div>
            <h2 class="sec-title">Sound familiar?</h2>
            <p class="sec-sub">Most people aren't bad with money — they just don't have clear enough visibility to make better decisions. That's what Bright Finance fixes.</p>
        </div>
        <div class="row g-3 justify-content-center">
            @php $problems = [
                ['😤', 'Salary disappears by the 20th', 'You earn well, but by the end of the month there\'s nothing left and no idea where it went.'],
                ['📊', 'Spreadsheets are too complicated', 'You\'ve tried Excel, you\'ve tried Google Sheets — they take too long and never stay up to date.'],
                ['🎯', 'Goals feel impossible', 'You want to save for a car, a holiday, or an emergency fund, but there\'s never "enough left over".'],
                ['🧾', 'No idea what you owe', 'Cards, loans, accounts — tracking your total financial position is overwhelming without the right tool.'],
            ]; @endphp
            @foreach($problems as $p)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="problem-card">
                    <span class="p-emoji">{{ $p[0] }}</span>
                    <h5>{{ $p[1] }}</h5>
                    <p>{{ $p[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <p style="font-size:1.1rem;font-weight:700;color:#0f172a;">Bright Finance solves all of this — in one place.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 mt-2" style="border-radius:10px;font-weight:700;">Try it free →</a>
        </div>
    </div>
</section>

{{-- ════ TRUST BAR ════ --}}
<div class="trust-bar">
    <div class="container">
        <div class="row g-3 justify-content-center text-center">
            @foreach([['ZAR','South African currency focus'],['10+','Report types built in'],['34','Categories pre-loaded'],['100%','Free to get started']] as $t)
            <div class="col-6 col-md-3 trust-item">
                <div class="trust-num">{{ $t[0] }}</div>
                <div class="trust-label">{{ $t[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ════ INTERACTIVE FEATURE TOUR ════ --}}
<section class="sec sec-alt" id="tour">
    <div class="container">
        <div class="text-center">
            <div class="sec-label">How It Works</div>
            <h2 class="sec-title">See it in action</h2>
            <p class="sec-sub">Click through the features below to see exactly what Bright Finance does for you.</p>
        </div>
        <div class="tour-wrap">
            <div class="tour-tabs-row" id="tourTabsRow">
                <button class="t-tab active" onclick="switchTour('transactions',this)"><i class="fas fa-exchange-alt"></i> Transactions</button>
                <button class="t-tab" onclick="switchTour('budgets',this)"><i class="fas fa-wallet"></i> Budgets</button>
                <button class="t-tab" onclick="switchTour('goals',this)"><i class="fas fa-bullseye"></i> Goals</button>
                <button class="t-tab" onclick="switchTour('reports',this)"><i class="fas fa-chart-bar"></i> Reports</button>
            </div>

            {{-- Transactions --}}
            <div class="tour-panel-content active" id="tp-transactions">
                <div class="tour-text">
                    <h3>Know where every rand goes</h3>
                    <p>Log every income and expense as it happens. Bright Finance categorises it automatically and builds your financial history — so you can answer "where did my money go?" in seconds.</p>
                    <ul class="check-list">
                        <li>Log salary, freelance income, and side hustles</li>
                        <li>Track groceries, fuel, bills, and everything else</li>
                        <li>Filter and search your full history</li>
                        <li>Export to CSV for your accountant or records</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-primary px-4" style="border-radius:10px;font-weight:700;font-size:.88rem;">Get started →</a>
                </div>
                <div class="tour-visual">
                    <div class="mock-mini">
                        <div class="mock-mini-bar">
                            <div class="mmbar-dot" style="background:#ef4444;"></div>
                            <div class="mmbar-dot" style="background:#f59e0b;"></div>
                            <div class="mmbar-dot" style="background:#22c55e;"></div>
                            <span style="font-size:.65rem;color:#94a3b8;margin-left:6px;">Transactions</span>
                        </div>
                        <div class="mock-mini-body">
                            <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                                <div style="background:#f0fdf4;border-radius:8px;padding:8px 10px;flex:1;margin-right:6px;text-align:center;"><div style="font-size:.62rem;color:#94a3b8;">Income</div><div style="font-size:.9rem;font-weight:800;color:#059669;">R18,500</div></div>
                                <div style="background:#fef2f2;border-radius:8px;padding:8px 10px;flex:1;text-align:center;"><div style="font-size:.62rem;color:#94a3b8;">Expenses</div><div style="font-size:.9rem;font-weight:800;color:#dc2626;">R9,240</div></div>
                            </div>
                            @foreach([['Salary Earned','Income','+R18,500','#059669','#f0fdf4'],['Groceries','Expenses','-R1,240','#dc2626','#fef2f2'],['Fuel','Expenses','-R640','#f59e0b','#fff7ed'],['Rent Paid','Expenses','-R8,500','#dc2626','#fef2f2'],['Freelance Work','Income','+R3,200','#059669','#f0fdf4']] as $tx)
                            <div style="display:flex;align-items:center;gap:8px;padding:6px 0;border-bottom:1px solid #f8fafc;">
                                <div style="width:26px;height:26px;border-radius:6px;background:{{ $tx[4] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <span style="font-size:.6rem;font-weight:700;color:{{ $tx[3] }};">{{ str_contains($tx[2],'+') ? '↓' : '↑' }}</span>
                                </div>
                                <div style="flex:1;"><div style="font-size:.72rem;font-weight:600;color:#334155;">{{ $tx[0] }}</div><div style="font-size:.62rem;color:#94a3b8;">{{ $tx[1] }}</div></div>
                                <div style="font-size:.75rem;font-weight:700;color:{{ $tx[3] }};">{{ $tx[2] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Budgets --}}
            <div class="tour-panel-content" id="tp-budgets">
                <div class="tour-text">
                    <h3>Plan your month before it starts</h3>
                    <p>Create a budget at the beginning of the month and see in real time how your actual spending compares. No more overspending by accident — Bright Finance makes it visible.</p>
                    <ul class="check-list">
                        <li>Set limits per expense category</li>
                        <li>Visual progress bars show overspend instantly</li>
                        <li>Recurring budgets auto-populate each month</li>
                        <li>Planning → Finalized workflow</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-primary px-4" style="border-radius:10px;font-weight:700;font-size:.88rem;">Get started →</a>
                </div>
                <div class="tour-visual">
                    <div class="mock-mini">
                        <div class="mock-mini-bar">
                            <div class="mmbar-dot" style="background:#ef4444;"></div>
                            <div class="mmbar-dot" style="background:#f59e0b;"></div>
                            <div class="mmbar-dot" style="background:#22c55e;"></div>
                            <span style="font-size:.65rem;color:#94a3b8;margin-left:6px;">May Budget</span>
                        </div>
                        <div class="mock-mini-body">
                            @foreach([['Rent','100%','#22c55e','R8,500 / R8,500'],['Groceries','72%','#f59e0b','R2,160 / R3,000'],['Transport','45%','#22c55e','R900 / R2,000'],['Entertainment','112%','#ef4444','R1,680 / R1,500'],['Savings','60%','#1d4ed8','R600 / R1,000']] as $b)
                            <div style="margin-bottom:10px;">
                                <div style="display:flex;justify-content:space-between;margin-bottom:3px;"><span style="font-size:.72rem;font-weight:600;color:#334155;">{{ $b[0] }}</span><span style="font-size:.65rem;color:#94a3b8;">{{ $b[3] }}</span></div>
                                <div style="height:8px;background:#e2e8f0;border-radius:4px;overflow:hidden;"><div style="height:100%;width:{{ min(100,intval($b[1])) }}%;background:{{ $b[2] }};border-radius:4px;"></div></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Goals --}}
            <div class="tour-panel-content" id="tp-goals">
                <div class="tour-text">
                    <h3>Make savings goals real</h3>
                    <p>Turn vague financial dreams into trackable plans. Set a target, break it into milestones, and get dashboard reminders as deadlines approach. Watch your progress grow.</p>
                    <ul class="check-list">
                        <li>Create goals with amounts and target dates</li>
                        <li>Milestone-based tracking keeps you motivated</li>
                        <li>Dashboard shows progress at a glance</li>
                        <li>Mark goals complete when you get there</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-primary px-4" style="border-radius:10px;font-weight:700;font-size:.88rem;">Get started →</a>
                </div>
                <div class="tour-visual">
                    <div class="mock-mini">
                        <div class="mock-mini-bar">
                            <div class="mmbar-dot" style="background:#ef4444;"></div>
                            <div class="mmbar-dot" style="background:#f59e0b;"></div>
                            <div class="mmbar-dot" style="background:#22c55e;"></div>
                            <span style="font-size:.65rem;color:#94a3b8;margin-left:6px;">Goals</span>
                        </div>
                        <div class="mock-mini-body">
                            @foreach([['🏥','Emergency Fund','R32,500','R50,000','65','#7c3aed','Dec 2026'],['✈️','Holiday Savings','R12,750','R15,000','85','#059669','Aug 2026'],['🚗','New Car Deposit','R24,000','R80,000','30','#f59e0b','Mar 2027']] as $g)
                            <div style="background:#fff;border:1px solid #f1f5f9;border-radius:10px;padding:10px;margin-bottom:8px;">
                                <div style="display:flex;justify-content:space-between;margin-bottom:5px;align-items:center;">
                                    <span style="font-size:.78rem;font-weight:700;color:#0f172a;">{{ $g[0] }} {{ $g[1] }}</span>
                                    <span style="font-size:.72rem;font-weight:700;color:{{ $g[5] }};">{{ $g[4] }}%</span>
                                </div>
                                <div style="height:8px;background:#e2e8f0;border-radius:4px;overflow:hidden;margin-bottom:4px;"><div style="height:100%;width:{{ $g[4] }}%;background:{{ $g[5] }};border-radius:4px;"></div></div>
                                <div style="display:flex;justify-content:space-between;"><span style="font-size:.62rem;color:#94a3b8;">{{ $g[2] }} saved</span><span style="font-size:.62rem;color:#94a3b8;">Target: {{ $g[3] }}</span></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Reports --}}
            <div class="tour-panel-content" id="tp-reports">
                <div class="tour-text">
                    <h3>Understand your financial patterns</h3>
                    <p>Bright Finance includes a full suite of reports — not just totals, but trends, forecasts, and accounting-grade views. Know where you've been and where you're headed.</p>
                    <ul class="check-list">
                        <li>12-month income vs expense trend</li>
                        <li>Cash budget forecast for next month</li>
                        <li>Full balance sheet from your journal entries</li>
                        <li>Category spending breakdown</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-primary px-4" style="border-radius:10px;font-weight:700;font-size:.88rem;">Get started →</a>
                </div>
                <div class="tour-visual">
                    <div class="mock-mini">
                        <div class="mock-mini-bar">
                            <div class="mmbar-dot" style="background:#ef4444;"></div>
                            <div class="mmbar-dot" style="background:#f59e0b;"></div>
                            <div class="mmbar-dot" style="background:#22c55e;"></div>
                            <span style="font-size:.65rem;color:#94a3b8;margin-left:6px;">Monthly Trends</span>
                        </div>
                        <div class="mock-mini-body">
                            <div style="font-size:.65rem;font-weight:700;color:#64748b;text-transform:uppercase;margin-bottom:8px;">Last 6 months</div>
                            @php $months=[['Feb','R14k','R11k'],['Mar','R16k','R12k'],['Apr','R15k','R10k'],['May','R18k','R9k'],['Jun','R17k','R13k'],['Jul','R19k','R11k']]; $maxH=90; @endphp
                            <div style="display:flex;align-items:flex-end;gap:5px;height:80px;margin-bottom:6px;">
                                @foreach($months as $i=>$m)
                                @php $inc=intval(str_replace('k','',str_replace('R','',$m[1]))); $exp=intval(str_replace('k','',str_replace('R','',$m[2]))); $maxVal=20; @endphp
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:2px;height:100%;justify-content:flex-end;">
                                    <div style="width:100%;background:#22c55e;border-radius:3px 3px 0 0;height:{{ round(($inc/$maxVal)*100) }}%;min-height:4px;opacity:.8;"></div>
                                </div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:2px;height:100%;justify-content:flex-end;">
                                    <div style="width:100%;background:#ef4444;border-radius:3px 3px 0 0;height:{{ round(($exp/$maxVal)*100) }}%;min-height:4px;opacity:.8;"></div>
                                </div>
                                @endforeach
                            </div>
                            <div style="display:flex;gap:5px;">
                                @foreach($months as $m)<div style="flex:2;text-align:center;font-size:.58rem;color:#94a3b8;">{{ $m[0] }}</div>@endforeach
                            </div>
                            <div style="display:flex;gap:12px;margin-top:8px;justify-content:center;">
                                <div style="display:flex;align-items:center;gap:4px;"><div style="width:8px;height:8px;border-radius:2px;background:#22c55e;"></div><span style="font-size:.65rem;color:#64748b;">Income</span></div>
                                <div style="display:flex;align-items:center;gap:4px;"><div style="width:8px;height:8px;border-radius:2px;background:#ef4444;"></div><span style="font-size:.65rem;color:#64748b;">Expenses</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ════ HOW IT WORKS — 3 STEPS ════ --}}
<section class="sec" style="background:#f8fafc;">
    <div class="container">
        <div class="text-center">
            <div class="sec-label">Get started</div>
            <h2 class="sec-title">Up and running in 3 minutes</h2>
            <p class="sec-sub">No accountant needed. No complex setup. Just sign up and start making sense of your money today.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-7">
                @php $steps = [
                    ['1','Create your free account','Sign up with your name, email, and mobile. No credit card required. Your 34 default categories are pre-loaded.'],
                    ['2','Record your first transaction','Log what came in or went out this month. Even adding one salary entry immediately shows you a starting point.'],
                    ['3','Create a budget and set a goal','Give your money a job to do. Assign amounts to your categories and set at least one savings target to work toward.'],
                ]; @endphp
                @foreach($steps as $s)
                <div class="d-flex gap-4 mb-5 step-line">
                    <div class="step-num">{{ $s[0] }}</div>
                    <div class="step-body pt-2">
                        <h5>{{ $s[1] }}</h5>
                        <p>{{ $s[2] }}</p>
                    </div>
                </div>
                @endforeach
                <div class="text-center mt-2">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5" style="border-radius:10px;font-weight:700;">Create My Free Account</a>
                    <div class="mt-2" style="font-size:.8rem;color:#94a3b8;">Already have an account? <a href="{{ route('login') }}" style="color:#1d4ed8;font-weight:600;">Log in →</a></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════ SOCIAL PROOF ════ --}}
<section class="sec sec-alt">
    <div class="container">
        <div class="text-center mb-5">
            <div class="sec-label">Why people use it</div>
            <h2 class="sec-title">What users say</h2>
        </div>
        <div class="row g-4 justify-content-center">
            @php $quotes = [
                ['"I used to dread checking my bank account. Now I check Bright Finance every day because it actually shows me progress, not just a number."', 'K. Dlamini', 'Teacher, Durban', 'K'],
                ['"I finally understand why I was always broke despite earning a good salary. The spending report was eye-opening."', 'T. Nkosi', 'Software developer, JHB', 'T'],
                ['"Setting up my emergency fund goal and watching it hit 65% in three months kept me more motivated than any spreadsheet ever did."', 'M. van der Berg', 'Freelancer, Cape Town', 'M'],
            ]; @endphp
            @foreach($quotes as $q)
            <div class="col-12 col-md-4">
                <div class="quote-card">
                    <div class="stars">★★★★★</div>
                    <div class="quote-text">{{ $q[0] }}</div>
                    <div class="d-flex align-items-center gap-10" style="gap:10px;">
                        <div class="quote-avatar">{{ $q[3] }}</div>
                        <div><div class="quote-name">{{ $q[1] }}</div><div class="quote-title">{{ $q[2] }}</div></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════ FINAL CTA ════ --}}
<div class="container">
    <div class="final-cta">
        <div style="font-size:3rem;margin-bottom:14px;">💡</div>
        <h2>You already earn enough.<br>Now let's make it work harder.</h2>
        <p>Bright Finance is completely free to start. No credit card. No complicated setup.<br>Just clarity about your money — starting today.</p>
        <div class="d-flex justify-content-center flex-wrap gap-3">
            <a href="{{ route('register') }}" class="btn-hero-primary">Create My Free Account</a>
            <a href="{{ route('features') }}" class="btn-hero-ghost">See all features →</a>
        </div>
        <div class="mt-3" style="font-size:.8rem;color:rgba(255,255,255,.5);">
            Already have an account? <a href="{{ route('login') }}" style="color:#93c5fd;font-weight:600;">Sign in →</a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function switchTour(panelId, tabEl) {
    document.querySelectorAll('.tour-panel-content').forEach(function(p) { p.classList.remove('active'); });
    document.querySelectorAll('.t-tab').forEach(function(t) { t.classList.remove('active'); });
    document.getElementById('tp-' + panelId).classList.add('active');
    tabEl.classList.add('active');
}
</script>
@endsection
