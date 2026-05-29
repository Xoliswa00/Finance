@extends('layouts.app')

@section('title', 'Features — Bright Finance')
@section('meta-description', 'Discover all the tools Bright Finance gives you: budgeting, transaction tracking, goal setting, reports, and more.')

@section('head')
<style>
    .features-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        padding: 80px 0 60px;
        text-align: center;
        color: #fff;
    }
    .features-hero h1 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; }
    .features-hero p { color: rgba(255,255,255,.75); font-size: 1.05rem; max-width: 580px; margin: 12px auto 0; }

    .feature-section { padding: 70px 0; }
    .feature-section:nth-child(even) { background: #f8fafc; }

    .feature-big-icon {
        width: 64px; height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem; color: #fff; margin-bottom: 20px;
    }
    .feature-tag {
        display: inline-block;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        border-radius: 20px;
        padding: 4px 12px;
        margin-bottom: 12px;
    }
    .feature-big-title { font-size: 1.7rem; font-weight: 800; color: #0f172a; margin-bottom: 12px; }
    .feature-big-desc { font-size: 0.95rem; color: #475569; line-height: 1.8; }

    .bullet-item {
        display: flex; align-items: flex-start; gap: 10px;
        margin-bottom: 12px;
    }
    .bullet-item i { color: #22c55e; font-size: 1rem; margin-top: 2px; flex-shrink: 0; }
    .bullet-item span { font-size: 0.9rem; color: #334155; }

    .feature-visual {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,.06);
    }
    .mini-card {
        background: #f8fafc;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .mini-card-icon {
        width: 36px; height: 36px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem; flex-shrink: 0;
    }
    .mini-card-label { font-size: 0.8rem; color: #64748b; }
    .mini-card-value { font-size: 1rem; font-weight: 700; color: #0f172a; }

    .feature-grid-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 24px 20px;
        transition: box-shadow .2s, border-color .2s;
        height: 100%;
    }
    .feature-grid-card:hover { box-shadow: 0 8px 24px rgba(29,78,216,.08); border-color: #bfdbfe; }
    .feature-grid-card i { font-size: 1.4rem; color: #1d4ed8; margin-bottom: 12px; display: block; }
    .feature-grid-card h5 { font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-bottom: 6px; }
    .feature-grid-card p { font-size: 0.82rem; color: #64748b; line-height: 1.6; margin: 0; }

    .compare-table th { background: #f8fafc; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing:.05em; color: #475569; border: none; }
    .compare-table td { font-size: 0.85rem; color: #334155; border-color: #f1f5f9; vertical-align: middle; }
    .compare-table .check { color: #22c55e; font-size: 1.1rem; }
    .compare-table .cross { color: #cbd5e1; font-size: 1.1rem; }
    .compare-table .highlight-col { background: #eff6ff; }
</style>
@endsection

@section('content')

{{-- Hero --}}
<div class="features-hero">
    <div class="container">
        <div style="display:inline-block;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:50px;padding:5px 14px;font-size:.78rem;font-weight:600;color:#bfdbfe;margin-bottom:14px;">
            All Features
        </div>
        <h1>Everything You Need to<br>Master Your Money</h1>
        <p>Bright Finance is packed with tools designed for everyday South Africans — from tracking daily expenses to planning long-term financial goals.</p>
        <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-light fw-bold px-5" style="border-radius:10px;">Get Started Free</a>
            <a href="{{ route('login') }}" class="btn btn-outline-light px-5" style="border-radius:10px;">Log In</a>
        </div>
    </div>
</div>

{{-- ── Feature 1: Transactions ── --}}
<section class="feature-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="feature-big-icon"><i class="fas fa-exchange-alt"></i></div>
                <div class="feature-tag">Core Feature</div>
                <h2 class="feature-big-title">Transaction Tracking</h2>
                <p class="feature-big-desc">Every rand you earn or spend, recorded and categorised instantly. Build a complete financial history you can export and analyse.</p>
                <div class="mt-4">
                    <div class="bullet-item"><i class="fas fa-check-circle"></i><span>Log income, expenses, purchases, and receipts</span></div>
                    <div class="bullet-item"><i class="fas fa-check-circle"></i><span>Attach categories, dates, and descriptions</span></div>
                    <div class="bullet-item"><i class="fas fa-check-circle"></i><span>Full edit and delete history</span></div>
                    <div class="bullet-item"><i class="fas fa-check-circle"></i><span>Export to CSV for your accountant</span></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-visual">
                    <div style="font-size:.78rem;font-weight:600;color:#475569;margin-bottom:14px;">Recent Transactions</div>
                    @foreach([['Groceries','Expenses','- ZAR 1,240','#ef4444'],['Salary Earned','Income','+ ZAR 18,500','#22c55e'],['Fuel','Expenses','- ZAR 640','#f59e0b'],['Rent Income','Income','+ ZAR 5,000','#22c55e'],['Entertainment','Expenses','- ZAR 380','#ef4444']] as $tx)
                    <div class="mini-card">
                        <div class="mini-card-icon" style="background:{{ $tx[3] }}20;">
                            <i class="fas fa-arrow-{{ str_contains($tx[2],'+') ? 'down' : 'up' }}" style="color:{{ $tx[3] }};"></i>
                        </div>
                        <div style="flex:1;">
                            <div class="mini-card-value">{{ $tx[0] }}</div>
                            <div class="mini-card-label">{{ $tx[1] }}</div>
                        </div>
                        <span style="font-weight:700;font-size:.9rem;color:{{ $tx[3] }};">{{ $tx[2] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Feature 2: Budgets ── --}}
<section class="feature-section">
    <div class="container">
        <div class="row align-items-center g-5 flex-row-reverse">
            <div class="col-lg-6">
                <div class="feature-big-icon" style="background:linear-gradient(135deg,#059669,#10b981);"><i class="fas fa-wallet"></i></div>
                <div class="feature-tag">Budgeting</div>
                <h2 class="feature-big-title">Smart Budget Management</h2>
                <p class="feature-big-desc">Plan your spending before the month starts. Create budgets per category, set limits, and track how much you've actually spent against your plan.</p>
                <div class="mt-4">
                    <div class="bullet-item"><i class="fas fa-check-circle"></i><span>Budget vs. actual comparison</span></div>
                    <div class="bullet-item"><i class="fas fa-check-circle"></i><span>Recurring budget items</span></div>
                    <div class="bullet-item"><i class="fas fa-check-circle"></i><span>Priority levels and due dates</span></div>
                    <div class="bullet-item"><i class="fas fa-check-circle"></i><span>Planning → Finalized workflow</span></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-visual">
                    <div style="font-size:.78rem;font-weight:600;color:#475569;margin-bottom:14px;">Budget Overview</div>
                    @foreach([['Rent','ZAR 8,500','ZAR 8,500','100%','#22c55e'],['Groceries','ZAR 3,000','ZAR 2,160','72%','#f59e0b'],['Transport','ZAR 2,000','ZAR 900','45%','#22c55e'],['Entertainment','ZAR 1,500','ZAR 420','28%','#22c55e']] as $b)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size:.82rem;font-weight:600;color:#334155;">{{ $b[0] }}</span>
                            <span style="font-size:.78rem;color:#64748b;">{{ $b[2] }} / {{ $b[1] }}</span>
                        </div>
                        <div style="height:8px;background:#e2e8f0;border-radius:4px;overflow:hidden;">
                            <div style="height:100%;width:{{ $b[3] }};background:{{ $b[4] }};border-radius:4px;"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Feature 3: Goals ── --}}
<section class="feature-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="feature-big-icon" style="background:linear-gradient(135deg,#7c3aed,#8b5cf6);"><i class="fas fa-bullseye"></i></div>
                <div class="feature-tag">Goals</div>
                <h2 class="feature-big-title">Financial Goal Tracking</h2>
                <p class="feature-big-desc">Whether it's a dream holiday, emergency fund, or home deposit — set a target, break it into milestones, and track your progress every step of the way.</p>
                <div class="mt-4">
                    <div class="bullet-item"><i class="fas fa-check-circle"></i><span>Create goals with target amounts and end dates</span></div>
                    <div class="bullet-item"><i class="fas fa-check-circle"></i><span>Milestone-based progress tracking</span></div>
                    <div class="bullet-item"><i class="fas fa-check-circle"></i><span>Visual progress bars and status updates</span></div>
                    <div class="bullet-item"><i class="fas fa-check-circle"></i><span>In-Progress, Completed, and Paused states</span></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-visual">
                    @foreach([['Emergency Fund','ZAR 50,000','ZAR 32,500','65%'],['New Car Deposit','ZAR 80,000','ZAR 24,000','30%'],['Holiday Savings','ZAR 15,000','ZAR 12,750','85%']] as $g)
                    <div class="mini-card d-block mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span style="font-weight:700;font-size:.9rem;color:#0f172a;">{{ $g[0] }}</span>
                            <span style="font-size:.8rem;color:#64748b;">{{ $g[1] }}</span>
                        </div>
                        <div style="height:10px;background:#e2e8f0;border-radius:5px;overflow:hidden;margin-bottom:4px;">
                            <div style="height:100%;width:{{ $g[3] }};background:linear-gradient(90deg,#7c3aed,#8b5cf6);border-radius:5px;"></div>
                        </div>
                        <div style="font-size:.75rem;color:#64748b;">{{ $g[2] }} saved · {{ $g[3] }} complete</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── All Other Features Grid ── --}}
<section class="feature-section" style="background:#f8fafc;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="font-size:1.8rem;font-weight:800;color:#0f172a;">And much more...</h2>
            <p style="color:#64748b;font-size:.95rem;">A full suite of financial management tools in one platform.</p>
        </div>
        <div class="row g-3">
            @php
                $more = [
                    ['fa-chart-bar','3-Month Spending Report','Compare income and expenses across the last three months, broken down by description.'],
                    ['fa-water','Cash Budget Forecast','Project your opening and closing cash position for the current month.'],
                    ['fa-balance-scale','Balance Sheet','Full asset, liability, and equity view built from your journal entries.'],
                    ['fa-book','Journal Entries','Double-entry bookkeeping for small business owners who need proper records.'],
                    ['fa-credit-card','Card Management','Track debit and credit card details and current balances in one place.'],
                    ['fa-tags','Custom Categories','Build your own category tree — income, expenses, assets, liabilities, and more.'],
                    ['fa-shield-alt','Secure & Private','Your financial data belongs to you. Role-based access and session security.'],
                    ['fa-file-csv','CSV Export','Export your transaction history for use in Excel, Sheets, or with your accountant.'],
                ];
            @endphp
            @foreach($more as $f)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="feature-grid-card">
                    <i class="fas {{ $f[0] }}"></i>
                    <h5>{{ $f[1] }}</h5>
                    <p>{{ $f[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CTA ── --}}
<section class="py-5 bg-white">
    <div class="container text-center py-3">
        <h2 style="font-size:1.8rem;font-weight:800;color:#0f172a;">Start managing your money smarter today</h2>
        <p style="color:#64748b;margin:12px auto 28px;max-width:500px;">Free to sign up. No hidden fees. Built for South Africans.</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 fw-bold" style="border-radius:10px;">
            Create Your Free Account
        </a>
    </div>
</section>

@endsection
