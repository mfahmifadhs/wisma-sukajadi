@extends('layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">WISMA SUKAJADI</h1>
                <h5>Wisma Kemenkes Sukajadi Bandung</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Daftar Kamar</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
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
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table-show" class="table table-bordered table-striped m-0 text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Instansi</th>
                                <th>Nama Instansi</th>
                                <th>No. Kendaraan</th>
                                <th>Maksud/Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tamu as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->nama_tamu }}</td>
                                <td>{{ $row->no_hp }}</td>
                                <td>{{ $row->instansi }}</td>
                                <td>{{ $row->nama_instansi }}</td>
                                <td>{{ $row->no_kendaraan }}</td>
                                <td>{{ $row->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
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
                    messageTop: datetime
                },
                {
                    extend: 'excel',
                    text: ' Download (.xlsx)',
                    className: 'fas fa-file btn btn-success mr-2 rounded',
                    title: 'show',
                    messageTop: datetime
                }
            ]
        }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)')
    })
</script>
@endsection

@endsection
