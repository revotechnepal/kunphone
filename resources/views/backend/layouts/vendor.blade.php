<!doctype html>
<html lang="en">

<head>
	<title>KunPhone | Dashboard </title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{asset('backend/assets/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('backend/assets/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('backend/assets/vendor/linearicons/style.css')}}">
	<link rel="stylesheet" href="{{asset('backend/assets/vendor/chartist/css/chartist-custom.css')}}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{asset('backend/assets/css/main.css')}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{asset('backend/assets/css/demo.css')}}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{asset('backend/assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('backend/assets/img/favicon.png')}}">

    @stack('styles')
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="{{route('dashboard')}}"><b style="font-size: 18px;">{{ config('app.name') }}</b></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
                            @php
                                $vendor = DB::table('vendors')->where('name', Auth::user()->name)->first();
                                $neworder = DB::table('notifications')->where('type','App\Notifications\NewOrderNotification')->where('is_read', null)->where('vendor_id', $vendor->id)->count();
                                $exchangeorder = DB::table('notifications')->where('type','App\Notifications\ExchangeOrderNotification')->where('is_read', null)->where('vendor_id', $vendor->id)->count();
                            @endphp
                            @if(Auth::user()->role_id == 4)
    							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                    <i class="lnr lnr-alarm"></i>
                                    @if ($neworder > 0 && $exchangeorder == 0)
                                        <span class="badge bg-danger">1</span>
                                    @elseif ($neworder == 0 && $exchangeorder > 0)
                                        <span class="badge bg-danger">1</span>
                                    @elseif ($neworder > 0 && $exchangeorder > 0)
                                        <span class="badge bg-danger">2</span>
                                    @else
                                        <span class="badge bg-danger">0</span>
                                    @endif

                                </a>
                            @endif

							<ul class="dropdown-menu notifications">
                                @if ($neworder > 0 && $exchangeorder == 0)
                                    <li><a href="{{route('vendor.orders.index')}}" class="notification-item"><span class="dot bg-warning"></span>{{$neworder}} new order has just arrived.</a></li>
                                    <li><a class="notification-item" href="{{route('vendor.notificationsread')}}"><span class="dot bg-danger"></span>Mark all as read</a></li>
                                @elseif ($neworder == 0 && $exchangeorder > 0)
                                    <li><a href="{{route('vendor.exchangeorders.index')}}" class="notification-item"><span class="dot bg-warning"></span>{{$exchangeorder}} new exchange order has just arrived.</a></li>
                                    <li><a class="notification-item" href="{{route('vendor.notificationsread')}}"><span class="dot bg-danger"></span>Mark all as read</a></li>
                                @elseif ($neworder > 0 && $exchangeorder > 0)
                                    <li><a href="{{route('vendor.orders.index')}}" class="notification-item"><span class="dot bg-warning"></span>{{$neworder}} new order has just arrived.</a></li>
                                    <li><a href="{{route('vendor.exchangeorders.index')}}" class="notification-item"><span class="dot bg-warning"></span>{{$exchangeorder}} new exchange order has just arrived.</a></li>
                                    <li><a class="notification-item" href="{{route('vendor.notificationsread')}}"><span class="dot bg-danger"></span>Mark all as read</a></li>

                                @else
                                    <li><a href="{{route('admin.productincoming.index')}}" class="notification-item"><span class="dot bg-success"></span>No new notifications.</a></li>
                                @endif
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="lnr lnr-user"></i><span>{{Auth::user()->name}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                        <i class="lnr lnr-exit"></i><span>{{ __('Logout') }}</span>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="{{route('dashboard')}}" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
						<li><a href="{{route('vendor.profile')}}" class=""><i class="lnr lnr-user"></i> <span>Profile</span></a></li>
                        <li>
                        <li>
							<a href="#subPages5" data-toggle="collapse" class="collapsed"><i class="lnr lnr-exit-up"></i> <span>Outgoing Products</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages5" class="collapse ">
								<ul class="nav">
                                    <li><a href="{{route('vendor.productoutgoing.index')}}" class="">New Products</a></li>
									<li><a href="{{route('vendor.productused.index')}}" class="">Used Products</a></li>
								</ul>
							</div>
						</li>

                        <li>
							<a href="#subPage2" data-toggle="collapse" class="collapsed"><i class="lnr lnr-alarm"></i> <span>Our Orders</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPage2" class="collapse ">
								<ul class="nav">
                                    <li><a href="{{route('vendor.orders.index')}}" class="">View Product Orders</a></li>
                                    <li><a href="{{route('vendor.exchangeorders.index')}}" class="">View Exchange Orders</a></li>
								</ul>
							</div>
                        </li>
                        <hr>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->

      @yield('content')


      <!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; 2020 <a href="https://www.themeineed.com" target="_blank">KunPhone</a>. All Rights Reserved.</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="{{asset('backend/assets/vendor/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('backend/assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('backend/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script src="{{asset('backend/assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
	<script src="{{asset('backend/assets/vendor/chartist/js/chartist.min.js')}}"></script>
    <script src="{{asset('backend/assets/scripts/klorofil-common.js')}}"></script>

    @stack('scripts')
	<script>
        $(function() {
            var data, options;
            // headline charts
            data = {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                series: [
                    [23, 29, 24, 40, 25, 24, 35],
                    [14, 25, 18, 34, 29, 38, 44],
                ]
            };
            options = {
                height: 300,
                showArea: true,
                showLine: false,
                showPoint: false,
                fullWidth: true,
                axisX: {
                    showGrid: false
                },
                lineSmooth: false,
            };
            new Chartist.Line('#headline-chart', data, options);
            // visits trend charts
            data = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                series: [{
                    name: 'series-real',
                    data: [200, 380, 350, 320, 410, 450, 570, 400, 555, 620, 750, 900],
                }, {
                    name: 'series-projection',
                    data: [240, 350, 360, 380, 400, 450, 480, 523, 555, 600, 700, 800],
                }]
            };
            options = {
                fullWidth: true,
                lineSmooth: false,
                height: "270px",
                low: 0,
                high: 'auto',
                series: {
                    'series-projection': {
                        showArea: true,
                        showPoint: false,
                        showLine: false
                    },
                },
                axisX: {
                    showGrid: false,
                },
                axisY: {
                    showGrid: false,
                    onlyInteger: true,
                    offset: 0,
                },
                chartPadding: {
                    left: 20,
                    right: 20
                }
            };
            new Chartist.Line('#visits-trends-chart', data, options);
            // visits chart
            data = {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                series: [
                    [6384, 6342, 5437, 2764, 3958, 5068, 7654]
                ]
            };
            options = {
                height: 300,
                axisX: {
                    showGrid: false
                },
            };
            new Chartist.Bar('#visits-chart', data, options);
            // real-time pie chart
            var sysLoad = $('#system-load').easyPieChart({
                size: 130,
                barColor: function(percent) {
                    return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
                },
                trackColor: 'rgba(245, 245, 245, 0.8)',
                scaleColor: false,
                lineWidth: 5,
                lineCap: "square",
                animate: 800
            });
            var updateInterval = 3000; // in milliseconds
            setInterval(function() {
                var randomVal;
                randomVal = getRandomInt(0, 100);
                sysLoad.data('easyPieChart').update(randomVal);
                sysLoad.find('.percent').text(randomVal);
            }, updateInterval);
            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }
        });
    </script>
</body>

</html>
