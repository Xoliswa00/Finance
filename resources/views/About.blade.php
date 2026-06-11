@extends('layouts.app')

@section('title', 'About Bright Finance')
@section('meta-description', 'Bright Finance is your personal financial home base — built for South Africans who want to know exactly where their money goes, plan ahead with budgets, and reach their financial goals.')

@section('head')
<style>
    /* Hero */
    .ab-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #1d4ed8 100%);
        padding: 80px 0 72px;
        text-align: center;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .ab-hero::before {
        content: '';
        position: absolute;
        top: -120px; right: -120px;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: rgba(255,255,255,.04);
    }
    .ab-hero::after {
        content: '';
        position: absolute;
        bottom: -100px; left: -80px;
        width: 400px; height: 400px;
        border-radius: 50%;
        background: rgba(255,255,255,.03);
    }
    .ab-hero .ab-badge {
        display: inline-block;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 50px;
        padding: 5px 16px;
        font-size: .78rem;
        font-weight: 700;
        color: #bfdbfe;
        letter-spacing: .06em;
        text-transform: uppercase;
        margin-bottom: 20px;
    }
    .ab-hero h1 {
        font-size: clamp(2rem, 5vw, 3.2rem);
        font-weight: 800;
        color: #fff;
        line-height: 1.15;
        margin-bottom: 18px;
    }
    .ab-hero .lead {
        font-size: clamp(.95rem, 2vw, 1.1rem);
        color: rgba(255,255,255,.78);
        max-width: 640px;
        margin: 0 auto 32px;
        line-height: 1.75;
    }
    .ab-hero-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
    .ab-btn-primary {
        background: #fff;
        color: #1d4ed8;
        border: none;
        border-radius: 10px;
        padding: 12px 28px;
        font-size: .9rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform .15s, box-shadow .15s;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .ab-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,.2); color: #1d4ed8; }
    .ab-btn-outline {
        background: transparent;
        color: #fff;
        border: 1.5px solid rgba(255,255,255,.4);
        border-radius: 10px;
        padding: 12px 28px;
        font-size: .9rem;
        font-weight: 600;
        text-decoration: none;
        transition: background .15s, border-color .15s;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .ab-btn-outline:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.7); color: #fff; }

    /* Sections */
    .ab-section { padding: 80px 0; }
    .ab-section-alt { background: #f8fafc; }
    .ab-section-dark { background: #0f172a; color: #fff; }
    .ab-label {
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: #1d4ed8;
        margin-bottom: 10px;
    }
    .ab-label-light { color: #7dd3fc; }
    .ab-h2 { font-size: clamp(1.6rem, 3vw, 2.1rem); font-weight: 800; color: #0f172a; line-height: 1.25; }
    .ab-h2-light { color: #fff; }
    .ab-subtext { font-size: 1rem; color: #64748b; line-height: 1.8; }
    .ab-subtext-light { color: rgba(255,255,255,.72); }

    /* What Is It */
    .what-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 32px;
        height: 100%;
    }
    .what-highlight {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border-left: 4px solid #1d4ed8;
        border-radius: 0 12px 12px 0;
        padding: 18px 22px;
        margin: 24px 0;
    }
    .what-highlight p { font-size: 1rem; font-style: italic; color: #1e40af; margin: 0; font-weight: 500; line-height: 1.65; }
    .what-pill {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        border-radius: 50px;
        padding: 5px 12px;
        font-size: .78rem;
        font-weight: 600;
        margin: 4px;
    }
    .what-pill i { font-size: .7rem; }

    /* ── How It Works ── */
    .how-step {
        display: flex;
        gap: 20px;
        margin-bottom: 32px;
        align-items: flex-start;
    }
    .how-num {
        width: 48px; height: 48px; flex-shrink: 0;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
        font-weight: 800;
        color: #fff;
    }
    .how-body h4 { font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
    .how-body p  { font-size: .9rem; color: #64748b; line-height: 1.7; margin: 0; }

    .how-connector {
        width: 2px;
        height: 28px;
        background: linear-gradient(#dbeafe, #e2e8f0);
        margin: 0 0 0 23px;
    }

    /* ── Features ── */
    .feat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px 20px;
        height: 100%;
        transition: border-color .2s, box-shadow .2s, transform .2s;
    }
    .feat-card:hover {
        border-color: #bfdbfe;
        box-shadow: 0 8px 24px rgba(29,78,216,.09);
        transform: translateY(-2px);
    }
    .feat-icon {
        width: 48px; height: 48px;
        border-radius: 13px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 14px;
    }
    .feat-card h5 { font-size: .95rem; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
    .feat-card p  { font-size: .82rem; color: #64748b; line-height: 1.65; margin: 0; }

    /* ── Who It's For ── */
    .persona-card {
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 28px 22px;
        height: 100%;
        transition: border-color .2s;
    }
    .persona-card:hover { border-color: #a5b4fc; }
    .persona-icon { font-size: 2.2rem; margin-bottom: 14px; display: block; }
    .persona-card h5 { font-size: 1rem; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
    .persona-card p  { font-size: .84rem; color: #64748b; line-height: 1.7; margin: 0; }

    /* ── Getting Started ── */
    .start-step {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 20px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        margin-bottom: 12px;
        transition: border-color .2s;
    }
    .start-step:hover { border-color: #bfdbfe; }
    .start-num {
        width: 36px; height: 36px; flex-shrink: 0;
        background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
        color: #fff;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: .9rem;
        font-weight: 800;
    }
    .start-step h6 { font-size: .95rem; font-weight: 700; color: #0f172a; margin-bottom: 3px; }
    .start-step p  { font-size: .82rem; color: #64748b; margin: 0; line-height: 1.6; }

    /* ── Story / Timeline ── */
    .timeline { position: relative; padding-left: 32px; }
    .timeline::before { content: ''; position: absolute; left: 11px; top: 0; bottom: 0; width: 2px; background: #e2e8f0; }
    .timeline-item { position: relative; margin-bottom: 28px; }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -25px; top: 4px;
        width: 12px; height: 12px;
        border-radius: 50%;
        background: #1d4ed8;
        border: 2px solid #fff;
        box-shadow: 0 0 0 3px #bfdbfe;
    }
    .timeline-year { font-size: .75rem; font-weight: 700; color: #1d4ed8; text-transform: uppercase; letter-spacing: .05em; }
    .timeline-desc { font-size: .9rem; color: #334155; margin-top: 2px; line-height: 1.6; }

    /* ── Values ── */
    .value-card {
        background: rgba(255,255,255,.07);
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 16px;
        padding: 28px 22px;
        text-align: center;
        height: 100%;
        transition: background .2s;
    }
    .value-card:hover { background: rgba(255,255,255,.11); }
    .value-icon {
        width: 52px; height: 52px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
        margin: 0 auto 14px;
    }
    .value-card h5 { font-size: .95rem; font-weight: 700; color: #fff; margin-bottom: 8px; }
    .value-card p  { font-size: .82rem; color: rgba(255,255,255,.65); line-height: 1.65; margin: 0; }
</style>
@endsection

@section('content')

{{-- ═══ HERO ═══ --}}
<section class="ab-hero">
    <div class="container position-relative" style="z-index:1;">
        <div class="ab-badge">Personal Finance Platform</div>
        <h1>Know Where Your Money Goes.</h1>
        <p class="lead">Bright Finance is your complete financial home base — built for South Africans who want clarity, control, and confidence over their money, every single month.</p>
        <div class="ab-hero-btns">
            <a href="{{ route('home') }}" class="ab-btn-primary">
                <i class="fas fa-tachometer-alt"></i> Go to Dashboard
            </a>
            <a href="#how-it-works" class="ab-btn-outline">
                <i class="fas fa-play-circle"></i> See How It Works
            </a>
        </div>
    </div>
</section>

{{-- ═══ WHAT IS BRIGHT FINANCE ═══ --}}
<section class="ab-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="ab-label">What Is It</div>
                <h2 class="ab-h2 mb-4">Your financial picture, finally in one place</h2>
                <div class="ab-subtext">
                    <p>Most people have a rough sense of what they earn — but a much blurrier picture of where it actually ends up. Bright Finance fixes that.</p>
                    <div class="what-highlight">
                        <p>"It's not a bank. It's not a spreadsheet. It's the layer between the two — a financial home base that connects your daily transactions to your bigger financial picture."</p>
                    </div>
                    <p>Whether you're tracking everyday spending, planning next month's budget, saving for a goal, or trying to understand your financial patterns — Bright Finance gives you the tools to do it all from one place.</p>
                    <p style="margin-top:16px;">Behind the scenes, every transaction follows proper double-entry accounting principles. Your reports — balance sheet, trial balance, cash forecast — are always accurate and always current. <strong style="color:#0f172a;">You never need to think about that part.</strong> It just works.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="what-card">
                    <div style="font-size:.82rem;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.06em;margin-bottom:20px;">What Makes It Different</div>
                    <div style="display:flex;flex-direction:column;gap:16px;">
                        @php
                        $diffs = [
                            ['fa-layer-group','#eff6ff','#1d4ed8','Everything in one place','Transactions, budgets, goals, reports, and transfers — no more jumping between apps.'],
                            ['fa-book-open','#f0fdf4','#059669','Real accounting under the hood','Double-entry bookkeeping means your numbers are always accurate. Your balance sheet balances.'],
                            ['fa-user-friends','#fdf4ff','#7c3aed','Built for real life','Not built for accountants or CFOs. Built for people who want to manage their money without a finance degree.'],
                            ['fa-seedling','#fff7ed','#d97706','Grows with you','Start with one transaction. Add a budget next week. Set a goal next month. Use as much or as little as you need.'],
                        ];
                        @endphp
                        @foreach($diffs as $d)
                        <div style="display:flex;gap:14px;align-items:flex-start;">
                            <div style="width:40px;height:40px;flex-shrink:0;border-radius:10px;background:{{ $d[1] }};display:flex;align-items:center;justify-content:center;">
                                <i class="fas {{ $d[0] }}" style="color:{{ $d[2] }};font-size:.95rem;"></i>
                            </div>
                            <div>
                                <div style="font-size:.9rem;font-weight:700;color:#0f172a;margin-bottom:2px;">{{ $d[3] }}</div>
                                <div style="font-size:.82rem;color:#64748b;line-height:1.6;">{{ $d[4] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ HOW IT WORKS ═══ --}}
<section class="ab-section ab-section-alt" id="how-it-works">
    <div class="container">
        <div class="text-center mb-5">
            <div class="ab-label">How It Works</div>
            <h2 class="ab-h2">Four steps to financial clarity</h2>
            <p class="ab-subtext mt-3" style="max-width:560px;margin:12px auto 0;">You don't need to set everything up on day one. Bright Finance is built to start simple and grow with you.</p>
        </div>
        <div class="row g-4 align-items-stretch">
            @php
            $steps = [
                ['1','linear-gradient(135deg,#1d4ed8,#3b82f6)','fa-arrow-right-arrow-left','Record What Happens','Log every rand that comes in or goes out. Attach it to a category — Groceries, Salary, Fuel, Rent — so every entry means something. This is your financial truth in real time.','Start with even one transaction. Once you see your data building up, it becomes habit.'],
                ['2','linear-gradient(135deg,#059669,#34d399)','fa-wallet','Plan Before You Spend','At the start of the month, create a budget: how much you expect to earn, and how much you plan to spend per category. Bright Finance then tracks actual vs. planned as you go.','No more end-of-month surprises. You\'ll see overspending before it becomes a problem.'],
                ['3','linear-gradient(135deg,#7c3aed,#a78bfa)','fa-bullseye','Track Your Goals','Set savings or investment goals with a target amount and end date. Bright Finance shows your progress visually and sends reminders when milestones are due.','Goals keep you honest. Seeing 68% to your emergency fund is more motivating than a number in a spreadsheet.'],
                ['4','linear-gradient(135deg,#d97706,#fbbf24)','fa-chart-line','Understand Your Patterns','The reports section pulls everything together — spending trends, monthly cash flow, balance sheet, and forecasts. You can see what changed, what stayed the same, and what to do next.','This is where one month of tracking becomes a year of financial intelligence.'],
            ];
            @endphp
            @foreach($steps as $i => $s)
            <div class="col-12 col-md-6 col-lg-3">
                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:18px;padding:28px 22px;height:100%;position:relative;overflow:hidden;">
                    <div style="position:absolute;top:-20px;right:-16px;font-size:5rem;font-weight:900;color:#f1f5f9;line-height:1;user-select:none;">{{ $s[0] }}</div>
                    <div style="width:50px;height:50px;border-radius:14px;background:{{ $s[1] }};display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                        <i class="fas {{ $s[2] }}" style="color:#fff;font-size:1.1rem;"></i>
                    </div>
                    <h5 style="font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:8px;">{{ $s[3] }}</h5>
                    <p style="font-size:.84rem;color:#475569;line-height:1.7;margin-bottom:14px;">{{ $s[4] }}</p>
                    <div style="background:#f8fafc;border-radius:8px;padding:10px 12px;">
                        <p style="font-size:.77rem;color:#64748b;line-height:1.6;margin:0;font-style:italic;">
                            <i class="fas fa-lightbulb" style="color:#d97706;margin-right:4px;font-size:.7rem;"></i>{{ $s[5] }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ FEATURES ═══ --}}
<section class="ab-section" id="features">
    <div class="container">
        <div class="text-center mb-5">
            <div class="ab-label">Features</div>
            <h2 class="ab-h2">Everything you need, nothing you don't</h2>
        </div>
        <div class="row g-3">
            @php
            $features = [
                ['fa-exchange-alt','#eff6ff','#1d4ed8','Transactions','Record income and expenses as they happen. Full edit history, category tagging, and monthly filters.'],
                ['fa-wallet','#f0fdf4','#059669','Budgets','Plan your month before it starts. Track budget vs. actual per category. Set recurring items so nothing slips through.'],
                ['fa-flag','#fdf4ff','#7c3aed','Goals & Milestones','Set savings and investment targets. Break them into milestones. Get reminded when due dates are approaching.'],
                ['fa-chart-bar','#fff7ed','#d97706','Reports','Monthly trends, spending breakdowns, cash budget forecasts, balance sheet, and trial balance — all live.'],
                ['fa-compare-arrows','#ecfdf5','#059669','Transfers','Move money between your own accounts and track the movement. Balances update automatically.'],
                ['fa-upload','#eff6ff','#1d4ed8','Bank Import','Upload your bank statement CSV. Preview and categorise rows. Bulk-create transactions in seconds.'],
                ['fa-tags','#fdf4ff','#7c3aed','Categories','Build your own chart of accounts — from basic income/expense to a full accounting structure if you want it.'],
                ['fa-project-diagram','#fff7ed','#d97706','Master Projects','Group large financial projects — renovations, business initiatives — with their own budgets, sections, and actuals.'],
            ];
            @endphp
            @foreach($features as $f)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="feat-card">
                    <div class="feat-icon" style="background:{{ $f[1] }};">
                        <i class="fas {{ $f[0] }}" style="color:{{ $f[2] }};"></i>
                    </div>
                    <h5>{{ $f[3] }}</h5>
                    <p>{{ $f[4] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ WHO IT'S FOR ═══ --}}
<section class="ab-section ab-section-alt" id="who">
    <div class="container">
        <div class="text-center mb-5">
            <div class="ab-label">Who It's For</div>
            <h2 class="ab-h2">You don't need a finance degree</h2>
            <p class="ab-subtext mt-3" style="max-width:520px;margin:12px auto 0;">Bright Finance is for anyone who wants to take their money seriously — students, professionals, entrepreneurs, families.</p>
        </div>
        <div class="row g-4">
            @php
            $personas = [
                ['💸','Managing day-to-day spending','You earn, you spend, and by the 20th you\'re not sure where it went. Bright Finance gives you a live picture so you always know your position — before the money runs out.'],
                ['🎯','Saving for something big','Emergency fund, holiday, deposit on a car, or paying off a loan. Goals keep the target in sight. Milestones keep you accountable. The dashboard keeps it visible every day.'],
                ['📊','Understanding your patterns','You\'ve always suspected you spend too much on takeaways or subscriptions, but you\'ve never had the data to confirm it. The reports section will show you exactly.'],
                ['🏢','Running a side income','Freelance work, rental income, a small side business. Bright Finance tracks multiple income sources, handles project budgets, and keeps your books in order without an accountant.'],
            ];
            @endphp
            @foreach($personas as $p)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="persona-card">
                    <span class="persona-icon">{{ $p[0] }}</span>
                    <h5>{{ $p[1] }}</h5>
                    <p>{{ $p[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ GETTING STARTED ═══ --}}
<section class="ab-section" id="getting-started">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <div class="ab-label">Getting Started</div>
                <h2 class="ab-h2 mb-4">Four steps and you're tracking</h2>
                <p class="ab-subtext">You don't need to set everything up perfectly on day one. Bright Finance grows with you — the more you use it, the more useful it becomes.</p>
                <div style="margin-top:28px;">
                    <div style="display:flex;align-items:center;gap:10px;font-size:.85rem;color:#64748b;">
                        <i class="fas fa-clock" style="color:#1d4ed8;"></i>
                        Takes about 5 minutes to get your first transaction in.
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;font-size:.85rem;color:#64748b;margin-top:8px;">
                        <i class="fas fa-layer-group" style="color:#059669;"></i>
                        34 standard categories are created automatically when you sign up.
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;font-size:.85rem;color:#64748b;margin-top:8px;">
                        <i class="fas fa-mobile-alt" style="color:#7c3aed;"></i>
                        Works on any device — desktop, tablet, or phone.
                    </div>
                </div>
                <div style="margin-top:28px;">
                    <a href="{{ route('home') }}"
                       style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#1d4ed8,#0ea5e9);color:#fff;border-radius:10px;padding:12px 24px;font-size:.9rem;font-weight:700;text-decoration:none;transition:opacity .15s;">
                        <i class="fas fa-rocket"></i> Open My Dashboard
                    </a>
                </div>
            </div>
            <div class="col-lg-7">
                @php
                $gsteps = [
                    ['Your account is created','You\'re already here. A default card and 34 categories have been set up for you — nothing to configure before you start.'],
                    ['Log your first transaction','It can be anything — a grocery run, your salary, a subscription charge. The point is to start the habit. Even one entry is better than none.'],
                    ['Create a budget','Before next month starts, set a simple budget. How much do you expect to earn? How much do you plan to spend on the big categories? That\'s it.'],
                    ['Set one goal','Pick one thing you\'re working toward — an emergency fund, a savings target, paying off a debt. Give it a number and a date. The dashboard keeps it in view.'],
                ];
                @endphp
                @foreach($gsteps as $i => $s)
                <div class="start-step">
                    <div class="start-num">{{ $i + 1 }}</div>
                    <div>
                        <h6>{{ $s[0] }}</h6>
                        <p>{{ $s[1] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ═══ OUR STORY ═══ --}}
<section class="ab-section ab-section-alt" id="story">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="ab-label">Our Story</div>
                <h2 class="ab-h2 mb-4">Born from a real financial challenge</h2>
                <div class="ab-subtext">
                    <p>Managing personal finances in South Africa can be complex. Juggling income, expenses, loan repayments, and savings goals across scattered spreadsheets and apps leads to confusion, overspending, and missed opportunities to grow wealth.</p>
                    <div class="what-highlight" style="margin:20px 0;">
                        <p>"I wanted a tool that thought the way I did about money — one that used real accounting principles but was simple enough for anyone to use."</p>
                    </div>
                    <p>Bright Finance was built to solve exactly that problem. Drawing on double-entry bookkeeping principles and a deep understanding of how South Africans manage day-to-day finances, it combines the rigour of accounting with the simplicity of a modern app.</p>
                    <p style="margin-top:14px;">From tracking grocery spend to forecasting next month's cash position, Bright Finance gives you the tools to make <strong style="color:#0f172a;">confident, informed financial decisions.</strong></p>
                </div>
            </div>
            <div class="col-lg-5">
                <div style="background:#fff;border-radius:20px;border:1px solid #e2e8f0;padding:28px 28px 20px;">
                    <div style="font-size:.78rem;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.06em;margin-bottom:20px;">Our Journey</div>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-year">2021</div>
                            <div class="timeline-desc">First version launched — basic income, expense, and budget tracking for everyday users.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2022</div>
                            <div class="timeline-desc">Added goal setting, milestones, and the balance sheet report.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2023</div>
                            <div class="timeline-desc">Journal entry system and cash budget forecasting introduced.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2024</div>
                            <div class="timeline-desc">Admin dashboard, activity logging, and error tracking added.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2025 — Now</div>
                            <div class="timeline-desc">Major revamp — improved UX, new reports, monthly trend analysis, transfers, bank imports, and more.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ VALUES ═══ --}}
<section class="ab-section ab-section-dark" id="values">
    <div class="container">
        <div class="text-center mb-5">
            <div class="ab-label ab-label-light">Our Values</div>
            <h2 class="ab-h2 ab-h2-light">What drives everything we build</h2>
        </div>
        <div class="row g-4">
            @php
            $values = [
                ['fa-eye','rgba(29,78,216,.25)','#7dd3fc','Transparency','Your data is yours. We show you exactly what\'s happening with your money — no smoke, no mirrors.'],
                ['fa-bolt','rgba(217,119,6,.25)','#fcd34d','Simplicity','Financial tools don\'t have to be complicated. We strip away the noise so you can focus on what matters.'],
                ['fa-lock','rgba(5,150,105,.25)','#6ee7b7','Security','Your financial information is sensitive. We treat it with the same care you would.'],
                ['fa-seedling','rgba(124,58,237,.25)','#c4b5fd','Growth','Every feature is built to help you move forward — toward savings goals, financial stability, and peace of mind.'],
            ];
            @endphp
            @foreach($values as $v)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="value-card">
                    <div class="value-icon" style="background:{{ $v[1] }};">
                        <i class="fas {{ $v[0] }}" style="color:{{ $v[2] }};"></i>
                    </div>
                    <h5>{{ $v[3] }}</h5>
                    <p>{{ $v[4] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ MISSION CTA ═══ --}}
<section class="ab-section text-center" style="background:linear-gradient(135deg,#1e3a8a,#1d4ed8);">
    <div class="container">
        <div class="ab-label" style="color:#7dd3fc;">Our Mission</div>
        <h2 class="ab-h2-light mt-2" style="font-size:clamp(1.6rem,3vw,2.2rem);color:#fff;font-weight:800;">
            To give every South African<br>financial clarity and confidence.
        </h2>
        <p style="color:rgba(255,255,255,.75);font-size:1rem;line-height:1.8;max-width:640px;margin:20px auto 0;">
            Financial management shouldn't be reserved for accountants and the wealthy. Bright Finance puts powerful tools in the hands of everyone — students, entrepreneurs, families, and professionals — because everyone deserves to know where their money goes.
        </p>
        <div class="ab-hero-btns mt-5">
            <a href="{{ route('home') }}" class="ab-btn-primary">
                <i class="fas fa-tachometer-alt"></i> Open Dashboard
            </a>
        </div>
    </div>
</section>

@endsection
