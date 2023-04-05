@extends('v_admin_sukajadi.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
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

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- /.col -->
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
        <div class="card card-primary card-outline" style="margin-left: 5%;margin-right: 5%;">
          <div class="card-header">
            <h3 class="card-title">Buat Reservasi</h3>
          </div>
          <!-- /.card-header -->
          <form action="{{ url('admin-sukajadi/tambah-reservasi') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_visitor" value="{{ random_int(100000, 999999) }}">
            <input type="hidden" name="id_reservation" value="{{ \Carbon\Carbon::now()->isoFormat('DDMMYYhhmmss') }}">
            @csrf
            <div class="card-body">
              <div class="form-group row">
                <label class="col-sm-12 col-form-label text-center">Informasi Pengunjung <hr></label>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">NIK</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" name="identity_num" placeholder="nomor induk kependudukan (NIK)">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Foto KTP</label>
                <div class="col-sm-8">
                  <div class="btn btn-default btn-file">
                    <i class="fas fa-paperclip"></i> Upload Foto KTP
                    <input type="file" name="identity_img" class="image-ktp" required>
                    <img id="preview-image-ktp" style="max-height: 80px;">
                  </div><br>
                  <span class="help-block" style="font-size: 12px;">Max. 5MB</span>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="visitor_name" placeholder="nama lengkap pengunjung">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control" name="visitor_birthdate" placeholder="nama lengkap pengunjung">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">No. Hp</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="visitor_phone_number" placeholder="nomor handphone aktif">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="visitor_address" placeholder="Alamat"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Asal Instansi</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="visitor_instance" placeholder="Asal Instansi">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Keterangan</label>
                <div class="col-sm-10">
                  <textarea type="text" class="form-control" name="visitor_description" placeholder="Keterangan Pengunjung (Jabatan, dsb)"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Surat Tugas</label>
                <div class="col-sm-8">
                  <div class="btn btn-default btn-file">
                    <i class="fas fa-paperclip"></i> Upload Surat Tugas
                    <input type="file" name="assignment_letter" class="image-assignment-letter">
                    <img id="preview-image-assignment-letter" style="max-height: 80px;">
                  </div><br>
                  <span class="help-block" style="font-size: 12px;">Format PDF (Max. 5MB)</span>
                </div>
              </div>
              <!-- <div class="section-payment">
                <div class="form-group row">
                    <label class="col-sm-12 col-form-label text-center">Pembayaran <hr></label>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                    <select class="form-control" name="status_reservation">
                        <option value="reservation">reservasi</option>
                    </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kode Biling</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="billing_code" placeholder="diisi setelah pengunjung melakukan pembayaran">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Bukti Pembayaran</label>
                    <div class="col-sm-8">
                    <div class="btn btn-default btn-file">
                        <i class="fas fa-paperclip"></i> Upload Bukti Pembayaran
                        <input type="file" name="payment_img" class="image-payment">
                        <img id="preview-image-payment" style="max-height: 80px;">
                    </div>
                    <p class="help-block" style="font-size: 12px;">Max. 5MB</p>
                    </div>
                </div>
              </div> -->
              <!-- <div class="section-more-room">
                <div class="form-group row">
                  <div class="col-md-12">
                    <hr>
                  </div>
                  <div class="col-md-12">
                    <div class="float-left">
                      <label class="col-sm-12 col-form-label">Reservasi Kamar [1]</label>
                    </div>
                    <div class="float-right">
                      <a id="add-more-room" class="btn btn-outline-primary btn-block btn-sm mt-1">
                        <i class="fas fa-plus-circle">  </i> Tambah Kamar
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
                    <input type="date" class="form-control" name="checkin[]" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}"
                    min="<?= date('Y-m-d'); ?>">
                  </div>
                  <label class="col-sm-2 col-form-label">Tanggal Check Out</label>
                  <div class="col-sm-4">
                    <input type="date" class="form-control" name="checkout[]" value="{{ \Carbon\Carbon::tomorrow()->isoFormat('Y-MM-DD') }}"
                    min="<?= date('Y-m-d'); ?>" >
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Kamar</label>
                  <div class="col-sm-4">
                    <select class="form-control data-room" id="roomid0" name="room_id[]">
                      <option value="">-- Pilih Kamar --</option>
                      @foreach($room as $room)
                      <option value="{{ $room->id_room }}">{{ $room->room_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <label class="col-sm-2 col-form-label">Tarif Sewa</label>
                  <div class="col-sm-4">
                    <select class="form-control category" data-target="0" id="rentalrateid0">
                      <option value="">-- Pilih Kategori Tarif Sewa --</option>
                      @foreach($price as $price)
                      <option value="{{ $price->rental_rate_ctg }}">{{ $price->rental_rate_ctg }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Kategori</label>
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
                  </div>
                  <label class="col-sm-2 col-form-label">Harga (Rp)</label>
                  <div class="col-sm-4">
                    <input type="hidden" id="id-room0" name="rental_rate_id[]">
                    <input type="text" id="price-room0" name="price[]" class="form-control" readonly>
                  </div>
                </div>
              </div> -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <div class="float-right">
                <button type="submit" class="btn btn-primary" onclick="return confirm('Buat Reservasi ?')">
                  <i class="fas fa-plus-square"></i> Buat Reservasi</button>
              </div>
              <!-- <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Batal</button> -->
            </div>
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
  $('.image-ktp').change(function(){
    let reader = new FileReader();
    reader.onload = (e) => {
      $('#preview-image-ktp').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
  });
  $('.image-payment').change(function(){
    let reader = new FileReader();
    reader.onload = (e) => {
      $('#preview-image-payment').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
  });
  $('.image-assignment-letter').change(function(){
    let reader = new FileReader();
    reader.onload = (e) => {
      $('#preview-image-assignment-letter').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
  });
  // Harga
  function updateTextView(_obj){
    var num = getNumber(_obj.val());
    if(num==0){
      _obj.val('');
    }else{
      _obj.val(num.toLocaleString());
    }
  }
  function getNumber(_str){
    var arr = _str.split('');
    var out = new Array();
    for(var cnt=0;cnt<arr.length;cnt++){
      if(isNaN(arr[cnt])==false){
        out.push(arr[cnt]);
      }
    }
    return Number(out.join(''));
  }
  $(document).ready(function(){
    $('input[type=price]').on('keyup',function(){
      updateTextView($(this));
    });
  });
</script>

<!-- Menampilkan harga tarif sewa -->
<script>
  let i = 0;
  // Menampilkan harga tarif sewa
  $(document).on('change', '.category', function() {
    let rentalrateid  = $(this).val();
    let target        = $(this).data('target');
    console.log(rentalrateid);
    if (rentalrateid) {
      $.ajax({
        type: "GET",
        url: "/admin-sukajadi/json-get-category?rentalrateid=" + rentalrateid,
        dataType: 'JSON',
        success: function(res) {
          if (res) {
            $("#show-category" + target).empty();
            $("#show-category" + target).append('<option value="">-- Pilih Kategori --</option>');
            $.each(res, function(price_ctg, price_ctg) {
              if (price_ctg == null)
              {
                $("#show-category" + target).append(
                  '<option value="null"> - </option>'
                );
              }else{
                $("#show-category" + target).append(
                  '<option value="' + price_ctg + '">' + price_ctg + '</option>'
                );
              }
            });
          } else {
            $("#show-category" + target).empty();
          }
        }
      });
    } else {
      $("#show-category" + target).empty();
    }

  });

  // Menampilkan harga tarif sewa
  $(document).on('change', '.price', function() {
    ++i;
    let target        = $(this).data('target');
    let roomid        = $('#roomid' + target).val();
    let rentalrateid  = $('#rentalrateid' + target).val();
    let category      = $(this).val();
    console.log(roomid);
    if (category) {
      $.ajax({
        type: "GET",
        url: "/admin-sukajadi/json-get-price?roomid=" + roomid,
        data: {
          "rentalrateid": rentalrateid,
          "categoryid"  : category
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
  $(function () {
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
          let optRoom       = "";
          let optRentalRate = "";
          let optCategory   = "";

          $.each(res.room, function(index, value) {
            optRoom       += '<option value=' + value.id_room + '>' + value.room_name + '</option>'
          });
          $.each(res.price, function(index, value) {
            optRentalRate       += '<option value=' + value.rental_rate_ctg + '>' + value.rental_rate_ctg + '</option>'
          });
          $.each(res.price_ctg, function(index, value) {
            if (value.price_ctg == null) {
              optCategory       += '<option value="">-</option>'
            }else{
              optCategory       += '<option value=' + value.price_ctg + '>' + value.price_ctg + '</option>'
            }
          });

          $(".section-more-room").append(
            '<div class="more-room">' +
              '<div class="form-group row">' +
                '<div class="col-md-12">' +
                  '<hr>' +
                '</div>' +
                '<div class="col-md-12">' +
                  '<div class="float-left">' +
                    '<label class="col-sm-12 col-form-label">Reservasi Kamar ['+num+']</label>' +
                  '</div>' +
                  '<div class="float-right">' +
                    '<a id="remove-more-room" class="btn btn-outline-danger btn-block btn-sm mt-1" onclick="return confirm(Buat Reservasi ?  )"><i class="fas fa-times-circle">  </i> Batal' +
                    '</a>' +
                  '</div>' +
                '</div>' +
                '<div class="col-md-12">' +
                  '<hr>' +
                '</div>' +
              '</div>' +
              '<div class="form-group row">' +
                '<label class="col-sm-2 col-form-label">Tanggal Check In</label>' +
                '<div class="col-sm-4">' +
                  '<input type="date" class="form-control" name="checkin['+i+']" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}" min="<?= date('Y-m-d'); ?>">' +
                '</div>' +
                '<label class="col-sm-2 col-form-label">Tanggal Check Out</label>' +
                '<div class="col-sm-4">' +
                  '<input type="date" class="form-control" name="checkout['+i+']" value="{{ \Carbon\Carbon::tomorrow()->isoFormat('Y-MM-DD') }}" min="<?= date('Y-m-d'); ?>" >' +
                '</div>' +
              '</div>' +
              '<div class="form-group row">' +
                '<label class="col-sm-2 col-form-label">Kamar</label>' +
                '<div class="col-sm-4">' +
                  '<select class="form-control data-room" id="roomid'+i+'" name="room_id['+i+']">' +
                    '<option value="">-- Pilih Kamar --</option>' +
                    optRoom +
                  '</select>' +
                '</div>' +
                '<label class="col-sm-2 col-form-label">Tarif Sewa</label>' +
                '<div class="col-sm-4">' +
                  '<select class="form-control category" data-target="'+i+'" id="rentalrateid'+i+'">' +
                    '<option value="">-- Pilih Tarif Sewa --</option>' +
                    optRentalRate +
                  '</select>' +
                '</div>' +
              '</div>' +
              '<div class="form-group row">' +
                '<label class="col-sm-2 col-form-label">Kategori</label>' +
                '<div class="col-sm-4">' +
                '<select class="form-control price" data-target="'+i+'" id="show-category'+i+'">' +
                  '<option value="">-- Pilih Kategori --</option>' +
                  optCategory +
                '</select>' +
              '</div>' +
              '<label class="col-sm-2 col-form-label">Harga (Rp)</label>' +
              '<div class="col-sm-4">' +
                '<input type="hidden" id="id-room'+i+'" name="rental_rate_id['+i+']">' +
                '<input type="text" id="price-room'+i+'" name="price['+i+']" class="form-control" readonly>' +
              '</div>' +
            '</div>'
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
