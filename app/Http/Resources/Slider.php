<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Slider extends JsonResource
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
            'hashtitle' => $this->hashtitle,
            'title' => $this->title,
            'description' => $this->description,
            'images' => $this->images,
        ];
    }
}
