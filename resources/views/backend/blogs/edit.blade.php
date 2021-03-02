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
            <h2 class="mb-3">Edit Blog => {{$blog->id}} <a href="{{route('admin.blog.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Blogs</a></h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <form action="{{route('admin.blog.update', $blog->id)}}" method="POST" class="bg-light p-3" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Blog Title: </label>
                                            <input type="text" name="title" class="form-control" value="{{@old('title')?@old('title'):$blog->title}}" placeholder="Blog Title">
                                            @error('title')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="logo">Upload Image: </label>
                                            <input type="file" name="image" class="form-control">
                                            <span style="color: red; font-size: 12px;">Note*: Leave empty to use previous image</span>
                                            @error('image')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category">Select Categories:</label>
                                            <select class="form-control chosen-select" data-placeholder="Type categories ..." multiple name="category[]">
                                                @foreach ($blogCategories as $blogCategory)
                                                    <option value="{{$blogCategory->id}}" {{in_array($blogCategory->id, $blog->category)?'selected':''}}>{{$blogCategory->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date:</label>
                                            <input type="datetime-local" class="form-control datetimepicker" name="date" value="{{@old('date')?@old('date'):$blog->date}}" placeholder="Date">
                                            @error('date')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="details">Description:</label>
                                            <textarea name="details" id="description" class="form-control" cols="30" rows="10" placeholder="Write something about the brand...">{{$blog->details}}</textarea>
                                            @error('details')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
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

        // $('#summernote').summernote({
        //     height: 200,
        //     placeholder: 'Blog Contents here'

        // });


        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });

        $(function () {

                $('#description').summernote({
                    callbacks: {
                        onImageUpload: function(files) {
                            console.log(files);
                            for(var i=0; i < files.length; i++) {
                                $.upload(files[i]);
                            }
                        }
                    }

                });

                $.upload = function (file) {

                    let out = new FormData();
                    out.append('file', file, file.name);
                    console.log("outform is ",out);
                    $.ajax({
                        method: 'POST',
                        url: '{{ route('admin.blog.store')}}',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'JSON',
                        data: out,
                        success: function (r) {
                            console.log(typeof r);
                            $('#description').summernote('insertImage', r.url);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.error(textStatus + " " + errorThrown);
                        }
                    });
                };
                $(".description").summernote({
                    callbacks : {
                        onMediaDelete : function ($target, $editable) {
                            console.log($target.attr('src'));   // get image url
                        }
                    }
                });


            });


    </script>
@endpush

