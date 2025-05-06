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
            <div class="col-md-3 mx-auto">
                <a type="button" data-toggle="modal" data-target="#detail">
                    <img src="{{ asset('images/main/logo-kemenkes.png') }}" class="img-fluid mt-5" alt="">
                </a>
                <div class="modal fade" id="detail" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Tarif Sewa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="{{ asset('images/main/logo-kemenkes.png') }}" class="img-fluid border border-dark" alt="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-8 mx-auto">
                <form id="form" action="{{ route('reservasi.book', 'proses') }}" method="GET">
                    @csrf
                    <input type="hidden" name="proses" value="true">

                    <div class="d-flex">
                        <div class="w-50 mr-1">
                            <label class="text-sm font-weight-bold text-dark">Asal Instansi</label>
                            <div class="input-group">
                                <div class="custom-control custom-radio text-black">
                                    <input class="custom-control-input" type="radio" id="radio1" name="instansi" value="kemenkes" <?php echo $id == 'kemenkes' ? 'checked' : ''; ?>>
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

                    <div class="d-flex mt-3">
                        <div class="w-50 mr-1">
                            <label class="text-sm font-weight-bold text-dark">Nama Lengkap*</label>
                            <input type="text" class="form-control border-secondary rounded text-dark" name="nama" required>
                        </div>
                        <div class="w-50 ml-1">
                            <label class="text-sm font-weight-bold text-dark">No. Handphone*</label>
                            <input type="text" class="form-control border-secondary rounded text-dark" name="nohp" required>
                        </div>
                    </div>

                    <div class="kemenkes" style="<?php echo $id != 'kemenkes' ? 'display: none;' : 'display: block;' ?>">
                        <div class="d-flex mt-3">
                            <div class="w-50 mr-1">
                                <label class="text-sm font-weight-bold text-dark">NIP*</label>
                                <input type="text" class="form-control border border-dark rounded text-dark" name="nik" value="{{ $nik }}">
                            </div>
                            <div class="w-50 ml-1">
                                <label class="text-sm font-weight-bold text-dark">Unit Kerja*</label>
                                <select name="uker" class="text-dark rounded border-secondary uker" style="width: 100%;">
                                    <option value="">-- PILIH UNIT KERJA --</option>
                                    @foreach ($uker as $row)
                                    <option value="{{ $row->id_unit_kerja }}">{{ strtoupper($row->nama_unit_kerja) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="umum" style="display: none;">
                        <div class="d-flex mt-3">
                            <div class="w-100 mr-1">
                                <label class="text-sm font-weight-bold text-dark">Nama Instansi</label>
                                <input type="text" class="form-control border-secondary rounded text-dark" name="nama_instansi" id="name">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mt-3">
                        <div class="w-25 mr-3">
                            <label class="text-sm font-weight-bold text-dark">Jumlah Kamar*</label>
                            <input type="number" class="form-control border-secondary rounded text-dark text-center" name="kamar" min="1" value="{{ $kamar }}" required>
                        </div>
                        <div class="w-50 mr-2">
                            <label class="text-sm font-weight-bold text-dark">Check In*</label>
                            <input id="checkInDate" type="date" class="form-control border-secondary rounded text-dark" name="masuk" min="{{ date('Y-m-d') }}" value="{{ $masuk }}" required>
                        </div>
                        <div class="w-50 ml-2">
                            <label class="text-sm font-weight-bold text-dark">Check Out*</label>
                            <input id="checkOutDate" type="date" class="form-control border-secondary rounded text-dark" name="keluar" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ $keluar }}" required>
                        </div>
                    </div>

                    <div class="mt-3 form-group row text-right">
                        <div class="col-md-9">
                            <div class="g-recaptcha" data-sitekey="6LcVm4YqAAAAAP5WdcWCmKLp2aNpjhu9WahaEpz8"></div>
                        </div>
                        <div class="col-md-3 my-auto">
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
                var instansi = document.querySelector('input[name="instansi"]:checked');
                var namaInstansi = instansi.value == 'kemenkes' ? document.getElementsByName('uker')[0] : document.getElementsByName('nama_instansi')[0];

                if (!nama.value || !nohp.value || !instansi.value || !namaInstansi.value) {
                    Swal.fire({
                        title: 'Gagal',
                        text: "Terdapat informasi yang belum di lengkapi.",
                        icon: 'warning'
                    })
                } else {
                    // Periksa reCAPTCHA
                    var response = grecaptcha.getResponse();
                    if (!response) {
                        Swal.fire({
                            title: 'Verifikasi Gagal',
                            text: "Silakan selesaikan CAPTCHA.",
                            icon: 'error'
                        });
                    } else {
                        document.getElementById('form').submit();
                    }
                }
            }
        });

        return false; // Prevent the default form submission
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Tanggal yang dinonaktifkan
        const disabledDates = [
            "2025-05-09", "2025-05-10", "2025-05-11", "2025-05-12"
        ];

        const dates = [
            document.getElementById("checkInDate"),
            document.getElementById("checkOutDate")
        ];

        dates.forEach(input => {
            if (input) {
                // Set min and max range
                input.min = "2025-05-09"
                input.max = "2025-05-12";

                // Add event listener
                input.addEventListener("input", function() {
                    const selectedDate = this.value;

                    // Jika tanggal yang dipilih ada dalam daftar disabledDates
                    if (disabledDates.includes(selectedDate)) {
                        alert("Tanggal yang dipilih tidak tersedia. Silakan pilih tanggal lain.");
                        this.value = ""; // Reset nilai input
                    }
                });
            }
        });
    });
</script>
@endsection



@endsection
