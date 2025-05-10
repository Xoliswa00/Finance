@extends('layouts.Nav')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Nature') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('natures.update', $nature->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="Classification" class="col-md-4 col-form-label text-md-right">{{ __('Classification') }}</label>

                                <div class="col-md-6">
                                    <input id="Classification" type="text" class="form-control @error('Classification') is-invalid @enderror" name="Classification" value="{{ old('Classification', $nature->Classification) }}" required autocomplete="Classification" autofocus>

                                    @error('Classification')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Nature" class="col-md-4 col-form-label text-md-right">{{ __('Nature') }}</label>

                                <div class="col-md-6">
                                    <input id="Nature" type="text" class="form-control @error('Nature') is-invalid @enderror" name="Nature" value="{{ old('Nature', $nature->Nature) }}" required autocomplete="Nature">

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
                                        {{ __('Update Nature') }}
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
