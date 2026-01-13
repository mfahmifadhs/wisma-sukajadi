@extends('layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">WISMA SUKAJADI</h1>
                <h5>Wisma Kemenkes Sukajadi Bandung</h5>
            </div>
            <div class="col-sm-6 my-auto">
                <ol class="breadcrumb float-sm-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                            Reservasi <i class="far fa-bell"></i>
                            <span class="badge badge-danger navbar-badge">{{ $book->count() }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                            <span class="dropdown-item dropdown-header text-dark">{{ $book->count() }} reservasi</span>
                            <div style="max-height: 250px; overflow-y: auto;">
                                @foreach($book as $row)
                                <a href="{{ route('reservasi.tambah', $row->id_reservasi) }}" class="dropdown-item small">
                                    <div class="row">
                                        <div class="col-md-1">{{ $loop->iteration }}. </div>
                                        <div class="col-md-11 text-xs">
                                            <small>{{ Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i') }}</small> <br>
                                            {{ $row->pengunjung->nama_pengunjung }} <br>
                                            {{ $row->pengunjung->unitKerja ? $row->pengunjung->unitKerja->nama_unit_kerja : $row->pengunjung->keterangan }} <br>
                                            {{ Carbon\Carbon::parse($row->tanggal_masuk)->isoFormat('D/M/Y') }} -
                                            {{ Carbon\Carbon::parse($row->tanggal_keluar)->isoFormat('D/M/Y') }}
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                @endforeach
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="{{ url('reservasi') }}" class="dropdown-item dropdown-footer">Lihat seluruh reservasi</a>
                        </div>
                    </li>
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
            @if (Auth::user()->role_id == 4)
            <div class="col-md-12 form-group">
                <a href="{{ route('reservasi.tambah', ['id' => '*']) }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Buat Reservasi
                </a>
            </div>
            @endif
            <div class="col-md-6 form-group">
                <div class="card card-primary card-outline" style="height: 50vh;">
                    <div class="card-header">
                        <h3 class="card-title">Total Pendapatan {{ now()->format('Y') }} (Grafik)</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse" collapsed>
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart">
                                    <canvas id="incomeChart" style="height: 250px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 form-group">
                <div class="card card-primary card-outline scrollable-table-container" style="height: 60vh;">
                    <div class="card-header">
                        <h3 class="card-title">Total Pendapatan {{ Carbon::now()->format('Y') }} (Tabel)</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse" collapsed>
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart">
                                    <table class="table m-0 text-center">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th class="text-left">Bulan</th>
                                                <th>Jumlah</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        @php
                                        $data = json_decode($pendapatan, true);
                                        @endphp
                                        <tbody>
                                            @foreach ($data['original'] as $i => $row)
                                            @php $month = '2025-' . $row['month'] . '-01'; @endphp
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td class="text-left">{{ \Carbon\Carbon::parse($month)->isoFormat('MMMM') }}</td>
                                                <td>Rp {{ number_format($row['pendapatan'], 0, ',', '.') }}</td>
                                                <td>
                                                    <form action="{{ route('reservasi.show') }}" method="GET">
                                                        @csrf
                                                        <input type="hidden" name="bulan" value="{{ \Carbon\Carbon::createFromFormat('n', $row['month'])->isoFormat('M') }}">
                                                        <button type="submit" class="btn btn-primary btn-xs rounded font-weight-bold">
                                                            Detail
                                                        </button>
                                                    </form>
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
            </div>
            <div class="col-md-12 form-group">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h5 class="card-title">Daftar Reservasi</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="table-show" class="table m-0 text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Order ID</th>
                                    <th>Nama</th>
                                    <th>Asal</th>
                                    <th>Check In - Check Out</th>
                                    <th>No. HP</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php $no = 1; ?>
                            <tbody>
                                @foreach ($reservasi->where('status_reservasi','!=',14) as $row)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <a href="{{ route('reservasi.detail', $row->id_reservasi) }}">
                                            {{ $row->id_reservasi }}
                                        </a>
                                    </td>
                                    <td class="text-left">{{ $row->pengunjung->nama_pengunjung }}</td>
                                    <td class="text-left">
                                        {{ $row->pengunjung->unitKerja ? $row->pengunjung->unitKerja->nama_unit_kerja : $row->pengunjung->keterangan }}
                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($row->tanggal_masuk)->isoFormat('d/M/Y') }} -
                                        {{ Carbon\Carbon::parse($row->tanggal_keluar)->isoFormat('d/M/Y') }}
                                    </td>
                                    <td>{{ '0'.$row->pengunjung->no_hp }}</td>
                                    <td><span class="badge badge-success">{{ $row->status->nama_status }}</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-xs font-weight-bold {{ Auth::user()->role_id != 4 ? 'disabled' : ''  }}" type="button" href="{{ route('reservasi.tambah', $row->id_reservasi) }}">
                                            <i class="fas fa-external-link-square-alt"></i> Proses
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-2 col-6">
                                <div class="description-block border-right">
                                    <h4 class="font-weight-bold">{{ $reservasi->where('status_reservasi', 10)->count() }}</h4>
                                    <span class="description-text">PEMILIHAN KAMAR</span>
                                    <h6 class="mt-2">
                                        <form action="{{ route('reservasi.show') }}" method="GET">
                                            @csrf
                                            <input type="hidden" name="status" value="10">
                                            <button type="submit" class="btn btn-default btn-xs">
                                                Selengkapnya <i class="fas fa-arrow-alt-circle-right"></i>
                                            </button>
                                        </form>
                                    </h6>
                                </div>

                            </div>

                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <h4 class="font-weight-bold">{{ $reservasi->where('status_reservasi', 11)->count() }}</h4>
                                    <span class="description-text">MENUNGGU PEMBAYARAN</span>
                                    <form action="{{ route('reservasi.show') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="status" value="11">
                                        <button type="submit" class="btn btn-default btn-xs">
                                            Selengkapnya <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>

                            <div class="col-sm-2 col-6">
                                <div class="description-block border-right">
                                    <h4 class="font-weight-bold">{{ $reservasi->where('status_reservasi', 12)->count() }}</h4>
                                    <span class="description-text">CHECK IN</span>
                                    <form action="{{ route('reservasi.show') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="status" value="12">
                                        <button type="submit" class="btn btn-default btn-xs">
                                            Selengkapnya <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>

                            <div class="col-sm-2 col-6">
                                <div class="description-block">
                                    <h4 class="font-weight-bold">{{ $reservasi->where('status_reservasi', 14)->count() }}</h4>
                                    <span class="description-text">CHECK OUT</span>
                                    <form action="{{ route('reservasi.show') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="status" value="14">
                                        <button type="submit" class="btn btn-default btn-xs">
                                            Selengkapnya <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="description-block">
                                    <h4 class="font-weight-bold">{{ $reservasi->count() }}</h4>
                                    <span class="description-text">SELURUH RESERVASI</span>
                                    <form action="{{ route('reservasi.show') }}" method="GEET">
                                        @csrf
                                        <button type="submit" class="btn btn-default btn-xs">
                                            Selengkapnya <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
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
<!-- //------------------------------
//- BAR CHART TOTAL PENDAPATAN -
//------------------------------ -->
<script>
    $("#table-show").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false
    }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)');

    var income = "{{ route('pendapatan') }}"
    var Month = new Array();
    var TotalIncome = new Array();
    // Chart Pendapatan
    $(document).ready(function() {
        $.get(income, function(response) {
            response.forEach(function(data) {
                Month.push(moment(data.month, "M").format("MMMM"));
                TotalIncome.push(data.pendapatan);
            });

            var barChartCanvas = $('#incomeChart').get(0).getContext('2d')
            var barChartData = {
                labels: Month,
                datasets: [{
                    label: 'Total Pendapatan (Rp)',
                    backgroundColor: 'rgba(3, 201, 169, 0.2)',
                    borderColor: 'rgb(22, 160, 133)',
                    borderWidth: 1,
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: TotalIncome
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
</script>
@endsection

@endsection
