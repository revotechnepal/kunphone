<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDisplay extends Model
{
    use HasFactory;

    protected $fillable = [
            'product_id',
            'screensize',
            'displaytype',
            'resolution',
            'pixeldensity',
            'protection',
            'screentobodyratio'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
