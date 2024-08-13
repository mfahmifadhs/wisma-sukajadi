@extends('app')
@section('content')

<section id="main-container" class="main-container">
    <div class="container">

        <div class="row text-center">
            <div class="col-12">
                <h2 class="section-title">Tuliskan kritik dan saran, untuk kami lebih baik</h2>
                <h3 class="section-sub-title">Kritik dan Saran</h3>
            </div>
        </div>
        <!--/ Title row end -->

        <div class="gap-10"></div>

        <div class="row">
            <div class="col-md-12 form-group">
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
                <form id="contact-form" action="{{ route('kritiksaran.post') }}" method="post" role="form">
                    @csrf
                    <div class="error-container"></div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama</label>
                                <input class="form-control text-dark border-dark" name="nama" placeholder="" type="text" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Menginap</label>
                                <input class="form-control text-dark border-dark" name="tgl_menginap" placeholder="" type="date" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Nomor Kamar <small>(salah satu)</small></label>
                                <input class="form-control text-dark border-dark" name="no_kamar" placeholder="" type="number" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Nomor Handphone</label>
                                <input class="form-control text-dark border-dark number" name="no_hp" required>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="font-weight-bold">Pesan</label>
                                <textarea class="form-control form-control-message border-dark" name="pesan" id="message" placeholder="" rows="15" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary solid blank" type="submit" onclick="return confirm('Kirim ?')">
                                Kirim
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div><!-- Content row -->
    </div><!-- Conatiner end -->
</section><!-- Main container end -->

@endsection
