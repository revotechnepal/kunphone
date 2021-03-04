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

<section id="home-section" class="hero">
    <div class="hero-wrap hero-bread" style="margin-top: -110px; padding: 12em 0 0 0; text-align:center">
        {{-- <div class="pre-content-html" style="height:450px;max-width:1200px;position:relative" data-spm-anchor-id="a2a0e.12811.0.i1.1db73255HWff1t"> --}}
            <img src="{{Storage::disk('uploads')->url($currentblog->image)}}" style="width: 90%; object-fit: cover; max-height: 500px;" alt="Blog Photo">
        {{-- </div> --}}
    </div>
</section>
    <section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-8 col-lg-10 order-md-last col-sm-12 col-xs-12">
    				<div class="row">
                        @php
                            $categories = $currentblog->category;

                            foreach ($categories as $cat) {
                                $categoryname = DB::table('blog_categories')->where('id', $cat)->first();
                                $route = route('categoryblogs', $categoryname->slug);
                                echo "<a href='$route' style='color:black'>|$categoryname->name|</a>";
                            }
                        @endphp
		    		</div>
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="heading">{{$currentblog->title}}</h3>
                        </div>

                        <div class="col-md-2">
                            <span class="icon-eye"></span> {{$currentblog->view_count}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <img src="{{Storage::disk('uploads')->url($currentblog->authorimage)}}" height="55px" width="55px">
                        </div>
                        <div class="col-md-4">
                            <p>{{$currentblog->authorname}}<br>
                            Posted on: {{date('F, Y h:m a')}}</p>
                        </div>

                    </div>

                    <div class="row">
                        {!! $currentblog->details !!}
                    </div>

		    	</div>

                <div class="col-md-4 col-lg-2 col-sm-12 col-xs-12">
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
                        {{-- <div class="sidebar-box-2">
                            <h2 class="heading">Popular Blogs</h2>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        @foreach ($popularblogs as $popular)
                                                <a href="{{route('viewblog', $popular->id)}}" style="color: black;"><u>{{$popular->title}}</u></a>
                                        @endforeach
                                    </h4>
                                </div>
                            </div>

                        </div> --}}
                        <div class="sidebar-box-2">
                            <h2 class="heading">Popular Blogs</h2>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        @if (count($popularblogs) == 0)
                                            <p>No blogs.</p>
                                        @endif
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

