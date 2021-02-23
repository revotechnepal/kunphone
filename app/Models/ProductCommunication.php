<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCommunication extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'bluetooth',
        'wlan',
        'gps',
        'radio',
        'usb',
        'networksupport'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
