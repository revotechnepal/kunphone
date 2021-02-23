@extends('backend.layouts.app')
@push('styles')
    <!-- Algolia Search -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/algolia_productoutgoing.css') }}">
@endpush
@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <h2 class="mb-3">Edit Outgoing Product <a href="{{route('admin.productused.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i> View All Products</a></h2>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <form action="{{route('admin.productused.update', $productoutgoing->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{-- <label for="name">Model Name: </label>
                                            <input type="text" name="name" class="form-control" value="{{@old('name')}}" placeholder="Enter Model Name">
                                            @error('name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror --}}
                                            <label for="name">Model Name: </label>
                                            <div class="aa-input-container" id="aa-input-container">
                                                <input type="text" id="aa-search-input" class="aa-input-search" placeholder="Select the model" name="name" value="{{@old('name')?@old('name'):$product->name}}"
                                                    autocomplete="off" />
                                            </div>
                                            @error('name')
                                                        <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="modelimages">Upload Product Image (Multiple images can be selected):</label>
                                            <input type="file" name="modelimages[]" class="form-control" multiple>
                                            <p class="text-danger">If you want previous images don't select any new images.</p>
                                        </div>
                                        @error('modelimages')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="accessories">Accessories Available: </label>
                                            <input type="text" name="accessories" class="form-control" value="{{@old('accessories')?@old('accessories'):$productoutgoing->accessories}}" placeholder="Enter accessories">
                                            @error('accessories')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quantity">Vendor: </label>
                                                <select name="vendor" id="" class="form-control">
                                                    <option value="">--Select a vendor--</option>
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{$vendor->id}}"{{$vendor->id == $productoutgoing->vendor_id?'selected':''}}>{{$vendor->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('vendor')
                                                    <p class="text-danger">{{$message}}</p>
                                                @enderror
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ram">RAM: </label>
                                            <input type="text" name="ram" class="form-control" value="{{@old('ram')?@old('ram'):$productoutgoing->ram}}" placeholder="Ex: 4 GB">
                                            @error('ram')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rom">ROM: </label>
                                            <input type="text" name="rom" class="form-control" value="{{@old('rom')?@old('rom'):$productoutgoing->rom}}" placeholder="Ex: 32 GB">
                                            @error('rom')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price">Price (Rs): </label>
                                            <input type="text" name="price" class="form-control" value="{{@old('price')?@old('price'):$productoutgoing->price}}" placeholder="Enter Price">
                                            @error('price')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="color">Color: </label>
                                            <input type="text" name="color" class="form-control" value="{{@old('color')?@old('color'):$productoutgoing->color}}" placeholder="Enter Color">
                                            @error('color')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="details">Description</label>
                                            <textarea name="details" id="" class="form-control" cols="30" rows="10" placeholder="Any more details to know..">{{$productoutgoing->details}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="checkbox" name="featured" value="1" {{$productoutgoing->is_featured == 1 ? 'checked' : ''}}>&nbsp;
                                            <label for="featured">Featured</label>
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
    </div>
@endsection
@push('scripts')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('backend/assets/scripts/algolia_productoutgoing.js') }}"></script>
@endpush

