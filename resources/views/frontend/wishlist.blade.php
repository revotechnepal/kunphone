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
                        <h4 class="billing-heading text-center">Wishlists of {{Auth::user()->name}}</h4>

                    </div>
                    <div class="card-body">
                        @if ($wishlists->count()<1)
                                <p>Empty Wishlist</p>
                            @else
                        <div class="table-responsive">
                            <table id="myTable" class="table">
                                <thead>
                                    <tr>
                                        <th style="font-weight: bold;">Product Image</th>
                                        <th style="font-weight: bold;">Product Info</th>
                                        <th style="font-weight: bold;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wishlists as $wishlist)
                                        <tr>
                                            @php
                                                $outgoingproduct = DB::table('product_outgoings')->where('id', $wishlist->product_id)->first();
                                                $product = DB::table('products')->where('id', $outgoingproduct->product_id)->first();
                                            @endphp
                                            <td>
                                                <img src="{{Storage::disk('uploads')->url($product->modelimage)}}" style="max-height:100px;" alt="">
                                                    @if ($outgoingproduct->condition == 'used')
                                                        <p class="mt-2">(Used Phone)<br>
                                                        (SKU: {{$outgoingproduct->sku}})</p>
                                                    @else
                                                        <p class="mt-2">(New Phone)</p>
                                                    @endif
                                            </td>
                                            <td>
                                                <b>{{$product->name}}</b><br>
                                                ( {{$outgoingproduct->ram}} / {{$outgoingproduct->rom}} )
                                            </td>
                                            <td><a href="{{route('product', ['id' => $outgoingproduct->id, 'slug' => $product->slug])}}" class="btn btn-success py-2 px-4">View</a>
                                                <a href="{{route('remove', $wishlist->id)}}" class="btn btn-danger py-2 px-4">Remove</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
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
