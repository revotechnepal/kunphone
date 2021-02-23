@extends('backend.layouts.app')

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3">Edit FAQ <a href="{{route('admin.faqs.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Faqs</a></h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                   <form action="{{route('admin.faqs.update', $faq->id)}}" method="POST" class="bg-light p-3">
                                    @csrf
                                    @method('PUT')
                                        <div class="form-group">
                                            <label for="question">Question :</label><br>
                                            <input type="text" name="question" class="form-control" placeholder="FAQ question??" value="{{$faq->question}}">
                                            @error('question')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="answer">Answer :</label><br>
                                            <textarea name="answer" class="form-control" id="answer" cols="30" rows="10" placeholder="Give Answer here...">{{$faq->answer}}</textarea>
                                            @error('answer')
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
    </div>
</div>
@endsection

