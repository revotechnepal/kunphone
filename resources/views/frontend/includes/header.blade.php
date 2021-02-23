<div class="py-1 bg-black">
    <div class="container">
        <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
            <div class="col-lg-12 d-block">
                <div class="row d-flex">
                    <div class="col-md pr-4 d-flex topper align-items-center">
                        <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
                        <span class="text">+977 01-{{$setting->phone}}</span>
                    </div>
                    <div class="col-md pr-4 d-flex topper align-items-center">
                        <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
                        <span class="text" style="text-transform: lowercase;">{{$setting->email}}</span>
                    </div>
                    <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
                        <span class="text">{{$setting->address}}</span>
                    </div>
                </div>
            </div>
        </div>
      </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="{{route('index')}}">{{$setting->site_name}}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a href="{{route('index')}}" class="nav-link">Home</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Buy Phone</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                    <a class="dropdown-item" href="{{route('shop')}}">All Phones</a>
                    <a class="dropdown-item" href="{{route('newshop')}}">New Phones</a>
                    <a class="dropdown-item" href="{{route('oldshop')}}">Used Phones</a>
                </div>
            </li>
            <li class="nav-item">
                @if (Auth::guest() || Auth::user()->role_id != 3)
                    <li class="nav-item"><a href="javascript:void(0)" onclick="openLoginModal();" class="nav-link login-panel">Exchange Phone</a></li>
                @elseif(Auth::user()->role_id==3)
                    <a href="{{route('sellphone')}}" class="nav-link">Exchange Phone</a>
                @endif
            </li>
          {{-- <li class="nav-item"><a href="{{route('about')}}" class="nav-link">Repair Phone</a></li> --}}
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Features</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                    <a class="dropdown-item" href="{{route('compare')}}">Compare Your Phone</a>
                </div>
            </li>
            <li class="nav-item"><a href="{{route('contact')}}" class="nav-link">Contact</a></li>

            @if (Auth::guest() || Auth::user()->role_id != 3)
                <li class="nav-item cta cta-colored"><a href="javascript:void(0)" onclick="openLoginModal();" class="nav-link login-panel"><span class="icon-shopping_cart"></span>[0]</a></li>
                <li class="nav-item"><a href="javascript:void(0)" onclick="openLoginModal();" class="nav-link login-panel"><i class="icomoon icon-user"></i>Login</a></li>
            @elseif(Auth::user()->role_id==3)

            @php
                $cartproducts = DB::table('carts')->where('user_id', Auth::user()->id)->get()->count();
            @endphp
            <li class="nav-item cta cta-colored"><a href="{{route('cart')}}" class="nav-link"><span class="icon-shopping_cart"></span>[{{$cartproducts}}]</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icomoon icon-user"></i>{{Auth::user()->name}}</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <a class="dropdown-item" href="{{route('myaccount')}}">My Account</a>
                        <a class="dropdown-item" href="{{route('myorders')}}">My Orders</a>
                        <a class="dropdown-item" href="{{route('approvedforexchange')}}">My Approved Items</a>
                        <a class="dropdown-item" href="{{route('wishlist')}}">My Wishlist</a>
                        <div class="dropdwn hidden" style="width: 190px;">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </li>
            @endif
        </ul>
      </div>
    </div>
  </nav>
<!-- END nav -->
