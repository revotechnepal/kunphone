@extends('frontend.layouts.app')
@push('styles')
    <style>
            .owl-carousel .owl-stage, .owl-carousel.owl-drag .owl-item{
                -ms-touch-action: auto;
                    touch-action: auto;
            }
    </style>
@endpush
@section('content')

<a href="" data-toggle="modal" data-target="#contact_modal" id="contact">
</a>
<!-- Modal -->
<div class="modal fade" id="contact_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header customimagemodal">
            <h5 id="contact_modalLabel" class="billing-heading">Welcome To KunPhone ( Beta Version )</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body customimagemodal">

            <img src="{{asset('uploads/phone/phone.png')}}" class="customimage">
        </div>
        {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div> --}}
    </div>
    </div>
</div
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
<section id="home-section" class="hero">
    <div class="home-slider owl-carousel">
        @foreach ($slider as $item)
        <div class="slider-item js-fullheight">
            <div class="overlay"></div>
          <div class="container-fluid p-0">
            <div class="row d-md-flex no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
                <img class="one-third order-md-last img-fluid" src="{{Storage::disk('uploads')->url($item->images)}}" alt="">
                <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                    <div class="text">
                        <span class="subheading">#{{$item->hashtitle}}</span>
                        <div class="horizontal">
                          <h1 class="mb-4 mt-3">{{$item->title}}</h1>
                          <p class="mb-4">{{$item->description}}</p>

                            <p>
                                <a href="{{route('shop')}}" class="btn-custom">Buy Phone</a>
                                @if (Auth::guest() || Auth::user()->role_id != 3)
                                    <a href="javascript:void(0)" onclick="openLoginModal();" class="btn-custom login-panel">Exchange Phone</a>
                                @elseif(Auth::user()->role_id==3)
                                    <a href="{{route('sellphone')}}" class="btn-custom">Exchange Phone</a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
        @endforeach
  </div>
</section>

<section class="ftco-section ftco-no-pt ftco-no-pb">
      <div class="container">
          <div class="row no-gutters ftco-services">
            <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services p-4 py-md-5">
                <div class="icon d-flex justify-content-center align-items-center mb-4">
                    <span class="flaticon-bag"></span>
                </div>
                <div class="media-body">
                <h3 class="heading">Check Price</h3>
                <p>Evaluate the price for your old phone.</p>
                </div>
            </div>
            </div>
            <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services p-4 py-md-5">
                <div class="icon d-flex justify-content-center align-items-center mb-4">
                    <span class="flaticon-customer-service"></span>
                </div>
                <div class="media-body">
                <h3 class="heading">Schedule Pickup</h3>
                <p>Schedule pickup address for our employee to pick up your phone.</p>
                </div>
            </div>
            </div>
            <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services p-4 py-md-5">
                <div class="icon d-flex justify-content-center align-items-center mb-4">
                    <span class="flaticon-payment-security"></span>
                </div>
                <div class="media-body">
                <h3 class="heading">Get Paid</h3>
                <p>Get value for your old phone.</p>
                </div>
            </div>
            </div>
        </div>
      </div>
  </section>
{{--
  <section class="ftco-section1 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="billing-heading mb-4">Our Associated Brands</h2>
            </div>
        </div>

        <div class="row">
            @foreach ($brands as $brand)
            <div class="col-sm-12 col-md-6 col-lg-3 ftco-animate d-flex">
                <div class="product d-flex flex-column text-center">
                    <a class="btn btn-primary py-3 px-5" href="{{route('brandproduct', $brand->slug)}}">
                        <img class="img-fluid mb-2" src="{{Storage::disk('uploads')->url($brand->logo)}}" alt="" style="max-height: 100px; width:100px; border-radius: 10px;"><br>
                        <b>{{$brand->name}}</b>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
  </div>
</section> --}}


<section class="ftco-section1 testimony-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
            <div class="heading-section ftco-animate text-center mb-5">
                <h2 class="billing-heading mb-4">Our Associated Brands</h2>
            </div>

          <div class="carousel-testimony owl-carousel">
            @foreach ($brands as $brand)
            <div class="item">
              <div class="testimony-wrap">
                <a class="btn btn-light py-3 px-5" href="{{route('brandproduct', $brand->slug)}}">
                    <img class="img-fluid mb-2" src="{{Storage::disk('uploads')->url($brand->logo)}}" alt="" style="height: 100px; border-radius: 10px;"><br>
                    <b>{{$brand->name}}</b>
                </a>

              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
</section>

