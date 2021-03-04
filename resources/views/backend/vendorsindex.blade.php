@extends('backend.layouts.vendor')

@section('content')

        <div class="main">

                <div class="main-content">
				<div class="container-fluid">
				    <div class="row">
				        <div class="col-md-12">
				            <div class="panel panel-headline">
						<div class="panel-heading text-center">
							<h3 class="panel-title">{{$vendor->name}}</h3>
							<p class="panel-subtitle">{{date('F j, Y')}}</p>
						</div>

						<div class="panel-body">
							<div class="row">
								<a href="{{route('vendor.productoutgoing.index')}}">
                                    <div class="col-md-4">
                                        <div class="metric">
                                            <span class="icon"><i class="fa fa-sign-out"></i></span>
                                            <p>
                                                <span class="number">{{$outgoingproduct->count()}}</span>
                                                <span class="title">Outgoing Products</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
								<a href="{{route('vendor.orders.index')}}">
                                    <div class="col-md-4">
                                        <div class="metric">
                                            <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                                            <p>
                                                <span class="number">{{$orderedproducts->count()}}</span>
                                                <span class="title">Products Sold</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
								<a href="{{route('vendor.exchangeorders.index')}}">
                                    <div class="col-md-4">
                                        <div class="metric">
                                            <span class="icon"><i class="fa fa-exchange"></i></span>
                                            <p>
                                                <span class="number">{{$exchangeorders->count()}}</span>
                                                <span class="title">Exchanges Completed</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
								{{-- <div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fa fa-bar-chart"></i></span>
										<p>
											<span class="number">35%</span>
											<span class="title">Conversions</span>
										</p>
									</div>
								</div> --}}
							</div>
							<div class="row">
								{{-- <div class="col-md-9">
									<div id="headline-chart" class="ct-chart"></div>
								</div> --}}
								<div class="col-md-4">
									<div class="weekly-summary text-center">
										<span class="number">{{$totalorders}}</span>
										<span class="info-label">Total Order<br>
                                        (Till date)</span>
									</div>
                                </div>
                                <div class="col-md-4">
									<div class="weekly-summary text-center">
										<span class="number">Rs. {{$monthlyincome}}</span>
										<span class="info-label">Monthly Income
                                            <br>({{date('F, Y')}})
                                        </span>
									</div>
                                </div>
                                <div class="col-md-4">
									<div class="weekly-summary text-center">
										<span class="number">Rs. {{$income}}</span>
										<span class="info-label">Total Income<br>
                                            (Till date)</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				        </div>
				    </div>

					 <!--END OVERVIEW -->
					<div class="row">
						<div class="col-md-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title text-center"><b>Last 10 Product orders</b></h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										{{-- <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> --}}
									</div>
								</div>
								<div class="panel-body no-padding">
									<table class="table table-striped text-center">
										<thead>
											<tr>
												<th class="text-center">Order No.</th>
												<th class="text-center">Customer Name</th>
												<th class="text-center">Product Name</th>
												<th class="text-center">Ordered Date</th>
												<th class="text-center">Status</th>
											</tr>
										</thead>
										<tbody>
                                            @if ($orders->count() == 0)
                                                <tr>
                                                    <td colspan="5">There are no orders yet.</td>
                                                </tr>
                                            @else
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td>{{$order->order_id}}</td>
                                                        <td>
                                                            @php
                                                                $mainorder = DB::table('orders')->where('id', $order->order_id)->first();
                                                                $user = DB::table('users')->where('id', $mainorder->user_id)->first();
                                                            @endphp
                                                            {{$user->name}}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $outgoingproduct = DB::table('product_outgoings')->where('id', $order->product_id)->first();
                                                                $product = DB::table('products')->where('id', $outgoingproduct->product_id)->first();
                                                            @endphp
                                                            {{$product->name}}<br>
                                                            @if ($outgoingproduct->condition == 'new')
                                                                (New Phone)
                                                            @else
                                                                (Used Phone)
                                                            @endif
                                                            {{-- ($outgoingproduct->condition) --}}
                                                        </td>
                                                        <td>{{date('F j, Y', strtotime($order->created_at))}}</td>
                                                        <td><span class="label label-success">{{$order->orderStatus->status}}</span></td>
                                                    </tr>
                                                @endforeach
                                            @endif

											{{-- <tr>
												<td><a href="#">763648</a></td>
												<td>Steve</td>
												<td>$122</td>
												<td>Oct 21, 2016</td>
												<td><span class="label label-success">COMPLETED</span></td>
											</tr>
											<tr>
												<td><a href="#">763649</a></td>
												<td>Amber</td>
												<td>$62</td>
												<td>Oct 21, 2016</td>
												<td><span class="label label-warning">PENDING</span></td>
											</tr>
											<tr>
												<td><a href="#">763650</a></td>
												<td>Michael</td>
												<td>$34</td>
												<td>Oct 18, 2016</td>
												<td><span class="label label-danger">FAILED</span></td>
											</tr>
											<tr>
												<td><a href="#">763651</a></td>
												<td>Roger</td>
												<td>$186</td>
												<td>Oct 17, 2016</td>
												<td><span class="label label-success">SUCCESS</span></td>
											</tr>
											<tr>
												<td><a href="#">763652</a></td>
												<td>Smith</td>
												<td>$362</td>
												<td>Oct 16, 2016</td>
												<td><span class="label label-success">SUCCESS</span></td>
											</tr> --}}
										</tbody>
									</table>
								</div>
								<div class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right"><a href="{{route('vendor.orders.index')}}" class="btn btn-primary">View All Product Orders</a></div>
									</div>
								</div>
							</div>
						</div>




                        <div class="col-md-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title text-center"><b>Last 10 Exchange orders</b></h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										{{-- <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> --}}
									</div>
								</div>
								<div class="panel-body no-padding">
									<table class="table table-striped text-center">
										<thead>
											<tr>
												<th class="text-center">Customer Name</th>
												<th class="text-center">Owner Product</th>
												<th class="text-center">Exchane with</th>
												<th class="text-center">Ordered Date</th>
												<th class="text-center">Status</th>
											</tr>
										</thead>
										<tbody>
                                            @if ($exchangeOrders->count() == 0)
                                                <tr>
                                                    <td colspan="5">There are no exchange orders yet.</td>
                                                </tr>
                                            @else
                                                @foreach ($exchangeOrders as $order)
                                                    <tr>
                                                        <td>
                                                            @php
                                                                $user = DB::table('users')->where('id', $order->user_id)->first();
                                                            @endphp
                                                            {{$user->name}}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $incomingproduct = DB::table('product_incomings')->where('id', $order->incomingproduct_id)->first();
                                                                $product = DB::table('products')->where('id', $incomingproduct->product_id)->first();
                                                            @endphp
                                                            {{$product->name}}
                                                            {{-- ($outgoingproduct->condition) --}}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $outgoingproduct = DB::table('product_outgoings')->where('id', $order->outgoingproduct_id)->first();
                                                                $product = DB::table('products')->where('id', $outgoingproduct->product_id)->first();
                                                            @endphp
                                                            {{$product->name}}<br>
                                                            @if ($outgoingproduct->condition == 'new')
                                                                (New Phone)
                                                            @else
                                                                (Used Phone)
                                                            @endif
                                                            {{-- ($outgoingproduct->condition) --}}
                                                        </td>
                                                        <td>{{date('F j, Y', strtotime($order->created_at))}}</td>
                                                        <td>
                                                            <span class="label label-success">
                                                                @if ($order->is_processsing == 0)
                                                                    Exchange Completed
                                                                @elseif ($order->is_processsing == 1)
                                                                    Exchange Processing
                                                                @elseif ($order->is_processsing == 2)
                                                                    Cancelled
                                                                @endif
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

											{{-- <tr>
												<td><a href="#">763648</a></td>
												<td>Steve</td>
												<td>$122</td>
												<td>Oct 21, 2016</td>
												<td><span class="label label-success">COMPLETED</span></td>
											</tr>
											<tr>
												<td><a href="#">763649</a></td>
												<td>Amber</td>
												<td>$62</td>
												<td>Oct 21, 2016</td>
												<td><span class="label label-warning">PENDING</span></td>
											</tr>
											<tr>
												<td><a href="#">763650</a></td>
												<td>Michael</td>
												<td>$34</td>
												<td>Oct 18, 2016</td>
												<td><span class="label label-danger">FAILED</span></td>
											</tr>
											<tr>
												<td><a href="#">763651</a></td>
												<td>Roger</td>
												<td>$186</td>
												<td>Oct 17, 2016</td>
												<td><span class="label label-success">SUCCESS</span></td>
											</tr>
											<tr>
												<td><a href="#">763652</a></td>
												<td>Smith</td>
												<td>$362</td>
												<td>Oct 16, 2016</td>
												<td><span class="label label-success">SUCCESS</span></td>
											</tr> --}}
										</tbody>
									</table>
								</div>
								<div class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right"><a href="{{route('vendor.exchangeorders.index')}}" class="btn btn-primary">View All Exchange Orders</a></div>
									</div>
								</div>
							</div>
						</div>
						{{-- <div class="col-md-6">
							 MULTI CHARTS
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Projection vs. Realization</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body">
									<div id="visits-trends-chart" class="ct-chart"></div>
								</div>
							</div>
							 END MULTI CHARTS
						</div> --}}
					</div>
					{{-- <div class="row">
						<div class="col-md-7">
							 TODO LIST
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">To-Do List</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body">
									<ul class="list-unstyled todo-list">
										<li>
											<label class="control-inline fancy-checkbox">
												<input type="checkbox"><span></span>
											</label>
											<p>
												<span class="title">Restart Server</span>
												<span class="short-description">Dynamically integrate client-centric technologies without cooperative resources.</span>
												<span class="date">Oct 9, 2016</span>
											</p>
											<div class="controls">
												<a href="#"><i class="icon-software icon-software-pencil"></i></a> <a href="#"><i class="icon-arrows icon-arrows-circle-remove"></i></a>
											</div>
										</li>
										<li>
											<label class="control-inline fancy-checkbox">
												<input type="checkbox"><span></span>
											</label>
											<p>
												<span class="title">Retest Upload Scenario</span>
												<span class="short-description">Compellingly implement clicks-and-mortar relationships without highly efficient metrics.</span>
												<span class="date">Oct 23, 2016</span>
											</p>
											<div class="controls">
												<a href="#"><i class="icon-software icon-software-pencil"></i></a> <a href="#"><i class="icon-arrows icon-arrows-circle-remove"></i></a>
											</div>
										</li>
										<li>
											<label class="control-inline fancy-checkbox">
												<input type="checkbox"><span></span>
											</label>
											<p>
												<strong>Functional Spec Meeting</strong>
												<span class="short-description">Monotonectally formulate client-focused core competencies after parallel web-readiness.</span>
												<span class="date">Oct 11, 2016</span>
											</p>
											<div class="controls">
												<a href="#"><i class="icon-software icon-software-pencil"></i></a> <a href="#"><i class="icon-arrows icon-arrows-circle-remove"></i></a>
											</div>
										</li>
									</ul>
								</div>
							</div>
							 END TODO LIST
						</div>
						<div class="col-md-5">
							 TIMELINE
							<div class="panel panel-scrolling">
								<div class="panel-heading">
									<h3 class="panel-title">Recent User Activity</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body">
									<ul class="list-unstyled activity-list">
										<li>
											<img src="{{asset('backend/assets/img/user1.png')}}" alt="Avatar" class="img-circle pull-left avatar">
											<p><a href="#">Michael</a> has achieved 80% of his completed tasks <span class="timestamp">20 minutes ago</span></p>
										</li>
										<li>
											<img src="{{asset('backend/assets/img/user2.png')}}" alt="Avatar" class="img-circle pull-left avatar">
											<p><a href="#">Daniel</a> has been added as a team member to project <a href="#">System Update</a> <span class="timestamp">Yesterday</span></p>
										</li>
										<li>
											<img src="{{asset('backend/assets/img/user3.png')}}" alt="Avatar" class="img-circle pull-left avatar">
											<p><a href="#">Martha</a> created a new heatmap view <a href="#">Landing Page</a> <span class="timestamp">2 days ago</span></p>
										</li>
										<li>
											<img src="{{asset('backend/assets/img/user4.png')}}" alt="Avatar" class="img-circle pull-left avatar">
											<p><a href="#">Jane</a> has completed all of the tasks <span class="timestamp">2 days ago</span></p>
										</li>
										<li>
											<img src="{{asset('backend/assets/img/user5.png')}}" alt="Avatar" class="img-circle pull-left avatar">
											<p><a href="#">Jason</a> started a discussion about <a href="#">Weekly Meeting</a> <span class="timestamp">3 days ago</span></p>
										</li>
									</ul>
									<button type="button" class="btn btn-primary btn-bottom center-block">Load More</button>
								</div>
							</div>
							 END TIMELINE
						</div>
					</div> --}}
					{{-- <div class="row">
						<div class="col-md-4">
							 TASKS
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">My Tasks</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body">
									<ul class="list-unstyled task-list">
										<li>
											<p>Updating Users Settings <span class="label-percent">23%</span></p>
											<div class="progress progress-xs">
												<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100" style="width:23%">
													<span class="sr-only">23% Complete</span>
												</div>
											</div>
										</li>
										<li>
											<p>Load &amp; Stress Test <span class="label-percent">80%</span></p>
											<div class="progress progress-xs">
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
													<span class="sr-only">80% Complete</span>
												</div>
											</div>
										</li>
										<li>
											<p>Data Duplication Check <span class="label-percent">100%</span></p>
											<div class="progress progress-xs">
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
													<span class="sr-only">Success</span>
												</div>
											</div>
										</li>
										<li>
											<p>Server Check <span class="label-percent">45%</span></p>
											<div class="progress progress-xs">
												<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
													<span class="sr-only">45% Complete</span>
												</div>
											</div>
										</li>
										<li>
											<p>Mobile App Development <span class="label-percent">10%</span></p>
											<div class="progress progress-xs">
												<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
													<span class="sr-only">10% Complete</span>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
							 END TASKS
						</div>
						<div class="col-md-4">
							 VISIT CHART
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Website Visits</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body">
									<div id="visits-chart" class="ct-chart"></div>
								</div>
							</div>
							 END VISIT CHART
						</div>
						<div class="col-md-4">
							 REALTIME CHART
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">System Load</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body">
									<div id="system-load" class="easy-pie-chart" data-percent="70">
										<span class="percent">70</span>
									</div>
									<h4>CPU Load</h4>
									<ul class="list-unstyled list-justify">
										<li>High: <span>95%</span></li>
										<li>Average: <span>87%</span></li>
										<li>Low: <span>20%</span></li>
										<li>Threads: <span>996</span></li>
										<li>Processes: <span>259</span></li>
									</ul>
								</div>
							</div>
							 END REALTIME CHART
						</div>
					</div> --}}
				</div>
			</div>

		</div>


@endsection
