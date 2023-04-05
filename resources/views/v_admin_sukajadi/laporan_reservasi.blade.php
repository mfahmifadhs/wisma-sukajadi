@extends('v_admin_sukajadi.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Laporan Reservasi</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/reservasi/daftar') }}">Daftar Reservasi</a></li>
          <li class="breadcrumb-item active">Laporan Reservasi</li>
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
        <table id="table-1" class="table table-bordered table-striped responsive">
          <thead class="text-center">
            <tr>
              <th style="width: 5%;">No</th>
              <th style="width: 10%;">Kode Biling</th>
              <th style="width: 15%;">Nama Pengunjung</th>
              <th style="width: 15%;">Check In - Check Out</th>
              <th style="width: 10%;">Durasi</th>
              <th style="width: 11%;">Kamar</th>
              <th style="width: 10%">Harga</th>
              <th style="width: 10%">Status</th>
            </tr>
          </thead>
          <?php $no = 1; ?>
          <tbody class="text-capitalize text-center">
            @foreach($reservasi as $reservasi)
            <tr class="clickable-row" data-href="{{ url('admin-sukajadi/reservasi/detail/'.$reservasi->id_reservation) }}">
              <td>{{ $no++ }}</td>
              <td>{{ $reservasi->billing_code }}</td>
              <td>{{ $reservasi->visitor_name }}</td>
              <td>
                {{ \Carbon\Carbon::parse($reservasi->check_in)->isoFormat('DD/MM/YY') }} - {{ \Carbon\Carbon::parse($reservasi->check_out)->isoFormat('DD/MM/YY') }}
              </td>
              <td>{{ $reservasi->duration }} malam</td>
              <td>{{ $reservasi->room_name }}</td>
              <td>Rp {{ number_format($reservasi->detail_reservation_price, 0, ',', '.') }}</td>
              <td>
                @if($reservasi->status_reservation == 'payment')
                    Menunggu Pembayaran
                @elseif($reservasi->status_reservation == 'reserved')
                    Dipesan
                @elseif($reservasi->status_reservation == 'checkin')
                    Check In
                @elseif($reservasi->status_reservation == 'checkout')
                    Check Out
                @else
                    Batal
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
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel"]
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
