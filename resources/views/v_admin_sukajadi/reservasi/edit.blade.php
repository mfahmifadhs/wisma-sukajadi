@extends('v_admin_sukajadi.layout.app')

@section('content')

<sect class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>Reservasi</b></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin-sukajadi/reservasi/daftar') }}">Reservasi</a></li>
                    <li class="breadcrumb-item active">Buat Reservasi</li>
                </ol>
            </div>
        </div>
    </div>
</sect>

<section class="content">
    <div class="container">
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
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Buat Reservasi</h3>
            </div>
            <form action="{{ url('admin-sukajadi/reservasi/update/'. $rsv->id_reservation) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_visitor" value="{{ $rsv->visitor_id }}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label text-center">Informasi Pengunjung
                            <hr>
                        </label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="identity_num" value="{{ $rsv->visitor->identity_num }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Foto KTP</label>
                        <div class="col-sm-8">
                            <div class="btn btn-default btn-file">
                                <i class="fas fa-paperclip"></i> Upload Foto KTP
                                <input type="file" name="identity_img" class="image-ktp">
                                <img id="preview-image-ktp" style="max-height: 80px;" src="{{ asset('images/admin/pengunjung/'. $rsv->visitor->identity_img )}}">
                            </div><br>
                            @if ($rsv->visitor->identity_img)
                            <a href="{{ url('admin-sukajadi/reservasi/delete-file-identity/'. $rsv->id_reservation) }}" class="btn btn-danger btn-xs" onclick="return confirm('Hapus file?')">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endif
                            <span class="help-block" style="font-size: 12px;">
                                Format JPG/JPEG/PNG Max. 5MB
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="visitor_name" value="{{ $rsv->visitor->visitor_name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="visitor_birthdate" value="{{ \Carbon\carbon::parse($rsv->visitor->visitor_birthdate)->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">No. Hp</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="visitor_phone_number" value="{{ $rsv->visitor->visitor_phone_number }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="visitor_address">{{ $rsv->visitor->visitor_address }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Asal Instansi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="visitor_instance" value="{{ $rsv->visitor->visitor_instance }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" name="visitor_description">{{ $rsv->visitor->visitor_description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Surat Tugas</label>
                        <div class="col-sm-8">
                            <div class="btn btn-default btn-file">
                                <i class="fas fa-paperclip"></i> Upload Surat Tugas
                                <input type="file" name="assignment_letter" class="image-assignment-letter">
                                <img id="preview-image-assignment-letter" style="max-height: 80px;" src="{{ asset('images/admin/surat-tugas/'. $rsv->assignment_letter )}}">
                            </div>
                            <br>
                            @if ($rsv->assignment_letter)
                            <a href="{{ url('admin-sukajadi/reservasi/delete-file-letter/'. $rsv->id_reservation) }}" class="btn btn-danger btn-xs" onclick="return confirm('Hapus file?')">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endif
                            <span class="help-block" style="font-size: 12px;">
                                Format PDF/JPG/JPEG/PNG (Max. 5MB)
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Simpan Perubahan ?')">
                            <i class="fas fa-save"></i> Simpan</button>
                    </div>
                    <!-- <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Batal</button> -->
                </div>
            </form>
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


@endsection

@endsection
