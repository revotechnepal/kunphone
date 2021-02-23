<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUsed extends Model
{
    use HasFactory;

    protected $fillable = [
        'used_product_id',
        'modelimage',
    ];
}
