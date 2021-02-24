<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;


class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = BlogCategory::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function($row){
                    $editurl = route('admin.blogcategory.edit', $row->id);
                    $deleteurl = route('admin.blogcategory.destroy', $row->id);
                    $csrf_token = csrf_token();
                    $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                           <form action='$deleteurl' method='POST' style='display:inline-block;'>
                            <input type='hidden' name='_token' value='$csrf_token'>
                            <input type='hidden' name='_method' value='DELETE' />
                               <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                           </form>
                           ";

                            return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.blogcategory.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.blogcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $this->validate($request, [
            'name'=>'required|string',
        ]);

        $existingcategory = BlogCategory::where('name', $data['name'])->first();
        if($existingcategory)
        {
            return redirect()->back()->with('failure', 'Category already exists');
        }

        $blogCategory = BlogCategory::create([
            'name'=>$data['name'],
            'slug'=>Str::slug($data['name']),
        ]);
        $blogCategory->save();
        return redirect()->route('admin.blogcategory.index')->with('success', 'Category added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function show(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $blogCategory = BlogCategory::findorfail($id);
        return view('backend.blogcategory.edit', compact('blogCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $blogCategory = BlogCategory::findorfail($id);
        $data = $this->validate($request, [
            'name'=>'required|string',
        ]);
        $existingcategory = BlogCategory::where('name', $data['name'])->first();
        if($existingcategory)
        {
            return redirect()->back()->with('failure', 'Category already exists');
        }

        $blogCategory->update([
            'name'=>$data['name'],
            'slug'=>Str::slug($data['name']),
        ]);

        return redirect()->route('admin.blogcategory.index')->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $blogCategory = BlogCategory::findorfail($id);

        $blogs = Blog::all();
        foreach ($blogs as $blog) {
            if(in_array($blogCategory->id, $blog->category))
            {
                return redirect()->back()->with('failure', 'Category is being used in blogs');
            }
        }
        $blogCategory->delete();

        return redirect()->route('admin.blogcategory.index')->with('success', 'Category Successfully Deleted');
    }
}
