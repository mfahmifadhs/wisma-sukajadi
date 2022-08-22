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
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/reservasi/daftar') }}">Reservasi</a></li>
          <li class="breadcrumb-item active">Detail Reservasi</li>
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
      <div class="col-md-3 text-capitalize">
        <div class="row">
          <div class="col-md-12 form-group">
            <!-- Informasi Pengunjung -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Informasi Pengunjung</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="img-fluid img-thumbnail" src="{{ asset('images/admin/pengunjung/'. $reservasi->identity_img) }}" alt="Foto KTP">
                </div>
                <h3 class="profile-username text-center">{{ $reservasi->visitor_name }}</h3>
                <p class="text-muted text-center">{{ $reservasi->identity_num }}</p>
                <hr>
                <strong><i class="fas fa-calendar mr-1"></i> Tanggal Lahir</strong>
                <p class="text-muted">{{ \Carbon\Carbon::parse($reservasi->visitor_birthdate)->isoFormat('DD MMMM Y') }}</p>
                <hr>
                <strong><i class="fas fa-phone mr-1"></i> No. Handphone</strong>
                <p class="text-muted">{{ $reservasi->visitor_phone_number }}</p>
                <hr>
                <strong><i class="fas fa-building mr-1"></i> Instansi</strong>
                <p class="text-muted">{{ $reservasi->visitor_instance }}</p>
                <hr>
                <strong><i class="fas fa-address-card mr-1"></i> Keterangan Pengunjung</strong>
                <p class="text-muted">{{ $reservasi->visitor_description }}</p>
                <hr>
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                <p class="text-muted">{{ $reservasi->visitor_address }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-12 form-group">
            <!-- Informasi Harga -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Informasi Pembayaran</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body box-profile">
                <div class="row">
                  @foreach($detail as $reservationDetail)
                  <div class="col-md-12">
                    <span class="float-left">
                      <h6 style="font-size: 13px;"><b>{{ $reservationDetail->room_name }}</b></h6>
                    </span>
                    <span class="float-right">
                      <h6 style="font-size: 12px;">{{ $reservationDetail->duration }} malam</h6>
                    </span>
                  </div>
                  <div class="col-md-12">
                    <span class="float-left">
                      <h6 style="font-size: 12px;"> Rp {{ number_format($reservationDetail->price, 0, ',', '.') }} / malam</h6>
                    </span>
                    <span class="float-right">
                      <h6 style="font-size: 13px;"> Rp {{ number_format($reservationDetail->detail_reservation_price, 0, ',', '.') }}</h6>
                    </span>
                    <hr class="mt-4">
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          @if($reservasi->assignment_letter != null)
          <div class="col-md-12 form-group">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Surat Tugas</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-default btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="img-fluid img-thumbnail" src="{{ asset('images/admin/surat-tugas/'. $reservasi->assignment_letter) }}" alt="Foto KTP">
                </div>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
      <div class="col-md-9">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <span class="float-left"><h3 class="card-title">Informasi Reservasi</h3></span>
            <span class="float-right">
              @if($reservasi->status_reservation == 'payment')
                <a class="btn btn-warning btn-xs font-weight-bold disabled text-uppercase">Payment</a>
              @elseif($reservasi->status_reservation == 'reserved')
                <a class="btn btn-warning btn-xs font-weight-bold disabled text-uppercase">Reserved</a>
              @elseif($reservasi->status_reservation == 'checkin')
                <a class="btn btn-success btn-xs font-weight-bold disabled text-uppercase">Check In</a>
              @elseif($reservasi->status_reservation == 'checkout')
                <a class="btn btn-danger btn-xs font-weight-bold disabled text-uppercase">Check Out</a>
              @endif
            </span>
          </div>
          <!-- /.card-header -->
          <form action="{{ url('admin-sukajadi/reservasi/proses-pembayaran/'. $reservasi->id_reservation) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="form-group row">
                <label class="col-sm-12 col-form-label text-center">Pembayaran <hr></label>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                  <select class="form-control" name="status_reservation" readonly>
                    <option value="reservation">{{ $reservasi->status_reservation }}</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Kode Biling</label>
                <div class="col-sm-10">
                  @if($reservasi->payment_status == 'belum bayar')
                  <input type="text" class="form-control" name="billing_code" placeholder="diisi setelah pengunjung melakukan pembayaran" required>
                  @else
                  <input type="text" class="form-control" name="billing_code" value="{{ $reservasi->billing_code }}" readonly>
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Bukti Pembayaran</label>
                <div class="col-sm-8">
                  <div class="btn btn-default btn-file">
                    <i class="fas fa-paperclip"></i> Upload Bukti Pembayaran
                    @if($reservasi->payment_status == 'belum bayar')
                    <input type="file" name="payment_img" class="image-payment">
                    <img id="preview-image-payment" style="max-height: 80px;">
                    @else
                    <input type="file" name="payment_img" class="image-payment" disabled>
                    <img id="preview-image-payment" src="{{ asset('images/admin/bukti-pembayaran/'. $reservasi->payment_img) }}" style="max-height: 80px;">
                    @endif
                  </div>
                  <p class="help-block" style="font-size: 12px;">Max. 5MB</p>
                </div>
              </div>
              <?php 
                $i = 1; //Nomor
              ?>
              <div class="detail">
                @foreach($detail as $x => $details)
                <input type="hidden" name="duration[{{ $x }}]" value="{{ $details->duration }}">
                <input type="hidden" name="res_detail_id[{{ $x }}]" value="{{ $details->id_detail_reservation }}">
                <div class="form-group row">
                  <label class="col-sm-12 col-form-label text-center"><hr>[{{ $i++ }}] Jadwal Reservasi <hr></label>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tanggal Check In</label>
                  <div class="col-sm-4">
                    <input type="date" class="form-control" name="checkin[{{ $x }}]" 
                    value="{{ \Carbon\Carbon::parse($details->check_in)->isoFormat('Y-MM-DD') }}" readonly>
                  </div>
                  <label class="col-sm-2 col-form-label">Tanggal Check Out</label>
                  <div class="col-sm-4">
                    <input type="date" class="form-control" name="checkout[{{ $x }}]" 
                    value="{{ \Carbon\Carbon::parse($details->check_out)->isoFormat('Y-MM-DD') }}" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Kamar</label>
                  <div class="col-sm-4">
                    @if($reservasi->payment_status == 'belum bayar')
                    <select class="form-control price" id="roomid{{ $x }}" name="room_id[{{ $x }}]" data-target="{{ $x }}">
                     @foreach ($room as $rooms)
                        <option value="{{ $rooms->id_room }}" {{ ( $rooms->id_room == $details->id_room) ? 'selected' : '' }}> 
                         {{ $rooms->room_name }} 
                       </option>
                     @endforeach
                    </select>
                    @else
                    <select class="form-control price" id="roomid{{ $x }}" name="room_id[{{ $x }}]" data-target="{{ $x }}" readonly>
                      <option>{{ $details->room_name }} </option>
                    </select>
                    @endif
                  </div>
                  <label class="col-sm-2 col-form-label">Tarif Sewa</label>
                  <div class="col-sm-4">
                    <select class="form-control category" id="rentalrateid{{ $x }}" readonly>
                      @foreach ($price as $prices)
                        <option value="{{ $prices->rental_rate_ctg }}" {{ ( $prices->rental_rate_ctg == $details->rental_rate_ctg) ? 'selected' : '' }}>
                          {{ $prices->rental_rate_ctg }} 
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Kategori</label>
                  <div class="col-sm-4">
                    <select class="form-control category" id="show-category{{ $x }}" readonly>
                       @foreach ($price_ctg as $prices_ctg)
                        @if($prices_ctg->price_ctg == null)
                        <option value="">-</option>
                        @else
                        <option value="{{ $prices_ctg->price_ctg }}" {{ ( $prices_ctg->price_ctg == $details->price_ctg) ? 'selected' : '' }}> 
                          {{ $prices_ctg->price_ctg }} 
                        </option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                  <label class="col-sm-2 col-form-label">Harga (Rp)</label>
                  <div class="col-sm-4">
                    <input type="hidden" name="old_rental_rate_id[{{ $x }}]" value="{{ $details->rental_rate_id }}">
                    <input type="hidden" name="old_price[{{ $x }}]" value="{{ $details->price }}">
                    <input type="hidden" id="id-room{{ $x }}" name="new_rental_rate_id[{{ $x }}]">
                    <input type="text" class="form-control" id="price-room{{ $x }}" name="new_price[{{ $x }}]" placeholder="{{ $details->price }}" readonly>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              @if($reservasi->payment_status == 'belum bayar')
              <div class="float-right">
                <button type="submit" class="btn btn-primary" onclick="return confirm('Tambah pembayaran ?')">
                  <i class="far fa-envelope"></i> Simpan Pembayaran</button>
              </div>
              <div class="float-left">
                <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Batal</button>
              </div>
              @else
              <div class="float-left">
                <a href="{{ url('admin-sukajadi/reservasi/daftar') }}" type="reset" class="btn btn-default">
                  <i class="fas fa-arrow-circle-left"></i> Kembali
                </a>
              </div>
              @endif
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
    console.log(rentalrateid);
    if (rentalrateid) {
      $.ajax({
        type: "GET",
        url: "/admin-sukajadi/json-get-category?rentalrateid=" + rentalrateid,
        dataType: 'JSON',
        success: function(res) {
          if (res) {
            $("#show-category").empty();
            $("#show-category").append('<option value="">-- Pilih Kategori --</option>');
            $.each(res, function(price_ctg, price_ctg) {
              if (price_ctg == null) 
              {
                $("#show-category").append(
                  '<option value="null"> - </option>'
                );
              }else{
                $("#show-category").append(
                  '<option value="' + price_ctg + '">' + price_ctg + '</option>'
                );
              }
            });
          } else {
            $("#show-category").empty();
          }
        }
      });
    } else {
      $("#show-category").empty();
    }

  });
  
  // Menampilkan harga tarif sewa
  $(document).on('change', '.price', function() {
    i++;
    let target        = $(this).data('target');
    let roomid        = $('#roomid'+target).val();
    let rentalrateid  = $('#rentalrateid'+target).val();
    let checkcategory = $('#show-category'+target).val();
    let category      = '';

    if (checkcategory == '') { category = 'null'}else{ category = $('#show-category'+target).val() }
    console.log(category);
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
          console.log(res);
          if (res) {
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

@endsection

@endsection