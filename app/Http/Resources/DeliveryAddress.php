<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryAddress extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'address' => $this->address,
            'tole' => $this->tole,
            'town' => $this->town,
            'postcode' => $this->postcode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'phone' => $this->phone,
            'email' => $this->email,
            'user_id' => $this->user_id,
            'is_default' => $this->is_default,
            'description' => $this->description,
        ];
    }
}
