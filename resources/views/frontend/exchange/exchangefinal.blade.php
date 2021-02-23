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
            <div class="col-md-12 col-lg-12 order-md-last">
                <div class="card">
                    <div class="card-header">
                        <h4 class="billing-heading text-center">Exchange Product</h4>
                    </div>
                    <div class="card-body">
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
                                <form action="{{route('exchangecheckout', [ 'outgoing_id' => $outgoingproduct->id, 'incoming_id' => $incomingproduct->id])}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                        <tbody>
                                            <tr>
                                                <td style="font-weight: bold">Your Product</td>
                                                <td>
                                                    <a href="http://phone.revonepal.com/public/uploads/{{$incomingproduct->frontimage}}" target="_blank"><img src="{{Storage::disk('uploads')->url($incomingproduct->frontimage)}}" alt="" style="max-height: 100px;;"></a>
                                                    <a href="http://phone.revonepal.com/public/uploads/{{$incomingproduct->backimage}}" target="_blank"><img src="{{Storage::disk('uploads')->url($incomingproduct->backimage)}}" alt="" style="max-height: 100px;;"></a>
                                                </td>
                                                <td>
                                                    {{$exchangingproduct->name}}<br>
                                                    ( {{$incomingproduct->ram}} / {{$incomingproduct->rom}} )
                                                </td>
                                                <td>
                                                    Rs. {{$incomingproduct->price}}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-weight: bold">Exchange With</td>
                                                <td>
                                                            @if ($outgoingproduct->condition == 'new')

                                                                <img src="{{Storage::disk('uploads')->url($exchangingwith->modelimage)}}" style="max-height:100px;" alt="">

                                                            @elseif($outgoingproduct->condition == 'used')
                                                            @php
                                                                $productimages = DB::table('product_useds')->where('used_product_id', $outgoingproduct->id)->get();
                                                            @endphp
                                                                @foreach ($productimages as $image)
                                                                    <img class="img-fluid" src="{{Storage::disk('uploads')->url($image->modelimage)}}" alt="Model Image" style="max-height: 100px;">
                                                                @endforeach
                                                            @endif

                                                </td>
                                                <td>
                                                    {{$exchangingwith->name}}<br>
                                                    ( {{$outgoingproduct->ram}} / {{$outgoingproduct->rom}} )
                                                </td>
                                                <td>
                                                    Rs. {{$outgoingproduct->price}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="font-weight: bold;">Price Difference:</td>
                                                @php
                                                    $subtotal = $outgoingproduct->price - $incomingproduct->price;
                                                @endphp
                                                <td>Rs. {{$subtotal}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="font-weight: bold;">Choose a vendor to exchange from:
                                                    <div class="form-group">
                                                        <select name="vendor" id="">
                                                            @foreach ($vendors as $vendor)
                                                                <option value="{{$vendor->id}}">{{$vendor->name}}, {{$vendor->address}}, {{$vendor->district}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td>
                                                    <button type="submit" class="btn btn-success">Confirm Exchange</button>
                                                </td>
                                            </tr>
                                    </tbody>
                                </form>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
