@extends('v_admin_sukajadi.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>Reservasi</b></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Reservasi</li>
                    <li class="breadcrumb-item active">Buat Reservasi</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Choosing Room content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline" style="margin-left: 5%;margin-right: 5%;">
                    <div class="card-header">
                        <h4 class="card-title">Detail Reservasi</h4>
                        <div class="card-tools">
                            @if($rsv->status_reservation == 'reserved')
                            <a href="{{ url('admin-sukajadi/reservasi/checkin/'.$rsv->id_reservation) }}" class="btn btn-success btn-xs" onclick="return confirm('Check In ?')">
                                <i class="fas fa-check"></i> Check In </a>
                            @endif

                            @if($rsv->status_reservation == 'checkout')
                            <a href="{{ url('admin-sukajadi/reservasi/checkout/'.$rsv->id_reservation) }}" class="btn btn-danger btn-xs" onclick="return confirm('Check Out ?')">
                                <i class="fas fa-check"></i> Check Out
                            </a>
                            @endif
                        </div>
                    </div>

                    <form action="{{ url('admin-sukajadi/tambah-reservasi') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_visitor" value="{{ random_int(100000, 999999) }}">
                        <input type="hidden" name="id_reservation" value="{{ $rsv->id_reservation }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row text-capitalize">
                                <div class="col-sm-12 text-center font-weight-bold">Informasi Pengunjung
                                    <hr>
                                </div>
                                <div class="col-sm-12">
                                    <img src="{{ asset('images/admin/pengunjung/'. $rsv->visitor->identity_img )}}" class="mb-4 border" width="200">
                                </div>
                                <label class="col-sm-2">NIK</label>
                                <div class="col-sm-10">:
                                    {{ $rsv->visitor->identity_num }}
                                </div>
                                <label class="col-sm-2">Nama Pengunjung</label>
                                <div class="col-sm-4">:
                                    {{ $rsv->visitor->visitor_name }}
                                </div>
                                <label class="col-sm-2">Nomor Handphone</label>
                                <div class="col-sm-4">:
                                    {{ $rsv->visitor->visitor_phone_number }}
                                </div>
                                <label class="col-sm-2">Tanggal Lahir</label>
                                <div class="col-sm-4">:
                                    {{ $rsv->visitor->visitor_birthdate }}
                                </div>
                                <label class="col-sm-2">Alamat</label>
                                <div class="col-sm-4">:
                                    {{ $rsv->visitor->visitor_address }}
                                </div>
                                <label class="col-sm-2">Asal Instansi</label>
                                <div class="col-sm-4">:
                                    {{ $rsv->visitor->visitor_instance }}
                                </div>
                                <label class="col-sm-2">Keterangan</label>
                                <div class="col-sm-4">:
                                    {{ $rsv->visitor->visitor_description }}
                                </div>
                                @if ($rsv->assignment_letter)
                                <label class="col-sm-2">Surat Tugas</label>
                                <div class="col-sm-4">:
                                    <a download="{{ $rsv->assignment_letter }}" href="" title="Surat Tugas">
                                        Surat Tugas
                                    </a>
                                </div>
                                @endif
                            </div>

                            @if ($rsv->status_reservation == '')
                            <input type="hidden" name="process" value="pemilihan-kamar">
                            <div class="section-more-room">
                                <div class="form-group row">
                                    <div class="col-sm-12 text-center font-weight-bold">
                                        <hr>
                                        Pemilihan Kamar
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="float-left">
                                            <label class="col-sm-12 col-form-label">Reservasi Kamar [1]</label>
                                        </div>
                                        <div class="float-right">
                                            <!-- <a id="add-more-room" class="btn btn-outline-primary btn-block btn-sm mt-1">
                                                <i class="fas fa-plus-circle"> </i> Tambah Kamar
                                            </a> -->
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    @if ($message = Session::get('failed-room'))
                                    <div class="col-sm-12 mb-4">
                                        <p class="fw-light text-danger" style="margin: auto;">*{{ $message }}</p>
                                    </div>
                                    @endif
                                    <label class="col-sm-2 col-form-label">Tanggal Check In</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="checkin[]" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}" min="<?= date('Y-m-d'); ?>">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Tanggal Check Out</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="checkout[]" value="{{ \Carbon\Carbon::tomorrow()->isoFormat('Y-MM-DD') }}" min="<?= date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kamar</label>
                                    <div class="col-sm-4">
                                        <select class="form-control data-room" id="roomid0" name="room_id[]" required>
                                            <option value="">-- Pilih Kamar --</option>
                                            @foreach($room as $room)
                                            <option value="{{ $room->id_room }}">{{ $room->room_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Tarif Sewa</label>
                                    <div class="col-sm-4">
                                        <select class="form-control category" data-target="0" id="rentalrateid0" required>
                                            <option value="">-- Pilih Kamar --</option>
                                            @foreach($price as $price)
                                            <option value="{{ $price->rental_rate_ctg }}">{{ $price->rental_rate_ctg }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <!-- <label class="col-sm-2 col-form-label">Kategori</label>
                                    <div class="col-sm-4">
                                        <select class="form-control price" data-target="0" id="show-category0">
                                            @foreach($price_ctg as $price_ctg)
                                            @if($price_ctg->price_ctg == null)
                                            <option value="">-</option>
                                            @else
                                            <option value="{{ $price_ctg->price_ctg }}">{{ $price_ctg->price_ctg }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div> -->
                                    <label class="col-sm-2 col-form-label">Harga (Rp)</label>
                                    <div class="col-sm-4">
                                        <input type="hidden" id="id-room0" name="rental_rate_id[]">
                                        <input type="text" id="price-room0" name="price[]" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <a id="add-more-room" class="btn btn-outline-primary btn-block btn-sm mt-1">
                                        <i class="fas fa-plus-circle"> </i> Tambah Kamar
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if ($rsv->status_reservation == 'payment')
                            <input type="hidden" name="process" value="pembayaran">
                            <div class="section-payment">
                                <div class="form-group row">
                                    <div class="col-sm-12 text-center font-weight-bold">
                                        <hr>
                                        Pembayaran
                                        <hr>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Total Pembayaran</label>
                                    <div class="col-sm-4">:
                                        <label class="col-form-label">Rp {{ number_format($rsv->payment_total, 0, ',', '.') }}</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kode Biling</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="billing_code" placeholder="Tuliskan kode biling sesuai yang diberikan Bendahara PNBP" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Bukti Pembayaran</label>
                                    <div class="col-sm-8">
                                        <div class="btn btn-default btn-file">
                                            <i class="fas fa-paperclip"></i> Upload Bukti Pembayaran
                                            <input type="file" name="payment_img" class="image-payment" required>
                                            <img id="preview-image-payment" style="max-height: 80px;">
                                        </div>
                                        <p class="help-block" style="font-size: 12px;">Max. 5MB</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-4">
                                        @php
                                        $phone = "6285772652563";
                                        $date = \Carbon\carbon::parse($rsv->reservation_date)->isoFormat('DD/MM/Y');
                                        $name = ucwords($rsv->visitor->visitor_name);
                                        $room = $rsv->reservationdetail;
                                        $price = number_format($rsv->payment_total, 0, ',', '.');
                                        $msg = "Reservasi Pengunjung,
                                        %0ATanggal : $date
                                        %0AAtas Nama : $name, %0A*Total Pembayaran : Rp $price* %0ADengan Riancian : ";
                                        foreach($room as $dataRoom) {
                                        $msg .= "%0A▪️".$dataRoom->room_name." durasi ".$dataRoom->duration." malam, ";
                                        }
                                        $msg = rtrim($msg, ", "); // Menghapus koma terakhir dari string

                                        @endphp
                                        <a href="https://api.whatsapp.com/send?phone=+{{ $phone }}&text={{ $msg }}" target="_blank">
                                            Konfirmasi ke Bendahara PNBP (WhatsApp)
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="section-room">
                                <div class="form-group row">
                                    <div class="col-sm-12 text-center font-weight-bold">
                                        <hr>
                                        Informasi Kamar
                                        <hr>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th>No</thclass=>
                                                    <th>Kamar</th>
                                                    <th>Tanggal Check In</th>
                                                    <th>Tanggal Check Out</th>
                                                    <th>Durasi</th>
                                                    <th>Kategori</th>
                                                    <th>Tarif Sewa /malam</th>
                                                    <th>Total Tarif Sewa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($rsv->reservationdetail as $i => $row)
                                                <tr>
                                                    <td>
                                                        {{ $i + 1 }}
                                                        <input type="hidden" name="room_id[]" value="{{ $row->room_id }}">
                                                    </td>
                                                    <td>{{ $row->room_name }}</td>
                                                    <td>{{ \Carbon\carbon::parse($row->check_in)->isoFormat('DD/MM/Y') }}</td>
                                                    <td>{{ \Carbon\carbon::parse($row->check_out)->isoFormat('DD/MM/Y') }}</td>
                                                    <td>{{ $row->duration }} malam</td>
                                                    <td>{{ $row->rental_rate_ctg }}</td>
                                                    <td>Rp {{ number_format($row->new_price, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($row->detail_reservation_price, 0, ',', '.') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if ($rsv->status_reservation == 'reserved')
                            <input type="hidden" name="process" value="pembayaran">
                            <div class="section-payment">
                                <div class="form-group row">
                                    <div class="col-sm-12 text-center font-weight-bold">
                                        <hr>
                                        Pembayaran
                                        <hr>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tanggal Pembayaran</label>
                                    <div class="col-sm-4">:
                                        <label class="col-form-label">{{ \Carbon\carbon::parse($rsv->payment_date)->isoFormat('DD/MM/Y') }}</label>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Total Pembayaran</label>
                                    <div class="col-sm-4">:
                                        <label class="col-form-label">Rp {{ number_format($rsv->payment_total, 0, ',', '.') }}</label>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Kode Biling</label>
                                    <div class="col-sm-4">:
                                        <label class="col-form-label">{{ $rsv->billing_code }}</label>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Bukti Pembayaran</label>
                                    <div class="col-sm-4">:
                                        <a href="" data-toggle="modal" data-target="#paymentImg">
                                            <label class="col-form-label">Bukti Pembayaran</label>
                                        </a>
                                        <div class="modal fade" id="paymentImg" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Bukti Pembayaran</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Tanggal : {{ \Carbon\carbon::parse($rsv->payment_date)->isoFormat('DD/MM/Y') }}</p>
                                                        <p>Nama File : {{ $rsv->payment_img }}</p>
                                                        <img src="{{ url($rsv->payment_img_url) }}" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section-room">
                                <div class="form-group row">
                                    <div class="col-sm-12 text-center font-weight-bold">
                                        <hr>
                                        Informasi Kamar
                                        <hr>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th>No</thclass=>
                                                    <th>Kamar</th>
                                                    <th>Tanggal Check In</th>
                                                    <th>Tanggal Check Out</th>
                                                    <th>Durasi</th>
                                                    <th>Kategori</th>
                                                    <th>Tarif Sewa /malam</th>
                                                    <th>Total Tarif Sewa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($rsv->reservationdetail as $i => $row)
                                                <tr>
                                                    <td>{{ $i + 1 }}</tdclass=>
                                                    <td>{{ $row->room_name }}</td>
                                                    <td>{{ \Carbon\carbon::parse($row->check_in)->isoFormat('DD/MM/Y') }}</td>
                                                    <td>{{ \Carbon\carbon::parse($row->check_out)->isoFormat('DD/MM/Y') }}</td>
                                                    <td>{{ $row->duration }} malam</td>
                                                    <td>{{ $row->rental_rate_ctg }}</td>
                                                    <td>Rp {{ number_format($row->new_price, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($row->detail_reservation_price, 0, ',', '.') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                        @if ($rsv->status_reservation == '' || $rsv->status_reservation == 'payment')
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Buat Reservasi ?')">
                                    <i class="fas fa-paper-plane"></i> Submit
                                </button>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

@section('js')
<!-- Lainya -->
<script>
    // Upload Foto
    $('.image-ktp').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image-ktp').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
    $('.image-payment').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image-payment').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
    $('.image-assignment-letter').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image-assignment-letter').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
    // Harga
    function updateTextView(_obj) {
        var num = getNumber(_obj.val());
        if (num == 0) {
            _obj.val('');
        } else {
            _obj.val(num.toLocaleString());
        }
    }

    function getNumber(_str) {
        var arr = _str.split('');
        var out = new Array();
        for (var cnt = 0; cnt < arr.length; cnt++) {
            if (isNaN(arr[cnt]) == false) {
                out.push(arr[cnt]);
            }
        }
        return Number(out.join(''));
    }
    $(document).ready(function() {
        $('input[type=price]').on('keyup', function() {
            updateTextView($(this));
        });
    });
</script>

<!-- Menampilkan harga tarif sewa -->
<script>
    let i = 0;
    // Menampilkan harga tarif sewa
    $(document).on('change', '.category', function() {
        let target = $(this).data('target');
        let roomid = $('#roomid' + target).val();
        let rentalrateid = $(this).val();
        if (rentalrateid) {
            $.ajax({
                type: "GET",
                url: "/admin-sukajadi/json-get-category?rentalrateid=" + rentalrateid,
                data: {
                    "roomid": roomid
                },
                dataType: 'JSON',
                success: function(res) {
                    if (res) {
                        $("#rental_rate_price" + target).empty();
                        $("#rental_rate_price" + target).append('<option value="">-- Pilih Kategori --</option>');
                        $.each(res, function(index, value) {
                            $('#id-room' + target).val(index);
                            $('#price-room' + target).val(value);
                        });
                    } else {
                        $("#rental_rate_price" + target).empty();
                    }
                }
            });
        } else {
            $("#rental_rate_price" + target).empty();
        }

    });

    // Menampilkan harga tarif sewa
    $(document).on('change', '.price', function() {
        ++i;
        let target = $(this).data('target');
        let roomid = $('#roomid' + target).val();
        let rentalrateid = $('#rentalrateid' + target).val();
        let category = $(this).val();
        console.log(roomid);
        if (category) {
            $.ajax({
                type: "GET",
                url: "/admin-sukajadi/json-get-price?roomid=" + roomid,
                data: {
                    "rentalrateid": rentalrateid,
                    "categoryid": category
                },
                dataType: 'JSON',
                success: function(res) {
                    if (res) {
                        $("#rental_rate_price" + target).empty();
                        $.each(res, function(id_rental_rate, price) {
                            $('#id-room' + target).val(id_rental_rate);
                            $('#price-room' + target).val(price);
                        });
                    } else {
                        $("#rental_rate_price" + target).empty();
                    }
                }
            });
        } else {
            $("#rental_rate_price" + target).empty();
        }
    });
</script>

<!-- Tambah Kamar (Add More) -->
<script>
    $(function() {
        let i = 0;
        let num = 1;
        let dataroom = [];
        // Menyimpan data id room / kamar
        $(document).on('change', '.data-room', function() {
            dataroom = $('.data-room').map(function() {
                return this.value
            }).get();
        });
        // Tambah reservasi kamar
        $("#add-more-room").click(function() {
            ++i;
            ++num;
            $.ajax({
                type: "GET",
                url: "/admin-sukajadi/json-get-room",
                data: {
                    "dataroom": dataroom
                },
                dataType: 'JSON',
                success: function(res) {
                    let optRoom = "";
                    let optRentalRate = "";
                    let optCategory = "";

                    $.each(res.room, function(index, value) {
                        optRoom += '<option value=' + value.id_room + '>' + value.room_name + '</option>'
                    });
                    $.each(res.price, function(index, value) {
                        optRentalRate += '<option value=' + value.rental_rate_ctg + '>' + value.rental_rate_ctg + '</option>'
                    });
                    // $.each(res.price_ctg, function(index, value) {
                    //     if (value.price_ctg == null) {
                    //         optCategory += '<option value="">-</option>'
                    //     } else {
                    //         optCategory += '<option value=' + value.price_ctg + '>' + value.price_ctg + '</option>'
                    //     }
                    // });

                    console.log('kamar', optRentalRate)
                    $(".section-more-room").append(
                        `<div class="more-room">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="float-left">
                                        <label class="col-sm-12 col-form-label">Reservasi Kamar [` + num + `]</label>
                                    </div>
                                    <div class="float-right">
                                        <a id="remove-more-room" class="btn btn-outline-danger btn-block btn-sm mt-1" onclick="return confirm(Buat Reservasi ?  )">
                                            <i class="fas fa-times-circle">  </i> Batal
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal Check In</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="checkin[` + i + `]"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" min="<?= date('Y-m-d'); ?>">
                                </div>
                                <label class="col-sm-2 col-form-label">Tanggal Check Out</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="checkout[` + i + `]"
                                    value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" min="<?= date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kamar</label>
                                <div class="col-sm-4">
                                    <select class="form-control data-room" id="roomid` + i + `" name="room_id[` + i + `]">
                                        <option value="">-- Pilih Kamar --</option>
                                        ` + optRoom + `
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Tarif Sewa</label>
                                <div class="col-sm-4">
                                    <select class="form-control category" data-target="` + i + `" id="rentalrateid` + i + `">
                                        <option value="">-- Pilih Tarif Sewa --</option>
                                        ` + optRentalRate + `
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Harga (Rp)</label>
                                <div class="col-sm-4">
                                    <input type="hidden" id="id-room` + i + `" name="rental_rate_id[` + i + `]">
                                    <input type="text" id="price-room` + i + `" name="price[` + i + `]" class="form-control" readonly>
                                </div>
                            </div>
                        </div>`
                    );
                }
            });
        });
        // Menghapus Section
        $(document).on('click', '#remove-more-room', function() {
            $(this).parents('.more-room').remove();
        });
    });
</script>


@endsection

@endsection
