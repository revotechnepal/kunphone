<!DOCTYPE html>
<html lang="en">
  <head>
    {!! SEOMeta::generate() !!}
    <link rel = "icon" href = "{{asset('frontend/images/apple.jpg')}}"
        type = "image/x-icon">
    <meta charset="utf-8">

    <meta property="og:http://127.0.0.1:8000" content="http://127.0.0.1:8000"/>
    <meta property="og:KunPhone" content="KunPhone" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/open-iconic-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/s/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/aos.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.timepicker.css')}}">
    <!--{{-- <link rel="stylesheet" href="{{asset('frontend/css/font-awesome.min.css')}}" type="text/css"> --}}-->
    <link rel="stylesheet" href="{{asset('frontend/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/icomoon.css')}}">
    <link href="{{asset('frontend/modalassets/css/login-register.css')}}" rel="stylesheet"/>
    <!--<link rel="stylesheet" href="{{asset('frontend/css/rating.css')}}">-->
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <style>
        .clicked {
        background: black;
        display: none;
        position: absolute;

    }
    .clicked a{
        color: white;
    }
            
    div.stars {
    width: 270px;
    display: inline-block
    }
    
    input.star {
        display: none
    }
    
    label.star {
        float: right;
        padding: 10px;
        font-size: 36px;
        color: gray;
        transition: all .2s
    }
    
    input.star:checked~label.star:before {
        content: '\2605';
        color: #FD4;
        transition: all .25s;
    }
    
    input.star-5:checked~label.star:before {
        color: #FE7;
        text-shadow: 0 0 20px #952
    }
    
    input.star-1:checked~label.star:before {
        color: #F62
    }
    
    label.star:hover {
        transform: rotate(-15deg) scale(1.3)
    }
    
    label.star:before {
        content: '\2605';
    }
    
    .edited {
        color: white;
        background: rgb(155, 151, 151);
    }
    
    .linkedited {
        color: rgb(88, 88, 255);
    }
    
    .linkedited:hover {
        color: rgb(88, 88, 255);
    }
    
    .new {
        background: white;
        border-radius: 0px;
    }
    
    </style>


    @stack('styles')
  </head>

  <body class="goto-here">
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0&appId=398298897927750&autoLogAppEvents=1" nonce="mlKBYHHm"></script>
      <!-- Header Section Begin -->
    @include('frontend.includes.header')
    <!-- Header End -->

    @yield('content')

    <!-- Footer Section Begin -->
    @include('frontend.includes.footer')
    <!-- Footer Section End -->

    @include('frontend.includes.modal')

    <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
  <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
  <script src="{{asset('frontend/js/jquery-migrate-3.0.1.min.js')}}"></script>
  <script src="{{asset('frontend/js/popper.min.js')}}"></script>
  <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('frontend/js/jquery.easing.1.3.js')}}"></script>
  <script src="{{asset('frontend/js/jquery.waypoints.min.js')}}"></script>
  <script src="{{asset('frontend/js/jquery.stellar.min.js')}}"></script>
  <script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
  <script src="{{asset('frontend/js/jquery.magnific-popup.min.js')}}"></script>
  <script src="{{asset('frontend/js/aos.js')}}"></script>
  <script src="{{asset('frontend/js/jquery.animateNumber.min.js')}}"></script>
  <script src="{{asset('frontend/js/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('frontend/js/scrollax.min.js')}}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="{{asset('frontend/js/google-map.js')}}"></script>
  <script src="{{asset('frontend/js/main.js')}}"></script>
  <script src="{{asset('frontend/modalassets/js/login-register.js')}}" type="text/javascript"></script>

<script>
    $(function(){
        var loginpanel = $('.hovbtn');
        var dropdown = $('.dropdwn');
        loginpanel.on('mouseover', function(){
            dropdown.removeClass('hidden');
        })
        loginpanel.on('mouseleave', function(){
            dropdown.addClass('hidden');
        })
        dropdown.on('mouseover', function(){
            dropdown.removeClass('hidden');
        })
        dropdown.on('mouseleave', function(){
            dropdown.addClass('hidden');
        })
    })
</script>

<script>
    function showRegisterForm(){
        $('.loginBox').fadeOut('fast',function(){
            $('.registerBox').fadeIn('fast');
            $('.login-footer').fadeOut('fast',function(){
                $('.register-footer').fadeIn('fast');
            });
            $('.modal-title').html('Register with');
        });
        $('.error').removeClass('alert alert-danger').html('');
    }
    function showLoginForm(){
        $('#loginModal .registerBox').fadeOut('fast',function(){
            $('.loginBox').fadeIn('fast');
            $('.register-footer').fadeOut('fast',function(){
                $('.login-footer').fadeIn('fast');
            });

            $('.modal-title').html('Login with');
        });
        $('.error').removeClass('alert alert-danger').html('');
    }

    function openLoginModal(){
        showLoginForm();
        setTimeout(function(){
            $('#loginModal').modal('show');
        }, 230);
    }
    function openRegisterModal(){
        showRegisterForm();
        setTimeout(function(){
            $('#loginModal').modal('show');
        }, 230);
    }
    </script>

@if ($errors->has('email') || $errors->has('password') || $errors->has('name') ||$errors->has('password_confirmation'))
    <script type="text/javascript">
    showLoginForm();
    setTimeout(function(){
        $('#loginModal').modal('show');
    }, 230);
    shakeModal()
    function shakeModal(){
        $('#loginModal .modal-dialog').addClass('shake');
                setTimeout( function(){
                    $('#loginModal .modal-dialog').removeClass('shake');
        }, 2000 );
    }
    </script>
@endif
<script>
    $(document).ready(function(){
        var tala = $('.clicked');
        var btn = $('.click');

        btn.on('click', function(){
            tala.slideToggle();
        })
    });
</script>

  @stack('scripts')

  </body>
</html>
