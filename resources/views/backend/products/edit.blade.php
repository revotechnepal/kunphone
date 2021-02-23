@extends('backend.layouts.app')

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3">Edit Product => {{$product->name}}</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Basic Info</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="design-tab" data-toggle="tab" href="#design" role="tab" aria-controls="design" aria-selected="false">Design</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="display-tab" data-toggle="tab" href="#display" role="tab" aria-controls="display" aria-selected="false">Display</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="performance-tab" data-toggle="tab" href="#performance" role="tab" aria-controls="performance" aria-selected="false">Performance</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="storage-tab" data-toggle="tab" href="#storage" role="tab" aria-controls="storage" aria-selected="false">Storage</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="backcamera-tab" data-toggle="tab" href="#backcamera" role="tab" aria-controls="backcamera" aria-selected="false">Back Camera</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="frontcamera-tab" data-toggle="tab" href="#frontcamera" role="tab" aria-controls="frontcamera" aria-selected="false">Front Camera</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="sound-tab" data-toggle="tab" href="#sound" role="tab" aria-controls="sound" aria-selected="false">Sound</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="battery-tab" data-toggle="tab" href="#battery" role="tab" aria-controls="battery" aria-selected="false">Battery</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="communication-tab" data-toggle="tab" href="#communication" role="tab" aria-controls="communication" aria-selected="false">Communication</a>
                                </li>
                            </ul>
                            <form action="{{route('admin.product.update', $productstorage->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade active in" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Model Name: </label>
                                                        <input type="text" name="name" class="form-control" value="{{@old('name')?@old('name'):$product->name}}" placeholder="Enter Model Name">
                                                        @error('name')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="brand">Brand:</label>
                                                        <select class="form-control" name="brand_id" id="brand">
                                                            @foreach ($brands as $brand)

                                                                <option value="{{$brand->id}}"{{$brand->id == $product->brand_id?'selected':''}}>{{$brand->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('brand_id')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="sim">SIM: </label>
                                                        <input type="text" name="sim" class="form-control" value="{{@old('sim')?@old('sim'):$product->sim}}" placeholder="Ex: Hybrid Dual SIM (Nano-SIM, dual stand-by)">
                                                        @error('sim')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="modelimage">Upload Model Image: </label>
                                                        <input type="file" name="modelimage" class="form-control">
                                                        <p class="text-danger">Note*: If you want same image dont upload.</p>
                                                        @error('modelimage')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="design" role="tabpanel" aria-labelledby="design-tab">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="height">Height (inches): </label>
                                                        <input type="text" name="height" class="form-control" value="{{@old('height')?@old('height'):$product->productdesign->height}}" placeholder="Height">
                                                        @error('height')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="width">Width (inches): </label>
                                                        <input type="text" name="width" class="form-control" value="{{@old('width')?@old('width'):$product->productdesign->width}}" placeholder="Width">
                                                        @error('width')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="thickness">Thickness (inches): </label>
                                                        <input type="text" name="thickness" class="form-control" value="{{@old('thickness')?@old('thickness'):$product->productdesign->thickness}}" placeholder="Thickness">
                                                        @error('thickness')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="weight">Weight (gram): </label>
                                                        <input type="text" name="weight" class="form-control" value="{{@old('weight')?@old('weight'):$product->productdesign->weight}}" placeholder="Weight">
                                                        @error('weight')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="color">Color: </label>
                                                        <input type="text" name="color" class="form-control" value="{{@old('color')?@old('color'):$product->productdesign->color}}" placeholder="Color">
                                                        @error('color')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="build">Build: </label>
                                                        <input type="text" name="build" class="form-control" value="{{@old('build')?@old('build'):$product->productdesign->build}}" placeholder="Ex: Front glass, aluminum body">
                                                        @error('build')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="display" role="tabpanel" aria-labelledby="display-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="screensize">Screen Size (inches): </label>
                                                        <input type="text" name="screensize" class="form-control" value="{{@old('screensize')?@old('screensize'):$product->productdisplay->screensize}}" placeholder="Screensize">
                                                        @error('screensize')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="displaytype">Display Type: </label>
                                                        <input type="text" name="displaytype" class="form-control" value="{{@old('displaytype')?@old('displaytype'):$product->productdisplay->displaytype}}" placeholder="Ex: IPS LCD capacitive touchscreen">
                                                        @error('displaytype')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="resolution">Resolution (pixels): </label>
                                                        <input type="text" name="resolution" class="form-control" value="{{@old('resolution')?@old('resolution'):$product->productdisplay->resolution}}" placeholder="750 x 1334">
                                                        @error('resolution')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pixeldensity">Pixel Density (ppi): </label>
                                                        <input type="text" name="pixeldensity" class="form-control" value="{{@old('pixeldensity')?@old('pixeldensity'):$product->productdisplay->pixeldensity}}" placeholder="Ex: 326">
                                                        @error('pixeldensity')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="protection">Protection: </label>
                                                        <input type="text" name="protection" class="form-control" value="{{@old('protection')?@old('protection'):$product->productdisplay->protection}}" placeholder="Ex: Ion-strengthened glass, oleophobic coating">
                                                        @error('protection')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="screentobodyratio">Screen to Body Ratio (%): </label>
                                                        <input type="text" name="screentobodyratio" class="form-control" value="{{@old('screentobodyratio')?@old('screentobodyratio'):$product->productdisplay->screentobodyratio}}" placeholder="Ex: 65.60">
                                                        @error('screentobodyratio')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="performance" role="tabpanel" aria-labelledby="performance-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="gpu">GPU: </label>
                                                        <input type="text" name="gpu" class="form-control" value="{{@old('gpu')?@old('gpu'):$product->productperformance->gpu}}" placeholder="Ex: Mali-G51 MP4">
                                                        @error('gpu')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="os">Operating System (OS): </label>
                                                        <input type="text" name="os" class="form-control" value="{{@old('os')?@old('os'):$product->productperformance->os}}" placeholder="Ex: Android 8.1 (Oreo), upgradable to Android 9.0 (Pie) EMUI 9.0">
                                                        @error('os')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="chipsetgp">Chipset GP: </label>
                                                        <input type="text" name="chipsetgp" class="form-control" value="{{@old('chipsetgp')?@old('chipsetgp'):$product->productperformance->chipsetgp}}" placeholder="Ex: Hisilicon Kirin 710 (12 nm)">
                                                        @error('chipsetgp')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cpu">CPU: </label>
                                                        <input type="text" name="cpu" class="form-control" value="{{@old('cpu')?@old('cpu'):$product->productperformance->cpu}}" placeholder="Ex: Octa-core (4x2.2 GHz Cortex-A73 4x1.7 GHz Cortex-A53)">
                                                        @error('cpu')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="sensors">Sensors: </label>
                                                        <input type="text" name="sensors" class="form-control" value="{{@old('sensors')?@old('sensors'):$product->productperformance->sensors}}" placeholder="Ex: Fingerprint (rear-mounted), accelerometer, gyro, proximity, compass">
                                                        @error('sensors')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="storage" role="tabpanel" aria-labelledby="storage-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="ram">RAM: </label>
                                                        <input type="text" name="ram" class="form-control" value="{{@old('ram')?@old('ram'):$productstorage->ram}}" placeholder="RAM Info">
                                                        @error('ram')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="rom">ROM: </label>
                                                        <input type="text" name="rom" class="form-control" value="{{@old('rom')?@old('rom'):$productstorage->rom}}" placeholder="ROM Info">
                                                        @error('rom')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="expandable">Expandable:</label>
                                                        <select class="form-control" name="expandable" id="expandable">
                                                                <option value="yes" {{$productstorage->expandable == "yes"?'selected':''}}>Yes</option>
                                                                <option value="no" {{$productstorage->expandable == "no"?'selected':''}}>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="price">Price (Rs): </label>
                                                        <input type="text" name="price" class="form-control" value="{{@old('price')?@old('price'):$productstorage->price}}" placeholder="Price">
                                                        @error('price')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="backcamera" role="tabpanel" aria-labelledby="backcamera-tab">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="backcamera">Camera: </label>
                                                        <input type="text" name="backcamera" class="form-control" value="{{@old('backcamera')?@old('backcamera'):$product->productbackcamera->backcamera}}" placeholder="Ex: 16 MP, f/2.2|2 MP, depth sensor">
                                                        @error('backcamera')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="backvideo">Video: </label>
                                                        <input type="text" name="backvideo" class="form-control" value="{{@old('backvideo')?@old('backvideo'):$product->productbackcamera->backvideo}}" placeholder="Ex: 1080p30fps, 4K">
                                                        @error('backvideo')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="backfeatures">Features: </label>
                                                        <input type="text" name="backfeatures" class="form-control" value="{{@old('backfeatures')?@old('backfeatures'):$product->productbackcamera->backfeatures}}" placeholder="Ex: LED flash, HDR, panorama">
                                                        @error('backfeatures')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="frontcamera" role="tabpanel" aria-labelledby="frontcamera-tab">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="frontcamera">Camera: </label>
                                                        <input type="text" name="frontcamera" class="form-control" value="{{@old('frontcamera')?@old('frontcamera'):$product->productfrontcamera->frontcamera}}" placeholder="Ex: 16 MP, f/2.2|2 MP, depth sensor">
                                                        @error('frontcamera')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="frontvideo">Video: </label>
                                                        <input type="text" name="frontvideo" class="form-control" value="{{@old('frontvideo')?@old('frontvideo'):$product->productfrontcamera->frontvideo}}" placeholder="Ex: 1080p30fps, 4K">
                                                        @error('frontvideo')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="frontfeatures">Features: </label>
                                                        <input type="text" name="frontfeatures" class="form-control" value="{{@old('frontfeatures')?@old('frontfeatures'):$product->productfrontcamera->frontfeatures}}" placeholder="Ex: LED flash, HDR, panorama">
                                                        @error('frontfeatures')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="sound" role="tabpanel" aria-labelledby="sound-tab">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="headphone">Headphone Jack:</label>
                                                        <select class="form-control" name="headphone" id="headphone">
                                                                <option value="yes" {{$product->productsound->headphone == "yes"?'selected':''}}>Yes</option>
                                                                <option value="no" {{$product->productsound->headphone == "no"?'selected':''}}>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="loudspeakers">Loudspeakers:</label>
                                                        <select class="form-control" name="loudspeakers" id="loudspeakers">
                                                                <option value="yes" {{$product->productsound->loudspeakers == "yes"?'selected':''}}>Yes</option>
                                                                <option value="no" {{$product->productsound->loudspeakers == "no"?'selected':''}}>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="audiofeatures">Audio Features: </label>
                                                        <input type="text" name="audiofeatures" class="form-control" value="{{@old('audiofeatures')?@old('audiofeatures'):$product->productsound->audiofeatures}}" placeholder="Ex: Active noise cancellation with dedicated mic">
                                                        @error('audiofeatures')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="battery" role="tabpanel" aria-labelledby="battery-tab">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="capacity">Capacity (mAh): </label>
                                                        <input type="text" name="capacity" class="form-control" value="{{@old('capacity')?@old('capacity'):$product->productbattery->capacity}}" placeholder="Ex: 3340">
                                                        @error('capacity')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="userreplaceable">User Replaceable:</label>
                                                        <select class="form-control" name="userreplaceable" id="userreplaceable">
                                                                <option value="replaceable" {{$product->productbattery->userreplaceable == "replaceable"?'selected':''}}>Replaceable</option>
                                                                <option value="nonreplaceable" {{$product->productbattery->userreplaceable == "nonreplaceable"?'selected':''}}>Non-Replaceable</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="batterytype">Battery Type: </label>
                                                        <input type="text" name="batterytype" class="form-control" value="{{@old('batterytype')?@old('batterytype'):$product->productbattery->batterytype}}" placeholder="Ex: Li-Ion">
                                                        @error('batterytype')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="communication" role="tabpanel" aria-labelledby="communication-tab">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bluetooth">Bluetooth: </label>
                                                        <input type="text" name="bluetooth" class="form-control" value="{{@old('bluetooth')?@old('bluetooth'):$product->productcommunication->bluetooth}}" placeholder="Ex: 4.2, A2DP, LE, EDR, aptX HD">
                                                        @error('bluetooth')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="wlan">WLAN: </label>
                                                        <input type="text" name="wlan" class="form-control" value="{{@old('wlan')?@old('wlan'):$product->productcommunication->wlan}}" placeholder="Ex: Wi-Fi 802.11 b/g/n, Wi-Fi Direct, hotspot">
                                                        @error('wlan')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="gps">GPS: </label>
                                                        <input type="text" name="gps" class="form-control" value="{{@old('gps')?@old('gps'):$product->productcommunication->gps}}" placeholder="Ex: Yes, with A-GPS, GLONASS, BDS">
                                                        @error('gps')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="radio">Radio: </label>
                                                        <input type="text" name="radio" class="form-control" value="{{@old('radio')?@old('radio'):$product->productcommunication->radio}}" placeholder="Ex: FM Radio">
                                                        @error('radio')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="usb">USB: </label>
                                                        <input type="text" name="usb" class="form-control" value="{{@old('usb')?@old('usb'):$product->productcommunication->usb}}" placeholder="Ex: microUSB 2.0, USB On-The-Go">
                                                        @error('usb')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="networksupport">Network Support: </label>
                                                        <input type="text" name="networksupport" class="form-control" value="{{@old('networksupport')?@old('networksupport'):$product->productcommunication->networksupport}}" placeholder="Ex: GSM / HSPA / LTE">
                                                        @error('networksupport')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
