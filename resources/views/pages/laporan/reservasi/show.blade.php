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
                <h3 class="card-title">Laporan Pendapatan</h3>
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
                                @foreach ($bulan as $i => $row)
                                <option value="{{ $row['id'] }}" {{ !$bulanPick ? '' : ($row['id'] == $bulanPick->first()['id'] ? 'selected' : '') }}>
                                    {{ $row['nama_bulan'] }}
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
                            <a href="{{ route('laporan.show', ['id' => 'reservasi' ]) }}" class="btn btn-danger btn-sm font-weight-bold btn-block">
                                <i class="fas fa-undo"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <label for="">Laporan Pendapatan Per-tanggal</label>
                <table id="table-show" class="table table-bordered table-striped text-center" style="font-size: 15px;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Total Kamar</th>
                            <th>Kamar Dipesan</th>
                            <th>Kamar Tersedia</th>
                        </tr>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody class="text-capitalize">
                    @foreach($result->groupBy(function($item) {
                        return \Carbon\Carbon::parse($item->tanggal_reservasi)->format('d-m-Y');
                    }) as $date => $row)
                        <tr>
                            <td class="pt-3">{{ $no++ }} </td>
                            <td class="pt-3">{{ $date }}</td>
                            <td class="pt-3">{{ count($kamar) }} Kamar</td>
                            <td class="pt-3">{{ count($row) }} Kamar</td>
                            <td class="pt-3">{{ count($kamar) - count($row) }} Kamar</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section><br>

<!-- Modal -->
@foreach($result as $row)
<div class="modal fade" id="ktp-{{ $row->date }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto KTP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

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
        var currentdate = new Date();
        var datetime = "Tanggal: " + currentdate.getDate() + "/" +
            (currentdate.getMonth() + 1) + "/" +
            currentdate.getFullYear() + " \n Pukul: " +
            currentdate.getHours() + ":" +
            currentdate.getMinutes() + ":" +
            currentdate.getSeconds()
        $("#table-show").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true,
            buttons: [{
                    extend: 'pdf',
                    text: ' Download (.pdf)',
                    className: 'fas fa-file btn btn-danger mr-2 rounded',
                    title: 'show',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
                    messageTop: datetime
                },
                {
                    extend: 'excel',
                    text: ' Download (.xlsx)',
                    className: 'fas fa-file btn btn-success mr-2 rounded',
                    title: 'show',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
                    messageTop: datetime
                }
            ]
        }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)')
    })
</script>
@endsection

@endsection
