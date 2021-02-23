<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Wishlist;
use Validator;
use App\Http\Resources\Wishlist as WishlistResource;

class WishlistController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wishlists = Wishlist::all();

        return $this->sendResponse(WishlistResource::collection($wishlists), 'Wishlists retrieved successfully.');
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
            'product_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $wishlist = Wishlist::create($input);

        return $this->sendResponse(new WishlistResource($wishlist), 'Wishlist added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wishlist = Wishlist::find($id);

        if (is_null($wishlist)) {
            return $this->sendError('Wishlist content not found.');
        }

        return $this->sendResponse(new WishlistResource($wishlist), 'Wishlist content retrieved successfully.');
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

        $wishlist = Wishlist::where('id', $id)->first();
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'product_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $wishlist->user_id = $input['user_id'];
        $wishlist->product_id = $input['product_id'];
        $wishlist->save();

        return $this->sendResponse(new WishlistResource($wishlist), 'Wishlist content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wishlist = Wishlist::where('id', $id)->first();

        $wishlist->delete();

        return $this->sendResponse([], 'Wishlist content deleted successfully.');
    }
}
