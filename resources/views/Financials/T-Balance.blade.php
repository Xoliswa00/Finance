@extends('layouts.Nav')
<style>
    .t-account {
      display: flex;
    }
    .debit-column, .credit-column {
      flex: 1;
      border: 1px solid #000;
      padding: 20px;
    }
    .debit-column {
      border-right: 1px solid #000;
    }
  </style>

@section('content')
<div class="container my-auto">


   
                    <div
                        class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1"
                    >
                        <h2
                            class="text-white font-weight-bolder text-center "
                        >
                        {{$account->category}} Balanace
                        </h2>
                    </div>
                    <br>

               @php
               $dr=0;
               $cr=0;
               $crcd=0;
               $crbd=0;
               $drcd=0;
               $drbd=0;
               $drr=0;
               $crr=0;


               $balancse=0;
               @endphp
               @foreach($result as $transaction)
               @if($transaction->Effect=="Dr")
               @php
               $dr +=$transaction->Amount;
               @endphp
               @elseif($transaction->Effect=="Cr")
               @php
               $cr +=$transaction->Amount;
               @endphp
               @endif


               @endforeach
               @php
               if($dr>$cr){
                $balances=$dr;
                $crcd=$dr-$cr;
                $drbd=$crcd;
               }else{
                $balances =$cr;
                $drcd=$cr-$dr;
                $crbd=$drcd;
               }


               @endphp

    <div class="row ">
        <div class="col-md-6  debit-column">
            <table class="table debit-column">
                <thead>
                    <tr class="bg-gradient-success text-white">
                        <th>Dr</th>
                        <th></th>
                        <th></th>
                        <th></th>
                      
                    </tr>
                    <tr class=" shadow-primary border-radius-lg text-justify text-dark" >
                        <th  >Date</th>
                        <th>Source</th>
                        <th>Description</th>
                        <th>Amount</th>
                      
                    </tr>
                </thead>
                <tbody >
                    <!-- Display debit (Dr) transactions -->
                    @foreach($result as $transaction)
                        @if($transaction->Effect=="Dr")
                            <tr class="text-justify">
                                <td >{{$transaction->bill_date}}</td>
                                <td >{{$transaction->Action}}</td>
                                <td >{{$transaction->Description}}</td>
                                <td>@php
                                    $num =$transaction->Amount;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                  @endphp
                                    
                                  </td>
                            </tr>

                            @php
                          
                            $drr +=$transaction->Amount;
                            @endphp
                        @endif
                    @endforeach
                    @if($drcd <>0)
                    <tr>
                        <th></th>
                        <th>Balance</th>
                        <th>c/d</th>
                        <th >@php
                            $num =$drcd;
                            $n = number_format($num, 2, '.', ',');
                            echo ' R ' . $n;
                          @endphp</th>
                    </tr>
                    @endif
                    <tr style="border: double;">
                      
                        <th></th>
                        <th></th>
                        <th></th>
                        <th >@php
                            $num =$balances;
                            $n = number_format($num, 2, '.', ',');
                            echo ' R ' . $n;
                          @endphp</th>
                    </tr>
                  @if($drbd <> 0)
                    <tr style="border: solid;">
                      
                        <th> {{$account->updated_at}}</th>
                        <th>Balance</th>
                        <th>b/d</th>
                        <th >@php
                            $num =$drbd;
                            $n = number_format($num, 2, '.', ',');
                            echo ' R ' . $n;
                          @endphp</th>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-6 credit-column ">
            <table class="table table-striped">
                <thead>
                    <tr class="bg-gradient-success text-white ">
                      
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Cr</th>
                    </tr>
                    <tr class=" shadow-primary border-radius-lg text-justify text-dark" >
                        <th>Date</th>
                        <th>Source</th>
                        <th>Description</th>
                        <th>Amount</th>
                     
                    </tr>
                </thead>
                <tbody >
                    <!-- Display credit (Cr) transactions -->
                    @foreach($result as $transaction)
                        @if($transaction->Effect=="Cr")
                            <tr>
                                <td>{{$transaction->bill_date}}</td>
                                <td>{{$transaction->Action}}</td>
                                <td>{{$transaction->Description}}</td>
                                <td>@php
                                    $num =$transaction->Amount;
                                    $n = number_format($num, 2, '.', ',');
                                    echo ' R ' . $n;
                                  @endphp</td>
                            </tr>
                            @php
                           
                            $crr +=$transaction->Amount;
                            @endphp
                        @endif
                        
                    @endforeach
                   
                    @if($crcd <>0)
                    <tr>
                        <th></th>
                        <th>Balance</th>
                        <th>c/d</th>
                        <th >@php
                            $num =$crcd;
                            $n = number_format($num, 2, '.', ',');
                            echo ' R ' . $n;
                          @endphp</th>
                    </tr>
                    @endif
                    <tr style="border: double;">
                      
                        <th></th>
                        <th></th>
                        <th></th>
                        <th >@php
                            $num =$balances;
                            $n = number_format($num, 2, '.', ',');
                            echo ' R ' . $n;
                          @endphp</th>
                    </tr>
                  @if($crbd <>0)
                    <tr style="border: solid;">
                      
                        <th> {{$account->updated_at}}</th>
                        <th></th>
                        <th>Balance</th>
                        <th >@php
                            $num =$crbd;
                            $n = number_format($num, 2, '.', ',');
                            echo ' R ' . $n;
                          @endphp</th>
                    </tr>
                    @endif



                </tbody>
            </table>
        </div>
    </div>


</div>







@endsection
