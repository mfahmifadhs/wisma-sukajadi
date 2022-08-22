<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomModel extends Model {
    protected $table      = 'tbl_rooms';
    protected $primaryKey = 'id_room';
    public $timestamps    = false;
    protected $fillable   = ['room_name','room_capacity','room_img','room_status'];

    public function rentalrate() {
        return $this->hasMany(RentalrateModel::class, 'room_id')->orderby('rental_rate_ctg','ASC');
    }
}

class RentalrateModel extends Model {
    protected $table      = 'tbl_rental_rates';
    protected $primaryKey = 'id_rental_rate';
    protected $fillable   = ['room_id', 'price', 'rental_rate_ctg','price_ctg'];

    public function category() {
        return $this->belongsTo(Mainmenu::class, 'room_id'); 
    } 
}
