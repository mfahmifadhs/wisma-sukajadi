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
                type: "POST",
                url: "/kamar/select",
                data: {
                    "data": dataKamar
                },
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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
