<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VendorBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Brand::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('description', function($row){
                    $description = substr($row->description, 0, 15) . '...';
                    return $description;
                })
                ->addColumn('logo', function($row){
                    $src = Storage::disk('uploads')->url($row->logo);

                    $image = "<img src='$src' style='max-height: 50px;'>";
                    return $image;
                })
                ->addColumn('action', function($row){
                    $editurl = route('vendor.brands.edit', $row->id);
                    $deleteurl = route('vendor.brands.destroy', $row->id);
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
                ->rawColumns(['description', 'logo', 'action'])
                ->make(true);
        }
        return view('backend.vendorside.brands.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.vendorside.brands.create');
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
        $data = $this->validate($request,[
            'name' => 'required',
            'logo' => 'required|mimes:png,jpg,jpeg',
            'description' => 'required'
        ]);

        $imagename = '';
        if($request->hasfile('logo')){
            $image = $request->file('logo');
                $imagename = $image->store('brand_logo', 'uploads');
                $brand = Brand::create([
                    'name'=>$data['name'],
                    'slug'=>Str::slug($data['name']),
                    'logo' => $imagename,
                    'description' => $data['description']
                ]);
                $brand->save();
        }

        return redirect()->route('vendor.brands.index')->with('success', 'Brand Successfully Added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $brand = Brand::findorfail($id);
        return view('backend.vendorside.brands.edit', compact('brand'));
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
        $brand = Brand::findorfail($id);
        $data = $this->validate($request,[
            'name' => 'required',
            'logo' => '',
            'description' => 'required'
        ]);

        $imagename = '';
        if($request->hasfile('logo')){
                $image = $request->file('logo');

                Storage::disk('uploads')->delete($brand->logo);
                $imagename = $image->store('brand_logo', 'uploads');

                $brand->update([
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'logo' => $imagename,
                    'description' => $data['description']
                ]);
        }
        else{
            $imagename = $brand->logo;
            $brand->update([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'logo' => $imagename,
                'description' => $data['description']
            ]);
        }

        return redirect()->route('vendor.brands.index')->with('success', 'Brand Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findorFail($id);
        $product = Product::where('brand_id', $id)->first();
        if ($product) {
            return redirect()->back()->with('failure', 'Cannot delete as there are products under this brand.');
        }else
        {
            Storage::disk('uploads')->delete($brand->logo);
            $brand->delete();
            return redirect()->back()->with('success', 'Brand Successfully Deleted');
        }
    }
}
