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
                        <h4 class="billing-heading text-center">My Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <b>Name:</b>
                                    </div>
                                    <div class="col-md-10">
                                        {{$user->name}}
                                    </div>
                                    <br>
                                    <div class="col-md-2">
                                        <b>Email:</b>
                                    </div>
                                    <div class="col-md-10">
                                        {{$user->email}}<br><br>
                                        <a href="{{route('editinfo')}}" class="btn btn-info py-3 px-3">Edit Info</a>&nbsp;
                                        <a href="{{route('sendotp')}}" class="btn btn-info py-3 px-3">Edit Password</a>
                                    </div>
                                </div>
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
