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
    <section class="ftco-section">
    	<div class="container">
    		<div class="row">
    			<div class="col-lg-6 mb-5 ftco-animate">
                    @if ($outgoingproduct->condition == 'new')
                        <a href="{{Storage::disk('uploads')->url($product->modelimage)}}" class="image-popup prod-img-bg"><img src="{{Storage::disk('uploads')->url($product->modelimage)}}" class="img-fluid" alt="" style="max-height: auto; max-width: auto;">
                        </a>

                    @elseif ($outgoingproduct->condition == 'used')
                        @php
                            $productimage = DB::table('product_useds')->where('used_product_id', $outgoingproduct->id)->first();
                            $productimages = DB::table('product_useds')->where('used_product_id', $outgoingproduct->id)->get();
                        @endphp
                        <a href="{{Storage::disk('uploads')->url($productimage->modelimage)}}" class="image-popup prod-img-bg"><img src="{{Storage::disk('uploads')->url($productimage->modelimage)}}" class="img-fluid product-big-img" alt="" style="max-height: auto; width: auto;">
                        </a>
                        <div class="product-thumbs mt-3">
                            <div class="product-thumbs-track ps-slider owl-carousel">
                                @foreach ($productimages as $productimage)
                                <div class="pt" data-imgbigurl="{{Storage::disk('uploads')->url($productimage->modelimage)}}">
                                    <img src="{{Storage::disk('uploads')->url($productimage->modelimage)}}" alt="">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

    			</div>
    			<div class="col-lg-6 product-details pl-md-5 ftco-animate">
    				<h3>{{$product->name}}</h3>
    				    <div class="rating d-flex">
							    @php
                                    $avgRatingFloat = DB::table('reviews')->where('product_id', $outgoingproduct->id)->avg('rating');
                                    $avgRating = number_format((float)$avgRatingFloat, 1, '.', '');
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="rateyos-readonly-widg"></div>
                                    </div>

                                    <div class="col-md-6" style="margin-top: -3px">
                                       <p style="color: #e7ab3c;">&nbsp;&nbsp;({{$avgRating}} / 5) </p>
                                    </div>
                                </div>
                        </div>
                        <div class="fb-share-button" data-href="http://phone.revonepal.com/product/{{$outgoingproduct->id}}/{{$product->slug}}" data-layout="button" data-size="small">
                            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2F127.0.0.1%3A8000%2Fproduct%2Fid%2Fslug&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">
                                Share
                            </a>
                        </div>

                        <h4 class="heading mt-3">Type</h4>

                        @if ($outgoingproduct->condition == 'new')
                                <span class="status">New Phone</span>
                            @elseif($outgoingproduct->condition == 'used')
                                <span class="status">Used Phone</span>
                        @endif
                        <h4 class="heading">Color</h4>

                        {{$outgoingproduct->color}}

                        <h4 class="heading">Storage Info</h4>
                        <p>{{$outgoingproduct->ram}}/{{$outgoingproduct->rom}}</p>

                        @if ($outgoingproduct->condition == 'new')

                    @elseif($outgoingproduct->condition == 'used')
                        <h4 class="heading mt-3">SKU</h4>
                        <span class="status">{{$outgoingproduct->sku}}</span>
                    @endif
                    <p class="price"><span style="red">Rs. {{$outgoingproduct->price}}</span></p>


                    <div class="col-md-12">
                        <p style="color: #000;">{{$outgoingproduct->quantity}} piece available</p>
                    </div>
    				{{-- <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
    				<p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.
						</p> --}}
                    <p>
                        @if(Auth::guest() || Auth::user()->role_id != 3)
                            <a href="javascript:void(0)" onclick="openLoginModal();" class="login-panel btn btn-black py-3 px-5 mr-2">Add to Cart</a>
                            <a href="javascript:void(0)" onclick="openLoginModal();" class="login-panel btn btn-primary py-3 px-5">Add to Wishlist</a>
                        @elseif(Auth::user()->hasRole('user'))
                            <form action="{{route('addtocart', $outgoingproduct->id)}}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="row mt-4">
                                    <div class="w-100"></div>
                                        <div class="input-group col-md-6 d-flex mb-3">
                                        <span class="input-group-btn mr-2">
                                            <button type="button" class="quantity-left-minus btn"  data-type="minus" data-field="">
                                                <i class="ion-ios-remove"></i>
                                            </button>
                                        </span>
                                        <input type="text" id="quantity" name="quantity" class="quantity form-control input-number" value="1" min="1" max="100">
                                        <span class="input-group-btn ml-2">
                                            <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                                <i class="ion-ios-add"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <div class="w-100"></div>
                                </div>

                                <a href="#" class="btn btn-black py-3 px-5 mr-2" onclick="this.parentNode.submit()">Add to Cart</a>
                                <a href="{{route('addtowishlist', $outgoingproduct->id)}}" class="btn btn-primary py-3 px-5">Add to Wishlist</a>
                            </form>
                        @endif

                    </p>
                </div>
    		</div>
    		<div class="row mt-5">
          <div class="col-md-12 nav-link-wrap">
            <div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link ftco-animate active mr-lg-1" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Description</a>

              <a class="nav-link ftco-animate mr-lg-1" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Manufacturer</a>

              <a class="nav-link ftco-animate" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Reviews</a>

            </div>
          </div>
          <div class="col-md-12 tab-wrap">

            <div class="tab-content bg-light" id="v-pills-tabContent">

              <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="day-1-tab">
              	<div class="p-4">
                      <h3 class="mb-4">{{$product->name}}</h3>

                      <div class="row">
                          <div class="col-md-2">
                            Type:
                          </div>
                          <div class="col-md-10">
                            @if ($outgoingproduct->condition == 'new')
                                <span class="status">New Phone</span>
                            @elseif($outgoingproduct->condition == 'used')
                                <span class="status">Used Phone</span>
                            @endif
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-md-2">
                            Color:
                        </div>
                        <div class="col-md-10">
                            {{$outgoingproduct->color}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            Storage info:
                        </div>
                        <div class="col-md-10">
                            {{$outgoingproduct->ram}} / {{$outgoingproduct->rom}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Available Accessories:
                        </div>
                        <div class="col-md-10">
                            {{$outgoingproduct->accessories}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Available Quantity:
                        </div>
                        <div class="col-md-10">
                            {{$outgoingproduct->quantity}} available in stock.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Unit Price:
                        </div>
                        <div class="col-md-10">
                            Rs. {{$outgoingproduct->price}}
                        </div>
                    </div>
                    @if ($outgoingproduct->condition == 'new')

                    @elseif ($outgoingproduct->condition == 'used')
                    <div class="row">
                        <div class="col-md-2">
                            SKU:
                        </div>
                        <div class="col-md-10">
                            {{$outgoingproduct->sku}}
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-2">
                            Vendor:
                        </div>
                        <div class="col-md-10">
                            {{$outgoingproduct->vendor->name}}
                        </div>
                    </div>
                    @if ($outgoingproduct->details == null)

                    @else
                    <div class="row">
                        <div class="col-md-2">
                            Details:
                        </div>
                        <div class="col-md-10">
                            {{$outgoingproduct->details}}
                        </div>
                    </div>
                    @endif
              	</div>
              </div>

              <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-day-2-tab">
              	<div class="p-4">
                      <h3 class="mb-4">Manufactured By {{$product->brand->name}}</h3>
                      <div class="row">
                        <div class="col-md-3">
                            <img src="{{Storage::disk('uploads')->url($product->brand->logo)}}" alt="" style="max-height: 500px; width: 250px; border-radius:10px;">
                        </div>
                        <div class="col-md-9">
                            <p>{{$product->brand->description}}</p>
                        </div>
                      </div>
              	</div>
              </div>
              <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-day-3-tab">
              	<div class="row p-4">
                    <div class="col-md-7">
                        @if (count($allreviews) == 0)
                            <h3 class="mb-4">Reviews for this Phone</h3>
                            <div class="review">
                                <div class="desc">
                                    <p>No reviews for this phone.</p>
                                </div>
                            </div>
                        @else
                            <h3 class="mb-4">Reviews for this Phone</h3>
                            <h4 class="mb-4">{{count($allreviews)}} Reviews</h4>
                            <div class="review">
                                <img src="{{Storage::disk('uploads')->url('user.jpg')}}" alt="" style="max-height: 90px; border-radius: 100px;">
                                <div class="desc">
                                    @foreach ($allreviews as $review)
                                        <h4>
                                            <span class="text-left">{{$review->user->name}}</span>
                                            <span class="text-center">{{$review->updated_at->diffForHumans()}}</span>
                                        </h4>
                                        <p class="star">
                                            <span>
                                                @for ($i = $review->rating; $i > 0; $i--)
                                                    <i class="ion-ios-star"></i>
                                                @endfor
                                                @for ($i =5 - $review->rating; $i > 0; $i--)
                                                    <i class="ion-ios-star-outline"></i>
                                                @endfor
                                            </span>
                                        </p>
                                        <p>{{$review->description}}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="col-md-4">
                        <div class="rating-wrap">
                            <h3 class="mb-4"></h3>
                            <p class="star">
                                <span>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star"></i>
                                </span>
                                @php
                                    $starreviews5 = DB::table('reviews')->where('product_id', $outgoingproduct->id)->where('rating', 5)->get();
                                @endphp
                                <span>{{count($starreviews5)}} Reviews</span>
                            </p>
                            <p class="star">
                                <span>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star-outline"></i>
                                </span>
                                @php
                                    $starreviews4 = DB::table('reviews')->where('product_id', $outgoingproduct->id)->where('rating', 4)->get();
                                @endphp
                                <span>{{count($starreviews4)}} Reviews</span>
                            </p>
                            <p class="star">
                                <span>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                </span>
                                @php
                                    $starreviews3 = DB::table('reviews')->where('product_id', $outgoingproduct->id)->where('rating', 3)->get();
                                @endphp
                                <span>{{count($starreviews3)}} Reviews</span>
                            </p>
                            <p class="star">
                                <span>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                </span>
                                @php
                                    $starreviews2 = DB::table('reviews')->where('product_id', $outgoingproduct->id)->where('rating', 2)->get();
                                @endphp
                                <span>{{count($starreviews2)}} Reviews</span>
                            </p>
                            <p class="star">
                                <span>
                                    <i class="ion-ios-star"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                    <i class="ion-ios-star-outline"></i>
                                </span>
                                @php
                                    $starreviews1 = DB::table('reviews')->where('product_id', $outgoingproduct->id)->where('rating', 1)->get();
                                @endphp
                                <span>{{count($starreviews1)}} Reviews</span>
                            </p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row p-4">
                    <div class="col-md-8">
                        <h3 class="mb-4">Queries for this Phone</h3>
                        @if (count($questions) == 0)
                            <p>No questions for this product.</p>
                        @else
                            @foreach ($questions as $question)
                                <div class="review">
                                    <img src="{{Storage::disk('uploads')->url('user.jpg')}}" alt="" style="max-height: 100px; border-radius: 100px;">
                                    <div class="desc">
                                        <h4>
                                            <span class="text-left"><b>{{$question->user->name}}</b></span>
                                            <span class="text-right">{{$question->created_at->diffForHumans()}}</span>
                                        </h4>
                                        @if ($question->answer == null)
                                            <p><b>Q:</b> {{$question->question}}</p>
                                        @else
                                            <p><b>Q:</b> {{$question->question}}</p>
                                            <p><b>A:</b> {{$question->answer}}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="col-md-4"></div>

                    <div class="col-md-12">
                        <hr>
                        <form action="{{route('questions', $outgoingproduct->id)}}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group mt-2">
                                        <input type="text" class="form-control" name="question" placeholder="Ask your question...">
                                    </div>
                                </div>
                                <div class="col-md-2">

                                    @if(Auth::guest() || Auth::user()->role_id != 3)
                                        <a href="javascript:void(0)" onclick="openLoginModal();" class="login-panel btn btn-primary py-4 px-5">Submit</a>
                                    @elseif(Auth::user()->hasRole('user'))
                                        <button type="submit" class="btn btn-primary py-4 px-5">Submit</button>
                                    @endif
                                </div>
                            </div>
                        </form>
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
<script>
    $(document).ready(function(){

    var quantitiy=0;
       $('.quantity-right-plus').click(function(e){

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined
                $('#quantity').val(quantity + 1);
                // Increment
        });
         $('.quantity-left-minus').click(function(e){
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());
            // If is not undefined
                // Increment
                if(quantity>0){
                $('#quantity').val(quantity - 1);
                }
        });

    });
</script>

{{-- <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script> --}}
<script type="text/javascript" src="{{asset('frontend/StarRating/src/jquery.rateyo.js')}}"></script>

<script>

  $(function () {

    var rating = {{$avgRating}};

    $(".rateyos-readonly-widg").rateYo({

      rating: rating,
      numStars: 5,
      precision: 2,
      starWidth: "20px",
      minValue: 1,
      maxValue: 5
    }).on("rateyo.change", function (e, data) {
      console.log(data.rating);
    });

    $(".rateyo-readonly-widg").rateYo({

        rating: rating,
        numStars: 5,
        precision: 2,
        starWidth: "32px",
        minValue: 1,
        maxValue: 5
        }).on("rateyo.change", function (e, data) {
        console.log(data.rating);
        });
  });
</script>

@endpush
