<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductBackCamera;
use App\Models\ProductBattery;
use App\Models\ProductCommunication;
use App\Models\ProductDesign;
use App\Models\ProductDisplay;
use App\Models\ProductFrontCamera;
use App\Models\ProductOutgoing;
use App\Models\ProductPerformance;
use App\Models\ProductSound;
use App\Models\ProductStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug)
    {
        //
        $currentbrand = Brand::where('slug', $slug)->first();
        if ($request->ajax()) {

            $data = ProductStorage::latest()->with('product')->where('brand_id', $currentbrand->id)->orderBy('brand_id','ASC')->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('modelimage', function($row){
                        $image = Product::where('id', $row->product->id)->first();
                        $src = Storage::disk('uploads')->url($image->modelimage);
                        $modelimage = "<img src='$src'style = 'max-height:100px'>";
                        return $modelimage;
                    })
                    ->addColumn('name', function($row){
                        $name = $row->product->name;
                        return $name;
                    })
                    ->addColumn('ram', function($row){
                        // foreach($row->productstorage as $row){

                        $ram = $row->ram;
                        // $ram = $row->ram;
                        return $ram;
                    })
                    ->addColumn('rom', function($row){
                        $rom = $row->rom;
                        return $rom;
                    })
                    ->addColumn('price', function($row){
                        $price = $row->price;
                        return $price;
                    })
                    ->addColumn('action', function($row){
                            $showurl = route('admin.product.show', $row->id);
                            $editurl = route('admin.product.edit', $row->id);
                            $deleteurl = route('admin.product.destroy', $row->id);
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
                    ->rawColumns(['modelimage','name', 'brand' ,'ram', 'rom', 'price', 'action'])
                    ->make(true);

        }
        return view('backend.products.index', compact('currentbrand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $brands = Brand::all();
        return view('backend.products.create', compact('brands'));
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
            'brand_id' => 'required',
            'sim' => 'required',
            'modelimage' =>'required|mimes:png,jpg,jpeg',
            'height' => 'required|numeric|max:99.99',
            'width' => 'required|numeric|max:99.99',
            'thickness' => 'required|numeric|max:99.99',
            'weight' => 'required',
            'color' => 'required',
            'build' => 'required',
            'screensize' => 'required|numeric|max:99.99',
            'displaytype' => 'required',
            'resolution' => 'required',
            'pixeldensity' => 'required|numeric',
            'protection' => 'required',
            'screentobodyratio' => 'required',
            'gpu' => 'required',
            'os' => 'required',
            'chipsetgp' => 'required',
            'cpu' => 'required',
            'sensors' => 'required',
            'ram' => 'required',
            'rom' => 'required',
            'expandable' => 'required',
            'price'=> 'required',
            'backcamera' => 'required',
            'backvideo' => 'required',
            'backfeatures' => 'required',
            'frontcamera' => 'required',
            'frontvideo' => 'required',
            'frontfeatures' => 'required',
            'headphone' => 'required',
            'loudspeakers' => 'required',
            'audiofeatures' => 'required',
            'capacity' => 'required|numeric',
            'userreplaceable' => 'required',
            'batterytype' => 'required',
            'bluetooth' => 'required',
            'wlan' => 'required',
            'gps' => 'required',
            'radio' => 'required',
            'usb' => 'required',
            'networksupport' => 'required',
        ]);

        $imagename = '';
        if($request->hasfile('modelimage')){
            $image = $request->file('modelimage');

                $imagename = $image->store('product_images', 'uploads');

                $product = Product::create([
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'brand_id' => $data['brand_id'],
                    'sim' => $data['sim'],
                    'modelimage' => $imagename,
                ]);
                $product->save();
        }


        $latest_product = Product::latest()->first();

        $product_design = ProductDesign::create([
            'product_id' => $latest_product->id,
            'height' => $data['height'],
            'width' => $data['width'],
            'thickness' => $data['thickness'],
            'weight' => $data['weight'],
            'color' => $data['color'],
            'build' => $data['build'],
        ]);

        $product_display = ProductDisplay::create([
            'product_id' => $latest_product->id,
            'screensize' => $data['screensize'],
            'displaytype' => $data['displaytype'],
            'resolution' => $data['resolution'],
            'pixeldensity' => $data['pixeldensity'],
            'protection' => $data['protection'],
            'screentobodyratio' => $data['screentobodyratio'],
        ]);

        $product_performance = ProductPerformance::create([
            'product_id' => $latest_product->id,
            'gpu' => $data['gpu'],
            'os' => $data['os'],
            'chipsetgp' => $data['chipsetgp'],
            'cpu' => $data['cpu'],
            'sensors' => $data['sensors'],
        ]);

        $product_storage = ProductStorage::create([
            'product_id' => $latest_product->id,
            'ram' => $data['ram'],
            'rom' => $data['rom'],
            'expandable' => $data['expandable'],
            'price' => $data['price'],
            'brand_id' => $data['brand_id'],
        ]);

        $product_backcamera = ProductBackCamera::create([
            'product_id' => $latest_product->id,
            'backcamera' => $data['backcamera'],
            'backvideo' => $data['backvideo'],
            'backfeatures' => $data['backfeatures'],
        ]);

        $product_frontcamera = ProductFrontCamera::create([
            'product_id' => $latest_product->id,
            'frontcamera' => $data['frontcamera'],
            'frontvideo' => $data['frontvideo'],
            'frontfeatures' => $data['frontfeatures'],
        ]);

        $product_sound = ProductSound::create([
            'product_id' => $latest_product->id,
            'headphone' => $data['headphone'],
            'loudspeakers' => $data['loudspeakers'],
            'audiofeatures' => $data['audiofeatures'],
        ]);

        $product_battery = ProductBattery::create([
            'product_id' => $latest_product->id,
            'capacity' => $data['capacity'],
            'userreplaceable' => $data['userreplaceable'],
            'batterytype' => $data['batterytype'],
        ]);

        $product_communication = ProductCommunication::create([
            'product_id' => $latest_product->id,
            'bluetooth' => $data['bluetooth'],
            'wlan' => $data['wlan'],
            'gps' => $data['gps'],
            'radio' => $data['radio'],
            'usb' => $data['usb'],
            'networksupport' => $data['networksupport'],
        ]);

        $product_design->save();
        $product_display->save();
        $product_performance->save();
        $product_storage->save();
        $product_backcamera->save();
        $product_frontcamera->save();
        $product_sound->save();
        $product_battery->save();
        $product_communication->save();

        $currentbrand = Brand::where('id', $data['brand_id'])->first();

        return redirect()->route('admin.product.index', $currentbrand->slug)->with('success', 'Product Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productstorage = ProductStorage::where('id', $id)->first();
        $product = Product::where('id', $productstorage->product_id)->with('brand','productdesign',
                                                                        'productdisplay',
                                                                        'productperformance',
                                                                        'productbackcamera',
                                                                        'productfrontcamera',
                                                                        'productsound',
                                                                        'productbattery',
                                                                        'productcommunication')->first();

        return view('backend.products.show', compact('productstorage', 'product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $productstorage = ProductStorage::where('id', $id)->first();
        $product = Product::where('id', $productstorage->product_id)->with('productdesign',
                                                                        'productdisplay',
                                                                        'productperformance',
                                                                        'productbackcamera',
                                                                        'productfrontcamera',
                                                                        'productsound',
                                                                        'productbattery',
                                                                        'productcommunication')->first();
        $brands = Brand::all();
        return view('backend.products.edit', compact('productstorage', 'product', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $productstorage = ProductStorage::where('id', $id)->first();
        $product = Product::where('id', $productstorage->product_id)->first();
        $currentbrand = Brand::where('id', $product->brand_id)->first();
        $data = $this->validate($request, [
            'name' => 'required',
            'brand_id' => 'required',
            'sim' => 'required',
            'modelimage' =>'mimes:png,jpg',
            'height' => 'required|numeric|max:99.99',
            'width' => 'required|numeric|max:99.99',
            'thickness' => 'required|numeric|max:99.99',
            'weight' => 'required',
            'color' => 'required',
            'build' => 'required',
            'screensize' => 'required|numeric|max:99.99',
            'displaytype' => 'required',
            'resolution' => 'required',
            'pixeldensity' => 'required|numeric',
            'protection' => 'required',
            'screentobodyratio' => 'required',
            'gpu' => 'required',
            'os' => 'required',
            'chipsetgp' => 'required',
            'cpu' => 'required',
            'sensors' => 'required',
            'ram' => 'required',
            'rom' => 'required',
            'expandable' => 'required',
            'price'=> 'required',
            'backcamera' => 'required',
            'backvideo' => 'required',
            'backfeatures' => 'required',
            'frontcamera' => 'required',
            'frontvideo' => 'required',
            'frontfeatures' => 'required',
            'headphone' => 'required',
            'loudspeakers' => 'required',
            'audiofeatures' => 'required',
            'capacity' => 'required|numeric',
            'userreplaceable' => 'required',
            'batterytype' => 'required',
            'bluetooth' => 'required',
            'wlan' => 'required',
            'gps' => 'required',
            'radio' => 'required',
            'usb' => 'required',
            'networksupport' => 'required',
        ]);

        $imagename = '';
        if($request->hasfile('modelimage')){
                $image = $request->file('modelimage');

                Storage::disk('uploads')->delete($product->modelimage);
                $imagename = $image->store('product_images', 'uploads');

                $product->update([
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'brand_id' => $data['brand_id'],
                    'sim' => $data['sim'],
                    'modelimage' => $imagename,
                ]);
        }
        else{

            $imagename = $product->modelimage;
            $product->update([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'brand_id' => $data['brand_id'],
                'sim' => $data['sim'],
                'modelimage' => $imagename,
            ]);
        }

        $product_design = ProductDesign::where('product_id', $product->id)->first();
        $product_design->update([
            'product_id' => $product->id,
            'height' => $data['height'],
            'width' => $data['width'],
            'thickness' => $data['thickness'],
            'weight' => $data['weight'],
            'color' => $data['color'],
            'build' => $data['build'],
        ]);

        $product_display = ProductDisplay::where('product_id', $product->id)->first();
        $product_display->update([
            'product_id' => $product->id,
            'screensize' => $data['screensize'],
            'displaytype' => $data['displaytype'],
            'resolution' => $data['resolution'],
            'pixeldensity' => $data['pixeldensity'],
            'protection' => $data['protection'],
            'screentobodyratio' => $data['screentobodyratio'],
        ]);

        $product_performance = ProductPerformance::where('product_id', $product->id)->first();
        $product_performance->update([
            'product_id' => $product->id,
            'gpu' => $data['gpu'],
            'os' => $data['os'],
            'chipsetgp' => $data['chipsetgp'],
            'cpu' => $data['cpu'],
            'sensors' => $data['sensors'],
        ]);

        $productstorage->update([
            'product_id' => $product->id,
            'ram' => $data['ram'],
            'rom' => $data['rom'],
            'expandable' => $data['expandable'],
            'price' => $data['price'],
            'brand_id' => $data['brand_id'],
        ]);

        $product_backcamera = ProductBackCamera::where('product_id', $product->id)->first();
        $product_backcamera->update([
            'product_id' => $product->id,
            'backcamera' => $data['backcamera'],
            'backvideo' => $data['backvideo'],
            'backfeatures' => $data['backfeatures'],
        ]);

        $product_frontcamera = ProductFrontCamera::where('product_id', $product->id)->first();
        $product_frontcamera->update([
            'product_id' => $product->id,
            'frontcamera' => $data['frontcamera'],
            'frontvideo' => $data['frontvideo'],
            'frontfeatures' => $data['frontfeatures'],
        ]);

        $product_sound = ProductSound::where('product_id', $product->id)->first();
        $product_sound->update([
            'product_id' => $product->id,
            'headphone' => $data['headphone'],
            'loudspeakers' => $data['loudspeakers'],
            'audiofeatures' => $data['audiofeatures'],
        ]);

        $product_battery = ProductBattery::where('product_id', $product->id)->first();
        $product_battery->update([
            'product_id' => $product->id,
            'capacity' => $data['capacity'],
            'userreplaceable' => $data['userreplaceable'],
            'batterytype' => $data['batterytype'],
        ]);

        $product_communication = ProductCommunication::where('product_id', $product->id)->first();
        $product_communication->update([
            'product_id' => $product->id,
            'bluetooth' => $data['bluetooth'],
            'wlan' => $data['wlan'],
            'gps' => $data['gps'],
            'radio' => $data['radio'],
            'usb' => $data['usb'],
            'networksupport' => $data['networksupport'],
        ]);

        return redirect()->route('admin.product.index', $currentbrand->slug)->with('success', 'Product Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $productstorage = ProductStorage::where('id', $id)->first();
        $currentproduct = Product::where('id', $productstorage->product_id)->first();
        $currentbrand = Brand::where('id', $currentproduct->brand_id)->first();
        $productoutgoing = ProductOutgoing::where('product_id', $currentproduct->id)->where('ram', $productstorage->ram)->where('rom', $productstorage->rom)->get();
        if(count($productoutgoing) > 0){
            foreach($productoutgoing as $outproduct){
            $outproduct->delete();
            }
        }
        $totalproductstorage = ProductStorage::where('product_id', $productstorage->product_id)->get();
        $remainingafterdel = count($totalproductstorage) - 1;
        if($remainingafterdel == 0){
            $product = Product::where('id', $productstorage->product_id)->first();
            $productdisplay = ProductDisplay::where('product_id', $product->id)->first();
            $productdesign = ProductDesign::where('product_id', $product->id)->first();
            $productperformance = ProductPerformance::where('product_id', $product->id)->first();
            $productBackCamera = ProductBackCamera::where('product_id', $product->id)->first();
            $productFrontCamera = ProductFrontCamera::where('product_id', $product->id)->first();
            $productSound = ProductSound::where('product_id', $product->id)->first();
            $productBattery = ProductBattery::where('product_id', $product->id)->first();
            $productCommunication = ProductCommunication::where('product_id', $product->id)->first();

            $product->delete();
            $productdisplay->delete();
            $productdesign->delete();
            $productperformance->delete();
            $productBackCamera->delete();
            $productFrontCamera->delete();
            $productSound->delete();
            $productBattery->delete();
            $productCommunication->delete();
            $productstorage->delete();
            Storage::disk('uploads')->delete($product->modelimage);

            return redirect()->route('admin.product.index', $currentbrand->slug)->with('success', 'Product Deleted Successfully');
        }
        else{
            $productstorage->delete();
            return redirect()->route('admin.product.index', $currentbrand->slug)->with('success', 'Product Variant Deleted Successfully');
        }

    }

    public function variant($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $productstorage = ProductStorage::where('product_id', $product->id)->get();
        return view('backend.products.variant', compact('product', 'productstorage'));
    }

    public function addvariant(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();
        $currentbrand = Brand::where('id', $product->brand_id)->first();
        $data = $this->validate($request,[
            'ram' => 'required',
            'rom' => 'required',
            'expandable' => 'required',
            'price' => 'required'
        ]);
        $productVariant = ProductStorage::create([
            'product_id' => $product->id,
            'ram' => $data['ram'],
            'rom' => $data['rom'],
            'expandable' => $data['expandable'],
            'price' => $data['price'],
            'brand_id' => $product->brand_id,
        ]);
        $productVariant->save();
        return redirect()->route('admin.product.index', $currentbrand->slug)->with('success', 'Product Variant Added Successfully.');
    }
}
