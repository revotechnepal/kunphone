@extends('frontend.layouts.app')

@section('content')

<section class="ftco-section bg-light">
    <div class="container">
        <h1>About Us</h1>

        <p>{!!$aboutus->aboutus!!}</p>
    </div>
</section>
@endsection

