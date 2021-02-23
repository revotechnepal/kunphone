@extends('frontend.layouts.app')
@push('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
    			<div class="col-md-12 col-lg-12 order-md-last">
                    <h2 class="billing-heading mb-5 text-center">Exchange for your value (Rs. {{$price}} or more..)</h2>
    				<div class="row">
                        @foreach ($productoutgoing as $outproduct)
                            @php
                                $product = DB::table('products')->where('id', $outproduct->product_id)->first();
                                $brand = DB::table('brands')->where('id', $product->brand_id)->first();
                            @endphp
                            <div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
                                <div class="product d-flex flex-column">
                                    <div class="img-prod">
                                        {{-- <img class="img-fluid" src="{{Storage::disk('uploads')->url($product->modelimage)}}" alt="Model Image" style="max-height: auto; width: auto;">
                                        @if ($outproduct->condition == 'new')
                                            <span class="status">New Phone</span>
                                        @elseif($outproduct->condition == 'used')
                                            <span class="status">Used Phone</span>
                                        @endif --}}

                                        @if ($outproduct->condition == 'new')
                                            <a href="{{route('product', ['id' => $outproduct->id, 'slug' => $product->slug])}}"><img class="img-fluid" src="{{Storage::disk('uploads')->url($product->modelimage)}}" alt="Model Image" style="max-height: auto; width: auto;">
                                            <span class="status">New Phone</span></a>
                                        @elseif($outproduct->condition == 'used')
                                        @php
                                            $productimage = DB::table('product_useds')->where('used_product_id', $outproduct->id)->first();
                                        @endphp
                                            <a href="{{route('product', ['id' => $outproduct->id, 'slug' => $product->slug])}}"><img class="img-fluid" src="{{Storage::disk('uploads')->url($productimage->modelimage)}}" alt="Model Image" style="max-height: auto; width: auto;">
                                            <span class="status">Used Phone</span></a>
                                        @endif
                                        <div class="overlay"></div>
                                    </div>
                                    <div class="text py-3 pb-4 px-3">
                                        <div class="d-flex">
                                            <div class="cat">
                                                <span>{{$brand->name}}</span>
                                            </div>
                                        </div>
                                        <h3>{{$product->name}} ({{$outproduct->ram}}/{{$outproduct->rom}})</h3>
                                        <div class="pricing">
                                            <p class="price"><span>Rs. {{$outproduct->price}}</span></p>
                                        </div>
                                        <p class="bottom-area d-flex px-3">
                                            <a href="{{route('exchangewith', ['price' => $price, 'outgoing_id' => $outproduct->id, 'incoming_id' => $id])}}" class="buy-now text-center py-2">Exchange<span><i class="ion-ios-crop ml-1"></i></span></a>&nbsp;
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
		    		</div>
		    		<div class="row mt-5">
		          <div class="col text-center">
		            <div class="block-27">
                      {{$productoutgoing->links()}}

		            </div>
		          </div>
		        </div>
		    	</div>
    </section>
@endsection
