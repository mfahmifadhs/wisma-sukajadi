<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationDetailModel extends Model
{
    use HasFactory;

    protected $table = "tbl_reservations_details";
    protected $primary_key = "id_detail_reservation";
    public $timestamps = false;
    
    protected $fillable = [
        'reservation_id',
        'rental_rate_id',
        'check_in',
        'check_out',
        'duration',
        'detail_reservation_price',
        'notes'
    ];
}
