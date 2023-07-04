<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservasiDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_reservasi_detail";
    protected $primaryKey = "id_detail";
    public $timestamps = false;

    protected $fillable = [
        'id_detail',
        'reservasi_id',
        'tarif_sewa_id',
        'tanggal_check_in',
        'waktu_check_in',
        'tanggal_check_out',
        'waktu_check_out',
        'total_harga',
        'keterangan'
    ];

    public function reservasi() {
        return $this->belongsTo(ReservasiDetail::class, 'reservasi_id');
    }

    public function pengunjung() {
        return $this->belongsTo(Status::class, 'pengungjung_id');
    }

    public function tarif() {
        return $this->belongsTo(TarifSewa::class, 'tarif_sewa_id');
    }
}
