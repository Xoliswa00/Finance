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
                        {{ __('Create New Category') }}
                        </h4>
                    </div>
                </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('natures.store') }}">
                            @csrf

                           <div class="form-group row input-group input-group-outline my-3">
                                <label for="Classification" class="col-md-4 col-form-label text-md-right">{{ __('Classification') }}</label>

                                <div class="col-md-6">
                                    <input id="Classification" type="text" class="form-control @error('Classification') is-invalid @enderror" name="Classification" value="{{ old('Classification') }}" required autocomplete="Classification" autofocus>

                                    @error('Classification')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                           <div class="form-group row input-group input-group-outline my-3">
                                <label for="Nature" class="col-md-4 col-form-label text-md-right">{{ __('Nature') }}</label>

                                <div class="col-md-6">
                                    <input id="Nature" type="text" class="form-control @error('Nature') is-invalid @enderror" name="Nature" value="{{ old('Nature') }}" required autocomplete="Nature">

                                    @error('Nature')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>
                                    <a href="{{ route('natures.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
