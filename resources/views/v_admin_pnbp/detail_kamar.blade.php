@extends('v_admin_pnbp.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Detail Kamar</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-pnbp/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('admin-pnbp/kamar/daftar') }}">Daftar Kamar</a></li>
          <li class="breadcrumb-item active">Detail Kamar</li>
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
      <div class="col-md-3">
        <div class="row">
          <div class="col-md-12">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title">Informasi Kamar</h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="img-fluid img-thumbnail" src="{{ asset('images/admin/kamar/'. $room->room_img) }}" alt="Foto KTP">
                </div>
                <hr>
                <strong><i class="fas fa-house-user mr-1"></i> Kamar</strong>
                <span class="badge float-right mt-1">{{ $room->room_name }}</span>
                <hr>
                <strong><i class="fas fa-people-arrows mr-1"></i> Kapasitas</strong>
                <span class="badge float-right mt-1">{{ $room->room_capacity }} orang</span>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
             <div class="card-header">
                <h5 class="card-title">Tarif Sewa Kamar</h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body box-profile text-capitalize">
                @foreach($rentalrate as $rentalrateinfo)
                <strong>
                  <i class="fas fa-house-user mr-1"></i> {{ $rentalrateinfo->rental_rate_ctg }}
                </strong>
                <span class="badge float-right mt-3">Rp {{ number_format($rentalrateinfo->price, 0, ',', '.') }}</span>
                <br>
                <span style="font-size: 12px;">{{ $rentalrateinfo->rental_rate_ctg }}</span>
                <hr>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        
      </div>
      <div class="col-md-9">
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
        <div class="card ard-primary card-outline">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#information" data-toggle="tab">Informasi Kamar</a></li>
              <li class="nav-item"><a class="nav-link" href="#rental-rate" data-toggle="tab">Harga Tarif Sewa</a></li>
              <li class="nav-item"><a class="nav-link" href="#history" data-toggle="tab">Riwayat</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="information">
                <form method="POST" action="{{ url('admin-pnbp/kamar/update/informasi-kamar') }}">
                  @csrf
                  <input type="hidden" name="room_id" value="{{ $room->id_room }}">
                  <div class="card-body">
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Nama Kamar</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="room_name" value="{{ $room->room_name }}" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Kapasitas</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="room_capacity" value="{{ $room->room_capacity }}" min="1" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Status</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="room_status" readonly>
                          @if($room->room_status == 'tersedia')
                          <option value="tersedia">tersedia</option>
                          <option value="tidak tersedia">dipesan</option>
                          <option value="maintenance">tidak tersedia</option>
                          @elseif($room->room_status == 'tidak tersedia')
                          <option value="tidak tersedia">dipesan</option>
                          <option value="tersedia">tersedia</option>
                          <option value="maintenance">tidak tersedia</option>
                          @else
                          <option value="maintenance">tidak tersedia</option>
                          <option value="tersedia">tersedia</option>
                          <option value="tidak tersedia">dipesan</option>
                          @endif
                        </select>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane" id="rental-rate">
                <form method="POST" action="{{ url('admin-pnbp/kamar/update/tarif-sewa') }}">
                  @csrf
                  <input type="hidden" name="room_id" value="{{ $room->id_room }}">
                  <div class="card-body">
                    @foreach($rentalrate as $rentalrate)
                    <input type="hidden" name="id_rental_rate[]" value="{{ $rentalrate->id_rental_rate }}">
                    <div class="form-group row">
                      <label class="col-sm-2 mt-4 col-form-label">Tarif Sewa</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control mt-4" name="rentalrate[]" value="{{ $rentalrate->rental_rate_ctg }}" readonly>
                      </div>
                      <label class="col-sm-2 mt-4 col-form-label">Kategori</label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control mt-4" name="category[]" value="{{ $rentalrate->price_ctg }}" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Harga (Rp)</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="price[]" value="{{ $rentalrate->price }}" min="1" readonly>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </form>
              </div>
              <div class="tab-pane" id="history">
                <table class="table m-0">
                  <thead>
                    <tr>
                      <th>Kode Biling</th>
                      <th>Durasi</th>
                      <th>Total Pembayaran</th>
                      <th>Status</th>
                    </tr>
                  </thead>  
                  <tbody class="text-capitalize">
                    @foreach($reservasi as $history)
                    <tr>
                      <td><a href="{{ url('admin-pnbp/reservasi/detail/'. $history->id_reservation) }}">{{ $history->billing_code }}</a></td>
                      <td>{{ $history->duration }} malam</td>
                      <td>Rp {{ number_format($history->payment_total, 0, ',', '.') }}</td>
                      <td>{{ $history->status_reservation }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection