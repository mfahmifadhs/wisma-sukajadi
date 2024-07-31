@extends('app')
@section('content')

<div id="banner-area" class="banner-area" style="background-image:url(../../images/main/banner/fasilitas-1.jpg)">
    <div class="banner-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-heading">
                        <h1 class="banner-title">KAMAR & FASILITAS</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                                <li class="breadcrumb-item" aria-current="page">Kamar & Fasilitas</li>
                                <li class="breadcrumb-item active" aria-current="page">Kamar</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<section id="main-container" class="main-container">
    <div style="margin: 0px 50px 0px 50px;">
        <div class="row">
            <div class="col-12 text-center">
                <h3 class="section-sub-title mb-0">DAFTAR KAMAR
                    <hr>
                </h3>
            </div>
            <div class="col-lg-12 mb-5 mb-lg-0">
                <div class="post">
                    <div class="row">
                        @foreach($rooms as $room)
                        <div class="col-md-3 form-group">
                            <div class="card border-success">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 room-name text-center">
                                            <h6>{{ $room->nama_kamar }}</h6>
                                        </div>
                                        <div class="col-md-12">
                                            <img src="{{ asset('images/admin/kamar/'. $room->foto_kamar) }}" class="img-thumbnail img-fluid" style="height: 220px;">
                                        </div>
                                        <div class="col-md-5 small col-6 room-area">
                                            <i class="fas fa-vector-square"></i>
                                            Luas {{ number_format($room->luas_kamar, $room->luas_kamar == intval($room->luas_kamar) ? 0 : 2) }} m<sup>2</sup>
                                        </div>
                                        <div class="col-md-7 small col-6 room-capacity text-right">
                                            <i class="fas fa-users"></i> Kapasitas : {{ $room->kapasitas }} orang
                                        </div>
                                    </div>
                                    <div class="border border-success mt-2 mb-2"></div>
                                    <div class="row small">
                                        <div class="col-md-12">Tarif Sewa</div>
                                        @foreach($room->tarif as $tarif)
                                        <div class="col-md-4">{{ $tarif->kategori_tamu }}</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-4">{{ 'Rp '. number_format($tarif->harga_sewa, 0, ',', '.') }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
