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

    <div class="hero-wrap hero-bread" style="background-image: url('frontend/images/bg_6.jpg');">
        <div class="container">
          <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="{{route('index')}}">Home</a></span> <span>Blogs</span></p>
              <h1 class="mb-0 bread">KunPhone Blogs</h1>
            </div>
          </div>
        </div>
    </div>


    <section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-8 col-lg-10 order-md-last">
    				<div class="row">
                        @foreach ($allblogs as $blog)
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
                            {{$allblogs->links()}}

                            </div>
                        </div>
		            </div>
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

