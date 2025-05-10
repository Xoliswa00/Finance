@extends('layouts.Nav')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

@section('content')
    <div class="container-fluid ">
        @if (session('success'))
        <div class="alert alert-success text-center text-white col-12" role="alert">
            {{ session('success') }}
        </div>
    @endif
        <div class="row">
            <h1 class="text-center bg-gradient-info text-white shadow-primary border-radius-lg py-3 pe-1">Master X Goals/ Events </h1>

            {{-- Create Master X Data --}}
            <div class="col-md-12 col-lg-6 col-sm-12">
                <div class="row">
                    <div class="card mb-3">
                        <div class="card-header" id="headingMasterX">
                            <div class="bg-gradient-primary shadow-info border-radius-lg py-3 pe-1">
                                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">
                                    Master
                                </h4>
                            </div>
                        </div>
                    
                        <div id="collapseMasterX" class="collapse navbar-collapse show" aria-labelledby="headingMasterX" data-parent="#accordion">
                            <div class="card-body">
                    
                                <div class="input-group row input-group-outline my-3">
                                    <label for="master_id" class="col-md-4 col-form-label text-md-end">{{ __('Master') }}</label>
                    
                                    <div class="col-md-6">
                                        <select id="master_id" form="section" class="form-control @error('master_id') is-invalid @enderror" name="master_id" required autocomplete="master_id" autofocus>
                                            <option value="">Select Master</option>
                                            <?php foreach ($master as $master) : ?>
                                            <option value="<?= $master['id'] ?>" data-budget="<?= $master['Budget'] ?>" data-Name="<?= $master['Name'] ?>" data-actual="<?= $master['Actual'] ?>">
                                                <?= $master['Name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                        </select>
                    
                                        @error('master_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="input-group row text-dark input-group-outline my-3">
                                    <label for="master_id" class="col-md-4 col-form-label text-md-end">{{ __('') }}</label>
                    
                                    <div class="col-md-6">
                                        <p> Total Budget : <strong id="budget"></strong> </p> 
                                        <p> Current Balance : <strong id="actual"></strong> </p> 
                                        <p> Remaining Balanace : <strong id="difference"></strong></p> 
                                       
      
                                   

                                        
                                    </div>
                                </div>
                    
                                

                               
                                
                    
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        // Function to format numbers with proper spacing for thousands
                        function formatNumberWithSpacing(number) {
                            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                        }
                    
                        document.getElementById('master_id').addEventListener('change', function () {
                            var selectedOption = this.options[this.selectedIndex];
                            var budget = parseFloat(selectedOption.getAttribute('data-budget'));
                            var actual = parseFloat(selectedOption.getAttribute('data-actual'));
                            var difference = budget-actual;
                    
                            // Display the amounts with proper spacing and South African Rand (ZAR) formatting
                            document.getElementById('budget').innerText = 'R ' + formatNumberWithSpacing(budget.toFixed(2));
                            document.getElementById('actual').innerText = 'R ' + formatNumberWithSpacing(actual.toFixed(2));
                            document.getElementById('difference').innerText = 'R ' + formatNumberWithSpacing(difference.toFixed(2));
                        });
                    </script>
                 
                    
                    

                    <br>


                    <div class="card mb-3 ">
                        <div class="card-header" id="headingMasterX">
                            <div
                        class="bg-gradient-danger shadow-primary border-radius-lg py-3 pe-1"
                    >
                        <h4
                            class="text-white font-weight-bolder text-center mt-2 mb-0"
                        >
                           Master' Section
                        </h4>
                    </div>
                        </div>
        
                        <div id="collapseMasterX" class=" collapse  navbar-collapse show" aria-labelledby="headingMasterX" data-parent="#accordion">
                            <div class="card-body">
                                <form action="{{ route('x_items.store') }}" id="section"method="POST">
                                    @csrf


                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Sections" class="col-md-4 col-form-label text-md-end">{{ __(' Section Name') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="Section" type="text" class="form-control @error('Section') is-invalid @enderror" name="Section" value="{{ old('Section') }}" required autocomplete="section" autofocus>
            
                                            @error('Section')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Description" class="col-md-4 col-form-label text-md-end">{{ __(' Description') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="Description" type="text" class="form-control @error('description') is-invalid @enderror" name="Description" value="{{ old('description') }}" required autocomplete="Description" autofocus>
            
                                            @error('Description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>



                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Nature" class="col-md-4 col-form-label text-md-end">{{ __('Nature ') }}</label>
            
                                        <div class="col-md-6">
                                            <select  id="Nature" class="form-control @error('Nature') is-invalid @enderror" name="Nature" required autocomplete="Nature" autofocus >
                                                <option value="">Select a nature</option>
                                                @foreach($natures as $nature)
                                                    <option value="{{ $nature->Nature }}" >{{ $nature->Nature }}</option>
                                                @endforeach
                                            </select>



                                            @error('Nature')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>

                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Budget" class="col-md-4 col-form-label text-md-end">{{ __('Budget Amount') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="Budget" type="number" class="form-control @error('Budget') is-invalid @enderror" name="Budget" value="{{ old('Budget') }}" required autocomplete="budget" autofocus>
            
                                            @error('Budget')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Start_date" class="col-md-4 col-form-label text-md-end">{{ __('Start Date') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="Start_date" type="date" class="form-control @error('Start_date') is-invalid @enderror" name="Start_date" value="{{ old('Start_date') }}" required autocomplete="Start_date" autofocus>
            
                                            @error('Start_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="input-group row input-group-outline my-3">
                                        <label for="end_date" class="col-md-4 col-form-label text-md-end">{{ __('End Date') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" required autocomplete="end_date" autofocus>
            
                                            @error('end_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>




                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Status" class="col-md-4 col-form-label text-md-end">{{ __('Section Status') }}</label>
            
                                        <div class="col-md-6">
                                            <select  id="Status" class="form-control @error('Status') is-invalid @enderror" name="Status" required autocomplete="Status" autofocus >
                                                <option value="Not Started">Not Started</option>
                                                <option value="Delayed">Delayed</option>
                                                <option value="In-Progress">In-Progress</option>
                                                <option value="Completed">Completed</option>
                                            </select>



                                            @error('Status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="input-group row input-group-outline my-3">
                                        <label for="Progress" class="col-md-4 col-form-label text-md-end">{{ __('Progress Status') }}</label>
            
                                        <div class="col-md-6">
                                            <select  id="Progress" class="form-control @error('Progress') is-invalid @enderror" name="Progress" required autocomplete="Progress" autofocus >
                                                <option value="5">5 % completed</option>
                                                <option value="10">10 % completed</option>
                                                <option value="25">25 % completed</option>
                                                <option value="45">45 % completed</option>
                                                <option value="50">50 % completed</option>
                                                <option value="75">75 % completed</option>
                                                <option value="85">85 % completed</option>
                                                <option value="95">95 % completed</option>
                                                <option value="100">100 % completed</option>


                                            </select>



                                            @error('Progress')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>


                                   
                                    
                        
                                    <button class="btn btn-primary " type="submit">Create Section</button>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>

                
            </div>

            <div class="col-md-12 col-lg-6 col-sm-12">

                <section data-bs-version="5.1" class=" shadow-danger content16 cid-tSlafClOWQ text-center" id="content16-r">
                    <div class="container">
                        <div class="row text-center text-dark">
                            <div class="col-12 col-md-12">
                                <div class=" card-header  align-center mb-2">
                                    <h3 class="  mb-0 mbr-fonts-style display-2">
                                        <strong> Sections Preview</strong>
                                    </h3>
                                    
                                </div>
                                <div id="bootstrap-accordion_22" class="panel-group accordionStyles accordion" role="tablist" aria-multiselectable="true">


                                    @foreach($masters as $goal)
                                    <div class="card mb-3 shadow-warning  text-center ">
                                        <div class="card-header bg-gradient-dark  py-3 pe-1" role="tab" id="headingOne">
                                            <a role="button" class="panel-title collapsed" data-toggle="collapse" data-bs-toggle="collapse" data-core="" href="#collapses{{$goal->id}}_22" aria-expanded="false" aria-controls="collapses{{$goal->id}}">
                                                <h5 style="text-align: center;" class=" text-right text-white  "><p> </p> {{$goal->Name}}  </h5> <br>
                                               
                                                <span class="sign mbr-iconfont mbri-arrow-down"></span>
                                            </a>
                                        </div>
                                        <div id="collapses{{$goal->id}}_22" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" data-bs-parent="#bootstrap-accordion_22">
                                            <div class="panel-body">
                                                @foreach($Section as $section)
                                                @if($section->Master == $goal->id )  
                                                
                                                      <div class="card-header" id="headingMasterX">
                                                        <div class="bg-gradient-info shadow-danger border-radius-lg py-3 pe-1">
                                                            <h5 class="text-white font-weight-bolder text-center mt-2 mb-0">
                                                                {{$section->Section}} <br>  Remaining Balance  @php
                                                        $num =$section->Budget - $section->Actual;
                                                        $n = number_format($num, 2, '.', ',');
                                                        echo ' R ' . $n;
                                                      @endphp
                                                            </h5>
                                                        </div>
                                                    </div>
                                              
                                                
                                                @endif
                                                @endforeach


                                                <div class="container">
                                                    @foreach($balance as $balances)
                                                    @if($balances->Master == $goal->id )
                                                    <p>
                                                        Total Sections Budget : @php
                                                        
                                                            $num =$balances->Budget ;
                                                            $n = number_format($num, 2, '.', ',');
                                                            echo ' R ' . $n;
                                                      @endphp
                                                    
                                                    </p>
                                                    <br>

                                                    <p>
                                                        Total Sections Actual : @php
                                                        
                                                            $num = $balances->Actual ;
                                                            $n = number_format($num, 2, '.', ',');
                                                            echo ' R ' . $n;
    
                                                        
                                                       
                                                      @endphp
                                                    
                                                    </p>
                                                   
                                                    
                                                    
                                                    <br> <p>  Remaining Balance @php
                                                 
                                                        $num =$balances->Budget - $balances->Actual ;
                                                        $n = number_format($num, 2, '.', ',');
                                                        echo ' R ' . $n;
                                                  @endphp  </p>
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
                </section>
            </div>
          

          


         </div>
    </div>

    <script>
        function myFunction(id) {
          var x = document.getElementById(id);
          if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
          } else { 
            x.className = x.className.replace(" w3-show", "");
          }
        }
        </script>
        
@endsection