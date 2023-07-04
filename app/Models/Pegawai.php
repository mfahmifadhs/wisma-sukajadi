<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_pegawai";
    protected $primaryKey = "id_pegawai";
    public $timestamps = false;

    protected $fillable = [
        'id_pegawai',
        'unit_kerja_id',
        'nip',
        'nama_pegawai',
        'jabatan',
        'status_id'
    ];

    public function unitKerja() {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
