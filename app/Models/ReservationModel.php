<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReservationDetailModel;

class ReservationModel extends Model {
    protected $table      = 'tbl_reservations';
    protected $primaryKey = 'id_reservation';
    public $timestamps    = false;
    
    protected $fillable   = [
        'billing_code',
        'visitor_id',
        'assignment_letter',
        'total_room',
        'status_reservation',
        'payment_status',
        'payment_img',
        'payment_total',
        'reservation_date'
    ];

    public function reservationdetail() {
        return $this->hasMany(ReservationDetailModel::class, 'reservation_id');
    }
}
