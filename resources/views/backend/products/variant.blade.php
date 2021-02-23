@extends('backend.layouts.app')
@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3">Create Product Variant => {{$product->name}}</h2>
            <div class="row">
                <div class="col-md-2">
                    <h4>Available Variants:</h4>
                </div>
                <div class="col-md-4">
                    <h4>
                    @foreach ($productstorage as $storage)
                        {{$storage->ram}}/{{$storage->rom}}/Rs. {{$storage->price}} <br>
                    @endforeach
                    </h4>
                </div>
            </div>
            <br>
            <div class="panel">
                <div class="panel-body">
                    <form action="{{route('admin.product.addvariant', $product->slug)}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ram">RAM: </label>
                                    <input type="text" name="ram" class="form-control" value="{{@old('ram')}}" placeholder="RAM Info">
                                    @error('ram')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rom">ROM: </label>
                                    <input type="text" name="rom" class="form-control" value="{{@old('rom')}}" placeholder="ROM Info">
                                    @error('rom')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expandable">Expandable:</label>
                                    <select class="form-control" name="expandable" id="expandable">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price (Rs): </label>
                                    <input type="text" name="price" class="form-control" value="{{@old('price')}}" placeholder="Price">
                                    @error('price')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


