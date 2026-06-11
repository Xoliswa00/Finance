<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Welcome to Bright Finance</title>
    <link rel="icon" type="image/png" href="/assets/images/bright.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4ff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 24px 16px 40px;
        }

        /* Top bar */
        .top-bar {
            width: 100%;
            max-width: 820px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
        }
        .top-bar img { height: 2.4rem; }
        .skip-link {
            font-size: 0.82rem;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
        }
        .skip-link:hover { color: #1d4ed8; text-decoration: underline; }

        /* Progress dots */
        .progress-bar-wrap {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 32px;
        }
        .progress-step { display: flex; align-items: center; gap: 6px; }
        .dot {
            width: 30px; height: 30px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem; font-weight: 700;
            transition: all .3s; cursor: default;
        }
        .dot.done    { background: #1d4ed8; color: #fff; }
        .dot.active  { background: #fff; color: #1d4ed8; border: 2.5px solid #1d4ed8; box-shadow: 0 0 0 4px rgba(29,78,216,.15); }
        .dot.pending { background: #e2e8f0; color: #94a3b8; }
        .dot-label   { font-size: .75rem; font-weight: 600; color: #475569; }
        .dot-label.active { color: #1d4ed8; }
        .connector   { width: 32px; height: 2px; background: #e2e8f0; }
        .connector.done { background: #1d4ed8; }

        /* Wizard card */
        .wizard-card {
            width: 100%;
            max-width: 820px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 40px rgba(29,78,216,.1);
            overflow: hidden;
        }

        /* Steps */
        .step { display: none; }
        .step.active { display: block; }

        /* Step 1: Welcome */
        .welcome-hero {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 60%, #0ea5e9 100%);
            padding: 48px 40px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .welcome-hero::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
        }
        .welcome-emoji { font-size: 3.5rem; margin-bottom: 16px; display: block; }
        .welcome-hero h1 { font-size: 1.9rem; font-weight: 800; color: #fff; margin-bottom: 10px; }
        .welcome-hero p { font-size: 1rem; color: rgba(255,255,255,.8); max-width: 480px; margin: 0 auto; line-height: 1.7; }
        .welcome-name { color: #7dd3fc; }

        .welcome-body { padding: 36px 40px; }
        .what-you-get {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 32px;
        }
        .wyg-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 18px 16px;
            text-align: center;
            transition: border-color .2s, box-shadow .2s;
        }
        .wyg-item:hover { border-color: #bfdbfe; box-shadow: 0 4px 12px rgba(29,78,216,.07); }
        .wyg-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            margin: 0 auto 10px;
        }
        .wyg-title { font-size: .88rem; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
        .wyg-desc  { font-size: .78rem; color: #64748b; line-height: 1.5; }

        /* Step 2: How It Works */
        .hiw-header {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            padding: 36px 40px 28px;
            text-align: center;
        }
        .hiw-header .hiw-badge {
            display: inline-block;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 50px;
            padding: 4px 14px;
            font-size: .72rem;
            font-weight: 700;
            color: #bfdbfe;
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }
        .hiw-header h2 { font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 8px; }
        .hiw-header p  { font-size: .9rem; color: rgba(255,255,255,.7); max-width: 520px; margin: 0 auto; line-height: 1.65; }

        .hiw-body { padding: 32px 40px 24px; }

        .hiw-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }
        .hiw-step {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 22px 16px 18px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: border-color .2s, box-shadow .2s;
        }
        .hiw-step:hover { border-color: #bfdbfe; box-shadow: 0 4px 16px rgba(29,78,216,.08); }
        .hiw-step-ghost {
            position: absolute;
            top: -12px; right: -8px;
            font-size: 3.5rem;
            font-weight: 900;
            color: #f1f5f9;
            line-height: 1;
            user-select: none;
        }
        .hiw-step-icon {
            width: 46px; height: 46px;
            border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            margin: 0 auto 12px;
            position: relative;
        }
        .hiw-step h4 { font-size: .9rem; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
        .hiw-step p  { font-size: .77rem; color: #64748b; line-height: 1.55; margin: 0; }

        .hiw-mission {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border-left: 4px solid #1d4ed8;
            border-radius: 0 12px 12px 0;
            padding: 16px 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .hiw-mission i { color: #1d4ed8; font-size: 1.1rem; flex-shrink: 0; margin-top: 2px; }
        .hiw-mission p { font-size: .87rem; color: #1e40af; line-height: 1.65; margin: 0; font-style: italic; }

        .hiw-about-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .8rem;
            font-weight: 600;
            color: #1d4ed8;
            text-decoration: none;
            margin-top: 16px;
        }
        .hiw-about-link:hover { text-decoration: underline; }

        /* Step 3: Tour */
        .tour-header {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 28px 36px 0;
        }
        .tour-header h2 { font-size: 1.3rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
        .tour-header p  { font-size: .88rem; color: #64748b; margin-bottom: 20px; }
        .tour-tabs {
            display: flex;
            gap: 4px;
            overflow-x: auto;
            padding-bottom: 0;
        }
        .tour-tab {
            padding: 10px 16px;
            font-size: .82rem; font-weight: 600;
            color: #64748b;
            border-radius: 8px 8px 0 0;
            cursor: pointer;
            white-space: nowrap;
            border: 1px solid transparent;
            border-bottom: none;
            transition: background .15s, color .15s;
            background: transparent;
        }
        .tour-tab:hover { background: #eff6ff; color: #1d4ed8; }
        .tour-tab.active {
            background: #fff;
            color: #1d4ed8;
            border-color: #e2e8f0;
            border-bottom-color: #fff;
            margin-bottom: -1px;
        }
        .tour-panels { padding: 28px 36px 0; }
        .tour-panel { display: none; }
        .tour-panel.active { display: block; }

        .mock-screen {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .mock-topbar {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            padding: 10px 16px;
            display: flex; align-items: center; gap: 8px;
        }
        .mock-dot { width: 8px; height: 8px; border-radius: 50%; }
        .mock-title { font-size: .75rem; font-weight: 600; color: #475569; margin-left: 4px; }
        .mock-body { padding: 16px; }
        .mock-stat-row { display: flex; gap: 10px; margin-bottom: 12px; }
        .mock-stat {
            flex: 1;
            background: #fff;
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #e2e8f0;
        }
        .mock-stat-label { font-size: .68rem; color: #94a3b8; }
        .mock-stat-val   { font-size: 1rem; font-weight: 800; color: #0f172a; margin-top: 2px; }
        .mock-stat-val.green { color: #059669; }
        .mock-stat-val.red   { color: #dc2626; }
        .mock-stat-val.blue  { color: #1d4ed8; }
        .mock-row {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px;
            background: #fff;
            border-radius: 8px;
            margin-bottom: 6px;
            border: 1px solid #f1f5f9;
        }
        .mock-row-icon { width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: .8rem; flex-shrink: 0; }
        .mock-row-label { flex: 1; font-size: .78rem; color: #334155; font-weight: 500; }
        .mock-row-amount { font-size: .8rem; font-weight: 700; }
        .mock-progress-item { margin-bottom: 10px; }
        .mock-prog-header { display: flex; justify-content: space-between; margin-bottom: 4px; }
        .mock-prog-name { font-size: .78rem; color: #334155; font-weight: 600; }
        .mock-prog-pct  { font-size: .72rem; color: #64748b; }
        .mock-prog-track { height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden; }
        .mock-prog-fill  { height: 100%; border-radius: 4px; }

        .tour-explain h3 { font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
        .tour-explain p  { font-size: .88rem; color: #475569; line-height: 1.7; margin-bottom: 12px; }
        .tour-explain ul { padding-left: 0; list-style: none; }
        .tour-explain ul li {
            font-size: .85rem; color: #334155;
            padding: 5px 0;
            display: flex; align-items: flex-start; gap: 8px;
        }
        .tour-explain ul li::before { content: '✓'; color: #059669; font-weight: 700; flex-shrink: 0; }

        /* Step 4: Ready */
        .step-ready { padding: 48px 40px; text-align: center; }
        .ready-icon { font-size: 4rem; margin-bottom: 20px; display: block; }
        .step-ready h2 { font-size: 1.7rem; font-weight: 800; color: #0f172a; margin-bottom: 10px; }
        .step-ready p  { font-size: .95rem; color: #64748b; max-width: 480px; margin: 0 auto 32px; line-height: 1.7; }

        .setup-checklist {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px 24px;
            text-align: left;
            max-width: 460px;
            margin: 0 auto 32px;
        }
        .setup-checklist h4 { font-size: .82rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #64748b; margin-bottom: 14px; }
        .setup-item {
            display: flex; align-items: center; gap: 12px;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .setup-item:last-child { border-bottom: none; }
        .setup-check {
            width: 22px; height: 22px;
            border-radius: 50%;
            background: #dcfce7;
            display: flex; align-items: center; justify-content: center;
            font-size: .7rem; color: #059669;
            flex-shrink: 0;
        }
        .setup-label { font-size: .88rem; color: #334155; font-weight: 500; }
        .setup-note  { font-size: .75rem; color: #94a3b8; }

        .first-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 10px;
            max-width: 460px;
            margin: 0 auto 28px;
        }
        .first-step-item {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 12px;
            text-align: center;
            text-decoration: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .first-step-item:hover { border-color: #bfdbfe; box-shadow: 0 4px 12px rgba(29,78,216,.08); }
        .first-step-item i { font-size: 1.3rem; color: #1d4ed8; display: block; margin-bottom: 6px; }
        .first-step-item span { font-size: .78rem; font-weight: 600; color: #334155; display: block; }

        /* Footer */
        .wizard-footer {
            padding: 20px 36px;
            border-top: 1px solid #f1f5f9;
            display: flex; align-items: center; justify-content: space-between;
            background: #fafbfc;
        }
        .btn-back {
            background: none;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 22px;
            font-size: .88rem; font-weight: 600; color: #475569;
            cursor: pointer;
            transition: border-color .15s, color .15s;
        }
        .btn-back:hover { border-color: #94a3b8; color: #0f172a; }
        .btn-next {
            background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
            border: none;
            border-radius: 10px;
            padding: 10px 28px;
            font-size: .9rem; font-weight: 700; color: #fff;
            cursor: pointer;
            transition: opacity .15s, transform .15s;
            display: flex; align-items: center; gap: 6px;
        }
        .btn-next:hover { opacity: .9; transform: translateY(-1px); }
        .step-counter { font-size: .78rem; color: #94a3b8; font-weight: 500; }

        @media (max-width: 580px) {
            .welcome-body, .tour-header, .tour-panels, .step-ready, .hiw-body { padding-left: 20px; padding-right: 20px; }
            .hiw-header { padding-left: 20px; padding-right: 20px; }
            .wizard-footer { padding: 16px 20px; }
            .what-you-get, .hiw-steps { grid-template-columns: 1fr 1fr; }
            .welcome-hero { padding: 36px 20px 28px; }
            .connector { width: 16px; }
            .dot-label { display: none; }
        }
    </style>
</head>
<body>

    {{-- Top bar --}}
    <div class="top-bar">
        <img src="/assets/images/Bright v4.png" alt="Bright Finance">
        <form action="{{ route('onboarding.complete') }}" method="POST">
            @csrf
            <button type="submit" class="skip-link" style="background:none;border:none;cursor:pointer;">
                Skip for now →
            </button>
        </form>
    </div>

    {{-- Progress dots --}}
    <div class="progress-bar-wrap" id="progressDots">
        <div class="progress-step">
            <div class="dot active" id="dot-1">1</div>
            <div class="dot-label active" id="label-1">Welcome</div>
        </div>
        <div class="connector" id="conn-1"></div>
        <div class="progress-step">
            <div class="dot pending" id="dot-2">2</div>
            <div class="dot-label" id="label-2">How It Works</div>
        </div>
        <div class="connector" id="conn-2"></div>
        <div class="progress-step">
            <div class="dot pending" id="dot-3">3</div>
            <div class="dot-label" id="label-3">Quick Tour</div>
        </div>
        <div class="connector" id="conn-3"></div>
        <div class="progress-step">
            <div class="dot pending" id="dot-4">4</div>
            <div class="dot-label" id="label-4">Ready!</div>
        </div>
    </div>

    {{-- Wizard card --}}
    <div class="wizard-card">

        {{-- ════ STEP 1: WELCOME ════ --}}
        <div class="step active" id="step-1">
            <div class="welcome-hero">
                <span class="welcome-emoji">👋</span>
                <h1>Welcome, <span class="welcome-name">{{ auth()->user()->name }}!</span></h1>
                <p>You've just made a great financial decision. Bright Finance is your personal toolkit for tracking money, building budgets, and reaching your goals — in minutes a day.</p>
            </div>
            <div class="welcome-body">
                <p style="font-size:.88rem;color:#64748b;margin-bottom:18px;font-weight:500;">Here's what's waiting for you:</p>
                <div class="what-you-get">
                    <div class="wyg-item">
                        <div class="wyg-icon" style="background:#eff6ff;">
                            <i class="fas fa-exchange-alt" style="color:#1d4ed8;"></i>
                        </div>
                        <div class="wyg-title">Transaction Tracking</div>
                        <div class="wyg-desc">Know exactly where every rand goes.</div>
                    </div>
                    <div class="wyg-item">
                        <div class="wyg-icon" style="background:#f0fdf4;">
                            <i class="fas fa-wallet" style="color:#059669;"></i>
                        </div>
                        <div class="wyg-title">Smart Budgeting</div>
                        <div class="wyg-desc">Plan your month before it starts.</div>
                    </div>
                    <div class="wyg-item">
                        <div class="wyg-icon" style="background:#fdf4ff;">
                            <i class="fas fa-bullseye" style="color:#7c3aed;"></i>
                        </div>
                        <div class="wyg-title">Goal Tracking</div>
                        <div class="wyg-desc">Set targets and watch your progress.</div>
                    </div>
                    <div class="wyg-item">
                        <div class="wyg-icon" style="background:#fff7ed;">
                            <i class="fas fa-chart-bar" style="color:#d97706;"></i>
                        </div>
                        <div class="wyg-title">Financial Reports</div>
                        <div class="wyg-desc">See trends, forecasts, and balance sheets.</div>
                    </div>
                </div>

                <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:14px;padding:16px 18px;display:flex;align-items:flex-start;gap:12px;">
                    <i class="fas fa-info-circle" style="color:#0ea5e9;font-size:1.1rem;margin-top:2px;flex-shrink:0;"></i>
                    <div>
                        <div style="font-size:.85rem;font-weight:700;color:#0369a1;margin-bottom:3px;">We already set you up</div>
                        <div style="font-size:.82rem;color:#0369a1;line-height:1.6;">34 standard categories (income, expenses, assets, liabilities) and a debit card have been created for your account. You can customise them at any time.</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════ STEP 2: HOW IT WORKS ════ --}}
        <div class="step" id="step-2">
            <div class="hiw-header">
                <div class="hiw-badge">How It Works</div>
                <h2>Your money, finally making sense</h2>
                <p>Bright Finance connects your daily transactions to your bigger financial picture. Here's the journey — from day one to full financial clarity.</p>
            </div>
            <div class="hiw-body">
                <div class="hiw-steps">
                    <div class="hiw-step">
                        <div class="hiw-step-ghost">1</div>
                        <div class="hiw-step-icon" style="background:#eff6ff;">
                            <i class="fas fa-arrow-right-arrow-left" style="color:#1d4ed8;"></i>
                        </div>
                        <h4>Record</h4>
                        <p>Log every rand in and out. Attach a category so each entry means something.</p>
                    </div>
                    <div class="hiw-step">
                        <div class="hiw-step-ghost">2</div>
                        <div class="hiw-step-icon" style="background:#f0fdf4;">
                            <i class="fas fa-wallet" style="color:#059669;"></i>
                        </div>
                        <h4>Plan</h4>
                        <p>Create a budget before the month starts. Know your limits before you hit them.</p>
                    </div>
                    <div class="hiw-step">
                        <div class="hiw-step-ghost">3</div>
                        <div class="hiw-step-icon" style="background:#fdf4ff;">
                            <i class="fas fa-bullseye" style="color:#7c3aed;"></i>
                        </div>
                        <h4>Track Goals</h4>
                        <p>Set a savings target. Watch your progress. Get reminded when milestones are due.</p>
                    </div>
                    <div class="hiw-step">
                        <div class="hiw-step-ghost">4</div>
                        <div class="hiw-step-icon" style="background:#fff7ed;">
                            <i class="fas fa-chart-line" style="color:#d97706;"></i>
                        </div>
                        <h4>Understand</h4>
                        <p>Reports turn months of data into patterns you can actually act on.</p>
                    </div>
                </div>

                <div class="hiw-mission">
                    <i class="fas fa-quote-left"></i>
                    <p>Most people know what they earn — but have a blurry picture of where it actually ends up. Bright Finance fixes that. It's not a bank, not a spreadsheet. It's the layer between the two — the place where your daily transactions connect to your bigger financial goals.</p>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:18px;flex-wrap:wrap;gap:10px;">
                    <div style="font-size:.82rem;color:#64748b;line-height:1.6;">
                        Behind every transaction, Bright Finance uses real double-entry accounting to keep your balances accurate. Your balance sheet always balances. You never need to think about it.
                    </div>
                    <a href="{{ route('About') }}" target="_blank" class="hiw-about-link">
                        <i class="fas fa-external-link-alt" style="font-size:.7rem;"></i> Full story on our About page
                    </a>
                </div>
            </div>
        </div>

        {{-- ════ STEP 3: QUICK TOUR ════ --}}
        <div class="step" id="step-3">
            <div class="tour-header">
                <h2>A quick look around</h2>
                <p>Click each tab to see how the different parts of Bright Finance work.</p>
                <div class="tour-tabs">
                    <button class="tour-tab active" onclick="showPanel('transactions', this)">Transactions</button>
                    <button class="tour-tab" onclick="showPanel('budgets', this)">Budgets</button>
                    <button class="tour-tab" onclick="showPanel('goals', this)">Goals</button>
                    <button class="tour-tab" onclick="showPanel('reports', this)">Reports</button>
                </div>
            </div>

            <div class="tour-panels">

                {{-- Transactions --}}
                <div class="tour-panel active" id="panel-transactions">
                    <div class="mock-screen">
                        <div class="mock-topbar">
                            <div class="mock-dot" style="background:#ef4444;"></div>
                            <div class="mock-dot" style="background:#f59e0b;"></div>
                            <div class="mock-dot" style="background:#22c55e;"></div>
                            <div class="mock-title">Transactions</div>
                        </div>
                        <div class="mock-body">
                            <div class="mock-stat-row">
                                <div class="mock-stat"><div class="mock-stat-label">This month income</div><div class="mock-stat-val green">ZAR 18,500</div></div>
                                <div class="mock-stat"><div class="mock-stat-label">This month expenses</div><div class="mock-stat-val red">ZAR 9,240</div></div>
                                <div class="mock-stat"><div class="mock-stat-label">Net</div><div class="mock-stat-val blue">ZAR 9,260</div></div>
                            </div>
                            @foreach([['Groceries','Expenses','- ZAR 1,240','#fef2f2','#ef4444'],['Salary Earned','Income','+ ZAR 18,500','#f0fdf4','#059669'],['Fuel','Expenses','- ZAR 640','#fef2f2','#ef4444'],['Entertainment','Expenses','- ZAR 380','#fef2f2','#f59e0b']] as $tx)
                            <div class="mock-row">
                                <div class="mock-row-icon" style="background:{{ $tx[3] }};"><i class="fas fa-arrow-{{ str_contains($tx[2],'+') ? 'down' : 'up' }}" style="color:{{ $tx[4] }};font-size:.7rem;"></i></div>
                                <div class="mock-row-label">{{ $tx[0] }} <span style="font-size:.68rem;color:#94a3b8;">· {{ $tx[1] }}</span></div>
                                <div class="mock-row-amount" style="color:{{ $tx[4] }};">{{ $tx[2] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tour-explain">
                        <h3>Track every transaction</h3>
                        <p>Log income and expenses as they happen. Attach categories, dates, and descriptions so you always know exactly what each entry is.</p>
                        <ul>
                            <li>Log Received, Earned, Paid, or Bought transactions</li>
                            <li>Full edit and delete history</li>
                            <li>Export to CSV for your records</li>
                        </ul>
                    </div>
                </div>

                {{-- Budgets --}}
                <div class="tour-panel" id="panel-budgets">
                    <div class="mock-screen">
                        <div class="mock-topbar">
                            <div class="mock-dot" style="background:#ef4444;"></div>
                            <div class="mock-dot" style="background:#f59e0b;"></div>
                            <div class="mock-dot" style="background:#22c55e;"></div>
                            <div class="mock-title">Budget Management</div>
                        </div>
                        <div class="mock-body">
                            <div style="font-size:.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px;">This Month · Planning</div>
                            @foreach([['Rent','ZAR 8,500','ZAR 8,500','100%','#22c55e'],['Groceries','ZAR 3,000','ZAR 2,160','72%','#f59e0b'],['Transport','ZAR 2,000','ZAR 900','45%','#22c55e'],['Entertainment','ZAR 1,500','ZAR 0','0%','#e2e8f0']] as $b)
                            <div class="mock-progress-item">
                                <div class="mock-prog-header">
                                    <div class="mock-prog-name">{{ $b[0] }}</div>
                                    <div class="mock-prog-pct">{{ $b[2] }} / {{ $b[1] }}</div>
                                </div>
                                <div class="mock-prog-track">
                                    <div class="mock-prog-fill" style="width:{{ $b[3] }};background:{{ $b[4] }};"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tour-explain">
                        <h3>Plan before you spend</h3>
                        <p>Create a budget at the start of the month and track how you're tracking against it in real time. No more end-of-month surprises.</p>
                        <ul>
                            <li>Budget vs. actual comparison per category</li>
                            <li>Set recurring items so you never forget</li>
                            <li>Plan → Finalize workflow keeps you accountable</li>
                        </ul>
                    </div>
                </div>

                {{-- Goals --}}
                <div class="tour-panel" id="panel-goals">
                    <div class="mock-screen">
                        <div class="mock-topbar">
                            <div class="mock-dot" style="background:#ef4444;"></div>
                            <div class="mock-dot" style="background:#f59e0b;"></div>
                            <div class="mock-dot" style="background:#22c55e;"></div>
                            <div class="mock-title">Goals</div>
                        </div>
                        <div class="mock-body">
                            @foreach([['Emergency Fund','ZAR 50,000','ZAR 32,500','65%','#7c3aed'],['Holiday Savings','ZAR 15,000','ZAR 12,750','85%','#059669'],['New Car Deposit','ZAR 80,000','ZAR 24,000','30%','#f59e0b']] as $g)
                            <div style="background:#fff;border:1px solid #f1f5f9;border-radius:10px;padding:12px;margin-bottom:8px;">
                                <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                                    <span style="font-size:.82rem;font-weight:700;color:#0f172a;">{{ $g[0] }}</span>
                                    <span style="font-size:.8rem;font-weight:700;color:{{ $g[4] }};">{{ $g[3] }}</span>
                                </div>
                                <div style="height:8px;background:#e2e8f0;border-radius:4px;overflow:hidden;margin-bottom:5px;">
                                    <div style="height:100%;width:{{ $g[3] }};background:{{ $g[4] }};border-radius:4px;"></div>
                                </div>
                                <div style="font-size:.72rem;color:#94a3b8;">{{ $g[2] }} saved · Target: {{ $g[1] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tour-explain">
                        <h3>Turn dreams into plans</h3>
                        <p>Set financial goals with target amounts and deadlines. Break them into milestones so every step forward feels like progress.</p>
                        <ul>
                            <li>Visual progress bars keep you motivated</li>
                            <li>Milestone-based tracking</li>
                            <li>Dashboard reminders for upcoming milestones</li>
                        </ul>
                    </div>
                </div>

                {{-- Reports --}}
                <div class="tour-panel" id="panel-reports">
                    <div class="mock-screen">
                        <div class="mock-topbar">
                            <div class="mock-dot" style="background:#ef4444;"></div>
                            <div class="mock-dot" style="background:#f59e0b;"></div>
                            <div class="mock-dot" style="background:#22c55e;"></div>
                            <div class="mock-title">Monthly Trends Report</div>
                        </div>
                        <div class="mock-body">
                            <div class="mock-stat-row">
                                <div class="mock-stat"><div class="mock-stat-label">12m Income</div><div class="mock-stat-val green">ZAR 218k</div></div>
                                <div class="mock-stat"><div class="mock-stat-label">12m Expenses</div><div class="mock-stat-val red">ZAR 142k</div></div>
                                <div class="mock-stat"><div class="mock-stat-label">Net Surplus</div><div class="mock-stat-val blue">ZAR 76k</div></div>
                            </div>
                            <div style="font-size:.72rem;font-weight:700;color:#64748b;text-transform:uppercase;margin:10px 0 6px;">Top Expense Categories</div>
                            @foreach([['Rent / Accommodation','ZAR 51,000','100%','#1d4ed8'],['Groceries','ZAR 28,800','56%','#0ea5e9'],['Transport','ZAR 19,200','38%','#7c3aed'],['Entertainment','ZAR 8,400','16%','#f59e0b']] as $c)
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                                <div style="font-size:.72rem;color:#334155;min-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $c[0] }}</div>
                                <div style="flex:1;height:7px;background:#e2e8f0;border-radius:4px;overflow:hidden;"><div style="height:100%;width:{{ $c[2] }};background:{{ $c[3] }};border-radius:4px;"></div></div>
                                <div style="font-size:.72rem;font-weight:700;color:#475569;white-space:nowrap;">{{ $c[1] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tour-explain">
                        <h3>Understand your patterns</h3>
                        <p>The reports section gives you a full financial picture — spending trends, cash forecasts, balance sheets, and category breakdowns across the last 12 months.</p>
                        <ul>
                            <li>Monthly income vs expense trends</li>
                            <li>Cash budget forecast for next month</li>
                            <li>Full balance sheet and trial balance</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        {{-- ════ STEP 4: READY ════ --}}
        <div class="step" id="step-4">
            <span class="ready-icon">🚀</span>
            <h2 class="step-ready">You're all set, {{ auth()->user()->name }}!</h2>
            <p style="font-size:.95rem;color:#64748b;max-width:480px;margin:0 auto 32px;line-height:1.7;">Everything is ready for you. Here's what was automatically set up, and a few things to do first to get the most out of Bright Finance.</p>

            <div class="setup-checklist">
                <h4>Already done for you</h4>
                <div class="setup-item">
                    <div class="setup-check"><i class="fas fa-check" style="font-size:.65rem;"></i></div>
                    <div>
                        <div class="setup-label">34 standard categories created</div>
                        <div class="setup-note">Income, expenses, assets, liabilities — ready to use</div>
                    </div>
                </div>
                <div class="setup-item">
                    <div class="setup-check"><i class="fas fa-check" style="font-size:.65rem;"></i></div>
                    <div>
                        <div class="setup-label">Debit card record added</div>
                        <div class="setup-note">Update your card details in Cards → Edit</div>
                    </div>
                </div>
                <div class="setup-item">
                    <div class="setup-check"><i class="fas fa-check" style="font-size:.65rem;"></i></div>
                    <div>
                        <div class="setup-label">Dashboard personalised for you</div>
                        <div class="setup-note">Your financial overview is ready</div>
                    </div>
                </div>
            </div>

            <p style="font-size:.88rem;font-weight:700;color:#334155;margin-bottom:14px;">Where to start:</p>
            <div class="first-steps">
                <a href="{{ route('transactions.create') }}" class="first-step-item">
                    <i class="material-icons-round">swap_horiz</i>
                    <span>Add your first transaction</span>
                </a>
                <a href="{{ route('budgets.create') }}" class="first-step-item">
                    <i class="material-icons-round">account_balance_wallet</i>
                    <span>Create a budget</span>
                </a>
                <a href="{{ route('goals.create') }}" class="first-step-item">
                    <i class="material-icons-round">flag</i>
                    <span>Set a savings goal</span>
                </a>
                <a href="{{ route('cards.index') }}" class="first-step-item">
                    <i class="material-icons-round">credit_card</i>
                    <span>Update your card</span>
                </a>
            </div>

            <a href="{{ route('About') }}" target="_blank" style="font-size:.8rem;color:#64748b;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
                <i class="fas fa-book-open" style="font-size:.75rem;"></i> Read the full Bright Finance story
            </a>
        </div>

        {{-- Footer --}}
        <div class="wizard-footer">
            <button class="btn-back" id="btnBack" onclick="prevStep()" style="visibility:hidden;">← Back</button>
            <span class="step-counter" id="stepCounter">Step 1 of 4</span>
            <button class="btn-next" id="btnNext" onclick="nextStep()">
                Next <i class="fas fa-arrow-right" style="font-size:.8rem;"></i>
            </button>
        </div>

    </div>

    <form action="{{ route('onboarding.complete') }}" method="POST" id="completeForm">@csrf</form>

    <script>
        var currentStep = 1;
        var totalSteps  = 4;
        var labels = ['Welcome', 'How It Works', 'Quick Tour', 'Ready!'];

        function updateDots() {
            for (var i = 1; i <= totalSteps; i++) {
                var dot   = document.getElementById('dot-'   + i);
                var label = document.getElementById('label-' + i);
                var conn  = document.getElementById('conn-'  + i);

                dot.className = 'dot ' + (i < currentStep ? 'done' : i === currentStep ? 'active' : 'pending');
                dot.innerHTML = i < currentStep
                    ? '<i class="fas fa-check" style="font-size:.65rem;"></i>'
                    : String(i);

                if (label) {
                    label.className = 'dot-label' + (i === currentStep ? ' active' : '');
                }
                if (conn) {
                    conn.className = 'connector' + (i < currentStep ? ' done' : '');
                }
            }

            document.getElementById('stepCounter').textContent = 'Step ' + currentStep + ' of ' + totalSteps;
            document.getElementById('btnBack').style.visibility = currentStep === 1 ? 'hidden' : 'visible';

            var btn = document.getElementById('btnNext');
            btn.innerHTML = currentStep === totalSteps
                ? 'Go to Dashboard <i class="fas fa-rocket" style="font-size:.8rem;"></i>'
                : 'Next <i class="fas fa-arrow-right" style="font-size:.8rem;"></i>';
        }

        function showStep(n) {
            for (var i = 1; i <= totalSteps; i++) {
                document.getElementById('step-' + i).classList.toggle('active', i === n);
            }
            currentStep = n;
            updateDots();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function nextStep() {
            if (currentStep < totalSteps) {
                showStep(currentStep + 1);
            } else {
                document.getElementById('completeForm').submit();
            }
        }

        function prevStep() {
            if (currentStep > 1) showStep(currentStep - 1);
        }

        function showPanel(panelId, tabEl) {
            document.querySelectorAll('.tour-panel').forEach(function(p) { p.classList.remove('active'); });
            document.querySelectorAll('.tour-tab').forEach(function(t)   { t.classList.remove('active'); });
            document.getElementById('panel-' + panelId).classList.add('active');
            tabEl.classList.add('active');
        }

        updateDots();
    </script>
</body>
</html>
