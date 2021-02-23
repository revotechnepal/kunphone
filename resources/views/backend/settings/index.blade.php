@extends('backend.layouts.app')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" integrity="sha256-n3YISYddrZmGqrUgvpa3xzwZwcvvyaZco0PdOyUKA18=" crossorigin="anonymous" />

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

            <h2 class="mb-3">Website Settings </h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">General Settings</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="socialmedia-tab" data-toggle="tab" href="#socialmedia" role="tab" aria-controls="socialmedia" aria-selected="false">Social Media</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="aboutus-tab" data-toggle="tab" href="#aboutus" role="tab" aria-controls="aboutus" aria-selected="false">About Us</a>
                                </li>
                            </ul>
                            <form action="{{route('admin.setting.store')}}" method="POST">
                                @csrf
                                @method('POST')
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade active in" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="row mb-2">
                                                        <div class="form-group">
                                                            <label for="sitename" class="col-md-3 control-label">Site Name:</label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="site_name" class="form-control" id="sitename" value="{{ @$setting->site_name }}">
                                                            </div>
                                                            @error('site_name')
                                                                <p class="text-danger">{{$message}}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="row mb-2">
                                                        <div class="form-group">
                                                            <label for="email" class="col-md-3 control-label">Site Email:</label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="email" class="form-control" id="email" value="{{ @$setting->email }}">
                                                            </div>
                                                            @error('email')
                                                                <p class="text-danger">{{$message}}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="row mb-2">
                                                        <div class="form-group">
                                                            <label for="phone" class="col-md-3 control-label">Site Phone:</label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="phone" class="form-control" id="phone" value="{{ @$setting->phone }}">
                                                            </div>
                                                            @error('phone')
                                                                <p class="text-danger">{{$message}}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="row mb-2">
                                                        <div class="form-group">
                                                            <label for="address" class="col-md-3 control-label">Address:</label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="address" class="form-control" id="address" value="{{ @$setting->address }}">
                                                            </div>
                                                            @error('address')
                                                                <p class="text-danger">{{$message}}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="socialmedia" role="tabpanel" aria-labelledby="socialmedia-tab">

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="row mb-2">
                                                        <div class="form-group">
                                                            <label for="sfacebook" class="col-md-3 control-label">Facebook:</label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="facebook" class="form-control" id="sfacebook" value="{{ @$setting->facebook }}">
                                                            </div>
                                                            @error('facebook')
                                                                <p class="text-danger">{{$message}}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="row mb-2">
                                                        <div class="form-group">
                                                            <label for="stwitter" class="col-md-3 control-label">Twitter:</label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="twitter" class="form-control" id="stwitter" value="{{ @$setting->twitter }}">
                                                            </div>
                                                            @error('twitter')
                                                                <p class="text-danger">{{$message}}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="row mb-2">
                                                        <div class="form-group">
                                                            <label for="slinkedin" class="col-md-3 control-label">LinkedIn:</label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="linkedin" class="form-control" id="slinkedin" value="{{ @$setting->linkedin }}">
                                                            </div>
                                                            @error('linkedin')
                                                                <p class="text-danger">{{$message}}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="row mb-2">
                                                        <div class="form-group">
                                                            <label for="instagram" class="col-md-3 control-label">instagram:</label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="instagram" class="form-control" id="instagram" value="{{ @$setting->instagram }}">
                                                                <br>
                                                                <p style="color: red">If you don't want to show a social media on front-end, just leave the input field blank.</p>
                                                            </div>
                                                            @error('instagram')
                                                                <p class="text-danger">{{$message}}</p>
                                                            @enderror
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="aboutus" role="tabpanel" aria-labelledby="aboutus-tab">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <textarea name="aboutus" class="form-control" id="summernote">{{ @$setting->aboutus}}</textarea>
                                                </div>
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
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script type="text/javascript">
    $('#summernote').summernote({
        height: 200,
        placeholder: 'Tell customers about us...'
    });
</script>
@endpush
