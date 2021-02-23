<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Slider;
use Validator;
use App\Http\Resources\Slider as SliderResource;

class SliderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();

        return $this->sendResponse(SliderResource::collection($sliders), 'Sliders retrieved successfully.');
    }

    public function show($id)
    {
        $slider = Slider::find($id);

        if (is_null($slider)) {
            return $this->sendError('Slider Content not found.');
        }

        return $this->sendResponse(new SliderResource($slider), 'Slider Contents retrieved successfully.');
    }



}
