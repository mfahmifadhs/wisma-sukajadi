<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarifSewa extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table      = 't_tarif_sewa';
    protected $primaryKey = 'id_tarif_sewa';
    public $timestamps    = false;

    protected $fillable = [
        'id_tarif_sewa',
        'kategori_tamu',
        'kamar_id',
        'kategori_sewa',
        'harga_sewa',
        'periodesitas'
    ];

    public function kamar() {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }
}
