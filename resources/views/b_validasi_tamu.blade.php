@extends('app')
@section('content')


<section id="main-container" class="main-container">
  <div class="container">

    <div class="row text-center">
      <div class="col-12">
        <h3 class="section-sub-title">IDENTITAS TAMU</h3>
      </div>
    </div>
    <!--/ Title row end -->

    <div class="row">
      <div class="col-md-12">
        <!-- contact form works with formspree.io  -->
        <!-- contact form activation doc: https://docs.themefisher.com/constra/contact-form/ -->
        <form id="contact-form" action="#" method="post" role="form">
          <div class="error-container"></div>
          <div class="row">
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>Check In</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input class="form-control form-control-name" name="name" id="name" placeholder="23 Maret 2022" type="text" readonly>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>Durasi</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input class="form-control form-control-name" name="name" id="name" placeholder="1 Malam" type="text" readonly>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>Kategori</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input class="form-control form-control-name" name="name" id="name" placeholder="PNS" type="text" readonly>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>Instansi</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <select class="form-control" name="" id="">
                  <option value="">KEMENKES RI</option>
                  <option value="">LAINYA</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>Asal Instansi</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" class="form-control form-control-name" name="name" id="name" placeholder="Aparatur Sipil Negara (ASN) / PNS Kementerian, Pensiunan Kemenkes RI" >
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>No. NIP/KTP</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Masukan Nomor NIP / KTP">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>Jabatan</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <select name="" id="" class="form-control">
                    <option value="">-- Pilih Jabatan --</option>
                    <option style="font-weight: bold;">----------ESELON----------</option>
                    <option value="">Eselon I</option>
                    <option value="">Eselon II</option>
                    <option value="">Eselon III</option>
                    <option value="">Eselon IV</option>
                    <option value="">Eselon V</option>
                    <option style="font-weight: bold;">----------GOLONGAN----------</option>
                    <option value="">Golongan I</option>
                    <option value="">Golongan II</option>
                    <option value="">Golongan III</option>
                    <option value="">Golongan IV</option>
                    <option value="">Golongan V</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>Nama</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Masukan Nama Lengkap">  
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>Email</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="email" class="form-control" placeholder="Masukan Alamat Email">  
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>No. Hp</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Masukan Np. Hp Aktif">  
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>Alamat</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Masukan Alamat Lengkap">  
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>Surat Tugas</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="file" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group mt-2">
                <h4>&emsp;</h4>
              </div>
            </div>
            <div class="col-md-10">
              <div class="form-group">
                <button class="btn btn-primary">SUBMIT</button>
              </div>
            </div>
            
          </div>
        </form>
      </div>

    </div><!-- Content row -->
  </div><!-- Conatiner end -->
</section><!-- Main container end -->





@endsection