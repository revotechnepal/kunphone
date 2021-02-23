<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\DelieveryAddress;
use Validator;
use App\Http\Resources\DeliveryAddress as DeliveryAddressResource;

class DeliveryAddressController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveryaddresses = DelieveryAddress::all();

        return $this->sendResponse(DeliveryAddressResource::collection($deliveryaddresses), 'Delivery Addresses retrieved successfully.');
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
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'tole' => 'required',
            'town' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $deliveryaddress = DelieveryAddress::create($input);

        return $this->sendResponse(new DeliveryAddressResource($deliveryaddress), 'Delivery Address created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deliveryaddress = DelieveryAddress::find($id);

        if (is_null($deliveryaddress)) {
            return $this->sendError('Delivery address not found.');
        }

        return $this->sendResponse(new DeliveryAddressResource($deliveryaddress), 'Delivery address retrieved successfully.');
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
        $deliveryaddress = DelieveryAddress::where('id', $id)->first();
        $input = $request->all();
        $validator = Validator::make($input, [
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'tole' => 'required',
            'town' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $deliveryaddress->firstname = $input['firstname'];
        $deliveryaddress->lastname = $input['lastname'];
        $deliveryaddress->address = $input['address'];
        $deliveryaddress->tole = $input['tole'];
        $deliveryaddress->town = $input['town'];
        $deliveryaddress->postcode = $input['postcode'];
        $deliveryaddress->latitude = $request['latitude'];
        $deliveryaddress->longitude = $request['longitude'];
        $deliveryaddress->phone = $input['phone'];
        $deliveryaddress->email = $input['email'];
        $deliveryaddress->user_id = $input['user_id'];
        $deliveryaddress->is_default = $request['is_default'];
        $deliveryaddress->description = $request['description'];

        $deliveryaddress->save();

        return $this->sendResponse(new DeliveryAddressResource($deliveryaddress), 'Delivery Address updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deliveryaddress = DelieveryAddress::where('id', $id)->first();

        $deliveryaddress->delete();

        return $this->sendResponse([], 'Delivery Address deleted successfully.');
    }
}
