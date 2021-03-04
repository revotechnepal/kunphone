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


    <section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-8 col-lg-10 order-md-last">
                    <h3 class="billing-heading">Blogs Having Category {{$currentcategory->name}}</h3>
                    @if (count($categoryblogs) == 0)
                        <p>No blogs related to this category.</p>
                    @else
                        <div class="row mt-5">
                            @foreach ($categoryblogs as $blog)
                                {{-- @php
                                    $product = DB::table('products')->where('id', $outproduct->product_id)->first();
                                    $brand = DB::table('brands')->where('id', $product->brand_id)->first();
                                @endphp --}}
                                <div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
                                    <div class="product d-flex flex-column">


                                                <a href="{{route('viewblog', $blog->id)}}" class="img-prod"><img class="img-fluid" src="{{Storage::disk('uploads')->url($blog->image)}}" alt="Blog Image" style="max-height: auto; width: auto;">

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
                                            <h3><a href="{{route('viewblog', $blog->id)}}">{{$blog->title}}</a></h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row mt-5">
                            <div class="col text-center">
                                <div class="block-27">
                                {{$categoryblogs->links()}}

                                </div>
                            </div>
                        </div>
                    @endif
		    	</div>

                <div class="col-md-4 col-lg-2">
                    <div class="sidebar">
                        <div class="sidebar-box-2">
                            <h2 class="heading">Categories</h2>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        @foreach ($allcategories as $currentcategory)
                                            <a href="{{route('categoryblogs', $currentcategory->slug)}}">{{$currentcategory->name}}</a>
                                        @endforeach
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-box-2">
                            <h2 class="heading">Popular Blogs</h2>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($popularblogs as $popular)
                                                <a href="{{route('viewblog', $popular->id)}}"><p><span style="background: black; color:white; font-size: 20px; padding: 1px 8px 1px 8px">{{$no++}}</span> <u>{{$popular->title}}</u></p></a>

                                        @endforeach
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

