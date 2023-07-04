<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitKerja extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_unit_kerja";
    protected $primaryKey = "id_unit_kerja";
    public $timestamps = false;

    protected $fillable = [
        'id_unit_kerja',
        'unit_utama_id',
        'kode_unit_kerja',
        'nama_unit_kerja',
        'alokasi_anggaran'
    ];

    public function unitUtama() {
        return $this->belongsTo(UnitUtama::class, 'unit_utama_id');
    }
}
