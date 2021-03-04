<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Blog;
use Validator;
// use App\Http\Resources\Brand as BrandResource;

class BlogController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();

        return $this->sendResponse($blogs, 'Blogs retrieved successfully.');
    }

    public function show($id)
    {
        $blog = Blog::find($id);

        if (is_null($blog)) {
            return $this->sendError('Blog not found.');
        }

        return $this->sendResponse($blog, 'Blog retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::where('id', $id)->first();
        $input = $request->all();

        $validator = Validator::make($input, [
            'view_count' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $blog->view_count = $input['view_count'];
        $blog->save();

        return $this->sendResponse($blog, 'Blog updated successfully.');
    }

}
