@extends('layouts.Nav')
@section('content')

<div class="row">
    @foreach($Section as $section)
            <div class="col-md-6 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-header text-white bg-gradient-info ">
                        <h5 class="text-white" >{{$section->Section}}</h5>
                        <div class="">
                        
                            <a href="{{ route('section.edit', $section->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('section') }}" class="btn btn-danger">Add Section</a>


                            <form action="{{ route('section.delete', $section->id)  }}" method="POST" style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this goal?')">Delete</button>
                            </form>
                        
                        </div>
                    
                    </div>

                    <div class="card-body d-flex text-dark text-sm justify-content align-items-center">
                    
                            
                            <div class="col-6 ">
                                <canvas id="pieChart{{$section->id}}" width="200" height="150"></canvas>
                                <span class="badge bg-info rounded-pill">
                                    {{ number_format(($section->Actual / $section->Budget) * 100, 2) }}%
                                </span>
                                <p>Item Status : <strong>{{$section->Status}}</strong></p>
                            

                            </div>
                        
                        <ul class="list-group text text-sm te list-group-flush">
                            <li class="list-group-item">
                                <strong>Total Budget:</strong>@php
                                $num =$section->Budget;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                            @endphp
                            </li>
                            <li class="list-group-item">
                                <strong>Total Spending / Actual:</strong> @php
                                $num =$section->Actual;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                            @endphp
                            </li>
                            <li class="list-group-item">
                                <strong>Remaining Balance:</strong> @php
                                $num =$section->Budget - $section->Actual;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                            @endphp
                            </li>
                            <li class="list-group-item">
                                <strong> Transactions on hold:</strong> @php
                                $num =$sum[0]->total;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                            @endphp

                            <li class="list-group-item">
                                <strong>Balance after Transaction on hold:</strong> @php
                                $num =($section->Budget - $section->Actual)-$sum[0]->total;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                            @endphp
                            </li>
                        </ul>
                        
                    </div>
                    <script>
                        var ctx{{$section->id}} = document.getElementById("pieChart{{$section->id}}").getContext('2d');
                        var budget = {{$section->Budget}};
                        var actual = {{$section->Actual}};
                        var data = [budget, actual];
                        var labels = ["Budget", "Actual"];
                        var colors = ["#36a2eb", "#ff6384"];
                        var pieChart{{$section->id}} = new Chart(ctx{{$section->id}}, {
                            type: 'pie',
                            data: {
                                datasets: [{
                                    data: data,
                                    backgroundColor: colors,
                                }],
                                labels: labels,
                            },
                        });
                    </script>
                </div>
                <br>
                <div class="card mb-4">
                    <div class="card-header bg-danger pb-0 p-3">
                    <i class="fa fa-table"></i>
                  
                   
                        <h6 class="text-center text-white">Section Budget</h6>
                      
                    
                    </div>
                    <div class="card-body p-3 pb-0">
                      <tr class="col-xs-6 col-md-6 col-lg-6 " >
                        <td >  <small  class="text-dark text-sm " > <a aria-disabled="true" class="btn bg-gradient-danger btn-sm" href="{{route('budgets.Recurring')}}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Recurring Items</a> &nbsp;&nbsp; </small></td>         
                        <td >  <small  class="text-dark" > <a class="btn bg-gradient-dark btn-sm" href="{{route('holding.create')}}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Budget Item</a> &nbsp;&nbsp; </small></td>
                   
                      </tr>
                      <hr>
                      <ul class="list-group col-auto">
                        @foreach($holding as $budget)
                        @if ($budget->Status == "Holding")
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-md d-flex align-items-center justify-content-center"><i class="material-icons text-lg">priority_high</i></button>
                            <div class="d-flex flex-column">
                                <h6 class="text-dark text-sm"> {{ $budget->Description }} </h6>
                                <span class=" text-success text-xs">{{ $budget->bill_date }} &nbsp;&nbsp;    <?php
                                    $num = $budget->Amount;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' ZAR ' . $n;
                                ?>  </span>
                            </div>
                            </div>
                            <div class="d-flex align-items-end text-dark text-sm font-weight-bold">
                               
                                <form method="Post"  action="{{ route('holding.update') }}">
                                    @csrf
            
            
            
                                                       
                                        <input hidden name="Action" class="form-control" required value="{{$budget->Action}}">
                                       <input hidden name="category" class="form-control" required value="{{ $budget->Category }}">
                                       <input hidden name="description"  value="{{ $budget->Description }}" required >
                                       <input hidden name="Method" value="{{$budget->Method}}">
                                       <input hidden id="amount"  name="amount"value="{{ $budget->Amount}}" required >
                                       <input hidden id="bill_date"  name="bill_date" value="{{ $budget->bill_date}}" required autocomplete="bill_date">
                                       <input hidden id="Invoice_slip" name="Invoice_slip"value="{{ $budget->Invoice_slip }}"  >
                                       <input hidden name="id" value="{{$budget->id}}">
            
                                        <button type="submit" class="btn btn-success  mb-0 text-white">finalise </button>
            
                                  
            
                                </form>
                           
      
      
      
      
                            </div>
                        </li>
                        @endif
                    @endforeach
                    </ul>
                    <div class="align-middle text-center ">
                                              
                                          </div>
                                          <hr>
                    </div>
                  </div>
            </div>

    @endforeach
     <div class="col-md-6 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-center"><i class="fa fa-bar-chart"></i>&nbsp;Expense Categories </div>
            <div class="card-body pt-4 p-3 text-uppercase">
              
                <hr>

                  <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">New Incomes</h6>

                  @foreach($transactions as $tran)
                  
                    @if ($tran->Action == "Received" || $tran->Action == "Earned")

                      <ul class="list-group">
                          <!--Incomes First-->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                              <!-- Transaction occurred this week and has the action type "Received" or "Earned" -->
                                
                              <div class="d-flex align-items-center">
                                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-lg">expand_less</i></button>
                                <div class="d-flex flex-column">
                                  <h6 class="mb-1 text-dark text-sm">{{$tran->Section}} : {{$tran->Description}}</h6>
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
                
                  @if  ($tran->Action == "Paid" || $tran->Action == "Bought")
    
                    <ul class="list-group">
                        <!--Expenses Secon-->
                      <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <!-- Transaction occurred this week and has the action type "Paid" or "Bought" -->
                           
                            <div class="d-flex align-items-center">
                              <button  class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-lg d-flex align-items-center justify-content-center"  ><i class="material-icons text-lg">expand_more</i></button>
                              <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">{{$tran->Section}} : {{$tran->Description}}</h6>
                                <span class="text-xs text-dark">{{$tran->bill_date}}    </span>
                      
                              
    
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
            
        </div>
       
     </div>




  </div>


@endsection