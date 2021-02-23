@extends('frontend.layouts.app')
@section('content')

    <section class="ftco-section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-10 ftco-animate">
                    <h3 class="mb-4 billing-heading">Exchange Your {{$productstorage->product->name}} ({{$productstorage->ram}} / {{$productstorage->rom}})</h3>
                    <div class="card">
                        <br>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <img src="{{Storage::disk('uploads')->url($productstorage->product->modelimage)}}" alt="{{$productstorage->product->name}}" style="max-height:  170px;">
                                </div>
                                <div class="col-md-9">
                                    <h5>{{$productstorage->product->name}}</h5>
                                    <p>Valued Upto</p>
                                    <h3 style="color: red;">
                                        Rs.
                                        @php
                                            echo (60/100)*$productstorage->price;
                                        @endphp
                                    </h3>

                                    <p><a href="{{route('details',['slug' => $productstorage->product->slug, 'id' => $productstorage->id])}}" class="btn btn-info">Get Exact Value</a></p>
                                </div>
                            </div>
                        </div>

                        <br>
                        <br>
                        <br>
                    </div>
                <!-- END -->
                </div>
            </div> <!-- .col-md-8 -->
        </div>
    </section> <!-- .section -->

@endsection

