<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KritikSaran extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_kritik_saran";
    protected $primaryKey = "id_kritik_saran";
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'no_hp',
        'no_kamar',
        'tgl_menginap',
        'pesan'
    ];
}
