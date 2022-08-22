@extends('v_admin_sukajadi.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Pendapatan</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active"><a href="{{ url('admin-sukajadi/pendapatan') }}">Pendapatan</a></li>
          <li class="breadcrumb-item active">Pendapatan Tanggal {{ \Carbon\Carbon::parse($id)->isoFormat('DD MMMM Y') }}</li>
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
      <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Pendapatan Tanggal {{ \Carbon\Carbon::parse($id)->isoFormat('DD MMMM Y') }}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="table-1" class="table table-bordered table-striped">
              <thead class="text-center">
                <tr>
                  <th style="width: 5%;">No</th>
                  <th style="width: 20%;">Tanggal</th>
                  <th style="width: 16%;">No. Transaksi</th>
                  <th style="width: 15%;">Total Kamar</th>
                  <th style="width: 19%;">Total Pendapatan</th>
                  <th style="width: 10%;">Aksi</th>
                </tr>
              </thead>
              <?php $no = 1; ?>
              <tbody class="text-center">
                @foreach($income as $income)
                <tr>
                  <td class="pt-2">{{ $no++ }}</td>
                  <td class="pt-2">{{ \Carbon\Carbon::parse($income->reservation_date)->isoFormat('DD MMMM Y') }}</td>
                  <td class="pt-2">{{ $income->billing_code }}</td>
                  <td class="pt-2">{{ $income->total_room }}</td>
                  <td class="pt-2">Rp {{ number_format($income->payment_total, 0, ',', '.') }}</td>
                  <td class="pt-2">
                    <a href="{{ url('admin-sukajadi/reservasi/detail/'. $income->id_reservation) }}" class="btn btn-primary btn-xs">
                      <i class="fas fa-info-circle"></i> <br>Detail
                    </a>
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
</section>

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