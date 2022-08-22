@extends('app')
@section('content')

<div id="banner-area" class="banner-area" style="background-image:url(../images/main/banner/sukajadi-1.jpg)">
  <div class="banner-text">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
              <div class="banner-heading">
                <h1 class="banner-title">Tentang</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Tentang</li>
                    </ol>
                </nav>
              </div>
          </div><!-- Col end -->
        </div><!-- Row end -->
    </div><!-- Container end -->
  </div><!-- Banner text end -->
</div><!-- Banner area end --> 

<section id="main-container" class="main-container">
  <div class="container">
    <div class="row">
        <div class="col-lg-6">
          <h3 class="column-title">Wisma Sukajadi</h3>
          <p style="text-align: justify;">Wisma Kemenkes RI Sukajadi Bandung adalah penginapan yang terbuka untuk umum untuk seluruh masyarakat yang ingin menginap. Lokasi yang terletak di tengah
            Kota Bandung yaitu di Jl. Sukajadi No.155, Cipedes, Kec. Sukajadi, Kota Bandung. Dengan lokasi yang terletak di tengan Kota Bandung. Wisma Sukajadi 
            memberikan harga yang murah dan terjangkau untuk tamu yang menginap dengan fasilitas yang bersih, nyaman dan aman. 
          <p>Selain sebagai penginapan, Wisma Sukajadi memberikan fasilitas untuk mengadakan pertemuan maupun kegiatan lainya.</p>

        </div><!-- Col end -->

        <div class="col-lg-6 mt-5 mt-lg-0">
          
          <div id="page-slider" class="page-slider small-bg">

              <div class="item" style="background-image:url(../images/main/slider-pages/slide-page1.jpg)">
                <div class="container">
                    <div class="box-slider-content">
                      <div class="box-slider-text">
                          <h2 class="box-slide-title">PARKIR LUAS</h2>
                      </div>    
                    </div>
                </div>
              </div><!-- Item 1 end -->

              <div class="item" style="background-image:url(../images/main/slider-pages/slide-page2.jpg)">
                <div class="container">
                    <div class="box-slider-content">
                      <div class="box-slider-text">
                          <h2 class="box-slide-title">RUANG MAKAN</h2>
                      </div>    
                    </div>
                </div>
              </div><!-- Item 1 end -->

              <div class="item" style="background-image:url(../images/main/slider-pages/slide-page3.jpg)">
                <div class="container">
                    <div class="box-slider-content">
                      <div class="box-slider-text">
                          <h2 class="box-slide-title">RUANG TAMU</h2>
                      </div>    
                    </div>
                </div>
              </div><!-- Item 1 end -->

              <div class="item" style="background-image:url(../images/main/slider-pages/slide-page4.jpg)">
                <div class="container">
                    <div class="box-slider-content">
                      <div class="box-slider-text">
                          <h2 class="box-slide-title">RUANG PERTEMUAN</h2>
                      </div>    
                    </div>
                </div>
              </div><!-- Item 1 end -->
          </div><!-- Page slider end-->          
        

        </div><!-- Col end -->
    </div><!-- Content row end -->

  </div><!-- Container end -->
</section><!-- Main container end -->

@endsection