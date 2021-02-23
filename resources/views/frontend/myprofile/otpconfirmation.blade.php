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
                        <div class="row text-center">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <h3 class="billing-heading mb-3">Edit Info</h3>
                                <form action="{{route('otpvalidation')}}" method="get">
                                    @csrf
                                    <div class="form-group">
                                        <p>We have sent a verification code to your registered mail. Please enter the code below.
                                            Code expires in 5 minutes.
                                        </p>
                                        <input type="text" name="otpcode" class="form-control" placeholder="Enter your code." required>
                                        @error('otpcode')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                        <br>
                                        <button type="submit" name="submit" class="btn btn-success py-3 px-3">Confirm</button>
                                        <a href="{{route('sendotp')}}" class="btn btn-info py-3 px-3">Resend</a>
                                    </div>

                                </form>
                            </div>
                            <div class="col-md-3"></div>
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
