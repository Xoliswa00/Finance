@extends('layouts.Nav')
@section('content')

<div class="card mb-3 ">
                        <div class="card-header" id="headingMasterX">
                            <div
                        class="bg-gradient-primary shadow-info border-radius-lg py-3 pe-1"
                    >
                        <h4
                            class="text-white font-weight-bolder text-center mt-2 mb-0"
                        >
                           Master' Section
                        </h4>
                    </div>
                        </div>
        
                        <div id="collapseMasterX" class=" collapse  navbar-collapse show" aria-labelledby="headingMasterX" data-parent="#accordion">
                            <div class="card-body">
                                <form action="{{ route('masterx.store') }}" method="POST">
                                    @csrf


                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Name" class="col-md-4 col-form-label text-md-end">{{ __(' Goal Name') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="Name" type="text"  rows="3" class="form-control @error('Name') is-invalid @enderror" name="Name" value="{{ old('Name') }}" required autocomplete="name" autofocus>
            
                                            @error('Name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group row input-group-outline my-3">
                                        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __(' Description') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus>
            
                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>



                                  

                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Budget" class="col-md-4 col-form-label text-md-end">{{ __('Budget Amount') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="Budget" type="number" class="form-control @error('Budget') is-invalid @enderror" name="Budget" value="{{ old('Budget') }}" required autocomplete="Budget" autofocus>
            
                                            @error('Budget')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Start_date" class="col-md-4 col-form-label text-md-end">{{ __('Start Date') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="Start_date" type="date" class="form-control @error('Start_date') is-invalid @enderror" name="Start_date" value="{{ old('Start_date') }}" required autocomplete="Start_date" autofocus>
            
                                            @error('Start_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="input-group row input-group-outline my-3">
                                        <label for="end_date" class="col-md-4 col-form-label text-md-end">{{ __('End Date') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" required autocomplete="end_date" autofocus>
            
                                            @error('end_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>




                                   
                                    <div class="input-group row input-group-outline my-3">
                                        <label for="progress" class="col-md-4 col-form-label text-md-end">{{ __('Progress Status') }}</label>
            
                                        <div class="col-md-6">
                                            <select  id="progress" class="form-control @error('progress') is-invalid @enderror" name="progress" required autocomplete="progress" autofocus >
                                                <option value="0">0 % completed</option>
                                                <option value="10">10 % completed</option>
                                                <option value="25">25 % completed</option>
                                                <option value="45">45 % completed</option>
                                                <option value="50">50 % completed</option>
                                                <option value="75">75 % completed</option>
                                                <option value="85">85 % completed</option>
                                                <option value="95">95 % completed</option>
                                                <option value="100">100 % completed</option>


                                            </select>



                                            @error('progress')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>


                                   
                        
                                    <button class="btn btn-primary " type="submit">Create Section</button>
                                </form>
                            </div>
                        </div>
                    </div>


@endsection