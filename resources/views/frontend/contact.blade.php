@extends('frontend.layouts.app')
@section('content')

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
    <div class="hero-wrap hero-bread" style="background-image: url(frontend/images/bg_6.jpg);">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Contact</span></p>
            <h1 class="mb-0 bread">Contact Us</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section contact-section bg-light">
      <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14130.924632367776!2d85.288939!3d27.6947029!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x6d1869a0ae5929c4!2sRevo%20Deals!5e0!3m2!1sen!2snp!4v1602757836250!5m2!1sen!2snp"
                    height="610" width="100%" style="border:0" allowfullscreen="">
                </iframe>
            </div>
        </div>
        <div class="row block-9">
          <div class="col-md-6 order-md-last d-flex">
            <form action="{{route('customerEmail')}}" class="bg-white p-5 contact-form">
                <h4 class="billing-heading">Message Us</h4>
                <p>Our staff will call back later and answer your questions.</p>
              <div class="form-group">
                <input type="text" name="fullname" class="form-control" placeholder="Your Name">
              </div>
              <div class="form-group">
                <input type="text" name="customeremail" class="form-control" placeholder="Your Email">
              </div>
              <div class="form-group">
                <textarea name="message" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
              </div>
              <div class="form-group">
                <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
              </div>
            </form>

          </div>

          <div class="col-md-6">
            <div class="contact-widget">
                <h4 class="billing-heading mb-3">Contact Us</h4>
                <div class="cw-item">
                    <div class="ci-text">
                        <span>Address:</span>
                        <p><span class="icon icon-map-marker"></span> {{$setting->address}}</p>
                    </div>
                </div>
                <div class="cw-item">
                    <div class="ci-text">
                        <span>Phone:</span>
                        <p><span class="icon icon-phone"></span> +977 {{$setting->phone}}</p>
                    </div>
                </div>
                <div class="cw-item">
                    <div class="ci-text">
                        <span>Email:</span>
                        <p><span class="icon icon-envelope"></span> {{$setting->email}}</p>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
