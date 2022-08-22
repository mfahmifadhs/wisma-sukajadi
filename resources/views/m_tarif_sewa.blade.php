@extends('app')
@section('content')

<div id="banner-area" class="banner-area" style="background-image:url(../assets/images/banner/fasilitas-1.jpg)">
  <div class="banner-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="banner-heading">
            <h1 class="banner-title">TARIF SEWA KATEGORI BISNIS</h1>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                <li class="breadcrumb-item" aria-current="page">Tarif Sewa</li>
                <li class="breadcrumb-item active" aria-current="page">Kategori Bisnis</li>
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
    <div class="row">

      <div class="col-lg-8 mb-5 mb-lg-0">
        <h3 class="column-title">Tarif Sewa Kamar</h3>
        <div class="post">
          <div class="card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="post-media post-image">
                    <img loading="lazy" src="{{ asset('assets/images/room/kamar-1.jpg') }}" class="img-fluid" alt="post-image">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="post-body">
                    <div class="entry-header">
                      <div class="post-meta">
                        <h6>
                          <a href="news-single.html">Kamar 1</a>
                        </h6>
                        <span class="post-cat">
                          <i class="fas fa-bed"></i><a href="#"> 2 Kasur</a>
                        </span>
                        <span class="post-author">
                          <i class="fas fa-users"></i><a href="#"> 2 Orang</a>
                        </span>
                        <span class="post-meta-date"><i class="fas fa-rupiah-sign"></i> 354.000</span>
                      </div>
                    </div><!-- header end -->

                    <div class="entry-content">
                      <p>Lorem ipsum dolor sit amet.</p>
                    </div>

                    <div class="post-footer">
                      <a href="{{ url('beranda/detail_kamar') }}" class="btn btn-primary">Lihat Kamar 
                        <i class="fas fa-arrow-alt-circle-right"></i>
                      </a>
                    </div>

                  </div><!-- post-body end -->
                </div>
              </div>
            </div>
          </div>

          <div class="card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="post-media post-image">
                    <img loading="lazy" src="{{ asset('assets/images/room/kamar-2.jpg') }}" class="img-fluid" alt="post-image">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="post-body">
                    <div class="entry-header">
                      <div class="post-meta">
                        <h6>
                          <a href="news-single.html">Kamar 2</a>
                        </h6>
                        <span class="post-cat">
                          <i class="fas fa-bed"></i><a href="#"> 4 Kasur</a>
                        </span>
                        <span class="post-author">
                          <i class="fas fa-users"></i><a href="#"> 4 Orang</a>
                        </span>
                        <span class="post-meta-date"><i class="fas fa-rupiah-sign"></i> 278.000</span>
                      </div>
                    </div><!-- header end -->

                    <div class="entry-content">
                      <p>Lorem ipsum dolor sit amet.</p>
                    </div>

                    <div class="post-footer">
                      <a href="news-single.html" class="btn btn-primary">Lihat Kamar <i class="fas fa-arrow-alt-circle-right"></i></a>
                    </div>

                  </div><!-- post-body end -->
                </div>
              </div>
            </div>
          </div>

          <nav class="paging" aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a></li>
            </ul>
          </nav>
        </div>
      </div><!-- Content Col end -->

      <div class="col-lg-4">
        <div class="widget recent-posts">
          <h3 class="widget-title">Cari Kamar</h3>
          <form action="">
            <div class="form-group">
              <label for="">Kapasitas :</label>
              <select name="" id="" class="form-control">
                <option value="">1 Orang</option>
                <option value="">2 Orang</option>
                <option value="">3 Orang</option>
              </select>
            </div>
            <button class="btn btn-primary">Cari</button>
          </form>

        </div><!-- Recent post end -->
      </div><!-- Sidebar Col end -->

    </div><!-- Main row end -->

  </div><!-- Container end -->
</section><!-- Main container end -->



@endsection