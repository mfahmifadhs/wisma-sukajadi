@extends('app')
@section('content')

<div id="banner-area" class="banner-area" style="background-image:url(../images/main/banner/sukajadi-1.jpg)">
  <div class="banner-text">
    <div class="container">
      <div class="row">
       <div class="col-lg-12">
         <div class="banner-heading">
           <h1 class="banner-title">Testimoni</h1>
           <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
               <li class="breadcrumb-item"><a href="#">Beranda</a></li>
               <li class="breadcrumb-item active" aria-current="page">Testimoni</li>
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
    <div class="row text-center">
      <div class="col-12">
        <h3 class="section-sub-title mb-4">Testimoni</h3>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="quote-item quote-border mt-5">
          <div class="quote-text-border">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
          </div>

          <div class="quote-item-footer">
            <img loading="lazy" class="testimonial-thumb" src="https://cdn-icons-png.flaticon.com/512/599/599305.png" alt="testimonial">
            <div class="quote-item-info">
              <h3 class="quote-author">Gabriel Denis</h3>
              <span class="quote-subtext">Pengunjung</span>
            </div>
          </div>
        </div><!-- Quote item end -->
      </div><!-- End col md 4 -->

      <div class="col-lg-4 col-md-6">
        <div class="quote-item quote-border mt-5">
         <div class="quote-text-border">
          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
        </div>

        <div class="quote-item-footer">
          <img loading="lazy" class="testimonial-thumb" src="https://cdn-icons-png.flaticon.com/512/599/599305.png" alt="testimonial">
          <div class="quote-item-info">
           <h3 class="quote-author">Weldon Cash</h3>
           <span class="quote-subtext">Pengunjung</span>
          </div>
        </div>
        </div><!-- Quote item end -->
      </div><!-- End col md 4 -->

      <div class="col-lg-4 col-md-6">
        <div class="quote-item quote-border mt-5">
          <div class="quote-text-border">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
          </div>

          <div class="quote-item-footer">
            <img loading="lazy" class="testimonial-thumb" src="https://cdn-icons-png.flaticon.com/512/599/599305.png" alt="testimonial">
            <div class="quote-item-info">
              <h3 class="quote-author">Hyram Izzy</h3>
              <span class="quote-subtext">Pengunjung</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


@endsection