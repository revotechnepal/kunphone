@extends('frontend.layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{asset('frontend/StarRating/min/jquery.rateyo.min.css')}}"/>
@endpush
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
                        <h4 class="billing-heading text-center">My Orders</h4>
                    </div>
                    <div class="card-body">
                        @if ($orders->count() == 0)
                            You have no orders.
                        @else
                        <div class="table-responsive">
                            <table id="myTable" class="table">
                                <thead>
                                    <tr>
                                        <th style="font-weight: bold;">Order Id</th>
                                        <th style="font-weight: bold;">Ordered Date</th>
                                        <th style="font-weight: bold;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>{{date('F d, Y', strtotime($order->created_at))}}</td>
                                            <td>
                                                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong{{$order->id}}">View Order</a>

                                                    <div class="modal fade" id="exampleModalLong{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                        <div class="modal-dialog" role="document" style="max-width: 900px;">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">Order Id -> {{$order->id}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table" id="myTable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="font-weight: bold;">Model Image</th>
                                                                                    <th style="font-weight: bold;">Model Name</th>
                                                                                    <th style="font-weight: bold;">Order Status</th>
                                                                                    <th style="font-weight: bold;">Quantity</th>
                                                                                    <th style="font-weight: bold;">Unit Price</th>
                                                                                    <th style="font-weight: bold;">Total</th>
                                                                                    <th style="font-weight: bold;">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @php
                                                                                    $order_id = $order->id;
                                                                                    $orderedproducts = DB::table('ordered_products')->where('order_id', $order_id)->get();
                                                                                @endphp
                                                                                @foreach ($orderedproducts as $productorder)
                                                                                <tr>
                                                                                        @php
                                                                                            $outgoingproduct = DB::table('product_outgoings')->where('id', $productorder->product_id)->first();
                                                                                            $product = DB::table('products')->where('id', $outgoingproduct->product_id)->first();
                                                                                        @endphp
                                                                                        <td>
                                                                                            <img src="{{Storage::disk('uploads')->url($product->modelimage)}}" alt="" style="max-height: 100px;">
                                                                                            {{-- @if ($outgoingproduct->condition == 'used')
                                                                                                <p class="mt-2">(Used Phone)</p>
                                                                                            @else
                                                                                                <p class="mt-2">(New Phone)</p>
                                                                                            @endif --}}
                                                                                        </td>
                                                                                        <td>
                                                                                            <b>{{$product->name}}</b>
                                                                                            @if ($outgoingproduct->condition == 'used')
                                                                                                <p class="mt-2">(Used Phone)<br>
                                                                                                (SKU: {{$outgoingproduct->sku}})</p>
                                                                                            @else
                                                                                                <p class="mt-2">(New Phone)</p>
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>
                                                                                            @php
                                                                                                $status = DB::table('order_statuses')->where('id', $productorder->order_status_id)->first();
                                                                                            @endphp
                                                                                            {{$status->status}}
                                                                                        </td>
                                                                                        <td>{{$productorder->quantity}}</td>
                                                                                        <td>{{$productorder->price}}</td>
                                                                                        <td>
                                                                                            {{$productorder->quantity * $productorder->price}}
                                                                                        </td>
                                                                                        @if($status->status == "Delivered")
                                                                                        <td>
                                                                                            @php
                                                                                                $user_id = Auth::user()->id;
                                                                                                $userreview = DB::table('reviews')->where('user_id', $user_id)->where('product_id', $productorder->product_id)->first();
                                                                                            @endphp

                                                                                            @if (empty($userreview))
                                                                                                <button type="button" class="btn btn-info py-3 px-4" data-toggle="modal" data-target="#reviewModal{{$order->id . $productorder->product_id}}">Add Review</button>

                                                                                                <div class="modal fade" id="reviewModal{{$order->id . $productorder->product_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog" role="document">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="reviewModalLabel">Leave a Review</h5>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                            <span aria-hidden="true">&times;</span>
                                                                                                        </button>
                                                                                                        </div>
                                                                                                        <form action="{{route('addreview', $productorder->product_id)}}" method="POST">
                                                                                                            @csrf
                                                                                                            @method('POST')
                                                                                                            <div class="modal-body">
                                                                                                                    <div class="form-group">
                                                                                                                        <div class="container d-flex justify-content-center">
                                                                                                                            <div class="row">
                                                                                                                                <div class="col-md-2">
                                                                                                                                </div>
                                                                                                                                <div class="col-md-9">
                                                                                                                                    <div class="stars">
                                                                                                                                        <input class="star star-5" id="star-5{{$order->id . $productorder->product_id}}" type="radio" name="star" value="5"/>
                                                                                                                                        <label class="star star-5" for="star-5{{$order->id . $productorder->product_id}}"></label>
                                                                                                                                        <input class="star star-4" id="star-4{{$order->id . $productorder->product_id}}" type="radio" name="star" value="4"/>
                                                                                                                                        <label class="star star-4" for="star-4{{$order->id . $productorder->product_id}}"></label>
                                                                                                                                        <input class="star star-3" id="star-3{{$order->id . $productorder->product_id}}" type="radio" name="star" value="3"/>
                                                                                                                                        <label class="star star-3" for="star-3{{$order->id . $productorder->product_id}}"></label>
                                                                                                                                        <input class="star star-2" id="star-2{{$order->id . $productorder->product_id}}" type="radio" name="star" value="2"/>
                                                                                                                                        <label class="star star-2" for="star-2{{$order->id . $productorder->product_id}}"></label>
                                                                                                                                        <input class="star star-1" id="star-1{{$order->id . $productorder->product_id}}" type="radio" name="star" value="1"/>
                                                                                                                                        <label class="star star-1" for="star-1{{$order->id . $productorder->product_id}}"></label>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-12">
                                                                                                                                    <input type="hidden" name="product_id" value="{{$productorder->product_id}}">
                                                                                                                                    <textarea rows="4" cols="40" class="form-control" placeholder="Describe your experience (optional)" name="ratingdescription"></textarea>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="submit" class="btn btn-primary py-3 px-4">Submit</button>
                                                                                                                <button type="button" class="btn btn-secondary py-3 px-4" data-dismiss="modal">Close</button>
                                                                                                            </div>
                                                                                                        </form>
                                                                                                    </div>
                                                                                                    </div>
                                                                                                </div>

                                                                                            @else
                                                                                                <button type="button" class="btn btn-secondary py-3 px-4" data-toggle="modal" data-target="#editreviewModal{{$order->id . $productorder->product_id}}">Edit Review</button>
                                                                                                <div class="modal fade" id="editreviewModal{{$order->id . $productorder->product_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog" role="document">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="editreviewModalLabel">Update your Review</h5>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                            <span aria-hidden="true">&times;</span>
                                                                                                        </button>
                                                                                                        </div>
                                                                                                        <form action="{{route('updatereview', $userreview->id)}}" method="POST">
                                                                                                            @csrf
                                                                                                            @method('PUT')
                                                                                                            <div class="modal-body">
                                                                                                                    <div class="form-group">
                                                                                                                        <div class="container d-flex justify-content-center">
                                                                                                                            <div class="row">
                                                                                                                                <div class="col-md-2">
                                                                                                                                </div>
                                                                                                                                <div class="col-md-9">
                                                                                                                                    <div class="stars">
                                                                                                                                        <input class="star star-5" id="starrating-5{{$order->id . $productorder->product_id}}" type="radio" name="star" value="5"

                                                                                                                                        @if ($userreview->rating == 5)
                                                                                                                                            checked
                                                                                                                                        @endif />
                                                                                                                                        <label class="star star-5" for="starrating-5{{$order->id . $productorder->product_id}}"></label>
                                                                                                                                        <input class="star star-4" id="starrating-4{{$order->id . $productorder->product_id}}" type="radio" name="star" value="4"

                                                                                                                                        @if ($userreview->rating == 4)
                                                                                                                                            checked
                                                                                                                                        @endif />
                                                                                                                                        <label class="star star-4" for="starrating-4{{$order->id . $productorder->product_id}}"></label>
                                                                                                                                        <input class="star star-3" id="starrating-3{{$order->id . $productorder->product_id}}" type="radio" name="star" value="3"

                                                                                                                                        @if ($userreview->rating == 3)
                                                                                                                                            checked
                                                                                                                                        @endif />
                                                                                                                                        <label class="star star-3" for="starrating-3{{$order->id . $productorder->product_id}}"></label>
                                                                                                                                        <input class="star star-2" id="starrating-2{{$order->id . $productorder->product_id}}" type="radio" name="star" value="2"

                                                                                                                                        @if ($userreview->rating == 2)
                                                                                                                                            checked
                                                                                                                                        @endif />
                                                                                                                                        <label class="star star-2" for="starrating-2{{$order->id . $productorder->product_id}}"></label>
                                                                                                                                        <input class="star star-1" id="starrating-1{{$order->id . $productorder->product_id}}" type="radio" name="star" value="1"

                                                                                                                                        @if ($userreview->rating == 1)
                                                                                                                                            checked
                                                                                                                                        @endif />
                                                                                                                                        <label class="star star-1" for="starrating-1{{$order->id . $productorder->product_id}}"></label>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-12">
                                                                                                                                    <textarea rows="4" cols="40" class="form-control" placeholder="Describe your experience (optional)" name="ratingdescription">{{$userreview->description}}</textarea>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="submit" class="btn btn-primary py-3 px-4">Submit</button>
                                                                                                                <button type="button" class="btn btn-secondary py-3 px-4" data-dismiss="modal">Close</button>
                                                                                                            </div>
                                                                                                        </form>
                                                                                                    </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        </td>

                                                                                        @elseif ($productorder->order_status_id == 1 || $productorder->order_status_id == 2 || $productorder->order_status_id == 3)
                                                                                            <td><a href="#" class="btn btn-danger py-3 px-4"  data-toggle="modal" data-target="#cancel{{$productorder->id}}">Cancel Order</a></td>
                                                                                        @else
                                                                                            <td>-</td>
                                                                                        @endif
                                                                                </tr>
                                                                                <div class="modal fade" id="cancel{{$productorder->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                                                    <div class="modal-dialog" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                            <h5 class="modal-title" id="exampleModalLongTitle">Cancel Order : Order Id -> {{$order->id}}</h5>
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <form action="{{route('cancelorder', $productorder->id)}}" method="POST">
                                                                                                    @csrf
                                                                                                    @method('PUT')
                                                                                                    <div class="form-group">
                                                                                                        <label for="reason">Pick a reason</label>
                                                                                                        <select name="reason">
                                                                                                            <option value="Cheaper alternative available for lesser price">Cheaper alternative available for lesser price</option>
                                                                                                            <option value="Ordered out of excitement and realised it's of no need">Ordered out of excitement and realised it's of no need</option>
                                                                                                            <option value="Not going to be available in town due to some urgent travel">Not going to be available in town due to some urgent travel</option>
                                                                                                            <option value="Product is taking too long to be delivered">Product is taking too long to be delivered</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <button type="submit" class="btn btn-danger btn-sm">Submit & Cancel</button>
                                                                                                </form>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary py-3 px-4" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

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

@push('scripts')


@endpush

