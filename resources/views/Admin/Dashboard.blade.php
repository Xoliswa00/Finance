@extends('layouts.Admin')
@section('content')
<div class="container-fluid  max-height-vh-100 h-100 border-radius-lg py-4">
    <div class="row">
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card  k">
          <div class="card-header bg-gradient-dark text-white p-3 pt-2">
            <div class="icon icon-xl icon-shape bg-gradient-danger shadow-dark text-center border-radius-x2 mt-n4 position-absolute">
              <i class="material-icons opacity-10">weekend</i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm  mb-0 text-capitalize">Weekly New People</p>
              <h4 class="mb-0 text-white">{{$newUsersThisWeek}}</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
            <p class="mb-0 "><span class="text-info text-sm font-weight-bolder">{{$weekChange}}%</span> than last week</p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-header bg-gradient-dark text-white p-3 pt-2">
            <div class="icon icon-xl icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-12">email</i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Email Usage</p>
              <h4 class="mb-0 text-white ">2,300</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month</p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-header bg-gradient-dark text-white p-3 pt-2">
            <div class="icon icon-xl icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10">facebook</i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Social Activity</p>
              <h4 class="mb-0 text-white ">3,462</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
            <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6">
        <div class="card">
          <div class="card-header bg-gradient-dark text-white p-3 pt-2">
            <div class="icon icon-xl icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10">people</i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Total Friends</p>
              <h4 class="mb-0 text-white ">{{$userCount}}</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
           
            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">{{$percentageChange}}%</span> than yesterday</p>
     
          </div>
        </div>
      </div>
    </div>
<br>
    <div class="row">
      <div class="col-lg-6 ol-md-6 col-sm-12">
        <div class="position-relative border-radius-xl overflow-hidden py-4 bg-gradient-dark shadow-lg  mb-7">
          <div class="container  border-bottom">
            <div class="row justify-space-between py-2">
              <div class="col-lg-3 col-md-3 me-auto">
               
              </div>
              <div class="col-lg-8 ">
                <div class="nav-wrapper position-relative end-0">
                  <ul class="nav nav-pills nav-fill flex-row p-1" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#preview-inputs-1" role="tab" aria-controls="preview" aria-selected="true">
                      <i class="fas fa-desktop text-sm me-2"></i> Users' Overview
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#code-inputs-1" role="tab" aria-controls="code" aria-selected="false">
                        <i class="fas fa-code text-dark text-sm me-2"></i> User Activity
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#code-inputs-2" role="tab" aria-controls="code" aria-selected="false">
                        <i class="fas fa-code text-sm me-2"></i> Predictions
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-content tab-space">
            <div class="tab-pane active" id="preview-inputs-1">
              <div class="z-index-2 ">
                <p class="card-header  text-white pt-1 mb-0"></p>
               <br>
                
                <div class="card-body p-3 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                  <div class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1">
                    <div class="chart">
                      <canvas id="userStatsChart" class="chart-canvas" height="170"></canvas>
                    </div>
                  </div>
                </div>
              </div>
             
              <script>
                var ctx = document.getElementById('userStatsChart').getContext("2d");
                var userStatsData = @json($userStatsByDay);
            
                new Chart(ctx, {
                  type: "bar",
                  data: {
                    labels: userStatsData.map(data => data.day_of_week),
                    datasets: [{
                      label: 'User Count',
                      data: userStatsData.map(data => data.user_count),
                      tension: 0.4,
                      borderWidth: 0,
                      borderRadius: 4,
                      borderSkipped: false,
                      backgroundColor: "rgba(255, 255, 255, .8)",
                     
                      maxBarThickness: 6
                    }, ],
                  },
                  options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                      legend: {
                        display: false,
                      }
                    },
                    interaction: {
                      intersect: false,
                      mode: 'index',
                    },
                    scales: {
                      y: {
                        grid: {
                          drawBorder: false,
                          display: true,
                          drawOnChartArea: true,
                          drawTicks: false,
                          borderDash: [5, 5],
                          color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                          suggestedMin: 0,
                          suggestedMax: 500,
                          beginAtZero: true,
                          padding: 10,
                          font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                          },
                          color: "#fff"
                        },
                      },
                      x: {
                        grid: {
                          drawBorder: false,
                          display: true,
                          drawOnChartArea: true,
                          drawTicks: false,
                          borderDash: [5, 5],
                          color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                          display: true,
                          color: '#f8f9fa',
                          padding: 10,
                          font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                          },
                        }
                      },
                    },
                  },
                });
            
            </script>
            </div>
            <div class="tab-pane " id="code-inputs-1">
              <div class="z-index-2 ">
                <p class="card-header  text-white pt-1 mb-0"></p>
               <br>
                
                <div class="card-body p-3 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                  <div class="bg-gradient-dark shadow-primary border-radius-lg py-3 pe-1">
                    <div class="chart">
                      <canvas id="activityCount" class="chart-canvas" height="170"></canvas>
                    </div>
                  </div>
                </div>
              </div>
             
              <script>
                // Get the canvas context
                var ctx = document.getElementById('activityCount').getContext('2d');
                
                // Assume you have a PHP variable $activityCounts containing the data
                var userStatsData = @json($activityCounts);
            
                // Create a new Chart instance for a line chart
                new Chart(ctx, {
                    type: 'line', // Change this to 'line'
                    data: {
                        labels: userStatsData.map(data => data.date),
                        datasets: [{
                            label: 'User Count Trend',
                            data: userStatsData.map(data => data.count),
                            tension: 0.8,
                            borderWidth: 5,
                            borderColor: 'rgba(75, 192, 192, 1)', // Adjust the color
                            pointRadius: 5, // Adjust the size of data points
                            pointBackgroundColor: 'rgba(75, 192, 192, 1)', // Adjust the color of data points
                            fill: false,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom', // Adjust the position of the legend
                            },
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5],
                                    color: 'rgba(255, 255, 255, .2)',
                                },
                                ticks: {
                                    suggestedMin: 0,
                                    beginAtZero: true,
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        weight: 300,
                                        family: 'Roboto',
                                        style: 'normal',
                                        lineHeight: 2,
                                    },
                                    color: '#fff',
                                },
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5],
                                    color: 'rgba(255, 255, 255, .2)',
                                },
                                ticks: {
                                    display: true,
                                    color: '#f8f9fa',
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        weight: 300,
                                        family: 'Roboto',
                                        style: 'normal',
                                        lineHeight: 2,
                                    },
                                },
                            },
                        },
                    },
                });
            </script>
            
            
            </div>
            
            <div class="tab-pane" id="code-inputs-2">
              <div class="position-relative p-4 pb-2">
                <a class="btn btn-sm bg-gradient-dark position-absolute end-4 mt-3" onclick="copyCode(this);" type="button"><i class="fas fa-copy text-sm me-1"></i> Copy</a>
       why not
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="position-relative border-radius-xl overflow-hidden py-4 bg-gradient-dark text-white shadow-lg  mb-7">
          <div class="container  border-bottom">
            <div class="row justify-space-between py-2">
              <div class="col-lg-3 col-md-3 me-auto">
                <h6 class="lead text-white pt-1 mb-0"></h6>
              </div>
              <div class="col-lg-6 col-md-6">
                <div class="nav-wrapper position-relative end-0">
                  <ul class="nav nav-pills nav-fill flex-row p-1" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#server" role="tab" aria-controls="preview" aria-selected="true">
                      <i class="fas fa-desktop text-sm me-2"></i> Server 
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#database" role="tab" aria-controls="code" aria-selected="false">
                        <i class="fas fa-code text-sm me-2"></i> Database
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#apis" role="tab" aria-controls="code" aria-selected="false">
                        <i class="fas fa-code text-sm me-2"></i> APIs
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-content tab-space">
            <div class="tab-pane active" id="server">
              <div class="position-relative p-4 pb-2">
                Server

              </div>


            </div>
          
            <div class="tab-pane" id="database">
              <div class="position-relative p-4 pb-2">
                <a class="btn btn-sm bg-gradient-dark position-absolute end-4 mt-3" onclick="copyCode(this);" type="button"><i class="fas fa-copy text-sm me-1"></i> Copy</a>
       Database
              </div>
            </div>
            <div class="tab-pane" id="apis">
              <div class="position-relative p-4 pb-2">
                <a class="btn btn-sm bg-gradient-dark position-absolute end-4 mt-3" onclick="copyCode(this);" type="button"><i class="fas fa-copy text-sm me-1"></i> Copy</a>