<section class="ftco-section1 bg-light">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="billing-heading mb-4">New Arrivals</h2>
            </div>
        </div>

        <div class="row">
            @foreach ($outproducts as $outproduct)
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

<section class="ftco-section1 bg-light">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="billing-heading mb-4">Featured Products</h2>
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

{{-- <section class="ftco-section ftco-choose ftco-no-pb ftco-no-pt">
  <div class="container">
          <div class="row no-gutters">
              <div class="col-lg-4">
                  <div class="choose-wrap divider-one img p-5 d-flex align-items-end" style="background-image: url('frontend/images/choose-1.jpg');">

                  <div class="text text-center text-white px-2">
                          <span class="subheading">Men's Shoes</span>
                      <h2>Men's Collection</h2>
                      <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                      <p><a href="#" class="btn btn-black px-3 py-2">Shop now</a></p>
                  </div>
              </div>
              </div>
              <div class="col-lg-8">
              <div class="row no-gutters choose-wrap divider-two align-items-stretch">
                  <div class="col-md-12">
                      <div class="choose-wrap full-wrap img align-self-stretch d-flex align-item-center justify-content-end" style="background-image: url('frontend/images/choose-2.jpg');">
                          <div class="col-md-7 d-flex align-items-center">
                              <div class="text text-white px-5">
                                  <span class="subheading">Women's Shoes</span>
                                  <h2>Women's Collection</h2>
                                  <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                                  <p><a href="#" class="btn btn-black px-3 py-2">Shop now</a></p>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="row no-gutters">
                          <div class="col-md-6">
                              <div class="choose-wrap wrap img align-self-stretch bg-light d-flex align-items-center">
                                  <div class="text text-center px-5">
                                      <span class="subheading">Summer Sale</span>
                                      <h2>Extra 50% Off</h2>
                                      <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                                      <p><a href="#" class="btn btn-black px-3 py-2">Shop now</a></p>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="choose-wrap wrap img align-self-stretch d-flex align-items-center" style="background-image: url('frontend/images/choose-3.jpg');">
                                  <div class="text text-center text-white px-5">
                                      <span class="subheading">Shoes</span>
                                      <h2>Best Sellers</h2>
                                      <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                                      <p><a href="#" class="btn btn-black px-3 py-2">Shop now</a></p>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
  </div>
</section> --}}

{{-- <section class="ftco-section ftco-deal bg-primary">
  <div class="container">
      <div class="row">
          <div class="col-md-6">
              <img src="{{asset('frontend/images/prod-1.png')}}" class="img-fluid" alt="">
          </div>
          <div class="col-md-6">
              <div class="heading-section heading-section-white">
                  <span class="subheading">Deal of the month</span>
          <h2 class="mb-3">Deal of the month</h2>
        </div>
              <div id="timer" class="d-flex mb-4">
                    <div class="time" id="days"></div>
                    <div class="time pl-4" id="hours"></div>
                    <div class="time pl-4" id="minutes"></div>
                    <div class="time pl-4" id="seconds"></div>
                  </div>
                  <div class="text-deal">
                      <h2><a href="#">Nike Free RN 2019 iD</a></h2>
                      <p class="price"><span class="mr-2 price-dc">$120.00</span><span class="price-sale">$80.00</span></p>
                      <ul class="thumb-deal d-flex mt-4">
                          <li class="img" style="background-image: url('frontend/images/product-6.png')"></li>
                          <li class="img" style="background-image: url('frontend/images/product-2.png')"></li>
                          <li class="img" style="background-image: url('frontend/images/product-4.png')"></li>
                      </ul>
                  </div>
          </div>
      </div>
  </div>
</section> --}}

