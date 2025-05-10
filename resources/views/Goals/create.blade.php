@extends('layouts.Nav')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-8  col-sm-12 col-sm-12">
            <div class="card z-index-0 fadeIn3 shadow-dark fadeInBottom">
                <div class="card-header p-0 text-uppercase position-relative mt-n4 mx-3 z-index-2">
                <div
                        class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1"
                    >
                        <h4
                            class="text-white font-weight-bolder text-center mt-2 mb-0"

                        >
                     
                        {{ __('New Financial Goal') }}
                        
                        </h4>
                    </div>
            
            
            </div>

                <div class="card-body">
                    <form  action="{{ route('goals.save') }}"  method="post">
                        @csrf

                        <div class="input-group input-group-outline my-3   ">
                            <label for="title" class=" col-4 col-form-label text-md-right ">{{ __('Title') }}</label>
                            <input id="title" type="text" class="form-control  @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group input-group-outline my-3 ">
                            <label for="description" class=" col-4 col-form-label text-md-right ">{{ __('Description') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description') }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group input-group-outline my-3 ">
                            <label for="goal_category" class=" col-4 col-form-label text-md-right ">{{ __('Goal Category') }}</label>
                            <select id="goal_category" class="form-control @error('goal_category') is-invalid @enderror" name="goal_category" required>
                                <option class="bg-gradient-info " value="Saving"{{ old('goal_category') == 'Saving' ? ' selected' : '' }}>Saving</option>
                                <option value="Repayment"{{ old('goal_category') == 'Repayment' ? ' selected' : '' }}>Repayment</option>
                                <option value="Investing"{{ old('goal_category') == 'Investing' ? ' selected' : '' }}>Investing</option>
                            </select>

                            @error('goal_category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group input-group-outline my-3 ">
                            <label for="target_amount" class=" col-4 col-form-label text-md-right "> {{ __('Target Amount') }}</label>
                            <input id="target_amount" type="number" step="0.01" class="form-control @error('target_amount') is-invalid @enderror" name="target_amount" value="{{ old('target_amount') }}" required>

                            @error('target_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group input-group-outline my-3 ">
                            <label for="start_date " class=" col-4 col-form-label text-md-right ">{{ __('Start Date') }}</label>
                            <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}" required>

                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group input-group-outline my-3 ">
                            <label for="end_date"   class=" col-4 col-form-label text-md-right ">{{ __('End Date') }}</label>
                            <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" required>

                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Create Goal') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
