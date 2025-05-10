@extends('layouts.Nav')

@section('content')


    <div style="background-color: rgb(75, 82, 82);" class="container-fluid shadow-xl shadow-dark py-6 border-radius-xl">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="row">
                
                  <div class="col-sm-12 col-lg-6 col-md-12 ">
                
                  
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
                        <br>
                    

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
                  <div class="col-md-12  mb-3">
                    <div class="card mt-4">
                      <div class="card-header pb-0 p-3">
                    
                  
                            
                          
                
                        
                
                      </div>
                    
                      <div class="card-body text-sm p-3 pb-0">
                      
                        <div class="table-responsive p-0">
                            <table class="table table-responsive align-items-center ">
                                <thead>
                                    <tr class="bg-gradient-info text-white  ">
                                        <th class="text-uppercase  font-weight-bolder opacity-7">Goal Name</th>
                                     
                                        <th class=" text-uppercase  font-weight-bolder opacity-7">End Date</th>
                                      
                                        <th class=" text-uppercase font-weight-bolder opacity-7">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    @foreach ($goals as $goal)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column ">
                                                    <h6 class="mb-0 ">{{ $goal->title }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                      
                                       
                                        <td class="">
                                            {{ $goal->end_date }}
                                        </td>
                                    
                                      

                                          <td>
                                            <div class="progress">
                                                @php
                                                    // Calculate progress
                                                    $max = $goal->target_amount;
                                                    $current = $goal->current_amount;
                                    
                                                    // Calculate percentage
                                                    $percentage = ($current / $max) * 100;
                                                @endphp
                                                <progress  class="progress-bar-bg bg-gradient-danger" title=" Cuurently {{ $percentage }}  % completed"  id="file" value="{{ $percentage }}" max="100">50</progress>
                                              
                                          </div>
                                            </div>
                                          
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- Add pagination links below the table -->
                        <div class="align-middle text-center ">
                            {{ $goals->links() }}
                        </div>





                    </div>
                  </div>



                  
                </div>


               
            </div>
           
          
            
          </div>
          <div class="col-sm-12 col-md-6 col-lg-6">
          
           
            <div class="card mb-4">
              
              <div class="card-body p-3">
                  <div class="row">
                    <div class="col-md-6 " >
                      <canvas id="budgetChart" width="400" height="400"></canvas>
                      <div class="text-center mt-3">
                        <h6>Budget Overview</h6>
                    </div>
                  </div>
                  <div class="col-md-6 ">
                      <canvas id="actualChart" width="200" height="200"></canvas>
                      <div class="text-center mt-3">
                        <h6>Actual Overview</h6>
                    </div>
                  </div>
                 <!-- TODO:add investment bar -->
                  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                  <script>
                    const budgetChartCanvas = document.getElementById('budgetChart').getContext('2d');
                    const actualChartCanvas = document.getElementById('actualChart').getContext('2d');
                    
                
                    const budgetData = {
                        labels: ['Income Budgeted', 'Expense Budgeted'],
                        datasets: [{
                            label: 'Budget Summary',
                            data: [{{ $budget[0]->income_budgeted }}, {{ $budget[0]->expense_budgeted }}],
                            backgroundColor: ['#36a2eb', '#ff6384'],
                        }],
                    };
                
                    const actualData = {
                        labels: ['Income Actual', 'Expense Actual'],
                        datasets: [{
                            label: 'Actual Summary',
                            data: [{{ $actual[0]->income_actual }}, {{ $actual[0]->expense_actual }}],
                            backgroundColor: ['#36a2eb', '#ff6384'],
                        }],
                    };
                
                    const budgetChart = new Chart(budgetChartCanvas, {
                        type: 'bar',
                        data: budgetData,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Budget Summary',
                                    padding: {
                                        top: 10,
                                        bottom: 20
                                    }
                                }
                            }
                        }
                    });
                
                    const actualChart = new Chart(actualChartCanvas, {
                        type: 'bar',
                        data: actualData,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Actual Summary',
                                    padding: {
                                        top: 10,
                                        bottom: 20
                                    }
                                }
                            }
                        }
                    });
                </script>
                
                
                
                </div>
            </div>
              </div>
                                         
                                          <div class=" card border-radius-xl">
                                            <div class=" text-uppercase text-bold   bg-gradient-info text-center">
                                              <h3 class="text-white"> Payments Due Dates</h3>

                                            </div>
                                            <div class="card-body">
                                              <ul class="text-dark">
                                                @foreach($budgetDates as $data)
                                                <li class="table-straped">
                                                    <strong>Due Dates:</strong> {{$data->Description}} - {{$data->due_date}}
                                                </li>
                                                @endforeach
                                               
                                                <!-- Add more events or deadlines as needed -->
                                            </ul>
                                            <div class="align-middle text-center ">
                                              {{ $budgetDates->links() }}
                                          </div>

                                            </div>
                                          
                                        </div>               

             
             
          </div>
          
         
        </div>
        <div class=" col-sm-12 col-md-12 col-lg-12 mt-4">
          <div class="card h-100 mb-4">
              <div class="card-header pb-0 px-3">
                  <div class="row">
                      <div class="col-sm-3 d-flex align-items-center">
                          <h6 class="mb-0">Pending Budget Items</h6>
                      </div>
                  <div class="col-sm-9 d-flex justify-content-start justify-content-md-end align-items-center">
                      <small  class="text-dark" > <a class="btn bg-gradient-dark mb-0" href="{{route('budgets.create')}}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New Budget Item</a> &nbsp;&nbsp; </small> <hr>

                  </div>
                  </div>
              </div>
              <div class="card-body pt-4 p-3">
                  <h6 class=" text-body text-xs font-weight-bolder mb-3">Newest</h6>

                  <ul class="list-group">
                      @foreach($CurrentB as $budget)
                      @if ($budget->Status == "Planning")
                      <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                          <div class="d-flex align-items-center">
                              <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-md d-flex align-items-center justify-content-center"><i class="material-icons text-lg">priority_high</i></button>
                          <div class="d-flex flex-column">
                              <h6 class="mb-1 text-dark text-uppercase text-sm"> {{ $budget->Description }} </h6>
                              <span title="BA - Budget Amount, (AA) -Actual Amount" class="  text-success text-xs">{{ $budget->due_date }} &nbsp;&nbsp;  BA  <?php
                                  $num = $budget->Amount;
                                  $n = number_format($num, 2, '.', ',');
                                  echo ' ZAR ' . $n;
                              ?> Vs. AA   <?php
                              $Zum = $budget->Limit;
                              $n = number_format($Zum, 2, '.', ',');
                              echo ' ZAR ' . $n;
                          ?>   </span>
                          </div>
                          </div>
                          <div class="d-flex align-items-center text-dark text-sm font-weight-bold">
                              <form class="d-inline" action="{{ route('budgets.edit', $budget->id) }}" method="POST">
                                  @csrf
                                  @method('get')
                                  <button type="submit"   class="btn btn-link text-info text-gradient px-3 mb-0" href="javascript:;"><i class="material-icons text-md me-2">edit</i></button>
                              </form>
                          <form class="d-inline" action="{{ route('budgets.Finalized', $budget->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit"   class="btn btn-link text-success text-gradient px-3 mb-0" href="javascript:;"><i class="material-icons text-md me-2">send</i></button>
                          </form>
                          <form class="d-inline" action="{{ route('budgets.destroy', $budget->id) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit"   class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="material-icons text-sm me-2">delete</i></button>
                          </form>




                          </div>
                      </li>
                      @endif
                  @endforeach
                  </ul>
              
              </div>
          </div>
      
      </div>
     



    
     
@endsection




