<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProductIncoming extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'user_id',
        'product_id',
        'makecalls',
        'phonescreen',
        'bodydefects',
        'timeused',
        'duration',
        'warranty',
        'return',
        'frontcamera',
        'backcamera',
        'volumebuttons',
        'touchscreen',
        'battery',
        'volumesound',
        'colorfaded',
        'powerbutton',
        'chargingpot',
        'fullname',
        'phone',
        'otherdefects',
        'is_approved',
        'price',
        'ram',
        'rom',
        'frontimage',
        'backimage',
        'exchangecode',
        'is_confirmed',
        'is_sent'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
