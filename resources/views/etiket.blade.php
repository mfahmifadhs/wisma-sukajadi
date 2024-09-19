@extends('app')
@section('content')


<section id="main-container" class="main-container">
    <div class="container">
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
            <div class="col-md-7 mx-auto">
                <div class="card border-dark">
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <h4 class="w-50">Reservasi</h4>
                            <label class="w-50 text-right my-auto">
                                KODE TIKET #{{ Carbon\Carbon::parse($data->tanggal_reservasi)->format('dmy').$data->id_reservasi }}
                            </label>
                        </div>
                        <div class="input-group my-2">
                            <h6 class="w-25">Nama</h6>
                            <h6 class="w-75">: {{ $data->pengunjung->nama_pengunjung }}</h6>
                        </div>
                        <div class="input-group my-2">
                            <h6 class="w-25">Total Kamar</h6>
                            <h6 class="w-75">: {{ $data->total_kamar }} kamar</h6>
                        </div>
                        <div class="input-group my-2">
                            <h6 class="w-25">Tanggal Masuk</h6>
                            <h6 class="w-75">: {{ Carbon\Carbon::parse($data->tanggal_masuk)->isoFormat('DD MMMM Y') }}</h6>
                        </div>
                        <div class="input-group my-2">
                            <h6 class="w-25">Tanggal Keluar</h6>
                            <h6 class="w-75">: {{ Carbon\Carbon::parse($data->tanggal_keluar)->isoFormat('DD MMMM Y') }}</h6>
                        </div>
                        <div class="input-group my-2">
                            <h6 class="w-25">Status</h6>
                            <h6 class="w-75">:
                                @if ($data->status_reservasi == 10)
                                <span class="badge badge-warning">ONGOING</span>
                                @endif
                            </h6>
                        </div>
                        <div class="input-group my-2">
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
