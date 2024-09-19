@extends('app')
@section('content')


<section id="main-container" class="main-container">
    <div class="container">
        <h3 class="text-center">Reservasi</h3>
        <!--/ Title row end -->
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
            <div class="col-md-9 mx-auto">
                <form id="form" action="{{ route('reservasi.book') }}" method="GET">
                    @csrf
                    <input type="hidden" name="proses" value="true">
                    <div class="form-group row">
                        <h4 class="col-md-4 mt-2">Jumlah Kamar</h4>
                        <div class="col-md-7">
                            <input type="number" class="form-control border-secondary rounded text-dark" name="kamar" min="1" value="{{ $kamar }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <h4 class="col-md-4 mt-2">Tanggal Menginap</h4>
                        <div class="col-md-7">
                            <div class="input-group">
                                <input type="date" class="form-control border-secondary rounded text-dark" name="masuk" min="{{ date('Y-m-d') }}" value="{{ $masuk }}" required>
                                <span class="mx-2 my-auto">-</span>
                                <input type="date" class="form-control border-secondary rounded text-dark" name="keluar" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ $keluar }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <h4 class="col-md-4 mt-2">Nama Lengkap</h4>
                        <div class="col-md-7">
                            <input type="text" class="form-control border-secondary rounded text-uppercase" name="nama" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <h4 class="col-md-4 mt-2">Nomor HP</h4>
                        <div class="col-md-7">
                            <input type="number" class="form-control border-secondary rounded text-dark" name="nohp" required>
                        </div>
                    </div>

                    <div class="form-group row mt-2">
                        <h4 class="col-md-4 mt-1">Asal Instansi</h4>
                        <div class="col-md-7 mt-1">
                            <div class="input-group">
                                <div class="custom-control custom-radio text-black">
                                    <input class="custom-control-input" type="radio" id="radio1" name="instansi" value="kemenkes">
                                    <label for="radio1" class="custom-control-label">KEMENKES</label>
                                </div>
                                <span class="mx-3"></span>
                                <div class="custom-control custom-radio text-black">
                                    <input class="custom-control-input" type="radio" id="radio2" name="instansi" value="umum">
                                    <label for="radio2" class="custom-control-label">UMUM</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row kemenkes" style="display: none;">
                        <h4 class="col-md-4 mt-1">Unit Kerja*</h4>
                        <div class="col-md-7">
                            <select name="uker" class="text-dark rounded border-success uker" style="width: 100%; height: 100%;">
                                <option value="">-- PILIH UNIT KERJA --</option>
                                @foreach ($uker as $row)
                                <option value="{{ $row->id_unit_kerja }}">{{ strtoupper($row->nama_unit_kerja) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row umum" style="display: none;">
                        <h4 class="col-md-4 mt-2">Nama Instansi</h4>
                        <div class="col-md-7">
                            <input type="text" class="form-control border-success rounded text-uppercase text-dark" name="nama_instansi" id="name" required>
                        </div>
                    </div>
                    <div class="form-group row text-right">
                        <div class="col-md-4">&nbsp;</div>
                        <div class="col-md-7">
                            <button class="btn btn-primary btn-block" onclick="return confirmSubmit()">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>

        </div><!-- Content row -->
    </div><!-- Conatiner end -->
</section><!-- Main container end -->

@section('js')
<script>
    $('.uker').select2()
    $('input[name="instansi"]').change(function() {
        var selectedValue = $(this).val()

        // Menampilkan/menyembunyikan div berdasarkan nilai yang dipilih
        if (selectedValue === 'kemenkes') {
            $('.kemenkes').show()
            $('.umum').hide()
        } else if (selectedValue === 'umum') {
            $('.kemenkes').hide()
            $('.umum').show()
        }
    });

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
                var namaInstansi = instansi.value == 'kemenkes' ? document.getElementsByName('uker')[0] : document.getElementsByName('nama_instansi')[0];

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
