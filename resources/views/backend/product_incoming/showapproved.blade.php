@extends('backend.layouts.app')

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3"> {{$productincoming->product->name}} ({{$productincoming->ram}} / {{$productincoming->rom}})  <a href="{{route('admin.productincoming.approved')}}" class="btn btn-primary btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i> View Approved Products</a> <a href="{{route('admin.productincoming.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i> View Unapproved Products</a></h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <h3>Owner Info</h3>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Full Name:</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p>{{$productincoming->fullname}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Contact no.:</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p>{{$productincoming->phone}}</p>
                                        </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p>Valued at.:</p>
                                            </div>
                                            <div class="col-md-9">
                                                <p>Rs. {{$productincoming->price}}</p>
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Confirmation:</p>
                                        </div>
                                        <div class="col-md-9">
                                            @if ($productincoming->is_approved == 0)
                                                <p>Not Approved</p>
                                            @elseif($productincoming->is_approved == 1)
                                                <p>Approved</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Exchange Code:</p>
                                        </div>
                                        <div class="col-md-9">
                                            <b>{{$productincoming->exchangecode}}</b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <h3>Images from owner</h3>
                                    <a href="http://phone.revonepal.com/public/uploads/{{$productincoming->frontimage}}" target="_blank"><img src="{{Storage::disk('uploads')->url($productincoming->frontimage)}}" alt="{{$productincoming->product->name}}" style="max-height: 100px;"></a>
                                    <a href="http://phone.revonepal.com/public/uploads/{{$productincoming->backimage}}" target="_blank"><img src="{{Storage::disk('uploads')->url($productincoming->backimage)}}" alt="{{$productincoming->product->name}}" style="max-height: 100px;"></a>
                                </div>
                            </div>

                            <h3>About Phone</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Able to make calls:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->makecalls == 'yes')
                                                <p>Yes</p>
                                            @elseif($productincoming->makecalls == 'no')
                                                <p>No</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Problems with your mobile screeen:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->phonescreen == 'yes')
                                                <p>Yes</p>
                                            @elseif($productincoming->phonescreen == 'no')
                                                <p>No</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Defects on your phone body:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->bodydefects == 'yes')
                                                <p>Yes</p>
                                            @elseif($productincoming->bodydefects == 'no')
                                                <p>No</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Time used:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{$productincoming->timeused}} {{$productincoming->duration}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Phone warranty:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->warrnaty == 'yes')
                                                <p>Under warranty</p>
                                            @elseif($productincoming->warrnaty == 'no')
                                                <p>Not Under warratny</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Available Accessories:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->return == 'originalcharger')
                                                <p>Original Charger</p>
                                            @elseif($productincoming->return == 'bill')
                                                <p>Purachase Bill</p>
                                            @elseif($productincoming->return == 'both')
                                                <p>Original Charger, Purachase Bill</p>
                                            @elseif($productincoming->return == 'none')
                                                <p>No available accessories</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <h3>Functional or Physical Problems</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Front camera:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->frontcamera == 'yes')
                                                <p>Working</p>
                                            @elseif($productincoming->frontcamera == 'no')
                                                <p>Not Working</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Back camera:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->backcamera == 'yes')
                                                <p>Working</p>
                                            @elseif($productincoming->backcamera == 'no')
                                                <p>Not Working</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Volume buttons:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->volumebuttons == 'yes')
                                                <p>Working</p>
                                            @elseif($productincoming->volumebuttons == 'no')
                                                <p>Not Working</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Touch screen:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->touchscreen == 'yes')
                                                <p>Working</p>
                                            @elseif($productincoming->touchscreen == 'no')
                                                <p>Not Working</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Battery condition:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->backcamera == 'yes')
                                                <p>Working</p>
                                            @elseif($productincoming->backcamera == 'no')
                                                <p>Not Working</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Volume sound(speakers):</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->volumesound == 'yes')
                                                <p>Working</p>
                                            @elseif($productincoming->volumesound == 'no')
                                                <p>Not Working</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Body color:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->colorfaded == 'yes')
                                                <p>Faded</p>
                                            @elseif($productincoming->colorfaded == 'no')
                                                <p>Not Faded</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Power button:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->powerbutton == 'yes')
                                                <p>Working</p>
                                            @elseif($productincoming->powerbutton == 'no')
                                                <p>Not Working</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Charging pot:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->chargingpot == 'yes')
                                                <p>Working</p>
                                            @elseif($productincoming->chargingpot == 'no')
                                                <p>Not Working</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <h3>Other Defects</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Others:</p>
                                        </div>
                                        <div class="col-md-8">
                                            @if ($productincoming->otherdefects == null)
                                                <p>No other defects</p>
                                            @else
                                                <p>{{$productincoming->otherdefects}}</p>
                                            @endif
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
