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
            <div class="card-body">
                <table id="table-show" class="table table-bordered table-striped" style="font-size: 15px;">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Order ID</th>
                            <th style="width:30%;">Pengunjung</th>
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
                                {{ \Carbon\Carbon::parse($row->tanggal_reservasi)->isoFormat('DD MMMM Y') }} <br>
                                {{ $row->pengunjung->nama_pengunjung.' (0'.$row->pengunjung->no_hp.')' }} <br>
                                {{ $row->pengunjung->instansi != 'kemenkes' ? 'Lainnya' : 'Kemenkes' }}
                                {{ $row->pengunjung->instansi == 'kemenkes' ? (isset($row->pengunjung->unitKerja) ? $row->pengunjung->unitKerja->nama_unit_kerja : '') : $row->pengunjung->keterangan }}
                            </td>
                            <td>
                                Jumlah {{ $row->detail->count().' Kamar' }} (
                                <a type="button" class="text-primary" data-toggle="modal" onclick="showDetail('{{ $row->id_reservasi }}')">Detail</a> ) <br>
                                Total Harga Rp {{ number_format($row->detail->sum('total_harga'), 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @if ($row->pengunjung->foto_ktp) <i class="fas fa-check-circle text-success"></i> @else <i class="fas fa-times-circle text-danger"></i> @endif
                            </td>
                            <td class="text-center">
                                @if ($row->bukti_pembayaran)
                                <i class="fas fa-check-circle text-success"></i> @else <i class="fas fa-times-circle text-danger"></i> @endif
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
