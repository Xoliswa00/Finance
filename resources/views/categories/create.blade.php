@extends('layouts.Nav')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card card-default">
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
                        <form class="form-horizontal" method="POST" action="{{ route('categories.store') }}">
                                @csrf

                            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}  input-group input-group-outline my-3">
                                <label for="category" class="col-md-4 control-label">Category</label>

                                <div class="col-md-6">
                                    <input id="category" type="text" class="form-control" name="category" value="{{ old('category') }}" required autofocus>

                                    @if ($errors->has('category'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('Nature') ? ' has-error' : '' }}  input-group input-group-outline my-3">
                                <label for="Nature" class="col-md-4 control-label">Nature</label>

                                <div class="col-md-6">
                                    <select id="Nature" class="form-control" name="Nature" required>
                                        <option value="">Select a nature</option>
                                        @foreach($natures as $nature)
                                            <option value="{{ $nature->Nature }}" >{{ $nature->Nature }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('Nature'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('Nature') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Create Category
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
