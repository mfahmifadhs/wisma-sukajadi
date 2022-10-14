<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Wisma Sukajadi Bandung - {{ $reservasi->id_reservation }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('dist-admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist-admin/css/adminlte.css') }}">
  <style type="text/css">
    @media print{
      @page {
        size: auto;   /* auto is the initial value */
        size: A4 landscape;
        margin: 0;  /* this affects the margin in the printer settings */
        border: 1px solid red;  /* set a border for all printed pages */
      }
    }
  </style>
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
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
          <div class="row">
            <div class="col-12">
              <h4>
                <img src="{{ asset('images/admin/logo-kemenkes-icon.png') }}" width="50" style="margin-top: -8px;">
                Wisma Sukajadi Bandung
                <small class="float-right mt-3">
                  {{ \Carbon\Carbon::parse($reservasi->reservation_date)->isoFormat('DD MMMM Y') }}
                </small>
              </h4>
            </div>
          </div>

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

            <div class="col-sm-4 invoice-col">
              To
              <address class="text-capitalize">
                <strong>{{ $reservasi->visitor_name }}</strong><br>
                {{ $reservasi->visitor_instance }} <br>
                Telp : {{ $reservasi->visitor_phone_number }}
              </address>
            </div>

            <div class="col-sm-4 invoice-col">
              <b>Kwitansi #{{ $reservasi->id_reservation }}</b><br>
              <br>
              <b>Kode Biling:</b> {{ $reservasi->billing_code }}<br>
              <b>Tanggal:</b> {{ \Carbon\Carbon::parse($reservasi->reservation_date)->isoFormat('DD/MM/Y') }}<br>
            </div>
          </div>

          <!-- Table row -->
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped table-bordered">
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
                    <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
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
          </div>

          <div class="row">
            <div class="col-6">
              <p class="lead">Metode Pembayaran</p>
              <img src="https://1.bp.blogspot.com/-GjCpjdW8Hrs/XkXUvE0RseI/AAAAAAAABmk/u5e1zr7RGHQN2TFwPu1IoN8QJBtwXLH5QCLcBGAsYHQ/s400/Logo%2BLink%2BAja%2521.png" alt="Mandiri" width="60">
              <img src="https://cdn0-production-images-kly.akamaized.net/Z409KTEnMYWz7Ntw4JwR5ipVKZg=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/2264120/original/063927100_1530333288-20170926171133-6-ilustrasi-atm-bersama-001-magang.jpg" alt="BNI" width="70">

              <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                Rekening yang benar hanya atas nama Wisma Sukajadi Kemenkes RI.
              </p>
            </div>
            <div class="col-6">
              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th style="width:50%">Jumlah Kamar :</th>
                    <td>{{ $detail->total_room }} kamar</td>
                  </tr>
                  <tr>
                    <th>Pajak (%)</th>
                    <td>Rp 0</td>
                  </tr>
                  <tr>
                    <th class="font-weight-bold">Total Pembayaran:</th>
                    <td>Rp {{ number_format($detail->payment_total, 0, ',', '.') }}</td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="col-md-6 mt-4">
              <p class="font-weight-bold" style="margin-top: 10px;">Catatan :</p>
              <p style="font-family: Times New Roman;">
                1. Disimpan sebagai bukti pembayaran yang SAH. <br>
                2. Harga sudah termasuk pajak. <br>
                3. Uang yang sudah dibayarkan tidak dapat diminta kembali.

              </p>
            </div>

            <div class="col-md-6 mt-4">
              <p class="font-weight-bold">Pengelola Wisma Sukajadi Bandung Kemenkes RI</p>
              <p style="margin-top: 100px;">
                ──────────────
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
