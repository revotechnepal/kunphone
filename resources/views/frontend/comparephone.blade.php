@extends('frontend.layouts.app')
@push('styles')
    <!-- Algolia Search -->
    <link rel="stylesheet" href="{{ asset('frontend/css/algolia.css') }}">
@endpush
@section('content')

    @if (session('error'))
        <div class="row">
            <div class="col-sm-4 ml-auto message scroll">
                <div class="alert  alert-success alert-dismissible fade show" role="alert" style="background: darkred; color: white;">
                {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    <section class="ftco-section">
        <div class="container">
            <h3 class="billing-heading text-center mb-5">Compare your Phones</h3>
            <div class="row">
                <div class="col-md-2 text-center">
                    Your Phones to Compare
                </div>
                <div class="col-md-10">
                    <form action="{{route('comparephone')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-5">
                                <div class="aa-input-container" id="aa-input-container">
                                    <input type="search" id="aa-search-input" class="aa-input-search" placeholder="Search your phone" name="product1"
                                        autocomplete="off" required/>
                                    <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
                                        <path d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="aa-input-container" id="aa-input-container">
                                    <input type="search" id="aa-search-input1" class="aa-input-search" placeholder="Search your phone" name="product2"
                                        autocomplete="off" required/>
                                    <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
                                        <path d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
                                    </svg>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark">Start comparing</button>
                        </div>
                    </form>
                </div>
            </div>

            <h3 class="billing-heading text-center mb-5 mt-5">{{$product1->name}} VS {{$product2->name}}</h3>
            <div class="row">
                <div class="col-md-2 billing-heading">
                    Phones
                </div>
                <div class="col-md-10">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <p>{{$product1->name}}</p>
                            <img src="{{Storage::disk('uploads')->url($product1->modelimage)}}" alt="{{$product1->name}}" style="max-height: 100px;">
                        </div>
                        <div class="col-md-6">
                            <p>{{$product2->name}}</p>
                            <img src="{{Storage::disk('uploads')->url($product2->modelimage)}}" alt="{{$product2->name}}" style="max-height: 100px;">
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="billing-heading">Basic Info</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 20%; font-weight: bold">Sim:</th>
                        <td style="width: 40%">{{$product1->sim}}</td>
                        <td style="width: 40%">{{$product2->sim}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Brand:</th>
                        <td style="width: 40%">{{$product1->brand->name}}</td>
                        <td style="width: 40%">{{$product2->brand->name}}</td>
                    </tr>
                </table>
            </div>

            <h4 class="billing-heading">Design</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                    <th style="width: 20%; font-weight: bold">Height:</th>
                    <td style="width: 40%">{{$product1->productdesign->height}} inches</td>
                    <td style="width: 40%">{{$product2->productdesign->height}} inches</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Width:</th>
                        <td style="width: 40%">{{$product1->productdesign->width}} inches</td>
                        <td style="width: 40%">{{$product2->productdesign->width}} inches</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Thickness:</th>
                        <td style="width: 40%">{{$product1->productdesign->thickness}} inches</td>
                        <td style="width: 40%">{{$product2->productdesign->thickness}} inches</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Weight:</th>
                        <td style="width: 40%">{{$product1->productdesign->weight}} gms</td>
                        <td style="width: 40%">{{$product2->productdesign->weight}} gms</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Color:</th>
                        <td style="width: 40%">{{$product1->productdesign->color}}</td>
                        <td style="width: 40%">{{$product2->productdesign->color}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Build:</th>
                        <td style="width: 40%">{{$product1->productdesign->build}}</td>
                        <td style="width: 40%">{{$product2->productdesign->build}}</td>
                    </tr>
                </table>
            </div>

                <h4 class="billing-heading">Display</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                        <th style="width: 20%; font-weight: bold">Screen Size:</th>
                        <td style="width: 40%">{{$product1->productdisplay->screensize}} inches</td>
                        <td style="width: 40%">{{$product2->productdisplay->screensize}} inches</td>
                        </tr>
                        <tr>
                            <th style="width: 20%; font-weight: bold">Display Type:</th>
                            <td style="width: 40%">{{$product1->productdisplay->displaytype}}</td>
                            <td style="width: 40%">{{$product2->productdisplay->displaytype}}</td>
                        </tr>
                        <tr>
                            <th style="width: 20%; font-weight: bold">Resoluation:</th>
                            <td style="width: 40%">{{$product1->productdisplay->resolution}} pixels</td>
                            <td style="width: 40%">{{$product2->productdisplay->resolution}} pixels</td>
                        </tr>
                        <tr>
                            <th style="width: 20%; font-weight: bold">Pixel Density:</th>
                            <td style="width: 40%">{{$product1->productdisplay->pixeldensity}} ppi</td>
                            <td style="width: 40%">{{$product2->productdisplay->pixeldensity}} ppi</td>
                        </tr>
                        <tr>
                            <th style="width: 20%; font-weight: bold">Protection:</th>
                            <td style="width: 40%">{{$product1->productdisplay->protection}}</td>
                            <td style="width: 40%">{{$product2->productdisplay->protection}}</td>
                        </tr>
                        <tr>
                            <th style="width: 20%; font-weight: bold">Screen to Body Ratio:</th>
                            <td style="width: 40%">{{$product1->productdisplay->screentobodyratio}}%</td>
                            <td style="width: 40%">{{$product2->productdisplay->screentobodyratio}}%</td>
                        </tr>
                    </table>
                </div>

                <h4 class="billing-heading">Performance</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                    <tr>
                    <th style="width: 20%; font-weight: bold">GPU:</th>
                    <td style="width: 40%">{{$product1->productperformance->gpu}}</td>
                    <td style="width: 40%">{{$product2->productperformance->gpu}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Operating System (OS):</th>
                        <td style="width: 40%">{{$product1->productperformance->os}}</td>
                        <td style="width: 40%">{{$product2->productperformance->os}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Chipset GP:</th>
                        <td style="width: 40%">{{$product1->productperformance->chipsetgp}}</td>
                        <td style="width: 40%">{{$product2->productperformance->chipsetgp}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">CPU:</th>
                        <td style="width: 40%">{{$product1->productperformance->cpu}}</td>
                        <td style="width: 40%">{{$product2->productperformance->cpu}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Sensors:</th>
                        <td style="width: 40%">{{$product1->productperformance->sensors}}</td>
                        <td style="width: 40%">{{$product2->productperformance->sensors}}</td>
                    </tr>
                </table>
            </div>

            <h4 class="billing-heading">Storage</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                    <th style="width: 20%; font-weight: bold">RAM:</th>
                        <td style="width: 40%">
                            @foreach ($product1->productstorage as $storage)
                                {{$storage->ram}} <br>
                            @endforeach
                        <td style="width: 40%">
                            @foreach ($product2->productstorage as $storage)
                                {{$storage->ram}} <br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">ROM:</th>
                        <td style="width: 40%">
                            @foreach ($product1->productstorage as $storage)
                                {{$storage->rom}} <br>
                            @endforeach
                        </td>
                        <td style="width: 40%">
                            @foreach ($product2->productstorage as $storage)
                                {{$storage->rom}} <br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Expandable:</th>
                        <td style="width: 40%">
                            @foreach ($product1->productstorage as $storage)
                                @if ($storage->expandable == 'yes')
                                    Expandable <br>
                                    @else
                                    Not Expandable <br>
                                @endif
                            @endforeach
                        </td>
                        <td style="width: 40%">
                            @foreach ($product2->productstorage as $storage)
                                @if ($storage->expandable == 'yes')
                                    Expandable <br>
                                    @else
                                    Not Expandable <br>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>

            <h4 class="billing-heading">Back Camera</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                    <th style="width: 20%; font-weight: bold">Camera:</th>
                    <td style="width: 40%">{{$product1->productbackcamera->backcamera}}</td>
                    <td style="width: 40%">{{$product2->productbackcamera->backcamera}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Video:</th>
                        <td style="width: 40%">{{$product1->productbackcamera->backvideo}}</td>
                        <td style="width: 40%">{{$product2->productbackcamera->backvideo}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Features:</th>
                        <td style="width: 40%">{{$product1->productbackcamera->backfeatures}}</td>
                        <td style="width: 40%">{{$product2->productbackcamera->backfeatures}}</td>
                    </tr>
                </table>
            </div>

            <h4 class="billing-heading">Front Camera</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                    <th style="width: 20%; font-weight: bold">Camera:</th>
                    <td style="width: 40%">{{$product1->productfrontcamera->frontcamera}}</td>
                    <td style="width: 40%">{{$product2->productfrontcamera->frontcamera}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Video:</th>
                        <td style="width: 40%">{{$product1->productfrontcamera->frontvideo}}</td>
                        <td style="width: 40%">{{$product2->productfrontcamera->frontvideo}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Features:</th>
                        <td style="width: 40%">{{$product1->productfrontcamera->frontfeatures}}</td>
                        <td style="width: 40%">{{$product2->productfrontcamera->frontfeatures}}</td>
                    </tr>
                </table>
            </div>

            <h4 class="billing-heading">Sound</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                    <th style="width: 20%; font-weight: bold">HeadPhone Jack:</th>
                        <td style="width: 40%">
                            @if ($product1->productsound->headphone == 'yes')
                            Available
                            @else
                            Not Available
                            @endif
                        </td>
                        <td style="width: 40%">
                            @if ($product2->productsound->headphone == 'yes')
                            Available
                            @else
                            Not Available
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Loudspeakers:</th>
                        <td style="width: 40%">
                            @if ($product1->productsound->loudspeakers == 'yes')
                            Available
                            @else
                            Not Available
                            @endif
                        </td>
                        <td style="width: 40%">
                            @if ($product2->productsound->loudspeakers == 'yes')
                            Available
                            @else
                            Not Available
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Audio Features:</th>
                        <td style="width: 40%">{{$product1->productsound->audiofeatures}}</td>
                        <td style="width: 40%">{{$product2->productsound->audiofeatures}}</td>
                    </tr>
                </table>
            </div>

            <h4 class="billing-heading">Battery</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                    <th style="width: 20%; font-weight: bold">Capacity:</th>
                    <td style="width: 40%">{{$product1->productbattery->capacity}} mAh</td>
                    <td style="width: 40%">{{$product2->productbattery->capacity}} mAh</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">User Replaceable:</th>
                        <td style="width: 40%">
                            @if ($product1->productbattery->userreplaceable == 'replaceable')
                                Replaceable
                            @else
                                Non-Replaceable
                            @endif
                        </td>
                        <td style="width: 40%">
                            @if ($product2->productbattery->userreplaceable == 'replaceable')
                                Replaceable
                            @else
                                Non-Replaceable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Battery Type:</th>
                        <td style="width: 40%">{{$product1->productbattery->batterytype}}</td>
                        <td style="width: 40%">{{$product2->productbattery->batterytype}}</td>
                    </tr>
                </table>
            </div>

            <h4 class="billing-heading">Communication</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                    <th style="width: 20%; font-weight: bold">Bluetooth:</th>
                    <td style="width: 40%">{{$product1->productcommunication->bluetooth}} mAh</td>
                    <td style="width: 40%">{{$product2->productcommunication->bluetooth}} mAh</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">WLAN:</th>
                        <td style="width: 40%">{{$product1->productcommunication->wlan}}</td>
                        <td style="width: 40%">{{$product2->productcommunication->wlan}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">GPS:</th>
                        <td style="width: 40%">{{$product1->productcommunication->gps}}</td>
                        <td style="width: 40%">{{$product2->productcommunication->gps}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Radio:</th>
                        <td style="width: 40%">{{$product1->productcommunication->radio}}</td>
                        <td style="width: 40%">{{$product2->productcommunication->radio}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">USB:</th>
                        <td style="width: 40%">{{$product1->productcommunication->usb}}</td>
                        <td style="width: 40%">{{$product2->productcommunication->usb}}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%; font-weight: bold">Network Support:</th>
                        <td style="width: 40%">{{$product1->productcommunication->networksupport}}</td>
                        <td style="width: 40%">{{$product2->productcommunication->networksupport}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('frontend/js/algolia_phone1.js') }}"></script>
@endpush

