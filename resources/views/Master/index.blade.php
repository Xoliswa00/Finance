@extends('layouts.Nav')

@section('content')
<div class="container-flud">

    @php
    $Sec=0;

    @endphp
    <div class="col-1g-12 col-sm-12 col-md-12 ">
        <div class="card">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                    <h2 class="text-white text-uppercase text-center"> Goals Overview</h2>
                </div>
                <br>
            </div>
            <div class="card-body  text-dark">
                <div class="col-1g-12 col-sm-12 col-md-12">
                    <div class="chart-container" style="position: relative; height:50vh; ">
                        <canvas id="financialChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6 col-md-12 table-responsive  ">
                    <table class="table table-responsive-sm  mb-0">
                        <thead>
                            <tr class="bg-gradient-info text-white"  >
                                <th>Project Name</th>
                                <th>Budget</th>
                                <th>Actual</th>
                                <th>Variance</th>
                     
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($masters as $project)
                            <tr class="text-sm" >
                                <tr>
                                    <td>{{ $project->Name }}</td>
                                    <td>R {{ number_format($project->Budget, 2) }}</td>
                                    <td>R {{ number_format($project->Actual, 2) }}</td>
                                    <td>R {{ number_format($project->Budget-$project->Actual, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                


               
                <script>
                    const projects = @json($masters);
            
                    const ctx = document.getElementById('financialChart').getContext('2d');
            
                    const projectNames = projects.map(project => project.Name);
                    const budgets = projects.map(project => project.Budget);
                    const actuals = projects.map(project => project.Actual);
            
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: projectNames,
                            datasets: [
                                {
                                    label: 'Budget',
                                    data: budgets,
                                    backgroundColor: 'rgba(200, 132, 235, 0.5)',
                                },
                                {
                                    label: 'Actual',
                                    data: actuals,
                                    backgroundColor: 'rgba(355, 29, 132, 0.5)',
                                },
                            ],
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                },
                            },
                        },
                    });
                </script>
              
                
            </div>
           
        </div>
        
    </div>

</div>

<hr>
<hr>
        <div class="col-1g-12 col-sm-12 col-md-12 ">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                        <h2 class="text-white text-uppercase text-center">Master Goals</h2>
                    </div>
                    <br>
                    <a class="btn bg-gradient-primary mb-0 font-weight-bolder opacity-7 " href="{{ route('Master') }}"><i class="material-icons text-lg">add</i>&nbsp;&nbsp;Create Master Goal</a>
                    <a class="btn bg-gradient-danger mb-0 font-weight-bolder opacity-7 " href="{{ route('section') }}"><i class="material-icons text-lg">add</i>&nbsp;&nbsp;Add Master Section</a>
                    <a class="btn bg-gradient-primary mb-0 font-weight-bolder opacity-7 " href="{{ route('Master') }}"><i class="material-icons text-lg">add</i>&nbsp;&nbsp;Transaction</a>

                </div>

                <div  data-bs-version="5.1" class="card-body shadow-dark content16 cid-tSlafClOWQ text-center" id="content16-r"   >
           
                                <div id="bootstrap-accordion_22" class="panel-group accordionStyles accordion" role="tablist" aria-multiselectable="true">


                                    @foreach($masters as $goal)
                                    <div class="card mb-3 shadow-warning   text-center ">
                                        <div class="card-header   shadow-dark  " role="tab" id="headingOne">
                                            <a role="button" class="panel-title collapsed" data-toggle="collapse" data-bs-toggle="collapse" data-core="" href="#collapses{{$goal->id}}_22" aria-expanded="false" aria-controls="collapses{{$goal->id}}">
                                               <div class="panel-title">
                                                <h4> {{$goal->Name}} </h4>
                                               
                                                
                                                </div>
                                                 
                                                <span class="sign mbr-iconfont mbri-arrow-down"></span>
                                            </a>
                                           
                                       
                                        </div>
                                        <div id="collapses{{$goal->id}}_22" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" data-bs-parent="#bootstrap-accordion_22">
                                            <div class="panel-body">
                                                <div class="container-fluid mt-4">
                                                    <div class="row">
                                                        @foreach($Section as $section)
                                                            @if($section->Master == $goal->id)
                                                                <div class="col-md-6 col-sm-12 mb-4">
                                                                    <div class="card">
                                                                        <div class="card-header text-white bg-gradient-info ">
                                                                            <h5 class="text-white" >{{$section->Section}}</h5>
                                                                            <div class="">
                                                                               
                                                                                <a href="{{ route('master.show', $section->id) }}" class="btn btn-secondary">Show{{$section->id}}</a>
                                                                                <a href="{{ route('section.edit', $section->id) }}" class="btn btn-primary">Edit</a>
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
                                                                                    <strong>Budget:</strong>@php
                                                                                    $num =$section->Budget;
                                                                                    $n = number_format($num, 2, '.', ',');
                                                                                    echo ' R ' . $n;
                                                                                  @endphp
                                                                                </li>
                                                                                <li class="list-group-item">
                                                                                    <strong>Actual:</strong> @php
                                                                                    $num =$section->Actual;
                                                                                    $n = number_format($num, 2, '.', ',');
                                                                                    echo ' R ' . $n;
                                                                                  @endphp
                                                                                </li>
                                                                                <li class="list-group-item">
                                                                                    <strong>Balance:</strong> @php
                                                                                    $num =$section->Budget - $section->Actual;
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
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                


                                                <div class="container text-right text-dark">
                                                    @foreach($balance as $balances)
                                                    @if($balances->Master == $goal->id )
                                                    <ul class="list-group text-sm list-group-flush">
                                                        <li class="list-group-item">
                                                            <strong>Budget:</strong>@php
                                                            $num =$balances->Budget;
                                                            $n = number_format($num, 2, '.', ',');
                                                            echo ' R ' . $n;
                                                        @endphp
                                                        </li>
                                                        <li class="list-group-item">
                                                            <strong>Actual:</strong> @php
                                                            $num =$balances->Actual;
                                                            $n = number_format($num, 2, '.', ',');
                                                            echo ' R ' . $n;
                                                        @endphp
                                                        </li>
                                                        <li class="list-group-item">
                                                            <strong>Balance:</strong> @php
                                                            $num =$balances->Budget - $balances->Actual;
                                                            $n = number_format($num, 2, '.', ',');
                                                            echo ' R ' . $n;
                                                        @endphp
                                                        </li>
                                                    </ul>
                                                
                                                @endif
                                                @endforeach
    
    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                  
                                   
                                
                                
                              
                                   
                                </div>
                           
                

                </div>
               
            </div>
            
        </div>

      

@endsection
