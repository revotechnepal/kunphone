<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\OrderedProduct;
use Validator;
use App\Http\Resources\OrderedProduct as OrderedProductResource;

class OrderedProductsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = OrderedProduct::all();

        return $this->sendResponse(OrderedProductResource::collection($products), 'Ordered Products retrieved successfully.');
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
            'order_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = OrderedProduct::create($input);

        return $this->sendResponse(new OrderedProductResource($product), 'Ordered Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = OrderedProduct::find($id);

        if (is_null($product)) {
            return $this->sendError('Ordered Product not found.');
        }

        return $this->sendResponse(new OrderedProductResource($product), 'Ordered Product retrieved successfully.');
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
        $product = OrderedProduct::where('id', $id)->first();
        $input = $request->all();

        $validator = Validator::make($input, [
            'order_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product->order_id = $input['order_id'];
        $product->product_id = $input['product_id'];
        $product->quantity = $input['quantity'];
        $product->price = $input['price'];

        $product->save();

        return $this->sendResponse(new OrderedProductResource($product), 'Ordered Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = OrderedProduct::where('id', $id)->first();

        $product->delete();

        return $this->sendResponse([], 'Ordered Product deleted successfully.');
    }
}
