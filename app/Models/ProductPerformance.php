<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
            'product_id',
            'gpu',
            'os',
            'chipsetgp',
            'cpu',
            'sensors'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
