@extends('layouts.app')

@section('title', 'About Bright Finance')
@section('meta-description', 'Learn about Bright Finance — a personal and small business financial management platform built to help South Africans take control of their money.')

@section('head')
<style>
    .about-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        padding: 80px 0 60px;
        text-align: center;
        color: #fff;
    }
    .about-hero h1 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; }
    .about-hero p { color: rgba(255,255,255,.75); font-size: 1.05rem; max-width: 600px; margin: 14px auto 0; }

    .value-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 28px 24px;
        text-align: center;
        transition: box-shadow .2s;
        height: 100%;
    }
    .value-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.08); }
    .value-icon {
        width: 56px; height: 56px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        margin: 0 auto 16px;
    }
    .value-card h4 { font-size: 1rem; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
    .value-card p { font-size: 0.84rem; color: #64748b; line-height: 1.65; margin: 0; }

    .story-section { padding: 80px 0; background: #f8fafc; }
    .story-text { font-size: 1rem; color: #475569; line-height: 1.9; }
    .story-text strong { color: #0f172a; }

    .highlight-box {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border-left: 4px solid #1d4ed8;
        border-radius: 0 12px 12px 0;
        padding: 20px 24px;
        margin: 24px 0;
    }
    .highlight-box p { font-size: 1rem; font-style: italic; color: #1e40af; margin: 0; font-weight: 500; }

    .stat-pill {
        display: inline-block;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        padding: 8px 20px;
        margin: 6px;
        font-size: 0.85rem;
        color: #334155;
    }
    .stat-pill strong { color: #1d4ed8; }

    .team-section { padding: 80px 0; background: #fff; }
    .mission-section { padding: 80px 0; background: #0f172a; color: #fff; }
    .mission-section h2 { font-size: 2rem; font-weight: 800; }
    .mission-section p { color: rgba(255,255,255,.75); font-size: 1rem; line-height: 1.8; max-width: 700px; margin: 0 auto; }

    .timeline { position: relative; padding-left: 28px; }
    .timeline::before { content: ''; position: absolute; left: 10px; top: 0; bottom: 0; width: 2px; background: #e2e8f0; }
    .timeline-item { position: relative; margin-bottom: 28px; }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -22px;
        top: 4px;
        width: 12px; height: 12px;
        border-radius: 50%;
        background: #1d4ed8;
        border: 2px solid #fff;
        box-shadow: 0 0 0 3px #bfdbfe;
    }
    .timeline-year { font-size: 0.75rem; font-weight: 700; color: #1d4ed8; text-transform: uppercase; letter-spacing:.05em; }
    .timeline-desc { font-size: 0.9rem; color: #334155; margin-top: 2px; }
</style>
@endsection

@section('content')

{{-- Hero --}}
<div class="about-hero">
    <div class="container">
        <div style="display:inline-block;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:50px;padding:5px 14px;font-size:.78rem;font-weight:600;color:#bfdbfe;margin-bottom:14px;">
            Our Story
        </div>
        <h1>Built to Bring Brightness<br>to Your Finances</h1>
        <p>Bright Finance started as a simple idea — give everyday South Africans a clear, honest view of their financial health. It's grown into a complete financial management platform.</p>
    </div>
</div>

{{-- Our Story --}}
<section class="story-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1d4ed8;margin-bottom:8px;">How It Started</div>
                <h2 style="font-size:1.8rem;font-weight:800;color:#0f172a;margin-bottom:16px;">Born from a real financial challenge</h2>
                <div class="story-text">
                    <p>Managing personal finances in South Africa can be complex. Juggling income, expenses, loan repayments, and savings goals across scattered spreadsheets and apps often leads to confusion, overspending, and missed opportunities to grow wealth.</p>
                    <div class="highlight-box">
                        <p>"I wanted a tool that thought the way I did about money — one that used real accounting principles but was simple enough for anyone to use."</p>
                    </div>
                    <p>Bright Finance was built to solve exactly that problem. Drawing on <strong>double-entry bookkeeping principles</strong> and a deep understanding of how South Africans manage their day-to-day finances, the platform combines the rigour of accounting with the simplicity of a modern app.</p>
                    <p>From tracking your grocery spend to forecasting next month's cash position, Bright Finance gives you the tools and insights to make <strong>confident, informed financial decisions</strong>.</p>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="p-4" style="background:#fff;border-radius:20px;border:1px solid #e2e8f0;">
                    <div style="font-size:.82rem;font-weight:700;color:#475569;margin-bottom:20px;text-transform:uppercase;letter-spacing:.06em;">Our Journey</div>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-year">2021</div>
                            <div class="timeline-desc">First version launched — basic income, expense, and budget tracking.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2022</div>
                            <div class="timeline-desc">Added goal setting, milestones, and the balance sheet report.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2023</div>
                            <div class="timeline-desc">Journal entry system and cash budget forecasting added.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2024</div>
                            <div class="timeline-desc">Admin dashboard, activity logging, and error tracking added.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2025+</div>
                            <div class="timeline-desc">Major revamp — improved UX, new reports, monthly trend analysis.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section style="padding:80px 0;background:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <div style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1d4ed8;margin-bottom:8px;">Our Values</div>
            <h2 style="font-size:1.8rem;font-weight:800;color:#0f172a;">What drives everything we build</h2>
        </div>
        <div class="row g-4">
            @php
                $values = [
                    ['fa-eye','#eff6ff','#1d4ed8','Transparency','Your data is yours. We show you exactly what's happening with your money — no smoke, no mirrors.'],
                    ['fa-bolt','#fefce8','#d97706','Simplicity','Financial tools don't have to be complicated. We strip away the noise so you can focus on what matters.'],
                    ['fa-lock','#f0fdf4','#059669','Security','Your financial information is sensitive. We treat it with the same care you would.'],
                    ['fa-seedling','#fdf4ff','#7c3aed','Growth','Every feature is built to help you move forward — toward savings goals, financial stability, and peace of mind.'],
                ];
            @endphp
            @foreach($values as $v)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="value-card">
                    <div class="value-icon" style="background:{{ $v[1] }};">
                        <i class="fas {{ $v[0] }}" style="color:{{ $v[2] }};"></i>
                    </div>
                    <h4>{{ $v[3] }}</h4>
                    <p>{{ $v[4] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Mission --}}
<section class="mission-section text-center">
    <div class="container">
        <div style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#7dd3fc;margin-bottom:12px;">Our Mission</div>
        <h2>To give every South African<br>financial clarity and confidence.</h2>
        <p class="mt-4">We believe financial management shouldn't be reserved for accountants and the wealthy. Bright Finance is built to put powerful tools in the hands of everyone — students, entrepreneurs, families, and professionals alike.</p>
        <div class="mt-5 d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-light fw-bold px-5" style="border-radius:10px;">Join Us Today</a>
            <a href="{{ route('Contact') }}" class="btn btn-outline-light px-5" style="border-radius:10px;">Get in Touch</a>
        </div>
    </div>
</section>

@endsection
