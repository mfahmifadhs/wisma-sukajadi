@extends('v_admin_sukajadi.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>Selamat Datang</b>, {{ Auth::user()->name }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 form-group">
                <div class="card card-primary card-outline" style="height: 100%;">
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
                            <div class="col-md-12">
                                <div class="chart">
                                    <!-- Sales Chart Canvas -->
                                    <canvas id="visitorChart" style="height: 320px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 form-group">
                <div class="card card-primary card-outline" style="height: 100%;">
                    <div class="card-header">
                        <h3 class="card-title"><b>Total Pendapatan</b></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            @foreach($total_income as $data)
                            <div class="col-sm-4 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-success"><i class="fas fa-money-bill-wave"></i></span>
                                    <h5 class="description-header">Rp {{ number_format($data->payment_total, 0, ',', '.') }}</h5>
                                    <span class="description-text">BULAN {{ \Carbon\Carbon::parse($data->month)->isoFormat('MMMM Y') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 form-group ">
                <label>Daftar Kapasitas Kamar</label>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <a href="{{ url('admin-sukajadi/kamar/tersedia') }}" style="color: black;">
                            <div class="info-box">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-bed"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Kamar Tersedia</span>
                                    <span class="info-box-number">
                                        {{ $rooms->where('room_status','tersedia')->whereNull('deleted_at')->count() }} kamar
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <a href="{{ url('admin-sukajadi/kamar/terisi') }}" style="color: black;">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-bed"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Kamar Terisi</span>
                                    <span class="info-box-number">
                                        {{ $rooms->where('room_status','tidak tersedia')->whereNull('deleted_at')->count() }} kamar
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <a href="{{ url('admin-sukajadi/kamar/maintenance') }}" style="color: black;">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-bed"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Kamar Tidak Tersedia</span>
                                    <span class="info-box-number">
                                        {{ $rooms->where('room_status','maintenance')->whereNull('deleted_at')->count() }} kamar
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 form-group">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h6 class="font-weight-bold mt-2">Reservasi</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($reservasi as $reservasi)
                                    <div class="col-md-12">
                                        <span style="font-size: 12px;">{{ \Carbon\Carbon::parse($reservasi->reservation_date)->isoFormat('DD MMMM Y') }}</span><br>
                                        <span style="font-size: 13px;" class="float-left"><label>{{ $reservasi->visitor_name }}</label></span>
                                        <span class="float-right">
                                            <h6 style="font-size: 12px;">{{ $reservasi->total_room }} kamar</h6>
                                        </span>
                                        <hr class="mt-4">
                                    </div>
                                    @endforeach
                                    <div class="col-md-12">
                                        <p class="mb-0" style="font-size: 14px;">
                                            <a href="{{ url('admin-sukajadi/reservasi/daftar') }}" class="btn btn-default fw-bold">
                                                <i class="fas fa-arrow-circle-right"></i> Lihat semua reservasi
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 form-group">
                <div class="card card-primary card-outline">
                    <div class="card-header border-transparent">
                        <h3 class="card-title"><b>Daftar Pengunjung</b></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th style="width: 25%;">Tanggal</th>
                                        <th style="width: 35%;">Nama</th>
                                        <th>Keperluan</th>
                                    </tr>
                                </thead>
                                <?php $no = 1; ?>
                                <tbody class="text-capitalize">
                                    @foreach($visitor as $visitor)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ \Carbon\Carbon::parse($visitor->visit_date)->isoFormat('HH:mm') .' '.
                         \Carbon\Carbon::parse($visitor->visit_date)->isoFormat('DD MMMM Y') }}</td>
                                        <td>{{ $visitor->visit_name }}</td>
                                        <td>{{ $visitor->visit_description }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <a href="{{ url('admin-sukajadi/buku-tamu') }}" class="btn btn-default float-sm-right">
                            <i class="fas fa-arrow-alt-circle-right"></i> Lihat semua pengunjung
                        </a>
                    </div>
                    <!-- /.card-footer -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

@section('js')
<script>
    $(function() {
        $("#table-1").DataTable({
            "responsive": true,
            "autoWidth": false,
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ]
        }).buttons().container().appendTo('#table-1_wrapper .col-md-6:eq(0)');

        //-------------
        //- BAR CHART -
        //-------------
        var url = "{{ url('admin-sukajadi/chart-visitor') }}"
        var Month = new Array();
        var TotalVisit = new Array();
        $(document).ready(function() {
            $.get(url, function(response) {
                response.forEach(function(data) {
                    Month.push(data.month);
                    TotalVisit.push(data.total_visitor);
                });

                var barChartCanvas = $('#visitorChart').get(0).getContext('2d')
                var barChartData = {
                    labels: Month,
                    datasets: [{
                        label: 'Total Pengunjung',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1,
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: TotalVisit
                    }]
                }
                var temp0 = barChartData.datasets[0]
                barChartData.datasets[0] = temp0

                var barChartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
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
@endsection

@endsection

