@extends('v_admin_master.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard Super Admin</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard Super Admin</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Grafik -->
    <div class="row">
      <div class="col-md-6 form-group">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title"><b>Total Pengunjung</b></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12" >
                <div class="chart">
                  <!-- Sales Chart Canvas -->
                  <canvas id="visitorChart" style="height: 250px;"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              @foreach($total_visitor as $total_visitor)
              <div class="col-sm-4 col-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-success"><i class="fas fa-users"></i></span>
                  <h5 class="description-header">{{ $total_visitor->total_visitor }} orang</h5>
                  <span class="description-text">BULAN  {{ \Carbon\Carbon::parse('2022-'.$total_visitor->month.'-01')->isoFormat('MMMM') }}</span>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 form-group">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title"><b>Total Pendapatan</b></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12" >
                <div class="chart">
                  <!-- Sales Chart Canvas -->
                  <canvas id="incomeChart" style="height: 250px;"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              @foreach($total_income as $total_income)
              <div class="col-sm-4 col-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-success"><i class="fas fa-money-bill-wave"></i></span>
                  <h5 class="description-header">Rp {{ number_format($total_income->total_income, 0, ',', '.') }}</h5>
                  <span class="description-text">BULAN  {{ \Carbon\Carbon::parse('2022-'.$total_income->month.'-01')->isoFormat('MMMM') }}</span>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- --- -->

    <div class="row">
      <div class="col-md-4 form-group">
        <div class="row">
          <div class="col-md-12">
            <div class="callout callout-info">
              <h6 class="font-weight-bold mt-2">Reservasi</h6>
            </div>
          </div>
          <div class="col-md-12">
            <div class="callout callout-info text-capitalize">
              <div class="row">
                @foreach($reservasi as $reservasi)
                <div class="col-md-12">
                  <span style="font-size: 12px;">{{ \Carbon\Carbon::parse($reservasi->reservation_date)->isoFormat('DD MMMM Y') }}</span><br>
                  <span style="font-size: 13px;" class="float-left"><label>{{ $reservasi->visitor_name }}</label></span>
                  <span class="float-right"><h6 style="font-size: 12px;">{{ $reservasi->total_room }} kamar</h6></span>
                  <hr class="mt-4">
                </div>
                @endforeach
                <div class="col-md-12">
                  <p class="mb-0" style="font-size: 14px;">
                    <a href="{{ url('admin-master/laporan/reservasi') }}" class="fw-bold text-primary">
                      <i class="fas fa-arrow-circle-right"></i> Lihat semua 
                    </a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 form-group">
        <div class="row">
          <div class="col-md-12">
            <div class="callout callout-info">
              <h6 class="font-weight-bold mt-2">Pendapatan</h6>
            </div>
          </div>
          <div class="col-md-12">
            <div class="callout callout-info text-capitalize">
              <div class="row">
                @foreach($income as $income)
                <div class="col-md-12">
                  <span style="font-size: 12px;">{{ \Carbon\Carbon::parse($income->pnbp_date)->isoFormat('DD MMMM Y') }}</span><br>
                  <span style="font-size: 13px;" class="float-left"><label>{{ $income->transaction_num }}</label></span>
                  <span class="float-right"><h6 style="font-size: 12px;">Rp {{ number_format($income->pnbp_total_income, 0, ',', '.') }}</h6></span>
                  <hr class="mt-4">
                </div>
                @endforeach
                <div class="col-md-12">
                  <p class="mb-0" style="font-size: 14px;">
                    <a href="{{ url('admin-master/laporan/pnbp') }}" class="fw-bold text-primary">
                      <i class="fas fa-arrow-circle-right"></i> Lihat semua 
                    </a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 form-group">
        <div class="row">
          <div class="col-md-12">
            <div class="callout callout-info">
              <h6 class="font-weight-bold mt-2">Pengunjung/Tamu</h6>
            </div>
          </div>
          <div class="col-md-12">
            <div class="callout callout-info text-capitalize">
              <div class="row">
                @foreach($visitor as $visitor)
                <div class="col-md-12">
                  <span style="font-size: 12px;">{{ \Carbon\Carbon::parse($visitor->visit_date)->isoFormat('H:m DD MMMM Y') }}</span><br>
                  <span style="font-size: 13px;" class="float-left"><label>{{ $visitor->visit_name }}</label></span>
                  <span class="float-right"><h6 style="font-size: 12px;">{{ $visitor->visit_phone_num }}</h6></span>
                  <hr class="mt-4">
                </div>
                @endforeach
                <div class="col-md-12">
                  <p class="mb-0" style="font-size: 14px;">
                    <a href="{{ url('admin-master/laporan/reservasi') }}" class="fw-bold text-primary">
                      <i class="fas fa-arrow-circle-right"></i> Lihat semua 
                    </a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@section('js')
<script>
  $(function () {
    $("#table-1").DataTable({
      "responsive": true, "autoWidth": false, 
      "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]]
    }).buttons().container().appendTo('#table-1_wrapper .col-md-6:eq(0)');

    //------------------------------
    //- BAR CHART TOTAL PENGUNJUNG -
    //------------------------------
    var visitor = "{{ url('admin-master/chart-visitor') }}"
    var Month      = new Array();
    var TotalVisit = new Array();
    $(document).ready(function(){
      $.get(visitor, function(response){
        response.forEach(function(data){
          Month.push(data.month);
          TotalVisit.push(data.total_visitor);
        });

        var barChartCanvas = $('#visitorChart').get(0).getContext('2d')
        var barChartData = {
          labels  : Month,
          datasets: [
            {
              label               : 'Total Pengunjung',
              backgroundColor     : 'rgba(54, 162, 235, 0.2)',
              borderColor         : 'rgb(54, 162, 235)',
              borderWidth         : 1,
              pointRadius         : false,
              pointColor          : '#3b8bba',
              pointStrokeColor    : 'rgba(60,141,188,1)',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data                : TotalVisit
            }
          ]
        }
        var temp0 = barChartData.datasets[0]
        barChartData.datasets[0] = temp0

        var barChartOptions = {
          responsive              : true,
          maintainAspectRatio     : false,
          scales : {
            yAxes : [{
              ticks : {
                beginAtZero : true
              }   
            }]
          }
        }

        new Chart(barChartCanvas, {
          type: 'bar',
          data: barChartData,
          options: barChartOptions
        })
      });
    });
  });
</script>


<!-- //------------------------------
//- BAR CHART TOTAL PENDAPATAN -
//------------------------------ -->
<script>
    
    var income      = "{{ url('admin-master/chart-income') }}"
    var Month       = new Array();
    var TotalIncome = new Array();
    $(document).ready(function(){
      $.get(income, function(response){
        response.forEach(function(data){
          Month.push(data.month);
          TotalIncome.push(data.total_income);
        });

        var barChartCanvas = $('#incomeChart').get(0).getContext('2d')
        var barChartData = {
          labels  : Month,
          datasets: [
            {
              label               : 'Total Pendapatan',
              backgroundColor     : 'rgba(54, 162, 235, 0.2)',
              borderColor         : 'rgb(54, 162, 235)',
              borderWidth         : 1,
              pointRadius         : false,
              pointColor          : '#3b8bba',
              pointStrokeColor    : 'rgba(60,141,188,1)',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data                : TotalIncome
            }
          ]
        }
        var temp0 = barChartData.datasets[0]
        barChartData.datasets[0] = temp0

        var barChartOptions = {
          responsive              : true,
          maintainAspectRatio     : false,
          scales : {
            yAxes : [{
              ticks : {
                beginAtZero : true
              }   
            }]
          }
        }

        new Chart(barChartCanvas, {
          type: 'bar',
          data: barChartData,
          options: barChartOptions
        })
      });
    });
</script>
@endsection

@endsection