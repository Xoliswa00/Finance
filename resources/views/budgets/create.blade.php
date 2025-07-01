@extends('layouts.Nav')

@section('content')
<div class="container my-auto">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
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
                            Create Budget Item
                        </h4>
                        
                    </div>
                    <br>
                                             <a title="Create New Category\ Action Item" class="btn btn-secondary  bg-gradient-dark mb-0" href="{{route('categories.create')}}"><i class="material-icons text-sm">add</i> Create New Category</a>

                </div>

                <div class="card-body">
                    <form action="{{ route('budgets.store') }}" class="form" method="POST">
                        @csrf

                        <div class="input-group input-group-outline ">
                            <label for="category" class="col-4 col-form-label text-md-right">{{(' What are you budgeting For ') }}</label>

                            <div class="col-6">
                                <select name="category" class="form-control" required>
                                    <option value="">-- Select Action Item --</option>
                                    @foreach($category as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }} - {{$category->Nature}}</option>
                                    @endforeach
                                </select>

                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                       
                          <div class="input-group input-group-outline my-3">
                                <label for="Action" class="col-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-6">
                                
                                <input type="text" name="description" id="description" class="form-control input" value="{{ old('description') }}" required>

    


                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                          </div>
                          <div class="input-group input-group-outline my-3">
                                <label  for="amount" class="col-4 col-form-label text-md-right">{{ __('Budget Amount') }}</label>

                                <div class="col-6">
                                
                                <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}">

    


                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                          </div>
                          <div class="input-group input-group-outline my-3">
                                <label  for="amount" class="col-4 col-form-label text-md-right">{{ __('Actual Amount') }}</label>

                                <div class="col-6">
                                
                                <input type="number" name="limit" id="limit" class="form-control" value="{{ old('limit') }}" required>

    


                                    @error('limit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                          </div>



                          <div class="form-group  input-group input-group-outline my-3">
                          <label for="due_date" class="col-4 col-form-label text-md-right">Due Date</label>
                            <div class="col-6">
                             
                                <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}" required>
                            </div>

                            
                        </div>



                       

                        <div class="form-group input-group input-group-outline my-3">
                        <label for="recurring" class="col-4 col-form-label text-md-right">Recurring</label>

                            <div class="col-6">
                                <select name="recurring" id="recurring" class="form-control" required>
                                    <option value="Once-off" {{ old('recurring') === 'Once-off' ? 'selected' : '' }}>Once-off</option>
                                    <option value="Weekly" {{ old('recurring') === 'Weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="Monthly" {{ old('recurring') === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Yearly" {{ old('recurring') === 'Yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group  input-group input-group-outline my-3">
                        <label for="priority" class="col-4 col-form-label text-md-right">Priority</label>

                            <div class="col-md-6">
                              
                                <select name="priority" id="priority" class="form-control">
                                    <option value="High" {{ old('priority') === 'High' ? 'selected' : '' }}>High</option>
                                    <option value="Moderate" {{ old('priority') === 'Moderate' ? 'selected' : '' }}>Moderate</option>
                                    <option value="Normal" {{ old('priority') === 'Normal' ? 'selected' : '' }}>Normal</option>
                                </select>
                            </div>
                        </div>

                       
                       

                        <button type="submit" class="btn btn-secondary">Create Budget Item</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
