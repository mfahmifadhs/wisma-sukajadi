<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_reservasi";
    protected $primaryKey = "id_reservasi";
    public $timestamps = false;

    protected $fillable = [
        'id_reservasi',
        'pengunjung_id',
        'surat_tugas',
        'kode_biling',
        'tanggal_reservasi',
        'status_reservasi',
        'status_pembayaran',
        'bukti_pembayaran',
        'tanggal_pembayaran',
        'total_pembayaran',
        'total_kamar',
        'tanggal_masuk',
        'tanggal_keluar'
    ];

    public function detail() {
        return $this->hasMany(ReservasiDetail::class, 'reservasi_id')
            ->join('t_tarif_sewa','id_tarif_sewa','tarif_sewa_id')
            ->join('t_kamar','id_kamar','kamar_id');
    }

    public function statusReservasi() {
        return $this->belongsTo(Status::class, 'status_reservasi');
    }

    public function statusBayar() {
        return $this->belongsTo(Status::class, 'status_pembayaran');
    }

    public function pengunjung() {
        return $this->belongsTo(Pengunjung::class, 'pengunjung_id');
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_reservasi');
    }
}
