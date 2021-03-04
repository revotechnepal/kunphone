@extends('backend.layouts.vendor')

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3">Edit Brand => {{$brand->name}} <a href="{{route('vendor.brands.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Brands</a></h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <form action="{{route('vendor.brands.update', $brand->id)}}" method="POST" class="bg-light p-3" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Brand Name: </label>
                                            <input type="text" name="name" class="form-control" value="{{@old('name')?@old('name'):$brand->name}}" placeholder="Brand Name">
                                            @error('name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="logo">Upload New Brand logo: </label>
                                            <input type="file" name="logo" class="form-control">
                                            @error('logo')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                            <p style="color: red; margin-top: 3px;">If you want previous logo, select nothing.</p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description:</label>
                                            <textarea name="description" class="form-control" id="" cols="30" rows="10">{{$brand->description}}</textarea>
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

@endpush
