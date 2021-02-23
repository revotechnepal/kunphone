<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use DataTables;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Slider::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('images', function($row){

                    if(Slider::where('id', $row->id)->count() == 0){
                        $src = Storage::disk('uploads')->url('slider_images/noimage.png');
                    }
                    else{
                        $images = Slider::where('id', $row->id)->first();
                        $src = Storage::disk('uploads')->url($images->images);
                    }
                    $image = "<img src='$src' style='max-height:100px'>";
                    return $image;
                })
                ->addColumn('description', function($row){
                    $description = substr($row->description, 0, 16) .  '....';
                    return $description;
                })
                ->addColumn('action', function($row){
                    $editurl = route('admin.slider.edit', $row->id);
                    $deleteurl = route('admin.slider.destroy', $row->id);
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
                ->rawColumns(['images', 'description', 'action'])
                ->make(true);
        }

        return view('backend.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('backend.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'hashtitle' => 'required',
            'title' =>'required',
            'description'=>'required',
            'images' =>'required',
            'images.*' => 'mimes:jpg,jpeg,png'
        ]);

        $imagename = '';
        if($request->hasfile('images')){
            $images = $request->file('images');
            foreach($images as $image){
                $imagename = $image->store('slider_images', 'uploads');

                $slider = Slider::create([
                    'hashtitle' => $data['hashtitle'],
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'images' => $imagename,
                ]);
                $slider->save();
            }
        }
        return redirect()->route('admin.slider.index')->with('success', 'Slider Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::findorFail($id);
        return view('backend.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $data = $this->validate($request, [
            'hashtitle' => 'required',
            'title' =>'required',
            'description'=>'required',
        ]);

        $imagename = '';
        if($request->hasfile('images')){
            $images = $request->file('images');
            Storage::disk('uploads')->delete($slider->images);
            foreach($images as $image){
                $imagename = $image->store('slider_images', 'uploads');

                $slider->update([
                    'hashtitle' => $data['hashtitle'],
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'images' => $imagename,
                ]);
            }
        }
        else {
            $imagename = $slider->images;
            $slider->update([
                'hashtitle' => $data['hashtitle'],
                'title' => $data['title'],
                'description' => $data['description'],
                'images' => $imagename,
            ]);
        }
        return redirect()->route('admin.slider.index')->with('success', 'Slider Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        Storage::disk('uploads')->delete($slider->images);
        $slider->delete();
        return redirect()->route('admin.slider.index')->with('success', 'Slider Successfully Deleted');
    }
}
