<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalrateModel extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'tbl_rental_rates';
    protected $primaryKey = 'id_rental_rate';
    public $timestamps    = false;

    protected $fillable   = ['room_id', 'price', 'new_price', 'rental_rate_ctg','price_ctg'];
}
