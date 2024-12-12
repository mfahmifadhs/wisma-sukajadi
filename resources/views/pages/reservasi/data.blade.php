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
            <div class="col-sm-6 my-auto">
                <ol class="breadcrumb float-sm-right text-capitalize">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Reservasi</li>
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
                    <a id="downloadButton" onclick="downloadFile('excel')" class="btn btn-success btn-sm border-success" target="__blank">
                        <i class="fas fa-download"></i>
                        <span id="downloadSpinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                        <small>Download Excel</small>
                    </a>
                    <!-- <a id="downloadButton" onclick="downloadFile('pdf')" class="btn btn-danger btn-sm border-danger" target="__blank">
                        <i class="fas fa-print"></i>
                        <span id="downloadSpinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                        <small>Cetak</small>
                    </a> -->
                    <a href="" class="btn btn-primary btn-sm rounded" data-toggle="modal" data-target="#filterModal">
                        <i class="fas fa-filter"></i> <small>Filter</small>
                    </a>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-data" class="table table-bordered text-xs text-center">
                        <thead class="text-uppercase">
                            <tr>
                                <th style="width: 0%;">No</th>
                                <th>Aksi</th>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Asal Instansi</th>
                                <th>No. HP</th>
                                <th>Kamar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($reservasi->count() == 0)
                            <tr class="text-center">
                                <td colspan="9">Tidak ada data</td>
                            </tr>
                            @else
                            <tr class="text-center">
                                <td colspan="9">Sedang Mengambil Data ...</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section><br>


<!-- Modal -->
<div class="modal fade" id="modalReservasi" aria-labelledby="modalReservasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReservasiLabel">Detail Reservasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex">
                    <div class="w-25"><label>ID Reservasi</label></div>
                    <div class="w-75">: <span id="reservasiId"></span></div>
                </div>
                <div class="d-flex">
                    <div class="w-25"><label>Nama</label></div>
                    <div class="w-75">: <span id="reservasiNama"></span></div>
                </div>
                <div class="d-flex">
                    <div class="w-25"><label>Instansi</label></div>
                    <div class="w-75">: <span id="reservasiInstansi"></span></div>
                </div>
                <div class="d-flex">
                    <div class="w-25"><label>Total Harga</label></div>
                    <div class="w-75">: <span id="reservasiTotal"></span></div>
                </div>
                <hr>
                <div class="d-flex small text-center">
                    <div class="w-25"><label>No</label></div>
                    <div class="w-25"><label>Kamar</label></div>
                    <div class="w-25"><label>Kategori</label></div>
                    <div class="w-25"><label>Tarif Sewa</label></div>
                    <div class="w-50"><label>CheckIn - CheckOut</label></div>
                </div>
                <hr>

                <div id="reservasiDetail"></div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Filter -->
