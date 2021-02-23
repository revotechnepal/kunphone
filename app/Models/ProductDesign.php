<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDesign extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'height',
        'width',
        'thickness',
        'weight',
        'color',
        'build'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
