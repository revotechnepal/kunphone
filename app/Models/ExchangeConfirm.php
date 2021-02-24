<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ExchangeConfirm extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
       'user_id',
       'incomingproduct_id',
       'product1_ram',
       'product1_rom',
       'product1_price',
       'outgoingproduct_id',
       'product2_ram',
       'product2_rom',
       'product2_price',
       'pricediff',
       'vendor',
       'exchangecode',
       'frontimage',
       'backimage',
       'is_processsing',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
