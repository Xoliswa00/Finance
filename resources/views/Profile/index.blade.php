<!-- profile/index.blade.php -->
@extends('layouts.Nav')

@section('content')
<div class="container-fluid px-2 text-dark px-md-4">
    <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
      <span class="mask  bg-gradient-primary  opacity-6"></span>
    </div>
    <div class="card card-body mx-3 mx-md-4 mt-n6">
      <div class="row gx-4 mb-2">
        <div class="col-auto">
          <div class="avatar avatar-xl position-relative">
            <img src="assets/images/1.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
          </div>
        </div>
        <div class="col-auto my-auto">
          <div class="h-100">
            <h5 class="mb-1">
              {{Auth()->user()->name}},{{Auth()->user()->Surname}}
            </h5>
            <p class="mb-0 font-weight-normal text-sm">
                Cold Pricing Plan
            </p>
          </div>
        </div>
        
      </div>
      <div class="row">
        <div class="row">
          
          <div class="col-12 col-xl-4">
            <div class="card card-plain h-100">
              <div class="card-header pb-0 p-3">
                <div class="row">
                  <div class="col-md-8 d-flex align-items-center">
                    <h6 class="mb-0">Profile Information</h6>
                  </div>
                  <div class="col-md-4 text-end">
                    <a href="javascript:;">
                      <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-body p-3">
                <p class="text-sm">
                  Decisions: If you can’t decide, the answer is no. If two equally difficult paths, choose the one more painful in the short term (pain avoidance is creating an illusion of equality).
                </p>
                <hr class="horizontal gray-light my-4">
                <ul class="list-group">
                  <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Full Name:</strong> &nbsp; {{Auth()->user()->name}} {{Auth()->user()->Surname}}</li>
                  <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Mobile:</strong> &nbsp; (44) 123 1234 123</li>
                  <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp;    {{Auth()->user()->email}}</li>
                  <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Location:</strong> &nbsp; South Africa</li>
                  <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Join Date:</strong> &nbsp;  {{Auth()->user()->created_at}}</li>

                </ul>
              </div>
            </div>
          </div>
          <div class="col-12 col-xl-8">
            <div class="card card-plain h-100">
              <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Balances Details</h6>
              </div>
              <div class="">
                <div class="row">
                  <div class="col-6 ">
                    <div class="card">
                      <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                          <i class="material-icons opacity-10">account_balance</i>
                        </div>
                      </div>
                      <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Bank Balance</h6>
                        <span class="text-xs text-dark">Current balance</span>
                        <hr class="horizontal dark my-3">
                        <h5 class="mb-0">
                          @foreach($balance as $balance)
                            <?php
                                $num = $balance->Balance;
                                $n = number_format($num, 2, '.', ',');
                                echo 'ZAR ' . $n;
                            ?>
                            @endforeach
                        </h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 ">
                    <div class="card">
                      <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                          <i class="material-icons opacity-10">account_balance_wallet</i>
                        </div>
                      </div>
                      <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Credit Card Balance</h6>
                        <span class="text-xs text-dark">Current Available</span>
                        <hr class="horizontal dark my-3">
                        <h5 class="mb-0">  
                        @foreach($CreditB as $CreditB)
                            <?php
                                $num = $CreditB->Balance;
                                $n = number_format($num, 2, '.', ',');
                                echo 'ZAR ' . $n;
                            ?>
                            @endforeach
                        
                      </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class=" mb-lg-0 mb-4">
                <div class="card mt-4">
                  <div class="card-header pb-0 p-3">
                    <div class="row">
                      <div class="col-6 d-flex align-items-center">
                        <h6 class="mb-0">Cards Method</h6>
                      </div>
                      <div class="col-6 text-end">
                        <a class="btn bg-gradient-dark mb-0" href="{{route('cards.create')}}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New Card</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body p-3">
                    <div class="row">
                        @foreach($cards as $cards)
                      <div class="col-md-6 mb-md-0 mb-4">
                       
                        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                            
                          <img class="w-10 me-3 mb-0" src="../assets/img/logos/mastercard.png" alt="logo">
                          <h6 class="mb-0"> <?php
                            $cardNumbers = $cards->CardNumber;
                            $n = substr($cardNumbers, 0, 4) . " **** **** " . substr($cardNumbers, 12, 16);
                            echo $n;
                            ?></h6>
                          <i class="material-icons ms-auto text-dark cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Card">edit</i>
                          <i class="material-icons ms-auto text-dark cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Card">delete</i>

                        </div>
                      </div>
                      @endforeach
                    
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>


@endsection
