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
                        <h4 class="billing-heading text-center">My Account</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="billing-heading">Basic Info | <a href="{{route('myprofile')}}">Edit</a></h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <b>Name:</b>
                                    </div>
                                    <div class="col-md-9">
                                        {{$user->name}}
                                    </div>

                                    <div class="col-md-3">
                                        <b>Email:</b>
                                    </div>
                                    <div class="col-md-9">
                                        {{$user->email}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                
                                @if ($delieveryaddress == null)
                                <h4 class="billing-heading">My Address (Default)</h4>
                                    No default address.<br>
                                    Your default address will appear when you will order your first product.
                                @else
                                <h4 class="billing-heading">My Address (Default) | <a href="{{route('editaddress')}}">Edit</a></h4>
                                    {{$delieveryaddress->tole}}, {{$delieveryaddress->address}}<br>
                                    {{$delieveryaddress->town}} ({{$delieveryaddress->postcode}}), Nepal<br>
                                    +977 {{$delieveryaddress->phone}}
                                @endif

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
