@extends('layouts.Nav')

@section('content')
<div class="container-fluid">
    <h1 class="text-center bg-gradient-info shadow-primary border-radius-lg py-3 pe-1 text-white">3 Months Financial Position</h1>

    <!-- Company information section -->
    <div class="row">
        <div class="col-md-6 text-dark">
            <!-- Add your company information here -->
            <p><strong>Company Name:</strong> ABC Company</p>
            <p><strong>Report Date:</strong> {{$currentMonth}}</p>
        </div>
    </div>
  

    <!-- Balance Sheet -->
    <table class="table table-hover table-responsive">
        <thead>
            <tr class="bg-gradient-info shadow-danger text-white text-right">
            <td></td>
                <th>Category</th>
                @foreach ($totalBalances as $monthYear => $total)
                <th>{{ $monthYear }}</th>
            @endforeach
             <th>Grand Balance</th>
            </tr>
        </thead>
        
        <tbody>
            <!-- Assets -->
            <tr class=" text-dark">
                <td><strong> Assets</strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

              <!-- Non Current Assets -->
           
            <tr class="shadow-info">
                <td>Non-Current Assets</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
            @php
            $natureTotal = []; // Store monthly totals for each nature
            @endphp



            @foreach($balances as $Assets)
            @if($Assets->Nature == "Non-Current Assets")
            @foreach ($accountBalances as $accountName => $balanceData)
            @php
            $nature = $balanceData['Nature'];
            @endphp
         
              @if($accountName==$Assets->category)
                <tr  class=" text-right text-dark">
                  <td></td>
                  <td>   <form action="{{ route('T-Balance',$Assets->id )}}"  method="get"  >
                      @csrf
                    
                      <button type="submit"   class="btn btn-link text-info text-gradient px-3 mb-0" href="javascript:;"> {{ $Assets->category}}</button>
      
                    </form>
                    
                    
                  </td>
                
          
     
                    @foreach ($totalBalances as $monthYear => $total)
                        <td>
                            @if (isset($balanceData['Balances'][$monthYear]))
                                        @php
                                    $num =$balanceData['Balances'][$monthYear];
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                  @endphp
                        
                              
                            @else
                                @php
                                $num =0;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                              @endphp
                            @endif


                        @php
                        $natureTotal[$nature][$monthYear] = ($natureTotal[$nature][$monthYear] ?? 0) + ($balanceData['Balances'][$monthYear] ?? 0);
                        @endphp  
                        </td>                               
                    @endforeach
                    <td> @php
                      $num =array_sum($balanceData['Balances']);
                      $n = number_format($num, 2, '.', ',');
                      echo ' R ' . $n;
                    @endphp
                      
                      
                    </td>
                </tr>
            
   
              @endif
            

          @endforeach
          <tr  class=" text-center">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
          </tr>

        @endif
    @endforeach

    
      @foreach ($natureTotal as $nature => $totalData)
        <tr class="bg-gradient-dark text-white">
            <td>{{ $nature }}</td>
            <td>Total for {{ $nature }} </td>
            @foreach ($totalBalances as $monthYear => $total)
                <td> @php
                  $num =$totalData[$monthYear];
                  $n = number_format($num, 2, '.', ',');
                  echo ' R ' . $n;
                @endphp
                  
                  
                  
                  </td>
            
            @endforeach
            <td></td>
        </tr>
  
       @endforeach

          
            <tr  class=" text-center">

                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <!-- Current Assets -->
            <tr class="shadow-info">
                            <td>Current Assets</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @php
                        $natureTotal = []; // Store monthly totals for each nature
                        @endphp
            @foreach($balances as $Assets)

            @if($Assets->Nature == "Current Assets")
            @foreach ($accountBalances as $accountName => $balanceData)
            @php
            $nature = $balanceData['Nature'];
            @endphp
         
              @if($accountName==$Assets->category)
                <tr  class=" text-right text-dark">
                  <td></td>
                  <td>   <form action="{{ route('T-Balance',$Assets->id )}}"  method="get"  >
                      @csrf
                    
                      <button type="submit"   class="btn btn-link text-info text-gradient px-3 mb-0" href="javascript:;"> {{ $Assets->category}}</button>
      
                    </form>
                    
                    
                  </td>
                
          
     
                    @foreach ($totalBalances as $monthYear => $total)
                        <td>
                            @if (isset($balanceData['Balances'][$monthYear]))
                                        @php
                                    $num =$balanceData['Balances'][$monthYear];
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                  @endphp
                        
                              
                            @else
                                @php
                                $num =0;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                              @endphp
                            @endif


                        @php
                        $natureTotal[$nature][$monthYear] = ($natureTotal[$nature][$monthYear] ?? 0) + ($balanceData['Balances'][$monthYear] ?? 0);
                        @endphp  
                        </td>                               
                    @endforeach
                    <td> @php
                      $num =array_sum($balanceData['Balances']);
                      $n = number_format($num, 2, '.', ',');
                      echo ' R ' . $n;
                    @endphp
                      
                      
                    </td>
                </tr>
            
   
              @endif
            

          @endforeach
          <tr  class=" text-center">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
          </tr>

        @endif
    @endforeach

    
      @foreach ($natureTotal as $nature => $totalData)
        <tr class="bg-gradient-dark text-white">
            <td>{{ $nature }}</td>
            <td>Total for {{ $nature }} </td>
            @foreach ($totalBalances as $monthYear => $total)
                <td> @php
                  $num =$totalData[$monthYear];
                  $n = number_format($num, 2, '.', ',');
                  echo ' R ' . $n;
                @endphp
                  
                  
                  
                  </td>
            
            @endforeach
            <td></td>
        </tr>
  
       @endforeach
           
            <!-- Add more asset items as needed -->

            <!-- Liabilities -->
       
            <tr  class=" text-center">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr class=" text-dark">
                <td><strong> Equity and Liabilities</strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            
            </tr>
              <!-- Equity -->
              <tr class="shadow-dark text-dark">
                
                <td>Equity</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            

            </tr>
            @php
            $natureTotal = []; // Store monthly totals for each nature
            @endphp
            @foreach($balances as $equity)
            @if($equity->Nature == "Capital" or $equity->Nature == "Drawings" )
            @foreach ($accountBalances as $accountName => $balanceData)
            @php
            $nature = $balanceData['Nature'];
            @endphp
         
              @if($accountName==$equity->category)
                <tr  class=" text-right text-dark">
                  <td></td>
                  <td>   <form action="{{ route('T-Balance',$equity->id )}}"  method="get"  >
                      @csrf
                    
                      <button type="submit"   class="btn btn-link text-info text-gradient px-3 mb-0" href="javascript:;"> {{ $equity->category}}</button>
      
                    </form>
                    
                    
                  </td>
                
          
     
                    @foreach ($totalBalances as $monthYear => $total)
                        <td>
                            @if (isset($balanceData['Balances'][$monthYear]))
                                        @php
                                    $num =$balanceData['Balances'][$monthYear];
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                  @endphp
                        
                              
                            @else
                                @php
                                $num =0;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                              @endphp
                            @endif


                        @php
                        $natureTotal[$nature][$monthYear] = ($natureTotal[$nature][$monthYear] ?? 0) + ($balanceData['Balances'][$monthYear] ?? 0);
                        @endphp  
                        </td>                               
                    @endforeach
                    <td> @php
                      $num =array_sum($balanceData['Balances']);
                      $n = number_format($num, 2, '.', ',');
                      echo ' R ' . $n;
                    @endphp
                      
                      
                    </td>
                </tr>
            
   
              @endif
            

          @endforeach
          <tr  class=" text-center">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
          </tr>

        @endif
    @endforeach

    
      @foreach ($natureTotal as $nature => $totalData)
        <tr class="bg-gradient-dark text-white">
            <td>{{ $nature }}</td>
            <td>Total for {{ $nature }} </td>
            @foreach ($totalBalances as $monthYear => $total)
                <td> @php
                  $num =$totalData[$monthYear];
                  $n = number_format($num, 2, '.', ',');
                  echo ' R ' . $n;
                @endphp
                  
                  
                  
                  </td>
            
            @endforeach
            <td></td>
        </tr>
  
       @endforeach

         
          
          <br>
            <!-- Add more liability items as needed -->
               <!--Liability  -->
               <tr class=" text-dark">
                <td> <strong>Liability </strong> </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

              <!-- Non Current Liability  -->
            <tr class="shadow-dark">
                <td>Non-Current Liability</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
            @php
            $natureTotal = []; // Store monthly totals for each nature
            @endphp
            @foreach($balances as $equity)
            @if($equity->Nature == "Non-Current Liabilities" )
            @foreach ($accountBalances as $accountName => $balanceData)
            @php
            $nature = $balanceData['Nature'];
            @endphp
         
              @if($accountName==$equity->category)
                <tr  class=" text-right text-dark">
                  <td></td>
                  <td>   <form action="{{ route('T-Balance',$equity->id )}}"  method="get"  >
                      @csrf
                    
                      <button type="submit"   class="btn btn-link text-info text-gradient px-3 mb-0" href="javascript:;"> {{ $equity->category}}</button>
      
                    </form>
                    
                    
                  </td>
                
          
     
                    @foreach ($totalBalances as $monthYear => $total)
                        <td>
                            @if (isset($balanceData['Balances'][$monthYear]))
                                        @php
                                    $num =$balanceData['Balances'][$monthYear];
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                  @endphp
                        
                              
                            @else
                                @php
                                $num =0;
                                $n = number_format($num, 2, '.', ',');
                                echo ' R ' . $n;
                              @endphp
                            @endif


                        @php
                        $natureTotal[$nature][$monthYear] = ($natureTotal[$nature][$monthYear] ?? 0) + ($balanceData['Balances'][$monthYear] ?? 0);
                        @endphp  
                        </td>                               
                    @endforeach
                    <td> @php
                      $num =array_sum($balanceData['Balances']);
                      $n = number_format($num, 2, '.', ',');
                      echo ' R ' . $n;
                    @endphp
                      
                      
                    </td>
                </tr>
            
   
              @endif
            

          @endforeach
          <tr  class=" text-center">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
          </tr>

        @endif
    @endforeach

    
      @foreach ($natureTotal as $nature => $totalData)
        <tr class="bg-gradient-dark text-white">
            <td>{{ $nature }}</td>
            <td>Total for {{ $nature }} </td>
            @foreach ($totalBalances as $monthYear => $total)
                <td> @php
                  $num =$totalData[$monthYear];
                  $n = number_format($num, 2, '.', ',');
                  echo ' R ' . $n;
                @endphp
                  
                  
                  
                  </td>
            
            @endforeach
            <td></td>
        </tr>
  
       @endforeach
        

               <!-- Current Liability  -->
               <tr class="shadow-dark text-dark">
                <td>Current Liability</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
              @php
              $natureTotal = []; // Store monthly totals for each nature
              @endphp
            @foreach($balances as $equity)
              @if($equity->Nature == "Current Liabilities" )
                  @foreach ($accountBalances as $accountName => $balanceData)
                  @php
                  $nature = $balanceData['Nature'];
                  @endphp
               
                    @if($accountName==$equity->category)
                      <tr  class=" text-right text-dark">
                        <td></td>
                        <td>   <form action="{{ route('T-Balance',$equity->id )}}"  method="get"  >
                            @csrf
                          
                            <button type="submit"   class="btn btn-link text-info text-gradient px-3 mb-0" href="javascript:;"> {{ $equity->category}}</button>
            
                          </form>
                          
                          
                        </td>
                      
                
           
                          @foreach ($totalBalances as $monthYear => $total)
                              <td>
                                  @if (isset($balanceData['Balances'][$monthYear]))
                                              @php
                                          $num =$balanceData['Balances'][$monthYear];
                                          $n = number_format($num, 2, '.', ',');
                                          echo ' R ' . $n;
                                        @endphp
                              
                                    
                                  @else
                                      @php
                                      $num =0;
                                      $n = number_format($num, 2, '.', ',');
                                      echo ' R ' . $n;
                                    @endphp
                                  @endif


                              @php
                              $natureTotal[$nature][$monthYear] = ($natureTotal[$nature][$monthYear] ?? 0) + ($balanceData['Balances'][$monthYear] ?? 0);
                              @endphp  
                              </td>                               
                          @endforeach
                          <td> @php
                            $num =array_sum($balanceData['Balances']);
                            $n = number_format($num, 2, '.', ',');
                            echo ' R ' . $n;
                          @endphp
                            
                            
                          </td>
                      </tr>
                  
         
                    @endif
                  

                @endforeach
                <tr  class=" text-center">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
    
              @endif
          @endforeach

          
            @foreach ($natureTotal as $nature => $totalData)
              <tr class="bg-gradient-dark text-white">
                  <td>{{ $nature }}</td>
                  <td>Total for {{ $nature }} </td>
                  @foreach ($totalBalances as $monthYear => $total)
                      <td> @php
                        $num =$totalData[$monthYear];
                        $n = number_format($num, 2, '.', ',');
                        echo ' R ' . $n;
                      @endphp
                        
                        
                        
                        </td>
                  
                  @endforeach
                  <td></td>
              </tr>
        
             @endforeach
     


           
        </tbody>
    </table>

  
</div>
@endsection
