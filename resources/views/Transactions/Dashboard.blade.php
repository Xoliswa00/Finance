@extends('layouts.Nav') 

@section('content')

<div class="container-fluid center py-4 ">         
  <div class="col-md-12 mt-3">
    <div class="card  mb-4 z-index-0 fadeIn3 shadow-dark fadeInBottom ">
      <div class="card-header pb-0 px-3 p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="row">
          <div
                        class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1"
                    >
                        <h4
                            class="text-white font-weight-bolder text-center mt-2 mb-0"
                        >
                            Transaction Listing
                        </h4>
                    </div>
       
        </div>
      </div>
     


          <div class="card-body pt-4 p-3 text-uppercase">
            <small  class="text-dark" > <a class="btn bg-gradient-dark mb-0" href="{{route('transactions.create')}}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New Transaction</a> &nbsp;&nbsp; </small> <hr>

              <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">New Incomes</h6>

              @foreach($transactions as $tran)
              
                @if ((date('M', strtotime($tran->bill_date)) == date('M') && date('Y', strtotime($tran->bill_date)) == date('Y')) && ($tran->Action == "Received" || $tran->Action == "Earned"))

                  <ul class="list-group">
                      <!--Incomes First-->
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                          <!-- Transaction occurred this week and has the action type "Received" or "Earned" -->
                            
                          <div class="d-flex align-items-center">
                            <button  class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-lg d-flex align-items-center justify-content-center"><i class="material-icons text-lg">expand_less</i></button>
                            <div class="d-flex flex-column">
                              <h6 class="mb-1 text-dark text-sm">{{$tran->Description}}      </h6>
                              <span class="text-xs text-dark">{{$tran->bill_date}}</span>
                            
                            </div>
                          </div>
                          <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                            <?php
                            $num = $tran->Amount;
                            $n = number_format($num, 2, '.', ',');
                            echo '+ ZAR ' . $n;
                        ?>
                        
                        <form action="{{ route('transactions.destroy',$tran->id )}}"  method="POST"  >
                          @csrf
                          @method('DELETE')
                          <button type="submit"   class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="material-icons text-sm me-2">delete</i>Delete</button>

                        </form>
                      

                         
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
                          <button  class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-lg d-flex align-items-center justify-content-center"  ><i class="material-icons text-lg">expand_more</i></button>
                          <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark text-sm">{{$tran->Description}}</h6>
                            <span class="text-xs text-dark">{{$tran->bill_date}}    </span>
                          

                          </div>
                        </div>
                        <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                        <?php  $num = $tran->Amount;
                          $n = number_format($num, 2, '.', ',');
                          echo '- ZAR ' . $n;
                      ?>
                      <form action="{{ route('transactions.destroy',$tran->id )}}"  method="POST"  >
                        @csrf
                        @method('DELETE')
                        <button type="submit"   class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="material-icons text-sm me-2">delete</i>Delete</button>

                      </form>
                        </div>
                      
                  

                  </li>
              
                </ul>
        
              


              @endif
              @endforeach
            
        </div>

     

     
    </div>
  </div>
</div>
@endsection
