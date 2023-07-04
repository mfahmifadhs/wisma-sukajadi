<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;


    protected $table        = "users";
    protected $primary_key  = "id";
    public $timestamps      = false;

    protected $fillable = [
        'username',
        'pegawai_id',
        'password',
        'password_text',
        'name',
        'role_id',
        'status_id'
    ];

    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function unitKerja() {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
