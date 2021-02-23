@extends('backend.layouts.app')

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3">Create Slider <a href="{{route('admin.slider.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Sliders</a></h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <form action="{{route('admin.slider.store')}}" method="POST" class="bg-light p-3" enctype="multipart/form-data">
                            @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hashtitle">Hash Title: </label>
                                            <input type="text" name="hashtitle" class="form-control" placeholder="Hash Title">
                                            @error('hashtitle')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title: </label>
                                            <input type="text" name="title" class="form-control" placeholder="Title">
                                            @error('title')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description :</label><br>
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="10" placeholder="Write about the title..."></textarea>
                                    @error('description')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <p class="text-danger">Note*: Multiple images selected will have the same description.</p>
                                </div>
                                <div class="form-group">
                                    <label for="image">Select Multiple Images</label>
                                    <input type="file" name="images[]" id="uploads" class="form-control" multiple>
                                    @error('images')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
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
