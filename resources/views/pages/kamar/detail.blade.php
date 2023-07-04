@extends('layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">WISMA SUKAJADI</h1>
                <h5>Wisma Kemenkes Sukajadi Bandung</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kamar', ['id' => 'daftar']) }}">Daftar Kamar</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<section class="content">
    <div class="container">
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
        <div class="card card-outline card-success">
            <div class="card-header">
                <h5 class="card-title font-weight-bold">{{ $kamar->nama_kamar }}</h5>
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <img class="img-fluid img-thumbnail" src="{{ asset('images/admin/kamar/'. $kamar->foto_kamar) }}">
                    </div>
                    <div class="col-md-8">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <h5 class="card-title">Informasi Kamar</h5>
                                <p class="card-text">
                                <h6>{{ $kamar->nama_kamar }}</h6>
                                <h6>Luas {{ number_format($kamar->luas_kamar, $kamar->luas_kamar == intval($kamar->luas_kamar) ? 0 : 2) }} m<sup>2</sup></h6>
                                <h6>Kapasitas {{ $kamar->kapasitas }} orang</h6>
                                </p>
                            </div>
                            <div class="col-md-4 text-capitalize">
                                <h5 class="card-title">Tarif Sewa</h5>
                                <p class="card-text">
                                    @foreach ($kamar->tarif as $row)
                                <div class="row">
                                    <div class="col-md-4">{{ $row->kategori_tamu }}</div>:
                                    <div class="col-md-7">Rp {{ number_format($row->harga_sewa, 0, ',', '.') }}</div>
                                </div>
                                @endforeach
                                </p>
                                <p class="card-text"> </p>
                            </div>
                            <div class="col-md-4 text-right">
                                <p class="card-text">
                                    @if ($kamar->status_kamar == 5) <span class="badge badge-success">Tersedia</span> @endif
                                    @if ($kamar->status_kamar == 6) <span class="badge badge-danger">Sudah Dipesan</span> @endif
                                    @if ($kamar->status_kamar == 7) <span class="badge badge-warning">Dalam Pemeliharaan</span> @endif
                                </p>
                                <p class="card-text"> </p>
                            </div>
                            <div class="col-md-12 text-capitalize">
                                <h5 class="card-title">Deskripsi</h5>
                                <p class="card-text">
                                    <!-- Deskripsi Kamar -->
                                </p>
                                <p class="card-text"> </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card card-primary card-outline mt-3">
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
                                        <form method="POST" action="{{ route('kamar.edit', $kamar->id_kamar) }}">
                                            @csrf
                                            <input type="hidden" name="process" value="kamar">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Nama Kamar</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="nama_kamar" value="{{ $kamar->nama_kamar }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Kapasitas</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" class="form-control" name="kapasitas" value="{{ $kamar->kapasitas }}" min="1">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Status</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control" name="status_kamar">
                                                            @if($kamar->status_kamar == 5)
                                                            <option value="5">Tersedia</option>
                                                            <option value="6">Tidak Tersedia (Sudah Dipesan)</option>
                                                            <option value="7">Dalam Pemeliharaan</option>
                                                            @elseif($kamar->status_kamar == 6)
                                                            <option value="6">Tidak Tersedia (Sudah Dipesan)</option>
                                                            <option value="5">Tersedia</option>
                                                            <option value="7">Dalam Pemeliharaan</option>
                                                            @else
                                                            <option value="7">Dalam Pemeliharaan</option>
                                                            <option value="5">Tersedia</option>
                                                            <option value="6">Tidak Tersedia (Sudah Dipesan)</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <button type="submit" class="btn btn-primary float-right mt-4" onclick="return confirm('Simpan Perubahan ?')">
                                                            <i class="fas fa-save"></i> Simpan
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="rental-rate">
                                        <form method="POST" action="{{ route('kamar.edit', $kamar->id_kamar) }}">
                                            @csrf
                                            <input type="hidden" name="process" value="riwayat">
                                            <div class="card-body">
                                                @foreach($kamar->tarif as $row)
                                                <input type="hidden" name="id_tarif_sewa[]" value="{{ $row->id_tarif_sewa }}">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Tarif Sewa</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control text-capitalize" name="kategori_tamu[]" value="{{ $row->kategori_tamu }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Harga (Rp)</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control input-format" name="harga_sewa[]" value="{{ number_format($row->harga_sewa, 0, ',', '.') }}">
                                                    </div>
                                                </div>
                                                @endforeach
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">&nbsp;</label>
                                                    <div class="col-sm-5">
                                                        <button type="submit" class="btn btn-primary mt-4" onclick="return confirm('Simpan Perubahan ?')">
                                                            <i class="fas fa-save"></i> Simpan
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><br>


@section('js')
<script>
    $(document).ready(function() {
        $('.input-format').on('input', function() {
            // Menghapus karakter selain angka (termasuk tanda titik koma sebelumnya)
            var value = $(this).val().replace(/[^0-9]/g, '');

            // Format dengan menambahkan titik koma setiap tiga digit
            var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Memasukkan nilai yang sudah diformat kembali ke input
            $(this).val(formattedValue);
        });
    });
</script>
@endsection

@endsection