api              </div>
            </div>
          </div>
        </div>

      </div>
     


    </div>

    <br>
    <div class="row">
      <div class="col-lg-6 ol-md-6 col-sm-12">
        <div class="position-relative border-radius-xl overflow-hidden py-4 bg-gradient-dark shadow-lg  mb-7">
          <div class="container  border-bottom">
            <div class="row justify-space-between py-2">
              <div class="col-lg-3 col-md-3 me-auto">
               
              </div>
              <div class="col-lg-8 ">
                <div class="nav-wrapper position-relative end-0">
                  <ul class="nav nav-pills nav-fill flex-row p-1" role="tablist">
                   
                    <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#code-inputs-1" role="tab" aria-controls="code" aria-selected="false">
                        <i class="fas fa-code text-dark text-sm me-2"></i>Monitor </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#code-inputs-2" role="tab" aria-controls="code" aria-selected="false">
                        <i class="fas fa-code text-sm me-2"></i> Management
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-content tab-space">
            <div class="tab-pane active" id="Task-1">
              <div class="z-index-2 ">
                <p class="card-header  text-white pt-1 mb-0"></p>
               <br>
                
                <div class="card-body p-3 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                  <div class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1">
                    <div class="chart">
                      <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                    </div>
                  </div>
                </div>
              </div>
           
            </div>
            <div class="tab-pane" id="code-inputs-1">
              <div class="position-relative p-4 pb-2">
                <a class="btn btn-sm bg-gradient-dark position-absolute end-4 mt-3" onclick="copyCode(this);" type="button"><i class="fas fa-copy text-sm me-1"></i> Copy</a>
       
              </div>
            </div>
            <div class="tab-pane" id="code-inputs-2">
              <div class="position-relative p-4 pb-2">
                <a class="btn btn-sm bg-gradient-dark position-absolute end-4 mt-3" onclick="copyCode(this);" type="button"><i class="fas fa-copy text-sm me-1"></i> Copy</a>
       why not
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-6 ol-md-6 col-sm-12">
        <div class="position-relative border-radius-xl overflow-hidden py-4 bg-gradient-dark shadow-lg  mb-7">
          <div class="container  border-bottom">
            <div class="row justify-space-between py-2">
              <div class="col-lg-3 col-md-3 me-auto">
                <h6 class="lead text-white pt-1 mb-0">Calendar</h6>
              </div>
              <div class="col-lg-6 col-md-6">
                <div class="nav-wrapper position-relative end-0">
                  <ul class="nav nav-pills nav-fill flex-row p-1" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#calendar-1" role="tab" aria-controls="preview" aria-selected="true">
                      <i class="fas fa-desktop text-sm me-2"></i> Preview
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#code-inputs-1" role="tab" aria-controls="code" aria-selected="false">
                        <i class="fas fa-code text-sm me-2"></i> Code
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#code-inputs-2" role="tab" aria-controls="code" aria-selected="false">
                        <i class="fas fa-code text-sm me-2"></i> Code
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-content tab-space">
            
            </div>
            <div class="tab-pane text-white " id="code-inputs-1">
              <div class="position-relative p-4 pb-2">
                <div id='wrap'>

                  <div id='calendar'></div>
                  
                  <div style='clear:both'></div>
                  </div>
                  <script>

                    $(document).ready(function() {
                        var date = new Date();
                      var d = date.getDate();
                      var m = date.getMonth();
                      var y = date.getFullYear();
                  
                      /*  className colors
                  
                      className: default(transparent), important(red), chill(pink), success(green), info(blue)
                  
                      */
                  
                  
                      /* initialize the external events
                      -----------------------------------------------------------------*/
                  
                      $('#external-events div.external-event').each(function() {
                  
                        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                        // it doesn't need to have a start or end
                        var eventObject = {
                          title: $.trim($(this).text()) // use the element's text as the event title
                        };
                  
                        // store the Event Object in the DOM element so we can get to it later
                        $(this).data('eventObject', eventObject);
                  
                        // make the event draggable using jQuery UI
                        $(this).draggable({
                          zIndex: 999,
                          revert: true,      // will cause the event to go back to its
                          revertDuration: 0  //  original position after the drag
                        });
                  
                      });
                  
                  
                      /* initialize the calendar
                      -----------------------------------------------------------------*/
                  
                      var calendar =  $('#calendar').fullCalendar({
                        header: {
                          left: 'title',
                          center: 'agendaDay,agendaWeek,month',
                          right: 'prev,next today'
                        },
                        editable: true,
                        firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
                        selectable: true,
                        defaultView: 'month',
                  
                        axisFormat: 'h:mm',
                        columnFormat: {
                                  month: 'ddd',    // Mon
                                  week: 'ddd d', // Mon 7
                                  day: 'dddd M/d',  // Monday 9/7
                                  agendaDay: 'dddd d'
                              },
                              titleFormat: {
                                  month: 'MMMM yyyy', // September 2009
                                  week: "MMMM yyyy", // September 2009
                                  day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
                              },
                        allDaySlot: false,
                        selectHelper: true,
                        select: function(start, end, allDay) {
                          var title = prompt('Event Title:');
                          if (title) {
                            calendar.fullCalendar('renderEvent',
                              {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                              },
                              true // make the event "stick"
                            );
                          }
                          calendar.fullCalendar('unselect');
                        },
                        droppable: true, // this allows things to be dropped onto the calendar !!!
                        drop: function(date, allDay) { // this function is called when something is dropped
                  
                          // retrieve the dropped element's stored Event Object
                          var originalEventObject = $(this).data('eventObject');
                  
                          // we need to copy it, so that multiple events don't have a reference to the same object
                          var copiedEventObject = $.extend({}, originalEventObject);
                  
                          // assign it the date that was reported
                          copiedEventObject.start = date;
                          copiedEventObject.allDay = allDay;
                  
                          // render the event on the calendar
                          // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                          $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                  
                          // is the "remove after drop" checkbox checked?
                          if ($('#drop-remove').is(':checked')) {
                            // if so, remove the element from the "Draggable Events" list
                            $(this).remove();
                          }
                  
                        },
                  
                        events: [
                          {
                            title: 'All Day Event',
                            start: new Date(y, m, 1)
                          },
                          {
                            id: 999,
                            title: 'Repeating Event',
                            start: new Date(y, m, d-3, 16, 0),
                            allDay: false,
                            className: 'info'
                          },
                          {
                            id: 999,
                            title: 'Repeating Event',
                            start: new Date(y, m, d+4, 16, 0),
                            allDay: false,
                            className: 'info'
                          },
                          {
                            title: 'Meeting',
                            start: new Date(y, m, d, 10, 30),
                            allDay: false,
                            className: 'important'
                          },
                          {
                            title: 'Lunch',
                            start: new Date(y, m, d, 12, 0),
                            end: new Date(y, m, d, 14, 0),
                            allDay: false,
                            className: 'important'
                          },
                          {
                            title: 'Birthday Party',
                            start: new Date(y, m, d+1, 19, 0),
                            end: new Date(y, m, d+1, 22, 30),
                            allDay: false,
                          },
                          {
                            title: 'Click for Google',
                            start: new Date(y, m, 28),
                            end: new Date(y, m, 29),
                            url: 'http://google.com/',
                            className: 'success'
                          }
                        ],
                      });
                  
                  
                    });
                  
                  </script>
            </div>
            <div class="tab-pane" id="code-inputs-2">
              <div class="position-relative p-4 pb-2">
             
            </div>
          </div>
        </div>

      </div>
     


    </div>

</div>

@endsection