@extends('layouts.Nav')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card z-index-0 fadeIn3 shadow-dark fadeInBottom">
                <div
                    class="card-header p-0 text-uppercase position-relative mt-n4 mx-3 z-index-2"
                >
                    <div
                        class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1"
                    >
                        <h4
                            class="text-white font-weight-bolder text-center mt-2 mb-0"

                        >
                        @if($action=="Yes")
                        {{ __('Update Goal Balance') }}
                        @else
                        {{ __('New Transaction') }}
                        @endif
                        </h4>
                    </div>
                    @if (session('success'))
        <div class="alert alert-success text-center text-white col-12" role="alert">
            {{ session('success') }}
        </div>
    @endif
                </div>

                <div class="card-body">
                    <form method="POST"  action="{{ route('holding.store') }}">
                        @csrf



                                                <div class="input-group input-group-outline my-3">
                            <label for="Action" class="col-md-4  col-form-label text-md-right">{{ __('Cash Payment \ Income') }}</label>
                            <div class="col-md-6">
                                <select name="Action" class="form-control" required >
                                <option  value="">-- Select Option --</option>
                                 
                                    @if($action=="Yes")
                                    <option value="Paid">Cash payments</option>
                        @else
                        <option value="Paid">Cash payments</option>
                               
                               <option value="Received">Cash Income</option>
                        @endif
                                    
                                </select>
                                @error('Action')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="input-group input-group-outline my-3">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Cash Flow For:') }}</label>
                            <div class="col-md-6">
                                <select name="category" class="form-control" required>
                                    <option  value="">-- Select Option  --</option>
                                    @foreach($category as $category)
                                    
                                        <option value="{{ $category->id }}">{{ $category->Nature }} -- {{ $category->category }}</option>
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

                                <label for="description"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <input id="description" type="text"
                                        class="form-control @error('description') is-invalid @enderror" name="description"
                                        value="{{ old('description') }}" required placeholder="Short Description" autocomplete="description">

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group input-group-outline my-3">

                                <label for="Method" class="col-md-4 col-form-label text-md-right">{{ __('Method Affect') }}</label>

                                <div class="col-md-6">
                                

                                    <select name="Method"  class="form-control" required>
                            
                                        
                                       <option value="Cash" >Cash</option>
                                       @foreach($cards as $method)
                                          @if($method->Type=="Debit Cards")
                                             <option value="{{$method->Type}}" >Debit Card No. {{$method->id}}</option>
                                            @else
                                             <option value="{{$method->Type}}" >{{$method->Type}} No. {{$method->id}}</option>
                                            @endif
                                        @endforeach
                                
                                    </select>
    


                                    @error('Method')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                          </div>

                          <div class="input-group input-group-outline my-3">

                                <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount  R') }}</label>

                                <div class="col-md-6">
                                    <input id="amount" type="number" step="0.01" placeholder="0.00"
                                        class="form-control @error('amount') is-invalid @enderror" name="amount"
                                        value="{{ old('amount') }}" required autocomplete="amount">

                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group input-group-outline my-3">

                                <label for="bill_date"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Action Date') }}</label>

                                <div class="col-md-6">
                                    <input id="bill_date" type="date"
                                        class="form-control @error('bill_date') is-invalid @enderror" name="bill_date"
                                        value="{{ old('bill_date') }}" required autocomplete="bill_date">

                                    @error('bill_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="input-group input-group-outline my-3">

                                <label for="status"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Invoice slip') }}</label>

                                <div class="col-md-6">
                                    <input id="Invoice_slip" type="file"
                                        class="form-control @error('Invoice_slip') is-invalid @enderror" name="Invoice_slip"
                                        value="{{ old('Invoice_slip') }}"  autocomplete="status">

                                    @error('Invoice_slip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <small  class="text-dark" >   <button type="submit" class="btn btn-danger  mb-0 text-dark">Put on Hold</button> &nbsp;&nbsp; </small>

                      

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection