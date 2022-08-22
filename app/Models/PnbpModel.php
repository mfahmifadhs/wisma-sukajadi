<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PnbpModel extends Model
{
    use HasFactory;

    protected $table 	   = "tbl_pnbp";
    protected $primary_key = "id_pnbp";
    public $timestamps 	   = false;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_num',
        'transaction_date',
        'transaction_img',
        'pnbp_total_room',
        'pnbp_total_income',
        'pnbp_note',
        'pnbp_date',
        'pnbp_status'
    ];
}
