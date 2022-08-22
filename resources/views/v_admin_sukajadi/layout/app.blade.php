<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WISMA SUKAJADI</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('dist-admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('dist-admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('dist-admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('dist-admin/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist-admin/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('dist-admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
   <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('dist-admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist-admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist-admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Date time picker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
</head>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{ asset('images/main/logo-ikasmandu.png') }}" alt="Ikasmandu91" height="60" width="260">
  </div> -->

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

      <li class="navbar-nav">
        <a href="{{ url('admin-sukajadi/reservasi/buat') }}" title="Reservasi Kamar" class="nav-link">
          <i class="fas fa-business-time"></i>
        </a>
      </li>
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" title="Check In">
          <i class="fas fa-calendar-check"></i>
        </a>
      </li> -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user-circle"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{ Auth::user()->name }}</span>
          <div class="dropdown-divider"></div>
          <a href="{{ url('admin-sukajadi/profil/'. Auth::user()->id ) }}" class="dropdown-item">
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
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('admin-user/dashboard') }}" class="brand-link text-center">
      <span class="brand-text font-weight-bold">WISMA SUKAJADI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/admin/logo-admin-mini.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block text-capitalize">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ url('admin-sukajadi/dashboard') }}" class="nav-link {{ Request::is('admin-sukajadi/dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header font-weight-bold">Halaman Utama</li>
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link">
              <img src="{{ asset('images/admin/logo-kemenkes-icon.png') }}" width="28" style="margin-top: -0.5vh">
              <p >Wisma Sukajadi</p>
            </a>
          </li>
          <li class="nav-header font-weight-bold">Menu</li>
          <li class="nav-item">
            <a href="{{ url('admin-sukajadi/buku-tamu') }}" class="nav-link {{ Request::is('admin-sukajadi/buku-tamu') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
              <p>Buku Tamu</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin-sukajadi/kamar/daftar') }}" class="nav-link {{ Request::is('admin-sukajadi/kamar/daftar') ? 'active' : '' }}">
              <i class="nav-icon fas fa-bed"></i>
              <p>Kamar</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin-sukajadi/pendapatan') }}" class="nav-link {{ Request::is('admin-sukajadi/pendapatan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-wallet"></i>
              <p>Pendapatan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin-sukajadi/reservasi/daftar') }}" class="nav-link {{ Request::is('admin-sukajadi/reservasi/daftar') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>Reservasi</p>
            </a>
          </li>
          <li class="nav-header font-weight-bold">Laporan</li>
          <li class="nav-item">
            <a href="{{ url('admin-sukajadi/kamar/laporan') }}" class="nav-link {{ Request::is('admin-sukajadi/kamar/laporan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Laporan Kamar</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin-sukajadi/pnbp/laporan') }}" class="nav-link {{ Request::is('admin-sukajadi/pnbp/laporan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Laporan PNBP</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin-sukajadi/reservasi/laporan') }}" class="nav-link {{ Request::is('admin-sukajadi/reservasi/laporan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Laporan Reservasi</p>
            </a>
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
<script src="{{ asset('dist-admin/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('dist-admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('dist-admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist-admin/js/adminlte.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- ChartJS -->
<script src="{{ asset('dist-admin/plugins/chart.js/Chart.min.js') }}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist-admin/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist-admin/js/pages/dashboard2.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('dist-admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist-admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dist-admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dist-admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dist-admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('dist-admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dist-admin/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('dist-admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('dist-admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('dist-admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('dist-admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('dist-admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Date Time Picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

@yield('js')
</body>
</html>
