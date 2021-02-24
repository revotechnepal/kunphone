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
                        <h4 class="billing-heading text-center">Approved Products for Exchange</h4>
                            @if ($approvedproducts->count() > 0)
                                <p class="text-center">( Exchange with similar valued or more valued price phones..)</p>
                            @endif
                    </div>
                    <div class="card-body">
                        @if ($approvedproducts->count() == 0)
                                <p>No approved products</p>
                            @else
                        <div class="table-responsive">
                            <table id="myTable" class="table">
                                <thead>
                                    <tr>
                                        <th style="font-weight: bold;">Your Approved Product</th>
                                        <th style="font-weight: bold;">Product Info</th>
                                        <th style="font-weight: bold;">Valued at</th>
                                        <th style="font-weight: bold;">Your Exchange Code</th>
                                        <th style="font-weight: bold;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($approvedproducts as $approved)
                                        <tr>
                                            @php
                                                $product = DB::table('products')->where('id', $approved->product_id)->first();
                                            @endphp
                                            <td>
                                                <a href="http://phone.revonepal.com/public/uploads/{{$approved->frontimage}}" target="_blank"><img src="{{Storage::disk('uploads')->url($approved->frontimage)}}" alt="" style="max-height: 100px;;"></a>
                                                <a href="http://phone.revonepal.com/public/uploads/{{$approved->backimage}}" target="_blank"><img src="{{Storage::disk('uploads')->url($approved->backimage)}}" alt="" style="max-height: 100px;;"></a>
                                            </td>
                                            <td>
                                                {{$product->name}}<br>
                                                ( {{$approved->ram}} / {{$approved->rom}} )
                                            </td>
                                            <td>
                                                Rs. {{$approved->price}}
                                            </td>
                                                @php

                                                    $initiateddate = $approved->updated_at;
                                                    $initiatedinmilisec = strtotime($initiateddate.'+1 week');
                                                    $today = date('Y-m-d h:i:sa');
                                                    $expiringdate = strtotime($today);
                                                @endphp

                                                    @if($initiatedinmilisec < $expiringdate)
                                                        <td>Code Expired</td>
                                                        <td>Exchange Cancelled</td>
                                                    @else
                                                        <td><b>{{$approved->exchangecode}}</b></br>
                                                            @php
                                                                $timeremaining = $initiatedinmilisec - $expiringdate;
                                                                $timeindays = round($timeremaining / (60 * 60 * 24));
                                                            @endphp

                                                            @if($timeindays < 1)
                                                                (Expires Today)
                                                            @else
                                                                 (Expires in {{$timeindays}} days)
                                                            @endif
                                                        </td>
                                                        <td><a href='{{route('exchange', ['price' => $approved->price, 'id' => $approved->id])}}' class='btn btn-success py-2 px-4'>Exchange</a>
                                                        </td>

                                                    @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>


                @if ($exchangedproducts->count() == 0)

                @else
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="billing-heading text-center">Products Exchanged</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="myTable" class="table">
                                <thead>
                                    <tr>
                                        <th style="font-weight: bold;">Your Product</th>
                                        <th style="font-weight: bold;">Exchange with</th>
                                        <th style="font-weight: bold;">Price Difference</th>
                                        <th style="font-weight: bold;">Exchange Initiated</th>
                                        <th style="font-weight: bold;">Your Exchange Code</th>
                                        <th style="font-weight: bold;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($exchangedproducts as $exchange)
                                        <tr>
                                            @php
                                                $inproduct = DB::table('product_incomings')->where('id', $exchange->incomingproduct_id)->first();
                                                $yourproduct = DB::table('products')->where('id', $inproduct->product_id)->first();
                                                $outproduct = DB::table('product_outgoings')->where('id', $exchange->outgoingproduct_id)->first();
                                                $exchangingproduct = DB::table('products')->where('id', $outproduct->product_id)->first();
                                            @endphp
                                            <td>
                                                <img src="{{Storage::disk('uploads')->url($exchange->frontimage)}}" alt="" style="max-height: 100px;;"><br>
                                                {{$yourproduct->name}}<br>
                                                ( {{$exchange->product1_ram}} / {{$exchange->product1_rom}} )
                                            </td>
                                            <td>

                                                @if ($outproduct->condition == 'new')
                                                    <img src="{{Storage::disk('uploads')->url($exchangingproduct->modelimage)}}" alt="" style="max-height: 100px;">
                                                @elseif($outproduct->condition == 'used')
                                                @php
                                                    $productimage = DB::table('product_useds')->where('used_product_id', $outproduct->id)->first();
                                                @endphp
                                                    <img src="{{Storage::disk('uploads')->url($productimage->modelimage)}}" alt="" style="max-height: 100px;">
                                                @endif<br>
                                                {{$exchangingproduct->name}}<br>
                                                ( {{$exchange->product2_ram}} / {{$exchange->product2_rom}} )
                                            </td>
                                            <td>
                                                Rs. {{$exchange->pricediff}}
                                            </td>
                                            <td>
                                                {{date('F j, Y', strtotime($exchange->created_at))}}
                                            </td>


                                                @if ($exchange->is_processsing == 1)
                                                    @php
                                                        $initiateddate = $exchange->created_at;
                                                        $initiatedinmilisec = strtotime($initiateddate.'+1 week');
                                                        $today = date('Y-m-d h:i:sa');
                                                        $expiringdate = strtotime($today);
                                                    @endphp

                                                    @if($initiatedinmilisec < $expiringdate)
                                                        @php
                                                            DB::update('update exchange_confirms set is_processsing = 2 where id = ?', [$exchange->id]);
                                                            DB::update('update product_outgoings set quantity = quantity+1 where id = ?', [$exchange->outgoingproduct_id]);
                                                        @endphp
                                                        <td>Code Expired</td>
                                                    @else
                                                        <td><b>{{$exchange->exchangecode}}</b></br>
                                                            @php
                                                                $timeremaining = $initiatedinmilisec - $expiringdate;
                                                                $timeindays = round($timeremaining / (60 * 60 * 24));
                                                            @endphp

                                                            @if($timeindays < 1)
                                                                (Expires Today)
                                                            @else
                                                                 (Expires in {{$timeindays}} days)
                                                            @endif
                                                        </td>
                                                    @endif
                                                    <td>Exchange Processing</td>
                                                @elseif($exchange->is_processsing == 2)
                                                    <td>Code Expired</td>
                                                    <td>Exchange Cancelled</td>
                                                @elseif($exchange->is_processsing == 0)
                                                    <td><b>{{$exchange->exchangecode}}</b></td>
                                                    <td>Exchange Complete</td>
                                                @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
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
