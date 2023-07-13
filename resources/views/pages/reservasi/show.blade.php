@extends('layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">WISMA SUKAJADI</h1>
                <h5>Wisma Kemenkes Sukajadi Bandung</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-capitalize">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Daftar Reservasi</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container-fluid">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p style="color:white;margin: auto;">{{ $message }}</p>
        </div>
        @endif
        @if ($message = Session::get('failed'))
        <div class="alert alert-danger">
            <p style="color:white;margin: auto;">{{ $message }}</p>
        </div>
        @endif
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Daftar Reservasi</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-header mt-2">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="filter" value="true">
                    <div class="form-group row">
                        <div class="col-5">
                            <select name="bulan" class="form-control form-control-sm">
                                <option value="">Seluruh Bulan</option>
                                @if ($bulanPick)
                                <option value="{{ $bulanPick->first()['id'] }}" selected>{{ $bulanPick->first()['nama_bulan'] }}</option>
                                @endif
                                @foreach ($bulan as $i => $row)
                                <option value="{{ $row['id'] }}">{{ $row['nama_bulan'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-5">
                            <select name="status" class="form-control form-control-sm small">
                                <option value="">Seluruh Status</option>
                                @foreach ($status as $row)
                                <option value="{{ $row->id_status }}" <?php echo !$statusPick ? '' : $row->id_status == $statusPick->id_status ? 'selected' : '' ?>>
                                    {{ $row->nama_status }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-primary btn-sm font-weight-bold btn-block">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                        <div class="col-1">
                            <a href="{{ route('reservasi.show') }}" class="btn btn-danger btn-sm font-weight-bold btn-block">
                                <i class="fas fa-undo"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table id="table-show" class="table table-bordered table-striped" style="font-size: 15px;">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Order ID</th>
                            <th>Pengunjung</th>
                            <th>Keterangan</th>
                            <th>Foto KTP</th>
                            <th>Bukti Bayar</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody class="text-capitalize">
                        @foreach($reservasi as $row)
                        <tr>
                            <td class="pt-3 text-center">{{ $no++ }} </td>
                            <td class="pt-3 text-center">{{ $row->id_reservasi }} </td>
                            <td class="pt-3">
                                {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMMM Y') }} <br>
                                {{ $row->pengunjung->nama_pengunjung.' (0'.$row->pengunjung->no_hp.')' }} <br>
                                {{ $row->pengunjung->instansi }}
                                ({{ $row->pengunjung->instansi == 'kemenkes' ? $row->pengunjung->unitKerja->nama_unit_kerja : $row->pengunjung->keterangan }})
                            </td>
                            <td>
                                Jumlah {{ $row->detail->count().' Kamar' }} (
                                <a type="button" class="text-primary" data-toggle="modal" onclick="showDetail('{{ $row->id_reservasi }}')">Detail</a> ) <br>
                                Total Harga Rp {{ number_format($row->detail->sum('total_harga'), 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @if ($row->pengunjung->foto_ktp)
                                <a type="button" class="btn btn-default btn-sm" data-toggle="modal" onclick="showModalKtp('{{ $row->id_reservasi }}')">Tampilkan</a>
                                @else Belum ada @endif
                            </td>
                            <td class="text-center">
                                @if ($row->bukti_pembayaran)
                                <a type="button" class="btn btn-default btn-sm" data-toggle="modal" onclick="showModalBayar('{{ $row->id_reservasi }}')">Tampilkan</a>
                                @else Belum ada @endif
                            </td>
                            <td class="text-center">
                                <a href="">
                                    <small class="badge badge-primary">
                                        {{ $row->status->nama_status }}
                                    </small>
                                </a>
                            </td>
                            <td class="text-center">
                                <a type="button" class="btn btn-primary btn-sm" data-toggle="dropdown">
                                    <i class="fas fa-bars"></i>
                                </a>
                                <div class="dropdown-menu">
                                    @if ($row->status_reservasi < 14)
                                        <a class="dropdown-item btn btn-sm {{ Auth::user()->role_id != 4 ? 'disabled' : ''  }}" type="button" href="{{ route('reservasi.tambah', $row->id_reservasi) }}">
                                            <i class="fas fa-external-link-square-alt"></i> Proses
                                        </a>
                                        @if ($row->status_reservasi < 14)
                                        <a href="{{ route('reservasi.edit', $row->id_reservasi) }}" class="dropdown-item btn btn-sm" type="button">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        @endif
                                    @elseif ($row->status_reservasi == 14)
                                        <a type="button" class="dropdown-item btn btn-sm" data-toggle="modal" onclick="showKwitansi('{{ $row->id_reservasi }}')">
                                            <i class="fas fa-file"></i> Kwitansi
                                        </a>
                                    @endif
                                    <a href="{{ route('reservasi.detail', $row->id_reservasi) }}" type="button" class="dropdown-item btn btn-sm">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    @if (Auth::user()->role_id == 1)
                                    <a href="{{ route('reservasi.delete', $row->id_reservasi) }}" type="button" class="dropdown-item btn btn-sm" onclick="return confirm('Apakah ingin menghapus reservasi ?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section><br>

<!-- Modal -->
@foreach($reservasi as $row)
<div class="modal fade" id="ktp-{{ $row->id_reservasi }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto KTP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($row->pengunjung->foto_ktp)
                <img src="{{ asset('storage/files/foto_ktp/'. Crypt::decrypt($row->pengunjung->foto_ktp)) }}" alt="Foto KTP" class="img-fluid">
                @else Belum ada @endif
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="pembayaran-{{ $row->id_reservasi }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($row->bukti_pembayaran)
                <img src="{{ asset('storage/files/bukti_pembayaran/'. Crypt::decrypt($row->bukti_pembayaran)) }}" alt="Bukti Bayar" class="img-fluid">
                @else Belum ada @endif
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detail-{{ $row->id_reservasi }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Reservasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table m-0 text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kamar</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Periodisitas</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($row->detail as $i => $subRow)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $subRow->tarif->kamar->nama_kamar }}</td>
                                <td>{{ \Carbon\Carbon::parse($subRow->tanggal_check_in)->isoFormat('DD MMMM Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($subRow->tanggal_check_out)->isoFormat('DD MMMM Y') }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($subRow->tanggal_check_in)->diffInDays(\Carbon\Carbon::parse($subRow->tanggal_check_out)) }} Malam
                                </td>
                                <td>
                                    Rp {{ number_format($subRow->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="kwitansi-{{ $row->id_reservasi }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                    {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMMM Y') }}
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
                                <strong>{{ $row->pengunjung->nama_pengunjung }}</strong><br>
                                {{ $row->pengunjung->instansi }} <br>
                                Telp : {{ $row->pengunjung->no_hp }}
                            </address>
                        </div>

                        <div class="col-sm-4 invoice-col">
                            <b>Kwitansi #{{ $row->id_reservasi }}</b><br>
                            <br>
                            <b>Kode Biling:</b> {{ $row->kode_bilindg }}<br>
                            <b>Tanggal:</b> {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('DD/MM/Y') }}<br>
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
                                    @foreach($row->detail as $subRow)
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
                                        <td>{{ $row->detail->count() }} kamar</td>
                                    </tr>
                                    <tr>
                                        <th>Pajak (%)</th>
                                        <td>Rp 0</td>
                                    </tr>
                                    <tr>
                                        <th class="font-weight-bold">Total Pembayaran:</th>
                                        <td>Rp {{ number_format($row->total_pembayaran, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if ($row->status_reservasi == 14)
                <a href="{{ route('reservasi.kwitansi', $row->id_reservasi) }}" class="btn btn-danger btn-sm" target="_blank">
                    <i class="fas fa-print"></i> Cetak Kwitansi
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

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
            "info": true,
            "paging": true,
            "searching": true
        }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)')
    })
</script>
@endsection

@endsection
