<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengunjung extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_reservasi_pengunjung";
    protected $primaryKey = "id_pengunjung";
    public $timestamps = false;

    protected $fillable = [
        'id_pengunjung',
        'unit_kerja_id',
        'nik',
        'foto_ktp',
        'nama_pengunjung',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'instansi',
        'keterangan'
    ];

    public function unitKerja() {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }
}
