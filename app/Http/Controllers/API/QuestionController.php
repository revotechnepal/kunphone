<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Question;
use Validator;
use App\Http\Resources\Question as QuestionResource;

class QuestionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();

        return $this->sendResponse(QuestionResource::collection($questions), 'Questions retrieved successfully.');
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
            'outproduct_id' => 'required',
            'question' => 'required',
            'answer' => '',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $question = Question::create($input);

        return $this->sendResponse(new QuestionResource($question), 'Question created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);

        if (is_null($question)) {
            return $this->sendError('Question not found.');
        }

        return $this->sendResponse(new QuestionResource($question), 'Question retrieved successfully.');
    }

}
