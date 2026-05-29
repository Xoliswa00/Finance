@extends('layouts.app')

@section('title', 'Contact — Bright Finance')
@section('meta-description', 'Get in touch with the Bright Finance team. We\'re here to help with questions, support, and feedback.')

@section('head')
<style>
    .contact-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        padding: 70px 0 50px;
        text-align: center;
        color: #fff;
    }
    .contact-hero h1 { font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 800; }
    .contact-hero p { color: rgba(255,255,255,.75); font-size: 1rem; max-width: 500px; margin: 12px auto 0; }

    .contact-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 36px 30px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,.06);
        height: 100%;
        transition: box-shadow .2s, transform .2s;
    }
    .contact-card:hover { box-shadow: 0 12px 36px rgba(0,0,0,.1); transform: translateY(-3px); }
    .contact-icon {
        width: 64px; height: 64px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem;
        margin: 0 auto 20px;
    }
    .contact-card h4 { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
    .contact-card p { font-size: 0.88rem; color: #64748b; line-height: 1.6; margin-bottom: 20px; }

    .hours-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f0fdf4;
        color: #059669;
        border: 1px solid #bbf7d0;
        border-radius: 50px;
        padding: 4px 12px;
        font-size: 0.78rem;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .faq-section { padding: 70px 0; background: #f8fafc; }
    .faq-item {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 12px;
        overflow: hidden;
    }
    .faq-question {
        padding: 18px 20px;
        font-weight: 600;
        font-size: 0.92rem;
        color: #0f172a;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .faq-question:hover { background: #f8fafc; }
    .faq-answer {
        padding: 0 20px 18px;
        font-size: 0.86rem;
        color: #475569;
        line-height: 1.7;
    }
</style>
@endsection

@section('content')

{{-- Hero --}}
<div class="contact-hero">
    <div class="container">
        <div style="display:inline-block;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:50px;padding:5px 14px;font-size:.78rem;font-weight:600;color:#bfdbfe;margin-bottom:14px;">
            Get in Touch
        </div>
        <h1>We're Here to Help</h1>
        <p>Questions, feedback, or need support? We'd love to hear from you. Reach out via any of the channels below.</p>
    </div>
</div>

{{-- Contact Cards --}}
<section style="padding:70px 0;background:#fff;">
    <div class="container">
        <div class="row g-4 justify-content-center">

            {{-- Email --}}
            <div class="col-12 col-md-4">
                <div class="contact-card">
                    <div class="contact-icon" style="background:#eff6ff;">
                        <i class="fas fa-envelope" style="color:#1d4ed8;"></i>
                    </div>
                    <h4>Email Us</h4>
                    <p>Drop us a message and we'll reply within a few hours on working days.</p>
                    <div class="hours-badge">
                        <i class="fas fa-circle" style="font-size:.5rem;"></i>
                        Mon – Fri, 09:00 – 18:00
                    </div>
                    <br>
                    <a href="mailto:bester12@outlook.com" class="btn btn-primary w-100" style="border-radius:10px;font-weight:600;">
                        <i class="fas fa-paper-plane me-2"></i>Send an Email
                    </a>
                </div>
            </div>

            {{-- Phone --}}
            <div class="col-12 col-md-4">
                <div class="contact-card">
                    <div class="contact-icon" style="background:#f0fdf4;">
                        <i class="fas fa-phone-alt" style="color:#059669;"></i>
                    </div>
                    <h4>Call Us</h4>
                    <p>Prefer a voice call? We're available during business hours for quick queries and support.</p>
                    <div class="hours-badge">
                        <i class="fas fa-circle" style="font-size:.5rem;"></i>
                        Mon – Fri, 09:00 – 18:00
                    </div>
                    <br>
                    <a href="tel:0606861764" class="btn btn-success w-100" style="border-radius:10px;font-weight:600;">
                        <i class="fas fa-phone me-2"></i>060 686 1764
                    </a>
                </div>
            </div>

            {{-- WhatsApp --}}
            <div class="col-12 col-md-4">
                <div class="contact-card">
                    <div class="contact-icon" style="background:#f0fdf4;">
                        <i class="fab fa-whatsapp" style="color:#25D366;font-size:1.8rem;"></i>
                    </div>
                    <h4>WhatsApp</h4>
                    <p>The fastest way to reach us. Send a message and we'll respond as soon as we're available.</p>
                    <div class="hours-badge" style="background:#f0fdf4;color:#25D366;border-color:#bbf7d0;">
                        <i class="fas fa-circle" style="font-size:.5rem;"></i>
                        Usually replies quickly
                    </div>
                    <br>
                    <a href="https://wa.me/27606861764" target="_blank" class="btn w-100 fw-bold text-white" style="background:#25D366;border-radius:10px;">
                        <i class="fab fa-whatsapp me-2"></i>Chat on WhatsApp
                    </a>
                </div>
            </div>

        </div>

        {{-- Location --}}
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-8">
                <div style="background:#f8fafc;border-radius:16px;border:1px solid #e2e8f0;padding:28px 24px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                    <div style="width:52px;height:52px;border-radius:50%;background:#eff6ff;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">
                        <i class="fas fa-map-marker-alt" style="color:#1d4ed8;"></i>
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:0.95rem;color:#0f172a;">Based in South Africa 🇿🇦</div>
                        <div style="font-size:0.85rem;color:#64748b;margin-top:2px;">Serving individuals and small businesses across South Africa.</div>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('register') }}" class="btn btn-outline-primary" style="border-radius:10px;font-weight:600;">Get Started Free</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="faq-section">
    <div class="container">
        <div class="text-center mb-5">
            <div style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1d4ed8;margin-bottom:8px;">FAQ</div>
            <h2 style="font-size:1.8rem;font-weight:800;color:#0f172a;">Frequently Asked Questions</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                @php
                    $faqs = [
                        ['Is Bright Finance free to use?', 'Yes! Creating an account and using the core features is completely free. Sign up today with no credit card required.'],
                        ['Is my financial data secure?', 'Absolutely. Your data is stored securely and is only accessible by you. We use session-based authentication and role-based access control to protect your information.'],
                        ['Can I export my transaction history?', 'Yes. Bright Finance allows you to download your full transaction history as a CSV file — perfect for sharing with your accountant or importing into Excel.'],
                        ['What currencies are supported?', 'Bright Finance is primarily designed for South African Rand (ZAR). All amounts are displayed in ZAR format.'],
                        ['Can I use this for my small business?', 'Absolutely. The platform includes journal entries, balance sheets, and multi-category support — making it suitable for freelancers and small businesses in addition to personal finance use.'],
                        ['How do I get started?', 'Just click "Sign Up Free", create your account, and you\'ll be guided through setting up your categories and recording your first transactions. The whole process takes under 5 minutes.'],
                    ];
                @endphp
                @foreach($faqs as $i => $faq)
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}">
                        {{ $faq[0] }}
                        <i class="fas fa-chevron-down" style="font-size:.75rem;color:#94a3b8;"></i>
                    </div>
                    <div class="collapse" id="faq{{ $i }}">
                        <div class="faq-answer">{{ $faq[1] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section style="padding:60px 0;background:#fff;">
    <div class="container text-center">
        <h2 style="font-size:1.6rem;font-weight:800;color:#0f172a;">Still have questions?</h2>
        <p style="color:#64748b;margin:10px 0 24px;">Our team is happy to help. Send us a message and we'll get back to you quickly.</p>
        <a href="mailto:bester12@outlook.com" class="btn btn-primary btn-lg px-5 me-3" style="border-radius:10px;font-weight:600;">Email Us</a>
        <a href="https://wa.me/27606861764" target="_blank" class="btn btn-lg px-5 fw-bold text-white" style="background:#25D366;border-radius:10px;">WhatsApp Us</a>
    </div>
</section>

@endsection
