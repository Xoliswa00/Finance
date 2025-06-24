@extends('layouts.Nav')

@section('content')

    <div class="container-fluid  shadow-dark py-4 ">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"  >
                    <div class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1">
                        <h2 class="text-white font-weight-bolder text-center mt-2 mb-0" >
                            Budget Management: Overview
                        </h2>
                    </div>
                      
                @if (session('success'))
                    <div class="alert alert-success text-center text-white col-12" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
        </div>

      

            @if($CurrentB->isEmpty() )
            <p class="text-dark">No budgets found.</p>
             <td >  <small  class="text-dark text-sm " > <a class="btn bg-gradient-danger btn-sm" href="{{route('budgets.Recurring')}}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Recurring Items</a> &nbsp;&nbsp; </small></td>         
                    <td >  <small  class="text-dark" > <a class="btn bg-gradient-dark btn-sm" href="{{route('budgets.create')}}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Budget Item</a> &nbsp;&nbsp; </small></td>
            @else

            <div class="align-items-center">
            
                    <div class="row">
                        <div class=" col-sm-12 col-md-6 col-lg-6 mt-4">
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
                                                    <button type="submit"   class="btn btn-link text-info text-gradient px-3 mb-0" href="javascript:;"><i class="material-icons text-md me-2">edit</i>Make changes</button>
                                                </form>
                                            <form class="d-inline" action="{{ route('budgets.Finalized', $budget->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"   class="btn btn-link text-success text-gradient px-3 mb-0" href="javascript:;"><i class="material-icons text-md me-2">send</i>Finalized</button>
                                            </form>
                                            <form class="d-inline" action="{{ route('budgets.destroy', $budget->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"   class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="material-icons text-sm me-2">delete</i>Delete</button>
                                            </form>
            
            
            
            
                                            </div>
                                        </li>
                                        @endif
                                    @endforeach
                                    </ul>
                                
                                </div>
                            </div>
                        
                        </div>
                        <div class="col-md-6 col-sm-12  col-lg-6 mt-4 ">
                                <div  class="card  h-100 mb-4">
                                    <div class="card-header pb-0 px-3 text-center">
                                        <div class="row">
                                            <div class="col-6 d-flex">
                                                <h6 class="mb-0  ">Budget Summary</h6>
                                            </div>
                                    
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive col-auto  p-0">
                                    
                    
                                            <table class="table table-responsive align-items-center mb-0">
                                                <thead>
                                                    <tr class="shadow-info " >
                                                        <th class="text-uppercase text-dark font-weight-bolder opacity-7"  >Month</th>
                                                        <th class="text-uppercase text-dark font-weight-bolder opacity-7" >Budgeted Income</th>
                                                        <th class="text-uppercase text-dark font-weight-bolder opacity-7" >Budgeted Expense</th>
                                                        <th  class="text-uppercase text-dark font-weight-bolder opacity-7" >Difference</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalIncomeBudgeted = 0;
                                                        $totalExpenseBudgeted = 0;
                                                        $totalNetBudgeted = 0;
                                                    @endphp
                                                    @foreach ($budgetData as $entry)
                                                        <tr>
                                                            <td class="align-middle text-center">{{ $entry->month }}</td>
                                                            <td class="align-middle text-center">ZAR {{ number_format($entry->income_budgeted, 2, '.', ',') }}</td>
                                                            <td class="align-middle text-center">ZAR {{ number_format($entry->expense_budgeted, 2, '.', ',') }}</td>
                                                            @if( $entry->net_budgeted<0)
                                                            <td class="align-middle text-danger text-center">ZAR {{ number_format($entry->net_budgeted, 2, '.', ',') }}</td>
                                                            @else
                                                            <td class="align-middle text-success text-center">ZAR {{ number_format($entry->net_budgeted, 2, '.', ',') }}</td>
                                                            @endif
                                                        </tr>
                                                        @php
                                                            $totalIncomeBudgeted += $entry->income_budgeted;
                                                            $totalExpenseBudgeted += $entry->expense_budgeted;
                                                            $totalNetBudgeted += $entry->net_budgeted;
                                                        @endphp
                                                    @endforeach
                                                    <tr style="border: double;" class="bg-gradient-dark text-white" >
                                                        <td class="align-middle text-center">Totals</td>
                                                        <td class="align-middle text-center">ZAR {{ number_format($totalIncomeBudgeted, 2, '.', ',') }}</td>
                                                        <td class="align-middle text-center">ZAR {{ number_format($totalExpenseBudgeted, 2, '.', ',') }}</td>
                                                        @if( $totalNetBudgeted <0)
                                                        <td class="align-middle text-danger ext-bold text-gradient text-center">ZAR {{ number_format($totalNetBudgeted, 2, '.', ',') }}</td>
                                                        @else
                                                        <td class="align-middle  text-success ext-bold text-gradient text-center">ZAR {{ number_format($totalNetBudgeted, 2, '.', ',') }}</td>
                                                        @endif
            
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <br>
            
                                            <table class="table table-responsive align-items-center mb-0">
                                                <thead>
                                                    <tr class="shadow-info "  >
                                                        <th class="text-uppercase text-dark font-weight-bolder opacity-7" >Month</th>
                                                        <th class="text-uppercase text-dark font-weight-bolder opacity-7" >Actual Income</th>
                                                        <th  class="text-uppercase text-dark font-weight-bolder opacity-7" >Actual Expense</th>
                                                        <th  class="text-uppercase text-dark font-weight-bolder opacity-7" >Difference </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalIncomeActual = 0;
                                                        $totalExpenseActual = 0;
                                                        $totalNetActual = 0;
                                                    @endphp
                                                    @foreach ($budgetData as $entry)
                                                        <tr>
                                                            <td class="align-middle text-center">{{ $entry->month }}</td>
                                                            <td class="align-middle text-center">ZAR {{ number_format($entry->income_actual, 2, '.', ',') }}</td>
                                                            <td class="align-middle text-center">ZAR {{ number_format($entry->expense_actual, 2, '.', ',') }}</td>
                                                            @if($entry->net_actual <0)
                                                            <td class="align-middle text-danger text-center">ZAR {{ number_format($entry->net_actual, 2, '.', ',') }}</td>
                                                            @else
                                                            <td class="align-middle text-success text-center">ZAR {{ number_format($entry->net_actual, 2, '.', ',') }}</td>
                                                            @ENDIF
                                                        </tr>
                                                        @php
                                                            $totalIncomeActual += $entry->income_actual;
                                                            $totalExpenseActual += $entry->expense_actual;
                                                            $totalNetActual += $entry->net_actual;
                                                        @endphp
                                                    @endforeach
                                                    <tr style="border: double;"  class="bg-gradient-info text-white" >
                                                        <td class="align-middle text-center">Totals</td>
                                                        <td class="align-middle text-center">ZAR {{ number_format($totalIncomeActual, 2, '.', ',') }}</td>
                                                        <td class="align-middle text-center">ZAR {{ number_format($totalExpenseActual, 2, '.', ',') }}</td>
                                                        @if($totalNetActual<0)
                                                        <td class="align-middle text-danger text-bold text-gradient text-center">ZAR {{ number_format($totalNetActual, 2, '.', ',') }}</td>
                                                        @else
                                                        <td class="align-middle  text-bold text-white text-center">ZAR {{ number_format($totalNetActual, 2, '.', ',') }}</td>
                                                    @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                        </div>

                    </div>
                <div class="row">
                    <div class="col-md-6 mt-4 shadow-dark">
                        <div class="card h-100 mb-4">
                            <div class="card-header pb-0 px-3">
                                <div class="row">
                                    <div class="col-6 d-flex align-items-center">
                                        <h6 class="mb-0">Finalized Budget Items</h6>
                                    </div>
                                <div class="col-md-6 d-flex justify-content-start justify-content-md-end align-items-center">
                                    <i class="material-icons me-2 text-lg">date_range</i>
                                    <small>23 - 30 March 2020</small>
                                </div>
                                </div>
                            </div>
                            <div class="card-body pt-4 p-3">
                                <h6 class=" text-body text-xs font-weight-bolder mb-3">Newest</h6>

                                <ul class="list-group">
                                    @foreach($budgets as $budget)
                                    @if ($budget->Status == "Finalized")
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-info mb-0 me-3 p-3 btn-md d-flex align-items-center justify-content-center"><i class="material-icons text-lg">priority_high</i></button>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-uppercase text-sm"> {{ $budget->Description }} &nbsp;&nbsp; <?php
                                                $num = $budget->Amount;
                                                $n = number_format($num, 2, '.', ',');
                                                echo ' ZAR ' . $n;
                                            ?> </h6>
                                            <span class=" text-info text-xs">{{ $budget->due_date }}      </span>
                                        </div>
                                        </div>
                                        <div class="d-flex align-items-center text-info text-sm font-weight-bold">
                                            Finalized
                                        
                                    




                                        </div>
                                    </li>

                            
                                    @endif

                                @endforeach
                                </ul>
                                                    <!-- Add pagination links below the table -->
                                    <div class="align-middle text-center ">
                                        {{ $budgets->links() }}
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-4 shadow-dark">
                        <div class="card bg-gradient-default border-0">
                            <div class="card-header text-lg text-center bg-gradient-success">Budget Trend : Income vs Expense</div>
                            <div class="card-body">
                                <canvas id="budgetLineChart" width="400" height="400"></canvas>
                                <script>
                                    // Retrieve the data from your PHP variable
                                    var chartData = @json($chart);
                                
                                    // Extract labels (months) and data values (income and expenses) from the retrieved data
                                    var labels = chartData.map(entry => entry.month);
                                    var incomeData = chartData.map(entry => entry.income_budgeted);
                                    var expenseData = chartData.map(entry => entry.expense_budgeted);
                                    var OtherData = chartData.map(entry => entry.other_spending);
                                
                                    // Create a new line chart
                                    var ctx = document.getElementById("budgetLineChart").getContext('2d');
                                
                                    var budgetLineChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: labels,
                                            datasets: [
                                                {
                                                    label: 'Income Budgeted',
                                                    data: incomeData,
                                                    backgroundColor: 'rgba(0, 0, 0, 0.2)', // Dark background
                                                    borderColor: 'rgba(75, 192, 192, 1)',
                                                    borderWidth: 3,
                                                    pointBackgroundColor: 'rgba(75, 192, 192, 1)', // Glowing effect on data points
                                                    pointRadius: 5, // Increase point size
                                                    pointHoverRadius: 7, // Increase point size on hover
                                                    pointHoverBorderColor: 'rgba(75, 192, 192, 1)', // Glowing effect on hover
                                                    pointHoverBorderWidth: 3, // Increase point border width on hover
                                                },
                                                {
                                                    label: 'Expense Budgeted',
                                                    data: expenseData,
                                                    backgroundColor: 'rgba(0, 0, 0, 0.2)', // Dark background
                                                    borderColor: 'rgba(255, 99, 132, 1)',
                                                    borderWidth: 4,
                                                    pointBackgroundColor: 'rgba(255, 99, 132, 1)', // Glowing effect on data points
                                                    pointRadius: 5, // Increase point size
                                                    pointHoverRadius: 7, // Increase point size on hover
                                                    pointHoverBorderColor: 'rgba(255, 99, 132, 1)', // Glowing effect on hover
                                                    pointHoverBorderWidth: 3, // Increase point border width on hover
                                                },
                                                {
                                                    label: 'Other Spending',
                                                    data: OtherData,
                                                    backgroundColor: 'rgba(0, 0, 0, 0.2)', // Dark background
                                                    borderColor: 'rgb(29, 214, 54)',
                                                    borderWidth: 4,
                                                    pointBackgroundColor: 'rgba(255, 99, 132, 1)', // Glowing effect on data points
                                                    pointRadius: 5, // Increase point size
                                                    pointHoverRadius: 7, // Increase point size on hover
                                                    pointHoverBorderColor: 'rgba(255, 99, 132, 1)', // Glowing effect on hover
                                                    pointHoverBorderWidth: 3, // Increase point border width on hover
                                                }
                                            ]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            scales: {
                                                x: {
                                                    display: true,
                                                    title: {
                                                        display: true,
                                                        text: 'Months'
                                                    }
                                                },
                                                y: {
                                                    display: true,
                                                    title: {
                                                        display: true,
                                                        text: 'Budget Amount'
                                                    }
                                                }
                                            }
                                        }
                                    });
                                </script>
                                
                                
                                


                            </div>
                                
                                   

                    </div>

                </div>
                
        
            </div>
            @endif
     
        </div>
    </div>
@endsection

