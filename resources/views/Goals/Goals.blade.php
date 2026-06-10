@extends('layouts.Nav')

@section('title', 'Goals')
@section('page-title', 'Financial Goals')

@section('breadcrumb')
<li class="breadcrumb-item active">Goals</li>
@endsection

@section('content')
<style>
.goal-hero { background: linear-gradient(135deg,#1e3a8a 0%,#1d4ed8 100%); border-radius:16px; padding:40px 36px; color:#fff; margin-bottom:28px; }
.goal-card { border:1px solid #e2e8f0; border-radius:14px; padding:24px; background:#fff; height:100%; transition:box-shadow .2s; }
.goal-card:hover { box-shadow:0 4px 24px rgba(29,78,216,.1); }
.goal-icon { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:14px; font-size:1.4rem; }
</style>

<div class="goal-hero">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.6);margin-bottom:8px;">
                <i class="material-icons-round me-1" style="font-size:.9rem;vertical-align:middle;">flag</i> Financial Goals
            </div>
            <h2 style="font-weight:800;font-size:1.7rem;margin-bottom:10px;">Set Goals, Build Your Future</h2>
            <p style="color:rgba(255,255,255,.8);font-size:.95rem;max-width:480px;margin-bottom:0;">
                SMART financial goals give your money a purpose. Track savings targets, debt repayments, and investments — all in one place.
            </p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('goals.index') }}" class="btn btn-light me-2" style="border-radius:10px;font-weight:600;font-size:.88rem;">
                <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">list</i> My Goals
            </a>
            <a href="{{ route('goals.create') }}" class="btn" style="background:rgba(255,255,255,.15);color:#fff;border:1.5px solid rgba(255,255,255,.35);border-radius:10px;font-weight:600;font-size:.88rem;">
                <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">add</i> New Goal
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <p style="font-size:.85rem;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.06em;">Goal types you can track</p>
    </div>
    <div class="col-md-4 mb-3">
        <div class="goal-card">
            <div class="goal-icon" style="background:#f0fdf4;">
                <i class="material-icons-round" style="color:#16a34a;">savings</i>
            </div>
            <h5 style="font-weight:700;color:#0f172a;margin-bottom:8px;">Emergency Fund</h5>
            <p style="font-size:.86rem;color:#64748b;margin-bottom:12px;">Save a target amount to cover unexpected expenses and build a financial safety net.</p>
            <ul style="list-style:none;padding:0;margin:0;">
                <li style="font-size:.82rem;color:#475569;padding:4px 0;border-bottom:1px solid #f8fafc;"><i class="material-icons-round me-1" style="font-size:.8rem;color:#16a34a;vertical-align:middle;">check_circle</i> Peace of mind for emergencies</li>
                <li style="font-size:.82rem;color:#475569;padding:4px 0;border-bottom:1px solid #f8fafc;"><i class="material-icons-round me-1" style="font-size:.8rem;color:#16a34a;vertical-align:middle;">check_circle</i> 3–6 months of living expenses</li>
                <li style="font-size:.82rem;color:#475569;padding:4px 0;"><i class="material-icons-round me-1" style="font-size:.8rem;color:#16a34a;vertical-align:middle;">check_circle</i> Protect against income disruption</li>
            </ul>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="goal-card">
            <div class="goal-icon" style="background:#fff1f2;">
                <i class="material-icons-round" style="color:#e11d48;">account_balance</i>
            </div>
            <h5 style="font-weight:700;color:#0f172a;margin-bottom:8px;">Debt Repayment</h5>
            <p style="font-size:.86rem;color:#64748b;margin-bottom:12px;">Pay off credit card debt, personal loans, or any outstanding obligations with a clear plan.</p>
            <ul style="list-style:none;padding:0;margin:0;">
                <li style="font-size:.82rem;color:#475569;padding:4px 0;border-bottom:1px solid #f8fafc;"><i class="material-icons-round me-1" style="font-size:.8rem;color:#e11d48;vertical-align:middle;">check_circle</i> Eliminate high-interest debt first</li>
                <li style="font-size:.82rem;color:#475569;padding:4px 0;border-bottom:1px solid #f8fafc;"><i class="material-icons-round me-1" style="font-size:.8rem;color:#e11d48;vertical-align:middle;">check_circle</i> Reduce financial stress</li>
                <li style="font-size:.82rem;color:#475569;padding:4px 0;"><i class="material-icons-round me-1" style="font-size:.8rem;color:#e11d48;vertical-align:middle;">check_circle</i> Build a solid financial foundation</li>
            </ul>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="goal-card">
            <div class="goal-icon" style="background:#eff6ff;">
                <i class="material-icons-round" style="color:#1d4ed8;">trending_up</i>
            </div>
            <h5 style="font-weight:700;color:#0f172a;margin-bottom:8px;">Savings & Investing</h5>
            <p style="font-size:.86rem;color:#64748b;margin-bottom:12px;">Build retirement savings, grow investments, or save for a specific future goal.</p>
            <ul style="list-style:none;padding:0;margin:0;">
                <li style="font-size:.82rem;color:#475569;padding:4px 0;border-bottom:1px solid #f8fafc;"><i class="material-icons-round me-1" style="font-size:.8rem;color:#1d4ed8;vertical-align:middle;">check_circle</i> Compounding interest over time</li>
                <li style="font-size:.82rem;color:#475569;padding:4px 0;border-bottom:1px solid #f8fafc;"><i class="material-icons-round me-1" style="font-size:.8rem;color:#1d4ed8;vertical-align:middle;">check_circle</i> Long-term wealth building</li>
                <li style="font-size:.82rem;color:#475569;padding:4px 0;"><i class="material-icons-round me-1" style="font-size:.8rem;color:#1d4ed8;vertical-align:middle;">check_circle</i> Work towards retirement security</li>
            </ul>
        </div>
    </div>
</div>

<div class="card text-center py-5" style="border-radius:16px;border:1px solid #e2e8f0;">
    <i class="material-icons-round" style="font-size:2.5rem;color:#1d4ed8;">flag</i>
    <h5 class="mt-3 mb-1" style="font-weight:700;color:#0f172a;">Ready to take control?</h5>
    <p style="font-size:.88rem;color:#64748b;max-width:400px;margin:8px auto 0;">Start with one goal today — the habit of tracking builds financial momentum over time.</p>
    <div class="mt-3 d-flex justify-content-center gap-2 flex-wrap">
        <a href="{{ route('goals.create') }}" class="btn btn-primary" style="border-radius:10px;font-weight:600;">
            <i class="material-icons-round me-1" style="font-size:.95rem;vertical-align:middle;">add</i> Create your first goal
        </a>
        <a href="{{ route('goals.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;font-weight:600;">View my goals</a>
    </div>
</div>
@endsection
