@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div
                    class="card-header p-0 text-uppercase position-relative mt-n4 mx-3 z-index-2"
                >
                    <div
                        class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1"
                    >
                        <h4
                            class="text-white font-weight-bolder text-center mt-2 mb-0"
                        >
                        {{ __('Sign Up ') }}
                        </h4>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                     <div class="input-group row input-group-outline my-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __(' First Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                     <div class="input-group row input-group-outline my-3">
                            <label for="Surname" class="col-md-4 col-form-label text-md-end">{{ __('Surname') }}</label>

                            <div class="col-md-6">
                                <input id="Surname" type="text" class="form-control @error('Surname') is-invalid @enderror" name="Surname" value="{{ old('Surname') }}" required autocomplete="name" autofocus>

                                @error('Surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                     <div class="input-group row input-group-outline my-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="input-group row input-group-outline my-3">
                            <label for="Location" class="col-md-4 col-form-label text-md-end">{{ __('City,Country') }}</label>

                            <div class="col-md-6">
                                <input id="Location" type="text" class="form-control @error('Location') is-invalid @enderror" name="Location" value="{{ old('Location') }}" required autocomplete="Location">

                                @error('Location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="input-group row input-group-outline my-3">
                            <label for="Mobile" class="col-md-4 col-form-label text-md-end">{{ __('Mobile') }}</label>

                            <div class="col-md-6">
                                <input id="Mobile" type="tel" class="form-control @error('Mobile') is-invalid @enderror" size="10" pattern="[0-9]{10}" name="Mobile" value="{{ old('Mobile') }}" required autocomplete="Mobile">

                                @error('Mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                     <div class="input-group row input-group-outline my-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                     <div class="input-group row input-group-outline my-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-secondary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
