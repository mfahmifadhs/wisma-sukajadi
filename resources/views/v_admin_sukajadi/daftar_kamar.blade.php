@extends('v_admin_sukajadi.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Kamar</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Daftar Kamar</li>
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
      <div class="col-md-3">
        <!-- /.card -->
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title"><b>Kapasitas Kamar</b></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
              @foreach($total as $totals)
              <li class="nav-item text-capitalize">
                <a href="{{ url('admin-sukajadi/kamar/'. $totals->room_status) }}" class="nav-link">
                  @if( $totals->room_status == 'tersedia')
                  <i class="fas fa-bed text-success"></i> tersedia
                  <span class="badge bg-success float-right mt-1">{{ $totals->total_room }} kamar</span>
                  @elseif( $totals->room_status == 'tidak tersedia')
                  <i class="fas fa-bed text-warning"></i> Dipesan
                  <span class="badge bg-warning float-right mt-1">{{ $totals->total_room }} kamar</span>
                  @else
                  <i class="fas fa-bed text-danger"></i> pemeliharaan
                  <span class="badge badge-danger float-right mt-1">{{ $totals->total_room }} kamar</span>
                  @endif
                </a>
              </li>
              @endforeach
              <li class="nav-item text-capitalize">
                <a href="{{ url('admin-sukajadi/kamar/daftar') }}" class="nav-link">
                  <i class="fas fa-bed text-info"></i> seluruh kamar
                  <span class="badge badge-info float-right mt-1">{{ $total->sum('total_room') }} kamar</span>
                </a>
              </li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col-md-9">
        <div class="row">
          @foreach($rooms as $room)
          <div class="col-md-12 form-group">
            <div class="card card-primary card-outline" style="height: 100%;">
              <div class="card-header">
                <h5 class="card-title mt-1"><b>{{ $room->room_name }}</b></h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <img src="{{ asset('images/admin/kamar/'. $room->room_img) }}" class="img-thumbnail" style="width: 100%;max-height: 100%;">
                  </div>
                  <div class="col-md-8">
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label>Kamar : </label>
                        <h6>{{ $room->room_name }}</h6>
                      </div>
                      <div class="col-md-4">
                        <label>Kapasitas : </label>
                        <h6>{{ $room->room_capacity }} orang</h6>
                      </div>
                      <div class="col-md-4">
                        <label>Status : </label>
                        <h6>
                          @if( $room->room_status == 'tersedia')
                          <span class="badge bg-success">Tersedia</span>
                          @elseif( $room->room_status == 'tidak tersedia')
                          <span class="badge bg-warning">Dipesan</span>
                          @elseif( $room->id_room == 10)
                          <span class="badge badge-danger">Tidak Disewakan (Ruang kantor)</span>
                          @else
                          <span class="badge badge-danger">Dibersihkan</span>
                          @endif
                        </h6>
                      </div>
                      <div class="col-md-12">
                        <hr>
                        <label>Harga Tarif Sewa</label>
                        <hr>
                      </div>
                      @foreach($room->rentalrate as $rentalrate)
                      <div class="col-md-4 text-capitalize form-group">
                        <label>{{ $rentalrate->rental_rate_ctg }}</label>
                        @if($rentalrate->rental_rate_ctg == 'bisnis')
                          <h6>{{ 'Rp '. number_format($rentalrate->price, 0, ',', '.') }}</h6>
                        @else
                         <h6>{{ $rentalrate->price_ctg.' : Rp '. number_format($rentalrate->price, 0, ',', '.') }}</h6>
                        @endif
                      </div>
                      @endforeach
                    </div>
                  </div>
                  
                </div>
              </div>
              <div class="card-footer">
                <span class="float-right">
                  <a href="{{ url('admin-sukajadi/kamar/detail/'. $room->id_room) }}" class="btn btn-primary"><i class="fas fa-info-circle"></i> Detail</a>
                </span>
              </div>
            </div>
          </div>
          @endforeach
          <div class="col-md-12">
            {{ $rooms->links("pagination::bootstrap-4") }}
          </div>
        </div>
      </div>
    </div>

    

  </div>
</section>

@endsection