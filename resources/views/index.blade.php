@extends('home.app')

@section('content')

@if ($message = Session::get('failed'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ $message }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
</script>
@endif

<div class="banner-carousel banner-carousel-1 mb-0">
    <div class="banner-carousel-item" style="background-image:url(images/main/slider-main/sukajadi-2.jpg)">
        <div class="slider-content">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-md-12 text-center">
                        <!-- <h2 class="slide-title-box" data-animation-in="slideInDown">TERBUKA UNTUK UMUM</h2> -->
                        <h5 class="slide-sub-title" data-animation-in="slideInRight">SELAMAT DATANG DI</h5>
                        <h3 class="slide-sub-title" data-animation-in="slideInRight">WISMA SUKAJADI BANDUNG</h3>
                        <h2 class="slide-title-box" data-animation-in="slideInDown">Kementerian Kesehatan Republik Indonesia</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="banner-carousel-item" style="background-image:url(images/main/slider-main/sukajadi-1.jpg)">
        <div class="slider-content text-left">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-md-12">
                        <h2 class="slide-title-box" data-animation-in="slideInDown">LOKASI DI PUSAT KOTA</h2>
                        <h3 class="slide-sub-title" data-animation-in="slideInLeft">PILIHAN UNTUK MENGINAP DI PUSAT KOTA BANDUNG</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="banner-carousel-item" style="background-image:url(images/main/slider-main/sukajadi-3.jpg)">
        <div class="slider-content text-right">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-md-12">
                        <h2 class="slide-title-box" data-animation-in="slideInDown">RUANG PERTEMUAN</h2>
                        <h3 class="slide-sub-title" data-animation-in="fadeIn">Fasilitas Untuk Mengadakan Pertemuan</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="call-to-action-box no-padding rounded">
    <div class="container">
        <div class="action-style-box">
            <h4 class="text-center text-white">
                <form action="{{ route('reservasi.book', 'umum') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <h2 class="text-white font-weight-bold">Reservasi</h2>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-lowercase text-capitalize text-white">Jumlah Kamar</h6>
                            <input type="number" class="form-control form-control-sm rounded text-center text-dark" name="kamar" min="1" value="1" required>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-lowercase text-capitalize text-white">Tanggal Masuk</h6>
                            <input type="date" class="form-control form-control-sm rounded text-center text-dark" name="masuk" id="checkInDate" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-lowercase text-capitalize text-white">Tanggal Keluar</h6>
                            <input type="date" class="form-control form-control-sm rounded text-center text-dark" name="keluar" id="checkOutDate" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-lowercase text-capitalize text-white">&nbsp;</h6>
                            <div class="input-group">
                                <div class="w-100">
                                    <button class="btn btn-warning font-weight-bold" style="height: 110%;">BOOK</button>
                                    <a href="" data-toggle="modal" data-target="#modalCekBook" class="btn btn-secondary font-weight-bold pt-2" style="height: 110%;">
                                        CEK RESERVASI
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 mx-auto mt-2">
                            <small class="text-lowercase text-capitalize">
                                <i class="fas fa-triangle-exclamation text-warning"></i>
                                <i class="text-danger">PERINGATAN</i> <br>Hati-hati Penipuan Mengatasnamakan Pengelola Wisma Kemenkes Sukajadi Melalui Website. <br>
                                Info lainnya dapat menghubungi <b><u>(022) 2031152</u></b>.
                            </small>
                        </div>
                    </div>
                </form>
            </h4>
        </div>
    </div>
</section>

<!-- Modal Cek Reservasi -->
<div class="modal fade" id="modalCekBook" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('reservasi.etiket', 'cari') }}" method="GET">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <label class="text-dark"><b>Masukkan Kode Reservasi</b></label>
                    <input type="text" class="form-control border-dark rounded text-dark text-center number" name="id_reservasi" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<section id="ts-features" class="ts-features">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="ts-intro">
                    <h2 class="into-title">Tentang</h2>
                    <h3 class="into-sub-title">Wisma Sukajadi</h3>
                    <p style="text-align: justify;">Wisma Kemenkes RI Sukajadi Bandung adalah penginapan yang terbuka untuk umum untuk seluruh masyarakat yang ingin menginap. Dengan lokasi yang terletak
                        di Jl. Sukajadi No.155, Cipedes, Kec. Sukajadi, Kota Bandung. yang dekat dengan Pusat Kota Bandung. Selain itu, dengan lokasi yang strategis, fasilitas
                        yang bersih dan nyaman. Wisma Kemenkes Sukajadi Bandung memberikan harga yang sangat bersahabat untuk para pengunjung yang menginap.
                    </p>
                </div><!-- Intro box end -->

                <div class="gap-20"></div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="ts-service-box">
                            <span class="ts-service-icon">
                                <i class="fas fa-door-open"></i>
                            </span>
                            <div class="ts-service-box-content">
                                <h3 class="service-box-title">Terbuka Untuk Umum</h3>
                            </div>
                        </div><!-- Service 1 end -->
                    </div><!-- col end -->

                    <div class="col-md-6">
                        <div class="ts-service-box">
                            <span class="ts-service-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <div class="ts-service-box-content">
                                <h3 class="service-box-title">Lokasi di Pusat Kota Bandung</h3>
                            </div>
                        </div><!-- Service 2 end -->
                    </div><!-- col end -->
                </div><!-- Content row 1 end -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="ts-service-box">
                            <span class="ts-service-icon">
                                <i class="fas fa-thumbs-up"></i>
                            </span>
                            <div class="ts-service-box-content">
                                <h3 class="service-box-title">Harga Yang Terjangkau</h3>
                            </div>
                        </div><!-- Service 1 end -->
                    </div><!-- col end -->

                    <div class="col-md-6">
                        <div class="ts-service-box">
                            <span class="ts-service-icon">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="ts-service-box-content">
                                <h3 class="service-box-title">Fasilitas Untuk Pertemuan</h3>
                            </div>
                        </div><!-- Service 2 end -->
                    </div><!-- col end -->
                </div><!-- Content row 1 end -->
            </div><!-- Col end -->

            <div class="col-lg-6 mt-4 mt-lg-0">
                <h2 class="into-title">Testimoni</h2>
                <h3 class="into-sub-title mb-lg-4">Penilaian</h3>

                <div id="testimonial-slide" class="testimonial-slide">
                    <div class="item">
                        <div class="quote-item">
                            <span class="quote-text">
                                Tempat nyaman untuk kegiatan training atau acara keluarga...
                            </span>

                            <div class="quote-item-footer">
                                <img loading="lazy" class="testimonial-thumb" src="https://cdn-icons-png.flaticon.com/512/599/599305.png" alt="testimonial">
                                <div class="quote-item-info">
                                    <h3 class="quote-author">Cheppy Junaedi</h3>
                                    <span class="quote-subtext">Pengunjung</span>
                                </div>
                            </div>
                        </div><!-- Quote item end -->
                    </div>
                    <!--/ Item 1 end -->

                    <div class="item">
                        <div class="quote-item">
                            <span class="quote-text">
                                Pelayanan staff ramah, security 24 jam, kamar bersih rapih
                            </span>

                            <div class="quote-item-footer">
                                <img loading="lazy" class="testimonial-thumb" src="https://cdn-icons-png.flaticon.com/512/599/599305.png" alt="testimonial">
                                <div class="quote-item-info">
                                    <h3 class="quote-author">Andre S</h3>
                                    <span class="quote-subtext">Pengunjung</span>
                                </div>
                            </div>
                        </div><!-- Quote item end -->
                    </div>
                    <!--/ Item 2 end -->

                    <div class="item">
                        <div class="quote-item">
                            <span class="quote-text">
                                Harga murah dan sangat strategis untuk pergi kemana-mana.
                            </span>

                            <div class="quote-item-footer">
                                <img loading="lazy" class="testimonial-thumb" src="https://cdn-icons-png.flaticon.com/512/599/599305.png" alt="testimonial">
                                <div class="quote-item-info">
                                    <h3 class="quote-author">Asyeh Haqiq</h3>
                                    <span class="quote-subtext">Pengunjung</span>
                                </div>
                            </div>
                        </div><!-- Quote item end -->
                    </div>
                    <!--/ Item 3 end -->
                </div>
            </div><!-- Col end -->
        </div><!-- Row end -->
    </div><!-- Container end -->
</section><!-- Feature are end -->

<section id="main-container" class="main-container pb-2" style="background-color: #F5F5F5;">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <h2 class="section-title">Tarif Sewa</h2>
                <h3 class="section-sub-title">Kategori Penginapan</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5">
                <div class="ts-service-box">
                    <div class="d-flex">
                        <div class="ts-service-box-img">
                            <img loading="lazy" src="https://cdn-icons-png.flaticon.com/512/3405/3405818.png" width="50" alt="service-icon">
                        </div>
                        <div class="ts-service-info">
                            <h3 class="service-box-title">Kategori Bisnis</h3>
                            <p class="text-justify">Kategori untuk tamu yang berasal dari luar lingkungan Kementerian Kesehatan RI, baik perorangan atau organisasi</p>
                            <a class="btn btn-primary" href="{{ url('beranda/tarif-sewa/daftar') }}" aria-label="service-details">
                                <i class="fa fa-caret-right"></i> Tarif Sewa
                            </a>
                        </div>
                    </div>
                </div><!-- Service1 end -->
            </div><!-- Col 1 end -->

            <div class="col-lg-6 col-md-6 mb-5">
                <div class="ts-service-box">
                    <div class="d-flex">
                        <div class="ts-service-box-img">
                            <img loading="lazy" src="https://cdn-icons-png.flaticon.com/512/3405/3405818.png" width="50">
                        </div>
                        <div class="ts-service-info">
                            <h3 class="service-box-title">Kategori Non Bisnis</h3>
                            <p class="text-justify">Kategori untuk tamu yang berasal dari lingkungan Kementerian Kesehatan RI (ASN Kemenkes)</p>
                            <!-- <p>Kategori I : Lembaga Sosial/Pendidikan/Mahasiswa (instansi swasta).</p>
                  <p>Kategori II : Lembaga Sosial/Pendidikan/Mahasiswa (instansi pemerintah).</p>
                  <p>Kategori III : ASN Kementerian Kesehatan tanpa surat tugas/Pensiunan Kementerian Kesehatan.</p> -->
                            <a class="btn btn-primary" href="{{ url('beranda/tarif-sewa/daftar') }}" aria-label="service-details">
                                <i class="fa fa-caret-right"></i> Tarif Sewa
                            </a>
                        </div>
                    </div>
                </div><!-- Service2 end -->
            </div><!-- Col 2 end -->

            <!-- <div class="col-lg-4 col-md-6 mb-5">
                <div class="ts-service-box">
                    <div class="d-flex">
                        <div class="ts-service-box-img">
                            <img loading="lazy" src="https://cdn-icons-png.flaticon.com/512/3405/3405818.png" width="50" alt="service-icon">
                        </div>
                        <div class="ts-service-info">
                            <h3 class="service-box-title">Kategori Sosial</h3>
                            <p class="text-justify">Kategori tamu untuk pegawai Kemenkes RI (Pejabat Administrasi, Es III, Es IV, Gol IV, Gol III) dengan surat tugas</p>
                            <a class="btn btn-primary" href="{{ url('beranda/tarif-sewa/daftar') }}" aria-label="service-details">
                                <i class="fa fa-caret-right"></i> Tarif Sewa
                            </a>
                        </div>
                    </div>
                </div>
            </div> -->

        </div><!-- Main row end -->
    </div><!-- Conatiner end -->
