<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ProductOutgoing;
use Validator;

class OutgoingProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = ProductOutgoing::all();

        return $this->sendResponse($products, 'Outgoing Products retrieved successfully.');
    }

    public function show($id)
    {
        $product = ProductOutgoing::find($id);

        if (is_null($product)) {
            return $this->sendError('Outgoing Product not found.');
        }

        return $this->sendResponse($product, 'Outgoing Product retrieved successfully.');
    }

}
