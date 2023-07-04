@extends('layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">WISMA SUKAJADI</h1>
                <h5>Wisma Kemenkes Sukajadi Bandung</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-capitalize">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('unit_kerja.show') }}">Daftar Unit Kerja</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('alokasi_anggaran.show') }}">Alokasi Anggaran</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p style="color:white;margin: auto;">{{ $message }}</p>
        </div>
        @endif
        @if ($message = Session::get('failed'))
        <div class="alert alert-danger">
            <p style="color:white;margin: auto;">{{ $message }}</p>
        </div>
        @endif
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Edit Unit Kerja</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('unit_kerja.edit', $unitKerja->id_unit_kerja) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Unit Utama</label>
                        <div class="col-md-6">
                            <select class="form-control" name="unit_utama_id">
                                <option value="{{ $unitKerja->unit_utama_id }}">
                                    {{ $unitKerja->unitUtama->kode_unit_utama.' - '.$unitKerja->unitUtama->nama_unit_utama }}
                                </option>
                                @foreach ($unitUtama->where('id_unit_utama','!=',$unitKerja->unitUtama->id_unit_utama) as $row)
                                <option value="{{ $row->id_unit_utama }}">
                                    {{ $row->kode_unit_utama.' - '.$row->nama_unit_utama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kode Unit Kerja</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="kode_unit_kerja" value="{{ $unitKerja->kode_unit_kerja }}" placeholder="Kode Unit Utama" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Unit Kerja</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="nama_unit_kerja" value="{{ $unitKerja->nama_unit_kerja }}" placeholder="Nama Unit Utama" required>
                        </div>
                    </div>
                    @if ($unitKerja->unit_utama_id == 4)
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nilai Alokasi*</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control input-format" name="alokasi_anggaran" placeholder="Nilai Anggaran"
                            value="{{ number_format($unitKerja->alokasi_anggaran, 0, ',', '.') }}" required>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Simpan Perubahan ?')">
                        <i class="fas fa-save fa-1x"></i> <b>Simpan</b>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>


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
