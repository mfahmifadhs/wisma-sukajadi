@extends('v_admin_sukajadi.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>Kamar</b></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/dashboard') }}">Dashboard</a></li>
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
                    <div class="col-12 col-sm-6 col-md-4">
                        <a href="{{ url('admin-sukajadi/kamar/tersedia') }}" style="color: black;">
                            <div class="info-box">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-bed"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Kamar Tersedia</span>
                                    <span class="info-box-number">
                                        {{ $capacity->where('room_status','tersedia')->whereNull('deleted_at')->count() }} kamar
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <a href="{{ url('admin-sukajadi/kamar/terisi') }}" style="color: black;">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-bed"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Kamar Terisi</span>
                                    <span class="info-box-number">
                                        {{ $capacity->where('room_status','tidak tersedia')->whereNull('deleted_at')->count() }} kamar
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <a href="{{ url('admin-sukajadi/kamar/maintenance') }}" style="color: black;">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-bed"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Kamar Tidak Tersedia</span>
                                    <span class="info-box-number">
                                        {{ $capacity->where('room_status','maintenance')->whereNull('deleted_at')->count() }} kamar
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
                <div class="row">
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari Berdasarkan Kamar">
                    </div>
                    <div class="col-md-12" id="searchResult">
                        @if(count($rooms) == 0)
                        <p>Data tidak ditemukan</p>
                        @else
                        <div id="cardContainer" class="row">
                            @foreach($rooms as $i => $row)
                            <div class="col-md-4 room-card">
                                <a href="{{ url('admin-sukajadi/kamar/detail/'. $row->id_room) }}" style="cursor: pointer;height: 100%;color:black;">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <img src="{{ asset('images/admin/kamar/'. $row->room_img) }}" class="img-thumbnail img-fluid" style="height: 250px;">
                                                </div>
                                                <div class="col-md-12 col-12 room-name">
                                                    <i class="fas fa-bed"></i> {{ $row->room_name }}
                                                </div>
                                                <div class="col-md-6 col-6 room-area">
                                                    <i class="fas fa-vector-square"></i>
                                                    Luas {{ number_format($row->room_area, $row->room_area == intval($row->room_area) ? 0 : 2) }} m<sup>2</sup>
                                                </div>
                                                <div class="col-md-6 col-6 room-capacity">
                                                    <i class="fas fa-users"></i> Kapasitas : {{ $row->room_capacity }} orang
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">Tarif Sewa</div>
                                                @foreach($row->rentalrate as $rentalrate)
                                                <div class="col-md-5">{{ $rentalrate->rental_rate_ctg }}</div>
                                                <div class="col-md-7">: {{ 'Rp '. number_format($rentalrate->new_price, 0, ',', '.') }}</div>
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
            <!-- <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <div class="card">
                            <div class="card-body">
                                <table id="table-1" class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <td>
                                                <div class="row">

                                                </div>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%;">Foto</th>
                                            <th>Informasi Kamar</th>
                                            <th>Harga Tarif Sewa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rooms as $row)
                                        <tr class="clickable-row" data-href="{{ url('admin-sukajadi/kamar/detail/'. $row->id_room) }}" style="cursor: pointer;height: 100%;">
                                            <td>
                                                <img src="{{ asset('images/admin/kamar/'. $row->room_img) }}" class="img-thumbnail img-fluid">
                                            </td>
                                            <td>
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td>{{ $row->room_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Luas {{ number_format($row->room_area, $row->room_area == intval($row->room_area) ? 0 : 2) }} m<sub>2</sub></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kapasitas : {{ $row->room_capacity }} orang</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6>
                                                                @if( $row->room_status == 'tersedia')
                                                                <span class="badge bg-success">Tersedia</span>
                                                                @elseif( $row->room_status == 'tidak tersedia')
                                                                <span class="badge bg-warning">Dipesan</span>
                                                                @elseif( $row->id_room == 10)
                                                                <span class="badge badge-danger">Tidak Disewakan (Ruang kantor)</span>
                                                                @else
                                                                <span class="badge badge-danger">Dibersihkan</span>
                                                                @endif
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table class="table table-borderless">
                                                    @foreach($row->rentalrate as $rentalrate)
                                                    <tr>
                                                        <td>
                                                            <div class="row">
                                                                <label class="col-md-4">
                                                                    {{ $rentalrate->rental_rate_ctg }}
                                                                </label>
                                                                <div class="col-md-8">:
                                                                    {{ 'Rp '. number_format($rentalrate->new_price, 0, ',', '.') }}
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @foreach($rooms as $room)
                    <div class="col-md-12 form-group">
                        <div class="card card-primary card-outline" style="height: 100%;">
                            <div class="card-header">
                                <h5 class="card-title mt-1"><b>{{ $room->room_name }}</b></h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ asset('images/admin/kamar/'. $room->room_img) }}" class="img-thumbnail" style="width: 100%;max-height: 100%;">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Kamar : </label>
                                                <h6>{{ $room->room_name }}</h6>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Kapasitas : </label>
                                                <h6>{{ $room->room_capacity }} orang</h6>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Status : </label>
                                                <h6>
                                                    @if( $room->room_status == 'tersedia')
                                                    <span class="badge bg-success">Tersedia</span>
                                                    @elseif( $room->room_status == 'tidak tersedia')
                                                    <span class="badge bg-warning">Dipesan</span>
                                                    @elseif( $room->id_room == 10)
                                                    <span class="badge badge-danger">Tidak Disewakan (Ruang kantor)</span>
                                                    @else
                                                    <span class="badge badge-danger">Dibersihkan</span>
                                                    @endif
                                                </h6>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <hr>
                                                <label>Harga Tarif Sewa</label>
                                            </div>
                                            @foreach($room->rentalrate as $rentalrate)
                                            <div class="col-md-4 text-capitalize form-group">
                                                <label>{{ $rentalrate->rental_rate_ctg }}</label>
                                                <h6>{{ 'Rp '. number_format($rentalrate->new_price, 0, ',', '.') }}</h6>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <span class="float-right">
                                    <a href="{{ url('admin-sukajadi/kamar/detail/'. $room->id_room) }}" class="btn btn-primary"><i class="fas fa-info-circle"></i> Detail</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-12">

                    </div>
                </div>
            </div> -->
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
