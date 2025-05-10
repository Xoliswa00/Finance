@extends('layouts.Nav')

@section('content')


    <div style="background-color: rgb(75, 82, 82);" class="container-fluid shadow-xl shadow-dark py-6">
        <div class="row">
          <div class="col-sm-6">
            <div class="row">
            
              <div class="col-sm-12 col-lg-6 col-md-12 mb-0 mb-4">
             
               
                    <div class="card bg-transparent shadow-xl">
                    <div class="overflow-hidden position-relative border-radius-xl">
                        <img src="../assets/img/illustrations/pattern-tree.svg" class="position-absolute opacity-2 start-0 top-0 w-100 z-index-1 h-100" alt="pattern-tree">
                        <span class="mask bg-gradient-dark opacity-10"></span>
                        <div class="card-body position-relative z-index-1 p-3">
                        <i class="material-icons text-white p-2">wifi</i>
                        <h2 class="text-white mt-4 mb-5 pb-2"> <?php
                            $cardNumbers = $main->CardNumber;
                            $n = substr($cardNumbers, 0, 4) . "   ****   ****   " . substr($cardNumbers, 12, 16);
                            echo $n;
                            ?></h2>
                        <div class="d-flex">
                            <div class="d-flex">
                            <div class="me-4">
                                <p class="text-white text-sm opacity-8 mb-0">Card Holder</p>
                                <h6 class="text-white mb-0">{{$main->Cardholder}}</h6>
                            </div>
                            <div>
                                <p class="text-white text-sm opacity-8 mb-0">Expires</p>
                                <h6 class="text-white mb-0">{{$main->ExpiryDate}}</h6>
                            </div>
                            </div>
                            <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                            <img class="w-60 mt-2" src="../assets/img/logos/mastercard.png" alt="logo">
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                 

              </div>
              <div class=" container-fluid col-sm-12 col-md-12 col-lg-6 ">
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
              <div class="col-md-12  mb-lg-0 mb-4">
                <div class="card mt-4">
                  <div class="card-header pb-0 p-3">
                
              
                        <h6 class="mb-0">Cards Method</h6>
                        <a class="btn bg-gradient-dark mb-0 " href="{{route('cards.create')}}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New Card</a>
            
                     
             
                  </div>
                  <div class="card-body p-3">
                    <div class="row">
                        @foreach($cards as $cards)
                      <div class="col-md-12 col-lg-6 mb-md-0 mb-4">
                       
                        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                            
                          <img class="w-10 me-3 mb-0" src="../assets/img/logos/mastercard.png" alt="logo">
                          <h6 class="mb-0"> <?php
                            $cardNumbers = $cards->CardNumber;
                            $n = substr($cardNumbers, 0, 4) . " **** **** " . substr($cardNumbers, 12, 16);
                            echo $n;
                            ?></h6>
                          <i class="material-icons ms-auto text-dark cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Card">edit</i>
                        </div>
                      </div>
                      @endforeach
                    
                    </div>
                  </div>
                </div>
                <div class="card mt-4">
                  <div class="card-header pb-0 p-3">
                
              
                        <h6 class="mb-0">Quick Links</h6>
            
                     
             
                  </div>
                  <div class="card-body p-3">
                    <div class="row">
                       
                      <div class="col-md-12 col-lg-6 mb-md-0 mb-4">
               
                   <small  class="text-dark text-sm " > <a class="btn bg-gradient-success btn-sm" aria-disabled="true" href="#"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Money Transfer</a> &nbsp;&nbsp; </small>
                    <small  class="text-dark" > <a class="btn bg-gradient-dark btn-sm" href="{{route('transactions.create')}}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;New Transction</a> &nbsp;&nbsp; </small>
                  <small  class="text-dark" > <a class="btn btn-outline-primary btn-sm "href="{{route('transactions.list')}}">View All</a> &nbsp;&nbsp; </small>
                



                
                        
                      </div>
             
                    
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-6  ">
            <div class="row">
              <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                  <div class="row">
               
                    <h6 class="text-center">Pending Transactions</h6>
                  
                  </div>
                </div>
                <div class="card-body p-3 pb-0">
                  <tr class="col-xs-6 col-md-6 col-lg-6 " >
                    <td >  <small  class="text-dark text-sm " > <a class="btn bg-gradient-danger btn-sm" href="{{route('budgets.Recurring')}}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Recurring Items</a> &nbsp;&nbsp; </small></td>         
                    <td >  <small  class="text-dark" > <a class="btn bg-gradient-dark btn-sm" href="{{route('budgets.create')}}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Budget Item</a> &nbsp;&nbsp; </small></td>
                 
                    <td >   <small  class="text-dark" > <a class="btn btn-outline-primary btn-sm " href="{{route('budgets.index')}}">View All</a> &nbsp;&nbsp; </small></td>
                  </tr>
                  <hr>
                  <ul class="list-group col-auto">
                    @foreach($budgets as $budget)
                    @if ($budget->Status == "Planning")
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-md d-flex align-items-center justify-content-center"><i class="material-icons text-lg">priority_high</i></button>
                        <div class="d-flex flex-column">
                            <h6 class="text-dark text-sm"> {{ $budget->Description }} </h6>
                            <span class=" text-success text-xs">{{ $budget->due_date }} &nbsp;&nbsp;    <?php
                                $num = $budget->Amount;
                                $n = number_format($num, 2, '.', ',');
                                echo ' ZAR ' . $n;
                            ?>  </span>
                        </div>
                        </div>
                        <div class="d-flex align-items-end text-dark text-sm font-weight-bold">
                           
                        <form class="d-inline"  action="{{ route('budgets.Finalized', $budget->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit"   class="btn btn-link text-success text-gradient " href="javascript:;"><i class="material-icons text-md me-2">send</i></button>
                        </form>
                        <form class="d-inline" action="{{ route('budgets.destroy', $budget->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"   class="btn btn-link text-danger text-gradient " href="javascript:;"><i class="material-icons text-sm me-2">delete</i></button>
                        </form>
  
  
  
  
                        </div>
                    </li>
                    @endif
                @endforeach
                </ul>
                <div class="align-middle text-center ">
                                          {{ $budgets->links() }}
                                      </div>
                                      <hr>
                </div>
              </div>

            </div>
          
          </div>
        </div>
        <div class="row text-uppercase">
         
          <div class=" col-sm-12 col-md-12 col-lg-12 mt-4">
            <div class="card h-100 mb-4">
              <div class="card-header pb-0 px-3">
                <h6 class="mb-0 text-center">Transactions History</h6>

              </div>
             



              <div class="card-body pt-4 p-3 text-uppercase">
              
                <hr>

                  <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">New Incomes</h6>

                  @foreach($transactions as $tran)
                  
                    @if ((date('M', strtotime($tran->bill_date)) == date('M') && date('Y', strtotime($tran->bill_date)) == date('Y')) && ($tran->Action == "Received" || $tran->Action == "Earned"))

                      <ul class="list-group">
                          <!--Incomes First-->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                              <!-- Transaction occurred this week and has the action type "Received" or "Earned" -->
                                
                              <div class="d-flex align-items-center">
                                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-lg">expand_less</i></button>
                                <div class="d-flex flex-column">
                                  <h6 class="mb-1 text-dark text-sm">{{$tran->Description}}</h6>
                                  <span class="text-xs text-dark">{{$tran->bill_date}}</span>
                                </div>
                              </div>
                              <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                <?php
                                $num = $tran->Amount;
                                $n = number_format($num, 2, '.', ',');
                                echo '+ ZAR ' . $n;
                            ?>
                              </div>


                        </li>
                    
                      </ul>
                    


                    @endif

              
                  @endforeach
              </div>
              <div class="card-body pt-4 p-3">
                <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">New Expenses</h6>
                @foreach($transactions as $tran)
                
                  @if ((date('M', strtotime($tran->bill_date)) == date('M') && date('Y', strtotime($tran->bill_date)) == date('Y')) && ($tran->Action == "Paid" || $tran->Action == "Bought"))

                    <ul class="list-group">
                        <!--Expenses Secon-->
                      <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <!-- Transaction occurred this week and has the action type "Paid" or "Bought" -->
                            <div class="d-flex align-items-center">
                              <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-lg">expand_more</i></button>
                              <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">{{$tran->Description}}</h6>
                                <span class="text-xs text-dark">{{$tran->bill_date}}</span>
                              </div>
                            </div>
                            <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                            <?php  $num = $tran->Amount;
                              $n = number_format($num, 2, '.', ',');
                              echo '- ZAR ' . $n;
                          ?>
                            </div>

                      </li>
                  
                    </ul>
             
                  


                  @endif

            
                @endforeach
            </div>
            <div class="align-middle text-center ">
              {{$transactions->links() }}
          </div>
          <hr>




            </div>
          </div>
        </div>
      
      </div>
@endsection
