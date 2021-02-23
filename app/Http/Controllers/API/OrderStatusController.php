<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\OrderStatus;
use Validator;
//use App\Http\Resources\OrderStatus as OrderStatusResource;

class OrderStatusController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = OrderStatus::all();

        return $this->sendResponse($statuses, 'Order Statuses retrieved successfully.');
    }

    public function show($id)
    {
        $status = OrderStatus::find($id);

        if (is_null($status)) {
            return $this->sendError('Order Status not found.');
        }

        return $this->sendResponse($status, 'Order Status retrieved successfully.');
    }

}
