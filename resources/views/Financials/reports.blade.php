
@extends('layouts.Nav')


@section('content')
<style>

@media print {
  header, nav, footer, .other-elements-to-hide {
    display: none !important;
  }
}
</style>


<div class="container-flud">
    
    <h3 class="text-center bg-gradient-info shadow-primary border-radius-lg py-3 pe-1 text-white "> BF : Income vs. Expenses Report</h3>
      <div class="col-sm-12 col-md-12 col-lg-12">
        @if(Session::has("success"))
        {{ Session::get("success") }}
        @endif
        <div style="align-items: right;" class=" align-item-end btn btn-diabled bg-gradient-success shadow-primary border-radius-lg text-bold text-border   ">Report Owner :  System Admin</div>
      
        <div class="container-flud  text-dark">
           
  
            <div class="table-responsive col-sm-12 col-xs-12 col-md-12 col-lg-12 ">
                <!-- Button trigger modal -->
                <table class="table table-hover table-striped table-responsive ">
                    <thead class="shadow-primary bg-gradient-info text-white">
                        <tr class="text-right">
                   
                            <th>Months</th>
                            <th></th>
                            <th class="text-center">{{$month3}}</th>
                            <th>{{$month2}}</th>
                            <th>{{$month1}}</th>
                            <!-- Add more month headers here -->
                            <th  >Grand Total</th>
                        </tr>
                    </thead>
                    <tbody style="border-style: groove;" class=" border-radius-2g py-3 pe-1 shadow-dark">
                        <tr>
                         
                            <td><b></b></td>
                            <td colspan="5" ></td>

                        </tr>
                        <tr class="bg-gradient-dark text-white" >
                         
                            <td><b>Category - Income</b></td>
                            <td colspan="5" ></td>

                        </tr>
                        @php
                        $totalMonth2=0;
                        $totalMonth1 =0 ;
                        $totalMonth0=0;
                        $totalGrand=0;



                        @endphp
                        @foreach($report as $key=> $income)
                        @if($income['income_current_Balance']>0)
                        <tr class="text-dark text-bold " >
                            <td class="text-dark text-bold ">  {{ $income['Income_description'] }}</td>
                            <td><b></b></td>
                            <div style="text-align: justify;">
                                <td class="text-center"><b>
                                    <?php
                                    $num = $income['income_month_2_total'] ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?> 
                                    
                                    
                                 </b></td>
                                <td><b>
                                    <?php
                                    $num = $income['income_month_1_total'] ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?> </b></td>
                                <td><b>
                                    <?php
                                    $num =  $income['income_current_month_total'] ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?>
                                    
                                   </b></td>
                            </div>
                            <td><b>
                                <?php
                                $num = $income['income_current_Balance'] ;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                            ?>
                                
                                
                                </b></td>
                        </tr>
                        @php
                        $totalMonth2+=$income['income_month_2_total'];
                        $totalMonth1 += $income['income_month_1_total'];
                        $totalMonth0 +=$income['income_current_month_total'];
                        $totalGrand +=$income['income_current_Balance'];



                        @endphp
                        @endif
                        @endforeach
                     
                      
                        <tr>
                         
                            <td><b></b></td>
                            <td colspan="5" ></td>

                        </tr>
                        <tr class="shadow-primary bg-gradient-dark text-white " >
                          
                            <td><b>Grand Total</b></td>
                            
                            <td><b></b></td>
                            <div style="text-align: justify;" >
                                <td class="text-center"><b>    <?php
                                    $num = $totalMonth2 ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?>
                                    </b></td>
                                <td><b> <?php
                                    $num = $totalMonth1 ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?></b></td>
                                <td><b> <?php
                                    $num = $totalMonth0 ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?></b></td>
                            
                            </div>
                            <td><b> <?php
                                $num = $totalGrand ;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                            ?></b></td>

                        </tr>

                        <tr>
                         
                            <td><b></b></td>
                            <td colspan="5" ></td>

                        </tr>
                        <tr class="bg-gradient-dark text-white" >
                         
                            <td><b>Category - Expenses</b></td>
                            <td colspan="5" ></td>

                        </tr>
                        @php
                        $totalMonths2=0;
                        $totalMonths1 =0 ;
                        $totalMonths0=0;
                        $totalGrands=0;



                        @endphp
                        @foreach($report as $key=> $expense)
                        @if($expense['expense_current_Balance']>0)
                        <tr class=" text-bold " >
                            <td class="text-dark text-bold ">  {{ $expense['Expense_description'] }}</td>
                            <td><b></b></td>
                            <div style="text-align: justify;">
                                <td class="text-center"><b>
                                    <?php
                                    $num = $expense['expense_month_2_total'] ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?> 
                                    
                                    
                                 </b></td>
                                <td><b>
                                    <?php
                                    $num = $expense['expense_month_1_total'] ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?> </b></td>
                                <td><b>
                                    <?php
                                    $num =  $expense['expense_current_month_total'] ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?>
                                    
                                   </b></td>
                            </div>
                            <td><b>
                                <?php
                                $num = $expense['expense_current_Balance'] ;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                            ?>
                                
                                
                                </b></td>
                        </tr>
                        @php
                        $totalMonths2+=$expense['expense_month_2_total'];
                        $totalMonths1 += $expense['expense_month_1_total'];
                        $totalMonths0 +=$expense['expense_current_month_total'];
                        $totalGrands +=$expense['expense_current_Balance'];



                        @endphp
                        @endif
                        @endforeach
                      
                        <tr>
                         
                            <td><b></b></td>
                            <td colspan="5" ></td>

                        </tr>
                        <tr class="shadow-primary bg-gradient-dark text-white " >                          
                            <td class="text-white"><b>Grand Total</b></td>
                            
                            <td><b></b></td>
                            <div class="text-white" style="text-align: justify;" >
                                <td class="text-center text-white"><b>    <?php
                                    $num = $totalMonths2 ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?>
                                    </b></td>
                                <td class="text-white"><b> <?php
                                    $num = $totalMonths1 ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?></b></td>
                                <td class="text-white"><b> <?php
                                    $num = $totalMonths0 ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?></b></td>
                            
                            </div>
                            <td class="text-white"><b> <?php
                                $num = $totalGrands ;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                            ?></b></td>

                        </tr>

                        <tr>
                         
                            <td><b></b></td>
                            <td colspan="5" ></td>

                        </tr>
                        <tr class=" bg-gradient-info text-white" >
                          
                            <td class="text-white"><b>Net  Total</b></td>
                            
                            <td><b></b></td>
                            <div style="text-align: justify;" >
                                <td class="text-center text-white" ><b> <?php
                                    $num = $totalMonth2 - $totalMonths2 ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?></b></td>
                                <td class="text-white" ><b><?php
                                    $num = $totalMonth1 - $totalMonths1 ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?></b></td>
                                <td class="text-white"><b><?php
                                    $num = $totalMonth0 - $totalMonths0 ;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                ?></b></td>
                            
                            </div>
                            <td class="text-white"><b><?php
                                $num = $totalGrand - $totalGrands ;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                            ?></b></td>

                        </tr>
                      
                    </tbody>
                </table>

                <div style="align-items: right;" class=" align-item-end   "><button id="printReportButton" class="  btn bg-gradient-success shadow-primary border-radius-lg text-bold text-border   " >Print Report</button></div>


            </div>


        </div>
      </div>
   
</div>



@endsection
