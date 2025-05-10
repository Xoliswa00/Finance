@extends('layouts.Nav')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-cente">
        <div class="col-4">
            <div class="card">
                <div class="card-header">{{ __('Create Budget Subitem') }}</div>

                <div class="card-body">
                    <form action="{{ route('budget_subitems.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="budget_id">Budget</label>
                            <select name="budget_id" id="budget_id" class="form-control">
                                <option value="">-- Select Budget --</option>
                                @foreach($budgets as $budget)
                                <option value="{{ $budget->id }}">{{ $budget->Category }}</option>
                                @endforeach
                            </select>

                            @error('budget_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" name="category" id="category" class="form-control" value="{{ old('category') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" step="0.01">
                        </div>

                        <div class="form-group">
                            <label for="limit">Limit</label>
                            <input type="number" name="limit" id="limit" class="form-control" value="{{ old('limit') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="recurring">Recurring</label>
                            <select name="recurring" id="recurring" class="form-control">
                                <option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Yearly">Yearly</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="High">High</option>
                                <option value="Moderate">Moderate</option>
                                <option value="Normal">Normal</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" name="status" id="status" class="form-control" value="{{ old('status') }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Budget Subitem</button>
                    </form>
                </div>
            </div>
     
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">{{ __('Create Budget Subitem') }}</div>

                <div class="card-body">
                    <form action="{{ route('budget_subitems.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="budget_id">Budget</label>
                            <select name="budget_id" id="budget_id" class="form-control">
                                <option value="">-- Select Budget --</option>
                                @foreach($budgets as $budget)
                                <option value="{{ $budget->id }}">{{ $budget->Category }}</option>
                                @endforeach
                            </select>

                            @error('budget_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" name="category" id="category" class="form-control" value="{{ old('category') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" step="0.01">
                        </div>

                        <div class="form-group">
                            <label for="limit">Limit</label>
                            <input type="number" name="limit" id="limit" class="form-control" value="{{ old('limit') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="recurring">Recurring</label>
                            <select name="recurring" id="recurring" class="form-control">
                                <option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Yearly">Yearly</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="High">High</option>
                                <option value="Moderate">Moderate</option>
                                <option value="Normal">Normal</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" name="status" id="status" class="form-control" value="{{ old('status') }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Budget Subitem</button>
                    </form>
                </div>
            </div>
     
        </div>
    </div>
    
</div>
@endsection
