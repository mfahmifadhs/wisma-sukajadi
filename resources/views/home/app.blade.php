<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Basic Page Needs
================================================== -->
    <meta charset="utf-8">
    <title>WISMA SUKAJADI | KEMENKES RI</title>

    <!-- Mobile Specific Metas
================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Construction Html5 Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <link rel="icon" href="{{ asset('images/icon-kemenkes.png') }}" type="image/x-icon">

    <!-- Favicon
================================================== -->
    <link rel="icon" type="image/png" href="images/favicon.png">

    <!-- CSS
================================================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('dist-main/plugins/bootstrap/bootstrap.min.css') }}">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <!-- Animation -->
    <link rel="stylesheet" href="{{ asset('dist-main/plugins/animate-css/animate.css') }}">
    <!-- slick Carousel -->
    <link rel="stylesheet" href="{{ asset('dist-main/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('dist-main/plugins/slick/slick-theme.css') }}">
    <!-- Colorbox -->
    <link rel="stylesheet" href="{{ asset('dist-main/plugins/colorbox/colorbox.css') }}">
    <!-- Template styles-->
    <link rel="stylesheet" href="{{ asset('dist-main/css/style.css') }}">
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="body-inner">

        <!-- Header start -->
        <header id="header" class="header-one">
            <div class="bg-white">
                <div class="container">
                    <div class="logo-area">
                        <div class="row align-items-center">
                            <div class="logo col-lg-3 text-center text-lg-left mb-3 mb-md-5 mb-lg-0">
                                <a class="d-block" href="index.html">
                                    <img loading="lazy" src="{{ asset('images/main/logo-kemenkes.png') }}" alt="Wisma Sukajadi Bandung">
                                </a>
                            </div><!-- logo end -->

                            <div class="col-lg-9 header-right">
                                <ul class="top-info-box">
                                    <li>
                                        <div class="info-box">
                                            <div class="info-box-content">
                                                <p class="info-box-title">Telepon</p>
                                                <p class="info-box-subtitle"><a href="tel:(+9) 847-291-4353">(022) 2031152</a></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="info-box">
                                            <div class="info-box-content">
                                                <p class="info-box-title">Alamat</p>
                                                <p class="info-box-subtitle"><a href="mailto:office@Constra.com">Jl. Sukajadi No.155, Cipedes, Kec. Sukajadi, Kota Bandung.</a></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="header-get-a-quote">
                                        @if(Auth::user() == null)
                                        <a class="btn btn-primary" href="{{ url('beranda/masuk') }}">Masuk</a>
                                        @else
                                        <a class="btn btn-primary" href="dropdown-toggle" data-toggle="dropdown">Admin</a>
                                        @endif
                                    </li>
                                </ul><!-- Ul end -->
                            </div><!-- header right end -->
                        </div><!-- logo area end -->

                    </div><!-- Row end -->
                </div><!-- Container end -->
            </div>

            <div class="site-navigation">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <nav class="navbar navbar-expand-lg navbar-dark p-0">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div id="navbar-collapse" class="collapse navbar-collapse">
                                    <ul class="nav navbar-nav mr-auto">
                                        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('/') }} ">Beranda</a>
                                        </li>
                                        <li class="nav-item {{ Request::is('beranda/tentang') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('beranda/tentang') }}">Tentang</a>
                                        </li>

                                        <li class="nav-item dropdown">
                                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Kamar & Fasilitas <i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li class="{{ Request::is('beranda/kamar/daftar') ? 'active' : '' }}">
                                                    <a href="{{ url('beranda/kamar/daftar') }}">Kamar</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="nav-item dropdown">
                                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Kunjungan & Lainya <i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li class="{{ Request::is('beranda/kunjungan/buku-tamu') ? 'active' : '' }}">
                                                    <a href="{{ url('beranda/kunjungan/buku-tamu') }}">Buku Tamu</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="nav-item {{ Request::is('beranda/testimoni') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('beranda/testimoni') }}">Testimoni</a>
                                        </li>
                                        <!-- <li class="nav-item {{ Request::is('beranda/faq') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('beranda/faq') }}">FAQ</a>
                                        </li> -->
                                        <li class="nav-item {{ Request::is('beranda/kontak') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('beranda/kontak') }}">Kontak</a>
                                        </li>
                                        @if(Auth::user() != null)
                                        <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <!--/ Col end -->
                    </div>
                    <!--/ Row end -->

                    <div class="nav-search">
                        <span id="search"><i class="fa fa-search"></i></span>
                    </div><!-- Search end -->

                    <div class="search-block" style="display: none;">
                        <label for="search-field" class="w-100 mb-0">
                            <input type="text" class="form-control" id="search-field" placeholder="Type what you want and enter">
                        </label>
                        <span class="search-close">&times;</span>
                    </div><!-- Site search end -->
                </div>
                <!--/ Container end -->

            </div>
            <!--/ Navigation end -->
        </header>
        <!--/ Header end -->


        @yield('content')


        <footer id="footer" class="footer bg-overlay">
            <div class="footer-main">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-lg-4 col-md-6 footer-widget footer-about">
                            <img loading="lazy" width="200px" class="footer-logo" src="{{ asset('images/main/logo-kemenkes.png')}}">
                            <div class="footer-social">
                                <ul>
                                    <li><a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li><a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#" aria-label="Github"><i class="fab fa-github"></i></a></li>
                                </ul>
                            </div><!-- Footer social end -->
                        </div><!-- Col end -->

                        <div class="col-lg-4 col-md-6 footer-widget mt-5 mt-md-0">
                            <h3 class="widget-title">Prosedur</h3>
                            <div class="working-hours">
                                Reservasi dapat dilakukan di jam kerja, diluar jam kerja pengunjung tetap dapat menginap namun
                                pembayaran dilakukan di jam kerja.
                                <br><br> Waktu Check In: <span class="text-right">14:00</span>
                                <br> Waktu Check Out: <span class="text-right">11:00</span>
                            </div>
                        </div><!-- Col end -->

                        <div class="col-lg-3 col-md-6 mt-5 mt-lg-0 footer-widget">
                            <h3 class="widget-title">Layanan</h3>
                            <ul class="list-arrow">
                                <li>Aula</li>
                                <li>Gym / Fitnes</li>
                                <li>Ruang Rapat</li>
                            </ul>
                        </div><!-- Col end -->
                    </div><!-- Row end -->
                </div><!-- Container end -->
            </div><!-- Footer main end -->

            <div class="copyright">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="copyright-info text-center text-md-left">
                                <span>Copyright &copy; 2021 <a href="#">Wisma Sukajadi Bandung</a>.</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="footer-menu text-center text-md-right">
                                Biro Umum Kemenkes RI
                            </div>
                        </div>
                    </div><!-- Row end -->

                    <div id="back-to-top" data-spy="affix" data-offset-top="10" class="back-to-top position-fixed">
                        <button class="btn btn-primary" title="Back to Top">
                            <i class="fa fa-angle-double-up"></i>
                        </button>
                    </div>

                </div><!-- Container end -->
            </div><!-- Copyright end -->
        </footer><!-- Footer end -->


        <!-- Javascript Files
  ================================================== -->

        <!-- initialize jQuery Library -->
        <script src="{{ asset('dist-main/plugins/jQuery/jquery.min.js') }}"></script>
        <!-- Bootstrap jQuery -->
        <script src="{{ asset('dist-main/plugins/bootstrap/bootstrap.min.js') }}" defer></script>
        <!-- Slick Carousel -->
        <script src="{{ asset('dist-main/plugins/slick/slick.min.js') }}"></script>
        <script src="{{ asset('dist-main/plugins/slick/slick-animation.min.js') }}"></script>
        <!-- Color box -->
        <script src="{{ asset('dist-main/plugins/colorbox/jquery.colorbox.js') }}"></script>
        <!-- shuffle -->
        <script src="{{ asset('dist-main/plugins/shuffle/shuffle.min.js') }}" defer></script>


        <!-- Google Map API Key-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer></script>
        <!-- Google Map Plugin-->
        <script src="{{ asset('dist-main/plugins/google-map/map.js') }}" defer></script>

        <!-- Template custom -->
        <script src="{{ asset('dist-main/js/script.js') }}"></script>
        @yield('js')

    </div><!-- Body inner end -->
</body>

</html>
