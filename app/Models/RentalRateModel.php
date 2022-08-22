<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalrateModel extends Model {
    protected $table      = 'tbl_rental_rates';
    protected $primaryKey = 'id_rental_rate';
    public $timestamps    = false;
    protected $fillable   = ['room_id', 'price', 'rental_rate_ctg','price_ctg'];
}
