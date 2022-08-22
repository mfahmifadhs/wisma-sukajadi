@extends('v_admin_master.layout.app')

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
          <li class="breadcrumb-item"><a href="{{ url('admin-master/dashboard') }}">Dashboard</a></li>
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
        <h3 class="card-title"><b>Daftar Reservasi Kamar</b></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="table-1" class="table table-bordered table-striped">
          <thead class="text-center">
            <tr>
              <th style="width: 5%;">No</th>
              <th style="width: 15%;">Pengunjung</th>
              <th style="width: 10%;">No. Hp</th>
              <th style="width: 10%;">Foto KTP</th>
              <th style="width: 10%;">Tanggal</th>
              <th style="width: 11%;">Total Kamar</th>
              <th style="width: 15%;">Total Pembayaran</th>
              <th style="width: 10%">Status</th>
              <th style="width: 15%;"></th>
            </tr>
          </thead>
          <?php $no = 1; ?>
          <tbody class="text-capitalize text-center">
            @foreach($reservasi as $reservasi)
            <tr class="clickable-row" data-href="{{ url('admin-master/reservasi/detail/'.$reservasi->id_reservation) }}">
              <td class="pt-4">{{ $no++ }}</td>
              <td class="pt-4">{{ $reservasi->visitor_name }}</td>
              <td class="pt-4">{{ $reservasi->visitor_phone_number }}</td>
              <td class="text-center">
                <img src="{{ asset('images/admin/pengunjung/'. $reservasi->identity_img )}}" width="80">
              </td>
              <td class="pt-4">
                {{ \Carbon\Carbon::parse($reservasi->reservation_date)->isoFormat('DD/MM/Y') }}
              </td>
              <td class="pt-4">{{ $reservasi->total_room }} kamar</td>
              <td class="pt-4">Rp {{ number_format($reservasi->payment_total, 0, ',', '.') }}</td>
              <td class="pt-4" >
                @if($reservasi->status_reservation == 'payment')
                <a class="btn btn-warning btn-xs font-weight-bold disabled text-uppercase" style="font-size: 10px;">Payment</a>
                @elseif($reservasi->status_reservation == 'reserved')
                <a class="btn btn-warning btn-xs font-weight-bold disabled text-uppercase" style="font-size: 10px;">Reserved</a>
                @elseif($reservasi->status_reservation == 'checkin')
                <a class="btn btn-success btn-xs font-weight-bold disabled text-uppercase" style="font-size: 10px;">Check In</a>
                @elseif($reservasi->status_reservation == 'checkout')
                <a class="btn btn-danger btn-xs font-weight-bold disabled text-uppercase" style="font-size: 10px;">Check Out</a>
                @else
                <a class="btn btn-danger btn-xs font-weight-bold disabled text-uppercase" style="font-size: 10px;">Batal</a>
                @endif
              </td>
              <td class="pt-3 text-center">
                @if($reservasi->payment_status == 'belum bayar')
                  @if($reservasi->status_reservation == 'cancel')

                  @else
                  <a href="{{ url('admin-master/reservasi/pembayaran/'.$reservasi->id_reservation) }}" class="btn btn-success btn-xs" 
                    onclick="return confirm('Melakukan pembayaran ?')"><i class="fas fa-check"></i> <br>Bayar
                  </a>
                  @endif
                @elseif($reservasi->payment_status == 'sudah bayar')
                  @if($reservasi->status_reservation == 'reserved')
                  <a href="{{ url('admin-master/reservasi/detail/'.$reservasi->id_reservation) }}" class="btn btn-primary btn-xs">
                    <i class="fas fa-info"></i> <br>Detail
                  </a>
                  @elseif($reservasi->status_reservation == 'checkout')
                  <a href="{{ url('admin-master/reservasi/detail/'.$reservasi->id_reservation) }}" class="btn btn-primary btn-xs">
                    <i class="fas fa-info"></i> <br>Detail
                  </a>
                  <a href="{{ url('admin-master/kwitansi/cek/'.$reservasi->id_reservation) }}" class="btn btn-primary btn-xs" 
                    onclick="return confirm('Cetak Kwitansi ?')"><i class="fas fa-file-invoice"></i> <br>Kwitansi
                  </a>
                  @endif
                @endif
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
  $(function () {
    $("#table-1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
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