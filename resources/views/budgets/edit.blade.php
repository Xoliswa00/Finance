@extends('layouts.Nav')

@section('content')
<div class="container my-auto">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-12 mx-auto">
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
                           Update Budget Item
                        </h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('budgets.update') }}" class="form" method="POST">
                        @csrf
                

                       
                       
                          <div class="input-group input-group-outline my-3">
                                <label for="Action" class="col-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-6">
                                
                                <input type="text" name="description" id="description" readonly class="form-control input" value="{{ $budget->Description }}" required>

    


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
                                
                                <input type="number" name="amount" id="amount" class="form-control" value="{{ $budget->Amount }}">

    


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
                                
                                <input type="number" name="limit" id="limit" class="form-control" value="{{ $budget->Limit }}" required>

    


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
                             
                                <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $budget->due_date }}" required>
                            </div>

                            
                        </div>



                       

                        <div class="form-group input-group input-group-outline my-3">
                        <label for="recurring" class="col-4 col-form-label text-md-right">Recurring</label>

                            <div class="col-6">
                                <select name="recurring" in id="recurring" class="form-control" required>
                                    <option value="Once-off" {{ old('recurring') === 'Once-off' ? 'selected' : '' }}>Once-off</option>
                                    <option value="Weekly" {{ old('recurring') === 'Weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="Monthly" {{ old('recurring') === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Yearly" {{ old('recurring') === 'Yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </div>
                        </div>
                       
                        <input type="number" name="id" hidden id="id" invisible class="form-control input"  value="{{ $budget->id}}" required>

                   

                       
                       

                        <button type="submit" class="btn btn-secondary">Update Budget Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
