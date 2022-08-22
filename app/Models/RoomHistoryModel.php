<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomHistoryModel extends Model
{
    use HasFactory;

    protected $table        = "tbl_room_historys";
    protected $primary_key  = "id_room_history";
    public $timestamps      = false;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reservation_id',
        'history_date',
        'total_room',
        'room_reserved',
        'room_notavailable',
        'room_available'
    ];
}
