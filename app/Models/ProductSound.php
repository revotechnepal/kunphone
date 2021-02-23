<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSound extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'headphone',
        'loudspeakers',
        'audiofeatures'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
