@extends('app')
@section('content')


<section id="main-container" class="main-container">
  <div class="container">

    <div class="row text-center">
      <div class="col-12">
        <h3 class="section-sub-title mb-0">BUKU TAMU <hr></h3>
      </div>
    </div>
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
      <div class="col-md-12">
        <!-- contact form works with formspree.io  -->
        <!-- contact form activation doc: https://docs.themefisher.com/constra/contact-form/ -->
        <form id="contact-form" action="{{ url('beranda/kunjungan/tambah-kunjungan') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-3">
              <div class="form-group mt-2">
                <h4>Nama Lengkap</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" class="form-control text-uppercase" name="visit_name" id="name" placeholder="Masukan nama lengkap" required>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>No. HP</h4>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <input type="number" min="1" class="form-control text-uppercase" name="visit_phone_num" placeholder="Masukan nomor HP aktif" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mt-2">
                <h4>No. Kendaraan</h4>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <input type="text" name="visit_car_num" class="form-control text-uppercase" placeholder="Masukan nomor kendaraan (kosongkan jika tidak ada)" onkeypress="return event.charCode != 32">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mt-2">
                <h4>Maksud / Tujuan</h4>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <textarea class="form-control" name="visit_description" placeholder="Masukan maksud dan tujuan kunjungan" rows="10"
                required></textarea>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mt-2">
                <h4>&emsp;</h4>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <button class="btn btn-primary" onclick="return confirm('Tambah Kunjungan ?')">SUBMIT</button>
              </div>
            </div>
            
          </div>
        </form>
      </div>

    </div><!-- Content row -->
  </div><!-- Conatiner end -->
</section><!-- Main container end -->



@endsection