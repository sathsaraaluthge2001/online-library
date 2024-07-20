<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OlUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'olusers'; 
    protected $primaryKey = 'email'; 
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'username',
        'email',
        'contactnumber',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
