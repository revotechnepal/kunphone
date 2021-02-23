<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelieveryAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'address',
        'tole',
        'town',
        'postcode',
        'latitude',
        'longitude',
        'phone',
        'email',
        'user_id',
        'is_default',
        'description',
    ];
}
