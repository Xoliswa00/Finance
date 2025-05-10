@extends('layouts.app')

@section('content')
<section 
    data-bs-version="5.1" 
    class="features12 cid-tFjGn3mYhs py-5 bg-light" 
    id="features13-4"
>
    <div class="container">
        <div class="row justify-content-center align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="display-4 fw-bold text-primary mb-3">
                    Bright Finance
                </h2>
                <p class="lead">
                    Your trusted companion for building financial freedom.
                </p>
                <p class="mb-4">
                    From tracking your spending to crushing your goals, Bright Finance empowers you with the tools and insights you need to confidently manage your money — one decision at a time.
                </p>
                <a class="btn btn-primary btn-lg" href="{{ route('register') }}">
                    Find Your Companion – Sign Up
                </a>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    @php
                        $features = [
                            ['icon' => 'globe-2', 'title' => 'Expense Tracking', 'desc' => 'Categorize and monitor where your money goes in real-time.'],
                            ['icon' => 'target', 'title' => 'Budgeting Tools', 'desc' => 'Set limits and stay within them with simple, visual budgets.'],
                            ['icon' => 'flag', 'title' => 'Goal Setting', 'desc' => 'Track savings goals and measure your progress along the way.'],
                            ['icon' => 'setting', 'title' => 'Financial Analysis', 'desc' => 'Understand your cash flow, net worth, and financial health.'],
                            ['icon' => 'user-2', 'title' => 'Personalized Insights', 'desc' => 'Get tailored tips and reports based on your activity.'],
                            ['icon' => 'alert', 'title' => 'Bill Reminders', 'desc' => 'Never miss a due date — we’ll keep you in check.'],
                        ];
                    @endphp

                    @foreach($features as $feature)
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-start bg-white shadow-sm rounded-3 p-3 h-100">
                                <div class="me-3">
                                    <span class="mbr-iconfont mobi-mbri-{{ $feature['icon'] }} mobi-mbri fs-2 text-primary"></span>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $feature['title'] }}</h5>
                                    <p class="mb-0 small">{{ $feature['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
