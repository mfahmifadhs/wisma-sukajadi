@extends('v_admin_sukajadi.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Keterangan Penggunaan Kamar</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/reservasi/daftar') }}">Reservasi</a></li>
          <li class="breadcrumb-item active">Keterangan Penggunaan Kamar oleh Tamu</li>
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
        <div class="card card-primary card-outline" style="margin-left: 10%;margin-right: 10%;">
          <div class="card-header">
            <h3 class="card-title">Keterangan Penggunaan Kamar (Apabila terdapat kerusakan/kehilangan barang)</h3>
          </div>
          <!-- /.card-header -->
          <form action="{{ url('admin-sukajadi/kamar/tambah-keterangan/'. $reservasi->id_reservation) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="form-group row">
                <label class="col-sm-12 col-form-label text-center">Informasi Pengunjung <hr></label>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">NIK</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" value="{{ $reservasi->identity_num }}" readonly>
                </div>
                <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" value="{{ $reservasi->visitor_name }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">No. Hp</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" value="{{ $reservasi->visitor_phone_number }}" readonly>
                </div>
                <label class="col-sm-2 col-form-label">Keterangan</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" value="{{ $reservasi->visitor_description }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-12 col-form-label text-center"><hr>Informasi Kamar <hr></label>
                @foreach($room as $room)
                <input type="hidden" name="id_detail_reservation[]" value="{{ $room->id_detail_reservation }}">
                <label class="col-sm-2 col-form-label form-group">Kamar</label>
                <div class="col-sm-4 form-group">
                  <input type="text" class="form-control" value="{{ $room->room_name }}" readonly>
                </div>
                <label class="col-sm-2 col-form-label form-group">Tarif Sewa</label>
                <div class="col-sm-4 form-group">
                  <input type="text" class="form-control" value="{{ $room->rental_rate_ctg }}" readonly>
                </div>
                <label class="col-sm-2 col-form-label form-group">Catatan</label>
                <div class="col-sm-10 form-group">
                  <textarea class="form-control" name="room_notes[]" rows="3" placeholder="Catatan penggunaan kamar apabila terdapat kehilangan atau kerusakan yang dilakukan oleh tamu">{{ $room->notes }}</textarea>
                </div>
                @endforeach
              </div>
            </div>
            <div class="card-footer">
              <div class="float-right">
                <button type="submit" class="btn btn-primary" onclick="return confirm('Tambah Catatan ?')">
                  <i class="fas fa-plus-square"></i> Tambah Catatan</button>
              </div>
              <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection