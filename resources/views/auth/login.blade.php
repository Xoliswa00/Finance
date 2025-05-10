@extends('layouts.app') @section('content')
<div class="container my-auto">
    <div class="row">
        <div class="col-lg-6 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 shadow-dark fadeInBottom">
                <div
                    class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
                >
                    <div
                        class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1"
                    >
                        <h4
                            class="text-white font-weight-bolder text-center mt-2 mb-0"
                        >
                            Sign in
                        </h4>
                    </div>
                </div>

                <div class="card-body text-md">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Email</label>
                            <input
                                id="email"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus
                            />
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Password</label>
                            <input
                                id="password"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                required
                                autocomplete="current-password"
                            />

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div
                            class="form-check form-switch d-flex align-items-center mb-3"
                        >
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="rememberMe"
                                checked
                            />
                            <label
                                class="form-check-label mb-0 ms-3"
                                for="rememberMe"
                                >Remember me</label
                            >
                        </div>

                        <div class="text-center">
                            <button
                                type="submit"
                                class="btn bg-gradient-info w-100 my-4 mb-2"
                            >
                                Sign in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
