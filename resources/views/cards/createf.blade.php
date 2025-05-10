@extends('layouts.Nav')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div
                    class="card-header p-0 text-uppercase position-relative mt-n4 mx-3 z-index-2"
                >
                    <div
                        class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1"
                    >
                        <h4
                            class="text-white font-weight-bolder text-center mt-2 mb-0"
                        >
                        {{ __('Add New Card') }}
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('cards.store') }}">
                        @csrf

                       <div class="form-group row input-group input-group-outline my-3">
                            <label for="Type"
                                class="col-md-4 col-form-label text-md-right">{{ __('Card Type') }}</label>

                            <div class="col-md-6">
                                <input id="Type" type="text" class="form-control @error('Type')  is-invalid @enderror"
                                    name="Type" value="{{ old('Type') }}" required autocomplete="Type"  placeholder="Debit Card or Credit Card" autofocus>

                                @error('Type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                       <div class="form-group row input-group input-group-outline my-3">
                            <label for="CardNumber"
                                class="col-md-4 col-form-label text-md-right">{{ __('Card Number') }}</label>

                            <div class="col-md-6">
                                <input id="CardNumber" type="number" 
                                    class="form-control @error('CardNumber') is-invalid @enderror" length="16" name="CardNumber"
                                    value="{{ old('CardNumber') }}" required autocomplete="CardNumber">

                                @error('CardNumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                       <div class="form-group row input-group input-group-outline my-3">
                            <label for="ExpiryDate"
                                class="col-md-4 col-form-label text-md-right">{{ __('Expiry Date') }}</label>

                            <div class="col-md-6">
                                <input id="ExpiryDate" type="text"
                                    class="form-control @error('ExpiryDate') is-invalid @enderror" pattern="/^((0[1-9])|([0-2]))[/]*((0[8-9])|(1[1-19]))$/" name="ExpiryDate"
                                    value="{{ old('ExpiryDate') }}" required autocomplete="ExpiryDate">

                                @error('ExpiryDate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                       <div class="form-group row input-group input-group-outline my-3">
                            <label for="CVC" class="col-md-4 col-form-label text-md-right">{{ __('CVC') }}</label>

                            <div class="col-md-6">
                                <input id="CVC" type="text" class="form-control @error('CVC') is-invalid @enderror"
                                    name="CVC" value="{{ old('CVC') }}" required autocomplete="CVC">

                                @error('CVC')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                       <div class="form-group row input-group input-group-outline my-3">
                            <label for="Cardholder"
                                class="col-md-4 col-form-label text-md-right">{{ __('Cardholder') }}</label>

                            <div class="col-md-6">
                                <input id="Cardholder" type="text"
                                    class="form-control @error('Cardholder') is-invalid @enderror" name="Cardholder"
                                    value="{{ old('Cardholder') }}" required autocomplete="Cardholder">

                                @error('Cardholder')

                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                       <div class="form-group row input-group input-group-outline my-3">
                            <label for="Cardholder"
                                class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                            <div class="col-md-6">
                                <input id="Status" type="text"
                                    class="form-control @error('Status') is-invalid @enderror" name="Status"
                                    value="Active"  required autocomplete="Cardholder">

                                @error('Status')

                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary justify-content-center btn-lg">Add Card</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection