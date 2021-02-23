@extends('frontend.layouts.app')
@section('content')

    @if (session('success'))
        <div class="row">
            <div class="col-sm-4 ml-auto message scroll">
                <div class="alert  alert-success alert-dismissible fade show" role="alert" style="background: seagreen; color: white;">
                {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-10 order-md-last">
                <div class="card">
                    <div class="card-header">
                        <h4 class="billing-heading text-center">Edit Address</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{route('updateaddress', $address->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <p class="text-danger">* fields are compulsory.</p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="firstname">First Name<span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="firstname" class="form-control" value="{{$address->firstname}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="lastname">Last Name<span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="lastname" class="form-control" value="{{$address->lastname}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-2">
                                                <label for="name">Phone<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="phone" class="form-control" value="{{$address->phone}}">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-2">
                                                <label for="name">Tole:<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="tole" class="form-control" value="{{$address->tole}}">
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-2">
                                                <label for="name">Full Address<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="address" class="form-control" value="{{$address->address}}">
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-2">
                                                <label for="name">Town:<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="town" class="form-control" value="{{$address->town}}">
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-2">
                                                <label for="name">Longitude</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="longitude" class="form-control" value="{{$address->longitude}}" placeholder="Longitude">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="name">Latitude</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="latitude" class="form-control" value="{{$address->latitude}}" placeholder="Latitude">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-10">
                                                <button type="submit" class="btn btn-primary py-3 px-5">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-2">
                    <div class="sidebar">
                        <div class="sidebar-box-2">
                            <h1 class="heading"><a href="{{route('myaccount')}}">My Account</a></h1>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <ul>
                                            <li><a href="{{route('myprofile')}}">My Profile</a></li>
                                            <li><a href="{{route('myorders')}}">My Orders</a></li>
                                            <li><a href="{{route('approvedforexchange')}}">My Approved Items</a></li>
                                            <li><a href="{{route('wishlist')}}">My Wishlist</a></li>
                                            <li><a href="{{route('myreviews')}}">My Reviews</a></li>
                                        </ul>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>

@endsection
