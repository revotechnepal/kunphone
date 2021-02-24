@extends('backend.layouts.app')

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            @if(session()->has('failure'))
                <div class="alert alert-danger">
                    {{ session()->get('failure') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <h2 class="mb-3">Create Category <a href="{{route('admin.blogcategory.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Categories</a></h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-body">
                            <form action="{{route('admin.blogcategory.store')}}" method="POST" class="bg-light p-3" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Category Name: </label>
                                            <input type="text" name="name" class="form-control" value="{{@old('name')}}" placeholder="Category Name">
                                            @error('name')
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

