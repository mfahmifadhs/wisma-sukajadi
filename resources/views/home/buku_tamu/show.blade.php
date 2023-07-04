@extends('home.app')
@section('content')


<section id="main-container" class="main-container">
    <div class="container">
        <h3 class="text-center">BUKU TAMU</h3>
        <!--/ Title row end -->
        <div class="row">
            <div class="col-md-11">
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
                <form id="form" action="{{ route('home.buku_tamu') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <h4 class="col-md-3 mt-2">Nama Lengkap</h4>
                        <div class="col-md-8">
                            <input type="text" class="form-control border-success rounded text-uppercase" name="nama_tamu" id="name" placeholder="Masukkan Nama Lengkap" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <h4 class="col-md-3 mt-2">Nomor HP</h4>
                        <div class="col-md-8">
                            <input type="number" class="form-control border-success rounded text-uppercase" name="no_hp" id="name" placeholder="Nomor HP Aktif" required>
                        </div>
                    </div>

                    <div class="form-group row mt-2">
                        <h4 class="col-md-3 mt-1">Asal Instansi</h4>
                        <div class="col-md-8 mt-1">
                            <div class="custom-control custom-radio text-black">
                                <input class="custom-control-input" type="radio" id="radio1" name="instansi" value="kemenkes">
                                <label for="radio1" class="custom-control-label">KEMENKES</label>
                            </div>
                            <div class="custom-control custom-radio text-black">
                                <input class="custom-control-input" type="radio" id="radio2" name="instansi" value="umum">
                                <label for="radio2" class="custom-control-label">UMUM</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <h4 class="col-md-3 mt-2">Nama Instansi</h4>
                        <div class="col-md-8">
                            <input type="text" class="form-control border-success rounded text-uppercase" name="nama_instansi" id="name" placeholder="Nama Instansi/Nama Unit Kerja" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <h4 class="col-md-3 mt-2">Nomor Kendaraan</h4>
                        <div class="col-md-8">
                            <input type="text" class="form-control border-success rounded text-uppercase" name="no_kendaraan" placeholder="Nomor Kendaraan" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <h4 class="col-md-3 mt-2">Keterangan</h4>
                        <div class="col-md-8">
                            <textarea name="keterangan" rows="3" class="form-control border-success rounded text-uppercase" placeholder="Maksud/Tujuan Kedatangan"></textarea>
                        </div>
                    </div>
                    <div class="form-group row text-right">
                        <div class="col-md-11">
                            <button class="btn btn-primary" onclick="return confirmSubmit()">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>

        </div><!-- Content row -->
    </div><!-- Conatiner end -->
</section><!-- Main container end -->

@section('js')
<script>
    function confirmSubmit() {
        Swal.fire({
            title: 'Apakah informasi sudah benar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            confirmButtonClass: 'bg-success',
        }).then((result) => {
            if (result.isConfirmed) {
                var namaTamu = document.getElementsByName('nama_tamu')[0];
                var noHp = document.getElementsByName('no_hp')[0];
                var instansi = document.getElementsByName('instansi')[0];
                var namaInstansi = document.getElementsByName('nama_instansi')[0];
                var keterangan = document.getElementsByName('keterangan')[0];

                if (!namaTamu.value || !noHp || !instansi || !namaInstansi || !keterangan ) {
                    Swal.fire({
                        title: 'Gagal',
                        text: "Terdapat informasi yang belum di lengkapi.",
                        icon: 'warning'
                    })
                }

                document.getElementById('form').submit();
            }
        });

        return false; // Prevent the default form submission
    }
</script>
@endsection



@endsection
