@extends('frontend.layouts.app')
@section('content')

    <section class="ftco-section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-10 ftco-animate">
                    <h3 class="mb-4 billing-heading">Exchange Your {{$product->name}}</h3>
                    <div class="card">
                        <br>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <img src="{{Storage::disk('uploads')->url($product->modelimage)}}" alt="{{$product->name}}" style="max-height:  170px;">
                                </div>
                                <div class="col-md-9">
                                    <h5>{{$product->name}}</h5>
                                    <p>Choose a variant</p>
                                    @foreach ($productstorage as $item)
                                        <a href="{{route('sellvariant', $item->id)}}" class="btn btn-secondary">{{$item->ram}}/ {{$item->rom}}</a>
                                    @endforeach
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

