@extends('layouts.Nav')
@section('content')
<div class="container">
<div class="card mb-3 ">
                        <div class="card-header" id="headingMasterX">
                            <div
                        class="bg-gradient-danger shadow-primary border-radius-lg py-3 pe-1"
                    >
                        <h4
                            class="text-white font-weight-ber text-center mt-2 mb-0"
                        >
                           Master' Section
                        </h4>
                    </div>
                        </div>
        
                        <div id="collapseMasterX" class=" collapse  navbar-collapse show" aria-labelledby="headingMasterX" data-parent="#accordion">
                      
                            <div class="card-body">
                                <form action="/UpdateItems" id="section" name="master" value="{{$section->Master}}" method="post">
                                    @csrf

<input name="master" hidden value="{{$section->Master}}" >
                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Sections" class="col-md-4 col-form-label text-md-end">{{ __(' Section Name') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="Section" type="text" class="form-control @error('Section') is-invalid @enderror" readonly name="Section" value="{{ $section->Section }}" required autocomplete="section" autofocus>

                                           
            
                                            @error('Section')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Description" class="col-md-4 col-form-label text-md-end">{{ __(' Description') }}</label>
            
                                        <div class="col-md-6">
                                            <textarea id="Description" type="text"  class="form-control @error('description') is-invalid @enderror" name="Description" value="{{$section->Description}}" required autocomplete="Description" autofocus>{{$section->Description}} </textarea>
                                          
            
                                            @error('Description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>



                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Nature" class="col-md-4 col-form-label text-md-end">{{ __('Nature ') }}</label>
            
                                        <div class="col-md-6">
                                            <select  id="Nature" class="form-control @error('Nature') is-invalid @enderror" name="Nature" required autocomplete="Nature" autofocus >
                                                <option value="{{ $section->Nature }}">{{$section->Nature}}</option>
                                               
                                            </select>



                                            @error('Nature')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>

                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Budget" class="col-md-4 col-form-label text-md-end">{{ __('Budget Amount') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="Budget" type="number" class="form-control @error('Budget') is-invalid @enderror" name="Budget" value="{{ $section->Budget }}" required autocomplete="budget" autofocus>
            
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
                                            <input id="Start_date" type="date" class="form-control @error('Start_date') is-invalid @enderror" name="Start_date" value="{{ $section->Start_date }}" required autocomplete="Start_date" autofocus>
            
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
                                            <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ $section->end_date }}" required autocomplete="end_date" autofocus>
            
                                            @error('end_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>




                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Status" class="col-md-4 col-form-label text-md-end">{{ __('Section Status') }}</label>
            
                                        <div class="col-md-6">
                                            <select  id="Status" class="form-control @error('Status') is-invalid @enderror" name="Status" required autocomplete="Status" autofocus >
                                                <option value="Not Started">Not Started</option>
                                                <option value="Delayed">Delayed</option>
                                                <option value="In-Progress">In-Progress</option>
                                                <option value="Completed">Completed</option>
                                            </select>



                                            @error('Status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Progress" class="col-md-4 col-form-label text-md-end">{{ __('Progress Status') }}</label>
            
                                        <div class="col-md-6">
                                            <select  id="Progress" class="form-control @error('Progress') is-invalid @enderror" name="Progress" required autocomplete="Progress" autofocus >
                                                <option value="5">5 % completed</option>
                                                <option value="10">10 % completed</option>
                                                <option value="25">25 % completed</option>
                                                <option value="45">45 % completed</option>
                                                <option value="50">50 % completed</option>
                                                <option value="75">75 % completed</option>
                                                <option value="85">85 % completed</option>
                                                <option value="95">95 % completed</option>
                                                <option value="100">100 % completed</option>


                                            </select>



                                            @error('Progress')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>


                                   
                                    
                        
                                    <button class="btn btn-primary " name="id" value="{{$section->id}}" type="submit">Update Section{{$section->id}}</button>
                                </form>
                            </div>
                   
                        </div>
                    </div>





</div>
@endsection
