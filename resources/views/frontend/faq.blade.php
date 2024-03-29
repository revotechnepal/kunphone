@extends('frontend.layouts.app')
@push('styles')
    <style>
        .faq-section {
        padding-top: 80px;
        padding-bottom: 54px;
    }
    
    .faq-accordin .card {
        border: none;
        margin-bottom: 22px;
    }
    
    .faq-accordin .card .card-heading {
        font-size: 20px;
        color: #252525;
        font-weight: 500;
        cursor: pointer;
    }
    
    .faq-accordin .card .card-heading a {
        padding-left: 42px;
        display: block;
    }
    
    .faq-accordin .card .card-body {
        padding: 0;
        padding-top: 13px;
        padding-bottom: 10px;
    }
    
    .faq-accordin .card .card-body p {
        margin-bottom: 0;
    }
    
    .faq-accordin .card-heading a:after,
    .faq-accordin .card-heading>a.active[aria-expanded=false]:after {
        content: "+";
        font-family: "FontAwesome";
        font-size: 14px;
        color: #404040;
        height: 25px;
        width: 25px;
        text-align: center;
        line-height: 25px;
        background: #EFEFF0;
        margin-top: 3px;
        position: absolute;
        left: 0;
        top: 0;
    }
    
    .faq-accordin .card-heading a[aria-expanded=true]:after,
    .faq-accordin .card-heading>a.active:after {
        content: "-";
        font-family: "FontAwesome";
        float: left;
        font-size: 13px;
        color: #ffffff;
        background: #e7ab3c;
    }
    </style>
@endpush
@section('content')

<div class="faq-section spad ftco-section">
    <div class="container">
        <h2 class="mt-3">Frequesntly Asked Questions (FAQs)</h2>
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="faq-accordin">
                    <div class="accordion" id="accordionExample">
                        @foreach ($faqs as $faq)
                        <div class="card">
                            <div class="card-heading active">
                                <a data-toggle="collapse" data-target="#collapse{{$faq->id}}">
                                    {!!$faq->question!!}
                                </a>
                            </div>
                            <div id="collapse{{$faq->id}}" class="collapse" data-parent="#accordionExample">
                                <div class="card-body">
                                    <p>{!!$faq->answer!!}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
