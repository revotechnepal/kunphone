<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Cart;
use Validator;
use App\Http\Resources\Cart as CartResource;

class CartController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::all();

        return $this->sendResponse(CartResource::collection($carts), 'Cart Contents retrieved successfully.');
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
            'ram' => 'required',
            'rom' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $cart = Cart::create($input);

        return $this->sendResponse(new CartResource($cart), 'Cart Content created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cart = Cart::find($id);

        if (is_null($cart)) {
            return $this->sendError('Brand not found.');
        }

        return $this->sendResponse(new CartResource($cart), 'Cart Product retrieved successfully.');
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
        $cart = Cart::where('id', $id)->first();
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'product_id' => 'required',
            'ram' => 'required',
            'rom' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $cart->user_id = $input['user_id'];
        $cart->product_id = $input['product_id'];
        $cart->ram = $input['ram'];
        $cart->rom = $input['rom'];
        $cart->price = $input['price'];
        $cart->quantity = $input['quantity'];

        $cart->save();

        return $this->sendResponse(new CartResource($cart), 'Cart Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::where('id', $id)->first();

        $cart->delete();

        return $this->sendResponse([], 'Cart Product deleted successfully.');
    }
}
