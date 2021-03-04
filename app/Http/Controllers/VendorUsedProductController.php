<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\ProductOutgoing;
use App\Models\ProductStorage;
use App\Models\ProductUsed;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class VendorUsedProductController extends Controller
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

            $vendor = Vendor::where('name', Auth::user()->name)->first();
            $data = ProductOutgoing::latest()->where('quantity', '>', 0)->where('condition', 'used')->where('vendor_id', $vendor->id)->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('modelimage', function($row){
                        $image = ProductUsed::where('used_product_id', $row->id)->first();
                        $src = Storage::disk('uploads')->url($image->modelimage);
                        $modelimage = "<img src='$src'style = 'max-height:100px'>";
                        return $modelimage;
                    })
                    ->addColumn('name', function($row){
                        $product = Product::where('id', $row->product_id)->first();
                        $name = $product->name;
                        return $name;
                    })

                    ->addColumn('featured', function($row){
                        if ($row->is_featured == 0) {
                            $name = 'Not featured';
                        }elseif ($row->is_featured == 1) {
                            $name = 'Featured';
                        }
                        return $name;
                    })

                    ->addColumn('action', function($row){
                            $showurl = route('vendor.productused.show', $row->id);
                            $editurl = route('vendor.productused.edit', $row->id);
                            $deleteurl = route('vendor.productused.destroy', $row->id);
                            $csrf_token = csrf_token();
                            $btn = "
                            <a href='$showurl' class='edit btn btn-info btn-sm'>Show</a>
                            <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                            <form action='$deleteurl' method='POST' style='display:inline-block;'>
                             <input type='hidden' name='_token' value='$csrf_token'>
                             <input type='hidden' name='_method' value='DELETE' />
                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                            ";

                            return $btn;
                    })
                    ->rawColumns([ 'modelimage', 'featured', 'name', 'action'])
                    ->make(true);

        }
        return view('backend.vendorside.product_outgoing.used_products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.vendorside.product_outgoing.used_products.create');
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
            'name' => 'required',
            'color' => 'required',
            'accessories' => 'required',
            'ram' => 'required',
            'rom' => 'required',
            'price' => 'required',
            'details' => '',
            'featured' => '',
            'modelimages' =>'required',
            'modelimages.*' => 'mimes:jpg,jpeg,png',
        ]);
        $product = Product::where('name', $data['name'])->first();
        $vendor = Vendor::where('name', Auth::user()->name)->first();

        $featured = '';
        if ($request['featured'] == null) {
            $featured = 0;
        } else {
            $featured = 1;
        }

        $prod = substr($data['name'], 0, 2);
        $rand = rand(10,100);
        $color = substr($data['color'], 0, 2);
        $sku = strtoupper($prod.$rand.$color.$rand);

        $productoutgoing = ProductOutgoing::create([
            'product_id' => $product->id,
            'ram' => $data['ram'],
            'rom' => $data['rom'],
            'quantity' => 1,
            'price' => $data['price'],
            'condition' => 'used',
            'accessories' => $data['accessories'],
            'color' => $data['color'],
            'brand_id' => $product->brand_id,
            'details' => $data['details'],
            'is_featured' => $featured,
            'sku' => $sku,
            'vendor_id' => $vendor->id
        ]);

        $imagename = '';
        if($request->hasfile('modelimages')){
            $images = $request->file('modelimages');
            foreach($images as $image){
                $imagename = $image->store('model_images', 'uploads');

                $productimage = ProductUsed::create([
                    'used_product_id' => $productoutgoing['id'],
                    'modelimage' => $imagename,
                ]);
                $productimage->save();
            }
        }
        $productoutgoing->save();
        return redirect()->route('vendor.productused.index')->with('success', 'Product Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductOutgoing  $productOutgoing
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productoutgoing = ProductOutgoing::where('id', $id)->first();
        $productimages = ProductUsed::where('used_product_id', $productoutgoing->id)->get();
        $product = Product::where('id', $productoutgoing->product_id)->with('brand','productdesign',
                                                                        'productdisplay',
                                                                        'productperformance',
                                                                        'productbackcamera',
                                                                        'productfrontcamera',
                                                                        'productsound',
                                                                        'productbattery',
                                                                        'productcommunication')->first();

        return view('backend.vendorside.product_outgoing.used_products.show', compact('productoutgoing', 'productimages', 'product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductOutgoing  $productOutgoing
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productoutgoing = ProductOutgoing::where('id', $id)->first();
        $product = Product::where('id', $productoutgoing->product_id)->first();
        return view('backend.vendorside.product_outgoing.used_products.edit', compact('productoutgoing', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductOutgoing  $productOutgoing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $productoutgoing = ProductOutgoing::where('id', $id)->first();
        $productimages = ProductUsed::where('used_product_id', $productoutgoing->id)->get();
        $data = $this->validate($request, [
            'name' => 'required',
            'color' => 'required',
            'accessories' => 'required',
            'ram' => 'required',
            'rom' => 'required',
            'price' => 'required',
            'featured' => '',
            'details' => '',
            'modelimages' =>'',
            'modelimages.*' => 'mimes:jpg,jpeg,png',
        ]);
        $product = Product::where('name', $data['name'])->first();
        $vendor = Vendor::where('name', Auth::user()->name)->first();

        $featured = '';
        if ($request['featured'] == null) {
            $featured = 0;
        } else {
            $featured = 1;
        }
        $productoutgoing->update([
            'product_id' => $product->id,
            'ram' => $data['ram'],
            'rom' => $data['rom'],
            'quantity' => 1,
            'price' => $data['price'],
            'condition' => 'used',
            'accessories' => $data['accessories'],
            'color' => $data['color'],
            'brand_id' => $product->brand_id,
            'is_featured' => $featured,
            'details' => $data['details'],
            'vendor_id' => $vendor->id
        ]);

        $imagename = '';
        if($request->hasfile('modelimages')){

            foreach ($productimages as $image) {
                Storage::disk('uploads')->delete($image->modelimage);
                $image->delete();
            }

            $images = $request->file('modelimages');
            foreach($images as $image){
                $imagename = $image->store('model_images', 'uploads');

                $productimage = ProductUsed::create([
                    'used_product_id' => $productoutgoing['id'],
                    'modelimage' => $imagename,
                ]);
                $productimage->save();
            }
        }

        return redirect()->route('vendor.productused.index')->with('success', 'Product Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductOutgoing  $productOutgoing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productoutgoing = ProductOutgoing::where('id', $id)->first();
        $productimages = ProductUsed::where('used_product_id', $productoutgoing->id)->get();
        foreach ($productimages as $image) {
            Storage::disk('uploads')->delete($image->modelimage);
            $image->delete();
        }
        $productoutgoing->delete();
        return redirect()->route('vendor.productused.index')->with('success', 'Product Deleted Successfully');
    }
}
