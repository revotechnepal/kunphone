<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFrontCamera extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'frontcamera',
        'frontvideo',
        'frontfeatures'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
