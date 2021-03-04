<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory;
    // use Notifiable;

    protected $fillable = [
        'user_id',
        'order_status_id',
        'delievery_address_id',
        'payment_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderStatus()
    {
        return $this->hasOne(OrderStatus::class , 'id', 'order_status_id');
    }

    public function delieveryAddress()
    {
        return $this->hasOne(DelieveryAddress::class, 'id', 'delievery_address_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id', 'payment_id');
    }
}
