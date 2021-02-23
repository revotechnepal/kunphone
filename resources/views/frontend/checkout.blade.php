@extends('frontend.layouts.app')
@section('content')
    <div class="hero-wrap hero-bread" style="background-image: url(frontend/images/bg_6.jpg);">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="{{route('index')}}">Home</a></span> <span>Checkout</span></p>
            <h1 class="mb-0 bread">Checkout</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-10 ftco-animate">
            <form action="{{route('placeorder')}}" class="billing-form" method="POST">
                @csrf
                @method('POST')
                <h3 class="mb-4 billing-heading">Billing Details</h3>
                    <div class="row align-items-end">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                        <input type="text" name="firstname" class="form-control" placeholder="First Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" class="form-control" placeholder="Last Name">
                        </div>
                    </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="streetaddress">Street Address</label>
                        <input type="text" name="address" class="form-control" placeholder="House number and street name">
                        </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="towncity">Tole</label>
                        <input type="text" class="form-control" name="tole" placeholder="Tole">
                        </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="towncity">Town / City</label>
                        <input type="text" name="town" class="form-control" placeholder="Ex: Kathmandu">
                        </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postcodezip">Postcode / ZIP</label>
                        <input type="text" class="form-control" name="postcode" placeholder="Zip code">
                        </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="latitude">Latitude (Optional)</label>
                        <input type="text" name="latitude" class="form-control" placeholder="Latitude">
                        </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude">Longitude (Optional)</label>
                        <input type="text" class="form-control" name="longitude" placeholder="Longitude">
                        </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Contact no.">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="emailaddress">Email Address</label>
                        <input type="text" name="email" class="form-control" placeholder="Your email address">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Write here..."></textarea>
                        </div>
                    </div>
                    </div>
                    <div class="row mt-5 pt-3 d-flex">
                        <div class="col-md-6 d-flex">
                            <div class="cart-detail cart-total bg-light p-3 p-md-4">
                                <h3 class="billing-heading mb-4">Cart Total</h3>
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
                        <div class="col-md-6">
                            <div class="cart-detail bg-light p-3 p-md-4">
                                <h3 class="billing-heading mb-4">Payment Method</h3>
                                  <div class="form-group">
                                      <div class="col-md-12">
                                          <div class="radio">
                                             <label><input type="radio" name="payment_method" value="bank" class="mr-2"> Direct Bank Tranfer</label>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="col-md-12">
                                          <div class="radio">
                                             <label><input type="radio" name="payment_method" value="cash" class="mr-2"> Cash on Delievery</label>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="col-md-12">
                                          <div class="radio">
                                             <label><input type="radio" name="payment_method" value="esewa" class="mr-2"> E-sewa</label>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="col-md-12">
                                          <div class="checkbox">
                                             <label><input type="checkbox" name="readterms" value="" class="mr-2"> I have read and accept the terms and conditions</label>
                                          </div>
                                      </div>
                                  </div>

                                  <button type="submit" class="btn btn-primary py-3 px-4">Place an order</button>
                                  {{-- <p><a href="" class="btn btn-primary py-3 px-4" onclick="this.parentNode.submit()">Place an order</a></p> --}}
                              </div>
                </form><!-- END -->
	            </div>
	        </div>
          </div> <!-- .col-md-8 -->
        </div>
      </div>
    </section> <!-- .section -->

@endsection

