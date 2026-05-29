@extends('layouts.app')

@section('title', 'Log In')

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
        max-width: 440px;
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

    .auth-field { margin-bottom: 18px; }
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
</style>
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">

        <div class="auth-header">
            <img src="/assets/images/Bright v4.png" alt="Bright Finance">
            <h1>Welcome back</h1>
            <p>Sign in to your Bright Finance account</p>
        </div>

        <div class="auth-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="auth-field">
                    <label for="email">Email Address</label>
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}"
                           required autocomplete="email" autofocus
                           placeholder="you@example.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password">Password</label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size:.78rem;color:#1d4ed8;font-weight:600;">Forgot password?</a>
                        @endif
                    </div>
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="current-password"
                           placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center gap-2 mb-4" style="font-size:.84rem;color:#475569;">
                    <input class="form-check-input m-0" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Keep me signed in</label>
                </div>

                <button type="submit" class="auth-btn">Sign In</button>
            </form>
        </div>

        <hr class="auth-divider">
        <div class="auth-footer">
            Don't have an account?
            <a href="{{ route('register') }}">Create one free →</a>
        </div>

    </div>
</div>
@endsection
