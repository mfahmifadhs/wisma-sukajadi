<?php

namespace App\Exports;

use App\Models\Reservasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class ReservasiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $res = [];
    protected $no = 0;
    protected $tanggal;
    protected $bulan;
    protected $tahun;
    protected $status;

    function __construct($res)
    {
        // Cek apakah $res bukan null dan key ada
        if ($res && isset($res['tanggal'])) {
            $this->tanggal = $res['tanggal'];
        } else {
            $this->tanggal = null; // Atau nilai default yang diinginkan
        }

        $this->bulan = $res['bulan'] ?? null; // Gunakan operator null coalescing jika key belum ada
        $this->tahun = $res['tahun'] ?? null;
        $this->status = $res['status'] ?? null;
    }

    public function collection()
    {
        $tanggal = $this->tanggal;
        $bulan   = $this->bulan;
        $tahun   = $this->tahun;
        $status  = $this->status;

        $data    = Reservasi::orderBy('id_reservasi', 'DESC')
            ->join('t_reservasi_pengunjung', 'id_pengunjung', 'pengunjung_id')
            ->join('t_status', 'id_status', 'status_reservasi');

        if ($tanggal || $bulan || $tahun || $status) {
            if ($tanggal) {
                $result = $data->whereDay('tanggal_reservasi', $tanggal);
            }

            if ($bulan) {
                $result = $data->whereMonth('tanggal_reservasi', $bulan);
            }

            if ($tahun) {
                $result = $data->whereYear('tanggal_reservasi', $tahun);
            }

            if ($status) {
                $result = $data->where('status_reservasi', $status);
            }

            $result = $result->get();
        } else {
            $result = $data->get();
        }

        return $result;
    }

    public function map($result): array
    {
        $details = [];
        if ($result->detail) {
            foreach ($result->detail as $index => $detail) {
                $kamarNama = $detail->tarif && $detail->tarif->kamar ? $detail->tarif->kamar->nama_kamar : 'Kamar ' . ($index + 1);
                $kategori = $detail->tarif ? $detail->tarif->kategori_tamu : 'Tidak Diketahui';

                $details[] = $kamarNama . ' (' . $kategori . ')';
            }
        } else {
            $details[] = null;
        }

        return [
            ++$this->no,
            $result->kode_biling ? '`' . $result->kode_biling : null,
            $result->nama_pengunjung,
            '0' . $result->no_hp,
            $result->instansi,
            $result->keterangan,
            $result->tanggal_reservasi,
            $result->detail->count(),
            'Rp ' . number_format($result->detail->sum('total_harga'), 0, ',', '.'),
            'detail' => implode(', ', $details)
        ];
    }

    public function headings(): array
    {
        return [
            "NO",
            "KODE",
            "NAMA",
            "NO HP",
            "ASAL",
            "INSTANSI",
            "TGL. RESERVASI",
            "TOTAL KAMAR",
            "TOTAL TARIF SEWA"
        ];
    }
}
