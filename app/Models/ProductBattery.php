<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBattery extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'capacity',
        'userreplaceable',
        'batterytype'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
