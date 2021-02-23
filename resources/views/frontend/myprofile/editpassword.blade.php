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
                                <h3 class="billing-heading mb-5 text-center">Change Password</h3>
                                <form action="{{route('updatepassword')}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <div class="row">
                                                <div class="col-md-3">
                                                    <label for="">Old Password:</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="password" class="form-control" name="oldpassword" placeholder="Old Password" required><br>
                                                    @error('oldpassword')
                                                        <p class="text-danger">{{$message}}</p>
                                                    @enderror
                                                    @if ($message = Session::get('oldfailure'))
                                                        <p class="alert alert-danger">{{ $message }}</p>
                                                    @endif
                                                </div>
                                        </div>

                                        <div class="row">
                                                <div class="col-md-3">
                                                    <label for="">New Password:</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="password" class="form-control" name="newpassword" placeholder="New Password" required> <br>
                                                    @error('newpassword')
                                                        <p class="text-danger">{{$message}}</p>
                                                    @enderror
                                                    @if ($message = Session::get('samepass'))
                                                            <p class="alert alert-danger">{{ $message }}</p>
                                                    @endif
                                                </div>
                                        </div>

                                        <div class="row">
                                                <div class="col-md-3">
                                                    <label for="">Confirm Password:</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="password" class="form-control" name="newpassword_confirmation" placeholder="Confirm new Password" required> <br>
                                                    @error('newpassword_confirmation')
                                                        <p class="text-danger">{{$message}}</p>
                                                    @enderror
                                                </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-9">
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
