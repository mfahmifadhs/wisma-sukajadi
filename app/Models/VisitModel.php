<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitModel extends Model
{
    use HasFactory;

    protected $table 	   = "tbl_visits";
    protected $primary_key = "id_visit";
    public $timestamps 	   = false;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'visit_date',
        'visit_name',
        'visitor_phone_number',
        'visit_vehicle_num',
        'visit_description'
    ];
}
