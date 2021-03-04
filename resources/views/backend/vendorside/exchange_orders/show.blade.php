@extends('backend.layouts.vendor')

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
            <h2 class="mb-3"> Exchange Order #{{$exchangeorder->id}} <a href="{{route('vendor.exchangeorders.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i> View All Exchange Orders</a></h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        {{-- <div class="panel-heading">
                        </div> --}}
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <p><span style="font-weight: bold;">Order Id: </span></p>
                                </div>
                                <div class="col-md-10">
                                    <p> {{$exchangeorder->id}}</p>
                                </div>
                                <div class="col-md-2">
                                    <p><span style="font-weight: bold;">Customer Name: </span></p>
                                </div>
                                <div class="col-md-10">
                                    <p> {{$exchangeorder->user->name}}</p>
                                </div>
                                <div class="col-md-2">
                                    <p><span style="font-weight: bold;">Email: </span></p>
                                </div>
                                <div class="col-md-10">
                                    <p>{{$exchangeorder->user->email}}</p>
                                </div>

                                <div class="col-md-2">
                                    <p><span style="font-weight: bold;">Ordered Date: </span></p>
                                </div>
                                <div class="col-md-10">
                                    <p>{{date('F d Y', strtotime($exchangeorder->created_at))}}</p>
                                </div>
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

                                            <div class="col-md-2">
                                                <p><span style="font-weight: bold;">Exchange Code: </span></p>
                                            </div>
                                            <div class="col-md-10">
                                                <p>(Code Expired)</p>
                                            </div>

                                        @else
                                            <div class="col-md-2">
                                                <p><span style="font-weight: bold;">Exchange Code: </span></p>
                                            </div>
                                            <div class="col-md-10">
                                                <p>{{$exchangeorder->exchangecode}}

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
                                            </div>
                                        @endif
                                        <div class="col-md-2">
                                            <p>
                                                <span style="font-weight: bold;">Exchange Status: </span>
                                            </p>
                                        </div>
                                        <div class="col-md-10">
                                            <p>Exchange Processing</p>
                                        </div>

                                        @elseif($exchangeorder->is_processsing == 2)
                                        <div class="col-md-2">
                                            <p><span style="font-weight: bold;">Exchange Code: </span></p>
                                        </div>
                                        <div class="col-md-10">
                                            <p>{{$exchangeorder->exchangecode}}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <p>
                                                <span style="font-weight: bold;">Exchange Status: </span></p>
                                        </div>
                                        <div class="col-md-10">
                                            <p>Exchange Cancelled
                                            </p>
                                        </div>


                                        @elseif($exchangeorder->is_processsing == 0)
                                        <div class="col-md-2">
                                            <p><span style="font-weight: bold;">Exchange Code: </span> </p>
                                        </div>
                                        <div class="col-md-10">
                                            <p>{{$exchangeorder->exchangecode}}</p>
                                        </div>

                                        <div class="col-md-2">
                                            <p>
                                                <span style="font-weight: bold;">Exchange Status: </span></p>
                                        </div>
                                        <div class="col-md-10">
                                            <p>Exchange Complete&nbsp;
                                                <a href="{{Storage::disk('uploads')->url($exchangeorder->warranty)}}" class="btn btn-primary" target="_blank">View Warranty Details</a>
                                            </p>
                                        </div>
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
                                            @if ($exchangeorder->is_processsing == 1)
                                            <tr>
                                                <td colspan="3"></td>
                                                <td>
                                                    <form action="{{route('vendor.exchangeorders.update', $exchangeorder->id)}}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-danger">Cancel Exchange</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endif

                                            @if ($exchangeorder->is_processsing == 1)
                                            <tr>
                                                <td colspan="3"></td>
                                                <td>
                                                    <a href="" id="slider" class="btn btn-primary" onclick="showwarrantyform()">Exchange Complete</a>
                                                </td>
                                            </tr>
                                            @endif

                                            <tr>
                                                <td colspan="3"></td>
                                                <td style="display: none;" id="willappear">
                                                    <form action="{{route('vendor.updateexchange', $exchangeorder->id)}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="warranty">Upload warranty details(in pdf.)</label>
                                                            <input type="file" class="form-control" name="warranty">
                                                            @error('warranty')
                                                                <p class="text-danger">{{$message}}</p>
                                                            @enderror
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Confirm</button>
                                                    </form>
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


@push('scripts')
<script>
    function showwarrantyform() {
      var row = document.getElementById("willappear");
      if (row.style.display === "none") {
        row.style.display = "block";
      } else {
        row.style.display = "none";
      }
    }

    $(document).ready(function(){
        $("#slider").click(function(event){
            event.preventDefault();
        });
    });
</script>
@endpush
