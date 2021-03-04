@extends('backend.layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" integrity="sha256-n3YISYddrZmGqrUgvpa3xzwZwcvvyaZco0PdOyUKA18=" crossorigin="anonymous" />
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
@endpush
@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3">Show Blog <a href="{{route('admin.blog.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Blogs</a></h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-body">
                            <br>
                            <p><b>Title:</b> {{$blog->title}}</p>
                            <p><b>Category:</b> {{$category}}</p>
                            <p><b>Date:</b> {{date('Y/m/d h:m a', strtotime($blog->date))}}</p>
                            <p><b>Author:</b> {{$blog->authorname}}</p>
                            <p><b>View Count:</b> {{$blog->view_count}}</p><br>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="{{Storage::disk('uploads')->url($blog->image)}}" alt="{{$blog->title}}" style="max-height: 200px; max-width: 350px;">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <p><b>Details: </b></p>
                            {!! $blog->details !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <script>


        $('#summernote').summernote({
            height: 200,
            placeholder: 'Blog Contents here'
        });


        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });


    </script>
@endpush

