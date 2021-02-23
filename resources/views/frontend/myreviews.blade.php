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
                        <h4 class="billing-heading text-center">My Reviews and Questions</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="true">My Reviews</a>
                            </li>
                            <li>
                                <a class="nav-link" id="question-tab" data-toggle="tab" href="#question" role="tab" aria-controls="question" aria-selected="false">My Question</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade active show" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                @if (count($reviews) == 0)
                                    You haven't given any reviews.
                                @else
                                    @foreach ($reviews as $review)
                                        @php
                                            $product = DB::table('products')->where('id', $review->product->product_id)->first();
                                        @endphp
                                        <h4 class="billing-heading">Review for {{$product->name}} ({{$review->product->ram}} / {{$review->product->rom}})</h4>
                                        <div class="row mt-3 mb-4">
                                            <div class="col-md-2 text-center">
                                                <img src="{{Storage::disk('uploads')->url($product->modelimage)}}" alt="" style="max-height: 100px;">
                                            </div>
                                            <div class="col-md-10">
                                                <p class="star">
                                                    <span>
                                                        @for ($i = $review->rating; $i > 0; $i--)
                                                            <i class="ion-ios-star"></i>
                                                        @endfor
                                                        @for ($i =5 - $review->rating; $i > 0; $i--)
                                                            <i class="ion-ios-star-outline"></i>
                                                        @endfor
                                                    </span>
                                                     ({{$review->rating}}/5) - {{$review->updated_at->diffForHumans()}}
                                                </p>
                                                <p>{{$review->description}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="tab-pane fade" id="question" role="tabpanel" aria-labelledby="question-tab">
                                @if (count($questions) == 0)
                                    You haven't asked any questions.
                                @else
                                    @foreach ($questions as $question)
                                        @php
                                            $product = DB::table('products')->where('id', $question->product->product_id)->first();
                                        @endphp
                                        <h4 class="billing-heading">Question for {{$product->name}} ({{$question->product->ram}} / {{$question->product->rom}})</h4>
                                        <div class="row mt-3 mb-4">
                                            <div class="col-md-2 text-center">
                                                <img src="{{Storage::disk('uploads')->url($product->modelimage)}}" alt="" style="max-height: 100px;">
                                            </div>
                                            <div class="col-md-10">
                                                @if ($question->answer == null)
                                                    <p><b>Q:</b> {{$question->question}} - {{$question->created_at->diffForHumans()}}</p>
                                                @else
                                                    <p><b>Q:</b> {{$question->question}} - {{$question->created_at->diffForHumans()}}</p>
                                                    <p><b>A:</b> {{$question->answer}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
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
