<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Setting;
use Validator;
use App\Http\Resources\Setting as SettingResource;

class SettingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::all();

        return $this->sendResponse(SettingResource::collection($settings), 'Settings retrieved successfully.');
    }
}
