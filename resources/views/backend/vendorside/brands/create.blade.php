@extends('backend.layouts.vendor')

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3">Create Brand <a href="{{route('vendor.brands.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Brands</a></h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <form action="{{route('vendor.brands.store')}}" method="POST" class="bg-light p-3" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Brand Name: </label>
                                            <input type="text" name="name" class="form-control" value="{{@old('name')}}" placeholder="Brand Name">
                                            @error('name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="logo">Upload Brand logo: </label>
                                            <input type="file" name="logo" class="form-control">
                                            @error('logo')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description:</label>
                                            <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Write something about the brand..."></textarea>
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

