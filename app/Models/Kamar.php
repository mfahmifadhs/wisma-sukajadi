<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kamar extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_kamar";
    protected $primaryKey = "id_kamar";
    public $timestamps = false;

    protected $fillable = [
        'nama_kamar',
        'kapasitas',
        'luas_kamar',
        'foto_kamar',
        'status_kamar'
    ];

    public function tarif() {
        return $this->hasMany(TarifSewa::class, 'kamar_id');
    }
}
