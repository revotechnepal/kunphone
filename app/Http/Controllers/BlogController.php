<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogImages;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
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
            $data = Blog::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    $image = Blog::where('id', $row->id)->first();
                    $src = Storage::disk('uploads')->url($image->image);

                    $image = "<img src='$src' style='max-height:100px'>";
                    return $image;
                })
                ->addColumn('category', function ($row) {
                    $categories = $row->category;
                    $category = '';
                    foreach ($categories as $cat) {
                        $categoryname = BlogCategory::where('id', $cat)->first();
                        $category .= '<span class="badge bg-green" style="background-color: green";>' . $categoryname->name . '</span>' . ' ';
                    }
                    return $category;
                })
                ->addColumn('date', function ($row) {
                    $date = date('Y/m/d h:m a', strtotime($row->date));
                    return $date;
                })
                ->addColumn('action', function($row){
                    $showurl = route('admin.blog.show', $row->id);
                    $editurl = route('admin.blog.edit', $row->id);
                    $deleteurl = route('admin.blog.destroy', $row->id);
                    $csrf_token = csrf_token();
                    $btn = "<a href='$showurl' class='edit btn btn-warning btn-sm'>Show</a>
                            <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                           <form action='$deleteurl' method='POST' style='display:inline-block;'>
                            <input type='hidden' name='_token' value='$csrf_token'>
                            <input type='hidden' name='_method' value='DELETE' />
                               <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                           </form>
                           ";

                            return $btn;
                })
                ->rawColumns(['image', 'category', 'date', 'action'])
                ->make(true);
        }
        return view('backend.blogs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $blogCategories = BlogCategory::latest()->get();
        $images = BlogImages::where('user_id',Auth::user()->id)->where('blog_id',0)->get();
        return view('backend.blogs.create', compact('blogCategories', 'images'));
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

        if ($request->ajax()) {
            $this->validate($request,[
                'file'=>'required|max:500'
            ]);

            $name = $request->file->store('blog_images','uploads');

            $i = new BlogImages;
            $i->location = $name;
            $i->blog_id = 0;
            $i->user_id = Auth::user()->id;
            $i->title = '';
            $i->save();

            return response()->json(['url'=>Storage::disk('uploads')->url($name),'id'=>$i->id]);
        };

        $data = $this->validate($request, [
            'title'=>'required',
            'image'=>'required|mimes:png,jpg,jpeg',
            'category'=>'required',
            'date'=>'required',
            'details'=>'required',
        ]);

        $imagename = '';
        if($request->hasfile('image')){
            $image = $request->file('image');
                $imagename = $image->store('blog_photo', 'uploads');
                $blog = Blog::create([
                    'title'=>$data['title'],
                    'image'=>$imagename,
                    'category'=>$data['category'],
                    'date'=>$data['date'],
                    'details'=>$data['details'],
                ]);
                $blog->save();


                $images = BlogImages::where('user_id',Auth::user()->id)->where('blog_id',0)->get();
            foreach($images as $image){
                $image->title = $data['title'];
                $image->blog_id = $blog->id;
                $image->save();
            }
        }

        return redirect()->route('admin.blog.index')->with('success', 'Blog Created Successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $blog = Blog::findorfail($id);

        $categories = $blog->category;
        $category = '';
        foreach ($categories as $cat) {
            $categoryname = BlogCategory::where('id', $cat)->first();
            $category .=  $categoryname->name. ', ';
        }

        return view('backend.blogs.show', compact('blog', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $blog = Blog::findorfail($id);
        $blogCategories = BlogCategory::latest()->get();
        return view('backend.blogs.edit', compact('blog', 'blogCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $blogImages = BlogImages::where('blog_id', $id)->get();
        if(count($blogImages) > 0)
        {
            foreach ($blogImages as $blogImage) {
                Storage::disk('uploads')->delete($blogImage->location);
                $blogImage->delete();
            }
        }

        if ($request->ajax()) {
            $this->validate($request,[
                'file'=>'required|max:500'
            ]);

            $name = $request->file->store('blog_images','uploads');

            $i = new BlogImages;
            $i->location = $name;
            $i->blog_id = 0;
            $i->user_id = Auth::user()->id;
            $i->title = '';
            $i->save();

            return response()->json(['url'=>Storage::disk('uploads')->url($name),'id'=>$i->id]);

        };

        $blog = Blog::findorfail($id);
        $data = $this->validate($request, [
            'title'=>'required',
            'category'=>'required',
            'date'=>'required',
            'details'=>'required',
        ]);

            $image_name = '';
            if ($request->hasfile('image')) {
                $blogimage = $request->file('image');

                Storage::disk('uploads')->delete($blog->image);
                $image_name = $blogimage->store('blog_photo', 'uploads');
            } else {
                $image_name = $blog->image;
            }

        $blog->update([
            'title'=>$data['title'],
            'image'=>$image_name,
            'category'=>$data['category'],
            'date'=>$data['date'],
            'details'=>$data['details'],
        ]);

        $images = BlogImages::where('user_id',Auth::user()->id)->where('blog_id',0)->get();
            foreach($images as $image){
                $image->title = $data['title'];
                $image->blog_id = $blog->id;
                $image->save();
            }

        return redirect()->route('admin.blog.index')->with('success', 'Blog Contents Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $blog = Blog::findorfail($id);
        Storage::disk('uploads')->delete($blog->image);
        $blog->delete();

        $blogImages = BlogImages::where('blog_id', $id)->get();
        if(count($blogImages) > 0)
        {
            foreach ($blogImages as $blogImage) {
                Storage::disk('uploads')->delete($blogImage->location);
                $blogImage->delete();
            }
        }

        return redirect()->back()->with('success', 'Blog Deleted Successfully');
    }

}
