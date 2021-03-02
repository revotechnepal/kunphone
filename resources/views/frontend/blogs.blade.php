@extends('frontend.layouts.app')

@section('content')

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

    {{-- <section id="home-section" class="hero">
        <div class="home-slider owl-carousel">
            @foreach ($sliderblogs as $item)
            <div class="slider-item js-fullheight">
                <div class="overlay"></div>
              <div class="container-fluid p-0">
                <div class="row d-md-flex no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
                    <img class="one-third order-md-last img-fluid" src="{{Storage::disk('uploads')->url($item->image)}}" alt="">
                    <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                        <div class="text">

                            <div class="horizontal">
                              <h1 class="mb-4 mt-3">{{$item->title}}</h1>



                            </div>
                        </div>
                    </div>
                  </div>
              </div>
            </div>
            @endforeach
      </div>
    </section> --}}
    <section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12 col-lg-12 order-md-last">
    				<div class="row">
                        @foreach ($allblogs as $blog)
                            {{-- @php
                                $product = DB::table('products')->where('id', $outproduct->product_id)->first();
                                $brand = DB::table('brands')->where('id', $product->brand_id)->first();
                            @endphp --}}
                            <div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
                                <div class="product d-flex flex-column">


                                            <a href="#" class="img-prod"><img class="img-fluid" src="{{Storage::disk('uploads')->url($blog->image)}}" alt="Blog Image" style="max-height: auto; width: auto;">
                                            <span class="status">Blog</span>
                                                <div class="overlay"></div>
                                            </a>
                                    <div class="text py-3 pb-4 px-3">
                                        <div class="d-flex">
                                            <div class="cat">
                                                <span>
                                                    @php
                                                        $categories = $blog->category;
                                                        $category = '';
                                                        foreach ($categories as $cat) {
                                                            $categoryname = DB::table('blog_categories')->where('id', $cat)->first();
                                                            $category .= $categoryname->name. ',';
                                                    }
                                                    @endphp
                                                    {{$category}}
                                                </span>
                                            </div>
                                        </div>
                                        <h3><a href="#">{{$blog->title}}</a></h3>
                                        {{-- <div class="pricing">
                                            <p class="price"><span>Rs. {{$outproduct->price}}</span></p>
                                        </div> --}}
                                        {{-- <p class="bottom-area d-flex px-3">
                                            <a href="{{route('product', ['id' => $outproduct->id, 'slug' => $product->slug])}}" class="buy-now text-center py-2">To Cart<span><i class="ion-ios-cart ml-1"></i></span></a>&nbsp;

                                            @if(Auth::guest() || Auth::user()->role_id != 3)
                                                <a href="javascript:void(0)" onclick="openLoginModal();" class="login-panel buy-now text-center py-2">To Wishlist<span><i class="ion-ios-list ml-1"></i></span></a>
                                            @elseif(Auth::user()->hasRole('user'))
                                                <a href="{{route('addtowishlist', $outproduct->id)}}" class="buy-now text-center py-2">To Wishlist<span><i class="ion-ios-list ml-1"></i></span></a>
                                            @endif
                                        </p> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
		    		</div>
		    	    <div class="row mt-5">
                        <div class="col text-center">
                            <div class="block-27">
                            {{$allblogs->links()}}

                            </div>
                        </div>
		            </div>
		    	</div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('frontend/js/algolia_phone1.js') }}"></script>
@endpush

