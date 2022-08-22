@extends('v_admin_master.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Laporan Penggunaan Kamar</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/kamar/daftar') }}">Daftar Kamar</a></li>
          <li class="breadcrumb-item active">Laporan Kamar</li>
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
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title mt-2"><b>Daftar Penggunaan Kamar</b></h3>
            <div class="card-tools">
              <a type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-filter">
                <i class="fas fa-filter"></i> Filter
              </a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="table-1" class="table table-bordered table-striped responsive">
              <thead class="text-center">
                <tr>
                  <th style="width: 5%;">No</th>
                  <th style="width: 20%;">Kode Biling</th>
                  <th style="width: 20%;">Tanggal</th>
                  <th style="width: 15%;">Total Kamar</th>
                  <th style="width: 15%;">Dipesan</th>
                  <th style="width: 15%;">Tidak Tersedia</th>
                  <th style="width: 15%">Tersedia</th>
                </tr>
              </thead>
              <?php $no = 1; ?>
              <tbody class="text-capitalize text-center">
                @foreach($rooms as $rooms)
                <tr class="clickable-row" data-href="{{ url('admin-sukajadi/rooms/detail/'.$rooms->id_reservation) }}">
                  <td class="pt-3">{{ $no++ }}</td>
                  <td class="pt-3">{{ $rooms->billing_code }}</td>
                  <td class="pt-3">
                    {{ \Carbon\Carbon::parse($rooms->history_date)->isoFormat('DD/MM/Y HH:mm:ss') }}
                  </td>
                  <td class="pt-3">{{ $rooms->total_room }} kamar</td>
                  <td class="pt-3">{{ $rooms->room_reserved }} kamar</td>
                  <td class="pt-3">{{ $rooms->room_notavailable }} kamar</td>
                  <td class="pt-3">{{ $rooms->room_available }} kamar</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->

        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="modal-filter">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Cari Bedasarkan Tanggal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ url('admin-master/laporan/kamar') }}" method="POST">
              @csrf
              <div class="modal-body">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Pilih Tanggal :</label>
                    <input type="date" class="form-control" name="start_dt" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}">
                  </div>
                  <div class="form-group col-md-6"> 
                    <label>&nbsp;</label>
                    <input type="date" class="form-control" name="end_dt" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}">
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <span class="float-left">
                  <a href="{{ url('admin-master/laporan/kamar') }}" class="btn btn-danger btn-sm"><i class="fas fa-sync"></i> Muat</a>
                </span>
                <span class="float-right">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                </span>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </div>
  </div>
</section>
<!-- End Main Content -->
@section('js')
<script>
  $(function () {
    $("#table-1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel","pdf"]
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