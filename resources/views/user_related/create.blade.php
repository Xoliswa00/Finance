@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create User Related Record') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user_related.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Relation" class="col-md-4 col-form-label text-md-right">{{ __('Relation') }}</label>

                            <div class="col-md-6">
                                <input id="Relation" type="text" class="form-control @error('Relation') is-invalid @enderror" name="Relation" value="{{ old('Relation') }}" required autocomplete="Relation">

                                @error('Relation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_user" class="col-md-4 col-form-label text-md-right">{{ __('User ID') }}</label>

                            <div class="col-md-6">
                                <input id="id_user" type="number" class="form-control @error('id_user') is-invalid @enderror" name="id_user" value="{{ old('id_user') }}" required autocomplete="id_user">

                                @error('id_user')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Added_by" class="col-md-4 col-form-label text-md-right">{{ __('Added By') }}</label>

                            <div class="col-md-6">
                                <input id="Added_by" type="number" class="form-control @error('Added_by') is-invalid @enderror" name="Added_by" value="{{ old('Added_by') }}" required autocomplete="Added_by">

                                @error('Added_by')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create User Related Record') }}
                                </button>
                                <a href="{{ route('user_related.index') }}" class="btn btn-secondary">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
