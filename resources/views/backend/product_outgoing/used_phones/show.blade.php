@extends('backend.layouts.app')

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3"> {{$product->name}} <a href="{{route('admin.productused.edit', $productoutgoing->id)}}" class="btn btn-success btn-sm"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a> <a href="{{route('admin.productused.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i> View All Outgoing Products</a></h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <h3>Basic Info</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Model Name:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->name}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Brand:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->brand->name}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>SIM:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->sim}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Phone Condition:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>
                                                @if ($productoutgoing->condition == 'new')
                                                    New Phone
                                                    @elseif($productoutgoing->condition == 'used')
                                                    Used Phone
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    
                                    @if ($productoutgoing->condition == 'new')

                                    @elseif($productoutgoing->condition == 'used')
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>SKU:</p>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{$productoutgoing->sku}}</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Accessories:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$productoutgoing->accessories}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Vendor:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$productoutgoing->vendor->name}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <h3>Uploaded Images</h3>
                                    @foreach ($productimages as $productimage)
                                        <a href="http://127.0.0.1:8000/uploads/{{$productimage->modelimage}}" target="_blank"><img src="{{Storage::disk('uploads')->url($productimage->modelimage)}}" alt="" style="max-height: 120px; padding: 3px 3px;"></a>
                                    @endforeach
                                </div>
                            </div>

                            <h3>Storage & Price</h3>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>RAM:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$productoutgoing->ram}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>ROM:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$productoutgoing->rom}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Price (Rs):</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$productoutgoing->price}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Design</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Height:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productdesign->height}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Width:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productdesign->width}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Thickness:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productdesign->thickness}}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Weight:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productdesign->weight}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Color:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$productoutgoing->color}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Build:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productdesign->build}}</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <h3>Display</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Screensize:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productdisplay->screensize}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Display Type:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productdisplay->displaytype}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Resolution:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productdisplay->resolution}}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Pixel Density:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productdisplay->pixeldensity}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Protection:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productdisplay->protection}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Screen to Body Ratio:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productdisplay->screentobodyratio}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Performance</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>GPU:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productperformance->gpu}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Operating System (OS):</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productperformance->os}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Chipset GP:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productperformance->chipsetgp}}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>CPU:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productperformance->cpu}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Sensors:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productperformance->sensors}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h3>Communication</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Bluetooth:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productcommunication->bluetooth}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>WLAN:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productcommunication->wlan}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>GPS:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productcommunication->gps}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Radio:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productcommunication->radio}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>USB:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productcommunication->usb}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Network Support:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productcommunication->networksupport}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Back Camera</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Camera:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productbackcamera->backcamera}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Video:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productbackcamera->backvideo}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Features:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productfrontcamera->frontfeatures}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h3>Front Camera</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Camera:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productfrontcamera->frontcamera}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Video:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productfrontcamera->frontvideo}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Features:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$product->productbackcamera->backfeatures}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Battery</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>Capacity:</p>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{$product->productbattery->capacity}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>User Replaceable:</p>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{$product->productbattery->userreplaceable}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>Battery Type:</p>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{$product->productbattery->batterytype}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>Sound</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>Headphone Jack:</p>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{$product->productsound->headphone}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>Loudspeakers:</p>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{$product->productsound->loudspeakers}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>Audio Features:</p>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{$product->productsound->audiofeatures}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