</section><!-- Main container end -->


<section id="main-container" class="main-container">
    <div class="container dark">

        <div class="row text-center">
            <div class="col-lg-12">
                <h2 class="section-title">Frequently Asked Question</h2>
                <h3 class="section-sub-title">FAQ</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="accordion accordion-group accordion-classic" id="construction-accordion">
                    <div class="card">
                        <div class="card-header p-0 bg-transparent" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Bagaimana Reservasi di Wisma Sukajadi Bandung ?
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#construction-accordion">
                            <div class="card-body">
                                Cara reservasi di Wisma Sukajadi Bandung, caranya cukup mudah yaitu pengunjung dapat datang langsung ke Wisma Sukajadi
                                Bandung dan melakukan reservasi ke bagian resepsionis.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header p-0 bg-transparent" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Apakah Menginap di Wisma Sukajadi Bandung Hanya Untuk Pegawai Kemenkes RI ?
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#construction-accordion">
                            <div class="card-body">
                                Tidak, Wisma Sukajadi Bandung terbuka untuk umum dengan harga yang sangat terjangkau di tengah pusat kota Bandung.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header p-0 bg-transparent" id="headingThree">
                            <h2 class="mb-0">
                                <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Bagaimana Metode Pembayaran Yang Dapat dilakukan Untuk Reservasi ?
                                </button>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#construction-accordion">
                            <div class="card-body">
                                Untuk metode pembayaran, pengunjung harus melakukan reservasi terlebih dahulu, selanjutnya pengunjung akan mendapatkan
                                <i> Virtual Billing Account</i> yang digunakan untuk melakukan pembayaran.
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Accordion end -->

            </div><!-- Col end -->

        </div><!-- Content row end -->

    </div><!-- Container end -->
