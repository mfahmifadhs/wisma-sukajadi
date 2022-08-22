@extends('v_admin_sukajadi.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Setor PNBP</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/pendapatan') }}">Pendapatan</a></li>
          <li class="breadcrumb-item active">Setor PNBPB</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
   <div class="card card-primary card-outline" style="margin-left: 10%;margin-right: 10%;">
    <!-- /.card-header -->
    <form action="{{ url('admin-sukajadi/pnbp/setor-pnbp') }}" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id_pnbp" value="{{ $pnbp->id_pnbp }}">
      <input type="hidden" name="pnbp_total_room" value="{{ $pnbp->pnbp_total_room }}">
      <input type="hidden" name="pnbp_total_income" value="{{ $pnbp->pnbp_total_income }}">
      <input type="hidden" name="pnbp_date" value="{{ $pnbp->pnbp_date }}">
      @csrf
      <div class="card-body">
        <div class="form-group row">
          <label class="col-sm-12 col-form-label text-center">Setor Penerimaan Negara Bukan Pajak (pnbp) <hr></label>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Periode Hari</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($pnbp->pnbp_date)->isoFormat('DD MMMM Y') }}" readonly>
          </div>
          <label class="col-sm-2 col-form-label">Total Pembayaran</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" value="Rp {{ number_format($pnbp->pnbp_total_income, 0, ',', '.') }}" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Tanggal Transaksi</label>
          <div class="col-sm-4">
            <input type="date" class="form-control" name="date" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}" 
            min="<?= date('Y-m-d'); ?>">
          </div>
          <label class="col-sm-2 col-form-label">Jam</label>
          <div class="col-sm-4">
            <input class="form-control" name="time" value="{{ \Carbon\Carbon::now()->isoFormat('Hh:mm') }}">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Kode Transaksi</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="transaction_num" placeholder="Kode transaksi pembayaran">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Bukti Pembayaran</label>
          <div class="col-sm-10">
            <div class="btn btn-default btn-file">
              <i class="fas fa-paperclip"></i> Upload Bukti Pembayaran
              <input type="file" name="transaction_img" class="image-receipt">
              <img id="preview-image-receipt" style="max-height: 80px;">
            </div><br>
            <span class="help-block" style="font-size: 12px;">Max. 5MB</span>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Keterangan</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="pnbp_note" rows="4"></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label"></label>
          <div class="col-sm-10">
            <button type="text" class="btn btn-primary" onclick="return confirm('Tambah setoran pnbp ?')">Submit</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
</section>

@section('js')
<!-- Lainya -->
<script>

  $(function () {
    $('[name="time"]').datetimepicker({
      format:'HH:mm'
    });
  });

  // Upload Foto
  $('.image-receipt').change(function(){
    let reader = new FileReader();
    reader.onload = (e) => { 
      $('#preview-image-receipt').attr('src', e.target.result); 
    }    
    reader.readAsDataURL(this.files[0]); 
  });
  
</script>
@endsection

@endsection