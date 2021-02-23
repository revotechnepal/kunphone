<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExchangeConfirm extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'incomingproduct_id' => $this->incomingproduct_id,
            'product1_ram' => $this->product1_ram,
            'product1_rom' => $this->product1_rom,
            'product1_price' => $this->product1_price,
            'outgoingproduct_id' => $this->outgoingproduct_id,
            'product2_ram' => $this->product2_ram,
            'product2_rom' => $this->product2_rom,
            'product2_price' => $this->product2_price,
            'pricediff' => $this->pricediff,
            'vendor' => $this->vendor,
            'exchangecode' => $this->exchangecode,
            'frontimage' => $this->frontimage,
            'backimage' => $this->backimage,
            'is_processsing' => $this->is_processsing,
        ];
    }
}
