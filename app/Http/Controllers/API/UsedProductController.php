<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ProductUsed;
use Validator;
// use App\Http\Resources\Brand as BrandResource;

class UsedProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = ProductUsed::all();

        return $this->sendResponse($products, 'Used Product Images retrieved successfully.');
    }

    public function show($id)
    {
        $product = ProductUsed::find($id);

        if (is_null($product)) {
            return $this->sendError('Used Product Image not found.');
        }

        return $this->sendResponse($product, 'Used Product Image retrieved successfully.');
    }


}
