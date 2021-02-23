@extends('frontend.layouts.app')
@section('content')
    <div class="hero-wrap hero-bread" style="background-image: url(frontend/images/bg_6.jpg);">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="{{route('index')}}">Home</a></span></p>
            <h1 class="mb-0 bread">My Cart</h1>
          </div>
        </div>
      </div>
    </div>

    @if (session('success'))
        <div class="row">
            <div class="col-sm-4 ml-auto message scroll">
                <div class="alert  alert-success alert-dismissible fade show" role="alert" style="background: seagreen; color: white;">
                {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="row">
            <div class="col-sm-4 ml-auto message scroll">
                <div class="alert  alert-success alert-dismissible fade show" role="alert" style="background: darkred; color: white;">
                {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <section class="ftco-section ftco-cart">
			<div class="container">
				<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="cart-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>&nbsp;</th>
						        <th>&nbsp;</th>
						        <th>Product</th>
						        <th>Price</th>
						        <th>Quantity</th>
						        <th>Total</th>
						      </tr>
						    </thead>
						    <tbody>
                                @if ($cartproducts->count() == 0)
                                    <tr><td>Cart is empty.</td></tr>
                                @else
                                    @foreach ($cartproducts as $product)
                                        @php
                                            $outgoingproduct = DB::table('product_outgoings')->where('id', $product->product_id)->first();
                                            $cartproduct = DB::table('products')->where('id', $outgoingproduct->product_id)->first();
                                        @endphp
                                        <tr class="text-center">
                                            <td class="product-remove"><a href="{{route('removecart', $product->id)}}"><span class="ion-ios-close"></span></a></td>

                                            <td class="image-prod"><img src="{{Storage::disk('uploads')->url($cartproduct->modelimage)}}" alt="" style="max-height: 100px;"></td>

                                            <td class="product-name">
                                                <h3>{{$cartproduct->name}}</h3>
                                                <p>{{$product->ram}} / {{$product->rom}}</p>
                                            </td>

                                            <td class="price">Rs. {{$product->price}}</td>

                                            <td class="quantity qua-col">
                                                <p style="color: #000;">Total Quantity in Stock: {{$outgoingproduct->quantity}}</p>

                                                <form action="{{route('updatecart', $product->id)}}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                            <div class="input-group d-flex mb-3">
                                                                <div class="pro-qty" style="margin-left: 35px;">
                                                                    <input type="text" name="quantity" value="{{$product->quantity}}">
                                                                </div>
                                                            </div>

                                                    <a href="#" class="btn btn-primary py-3 px-5 mr-2" onclick="this.parentNode.submit()">Update</a>
                                                </form>
                                        </td>
                                            <td class="total">Rs. {{$product->price * $product->quantity }}</td>
                                        </tr><!-- END TR-->
                                    @endforeach
                                @endif
						    </tbody>
						  </table>
					  </div>
    			</div>
    		</div>
    		<div class="row justify-content-start">
    			<div class="col col-md-12 mt-5 cart-wrap ftco-animate">
    				<div class="cart-total mb-3">
                        <h3>Cart Totals</h3>

                        @if ($cartproducts->count() == 0)
                            <p class="d-flex">
                                <span>Subtotal</span>
                                <span>Rs .0.00</span>
                            </p>
                            <p class="d-flex">
                                <span>Delivery</span>
                                <span>Rs. 0.00</span>
                            </p>
                            <hr>
                            <p class="d-flex total-price">
                                <span>Total</span>
                                <span>Rs. 0.00</span>
                            </p>
                        @else
                            @php
                                $sum = 0;
                                foreach ($cartproducts as $product)
                                    $sum = $sum + ($product->price*$product->quantity);
                            @endphp
                            <p class="d-flex">
                                <span>Subtotal</span>
                                <span>Rs. {{$sum}}.00</span>
                            </p>
                            <p class="d-flex">
                                <span>Delivery</span>
                                <span>Rs. 50.00</span>
                            </p>
                            <hr>
                            <p class="d-flex total-price">
                                <span>Total</span>
                                <span>Rs. {{$sum + 50}}.00</span>
                            </p>
                        @endif
                    </div>
                </div>
                <div class="col-md-12 text-center">

                    @if ($cartproducts->count() == 0)
                        <p class="text-center"><a href="{{route('emptycart')}}" class="btn btn-primary py-3 px-4">Proceed to Checkout</a> <a href="{{route('shop')}}" class="btn btn-black py-3 px-4">Go Shopping</a></p>
                    @else
                        <p class="text-center"><a href="{{route('checkout')}}" class="btn btn-primary py-3 px-4">Proceed to Checkout</a> <a href="{{route('shop')}}" class="btn btn-black py-3 px-4">Continue Shopping</a></p>
                    @endif
                </div>
    		</div>
			</div>
		</section>

@endsection
{{-- @push('scripts')
<script>
    $(document).ready(function(){

    var quantitiy=0;
       $('.quantity-right-plus').click(function(e){

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined
                $('#quantity').val(quantity + 1);
                // Increment

        });

         $('.quantity-left-minus').click(function(e){
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

                // Increment
                if(quantity>0){
                $('#quantity').val(quantity - 1);
                }
        });

    });
</script>
@endpush --}}

