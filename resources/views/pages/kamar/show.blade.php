@extends('layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">WISMA SUKAJADI</h1>
                <h5>Wisma Kemenkes Sukajadi Bandung</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Daftar Kamar</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
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
                <!-- /.card -->
                <div class="row">
                    @for ($i = 5; $i <= 7; $i++)
                    <div class="col-12 col-sm-6 col-md-4">
                        <a href="{{ route('kamar', $i) }}" style="color: black;">
                            <div class="info-box">
                                <span class="info-box-icon bg-default elevation-1">
                                    <i class="fas fa-bed {{ $i == 5 ? ( 'text-success' ) : ( $i == 6 ? 'text-danger' : 'text-warning' )  }}"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-number">
                                        {{ $totalKamar->where('status_kamar', $i)->count() }} kamar
                                    </span>
                                    <span class="info-box-text">
                                        {{ $i == 5 ? ( 'Tersedia' ) : ( $i == 6 ? 'Sudah Dipesan' : 'Dalam Pemeliharaan' )  }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endfor
            </div>
        </div>
        <div class="col-md-12">
            <hr>
            <div class="row">
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari Berdasarkan Kamar">
                </div>
                <div class="col-md-12" id="searchResult">
                    @if(count($kamar) == 0)
                    <p>Data tidak ditemukan</p>
                    @else
                    <div id="cardContainer" class="row">
                        @foreach($kamar as $i => $row)
                        <div class="col-md-4 room-card">
                            <a href="{{ route('kamar.detail', $row->id_kamar) }}" style="cursor: pointer;height: 100%;color:black;">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h3 class="card-title font-weight-bold room-name">
                                            {{ $row->nama_kamar }}
                                        </h3>
                                        <div class="card-tools">
                                                Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <img src="{{ asset('images/admin/kamar/'. $row->foto_kamar) }}" class="img-thumbnail img-fluid">
                                            </div>
                                            <div class="col-md-6 col-6 room-area">
                                                <i class="fas fa-vector-square"></i>
                                                Luas {{ number_format($row->luas_kamar, $row->luas_kamar == intval($row->luas_kamar) ? 0 : 2) }} m<sup>2</sup>
                                            </div>
                                            <div class="col-md-6 col-6 room-capacity">
                                                <i class="fas fa-users"></i> Kapasitas : {{ $row->kapasitas }} orang
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">Tarif Sewa</div>
                                            @foreach($row->tarif as $subRow)
                                            <div class="col-md-5 col-5">{{ $subRow->kategori_tamu }}</div>
                                            <div class="col-md-7 col-7">: {{ 'Rp '. number_format($subRow->harga_sewa, 0, ',', '.') }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach

                        <!-- Notifikasi jika data tidak ditemukan -->
                        <div id="noResult" class="col-md-12" style="display: none;">
                            <p>Tidak ada hasil yang cocok dengan kata kunci yang Anda masukkan.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#table-1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false
        }).buttons().container().appendTo('#table-1_wrapper .col-md-6:eq(0)');
    });


    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });

    function search() {
        var input, filter, cards, cardContainer, h6, title, i;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        cardContainer = document.getElementById("cardContainer");
        cards = cardContainer.getElementsByClassName("col-md-4");
        console.log('data', input)

        for (i = 0; i < cards.length; i++) {
            roomName = cards[i].querySelector(".room-name");
            roomArea = cards[i].querySelector(".room-area");
            roomCapacity = cards[i].querySelector(".room-name");

            if (roomName.innerText.toUpperCase().indexOf(filter) > -1 ||
                roomArea.innerText.toUpperCase().indexOf(filter) > -1 ||
                roomCapacity.innerText.toUpperCase().indexOf(filter) > -1) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }

        var noResult = document.getElementById("noResult");
        var count = 0;
        for (i = 0; i < cards.length; i++) {
            if (cards[i].style.display === "") {
                count++;
            }
        }
        if (count === 0) {
            noResult.style.display = "block";
        } else {
            noResult.style.display = "none";
        }
    }

    // Trigger search function when typing in search input
    document.getElementById("searchInput").addEventListener("keyup", search);
</script>
@endsection

@endsection
