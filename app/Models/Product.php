<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'slug',
        'brand_id',
        'sim',
        'modelimage'
    ];

    public function searchableAs()
    {
        return 'kunphone_products';
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function productdesign(){
        return $this->hasOne(ProductDesign::class);
    }

    public function productstorage(){
        return $this->hasMany(ProductStorage::class);
    }

    public function productdisplay(){
        return $this->hasOne(ProductDisplay::class);
    }

    public function productperformance(){
        return $this->hasOne(ProductPerformance::class);
    }

    public function productbackcamera(){
        return $this->hasOne(ProductBackCamera::class);
    }
    public function productfrontcamera(){
        return $this->hasOne(ProductFrontCamera::class);
    }
    public function productsound(){
        return $this->hasOne(ProductSound::class);
    }

    public function productbattery(){
        return $this->hasOne(ProductBattery::class);
    }

    public function productcommunication(){
        return $this->hasOne(ProductCommunication::class);
    }

}
