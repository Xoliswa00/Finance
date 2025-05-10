@extends('layouts.Nav')

@section('content')
<div class="container-fluid center py-4 ">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-title bg-gradient shadow-info  text-center py-3 pe-1">
                    <h3>Set Financial Goals and Achieve Financial Success</h3>
                
                </div>
                <div class="card-body text-dark">
             
                    <h3 style="text-decoration-line: underline;" class="text-center">Take control of your finances and secure your future with SMART goals. It starts with you! </h3>
                    <br>

                    <ul class="card-list">
                        <li>
                                <div class="card-header bg-gradient shadow-success"><h4>Emergency Fund</h4></div><br>
                                <div class="card-description ">Save a specific amount of money to cover unexpected expenses or financial emergencies.</div>
                                <ul class="card-details">
                                    <li>Ensure peace of mind and financial security.</li>
                                    <li>Build a safety net for unexpected circumstances.</li>
                                    <li>Have funds readily available for emergencies.</li>
                                </ul>
                        </li>
                        <br>
                        <li>
                                <div class="card-header bg-gradient shadow-danger "> <h4>  Debt Repayment </h4></div>
                                <br>

                                <div class="card-description">Pay off outstanding debts, such as credit card debt, student loans, or personal loans.</div>
                                <ul class="card-details">
                                    <li>Eliminate high-interest debt and improve financial health.</li>
                                    <li>Reduce financial stress and achieve financial freedom.</li>
                                    <li>Create a solid foundation for future financial endeavors.</li>
                                </ul>
                            
                        </li>
                        <br>
                        <li>
                                <div class="card-header  bg-gradient shadow-primary"><h4> Retirement Savings </h4> </div>
                                <br>
                                <div class="card-description">Build a retirement fund to ensure a financially secure retirement.</div>
                                <ul class="card-details">
                                    <li>Enjoy a comfortable and worry-free retirement.</li>
                                    <li>Accumulate enough savings to maintain your desired lifestyle.</li>
                                    <li>Take advantage of compounding interest and long-term investment growth.</li>
                                </ul>
                        </li>
                    </ul>
                    <!-- Add more goal cards for different financial goals -->
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <h2>Take Control of Your Financial Future</h2>
                        <h5>Start setting your own SMART financial goals today and unlock a world of opportunities!</h5>
                        <div class="cta-button">
                            <a href="{{ route('goals.create') }}" class="btn bg-gradient-success">Create your goal!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
