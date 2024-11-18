@extends('app')
@section('content')


<section id="main-container" class="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-7 mx-auto">
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
                <div class="card border-dark text-dark">
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <label class="w-50 h5"><b>Reservasi</b><small>#{{ $data->id_reservasi }}</small></label>
                            <label class="w-50 text-right my-auto">
                                {{ Carbon\Carbon::parse($data->tanggal_reservasi)->isoFormat('DD MMMM Y') }}
                            </label>
                        </div>
                        <div class="input-group my-2">
                            <label class="w-25 h6">Nama</label>
                            <label class="w-75 h6">: {{ $data->pengunjung->nama_pengunjung }}</label>
                        </div>
                        @if ($data->pengunjung->instansi == 'kemenkes')
                        <div class="input-group my-2">
                            <label class="w-25 h6">NIP</label>
                            <label class="w-75 h6">: {{ $data->pengunjung->nik }}</label>
                        </div>
                        @endif
                        <div class="input-group my-2">
                            <label class="w-25 h6">Asal Instansi</label>
                            <label class="w-75 h6">: {{ $data->pengunjung->instansi == 'kemenkes' ? 'Kementerian Kesehatan' : 'Umum' }}</label>
                        </div>
                        <div class="input-group my-2">
                            <label class="w-25 h6">Nama Instansi</label>
                            <label class="w-75 h6">: {{ $data->pengunjung->unitKerja->nama_unit_kerja ?? $data->pengunjung->keterangan }}</label>
                        </div>
                        <div class="input-group my-2">
                            <label class="w-25 h6">Total Kamar</label>
                            <label class="w-75 h6">: {{ $data->total_kamar }} kamar</label>
                        </div>
                        <div class="input-group my-2">
                            <label class="w-25 h6">Tanggal Reservasi</label>
                            <label class="w-75 h6">:
                                {{ Carbon\Carbon::parse($data->tanggal_masuk)->isoFormat('DD MMMM Y') }} -
                                {{ Carbon\Carbon::parse($data->tanggal_keluar)->isoFormat('DD MMMM Y') }}
                            </label>
                        </div>
                        <div class="input-group my-2">
                            <label class="w-25 h6">Status</label>
                            <label class="w-75 h6">:
                                @if ($data->status_reservasi == 10)
                                <span class="badge badge-warning">PROSES</span>
                                @endif
                            </label>
                        </div>
                        <div class="input-group my-2 mt-5">
                            <label class="text-danger">
                                Hati-hati Penipuan Mengatasnamakan Pengelola Wisma Kemenkes Sukajadi Melalui Website.
                                Info lainnya dapat menghubungi <b><u>(022) 2031152</u></b>.
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@section('js')
<script>
    function confirmSubmit() {
        Swal.fire({
            title: 'Reservasi ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            confirmButtonClass: 'bg-success',
        }).then((result) => {
            if (result.isConfirmed) {
                var kamar = document.getElementsByName('kamar')[0];
                var masuk = document.getElementsByName('masuk')[0];
                var keluar = document.getElementsByName('keluar')[0];
                var nama = document.getElementsByName('nama')[0];
                var nohp = document.getElementsByName('nohp')[0];
                var instansi = document.getElementsByName('instansi')[0];
                var namaInstansi = document.getElementsByName('nama_instansi')[0];

                if (!nama.value || !nohp.value || !instansi.value || !namaInstansi.value) {
                    Swal.fire({
                        title: 'Gagal',
                        text: "Terdapat informasi yang belum di lengkapi.",
                        icon: 'warning'
                    })
                } else {
                    document.getElementById('form').submit();
                }
            }
        });

        return false; // Prevent the default form submission
    }
</script>
@endsection



@endsection
