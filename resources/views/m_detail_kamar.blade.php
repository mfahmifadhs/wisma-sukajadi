@extends('app')
@section('content')

<div id="banner-area" class="banner-area" style="background-image:url(../../images/main/banner/fasilitas-1.jpg)">
  <div class="banner-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="banner-heading">
            <h1 class="banner-title">KAMAR 1</h1>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                <li class="breadcrumb-item" aria-current="page">Kamar & Fasilitas</li>
                <li class="breadcrumb-item" aria-current="page">Kamar</li>
                <li class="breadcrumb-item active" aria-current="page">Kamar 1</li>
              </ol>
            </nav>
          </div>
        </div><!-- Col end -->
      </div><!-- Row end -->
    </div><!-- Container end -->
  </div><!-- Banner text end -->
</div><!-- Banner area end -->

@foreach($rooms as $room)
<section id="main-container" class="main-container">
  <div class="container">
    <div class="row">

      <div class="col-lg-6">
        <div id="page-slider" class="page-slider small-bg">
          <div class="item">
            <img loading="lazy" src="{{ asset('images/admin/kamar/'. $room->room_img) }}" class="img-thumbnail">
          </div>
        </div><!-- Page slider end -->
      </div><!-- Slider col end -->

      <div class="col-lg-6 mt-5 mt-lg-0">

        <h3 class="column-title mrt-0">FASILITAS</h3>

        <ul class="project-info list-unstyled">
          <li>
            <p class="project-info-label">  
              <span class="mr-4"><i class="fas fa-bed"></i> Kapasitas : {{ $room->room_capacity }} orang</span>
              <i class="fas fa-door-open"></i> Status : {{ $room->room_status }}
            </p>
          </li>
          <hr class="mt-2 mb-2">
          @foreach($room->rentalrate as $pricebs)
            @if($pricebs->rental_rate_ctg == 'bisnis')
            <p class="project-info-label">Bisnis</p>
            <span>
              <i class="fas fa-money-bill-wave ml-2"></i> Rp {{ number_format($pricebs->price, 0, ',', '.') }}
            </span>
            @endif
          @endforeach
          <hr class="mt-2 mb-2">
          <p class="project-info-label">Non Bisnis</p>
          @foreach($room->rentalrate as $pricenb)
            @if($pricenb->rental_rate_ctg == 'non-bisnis')
            <span style="font-size: 14px;">
              <i class="fas fa-money-bill-wave ml-2"></i> {{ $pricenb->price_ctg.' : Rp '.number_format($pricenb->price, 0, ',', '.') }}
            </span>
            @endif
          @endforeach
          <hr class="mt-2 mb-2">
          <p class="project-info-label">Sosial</p>
          @foreach($room->rentalrate as $pricess)
            @if($pricess->rental_rate_ctg == 'sosial')
            <span style="font-size: 14px;">
              <i class="fas fa-money-bill-wave ml-2"></i> {{ $pricess->price_ctg.' : Rp '.number_format($pricess->price, 0, ',', '.') }}
            </span>
            @endif
          @endforeach
        </ul>
        <a href="{{ url('beranda/kamar/daftar') }}" class="btn btn-success float-left"> 
          <i class="fas fa-arrow-alt-circle-left"></i> Kembali
        </a>
      </div>

      </div>
      <!-- Row end -->
  </div><!-- Conatiner end -->
</section>
@endforeach


@endsection