{{-- <section class="ftco-section testimony-section">
<div class="container">
  <div class="row">
      <div class="col-lg-5">
          <div class="services-flow">
              <div class="services-2 p-4 d-flex ftco-animate">
                  <div class="icon">
                      <span class="flaticon-bag"></span>
                  </div>
                  <div class="text">
                      <h3>Free Shipping</h3>
                      <p class="mb-0">Separated they live in. A small river named Duden flows</p>
                  </div>
              </div>
              <div class="services-2 p-4 d-flex ftco-animate">
                  <div class="icon">
                      <span class="flaticon-heart-box"></span>
                  </div>
                  <div class="text">
                      <h3>Valuable Gifts</h3>
                      <p class="mb-0">Separated they live in. A small river named Duden flows</p>
                  </div>
              </div>
              <div class="services-2 p-4 d-flex ftco-animate">
                  <div class="icon">
                      <span class="flaticon-payment-security"></span>
                  </div>
                  <div class="text">
                      <h3>All Day Support</h3>
                      <p class="mb-0">Separated they live in. A small river named Duden flows</p>
                  </div>
              </div>
              <div class="services-2 p-4 d-flex ftco-animate">
                  <div class="icon">
                      <span class="flaticon-customer-service"></span>
                  </div>
                  <div class="text">
                      <h3>All Day Support</h3>
                      <p class="mb-0">Separated they live in. A small river named Duden flows</p>
                  </div>
              </div>
          </div>
      </div>
    <div class="col-lg-7">
        <div class="heading-section ftco-animate mb-5">
          <h2 class="mb-4">Our satisfied customer says</h2>
          <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
        </div>
      <div class="carousel-testimony owl-carousel">
        <div class="item">
          <div class="testimony-wrap">
            <div class="user-img mb-4" style="background-image: url('frontend/images/person_1.jpg')">
              <span class="quote d-flex align-items-center justify-content-center">
                <i class="icon-quote-left"></i>
              </span>
            </div>
            <div class="text">
              <p class="mb-4 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <p class="name">Garreth Smith</p>
              <span class="position">Marketing Manager</span>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="testimony-wrap">
            <div class="user-img mb-4" style="background-image: url('frontend/images/person_2.jpg')">
              <span class="quote d-flex align-items-center justify-content-center">
                <i class="icon-quote-left"></i>
              </span>
            </div>
            <div class="text">
              <p class="mb-4 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <p class="name">Garreth Smith</p>
              <span class="position">Interface Designer</span>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="testimony-wrap">
            <div class="user-img mb-4" style="background-image: url('frontend/images/person_3.jpg')">
              <span class="quote d-flex align-items-center justify-content-center">
                <i class="icon-quote-left"></i>
              </span>
            </div>
            <div class="text">
              <p class="mb-4 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <p class="name">Garreth Smith</p>
              <span class="position">UI Designer</span>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="testimony-wrap">
            <div class="user-img mb-4" style="background-image: url('frontend/images/person_1.jpg')">
              <span class="quote d-flex align-items-center justify-content-center">
                <i class="icon-quote-left"></i>
              </span>
            </div>
            <div class="text">
              <p class="mb-4 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <p class="name">Garreth Smith</p>
              <span class="position">Web Developer</span>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="testimony-wrap">
            <div class="user-img mb-4" style="background-image: url('frontend/images/person_1.jpg')">
              <span class="quote d-flex align-items-center justify-content-center">
                <i class="icon-quote-left"></i>
              </span>
            </div>
            <div class="text">
              <p class="mb-4 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <p class="name">Garreth Smith</p>
              <span class="position">System Analyst</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section> --}}

{{-- <section class="ftco-gallery">
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
                  <a href="{{asset('frontend/images/gallery-1.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url('frontend/images/gallery-1.jpg');">
                      <div class="icon mb-4 d-flex align-items-center justify-content-center">
                      <span class="icon-instagram"></span>
                  </div>
                  </a>
              </div>
              <div class="col-md-4 col-lg-2 ftco-animate">
                  <a href="{{asset('frontend/images/gallery-2.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url('frontend/images/gallery-2.jpg');">
                      <div class="icon mb-4 d-flex align-items-center justify-content-center">
                      <span class="icon-instagram"></span>
                  </div>
                  </a>
              </div>
              <div class="col-md-4 col-lg-2 ftco-animate">
                  <a href="{{asset('frontend/images/gallery-3.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url('frontend/images/gallery-3.jpg');">
                      <div class="icon mb-4 d-flex align-items-center justify-content-center">
                      <span class="icon-instagram"></span>
                  </div>
                  </a>
              </div>
              <div class="col-md-4 col-lg-2 ftco-animate">
                  <a href="{{asset('frontend/images/gallery-4.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url('frontend/images/gallery-4.jpg');">
                      <div class="icon mb-4 d-flex align-items-center justify-content-center">
                      <span class="icon-instagram"></span>
                  </div>
                  </a>
              </div>
              <div class="col-md-4 col-lg-2 ftco-animate">
                  <a href="{{asset('frontend/images/gallery-5.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url('frontend/images/gallery-5.jpg');">
                      <div class="icon mb-4 d-flex align-items-center justify-content-center">
                      <span class="icon-instagram"></span>
                  </div>
                  </a>
              </div>
              <div class="col-md-4 col-lg-2 ftco-animate">
                  <a href="{{asset('frontend/images/gallery-6.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url('frontend/images/gallery-6.jpg');">
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
<script>
    jQuery(function(){
       jQuery('#contact').click();
    });
</script>
@endpush



