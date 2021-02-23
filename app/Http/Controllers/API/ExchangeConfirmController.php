<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ExchangeConfirm;
use Validator;
use App\Http\Resources\ExchangeConfirm as ExchangeConfirmResource;

class ExchangeConfirmController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exchangeconfirm = ExchangeConfirm::latest()->get();
        return $this->sendResponse(ExchangeConfirmResource::collection($exchangeconfirm), 'Confirmed Exchanges retrieved successfully.');
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
            'incomingproduct_id' => 'required',
            'product1_ram' => 'required',
            'product1_rom' => 'required',
            'product1_price' => 'required',
            'outgoingproduct_id' => 'required',
            'product2_ram' => 'required',
            'product2_rom' => 'required',
            'product2_price' => 'required',
            'pricediff' => 'required',
            'vendor' => 'required',
            'exchangecode' => 'required',
            'frontimage' => 'required',
            'backimage' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = ExchangeConfirm::create($input);

        return $this->sendResponse(new ExchangeConfirmResource($product), 'Exchange Confirm created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exchangeconfirm = ExchangeConfirm::find($id);

        if (is_null($exchangeconfirm)) {
            return $this->sendError('Exchange Confirm not found.');
        }

        return $this->sendResponse(new ExchangeconfirmResource($exchangeconfirm), 'Exchange Confirm retrieved successfully.');
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
        $exchange = ExchangeConfirm::where('id', $id)->first();
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'incomingproduct_id' => 'required',
            'product1_ram' => 'required',
            'product1_rom' => 'required',
            'product1_price' => 'required',
            'outgoingproduct_id' => 'required',
            'product2_ram' => 'required',
            'product2_rom' => 'required',
            'product2_price' => 'required',
            'pricediff' => 'required',
            'vendor' => 'required',
            'exchangecode' => 'required',
            'frontimage' => 'required',
            'backimage' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $exchange->user_id = $input['user_id'];
        $exchange->incomingproduct_id = $input['incomingproduct_id'];
        $exchange->product1_ram = $input['product1_ram'];
        $exchange->product1_rom = $input['product1_rom'];
        $exchange->product1_price = $input['product1_price'];
        $exchange->outgoingproduct_id = $input['outgoingproduct_id'];
        $exchange->product2_ram = $input['product2_ram'];
        $exchange->product2_rom = $input['product2_rom'];
        $exchange->product2_price = $input['product2_price'];
        $exchange->pricediff = $input['pricediff'];
        $exchange->vendor = $input['vendor'];
        $exchange->exchangecode = $input['exchangecode'];
        $exchange->frontimage = $input['frontimage'];
        $exchange->backimage = $input['backimage'];
        $exchange->backimage = $input['backimage'];
        $exchange->is_processsing = $request['is_processsing'];

        $exchange->save();

        return $this->sendResponse(new ExchangeConfirmResource($exchange), 'Exchange Confirm updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exchange = ExchangeConfirm::where('id', $id)->first();
        $exchange->delete();

        return $this->sendResponse([], 'Exchange Confirm deleted successfully.');
    }
}
