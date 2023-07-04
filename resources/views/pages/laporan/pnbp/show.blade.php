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
                <h3 class="card-title">Laporan PNBP</h3>
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
                                <option value="{{ $row['id'] }}" <?php echo !$bulanPick ? '' : $row['id'] == $bulanPick->first()['id'] ? 'selected' : '' ?>>
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
                <label for="">Laporan PNBP Per-tanggal</label>
                <table id="table-show" class="table table-bordered table-striped text-center" style="font-size: 15px;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jumlah Kode Biling</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody class="text-capitalize">
                        @foreach($result->sortByDesc('date') as $row)
                        <tr>
                            <td>{{ $no++ }} </td>
                            <td>{{ $row->date }}</td>
                            <td>{{ $row->kode_biling }} kode biling</td>
                            <td>
                                <a type="button" class="btn btn-default btn-sm" data-toggle="modal" onclick="showDetail('{{ $row->date }}')">
                                    <i class="fas fa-list"></i> Daftar
                                </a>
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
@foreach($result as $row)
<div class="modal fade" id="detail-{{ $row->date }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Daftar Kode Biling [{{ Carbon\carbon::parse($row->date)->isoFormat('DD MMMM Y') }}]</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table m-0 text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Order ID</th>
                            <th>Kode Biling</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservasi->where('date', $row->date) as $i => $subRow)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><a href="{{ route('reservasi.detail', $subRow->id_reservasi) }}">{{ $subRow->id_reservasi }}</a></td>
                            <td>{{ $subRow->kode_biling }}</td>
                            <td>{{ \Carbon\Carbon::parse($subRow->tanggal_pembayaran)->isoFormat('DD MMMM Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach

@section('js')
<script>
    function showDetail(id) {
        var modal_target = "#detail-" + id;
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
