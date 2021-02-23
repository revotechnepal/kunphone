@extends('backend.layouts.app')

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3">Edit Vendor <a href="{{route('admin.vendor.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Vendors</a></h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <form action="{{route('admin.vendor.update', $vendor->id)}}" method="POST" class="bg-light p-3">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Vendor Name: </label>
                                            <input type="text" name="name" class="form-control" value="{{@old('name')?@old('name'):$vendor->name}}" placeholder="Vendor Name">
                                            @error('name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Street Address: </label>
                                            <input type="text" name="address" class="form-control" value="{{@old('address')?@old('address'):$vendor->address}}" placeholder="Address">
                                            @error('address')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="district">District: </label>
                                            <input type="text" name="district" class="form-control" value="{{@old('district')?@old('district'):$vendor->district}}" placeholder="Address">
                                            @error('district')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email: </label>
                                            <input type="text" name="email" class="form-control" value="{{@old('email')?@old('email'):$vendor->email}}" placeholder="Address">
                                            @error('email')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone: </label>
                                            <input type="text" name="phone" class="form-control" value="{{@old('phone')?@old('phone'):$vendor->phone}}" placeholder="Address">
                                            @error('phone')
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

