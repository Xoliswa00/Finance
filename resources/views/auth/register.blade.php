@extends('layouts.app')

@section('title', 'Create Account')

@section('head')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 140px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 16px;
        background: linear-gradient(135deg, #f0f4ff 0%, #f8fafc 100%);
    }
    .auth-card {
        width: 100%;
        max-width: 540px;
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 8px 40px rgba(29,78,216,.1);
        overflow: hidden;
    }
    .auth-header {
        background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
        padding: 32px 32px 28px;
        text-align: center;
    }
    .auth-header img { height: 3rem; margin-bottom: 12px; }
    .auth-header h1 { font-size: 1.4rem; font-weight: 800; color: #fff; margin: 0; }
    .auth-header p { font-size: 0.85rem; color: rgba(255,255,255,.75); margin: 6px 0 0; }

    .auth-body { padding: 32px; }

    .auth-field { margin-bottom: 16px; }
    .auth-field label { display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px; }
    .auth-field .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.9rem;
        color: #0f172a;
        transition: border-color .15s, box-shadow .15s;
        width: 100%;
    }
    .auth-field .form-control:focus {
        border-color: #1d4ed8;
        box-shadow: 0 0 0 3px rgba(29,78,216,.1);
        outline: none;
    }
    .auth-field .form-control.is-invalid { border-color: #ef4444; }
    .auth-field .invalid-feedback { font-size: 0.78rem; color: #ef4444; margin-top: 4px; }

    .auth-btn {
        width: 100%;
        background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 12px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: opacity .15s, transform .15s;
        margin-top: 6px;
    }
    .auth-btn:hover { opacity: .92; transform: translateY(-1px); }

    .auth-footer { padding: 0 32px 28px; text-align: center; font-size: 0.85rem; color: #64748b; }
    .auth-footer a { color: #1d4ed8; font-weight: 600; text-decoration: none; }
    .auth-footer a:hover { text-decoration: underline; }

    .auth-divider { border: none; border-top: 1px solid #f1f5f9; margin: 4px 32px 20px; }

    .field-hint { font-size: 0.75rem; color: #94a3b8; margin-top: 3px; }

    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    @media (max-width: 480px) { .two-col { grid-template-columns: 1fr; } }

    .perks {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 22px;
    }
    .perks ul { margin: 0; padding: 0 0 0 16px; }
    .perks li { font-size: 0.8rem; color: #0369a1; margin-bottom: 3px; }
</style>
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">

        <div class="auth-header">
            <img src="/assets/images/Bright v4.png" alt="Bright Finance">
            <h1>Create your free account</h1>
            <p>Start managing your money smarter today</p>
        </div>

        <div class="auth-body">

            <div class="perks">
                <ul>
                    <li>✓ Free forever — no credit card required</li>
                    <li>✓ Full access to budgets, goals, and reports</li>
                    <li>✓ Your data is private and secure</li>
                </ul>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="two-col">
                    <div class="auth-field">
                        <label for="name">First Name</label>
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}"
                               required autocomplete="given-name" autofocus
                               placeholder="John">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <label for="Surname">Surname</label>
                        <input id="Surname" type="text"
                               class="form-control @error('Surname') is-invalid @enderror"
                               name="Surname" value="{{ old('Surname') }}"
                               required autocomplete="family-name"
                               placeholder="Doe">
                        @error('Surname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="auth-field">
                    <label for="email">Email Address</label>
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}"
                           required autocomplete="email"
                           placeholder="you@example.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="two-col">
                    <div class="auth-field">
                        <label for="Mobile">Mobile Number</label>
                        <input id="Mobile" type="tel"
                               class="form-control @error('Mobile') is-invalid @enderror"
                               name="Mobile" value="{{ old('Mobile') }}"
                               required pattern="[0-9]{10}"
                               placeholder="0812345678">
                        <div class="field-hint">10-digit SA number</div>
                        @error('Mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <label for="Location">City, Country</label>
                        <input id="Location" type="text"
                               class="form-control @error('Location') is-invalid @enderror"
                               name="Location" value="{{ old('Location') }}"
                               required
                               placeholder="Cape Town, ZA">
                        @error('Location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="two-col">
                    <div class="auth-field">
                        <label for="password">Password</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password"
                               placeholder="••••••••">
                        <div class="field-hint">Min 8 characters</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <label for="password-confirm">Confirm Password</label>
                        <input id="password-confirm" type="password"
                               class="form-control"
                               name="password_confirmation" required autocomplete="new-password"
                               placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="auth-btn">Create My Account →</button>
            </form>
        </div>

        <hr class="auth-divider">
        <div class="auth-footer">
            Already have an account?
            <a href="{{ route('login') }}">Sign in →</a>
        </div>

    </div>
</div>
@endsection
