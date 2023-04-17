@extends('v_admin_sukajadi.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>Reservasi</b></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Daftar Reservasi</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="fw-light" style="margin: auto;">{{ $message }}</p>
        </div>
        @endif
        @if ($message = Session::get('failed'))
        <div class="alert alert-danger">
            <p class="fw-light" style="margin: auto;">{{ $message }}</p>
        </div>
        @endif
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h4 class="card-title mt-2"><b>Daftar Reservasi Kamar</b></h4>
                <div class="card-tools">
                    <a href="{{ url('admin-sukajadi/reservasi/buat') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Buat Reservasi
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table-1" class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 0%;">No</th>
                            <th style="width: 10%;">Tanggal</th>
                            <th style="width: 25%;">Pengunjung</th>
                            <th style="width: 10%;">KTP</th>
                            <th style="width: 10%;">Total Kamar</th>
                            <th style="width: 15%;">Total Pembayaran</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <?php $no = 1; ?>
                    <tbody class="text-capitalize text-center">
                        @foreach($reservasi as $reservasi)
                        <tr class="clickable-row" data-href="{{ url('admin-sukajadi/reservasi/detail/'.$reservasi->id_reservation) }}">
                            <td class="pt-4">{{ $no++ }}</td>
                            <td class="pt-4">
                                {{ \Carbon\Carbon::parse($reservasi->reservation_date)->isoFormat('DD MMMM Y') }}
                            </td>
                            <td class="text-left">
                                <div class="form-group row">
                                    <div class="col-md-3">Nama </div>
                                    <div class="col-md-9">: {{ $reservasi->visitor_name }}</div>
                                    <div class="col-md-3">No. Hp </div>
                                    <div class="col-md-9">: {{ $reservasi->visitor_phone_number }}</div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if ($reservasi->identity_img)
                                <img src="{{ asset('images/admin/pengunjung/'. $reservasi->identity_img )}}" width="80">
                                @else
                                -
                                @endif
                            </td>
                            <td class="pt-4">{{ (int) $reservasi->total_room }} kamar</td>
                            <td class="pt-4">Rp {{ number_format($reservasi->payment_total, 0, ',', '.') }}</td>
                            <td class="pt-4">
                                @if($reservasi->status_reservation == '')
                                <span class="badge badge-info font-weight-bold text-uppercase p-2">
                                    Pemilihan <br> Kamar
                                </span>
                                @elseif($reservasi->status_reservation == 'payment')
                                <span class="badge badge-warning font-weight-bold text-uppercase p-2">
                                    Menunggu <br> Pembayaran
                                </span>
                                @elseif($reservasi->status_reservation == 'reserved')
                                <span class="badge badge-info font-weight-bold text-uppercase p-2">
                                    Sudah Dipesan
                                </span>
                                @elseif($reservasi->status_reservation == 'checkin')
                                <span class="badge badge-success font-weight-bold text-uppercase p-2">
                                    Check In
                                </span>
                                @elseif($reservasi->status_reservation == 'checkout')
                                <span class="badge badge-danger font-weight-bold text-uppercase p-2">
                                    Check Out
                                </span>
                                @else
                                <span class="badge badge-danger font-weight-bold text-uppercase p-2">
                                    Batal
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($reservasi->status_reservation == '')
                                <a href="{{ url('admin-sukajadi/reservasi/pilih-kamar/'.$reservasi->id_reservation) }}" class="btn btn-info btn-xs btn-block" title="Pilih Kamar">
                                    <i class="fas fa-door-open"></i> Pilih Kamar
                                </a>
                                <a href="{{ url('admin-sukajadi/reservasi/batal/'.$reservasi->id_reservation) }}" class="btn btn-danger btn-xs btn-block" onclick="return confirm('Batal melakukan reservasi ?')">
                                    <i class="fas fa-times-circle"></i> Batal
                                </a>
                                @endif
                                @if($reservasi->status_reservation == 'payment' && $reservasi->status_reservation != 'cancel')
                                <a href="{{ url('admin-sukajadi/reservasi/pembayaran/'.$reservasi->id_reservation) }}" class="btn btn-success btn-xs btn-block" onclick="return confirm('Melakukan pembayaran ?')">
                                    <i class="fas fa-check-circle"></i> Bayar
                                </a>
                                <a href="{{ url('admin-sukajadi/reservasi/batal/'.$reservasi->id_reservation) }}" class="btn btn-danger btn-xs btn-block" onclick="return confirm('Batal melakukan reservasi ?')">
                                    <i class="fas fa-times-circle"></i> Batal
                                </a>
                                @endif

                                @if($reservasi->payment_status == 'sudah bayar')
                                @if($reservasi->status_reservation == 'reserved')
                                <div class="pt-2">
                                    <a href="{{ url('admin-sukajadi/reservasi/checkin/'.$reservasi->id_reservation) }}" class="btn btn-success mt-1 btn-xs btn-block" onclick="return confirm('Check In ?')">
                                        <i class="fas fa-check-circle"></i> Check In
                                    </a>
                                </div>
                                @elseif($reservasi->status_reservation == 'checkin')
                                <div class="pt-2">
                                    <a href="{{ url('admin-sukajadi/reservasi/checkout/'.$reservasi->id_reservation) }}" class="btn btn-danger mt-1 btn-xs btn-block" onclick="return confirm('Check Out ?')">
                                        <i class="fas fa-check-circle"></i> Check Out
                                    </a>
                                </div>
                                @elseif($reservasi->status_reservation == 'checkout')
                                <a href="{{ url('admin-sukajadi/kamar/keterangan/'.$reservasi->id_reservation) }}" class="btn btn-primary btn-xs btn-block" onclick="return confirm('Tambah Catatan ?')">
                                    <i class="fas fa-file"></i> Catatan
                                </a>
                                <a href="{{ url('admin-sukajadi/kwitansi/buat/'.$reservasi->id_reservation) }}" class="btn btn-primary btn-xs btn-block" onclick="return confirm('Cetak Kwitansi ?')">
                                    <i class="fas fa-file-invoice"></i> Kwitansi
                                </a>
                                @endif
                                @endif
                                <a href="{{ url('admin-sukajadi/reservasi/edit/'.$reservasi->id_reservation) }}" class="btn btn-warning btn-xs btn-block mt-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</section>
<!-- End Main Content -->
@section('js')
<script>
    $(function() {
        $("#table-1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false
        }).buttons().container().appendTo('#table-1_wrapper .col-md-6:eq(0)');
    });

    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>
@endsection

@endsection
