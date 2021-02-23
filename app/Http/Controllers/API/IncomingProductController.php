<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ProductIncoming;
use Validator;

class IncomingProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomingproducts = ProductIncoming::all();

        return $this->sendResponse($incomingproducts, 'Incoming Products retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'product_id' => 'required',
            'makecalls' => 'required',
            'phonescreen' => 'required',
            'bodydefects' => 'required',
            'timeused' => 'required',
            'duration' => 'required',
            'warranty' => 'required',
            'return' => 'required',
            'frontcamera' => 'required',
            'backcamera' => 'required',
            'volumebuttons' => 'required',
            'touchscreen' => 'required',
            'battery' => 'required',
            'volumesound' => 'required',
            'colorfaded' => 'required',
            'powerbutton' => 'required',
            'chargingpot' => 'required',
            'fullname' => 'required',
            'is_approved' => 'required',
            'is_sent' => 'required',
            'ram' => 'required',
            'rom' => 'required',
            'is_confirmed' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = ProductIncoming::create($input);

        return $this->sendResponse($product, 'Incoming Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = ProductIncoming::find($id);

        if (is_null($product)) {
            return $this->sendError('Incoming Product not found.');
        }

        return $this->sendResponse($product, 'Incoming Product retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = ProductIncoming::where('id', $id)->first();
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'product_id' => 'required',
            'makecalls' => 'required',
            'phonescreen' => 'required',
            'bodydefects' => 'required',
            'timeused' => 'required',
            'duration' => 'required',
            'warranty' => 'required',
            'return' => 'required',
            'frontcamera' => 'required',
            'backcamera' => 'required',
            'volumebuttons' => 'required',
            'touchscreen' => 'required',
            'battery' => 'required',
            'volumesound' => 'required',
            'colorfaded' => 'required',
            'powerbutton' => 'required',
            'chargingpot' => 'required',
            'fullname' => 'required',
            'is_approved' => 'required',
            'is_sent' => 'required',
            'ram' => 'required',
            'rom' => 'required',
            'is_confirmed' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product->user_id = $input['user_id'];
        $product->product_id = $input['product_id'];
        $product->makecalls = $input['makecalls'];
        $product->phonescreen = $input['phonescreen'];
        $product->bodydefects = $input['bodydefects'];
        $product->timeused = $input['timeused'];
        $product->duration = $input['duration'];
        $product->warranty = $input['warranty'];
        $product->return = $input['return'];
        $product->frontcamera = $input['frontcamera'];
        $product->backcamera = $input['backcamera'];
        $product->volumebuttons = $input['volumebuttons'];
        $product->touchscreen = $input['touchscreen'];
        $product->battery = $input['battery'];
        $product->volumesound = $input['volumesound'];
        $product->colorfaded = $input['colorfaded'];
        $product->powerbutton = $input['powerbutton'];
        $product->chargingpot = $input['chargingpot'];
        $product->fullname = $input['fullname'];
        $product->phone = $input['phone'];
        $product->otherdefects = $request['otherdefects'];
        $product->is_approved = $input['is_approved'];
        $product->is_sent = $input['is_sent'];
        $product->price = $request['price'];
        $product->ram = $input['ram'];
        $product->rom = $input['rom'];
        $product->frontimage = $request['frontimage'];
        $product->backimage = $request['backimage'];
        $product->exchangecode = $request['exchangecode'];
        $product->is_confirmed = $input['is_confirmed'];

        $product->save();

        return $this->sendResponse($product, 'Incoming Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = ProductIncoming::where('id', $id)->first();
        $product->delete();

        return $this->sendResponse([], 'Incoming Product deleted successfully.');
    }
}
