<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBackCamera extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'backcamera',
        'backvideo',
        'backfeatures'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
