@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-8">
        <div class="card shadow rounded-3">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Welcome to Bright Finance</h4>
            </div>
            <div class="card-body text-center">
                <p class="lead">We're glad to have you on board 🎉</p>
                <p class="text-muted">Explore your dashboard, manage your finances, and enjoy a smarter way to grow.</p>

                <a href="{{ route('home') }}" class="btn btn-success mt-3 mb-4">Go to Dashboard</a>

                <hr>

                <div class="text-start mt-4">
                    <h6>Need help?</h6>
                    <p class="mb-1">Reach out to our support team:</p>
                    <ul class="list-unstyled">
                        <li><strong>Email:</strong> <a href="mailto:admin@brightfinance-x.co.za">admin@brightfinance-x.co.za</a></li>
                        <li><strong>Phone:</strong> <a href="tel:+2767417419">0674017419</a></li>
                        <li><strong>WhatsApp:</strong> 
                            <a href="https://wa.me/0674017419" target="_blank" rel="noopener noreferrer">
                                0674017419
                            </a>
                        </li>
                        <li><strong>Hours:</strong> Mon–Fri, 8:00–17:00</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
