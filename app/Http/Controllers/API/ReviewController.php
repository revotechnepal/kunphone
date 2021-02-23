<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Review;
use Validator;
use App\Http\Resources\Review as ReviewResource;

class ReviewController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::all();

        return $this->sendResponse(ReviewResource::collection($reviews), 'Reviews retrieved successfully.');
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
            'rating' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $review = Review::create($input);

        return $this->sendResponse(new ReviewResource($review), 'Review created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $review = Review::find($id);

        if (is_null($review)) {
            return $this->sendError('Review not found.');
        }

        return $this->sendResponse(new ReviewResource($review), 'Review retrieved successfully.');
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

        $review = Review::where('id', $id)->first();
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'product_id' => 'required',
            'rating' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $review->user_id = $input['user_id'];
        $review->product_id = $input['product_id'];
        $review->rating = $input['rating'];
        $review->description = $input['description'];

        $review->save();

        return $this->sendResponse(new ReviewResource($review), 'Review updated successfully.');
    }

}
