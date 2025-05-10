@extends('layouts.Nav')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Financial Goal') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('goals.update', $goal->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">{{ __('Title') }}</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $goal->title) }}" required autofocus>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description', $goal->description) }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="goal_category">{{ __('Goal Category') }}</label>
                            <select id="goal_category" class="form-control @error('goal_category') is-invalid @enderror" name="goal_category" required>
                                <option value="Saving"{{ old('goal_category', $goal->goal_category) == 'Saving' ? ' selected' : '' }}>Saving</option>
                                <option value="Repayment"{{ old('goal_category', $goal->goal_category) == 'Repayment' ? ' selected' : '' }}>Repayment</option>
                                <option value="Investing"{{ old('goal_category', $goal->goal_category) == 'Investing' ? ' selected' : '' }}>Investing</option>
                            </select>

                            @error('goal_category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="target_amount">{{ __('Target Amount') }}</label>
                            <input id="target_amount" type="number" step="0.01" class="form-control @error('target_amount') is-invalid @enderror" name="target_amount" value="{{ old('target_amount', $goal->target_amount) }}" required>

                            @error('target_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="start_date">{{ __('Start Date') }}</label>
                            <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', $goal->start_date) }}" required>

                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="end_date">{{ __('End Date') }}</label>
                            <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', $goal->end_date) }}" required>

                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Update Goal') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
