@extends('backend.layouts.app')

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3">Edit Slider <a href="{{route('admin.slider.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Sliders</a></h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <form action="{{route('admin.slider.update', $slider->id)}}" method="POST" class="bg-light p-3" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hashtitle">Hash Title: </label>
                                            <input type="text" name="hashtitle" class="form-control" value="{{@old('hashtitle')?@old('hashtitle'):$slider->hashtitle}}" placeholder="Hash Title">
                                            @error('hashtitle')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title: </label>
                                            <input type="text" name="title" class="form-control" value="{{@old('title')?@old('title'):$slider->title}}" placeholder="Title">
                                            @error('title')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description :</label><br>
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="10" placeholder="Write about the title...">{{$slider->description}}</textarea>
                                    @error('description')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="image">Select New Image</label>
                                    <input type="file" name="images[]" id="uploads" class="form-control" multiple>
                                    @error('images')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <p class="text-danger">Note*: If you want the existing image do not select a new one.</p>
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
