@extends('layouts.app')

@section('content')
<section 
    data-bs-version="5.1" 
    class="header2 cid-tFjzdWY4mW mbr-fullscreen mbr-parallax-background d-flex align-items-center" 
    id="header2-2"
>
    <div class="mbr-overlay position-absolute top-0 start-0 w-100 h-100" style="opacity: 0; z-index: -1;"></div>

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
        <div class="card shadow-lg rounded-4 p-5 text-center" >
    <div class="card-body">
        <h1 class="display-5 fw-bold mb-4 text-white">
           Bring Brightness to Your Finances
        </h1>

        <p class="lead mb-3">
             Learn more about your finances
        </p>

        <p>
            Join a growing community taking control of their income, expenses, and financial goals. Our platform is your smart, simple companion on the path to financial clarity and success.
        </p>

        <p class="mt-4 fw-semibold text-dark">
            💡 Why this app ?:
        </p>
        <p class="text-white small">
            Bright Finance helps you track income and expenses, set savings goals, analyze spending patterns, and stay on top of your financial health — all in one simple dashboard.
        </p>

        <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
            <a class="btn btn-primary btn-lg px-4 me-md-2" href="{{ route('register') }}">
                {{ __('Sign Up Free') }}
            </a>
            <a class="btn btn-outline-secondary btn-lg px-4" href="{{ route('login') }}">
                {{ __('Log In') }}
            </a>
        </div>

       
    </div>
</div>

        </div>
    </div>
</div>

</section>
@endsection
