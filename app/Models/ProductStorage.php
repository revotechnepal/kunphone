<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStorage extends Model
{
    use HasFactory;

    protected $fillable = [
            'product_id',
            'ram',
            'rom',
            'expandable',
            'price',
            'brand_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
