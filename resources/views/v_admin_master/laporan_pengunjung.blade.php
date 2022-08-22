@extends('v_admin_master.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Buku Tamu</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-master/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Daftar Pengunjung</li>
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
            <h3 class="card-title"><b>Daftar Pengunjung</b></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="table-1" class="table table-bordered table-striped">
              <thead class="text-center">
                <tr>
                  <th style="width: 10%;">No</th>
                  <th style="width: 15%;">Tanggal</th>
                  <th style="width: 20%;">Nama Tamu</th>
                  <th style="width: 10%;">No. HP</th>
                  <th style="width: 12%;">No. Kendaraan</th>
                  <th>Tujuan Kunjungan</th>
                </tr>
              </thead>
              <?php $no = 1; ?>
              <tbody class="text-center text-capitalize">
                @foreach($visit as $visit)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ \Carbon\Carbon::parse($visit->visit_date)->isoFormat('HH:mm') .' '.
                         \Carbon\Carbon::parse($visit->visit_date)->isoFormat('DD MMMM Y') }}</td>
                  <td>{{ $visit->visit_name }}</td>
                  <td>{{ $visit->visit_phone_num }}</td>
                  <td>{{ $visit->visit_vehicle_num }}</td>
                  <td>{{ $visit->visit_description }}</td>
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
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel","pdf"]
    }).buttons().container().appendTo('#table-1_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection


@endsection