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
                    <li class="breadcrumb-item">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

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
                        <h3 class="card-title">Detail Reservasi</h3>
                    </div>
                    <div class="card-header">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                                        @foreach ($status as $row)
                                        <div class="timeline-step">
                                            <div class="timeline-content">
                                                @if ($row->id_status == $reservasi->status_reservasi)
                                                <i class="fas fa-dot-circle fa-2x text-danger"></i>
                                                @elseif ($reservasi->status_reservasi > $row->id_status)
                                                <i class="fas fa-dot-circle fa-2x text-primary"></i>
                                                @elseif ($reservasi->status_reservasi < $row->id_status)
                                                <i class="fas fa-dot-circle fa-2x text-secondary"></i>
                                                @endif

                                                <p class="h6 text-muted mb-0 mb-lg-0 mt-2">{{ $row->nama_status }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-form-label col-md-12">Informasi Pengunjung</label>
                                    <div class="col-md-3">Order ID</div>:
                                    <div class="col-md-8">{{ $reservasi->pengunjung->id_pengunjung }}</div>
                                    <div class="col-md-3">NIK</div>:
                                    <div class="col-md-8">{{ $reservasi->pengunjung->nik }}</div>
                                    <div class="col-md-3">Nama</div>:
                                    <div class="col-md-8">{{ $reservasi->pengunjung->nama_pengunjung }}</div>
                                    <div class="col-md-3">Tgl. Lahir</div>:
                                    <div class="col-md-8">{{ $reservasi->pengunjung->tanggal_lahir }}</div>
                                    <div class="col-md-3">No. HP</div>:
                                    <div class="col-md-8">{{ $reservasi->pengunjung->no_hp }}</div>
                                    <div class="col-md-3">Instansi</div>:
                                    <div class="col-md-8 text-capitalize">{{ $reservasi->pengunjung->instansi }}</div>
                                    <div class="col-md-3">{{ $reservasi->pengunjung->instansi == 'kemenkes' ? 'Jabatan' : 'Asal' }}</div>:
                                    <div class="col-md-8">{{ $reservasi->pengunjung->keterangan }}</div>
                                    @if ($reservasi->pengunjung->instansi == 'kemenkes')
                                    <div class="col-sm-3">Unit Kerja</div>:
                                    <div class="col-md-8">{{ $reservasi->pengunjung->unitKerja->nama_unit_kerja }}</div>
                                    @endif
                                    <div class="col-md-3">Foto KTP</div>:
                                    <div class="col-md-4">
                                        @if ($reservasi->pengunjung->foto_ktp)
                                        <a type="button" class="btn btn-default btn-sm" data-toggle="modal" onclick="showModalKtp('{{ $reservasi->id_reservasi }}')">
                                            <img src="{{ asset('storage/files/foto_ktp/'. Crypt::decrypt($reservasi->pengunjung->foto_ktp)) }}" alt="Foto KTP" class="img-fluid">
                                        </a>
                                        @else Belum ada @endif
                                    </div>
                                </div>
                            </div>
                            @if ($reservasi->kode_biling)
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-form-label col-md-12">Informasi Pengunjung</label>
                                    <div class="col-md-6">Tanggal Pembayaran</div>
                                    <div class="col-md-6">Kode Biling</div>
                                    <div class="col-md-6">
                                        {{ \Carbon\Carbon::parse($reservasi->tanggal_pembayaran)->isoFormat('DD MMMM Y') }}
                                    </div>
                                    <div class="col-md-6">{{ $reservasi->kode_biling }}</div>
                                    <div class="col-md-12 mt-3">Bukti Pembayaran</div>
                                    <div class="col-md-6">
                                        @if ($reservasi->bukti_pembayaran)
                                        <a type="button" class="btn btn-default btn-sm" data-toggle="modal" onclick="showModalBayar('{{ $reservasi->id_reservasi }}')">
                                            <img src="{{ asset('storage/files/bukti_pembayaran/'. Crypt::decrypt($reservasi->bukti_pembayaran)) }}" alt="Bukti Bayar" class="img-fluid">
                                        </a>
                                        @else Belum ada @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($reservasi->detail->count() != 0)
                            <div class="col-md-12 mt-4">
                                <label class="col-form-label">Informasi Kamar</label>
                                <table id="table-show" class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kamar</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Durasi</th>
                                            <th>Tarif Sewa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservasi->detail as $i => $row)
                                        @php $durasi = \Carbon\Carbon::parse($row->tanggal_check_in)->diffInDays(\Carbon\Carbon::parse($row->tanggal_check_out)); @endphp
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $row->tarif->kamar->nama_kamar }}</td>
                                            <td>{{ \Carbon\Carbon::parse($row->tanggal_check_in)->isoFormat('DD/MM/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($row->tanggal_check_out)->isoFormat('DD/MM/Y') }}</td>
                                            <td>{{ $durasi }} Malam</td>
                                            <td>Rp {{ number_format($row->total_harga) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        @if ($reservasi->status_reservasi == 14)
                        <a href="{{ route('reservasi.kwitansi', $reservasi->id_reservasi) }}" class="btn btn-danger btn-sm" target="_blank">
                            <i class="fas fa-print"></i> Cetak Kwitansi
                        </a>
                        @endif
                        @if (Auth::user()->role_id == 4)
                        <a href="{{ route('reservasi.edit', $reservasi->id_reservasi) }}" class="btn btn-success btn-sm font-weight-bold">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="ktp-{{ $reservasi->id_reservasi }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto KTP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($reservasi->pengunjung->foto_ktp)
                <img src="{{ asset('storage/files/foto_ktp/'. Crypt::decrypt($reservasi->pengunjung->foto_ktp)) }}" alt="Foto KTP" class="img-fluid">
                @else Belum ada @endif
            </div>
        </div>
    </div>
</div>
<!-- Bukti Bayar -->
<div class="modal fade" id="pembayaran-{{ $reservasi->id_reservasi }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($reservasi->bukti_pembayaran)
                <img src="{{ asset('storage/files/bukti_pembayaran/'. Crypt::decrypt($reservasi->bukti_pembayaran)) }}" alt="Bukti Bayar" class="img-fluid">
                @else Belum ada @endif
            </div>
        </div>
    </div>
</div>

<!-- Kwitansi -->
<div class="modal fade" id="kwitansi-{{ $reservasi->id_reservasi }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kwitansi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="invoice p-3">
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <img src="{{ asset('images/admin/logo-kemenkes-icon.png') }}" width="50" style="margin-top: -8px;">
                                Wisma Sukajadi Bandung
                                <small class="float-right mt-3">
                                    {{ \Carbon\Carbon::parse($reservasi->created_at)->isoFormat('DD MMMM Y') }}
                                </small>
                            </h4>
                        </div>
                    </div>

                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>Wisma Sukajadi Bandung</strong><br>
                                Jl. Sukajadi No.155, Cipedes, <br>
                                Kec. Sukajadi, Kota Bandung. <br>
                                Telp: (022) 2031152
                            </address>
                        </div>

                        <div class="col-sm-4 invoice-col">
                            To
                            <address class="text-capitalize">
                                <strong>{{ $reservasi->pengunjung->nama_pengunjung }}</strong><br>
                                {{ $reservasi->pengunjung->instansi }} <br>
                                Telp : {{ $reservasi->pengunjung->no_hp }}
                            </address>
                        </div>

                        <div class="col-sm-4 invoice-col">
                            <b>Kwitansi #{{ $reservasi->id_reservasi }}</b><br>
                            <br>
                            <b>Kode Biling:</b> {{ $reservasi->kode_bilindg }}<br>
                            <b>Tanggal:</b> {{ \Carbon\Carbon::parse($reservasi->created_at)->isoFormat('DD/MM/Y') }}<br>
                        </div>
                    </div>

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kamar</th>
                                        <th>Harga / Malam</th>
                                        <th>Check In - Check Out</th>
                                        <th>Waktu Menginap</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <?php $no = 1; ?>
                                <tbody>
                                    @foreach($reservasi->detail as $subRow)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $subRow->tarif->kamar->nama_kamar }}</td>
                                        <td>Rp {{ number_format($subRow->tarif->harga_sewa, 0, ',', '.') }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($subRow->tanggal_check_in)->isoFormat('DD/MM/YY') }}
                                            - {{ \Carbon\Carbon::parse($subRow->tanggal_check_out)->isoFormat('DD/MM/YY') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($subRow->tanggal_check_in)->diffInDays(\Carbon\Carbon::parse($subRow->tanggal_check_out)) }} malam</td>
                                        <td>Rp {{ number_format($subRow->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <p class="lead">Metode Pembayaran</p>
                            <img src="https://1.bp.blogspot.com/-GjCpjdW8Hrs/XkXUvE0RseI/AAAAAAAABmk/u5e1zr7RGHQN2TFwPu1IoN8QJBtwXLH5QCLcBGAsYHQ/s400/Logo%2BLink%2BAja%2521.png" alt="Mandiri" width="60">
                            <img src="https://cdn0-production-images-kly.akamaized.net/Z409KTEnMYWz7Ntw4JwR5ipVKZg=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/2264120/original/063927100_1530333288-20170926171133-6-ilustrasi-atm-bersama-001-magang.jpg" alt="BNI" width="70">

                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                Rekening yang benar hanya atas nama Wisma Sukajadi Kemenkes RI.
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Jumlah Kamar :</th>
                                        <td>{{ $reservasi->detail->count() }} kamar</td>
                                    </tr>
                                    <tr>
                                        <th>Pajak (%)</th>
                                        <td>Rp 0</td>
                                    </tr>
                                    <tr>
                                        <th class="font-weight-bold">Total Pembayaran:</th>
                                        <td>Rp {{ number_format($reservasi->total_pembayaran, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    function showModalKtp(id) {
        var modal_target = "#ktp-" + id;
        $(modal_target).modal('show');
    }

    function showModalBayar(id) {
        var modal_target = "#pembayaran-" + id;
        $(modal_target).modal('show');
    }

    function showDetail(id) {
        var modal_target = "#detail-" + id;
        $(modal_target).modal('show');
    }

    function showKwitansi(id) {
        var modal_target = "#kwitansi-" + id;
        $(modal_target).modal('show');
    }

    $(function() {
        $("#table-show").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": false,
            "paging": false,
            "searching": false
        }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)')
    })
</script>
@endsection

@endsection
