<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorModel extends Model
{
    use HasFactory;

    protected $table = "tbl_visitors";
    protected $primary_key = "id_visitor";
    public $timestamps = false;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_alumni',
        'identity_num',
        'identity_img',
        'visitor_name',
        'visitor_birthdate',
        'visitor_phone_number',
        'visitor_address',
        'visitor_instance',
        'visitor_description'
    ];
}
