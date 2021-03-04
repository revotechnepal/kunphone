<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\BlogCategory;
use Validator;
// use App\Http\Resources\Brand as BrandResource;

class BlogCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = BlogCategory::all();

        return $this->sendResponse($categories, 'Blog Categories retrieved successfully.');
    }

    public function show($id)
    {
        $blogCategory = BlogCategory::find($id);

        if (is_null($blogCategory)) {
            return $this->sendError('Blog Category not found.');
        }

        return $this->sendResponse($blogCategory, 'Blog Category retrieved successfully.');
    }

}
