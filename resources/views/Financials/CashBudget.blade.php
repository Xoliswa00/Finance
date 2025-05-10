@extends('layouts.Nav')



@section('content')
<div class="container-fluid ">
    <h1 class="text-center bg-gradient-info shadow-primary border-radius-lg py-3 pe-1 text-white ">Cash Budget Report</h1>

    <!-- Company information section -->
    <div class="row">
        <div class="col-md-6 text-dark">
            <p><strong>Prepared By:</strong> BF : Bright Finance</p>
            <p><strong>Prepared For:</strong> John Doe</p>
            <p><strong>Starting Date:</strong> {{$data['month_2']}}</p>
        </div>
    </div>
    <br>

    <!-- Cash Inflows section -->
    
    <table class="table table-hover table-responsive ">
        <thead>
            <tr class="bg-gradient-info shadow-primary text-white text-center" >
               
                <th  style="text-align: justify;" >Source</th>
              
                <th class="text-center" >{{$data['month_2']}} budget</th>
                
                <th>{{$data['month_2']}} Actual</th>
                <th> {{$data['month_2']}} Variance</th>
                <th>{{$data['month_1']}} Budget</th>
                <th>{{$data['month_1']}} Actual</th>
                <th> {{$data['month_1']}} Variance</th>
                <!-- Add more months as needed -->
            </tr>
        </thead>
        <tbody>
        <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <tr class="bg-gradient-dark text-white" >
                <td>Category - Cash inflow</td>
                <th></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <!-- Add rows for each cash inflow source -->
            @php
            $BMonth2=0;
            $Amonth2=0;
            $BMonth1=0;
            $Amonth1=0;




            @endphp


            @foreach($data['budget_data'] as $key => $budget )

            @if($budget->Nature=='Income')
            <tr class=" text-dark text-center" >
                <td style="text-align: justify;" class=" text-uppercase " >{{ $budget->Description}}</td>
           
                <td >{{$budget->month_2_budget}}</td>
                <td>{{$budget->month_2_Actual}}</td>
                @if($budget->month_2_budget > $budget->month_2_Actual )
                <td class="text-danger" > @php
                    $num =$budget->month_2_budget - $budget->month_2_Actual;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp
                    
                    
                    </td>
                    @else
                    <td class="text-success" > @php
                        $num =  $budget->month_2_budget - $budget->month_2_Actual ;
                        $n = number_format($num, 2, '.', ',');
                        echo ' R ' . $n;
                      @endphp
                        
                        
                        </td>

                    @endif
                <td>{{$budget->month_1_budget}}</td>
                <td>{{$budget->month_1_Actual}}</td>
                @if($budget->month_1_budget > $budget->month_1_Actual )
                <td class="text-danger" > @php
                    $num =$budget->month_1_budget - $budget->month_1_Actual;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp
                    
                    
                    </td>
                    @else
                    <td class="text-success" > @php
                        $num =  $budget->month_1_budget - $budget->month_1_Actual ;
                        $n = number_format($num, 2, '.', ',');
                        echo ' R ' . $n;
                      @endphp
                        
                        
                        </td>

                    @endif
            </tr>
            @php
            $BMonth2 +=$budget->month_2_budget;
            $BMonth1 +=$budget->month_1_budget;
            $Amonth2 +=$budget->month_2_Actual;
            $Amonth1 +=$budget->month_1_Actual;




            @endphp
            @endif
          
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
               
            </tr>
            <tr class="bg-gradient-dark text-white text-center" >
                <td style="text-align: justify;" >Grand Total - Cash inflow</td>
           
                <td> @php
                    $num =$BMonth2 ;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp 
                </td>

                <td> @php
                    $num =$Amonth2 ;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp 
                </td>
                <td>
                    @php
                    $num = $BMonth2-$Amonth2 ;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp



                </td>


                <td> @php
                    $num =$BMonth1 ;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp 
                </td>

                <td> @php
                    $num =$Amonth1 ;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp 
                </td>
               
                <td>
                    @php
                    $num = $BMonth1-$Amonth1 ;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp



                </td>
               
            </tr>

            <!-- Expenses -->
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>


            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <tr class="bg-gradient-dark text-white" >
                <td>Category - Cash Outflow</td>
                <th></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <!-- Add rows for each cash outflow source -->
            @php
            $BMonth2=0;
            $Amonth2=0;
            $BMonth1=0;
            $Amonth1=0;




            @endphp


            @foreach($data['budget_data'] as $key => $budget )

            @if($budget->Nature <>'Income')
            @if($budget->month_2_budget > 0 or $budget->month_1_budget  > 0 )
            <tr class=" text-dark text-center" >
                <td style="text-align: justify;" class=" text-uppercase " >{{ $budget->Description}}</td>
           
                <td > @php
                    $num =$budget->month_2_budget;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp

                </td>
                <td> @php
                    $num = $budget->month_2_Actual;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp</td>
                @if($budget->month_2_budget > $budget->month_2_Actual )
                <td class="text-danger" > @php
                    $num =$budget->month_2_budget - $budget->month_2_Actual;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp
                    
                    
                    </td>
                    @else
                    <td class="text-success" > @php
                        $num =  $budget->month_2_budget - $budget->month_2_Actual ;
                        $n = number_format($num, 2, '.', ',');
                        echo ' R ' . $n;
                      @endphp
                        
                        
                        </td>

                    @endif
                <td>@php
                    $num =$budget->month_1_budget;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp</td>
                <td>@php
                    $num = $budget->month_1_Actual;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp</td>
                @if($budget->month_1_budget > $budget->month_1_Actual )
                <td class="text-danger" > @php
                    $num =$budget->month_1_budget - $budget->month_1_Actual;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp
                    
                    
                    </td>
                    @else
                    <td class="text-success" > @php
                        $num =  $budget->month_1_budget - $budget->month_1_Actual ;
                        $n = number_format($num, 2, '.', ',');
                        echo ' R ' . $n;
                      @endphp
                        
                        
                        </td>

                    @endif
            </tr>
            @php
            $BMonth2 +=$budget->month_2_budget;
            $BMonth1 +=$budget->month_1_budget;
            $Amonth2 +=$budget->month_2_Actual;
            $Amonth1 +=$budget->month_1_Actual;




            @endphp
            @endif
            @endif
          
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
               
            </tr>
            <tr class="bg-gradient-dark text-white text-center" >
                <td style="text-align: justify;" >Grand Total - Cash Outflow</td>
           
                <td> @php
                    $num =$BMonth2 ;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp 
                </td>

                <td> @php
                    $num =$Amonth2 ;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp 
                </td>
                <td>
                    @php
                    $num = $BMonth2-$Amonth2 ;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp



                </td>


                <td> @php
                    $num =$BMonth1 ;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp 
                </td>

                <td> @php
                    $num =$Amonth1 ;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp 
                </td>
               
                <td>
                    @php
                    $num = $BMonth1-$Amonth1 ;
                    $n = number_format($num, 2, '.', ',');
                    echo ' R ' . $n;
                  @endphp



                </td>
               
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr class="bg-gradient-info text-white" >
                <td>Net Cash Flow</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>














            <!-- Add more rows as needed -->
        </tbody>
    </table>
    <!-- Cash Balances Section -->
<div class="row">
    <div class="col-md-6 text-dark">
        <p><strong>Opening Cash Balance:</strong> 
            
            <?php
            $num = $data['opening_balance'] ;
            $n = number_format($num, 2, '.', ',');
            echo ' R ' . $n;
        ?>
            
          </p>
        <p><strong>Closing Cash Balance:</strong>
            <?php
            $num =$data['closing_balance'] ;
            $n = number_format($num, 2, '.', ',');
            echo ' R ' . $n;
        ?>
          
           </p>
           @if(($data['opening_balance'] - $data['closing_balance']) >0)
        <p class="text-info" ><strong>Net Balance:</strong>
            <?php
            $num =$data['opening_balance'] - $data['closing_balance'];
            $n = number_format($num, 2, '.', ',');
            echo ' R ' . $n;
        ?>
            
            
            </p>
            @else
            <p class="text-danger" ><strong>Net Balance:</strong>
                <?php
                $num =$data['opening_balance'] - $data['closing_balance'];
                $n = number_format($num, 2, '.', ',');
                echo ' R ' . $n;
            ?>
                
                
                </p>
                @endif

    </div>
</div>

   
</div>
@endsection
