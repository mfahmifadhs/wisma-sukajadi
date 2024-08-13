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
                    <li class="breadcrumb-item active">Kritik & Saran</li>
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
        <div class="card border border-dark">
            <div class="card-header border-dark">
                <label class="my-auto"><i class="fas fa-envelope-open-text"></i> Kritik & Saran</label>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="tShow" class="table table-bordered text-center" style="font-size: 15px;">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 0%;">No</th>
                            <th style="width: 20%;">Nama</th>
                            <th style="width: 10%;">No. HP</th>
                            <th style="width: 10%;">No. Kamar</th>
                            <th style="width: 15%;">Tanggal Menginap</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody class="text-sm">
                        @foreach($data as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }} </td>
                            <td class="text-left">{{ $row->nama }}</td>
                            <td>{{ $row->no_hp }}</td>
                            <td>{{ $row->no_kamar }}</td>
                            <td>{{ Carbon\Carbon::parse($row->tgl_menginap)->isoFormat('DD MMMM Y') }}</td>
                            <td class="text-left">{{ nl2br($row->pesan) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#tShow").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true,
            buttons: [{
                extend: 'excel',
                text: ' Excel',
                pageSize: 'A4',
                className: 'bg-success btn-sm rounded',
                title: 'kritik_saran',
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#tShow_wrapper .col-md-6:eq(0)');
    })
</script>
@endsection

@endsection
