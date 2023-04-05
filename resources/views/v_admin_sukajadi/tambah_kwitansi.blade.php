@extends('v_admin_sukajadi.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Kwitansi</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/reservasi/daftar') }}">Reservasi</a></li>
          <li class="breadcrumb-item active">Buat Kwitansi</li>
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
      <!-- /.col -->
      <div class="col-md-12">
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
      </div>
      <div class="col-12">

        <!-- Main content -->
        <div class="invoice p-3 mb-3">
          <!-- title row -->
          <div class="row">
            <div class="col-12">
              <h6>
                <img src="{{ asset('images/admin/logo-kemenkes-icon.png') }}" width="50" style="margin-top: -5px;">
                Wisma Sukajadi Bandung
                <small class="float-right mt-3">
                  {{ \Carbon\Carbon::parse($reservasi->reservation_date)->isoFormat('DD MMMM Y') }}
                </small>
              </h6>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong>Wisma Sukajadi Bandung</strong><br>
                Jl. Sukajadi No.155, Cipedes, <br>
                Kec. Sukajadi, Kota Bandung. <br>
                Telp: (022) 2031152
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              To
              <address class="text-capitalize">
                <strong>{{ $reservasi->visitor_name }}</strong><br>
                {{ $reservasi->visitor_instance }} <br>
                Telp : {{ $reservasi->visitor_phone_number }}
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>Kwitansi #{{ $reservasi->id_reservation }}</b><br>
              <br>
              <b>Kode Biling:</b> {{ $reservasi->billing_code }}<br>
              <b>Tanggal:</b> {{ \Carbon\Carbon::parse($reservasi->reservation_date)->isoFormat('DD/MM/Y') }}<br>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kamar</th>
                    <th>Harga / Malam</th>
                    <th>Check In - Check Out</th>
                    <th>Waktu Menginap</th>
                    <th>Jumlah</th>
                  </tr>
                </thead>
                <?php $no = 1;?>
                <tbody>
                  @foreach($reservasidetail as $detail)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $detail->room_name }}</td>
                    <td>Rp {{ number_format($detail->new_price, 0, ',', '.') }}</td>
                    <td>
                      {{ \Carbon\Carbon::parse($detail->check_in)->isoFormat('DD/MM/YY') }} - {{ \Carbon\Carbon::parse($detail->check_out)->isoFormat('DD/MM/YY') }}
                    </td>
                    <td>{{ $detail->duration }} malam</td>
                    <td>Rp {{ number_format($detail->detail_reservation_price, 0, ',', '.') }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <div class="row">
            <div class="col-6">

            </div>
            <div class="col-6">
              <hr>
              <p class="lead float-left">Total Pembayaran  </p>
              <p class="lead float-right font-weight-bold">Rp {{ number_format($detail->payment_total, 0, ',', '.') }}</p>
            </div>
          </div>

          <div class="row no-print">
            <div class="col-12">
              <a href="{{ url('admin-sukajadi/kwitansi/cetak/'. $reservasi->id_reservation) }}" rel="noopener" target="_blank" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-print"></i> Cetak Kwitansi
              </a>
            </div>
          </div>
        </div>
        <!-- /.invoice -->
      </div><!-- /.col -->
    </div>
  </div>
</section>

@endsection
