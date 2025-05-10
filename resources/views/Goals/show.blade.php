@extends('layouts.Nav')

@section('content')
<style>
    #milestones-chart-container {
        position: relative;
        height: 400px;
        width: 100%;
        background-image: url('https://wallup.net/wp-content/uploads/2016/05/24/365098-mountains-Moon-lights-river-landscape-nature.jpg');
        background-size: cover;
        background-position: center;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                        <h2 class="text-white text-uppercase  text-center">Milestones: Goal - {{ $goal->title }}</h2>

                    </div>
                 </div>


                <div class="card-body">
                    <!-- Add your graph here to visualize milestones -->
                    <div id="milestones-chart-container">
                        <canvas id="milestones-chart"></canvas>
                    </div>
                    <!-- ... -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3 text-center ">Milestone Details</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Milestone Number</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($milestonesData as $milestone)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $milestone['date'] }}</td>
                                    <td>${{ number_format($milestone['amount'], 2) }}</td>
                                    <td>
                                        @if ($milestone['status'] === 'current')
                                            <span style="color: cyan;">Current Balance</span>
                                        @elseif ($milestone['status'] === 'Achieved')
                                            <span style="color: orange;">Achieved</span>
                                        @else
                                            <span style="color: red;">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var milestonesChart = document.getElementById('milestones-chart').getContext('2d');
    var milestonesChartData = {!! json_encode($milestonesChartData) !!};
    console.log(milestonesChartData);

    // Find the last milestone that is achieved
    var lastAchievedMilestoneIndex = -1;
    milestonesChartData.forEach((milestone, index) => {
        if (milestone.status === 'Achieved') {
            lastAchievedMilestoneIndex = index;
        }
    });

    new Chart(milestonesChart, {
        type: 'line',
        data: {
            labels: milestonesChartData.map(data => data.label),
            datasets: [{
                label: 'Milestone Progress',
                data: milestonesChartData.map(data => data.amount),
                pointRadius: 8,
                pointHoverRadius: 10,
                pointBorderWidth: 3,
                borderWidth: 4,
                borderColor: 'blue', // Change the progress line color to blue
                pointBorderColor: 'rgb(233, 250, 107)',
                pointBackgroundColor: function(context) {
                    var index = context.dataIndex;
                    var milestone = milestonesChartData[index];

                    if (milestone.status === 'current') {
                        return 'cyan'; // Use cyan for "Current Balance" milestone
                    } else if (milestone.status === 'Achieved') {
                        return 'orange'; // Use orange for "Achieved" milestones
                    } else {
                        return 'red'; // Use red for "Pending" milestones
                    }
                },
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Milestone Number',
                    },
                    grid: {
                        display: false,
                    },
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Milestone Amount',
                    },
                    suggestedMin: 0,
                    suggestedMax: Math.max(...milestonesChartData.map(data => data.amount)) * 1.1,
                    grid: {
                        display: false,
                    },
                },
            },
            elements: {
                point: {
                    hoverRadius: 10,
                    hoverBorderWidth: 5,
                },
            },
            plugins: {
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function (context) {
                            const datasetLabel = context.dataset.label || '';
                            const dataPoint = context.parsed.y;
                            return datasetLabel + ': $' + dataPoint.toFixed(2);
                        },
                    },
                },
            },
            interaction: {
                mode: 'nearest',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14,
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif",
                        },
                    },
                },
            },
        },
    });

    // Add the road-like effect for the milestones chart
    const drawRoad = (chart) => {
        const ctx = chart.ctx;
        const xAxis = chart.scales.x;
        const yAxis = chart.scales.y;
        const gradient = ctx.createLinearGradient(xAxis.left, yAxis.getPixelForValue(0), xAxis.right, yAxis.getPixelForValue(0));
        gradient.addColorStop(0, 'rgba(255, 255, 255, 0.5)');
        gradient.addColorStop(0.5, 'rgba(255, 255, 255, 0.3)');
        gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

        ctx.save();
        ctx.beginPath();
        ctx.moveTo(xAxis.left, yAxis.getPixelForValue(0));
        ctx.lineTo(xAxis.right, yAxis.getPixelForValue(0));
        ctx.lineTo(xAxis.right, yAxis.bottom);
        ctx.lineTo(xAxis.left, yAxis.bottom);
        ctx.closePath();
        ctx.fillStyle = gradient;
        ctx.fill();
        ctx.restore();
    };

    // Call the drawRoad function after the chart has been drawn
    milestonesChart.draw = function() {
        Chart.controllers.line.prototype.draw.apply(this, arguments);
        drawRoad(this);
    };

    // Add a CSS class to the last achieved milestone's point
    if (lastAchievedMilestoneIndex !== -1) {
        const point = milestonesChart.getDatasetMeta(0).data[lastAchievedMilestoneIndex];
        point.custom = point.custom || {};
        point.custom.backgroundColor = 'green'; // Change the color to green for the last achieved milestone
    }

    milestonesChart.update(); // Update the chart to apply the style changes
</script>

@endsection
