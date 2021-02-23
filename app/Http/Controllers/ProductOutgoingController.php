<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\ProductOutgoing;
use App\Models\ProductStorage;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductOutgoingController extends Controller
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
            
            if(Auth::user()->role_id == 4)
            {
                $vendor = Vendor::where('name', Auth::user()->name)->first();
                $data = ProductOutgoing::latest()->where('quantity', '>', 0)->where('condition', 'new')->where('vendor_id', $vendor->id)->get();
            }
            else
            {
                $data = ProductOutgoing::latest()->where('quantity', '>', 0)->where('condition', 'new')->get();   
            }

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('modelimage', function($row){
                        $image = Product::where('id', $row->product_id)->first();
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
                        if ($row->is_featured == null) {
                            $name = 'Not featured';
                        }elseif ($row->is_featured == 1) {
                            $name = 'Featured';
                        }
                        return $name;
                    })

                    ->addColumn('action', function($row){
                            $showurl = route('admin.productoutgoing.show', $row->id);
                            $editurl = route('admin.productoutgoing.edit', $row->id);
                            $deleteurl = route('admin.productoutgoing.destroy', $row->id);
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
                    ->rawColumns(['modelimage', 'featured', 'name', 'action'])
                    ->make(true);

        }
        return view('backend.product_outgoing.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendor = Vendor::latest()->get();
        return view('backend.product_outgoing.create', compact('vendor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $variantexists = 0;
        $data = $this->validate($request, [
            'name' => 'required',
            'quantity' => 'required',
            'color' => 'required',
            'accessories' => 'required',
            'ram' => 'required',
            'rom' => 'required',
            'price' => 'required',
            'featured' => '',
            'vendor' => 'required'
        ]);
        $product = Product::where('name', $data['name'])->first();

        if($product){
            $productstorage = ProductStorage::where('product_id', $product->id)->get();
            foreach($productstorage as $storage){
                if($data['ram'] == $storage->ram && $data['rom'] == $storage->rom){
                    $variantexists = 1;
                }
            }
            if($variantexists == 1){
                $exists = ProductOutgoing::where('product_id', $product->id)
                                ->where('ram', $data['ram'])
                                ->where('rom', $data['rom'])
                                ->where('price', $data['price'])
                                ->where('condition', 'new')
                                ->where('accessories', $data['accessories'])
                                ->where('color', $data['color'])
                                ->where('brand_id', $product->brand_id)->first();
                    if($exists){
                        $newquantity = $exists->quantity + $data['quantity'];
                        $featured = '';
                        if ($request['featured'] == null) {
                            $featured = 0;
                        } else {
                            $featured = 1;
                        }
                        $exists->update([
                            'product_id' => $product->id,
                            'ram' => $data['ram'],
                            'rom' => $data['rom'],
                            'quantity' => $newquantity,
                            'price' => $data['price'],
                            'condition' => 'new',
                            'accessories' => $data['accessories'],
                            'color' => $data['color'],
                            'brand_id' => $product->brand_id,
                            'is_featured' => $featured,
                            'vendor_id' => $data['vendor']
                        ]);
                        return redirect()->route('admin.productoutgoing.index')->with('success', 'Product Quantity Increased');
                    }
                    else{
                        $featured = '';
                        if ($request['featured'] == null) {
                            $featured = 0;
                        } else {
                            $featured = 1;
                        }
                        $productoutgoing = ProductOutgoing::create([
                            'product_id' => $product->id,
                            'ram' => $data['ram'],
                            'rom' => $data['rom'],
                            'quantity' => $data['quantity'],
                            'price' => $data['price'],
                            'condition' => 'new',
                            'accessories' => $data['accessories'],
                            'color' => $data['color'],
                            'brand_id' => $product->brand_id,
                            'is_featured' => $featured,
                            'vendor_id' => $data['vendor']
                        ]);

                        $productoutgoing->save();
                        return redirect()->route('admin.productoutgoing.index')->with('success', 'Product Added Successfully');
                    }
            }
            else{
                return redirect()->back()->with('error', 'No such variant exists');
            }

        }else{
            return redirect()->back()->with('error', 'No such product exists');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductOutgoing  $productOutgoing
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $productoutgoing = ProductOutgoing::where('id', $id)->first();
        $product = Product::where('id', $productoutgoing->product_id)->with('brand','productdesign',
                                                                        'productdisplay',
                                                                        'productperformance',
                                                                        'productbackcamera',
                                                                        'productfrontcamera',
                                                                        'productsound',
                                                                        'productbattery',
                                                                        'productcommunication')->first();

        return view('backend.product_outgoing.show', compact('productoutgoing', 'product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductOutgoing  $productOutgoing
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $vendor = Vendor::latest()->get();
        $productoutgoing = ProductOutgoing::where('id', $id)->first();
        $product = Product::where('id', $productoutgoing->product_id)->first();
        return view('backend.product_outgoing.edit', compact('productoutgoing', 'product', 'vendor'));
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
        $variantexists = 0;
        $productoutgoing = ProductOutgoing::where('id', $id)->first();
        $data = $this->validate($request, [
            'name' => 'required',
            'quantity' => 'required',
            'color' => 'required',
            'accessories' => 'required',
            'ram' => 'required',
            'rom' => 'required',
            'price' => 'required',
            'featured' => '',
            'vendor' => 'required'
        ]);
        $product = Product::where('name', $data['name'])->first();

        if($product){
            $productstorage = ProductStorage::where('product_id', $product->id)->get();
            foreach($productstorage as $storage){
                if($data['ram'] == $storage->ram && $data['rom'] == $storage->rom){
                    $variantexists = 1;
                }
            }
            if($variantexists == 1){
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
                    'quantity' => $data['quantity'],
                    'price' => $data['price'],
                    'condition' => 'new',
                    'accessories' => $data['accessories'],
                    'color' => $data['color'],
                    'brand_id' => $product->brand_id,
                    'is_featured' => $featured,
                    'vendor_id' => $data['vendor']
                ]);
                return redirect()->route('admin.productoutgoing.index')->with('success', 'Product Updated Successfully');
            }
            else{
                return redirect()->back()->with('error', 'No such variant exists');
            }

        }else{
            return redirect()->back()->with('error', 'No such product exists');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductOutgoing  $productOutgoing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $productoutgoing = ProductOutgoing::where('id', $id)->first();
        $productoutgoing->delete();
        return redirect()->route('admin.productoutgoing.index')->with('success', 'Product Deleted Successfully');
    }
}
