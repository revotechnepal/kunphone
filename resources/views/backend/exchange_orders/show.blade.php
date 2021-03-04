@extends('backend.layouts.app')

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <h2 class="mb-3"> Exchange Order #{{$exchangeorder->id}} <a href="{{route('admin.exchangeconfirm.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i> View All Exchange Orders</a></h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        {{-- <div class="panel-heading">
                        </div> --}}
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><span style="font-weight: bold;">Order Id: </span> {{$exchangeorder->id}}</p>
                                    <p><span style="font-weight: bold;">Customer Name: </span> {{$exchangeorder->user->name}}</p>
                                    <p><span style="font-weight: bold;">Email: </span>{{$exchangeorder->user->email}}</p>
                                    <p><span style="font-weight: bold;">Ordered Date: </span> {{date('F d Y', strtotime($exchangeorder->created_at))}}</p>
                                    <p>
                                        @php
                                            $vendor = DB::table('vendors')->where('id', $exchangeorder->vendor)->first();
                                        @endphp
                                        <span style="font-weight: bold;">Appropriate Vendor: </span> {{$vendor->name}}
                                    </p>
                                    <p>
                                        <span style="font-weight: bold;">Vendor Address: </span> {{$vendor->address}}, {{$vendor->district}}
                                    </p>

                                    @if ($exchangeorder->is_processsing == 1)
                                        @php
                                            $initiateddate = $exchangeorder->created_at;
                                            $initiatedinmilisec = strtotime($initiateddate.'+1 week');
                                            $today = date('Y-m-d h:i:sa');
                                            $expiringdate = strtotime($today);
                                        @endphp

                                        @if($initiatedinmilisec < $expiringdate)
                                        @php
                                            DB::update('update exchange_confirms set is_processsing = 2 where id = ?', [$exchangeorder->id]);
                                            DB::update('update product_outgoings set quantity = quantity+1 where id = ?', [$exchangeorder->outgoingproduct_id]);
                                        @endphp

                                            <p><span style="font-weight: bold;">Exchange Code: </span>  (Code Expired)</p>
                                        @else
                                            <p><span style="font-weight: bold;">Exchange Code: </span> {{$exchangeorder->exchangecode}}
                                            @php
                                                $timeremaining = $initiatedinmilisec - $expiringdate;
                                                $timeindays = round($timeremaining / (60 * 60 * 24));
                                            @endphp

                                            @if($timeindays < 1)
                                                (Expires Today)
                                            @else
                                                (Expires in {{$timeindays}} days)
                                            @endif
                                            </p>
                                        @endif
                                            <p>
                                                <span style="font-weight: bold;">Exchange Status: </span>Exchange Processing
                                            </p>
                                        @elseif($exchangeorder->is_processsing == 2)
                                            <p><span style="font-weight: bold;">Exchange Code: </span> {{$exchangeorder->exchangecode}}</p>
                                            <p>
                                                <span style="font-weight: bold;">Exchange Status: </span>Exchange Cancelled
                                            </p>
                                        @elseif($exchangeorder->is_processsing == 0)
                                            <p><span style="font-weight: bold;">Exchange Code: </span> {{$exchangeorder->exchangecode}}</p>
                                            <p>
                                                <span style="font-weight: bold;">Exchange Status: </span>Exchange Complete&nbsp;
                                                <a href="{{Storage::disk('uploads')->url($exchangeorder->warranty)}}" class="btn btn-primary" target="_blank">View Warranty Details</a>
                                            </p>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3>Exchange Summary</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="table-responsive">
                                    <table id="myTable" class="table">
                                        <thead>
                                            <tr>
                                                <th style="font-weight: bold;"></th>
                                                <th style="font-weight: bold;">Product</th>
                                                <th style="font-weight: bold;">Product Info</th>
                                                <th style="font-weight: bold;">Valued at</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="font-weight: bold">Owner's Product</td>
                                                <td><img src="{{Storage::disk('uploads')->url($exchangeorder->frontimage)}}" style="max-height:100px;" alt="">
                                                    <img src="{{Storage::disk('uploads')->url($exchangeorder->backimage)}}" style="max-height:100px;" alt=""></td>
                                                <td>
                                                    <b>{{$incomingproduct->product->name}}</b><br>
                                                    ( {{$exchangeorder->product1_ram}} / {{$exchangeorder->product1_rom}} )
                                                </td>
                                                <td>
                                                    Rs. {{$exchangeorder->product1_price}}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-weight: bold">Exchange With</td>
                                                <td>
                                                    @if ($outgoingproduct->condition == 'new')
                                                    @php
                                                        $product = DB::table('products')->where('id', $outgoingproduct->product_id)->first();
                                                    @endphp
                                                        <img class="img-fluid" src="{{Storage::disk('uploads')->url($product->modelimage)}}" alt="Model Image" style="max-height: 100px;">

                                                    @elseif($outgoingproduct->condition == 'used')
                                                    @php
                                                        $productimages = DB::table('product_useds')->where('used_product_id', $outgoingproduct->id)->get();
                                                    @endphp
                                                        @foreach ($productimages as $image)
                                                            <img class="img-fluid" src="{{Storage::disk('uploads')->url($image->modelimage)}}" alt="Model Image" style="max-height: 100px;">
                                                        @endforeach
                                                    @endif
                                                </a>
                                                </td>

                                                {{-- <td><img src="{{Storage::disk('uploads')->url($product1->modelimage)}}" style="max-height:100px;" alt=""></td> --}}
                                                <td>
                                                    <b>{{$outgoingproduct->product->name}}</b><br>
                                                    ( {{$exchangeorder->product1_ram}} / {{$exchangeorder->product1_rom}} )<br>
                                                    @if ($outgoingproduct->condition == 'new')
                                                        (New Phone)
                                                    @elseif($outgoingproduct->condition == 'used')
                                                        (Used Phone)<br>
                                                        SKU: {{$outgoingproduct->sku}}
                                                    @endif
                                                </td>
                                                <td>
                                                    Rs. {{$exchangeorder->product2_price}}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="text-right" style="font-weight: bold;">Price Difference:</td>
                                                <td>Rs. {{$exchangeorder->pricediff}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-right"></td>
                                                <td>
                                                    @if ($exchangeorder->is_processsing == 1)
                                                        <form action="{{route('admin.exchangeconfirm.update', $exchangeorder->id)}}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-danger">Cancel Exchange</button>
                                                        </form>

                                                    @endif
                                                </td>
                                            </tr>

                                            </tbody>
                                            </table>
                                        </div>

                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
