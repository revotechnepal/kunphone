<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Setting extends JsonResource
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
            'site_name' => $this->site_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'twitter' => $this->twitter,
            'address' => $this->address,
            'aboutus' => $this->aboutus,
        ];
    }
}
