<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OrderedProduct extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'order_status_id',
        'vendor_id',
        'warranty',
    ];

    public function orderStatus()
    {
        return $this->hasOne(OrderStatus::class, 'id', 'order_status_id');
    }

}
