<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $id }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dist_admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist_admin/css/adminlte.min.css') }}">
</head>
<style>
    @media print {
        .pagebreak {
            page-break-after: always;
        }

        .table-data {
            border: 1px solid;
            font-size: 20px;
        }

        .table-data th,
        .table-data td {
            border: 1px solid;
        }

        .table-data thead th,
        .table-data thead td {
            border: 1px solid;
        }
    }

    .divTable {
        border-top: 1px solid;
        border-left: 1px solid;
        border-right: 1px solid;
        font-size: 21px;
    }

    .divThead {
        border-bottom: 1px solid;
        font-weight: bold;
    }

    .divTbody {
        border-bottom: 1px solid;
        text-transform: capitalize;
    }

    .divTheadtd {
        border-right: 1px solid;
    }

    .divTbodytd {
        border-right: 1px solid;
        padding: 10px;
    }
</style>

<body style="font-family: Arial;">
    <section class="invoice">
        <div class="row">
            <div class="col-12">

                <div class="invoice p-3 mb-3">
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <img src="{{ asset('images/admin/logo-kemenkes-icon.png') }}" width="50" style="margin-top: -8px;">
                                Wisma Sukajadi Bandung
                                <small class="float-right mt-3">
                                    {{ \Carbon\Carbon::parse($reservasi->tanggal_pembayaran)->isoFormat('DD MMMM Y') }}
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
                                @if ($reservasi->pengunjung->instansi == 'Kemenkes')
                                    {{ $reservasi->pengunjung->unitKerja->nama_unit_kerja }}
                                @else
                                    {{ $reservasi->pengunjung->keterangan }}
                                @endif
                                <br>
                                Telp : {{ $reservasi->no_hp }}
                            </address>
                        </div>

                        <div class="col-sm-4 invoice-col">
                            <b>Kwitansi #{{ $reservasi->id_reservasi }}</b><br>
                            <br>
                            <b>Kode Biling:</b> {{ $reservasi->kode_biling }}<br>
                            <b>Tanggal:</b> {{ \Carbon\Carbon::parse($reservasi->tanggal_pembayaran)->isoFormat('DD/MM/Y') }}<br>
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
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Periodisitas</th>
                                        <th>Harga/malam</th>
                                        <th>Tarif Sewa</th>
                                        </tr>
                                </thead>
                                <?php $no = 1; ?>
                                <tbody>
                                    @foreach ($reservasi->detail as $i => $row)
                                    @php $durasi = \Carbon\Carbon::parse($row->tanggal_check_in)->diffInDays(\Carbon\Carbon::parse($row->tanggal_check_out)); @endphp
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $row->tarif->kamar->nama_kamar }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->tanggal_check_in)->isoFormat('DD/MM/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->tanggal_check_out)->isoFormat('DD/MM/Y') }}</td>
                                        <td>{{ $durasi }} malam</td>
                                        <td>Rp {{ number_format($row->tarif->harga_sewa) }}</td>
                                        <td>Rp {{ number_format($row->total_harga) }}</td>
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

                        <div class="col-md-6 mt-4">
                            <p class="font-weight-bold" style="margin-top: 10px;">Catatan :</p>
                            <p style="font-family: Times New Roman;">
                                1. Disimpan sebagai bukti pembayaran yang SAH. <br>
                                2. Harga sudah termasuk pajak. <br>
                                3. Uang yang sudah dibayarkan tidak dapat diminta kembali.

                            </p>
                        </div>

                        <div class="col-md-6 mt-4">
                            <p class="font-weight-bold">Pengelola Wisma Sukajadi Bandung Kemenkes RI</p>
                            <p style="margin-top: 100px;">
                                ──────────────
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
