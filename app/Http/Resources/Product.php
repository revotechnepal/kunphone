<?php

namespace App\Http\Resources;

use App\Models\ProductBackCamera;
use App\Models\ProductBattery;
use App\Models\ProductCommunication;
use App\Models\ProductDesign;
use App\Models\ProductDisplay;
use App\Models\ProductFrontCamera;
use App\Models\ProductPerformance;
use App\Models\ProductSound;
use App\Models\ProductStorage;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $productbackcamera = ProductBackCamera::where('product_id', $this->id)->first();
        $productfrontcamera = ProductFrontCamera::where('product_id', $this->id)->first();
        $productbattery = ProductBattery::where('product_id', $this->id)->first();
        $productcommunication = ProductCommunication::where('product_id', $this->id)->first();
        $productdesign = ProductDesign::where('product_id', $this->id)->first();
        $productdisplay = ProductDisplay::where('product_id', $this->id)->first();
        $productperformance = ProductPerformance::where('product_id', $this->id)->first();
        $productsound = ProductSound::where('product_id', $this->id)->first();
        $productstorage = ProductStorage::where('product_id', $this->id)->get();
        $ram = array();
        $rom = array();
        $expandable = array();
        $price = array();
        foreach ($productstorage as $storage) {
            $ram[] = $storage->ram;
            $rom[] = $storage->rom;
            $expandable[] = $storage->expandable;
            $price[] = $storage->price;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'brand_id' => $this->brand_id,
            'sim' => $this->sim,
            'modelimage' => $this->modelimage,
            'backcamera' => $productbackcamera->backcamera,
            'backvideo' => $productbackcamera->backvideo,
            'backfeatures' => $productbackcamera->backfeatures,
            'frontcamera' => $productfrontcamera->frontcamera,
            'frontvideo' => $productfrontcamera->frontvideo,
            'frontfeatures' => $productfrontcamera->frontfeatures,
            'capacity' => $productbattery->capacity,
            'userreplaceable' => $productbattery->userreplaceable,
            'batterytype' => $productbattery->batterytype,
            'bluetooth' => $productcommunication->bluetooth,
            'wlan' => $productcommunication->wlan,
            'gps' => $productcommunication->gps,
            'radio' => $productcommunication->radio,
            'usb' => $productcommunication->usb,
            'networksupport' => $productcommunication->networksupport,
            'height' => $productdesign->height,
            'width' => $productdesign->width,
            'thickness' => $productdesign->thickness,
            'weight' => $productdesign->weight,
            'color' => $productdesign->color,
            'build' => $productdesign->build,
            'screensize' => $productdisplay->screensize,
            'displaytype' => $productdisplay->displaytype,
            'resolution' => $productdisplay->resolution,
            'pixeldensity' => $productdisplay->pixeldensity,
            'protection' => $productdisplay->protection,
            'screentobodyratio' => $productdisplay->screentobodyratio,
            'gpu' => $productperformance->gpu,
            'os' => $productperformance->os,
            'chipsetgp' => $productperformance->chipsetgp,
            'cpu' => $productperformance->cpu,
            'sensors' => $productperformance->sensors,
            'headphone' => $productsound->headphone,
            'loudspeakers' => $productsound->loudspeakers,
            'audiofeatures' => $productsound->audiofeatures,
            'ram' => $ram,
            'rom' => $rom,
            'expandable' => $expandable,
            'price' => $price,
        ];
    }
}