<div class="modal fade" id="filterModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pencarian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('reservasi.show') }}" method="GET">
                @csrf
                <div class="modal-body text-xs">
                    <div class="form-group">
                        <b>Pilih Tanggal</b>
                        <select id="tanggal" name="tanggal" class="form-control form-control-sm border-dark rounded text-center">
                            <option value="">Semua Tanggal</option>
                            @foreach(range(1, 31) as $dateNumber)
                            @php $rowTgl = Carbon\Carbon::create()->day($dateNumber)->isoFormat('DD'); @endphp
                            <option value="{{ $rowTgl }}" <?php echo $tanggal == $rowTgl ? 'selected' : '' ?>>
                                {{ $rowTgl }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <b>Pilih Bulan</b>
                        <select id="bulan" name="bulan" class="form-control form-control-sm border-dark rounded text-center">
                            <option value="">Semua Bulan</option>
                            @foreach(range(1, 12) as $monthNumber)
                            @php $rowBulan = Carbon\Carbon::create()->month($monthNumber); @endphp
                            <option value="{{ $rowBulan->isoFormat('MM') }}" <?php echo $bulan == $rowBulan->isoFormat('M') ? 'selected' : '' ?>>
                                {{ $rowBulan->isoFormat('MMMM') }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <b>Pilih Tahun</b>
                        <select id="tahun" class="form-control form-control-sm text-center" name="tahun">
                            <option value="2025" <?php echo $tahun == '2025' ? 'selected' : ''; ?>>2025</option>
                            <option value="2024" <?php echo $tahun == '2024' ? 'selected' : ''; ?>>2024</option>
                            <option value="2023" <?php echo $tahun == '2023' ? 'selected' : ''; ?>>2023</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <b>Pilih Status</b>
                        <select id="status" class="form-control form-control-sm text-center" name="status">
                            <option value="">Semua Status</option>
                            @foreach($listStatus as $row)
                            <option value="{{ $row->id_status }}" <?php echo $row->id_status == $status ? 'selected' : ''; ?>>
                                {{ $row->nama_status }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<form id="form" action="{{ route('reservasi.show') }}" method="GET">
    <input type="hidden" name="data" value="{{ json_encode($data) }}">
</form>
@section('js')
<script>
    $(document).ready(function() {
        let tanggal = $('#tanggal').val();
        let bulan = $('#bulan').val();
        let tahun = $('#tahun').val();
        let status = $('#status').val();

        loadTable(tanggal, bulan, tahun, status);

        function loadTable(tanggal, bulan, tahun, status) {
            $.ajax({
                url: `{{ route('reservasi.select') }}`,
                method: 'GET',
                data: {
                    tanggal: tanggal,
                    bulan: bulan,
                    tahun: tahun,
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    let tbody = $('.table tbody');
                    tbody.empty(); // Mengosongkan tbody sebelum menambahkan data

                    if (response.message) {
                        // Jika ada pesan dalam respons (misalnya "No data available")
                        tbody.append(`
                        <tr>
                            <td colspan="9">${response.message}</td>
                        </tr>
                    `);
                    } else {
                        // Jika ada data
                        $.each(response, function(index, item) {
                            tbody.append(`
                                <tr>
                                    <td>${item.no}</td>
                                    <td>${item.aksi}</td>
                                    <td class="align-middle">${item.id}</td>
                                    <td class="align-middle">${item.tanggal}</td>
                                    <td class="align-middle text-left">${item.nama}</td>
                                    <td class="align-middle text-left">${item.instansi}</td>
                                    <td class="align-middle">${item.nohp}</td>
                                    <td class="align-middle">
                                        <button
                                            class="btn-none btn-modal-reservasi"
                                            data-toggle="modal"
                                            data-target="#modalReservasi"
                                            data-id="${item.id}">
                                            <u>${item.kamar} <small>kamar</small></u>
                                        </button>
                                    </td>
                                    <td class="align-middle">${item.status}</td>
                                </tr>
                            `);
                        });


                        $(document).on('click', '.btn-modal-reservasi', function() {
                            const reservasiId = $(this).data('id');
                            const reservasiData = response.find(item => item.id == reservasiId);

                            if (reservasiData) {
                                $('#reservasiId').text(reservasiData.id);
                                $('#reservasiNama').text(reservasiData.nama);
                                $('#reservasiInstansi').text(reservasiData.instansi);
                                $('#reservasiTotal').text(reservasiData.total);

                                const detailContainer = $('#reservasiDetail');
                                detailContainer.empty();

                                if (reservasiData.detail && reservasiData.detail.length > 0) {
                                    let no = 1;
                                    reservasiData.detail.forEach(detail => {
                                        detailContainer.append(`
                                            <div class="d-flex small text-center">
                                                <div class="w-25"><span>${no++}</span></div>
                                                <div class="w-25"><span>${detail.nama_kamar}</span></div>
                                                <div class="w-25"><span>${detail.kategori_tamu}</span></div>
                                                <div class="w-25"><span>Rp. ${detail.harga_sewa.toLocaleString('id-ID')}</span></div>
                                                <div class="w-50"><span>${moment(detail.tanggal_check_in).format('D MMM YYYY')} - ${moment(detail.tanggal_check_out).format('D MMM YYYY')}</span></div>
                                            </div><hr>
                                        `);
                                    });
                                } else {
                                    detailContainer.append('<div class="d-flex small text-center"><div class="w-100">Tidak ada informasi kamar.</div></div>');
                                }
                            }
                        });

                        $("#table-data").DataTable({
                            "responsive": false,
                            "lengthChange": true,
                            "autoWidth": false,
                            "info": true,
                            "paging": true,
                            "searching": true,
                            "bDestroy": true
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    });
</script>

<!-- Download -->
<script>
    function downloadFile(downloadFile) {
        var form = document.getElementById('form');
        var downloadButton = document.getElementById('downloadButton');
        var downloadSpinner = document.getElementById('downloadSpinner');

        downloadSpinner.style.display = 'inline-block';

        var existingDownloadFile = form.querySelector('[name="downloadFile"]');
        if (existingDownloadFile) {
            existingDownloadFile.remove();
        }

        var downloadFileInput = document.createElement('input');
        downloadFileInput.type = 'hidden';
        downloadFileInput.name = 'downloadFile';
        downloadFileInput.value = downloadFile;
        form.appendChild(downloadFileInput);

        downloadButton.disabled = true;
        form.target = '_blank';

        form.submit();
        location.reload();
    }
</script>
@endsection

@endsection
