<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Cancelorder;
use Validator;

class CancelOrderController extends BaseController
{

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'order_id' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $cancelorder = Cancelorder::create($input);

        return $this->sendResponse($cancelorder, 'Cancel Order created successfully.');
    }




}
