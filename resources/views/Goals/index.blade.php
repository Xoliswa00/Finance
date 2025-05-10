@extends('layouts.Nav')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                        <h2 class="text-white text-uppercase text-center">Financial Goals</h2>
                    </div>
                    <br>
                    <a class="btn bg-gradient-success mb-0 font-weight-bolder opacity-7 " href="{{ route('goals.create') }}"><i class="material-icons text-lg">add</i>&nbsp;&nbsp;Make a new Goal</a>
                    <a class="btn bg-gradient-success mb-0 font-weight-bolder opacity-7 " href="{{ route('goals.Balance') }}"><i class="material-icons text-lg">money</i>&nbsp;&nbsp;Update Balance</a>
                </div>
                <div class="card-body px-0 pb-2">

                 
                    <div class="table-responsive p-0">
                        <table class="table table-responsive align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-dark font-weight-bolder opacity-7">Goal Name</th>
                                    <th class="text-uppercase text-dark font-weight-bolder opacity-7 ps-2">Goal Type</th>
                                    <th class="text-center text-uppercase text-dark font-weight-bolder opacity-7">Goal Target</th>
                                    <th class="text-center text-uppercase text-dark font-weight-bolder opacity-7">Current Balance</th>
                                    <th class="text-center text-uppercase text-dark font-weight-bolder opacity-7">Complete Date</th>
                                    <th class="text-center text-uppercase text-dark font-weight-bolder opacity-7">Goal Status</th>
                                    <th class="text-dark opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($goals as $goal)
                              


                                @if( $goal->goal_category=="Repayment")
                                <tr class="font-weight-bold text-danger mb-0">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 ">{{ $goal->title }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="font-weight-bold mb-0">{{ $goal->goal_category }}</p>
                                    </td>
                                    <td class="align-middle  text-center">
                                        <p class="font-weight-bold text-danger mb-0">
                                            <?php
                                                $num = $goal->target_amount;
                                                $n = number_format($num, 2, '.', ',');
                                                echo ' ZAR ' . $n;
                                            ?>
                                        </p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0">
                                            <?php
                                                $num = $goal->current_amount;
                                                $n = number_format($num, 2, '.', ',');
                                                echo ' ZAR ' . $n;
                                            ?>
                                        </p>
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ $goal->end_date }}
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($goal->target_amount >= ($goal->current_amount)*-1)
                                        <span class="badge badge-sm bg-gradient-success">In-progress</span>
                                        @else
                                        <span class="badge badge-sm bg-gradient-info">Goal Achieved</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('goals.show', $goal->id) }}" method="POST" style="display: inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="badge badge-sm bg-gradient-secondary">Milestones</button>
                                        </form>
                                        <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-sm bg-gradient-danger" onclick="return confirm('Are you sure you want to delete this goal?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                @else
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 ">{{ $goal->title }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="font-weight-bold mb-0">{{ $goal->goal_category }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0">
                                            <?php
                                                $num = $goal->target_amount;
                                                $n = number_format($num, 2, '.', ',');
                                                echo '+ ZAR ' . $n;
                                            ?>
                                        </p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0">
                                            <?php
                                                $num = $goal->current_amount;
                                                $n = number_format($num, 2, '.', ',');
                                                echo '+ ZAR ' . $n;
                                            ?>
                                        </p>
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ $goal->end_date }}
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($goal->target_amount >= $goal->current_amount)
                                        <span class="badge badge-sm bg-gradient-success">In-progress</span>
                                        @else
                                        <span class="badge badge-sm bg-gradient-info">Goal Achieved</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('goals.show', $goal->id) }}" method="POST" style="display: inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="badge badge-sm bg-gradient-secondary">Milestones</button>
                                        </form>
                                        <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-sm bg-gradient-danger" onclick="return confirm('Are you sure you want to delete this goal?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                @endif
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
@endsection
