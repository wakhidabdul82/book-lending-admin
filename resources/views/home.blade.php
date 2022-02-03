@extends('layouts.master')
@section('header','Dashboard')
@section('subheader','Index')

@push('script')
<script type="text/javascript">
$(function () {
    var data_bar = '{!!json_encode($data_bar)!!}'; 
    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: JSON.parse(data_bar),
    }

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var data_pie = '{!!json_encode($data_pie)!!}';
    var label_pie = '{!!json_encode($label_pie)!!}';
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = {
      labels: JSON.parse(label_pie),
      datasets: [
        {
          data: JSON.parse(data_pie),
          backgroundColor : ['#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    });

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var data_donut = '{!!json_encode($data_donut)!!}';
    var label_donut = '{!!json_encode($label_donut)!!}';

    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: JSON.parse(label_donut),
      datasets: [
        {
          data: JSON.parse(data_donut),
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    });

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    //var temp0 = areaChartData.datasets[0]
    //var temp1 = areaChartData.datasets[1]
    //barChartData.datasets[0] = temp1
    //barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    });

    //----------------
    //-- LINE CHART --
    //----------------
    var data_line = '{!!json_encode($data_line)!!}'; 
    const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const data = {
        labels: labels,
        datasets: JSON.parse(data_line),
    };
  
    const config = {
    type: 'line',
    data: data,
    options: {}
    };
  
    var myChart = new Chart(
    document.getElementById('myChart'),
    config
    );
});
</script>
@endpush


@section('content')
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card border-info">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
            <div>
              <p class="mb-2 text-md-center text-lg-left">Total Book</p>
              <h1 class="mb-0">{{$total_book}}</h1>
            </div>
            <i class="typcn typcn-briefcase icon-xl text-secondary"></i>
          </div>
        </div>
        <a href="{{url('books')}}" class="card-footer">More info</a>
      </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card border-warning">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
            <div>
              <p class="mb-2 text-md-center text-lg-left">Publisher</p>
              <h1 class="mb-0">{{$total_publisher}}</h1>
            </div>
            <i class="typcn typcn-chart-pie icon-xl text-secondary"></i>
          </div>
        </div>
        <a href="{{url('publishers')}}" class="card-footer">More info</a>
      </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card border-primary">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
            <div>
              <p class="mb-2 text-md-center text-lg-left">Author</p>
              <h1 class="mb-0">{{$total_author}}</h1>
            </div>
            <i class="typcn typcn-clipboard icon-xl text-secondary"></i>
          </div>
        </div>
        <a href="{{url('authors')}}" class="card-footer">More info</a>
      </div>
    </div>
</div>

<div class="row justify-content-between">
    <div class="col-md-6">
        <div class="card border-danger">
            <div class="card-footer">
              <h4 class="text-secondary">Data Publishers</h4>
            </div>
            <div class="card-body">
              <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-success">
            <div class="card-footer">
              <h4 class="text-secondary">Transactions</h4>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card border-info">
            <div class="card-footer">
              <h4 class="text-secondary">Member Register</h4>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="myChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
    </div>
    <div class="col-md-6">
        <div class="card border-warning">
            <div class="card-footer">
              <h4 class="text-secondary">Members</h4>
            </div>
            <div class="card-body">
              <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection