@extends('frontend.layouts.app')
@push('styles')
    <!-- Algolia Search -->
    <link rel="stylesheet" href="{{ asset('frontend/css/algolia.css') }}">
@endpush
@section('content')

    <section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 ftco-animate">
				<h3 class="mb-4 billing-heading text-center">Search Your Phone to exchange</h3>
                <div class="row align-items-end">
                    <div class="col-md-12">
                        <div class="aa-input-container" id="aa-input-container">
                            <input type="search" id="aa-search-input" class="aa-input-search" placeholder="What do you need?" name="search"
                                autocomplete="off" />
                            <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
                                <path d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
                            </svg>
                        </div>
                    </div>
                </div>
              <!-- END -->
	        </div>
        </div> <!-- .col-md-8 -->
    </div>
    </section> <!-- .section -->
    
    <section class="ftco-section1 bg-light" style="z-index: -1;">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h3 class="billing-heading mb-4">Featured Products</h3>
            </div>
        </div>

        <div class="row">
            @foreach ($featuredproducts as $outproduct)
                @php
                    $product = DB::table('products')->where('id', $outproduct->product_id)->first();
                    $brand = DB::table('brands')->where('id', $product->brand_id)->first();
                @endphp

                <div class="col-sm-12 col-md-6 col-lg-3 ftco-animate d-flex">
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
                            <h3>
                                <a href="{{route('product', ['id' => $outproduct->id, 'slug' => $product->slug])}}">
                                    {{$product->name}} ({{$outproduct->ram}}/{{$outproduct->rom}})
                                </a>
                            </h3>
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
  </div>
</section>

@endsection
@push('scripts')

<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('frontend/js/algolia.js') }}"></script>

@endpush
