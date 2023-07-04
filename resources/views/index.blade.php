@extends('home.app')

@section('content')

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

<!-- <section class="call-to-action-box no-padding">
  <div class="container">
    <div class="action-style-box">
        <div class="row align-items-center">
          <div class="col-md-12 text-center text-md-left">
              <div class="call-to-action-text">
                <form action="{{ url('boking/validasi') }}">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <h6>Check-in :</h6>
                      </div>
                      <input type="date" class="form-control" placeholder="Pilih tanggal">
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <h6>Durasi : </h6>
                      </div>
                      <select class="form-control" name="" id="">
                        <option value="">1 Malam</option>
                        <option value="">2 Malam</option>
                        <option value="">3 Malam</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <h6>Kategori : </h6>
                      </div>
                      <select class="form-control" name="" id="">
                        <option value="">PNS</option>
                        <option value="">NON PNS</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <h6>&nbsp;</h6>
                      </div>
                      <button type="submit" class="form-control btn btn-dark">
                        <i class="fas fa-search"></i> CARI KAMAR
                      </button>
                    </div>
                  </div>
                </form>
              </div>
          </div><!-- Col end -->
        </div><!-- row end -->
    </div><!-- Action style box -->
  </div><!-- Container end -->
</section> -->

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
      <div class="col-lg-4 col-md-6 mb-5">
        <div class="ts-service-box">
            <div class="d-flex">
              <div class="ts-service-box-img">
                  <img loading="lazy" src="https://cdn-icons-png.flaticon.com/512/3405/3405818.png" width="50" alt="service-icon">
              </div>
              <div class="ts-service-info">
                  <h3 class="service-box-title">Kategori Bisnis</h3>
                  <p class="text-justify">Kategori untuk tamu yang berasal dari luar lingkungan Kementerian Kesehatan RI baik itu Perseorangan, Golongan atau Perusahaan.</p>
                  <a class="btn btn-primary" href="{{ url('beranda/tarif-sewa/daftar') }}" aria-label="service-details">
                    <i class="fa fa-caret-right"></i> Tarif Sewa
                  </a>
              </div>
            </div>
        </div><!-- Service1 end -->
      </div><!-- Col 1 end -->

      <div class="col-lg-4 col-md-6 mb-5">
        <div class="ts-service-box">
            <div class="d-flex">
              <div class="ts-service-box-img">
                  <img loading="lazy" src="https://cdn-icons-png.flaticon.com/512/3405/3405818.png" width="50">
              </div>
              <div class="ts-service-info">
                  <h3 class="service-box-title">Kategori Non Bisnis</h3>
                  <p class="text-justify">Kategori untuk tamu yang berasal dari Instansi Swasta, Instansi Pemerintah, Pegawai, ASN dan lainya tanpa surat tugas.</p>
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

      <div class="col-lg-4 col-md-6 mb-5">
        <div class="ts-service-box">
            <div class="d-flex">
              <div class="ts-service-box-img">
                  <img loading="lazy" src="https://cdn-icons-png.flaticon.com/512/3405/3405818.png" width="50" alt="service-icon">
              </div>
              <div class="ts-service-info">
                  <h3 class="service-box-title">Kategori Sosial</h3>
                  <p class="text-justify">Kategori tamu untuk pegawai Kemenkes RI (Pejabat Administrasi, Es III, Es IV, Gol IV, Gol III) dengan surat tugas</p>
                  <!-- <p>Kategori I : Pegawai Kementerian Kesehatan (Pejabat Administrasi ke atas, Eselon III ke atas, Golongan IV dan/atau setara).</p>
                  <p>Kategori II : Pegawai Kementerian Kesehatan dengan surat Tugas (Pejabat Pengawas ke bawah, Golongan III ke bawah, Eselon IV dan/atau setara).</p>
                  <p>Kategori III : Penggunaan Wisma dalam keadaan pandemi dan/atau menunjang tugas dan fungsi di bidang Kesehatan dengan mendapat izin dari Kepala Biro Umum.</p> -->
                  <a class="btn btn-primary" href="{{ url('beranda/tarif-sewa/daftar') }}" aria-label="service-details">
                    <i class="fa fa-caret-right"></i> Tarif Sewa
                  </a>
              </div>
            </div>
        </div><!-- Service3 end -->
      </div><!-- Col 3 end -->

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
                <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne"
                  aria-expanded="true" aria-controls="collapseOne">
                  Bagaimana Reservasi di Wisma Sukajadi Bandung ?
                </button>
              </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
              data-parent="#construction-accordion">
              <div class="card-body">
                Cara reservasi di Wisma Sukajadi Bandung, caranya cukup mudah yaitu pengunjung dapat datang langsung ke Wisma Sukajadi
                Bandung dan melakukan reservasi ke bagian resepsionis.
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header p-0 bg-transparent" id="headingTwo">
              <h2 class="mb-0">
                <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                  data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
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
                <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                  data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Bagaimana Metode Pembayaran Yang Dapat dilakukan Untuk Reservasi ?
                </button>
              </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
              data-parent="#construction-accordion">
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
          sehatan%20RI!5e0!3m2!1sen!2sid!4v1648020030923!5m2!1sen!2sid" style="width: 100%;height:  66.8vh;"
          allowfullscreen="" loading="lazy">
        </iframe>
        </div>
      </div><!-- Col 3 end -->

    </div><!-- 1st row end -->

    <div class="gap-60"></div>



    <div class="gap-40"></div>

    <!-- <div class="row">
      <div class="col-md-12">
        <h3 class="column-title">Kritik dan Saran</h3>
        <form id="contact-form" action="#" method="post" role="form">
          <div class="error-container"></div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Name</label>
                <input class="form-control form-control-name" name="name" id="name" placeholder="" type="text" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Email</label>
                <input class="form-control form-control-email" name="email" id="email" placeholder="" type="email"
                  required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Subject</label>
                <input class="form-control form-control-subject" name="subject" id="subject" placeholder="" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea class="form-control form-control-message" name="message" id="message" placeholder="" rows="10"
              required></textarea>
          </div>
          <div class="text-right"><br>
            <button class="btn btn-primary solid blank" type="submit">Kirim</button>
          </div>
        </form>
      </div>
    </div> -->
  </div><!-- Conatiner end -->
</section><!-- Main container end -->


@endsection
