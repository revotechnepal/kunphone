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

    <div class="hero-wrap hero-bread" style="background-image: url('frontend/images/bg_6.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="{{route('index')}}">Home</a></span> <span>Shop</span></p>
            <h1 class="mb-0 bread">Buy Phone</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-8 col-lg-10 order-md-last">
    				<div class="row">
                        @foreach ($productoutgoing as $outproduct)
                            @php
                                $product = DB::table('products')->where('id', $outproduct->product_id)->first();
                                $brand = DB::table('brands')->where('id', $product->brand_id)->first();
                            @endphp
                            <div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
                                <div class="product d-flex flex-column">

                                        @if ($outproduct->condition == 'new')
                                            <a href="{{route('product', ['id' => $outproduct->id, 'slug' => $product->slug])}}" class="img-prod"><img class="img-fluid" src="{{Storage::disk('uploads')->url($product->modelimage)}}" alt="Model Image" style="max-height: auto; width: auto;">
                                            <span class="status">New Phone</span>
                                        @elseif($outproduct->condition == 'used')
                                        @php
                                            $productimage = DB::table('product_useds')->where('used_product_id', $outproduct->id)->first();
                                        @endphp
                                            <a href="{{route('product', ['id' => $outproduct->id, 'slug' => $product->slug])}}" class="img-prod"><img class="img-fluid" src="{{Storage::disk('uploads')->url($productimage->modelimage)}}" alt="Model Image" style="max-height: auto; width: auto;">
                                            <span class="status">Used Phone</span>
                                        @endif
                                        <div class="overlay"></div>
                                    </a>
                                    <div class="text py-3 pb-4 px-3">
                                        <div class="d-flex">
                                            <div class="cat">
                                                <span>{{$brand->name}}</span>
                                            </div>
                                        </div>
                                        <h3><a href="{{route('product', ['id' => $outproduct->id, 'slug' => $product->slug])}}">{{$product->name}} ({{$outproduct->ram}}/{{$outproduct->rom}})</a></h3>
                                        <div class="pricing">
                                            <p class="price"><span>Rs. {{$outproduct->price}}</span></p>
                                        </div>
                                        <p class="bottom-area d-flex px-3">
                                            <a href="{{route('product', ['id' => $outproduct->id, 'slug' => $product->slug])}}" class="buy-now text-center py-2">To Cart<span><i class="ion-ios-cart ml-1"></i></span></a>&nbsp;

                                            @if(Auth::guest() || Auth::user()->role_id != 3)
                                                <a href="javascript:void(0)" onclick="openLoginModal();" class="login-panel buy-now text-center py-2">To Wishlist<span><i class="ion-ios-list ml-1"></i></span></a>
                                            @elseif(Auth::user()->hasRole('user'))
                                                <a href="{{route('addtowishlist', $outproduct->id)}}" class="buy-now text-center py-2">To Wishlist<span><i class="ion-ios-list ml-1"></i></span></a>
                                            @endif
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

		    	<div class="col-md-4 col-lg-2">
		    		    <div class="sidebar">
                            <div class="sidebar-box-2">
								<h2 class="heading">Buy Phones</h2>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="{{route('shop')}}">All Phones</a>
                                            <a href="{{route('newshop')}}">New Phones</a>
                                            <a href="{{route('oldshop')}}">Used Phones</a>
                                        </h4>
                                    </div>
                                </div>
							</div>
							<div class="sidebar-box-2">
								<h2 class="heading">Brands</h2>
								{{-- <div class="fancy-collapse-panel"> --}}
                                    {{-- <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true"> --}}

                                        @foreach ($brands as $brand)
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a href="{{route('brandproduct', $brand->slug)}}">{{$brand->name}}
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                        @endforeach

							</div>
							<div class="sidebar-box-2">
                                <h3 class="heading">Price Range (Rs.)</h3>
                                @php
                                    $leastpriceproduct = DB::table('product_outgoings')->orderBy('price','ASC')->first();
                                    $highestpriceproduct = DB::table('product_outgoings')->orderBy('price','DESC')->first();
                                    $leastprice = $leastpriceproduct->price;
                                    $highestprice = $highestpriceproduct->price;
                                @endphp

                                <form action="{{route('shop.pricesearch')}}" method="POST">
                                    @csrf
                                    @method('GET')
                                    <p>
                                        <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold; width: 150px;" name="price">
                                        @error('price')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </p>
                                    <div id="slider-range"></div>
                                    <div class="form-group mt-3">
                                        <button type="submit"class="btn btn-primary" style="width: 100%">Filter</button>
                                    </div>
                                </form>
							</div>
						</div>
    			</div>
    		</div>
    	</div>
    </section>
{{--
		<section class="ftco-gallery">
    	<div class="container">
    		<div class="row justify-content-center">
    			<div class="col-md-8 heading-section text-center mb-4 ftco-animate">
            <h2 class="mb-4">Follow Us On Instagram</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
          </div>
    		</div>
    	</div>
    	<div class="container-fluid px-0">
    		<div class="row no-gutters">
					<div class="col-md-4 col-lg-2 ftco-animate">
						<a href="{{asset('frontend/images/gallery-1.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url(frontend/images/gallery-1.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-instagram"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-4 col-lg-2 ftco-animate">
						<a href="{{asset('frontend/images/gallery-2.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url(frontend/images/gallery-2.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-instagram"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-4 col-lg-2 ftco-animate">
						<a href="{{asset('frontend/images/gallery-3.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url(frontend/images/gallery-3.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-instagram"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-4 col-lg-2 ftco-animate">
						<a href="{{asset('frontend/images/gallery-4.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url(frontend/images/gallery-4.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-instagram"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-4 col-lg-2 ftco-animate">
						<a href="{{asset('frontend/images/gallery-5.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url(frontend/images/gallery-5.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-instagram"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-4 col-lg-2 ftco-animate">
						<a href="{{asset('frontend/images/gallery-6.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url(frontend/images/gallery-6.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-instagram"></span>
    					</div>
						</a>
					</div>
        </div>
    	</div>
    </section> --}}
@endsection
@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
  $( "#slider-range" ).slider({
    range: true,
    min: {{$leastprice}},
    max: {{$highestprice}},
    values: [ {{$leastprice}} + 0.6 * {{$leastprice}}, {{$highestprice}} - 0.4 * {{$highestprice}} ],
    slide: function( event, ui ) {
      $( "#amount" ).val( ui.values[ 0 ] + " - "+ ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
    " - " + $( "#slider-range" ).slider( "values", 1 ) );
} );
</script>
@endpush
