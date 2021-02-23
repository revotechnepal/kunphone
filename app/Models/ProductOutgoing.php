<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOutgoing extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'ram',
        'rom',
        'quantity',
        'price',
        'refurbished',
        'accessories',
        'color',
        'brand_id',
        'condition',
        'is_featured',
        'details',
        'sku',
        'vendor_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
