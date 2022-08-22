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
        <h3 class="section-sub-title mb-0">DAFTAR KAMAR <hr></h3>
      </div>
      <div class="col-lg-12 mb-5 mb-lg-0">
        <div class="post">
          <div class="row">
            @foreach($rooms as $room)
            <div class="col-md-6 form-group">
              <div class="card mb-4" style="height: 100%;">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="post-media post-image mt-4">
                        <img loading="lazy" src="{{ asset('images/admin/kamar/'. $room->room_img) }}" class="img-thumbnail">
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="post-body">
                        <div class="entry-header">
                          <div class="post-meta text-capitalize">
                            <h6>
                              <a href="news-single.html">{{ $room->room_name }}</a>
                            </h6>
                            <span style="font-size: 13px;">
                              <i class="fas fa-bed"></i> Kapasitas : {{ $room->room_capacity }} orang
                            </span>
                            <span class="text-capitalize" style="font-size: 13px;">
                              <i class="fas fa-door-open"></i>Status : {{ $room->room_status }}
                            </span>
                            <hr class="mt-2 mb-2">
                            @foreach($room->rentalrate as $pricebs)
                            @if($pricebs->rental_rate_ctg == 'bisnis')
                            <b><i class="far fa-circle fa-1px"></i> Bisnis :</b><br>
                            <span style="font-size: 13px;">
                              <i class="fas fa-money-bill-wave"></i> Rp {{ number_format($pricebs->price, 0, ',', '.') }}
                            </span>
                            @endif
                            @endforeach
                            <hr class="mt-2 mb-2">
                            <b><i class="far fa-circle fa-1px"></i> Non Bisnis</b><br>
                            @foreach($room->rentalrate as $pricenb)
                            @if($pricenb->rental_rate_ctg == 'non-bisnis')
                            <span style="font-size: 13px;">
                              <i class="fas fa-money-bill-wave"></i> {{ $pricenb->price_ctg.' : Rp '.number_format($pricenb->price, 0, ',', '.') }}
                            </span>
                            @endif
                            @endforeach
                            <hr class="mt-2 mb-2">
                            <b><i class="far fa-circle fa-1px"></i> Sosial</b><br>
                            @foreach($room->rentalrate as $pricess)
                            @if($pricess->rental_rate_ctg == 'sosial')
                            <span style="font-size: 13px;">
                              <i class="fas fa-money-bill-wave"></i> {{ $pricess->price_ctg.' : Rp '.number_format($pricess->price, 0, ',', '.') }}
                            </span>
                            @endif
                            @endforeach
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <a href="{{ url('beranda/kamar/'. $room->id_room) }}" class="btn btn-primary float-right"> 
                    Lihat Kamar <i class="fas fa-arrow-alt-circle-right"></i> 
                  </a>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          {{ $rooms->links("pagination::bootstrap-4") }}
        </div>
      </div>
    </div>
  </div>
</section>



@endsection