</section><!-- Main container end -->

<section id="main-container" class="main-container" style="background-color: #F5F5F5;">
    <div class="container">

        <div class="row text-center">
            <div class="col-12">
                <h2 class="section-title">Reaching our Office</h2>
                <h3 class="section-sub-title">Find Our Location</h3>
            </div>
        </div>
        <!--/ Title row end -->

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="ts-service-box-bg text-center h-100">
                        <span class="ts-service-icon icon-round">
                            <i class="fas fa-map-marker-alt mr-0"></i>
                        </span>
                        <div class="ts-service-box-content">
                            <h4>Lokasi</h4>
                            <p>Jl. Sukajadi No.155, Cipedes, Kec. Sukajadi, Kota Bandung, Jawa Barat 40162</p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="ts-service-box-bg text-center h-100">
                        <span class="ts-service-icon icon-round">
                            <i class="fa fa-phone-square mr-0"></i>
                        </span>
                        <div class="ts-service-box-content">
                            <h4>Fax / Telepon</h4>
                            <p>(022) 2031152</p>
                        </div>
                    </div>
                </div>
            </div><!-- Col 1 end -->

            <div class="col-md-8">
                <div class="google-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15844.155643129408!2d107.5962878!
          3d-6.8859428!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8915931e2cb95952!2swisma%20kementrian%20ke
          sehatan%20RI!5e0!3m2!1sen!2sid!4v1648020030923!5m2!1sen!2sid" style="width: 100%;height:  66.8vh;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div><!-- Col 3 end -->

        </div><!-- 1st row end -->

        <div class="gap-60"></div>



        <div class="gap-40"></div>
    </div><!-- Conatiner end -->
</section><!-- Main container end -->

@section('js')
<script>
    document.getElementById('checkInDate').addEventListener('change', function() {
        var checkInDate = new Date(this.value);
        var checkOutDate = new Date(document.getElementById('checkOutDate').value);

        if (checkOutDate <= checkInDate) {
            document.getElementById('checkOutDate').value = '';
            document.getElementById('checkOutDate').setAttribute('min', this.value);
        }
    });

    document.getElementById('checkOutDate').addEventListener('change', function() {
        var checkInDate = new Date(document.getElementById('checkInDate').value);
        var checkOutDate = new Date(this.value);

        if (checkOutDate <= checkInDate) {
            alert("Tanggal Keluar harus lebih besar dari Tanggal Masuk");
            this.value = '';
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Tanggal yang dinonaktifkan
        const disabledDates = [
            "2025-04-03", "2025-04-04", "2025-04-05", "2025-04-06", "2025-04-07"
        ];
        const dates = [
            document.getElementById("checkInDate"),
            document.getElementById("checkOutDate")
        ];

        dates.forEach(input => {
            if (input) {
                // Set min and max range
                input.min = "2025-04-03";
                input.max = "2025-04-07";

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
