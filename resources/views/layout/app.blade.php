<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WISMA SUKAJADI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Icon Title -->
    <link rel="icon" href="{{ asset('images/icon-kemenkes.png') }}" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('dist_admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('dist_admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist_admin/css/adminlte.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('dist_admin/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dist_admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist_admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist_admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('dist_admin/plugins/select2/css/select2.min.css') }}">
</head>

<body class="hold-transition sidebar-mini sidebar-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle text-primary"></i> Profil
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">
                            {{ Auth::user()->pegawai->nama_pegawai }} <br>
                            {{ Auth::user()->pegawai->nip }}
                        </span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('keluar') }}" class="dropdown-item dropdown-footer">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-light-primary elevation-4">

            <a href="{{ route('dashboard') }}" class="brand-link text-center">
                <span class="brand-text font-weight-bold">WISMA SUKAJADI</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image mt-2">
                        <img src="{{ asset('images/admin/logo-kemenkes-icon.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block text-capitalize small">
                            {{ Auth::user()->pegawai->nip }} <br>
                            {{ Auth::user()->pegawai->nama_pegawai }}
                        </a>
                    </div>
                </div>


                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-header font-weight-bold">Halaman Utama</li>
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link">
                                <img src="{{ asset('images/admin/logo-kemenkes-icon.png') }}" width="28" style="margin-top: -0.5vh">
                                <p>Wisma Sukajadi</p>
                            </a>
                        </li>
                        <li class="nav-header font-weight-bold">Menu</li>
                        <li class="nav-item">
                            <a href="{{ route('buku_tamu.show') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>Buku Tamu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kamar', ['id' => 'daftar']) }}" class="nav-link">
                                <i class="nav-icon fas fa-bed"></i>
                                <p>Kamar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reservasi.show') }}" class="nav-link">
                                <i class="nav-icon fas fa-hotel"></i>
                                <p>Reservasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-address-card"></i>
                                <p>
                                    Laporan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('laporan.show', ['id' => 'pendapatan']) }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Pendapatan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('laporan.show', ['id' => 'reservasi']) }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Reservasi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('laporan.show', ['id' => 'pnbp']) }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>PNBP</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-header font-weight-bold">Pegawai Kemenkes</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Pengguna
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('user.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Pengguna</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.create') }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Pengguna</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-address-card"></i>
                                <p>
                                    Pegawai
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('pegawai.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Pegawai</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pegawai.create') }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Pegawai</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-address-card"></i>
                                <p>
                                    Unit Kerja
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('unit_kerja.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Unit Kerja</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('unit_kerja.create') }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Unit Kerja</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-address-card"></i>
                                <p>
                                    Unit Utama
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('unit_utama.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Unit Utama</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('unit_utama.create') }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Unit Utama</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2021 <a href="#">Wisma Sukajadi Bandung</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                Biro Umum Kemenkes RI
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('dist_admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('dist_admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('dist_admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist_admin/js/adminlte.js') }}"></script>
    <!-- Moment -->
    <script src="{{ asset('dist_admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/moment/locale/id.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <!-- PAGE PLUGINS -->
    <script src="{{ asset('dist_admin/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('dist_admin/plugins/chart.js/Chart.min.js') }}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist_admin/js/demo.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('dist_admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('dist_admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/pdfmake/pdfmake.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dist_admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('dist_admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- ChartJS -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    @yield('js')
    <script>
        $(function() {
            var url = window.location;
            // for single sidebar menu
            $('ul.nav-sidebar a').filter(function() {
                return this.href == url;
            }).addClass('active');

            // for sidebar menu and treeview
            $('ul.nav-treeview a').filter(function() {
                    return this.href == url;
                }).parentsUntil(".nav-sidebar > .nav-treeview")
                .css({
                    'display': 'block'
                })
                .addClass('menu-open').prev('a')
                .addClass('active');
        });
    </script>
</body>

</html>
