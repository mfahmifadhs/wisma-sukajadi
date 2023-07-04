<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
    use HasFactory;

    protected $table 	   = "t_buku_tamu";
    protected $primary_key = "id_tamu";
    public $timestamps 	   = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_tamu',
        'instansi',
        'nama_instansi',
        'no_hp',
        'no_kendaraan',
        'keterangan'
    ];
}
