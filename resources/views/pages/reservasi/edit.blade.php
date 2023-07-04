@extends('layout.app')

@section('content')

<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">WISMA SUKAJADI</h1>
                <h5>Wisma Kemenkes Sukajadi Bandung</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reservasi.show') }}">Daftar Reservasi</a></li>
                    <li class="breadcrumb-item">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container">
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
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Buat Reservasi</h3>
                    </div>
                    <form action="{{ route('reservasi.update', $reservasi->id_reservasi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <label class="col-form-label">Alur Reservasi</label>
                            <p class="card-text">
                                Pengisian Informasi Pengunjung <i class="fas fa-chevron-right"></i>
                                Pemilihan Kamar <i class="fas fa-chevron-right"></i>
                                Pembayaran (Sesuai Kode Biling) <i class="fas fa-chevron-right"></i>
                                Check In <i class="fas fa-chevron-right"></i>
                                Check Out <i class="fas fa-chevron-right"></i>
                                Check Out
                            </p>
                        </div>
                        <!-- Informasi Pengunjung -->
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Asal Instansi</label>
                                <div class="col-sm-10 mt-2">
                                    <span class="mr-4">
                                        <input type="radio" name="instansi" value="kemenkes" <?php echo $reservasi->pengunjung->instansi == 'kemenkes' ? 'checked' : 'disabled'; ?>> Kemenkes
                                    </span>
                                    <span class="mr-3">
                                        <input type="radio" name="instansi" value="umum" <?php echo $reservasi->pengunjung->instansi == 'umum' ? 'checked' : 'disabled'; ?>> Luar Kemenkes
                                    </span>
                                </div>
                            </div>
                            @if ($reservasi->pengunjung->instansi == 'kemenkes')
                            <div class="form-group row kemenkes">
                                <label class="col-md-2 col-form-label">Unit Kerja*</label>
                                <div class="col-md-10">
                                    <select name="unit_kerja_id" class="form-control text-uppercase">
                                        <option value="{{ $reservasi->pengunjung->unit_kerja_id }}">
                                            {{ $reservasi->pengunjung->unitKerja->nama_unit_kerja }}
                                        </option>
                                        @foreach ($unitKerja->where('id_unit_kerja', '!=', $reservasi->pengunjung->unit_kerja_id) as $row)
                                        <option value="{{ $row->id_unit_kerja }}">{{ strtoupper($row->nama_unit_kerja) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label mt-3">Jabatan</label>
                                <div class="col-sm-10 mt-3">
                                    <select name="jabatan" class="form-control" required>
                                        <option value="Staff" <?php echo $reservasi->pengunjung->keterangan ==  'Staff' ? 'selected' : ''; ?>>Staff</option>
                                        <option value="Eselon I" <?php echo $reservasi->pengunjung->keterangan ==  'Eselon I' ? 'selected' : ''; ?>>Eselon I</option>
                                        <option value="Eselon II" <?php echo $reservasi->pengunjung->keterangan ==  'Eselon II' ? 'selected' : ''; ?>>Eselon II</option>
                                        <option value="Eselon III" <?php echo $reservasi->pengunjung->keterangan ==  'Eselon III' ? 'selected' : ''; ?>>Eselon III</option>
                                        <option value="Eselon IV" <?php echo $reservasi->pengunjung->keterangan ==  'Eselon IV' ? 'selected' : ''; ?>>Eselon IV</option>
                                        <option value="Eselon V" <?php echo $reservasi->pengunjung->keterangan ==  'Eselon V' ? 'selected' : ''; ?>>Eselon V</option>
                                        <option value="Lainnya" <?php echo $reservasi->pengunjung->keterangan ==  'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label mt-3">Surat Tugas</label>
                                <div class="col-sm-8 mt-3">
                                    <div class="btn btn-default btn-file">
                                        <i class="fas fa-paperclip"></i> Upload Surat Tugas
                                        <input type="file" name="surat_tugas" class="image-assignment-letter">
                                        @php
                                        $src = $reservasi->surat_tugas ?
                                        asset('storage/files/surat_tugas/'. Crypt::decrypt($reservasi->surat_tugas)) : '';
                                        @endphp
                                        <img id="preview-image-assignment-letter" src="{{ $src }}" style="max-height: 80px;">
                                    </div><br>
                                    <span class="help-block" style="font-size: 12px;">Format PDF (Max. 5MB)</span>
                                </div>
                            </div>
                            @else
                            <div class="form-group row umum">
                                <label class="col-sm-2 col-form-label">Nama Instansi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="keterangan" placeholder="Umum/Asal Sekolah/Asal Instansi" value="{{ $reservasi->pengunjung->keterangan }}">
                                </div>
                            </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Foto KTP</label>
                                <div class="col-sm-8">
                                    <div class="btn btn-default btn-file">
                                        <i class="fas fa-paperclip"></i> Upload Foto KTP
                                        <input type="file" name="foto_ktp" class="image-ktp">
                                        @php
                                        $src = $reservasi->pengunjung->foto_ktp ?
                                        asset('storage/files/foto_ktp/'. Crypt::decrypt($reservasi->pengunjung->foto_ktp)) : '';
                                        @endphp
                                        <img id="preview-image-ktp" src="{{ $src }}" style="max-height: 80px;">
                                    </div><br>
                                    <span class="help-block" style="font-size: 12px;">Max. 5MB</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">NIK</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="nik" placeholder="nomor induk kependudukan (NIK)" value="{{ $reservasi->pengunjung->nik }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_pengunjung" placeholder="nama lengkap pengunjung" value="{{ $reservasi->pengunjung->nama_pengunjung }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="tanggal_lahir" placeholder="nama lengkap pengunjung" value="{{ $reservasi->pengunjung->tanggal_lahir }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">No. Hp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="no_hp" placeholder="nomor handphone aktif" value="{{ $reservasi->pengunjung->no_hp }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="alamat" placeholder="Alamat">{{ $reservasi->pengunjung->alamat }}</textarea>
                                </div>
                            </div>
                        </div>
                        <!-- /Informasi Pengunjung -->

                        <!-- Pemilihan Kamar -->
                        @if ($reservasi->detail->count() != 0)
                        <input type="hidden" value="{{ $status }}" name="status">
                        <input type="hidden" value="{{ $reservasi->id_reservasi }}" name="id_reservasi">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="col-form-label">Pemilihan Kamar</label>
                                    <input type="hidden" name="process" value="pemilihan-kamar">
                                    @foreach ($reservasi->detail as $i => $row)
                                    <div class="form-group row">
                                        <input type="hidden" name="id_detail[]" value="{{ $row->id_detail }}">
                                        <input type="hidden" id="kamar-available" value="{{ json_encode($kamar) }}">
                                        <div class="col-md-12">
                                            <span class="badge badge-danger">
                                                <input type="hidden" name="status_batal[{{ $i }}]" value="false">
                                                <input type="checkbox" name="status_batal[{{ $i }}]" value="true"> Batalkan
                                            </span>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Check In</label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control input-border-bottom" name="check_in[]" value="{{ $row->tanggal_check_in }}" min="<?= date('Y-m-d'); ?>">
                                        </div>
                                        <label class="col-sm-2 col-form-label">Check Out</label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control input-border-bottom" name="check_out[]" value="{{ $row->tanggal_check_out }}" min="<?= date('Y-m-d'); ?>">
                                        </div>
                                        <label class="col-sm-2 col-form-label mt-2">Kamar</label>
                                        <div class="col-sm-4 mt-2">
                                            <select class="form-control select-border-bottom data-kamar" name="kamar_id[]" required>
                                                <option value="">-- Pilih Kamar --</option>
                                                @foreach($kamar as $subRow)
                                                <option value="{{ $subRow->id_kamar }}" <?php echo $subRow->id_kamar == $row->tarif->kamar_id ? 'selected' : ''; ?>>
                                                    {{ $subRow->nama_kamar }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label mt-2">Tarif Sewa</label>
                                        <div class="col-sm-4 mt-2">
                                            <select class="form-control category select-border-bottom text-capitalize" name="tarif[]" required>
                                                <option value="">-- Pilih Tarif Sewa --</option>
                                                @foreach($tarif as $subRow)
                                                <option value="{{ $subRow }}" <?php echo $subRow == $row->tarif->kategori_tamu ? 'selected' : ''; ?>>
                                                    {{ $subRow }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                    <div class="section-kamar"></div>
                                    <div class="form-group row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <a id="tambah-baris" class="btn btn-sm mt-1" disabled>
                                                <i class="fas fa-plus-circle"> </i> Tambah Kamar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- Pemilihan Kamar -->

                        <!-- Pembayaran -->
                        @if ($reservasi->kode_biling)
                        <input type="hidden" value="{{ $status }}" name="status">
                        <input type="hidden" value="{{ $reservasi->id_reservasi }}" name="id_reservasi">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-form-label col-md-12">Informasi Pembayaran</label>
                                        <div class="col-md-12">Kode Biling</div>
                                        <div class="col-md-8 mt-2">
                                            <input type="number" class="form-control input-border-bottom" name="kode_biling" placeholder="Kode Biling dari PNBP" value="{{ $reservasi->kode_biling }}">
                                            <span class="text-danger small">
                                                *Kode biling lama akan hilang.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mt-3">Bukti Pembayaran</div>
                                        <div class="col-md-12 mt-2">
                                            <div class="btn btn-default btn-file">
                                                <i class="fas fa-paperclip"></i> Upload Bukti Pembayaran
                                                <input type="file" name="bukti_bayar" class="image-payment">
                                                @php
                                                $src = $reservasi->bukti_pembayaran ?
                                                asset('storage/files/bukti_pembayaran/'. Crypt::decrypt($reservasi->bukti_pembayaran)) : '';
                                                @endphp
                                                <img id="preview-image-payment" src="{{ $src }}" style="max-height: 80px;">
                                            </div>
                                            <p class="help-block" style="font-size: 12px;">Max. 5MB</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="row">
                                        <div class="col-md-12"></div>
                                        <div class="col-md-12">
                                            @php
                                            $phone = "6285772652563";
                                            $date = \Carbon\carbon::parse($reservasi->created_at)->isoFormat('DD/MM/Y');
                                            $name = ucwords($reservasi->pengunjung->nama_pengunjung);
                                            $room = $reservasi->detail;
                                            $price = number_format($reservasi->total_pembayaran, 0, ',', '.');
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
                            </div>
                        </div>
                        @endif
                        <!-- /Pembayaran -->

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success font-weight-bold" onclick="return confirm('Proses Reservasi?')">
                                <i class="fas fa-check-circle"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $(document).ready(function() {
        var selectedKamar = [];
        // Mengambil daftar kamar yang tersedia dari input tersembunyi
        var kamarAvailable = JSON.parse($('#kamar-available').val());
        $('#tambah-kamar').click(function() {
            // Membuat salinan elemen "kamar-container"
            var newKamarContainer = $('#kamar-container').clone();
            // Menghapus nilai yang dipilih sebelumnya pada elemen "kamar_id[]"
            $('.data-kamar', newKamarContainer).val('');
            // Menghapus opsi kamar yang sudah dipilih dari opsi yang tersedia
            $('.data-kamar option', newKamarContainer).each(function() {
                var kamarId = $(this).val();
                if (selectedKamar.includes(kamarId)) {
                    $(this).remove();
                }
            });
            // Menambahkan elemen "kamar-container" yang baru ke dalam form
            $('#kamar-container').parent().append(newKamarContainer);
            $('#hapus-kamar').removeClass('disabled').prop('disabled', false);
            toggleAddButton();
        });

        // Menangani perubahan pada elemen "kamar_id[]"
        $(document).on('change', '.data-kamar', function() {
            var selectedKamarId = $(this).val();
            // Menambahkan kamar yang dipilih ke dalam daftar selectedKamar
            selectedKamar.push(selectedKamarId);
            // Menghapus opsi kamar yang dipilih dari opsi yang tersedia di elemen "kamar-container" lainnya
            $('.data-kamar').not(this).each(function() {
                $('option[value="' + selectedKamarId + '"]', this).remove();
            });
            toggleAddButton();
        });

        function toggleAddButton() {
            if (selectedKamar.length > 0) {
                $('#tambah-kamar').removeAttr('disabled');
            } else {
                $('#tambah-kamar').attr('disabled', 'disabled');
            }
        }

        // Menambahkan fungsi klik pada tombol "Hapus Container"
        $(document).on('click', '#hapus-kamar', function() {
            var container = $('#kamar-container').last();
            console.log('datas container', container)
            container.remove();
        });
    });

    $(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
        // Preview KTP
        $('.image-ktp').change(function() {
            let reader = new FileReader()
            reader.onload = (e) => {
                $('#preview-image-ktp').attr('src', e.target.result)
            }
            reader.readAsDataURL(this.files[0])
        });
        // Preview Bukti Pembayaran
        $('.image-payment').change(function() {
            let reader = new FileReader()
            reader.onload = (e) => {
                $('#preview-image-payment').attr('src', e.target.result)
            }
            reader.readAsDataURL(this.files[0])
        });
        // Preview Surat Tugas
        $('.image-assignment-letter').change(function() {
            let reader = new FileReader()
            reader.onload = (e) => {
                $('#preview-image-assignment-letter').attr('src', e.target.result)
            }
            reader.readAsDataURL(this.files[0])
        });
        $('input[name="instansi"]').change(function() {
            var selectedValue = $(this).val()
            var instansi = '{{ $reservasi->pengunjung->instansi }}'

            // Menampilkan/menyembunyikan div berdasarkan nilai yang dipilih
            if (selectedValue === 'kemenkes') {
                $('.kemenkes').show()
                $('.umum').hide()
            } else if (selectedValue === 'umum') {
                $('.kemenkes').hide()
                $('.umum').show()
            }
        });
        // Menyimpan data id room / kamar
        let dataKamar = []
        $(document).on('change', '.data-kamar', function() {
            dataKamar = $('.data-kamar').map(function() {
                return this.value
            }).get();
        });
        $("#tambah-baris").click(function() {
            $.ajax({
                type: "GET",
                url: "/kamar/select",
                data: {
                    "data": dataKamar
                },
                dataType: 'JSON',
                success: function(res) {
                    let kamar = "";
                    let tarif = "";
                    let optCategory = "";

                    $.each(res.kamar, function(index, value) {
                        kamar += '<option value=' + value.id_kamar + '>' + value.nama_kamar + '</option>'
                    });
                    $.each(res.tarif, function(index, value) {
                        tarif += '<option value=' + value.kategori_tamu + '>' + value.kategori_tamu + '</option>'
                    });

                    $(".section-kamar").append(
                        `<div class="more">
                                <div class="form-group row">
                                    <input type="hidden" name="id_detail[]" value="null">
                                    <label class="col-sm-2 col-form-label">Check In</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control input-border-bottom" name="check_in[]" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}" min="<?= date('Y-m-d'); ?>">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Check Out</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control input-border-bottom" name="check_out[]" value="{{ \Carbon\Carbon::tomorrow()->isoFormat('Y-MM-DD') }}" min="<?= date('Y-m-d'); ?>">
                                    </div>
                                    <label class="col-sm-2 col-form-label mt-2">Kamar</label>
                                    <div class="col-sm-4 mt-2">
                                        <select class="form-control select-border-bottom data-kamar" name="kamar_id[]" required>
                                            <option value="">-- Pilih Kamar --</option>
                                            ` + kamar + `
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label mt-2">Tarif Sewa</label>
                                    <div class="col-sm-4 mt-2">
                                        <select class="form-control category select-border-bottom text-capitalize" name="tarif[]" required>
                                            <option value="">-- Pilih Tarif Sewa --</option>
                                            ` + tarif + `
                                        </select>
                                    </div>
                                    <div class="col-sm-12 mt-2 text-right">
                                        <a id="hapus-baris" class="btn btn-sm mt-1 hapus-kamar text-danger">
                                            <i class="fas fa-minus-circle"> </i> Hapus Kamar
                                        </a>
                                    </div>
                                </div>
                            </div>`
                    );
                }
            });
            $('#hapus-baris').removeClass('disabled').prop('disabled', false);

        });
        // Menghapus Section
        $(document).on('click', '#hapus-baris', function() {
            $(this).parents('.more').remove();
        });
    })
</script>
@endsection

@endsection
