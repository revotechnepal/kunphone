@extends('backend.layouts.app')

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <h2 class="mb-3"> Ordered Product #{{$ordered_product->id}}
                <a href="{{route('admin.orderedproducts.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i> View All Ordered Products</a>

            </h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <p><span style="font-weight: bold;">Order Id: </span> {{$ordered_product->order_id}}</p>
                                    <p><span style="font-weight: bold;">Customer Name: </span> {{$order->delieveryAddress->firstname}} {{$order->delieveryAddress->lastname}}</p>
                                    <p><span style="font-weight: bold;">Customer Email: </span>{{$order->delieveryAddress->email}}</p>
                                    <p><span style="font-weight: bold;">Delivery Address: </span>{{$order->delieveryAddress->tole}}, {{$order->delieveryAddress->address}}, {{$order->delieveryAddress->town}}</p>
                                    <p><span style="font-weight: bold;">Customer contact: </span>{{$order->delieveryAddress->phone}}</p>
                                    <p><span style="font-weight: bold;">Ordered Date: </span> {{date('F d, Y', strtotime($ordered_product->created_at))}}</p>
                                </div>
                                <div class="col-md-7">
                                    <p></p><p></p>
                                    <p><span style="font-weight: bold;">Appropriate Vendor: </span> {{$product_outgoing->vendor->name}}</p>
                                    <p><span style="font-weight: bold;">Vendor Address: </span>{{$product_outgoing->vendor->address}}, {{$product_outgoing->vendor->district}}</p>
                                    <p><span style="font-weight: bold;">Vendor contact: </span> {{$product_outgoing->vendor->phone}}</p>
                                    <p><span style="font-weight: bold;">Payment Method: </span>
                                        @if ($order->payment->method == 'cash')
                                            Cash on Delivery
                                        @elseif($order->payment->method == 'bank')
                                            Bank Tranfer
                                        @elseif($order->payment->method == 'esewa')
                                            Esewa Payment
                                        @endif

                                    </p>
                                    <p><span style="font-weight: bold;">Delievery Status: </span>{{$ordered_product->orderStatus->status}}</p>
                                    @if ($ordered_product->order_status_id == 5)
                                        <a href="{{Storage::disk('uploads')->url($ordered_product->warranty)}}" class="btn btn-primary btn-sm" target="_blank"> <i class="fa fa-eye" aria-hidden="true"></i> View Warranty Details</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3>Product Summary</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item active">
                                          <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="true">Product Details</a>
                                        </li>
                                        <li>
                                          <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">Shipping Details</a>
                                        </li>
                                        {{-- <li>
                                          <a class="nav-link" id="status-tab" data-toggle="tab" href="#status" role="tab" aria-controls="status" aria-selected="false">Status and Comments</a>
                                        </li> --}}
                                      </ul>
                                      <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade active in" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                        {{-- <h3 class="my-4">Edit Product Details</h3> --}}
                                            <table class="table table-responsive text-center">
                                                <thead>
                                                    <tr>
                                                        {{-- <th></th> --}}
                                                        <th class="text-center">Product Info</th>
                                                        <th class="text-center">Variant</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th class="text-center">Unit Price (Rs./piece)</th>
                                                        <th class="text-center">Total (Rs.)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                            <tr>
                                                                {{-- <td>
                                                                    <form action="{{route('admin.ordermanagement.destroy', $orderproduct->id)}}" method="POST">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button type="submit" class="btn btn-danger btn-sm">X</button>
                                                                    </form>
                                                                </td> --}}
                                                                <td>
                                                                    <b>{{$product_outgoing->product->name}}</b>
                                                                    @if ($product_outgoing->condition == 'used')
                                                                        <p class="mt-2">(Used Phone)<br>
                                                                        (SKU: {{$product_outgoing->sku}})</p>
                                                                    @else
                                                                        <p class="mt-2">(New Phone)</p>
                                                                    @endif
                                                                </td>
                                                                <td>{{$product_outgoing->ram}} / {{$product_outgoing->rom}}</td>
                                                                <td class="qua-col text-center">

                                                                    <form action="{{route('admin.ordermanagement.update', $ordered_product->id)}}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="input-group d-flex" style="margin-left: 35px;">
                                                                            <div class="pro-qty">
                                                                                <input type="text" name="quantity" value="{{$ordered_product->quantity}}">
                                                                            </div>
                                                                        </div>

                                                                        <p>({{$product_outgoing->quantity}} Left In Stock)</p>
                                                                        @if ($ordered_product->order_status_id == 6 || $ordered_product->order_status_id == 5)
                                                                        @else
                                                                            <a href="#" class="btn btn-primary py-3 px-5 mr-2" onclick="this.parentNode.submit()">Update</a>
                                                                        @endif
                                                                    </form>
                                                                </td>
                                                                <td>{{$ordered_product->price}}</td>
                                                                <td>{{$ordered_product->price * $ordered_product->quantity}}</td>
                                                            </tr>


                                                    {{-- <tr>
                                                        <td colspan="5" align="right" style="font-weight: bold;">Sub Total:</td>--}}
                                                        @php
                                                            $subtotal = $ordered_product->price * $ordered_product->quantity;
                                                            // foreach($orderproducts as $orderproduct){

                                                            //     $price = $orderproduct->price;
                                                            //     $qty = $orderproduct->quantity;
                                                            //     $total = $qty * $price;
                                                            //     $subtotal+=$total;
                                                            // }
                                                        @endphp
                                                        {{--<td> <input type="text" name="subtotal" value="Rs.{{$subtotal}}" disabled></td>
                                                    </tr> --}}
                                                    <tr>
                                                        @php
                                                            $deliverycharge = 50;
                                                        @endphp
                                                        <td colspan="4" align="right" style="font-weight: bold;">Delivery Charge: </td>
                                                        <td> <input type="text" name="deliverycharge" value="Rs.{{$deliverycharge}}" disabled></td>
                                                    </tr>
                                                    <tr>
                                                        @php
                                                            $gtotal = ceil($subtotal+$deliverycharge);
                                                        @endphp
                                                        <td colspan="4" align="right" style="font-weight: bold;">Grand Total:</td>
                                                        <td><input type="text" name="gtotal" value="Rs.{{$gtotal}}" disabled></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                        @if ($ordered_product->order_status_id == 6)
                                                            <td><b>Order is cancelled.</b></td>
                                                        @elseif($ordered_product->order_status_id == 5)
                                                            <td><b>Order is delievered.</b></td>
                                                        @else
                                                        {{-- <td>
                                                            <form action="{{route('admin.confirmorder', $ordered_product->id)}}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="text" name="gtotal" value="{{$gtotal}}" hidden>
                                                                <button class="btn btn-success btn-sm" type="submit">Order Delievered</button>
                                                            </form>
                                                        </td> --}}
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                        @if ($ordered_product->order_status_id == 6 || $ordered_product->order_status_id == 5)
                                                        @else
                                                            <td>
                                                                <form action="{{route('admin.ordermanagement.destroy', $ordered_product->id)}}" method="POST" class="mt-3">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" class="btn btn-danger btn-sm">Cancel Order</button>
                                                                </form>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                            {{-- <h3>Edit Shipping Details</h3> --}}
                                        <form action="{{route('admin.order.update', $order->id)}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="firstname">Firstname: </label>
                                                    <input type="text" name="firstname" class="form-control" value="{{$order->delieveryAddress->firstname}}">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label for="lastname">Lastname: </label>
                                                    <input type="text" name="lastname" class="form-control" value="{{$order->delieveryAddress->lastname}}">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="email">Email:</label>
                                                    <input type="text" name="email" class="form-control" value="{{$order->delieveryAddress->email}}">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label for="phone">Phone:</label>
                                                    <input type="text" name="phone" class="form-control" value="{{$order->delieveryAddress->phone}}">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label for="tole">Tole:</label>
                                                    <input type="text" name="tole" class="form-control" value="{{$order->delieveryAddress->tole}}">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label for="address">Street Address:</label>
                                                    <input type="text" name="address" class="form-control" value="{{$order->delieveryAddress->address}}">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label for="town">Town / District:</label>
                                                    <input type="text" name="town" class="form-control" value="{{$order->delieveryAddress->town}}">
                                                </div>

                                                <div class="col-md-12 form-group">
                                                    <label for="description">Delievery description:</label>
                                                    <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Something....">{{$order->delieveryAddress->description}}</textarea>
                                                </div>
                                            </div>
                                            <center>
                                                <button class="btn btn-success my-3" type="submit">Save Changes</button>
                                            </center>
                                        </form>
                                            {{-- <p class="bold"> Payment Amount : Rs.{{$order->payment->price}}</p>
                                            <p class="bold"> Payment Method :
                                                @if ($order->payment->method == 'cash')
                                                    Cash on Delivery
                                                @elseif($order->payment->method == 'bank')
                                                    Bank Tranfer
                                                @elseif($order->payment->method == 'esewa')
                                                    Esewa Payment
                                                @endif
                                            </p>
                                            <p class="bold"> Payment Status : {{$order->payment->status == null ? 'Unpaid' : 'Paid'}}</p>
                                            <form action="{{route('admin.paymentstatus', $order->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" value="1" name="status">
                                                <button type="submit" class="btn btn-primary">Payment Done</button>
                                            </form> --}}
                                        </div>
                                        {{-- <div class="tab-pane fade" id="status" role="tabpanel" aria-labelledby="status-tab">
                                            <h3>Order Status and Comment</h3> --}}
                                            {{-- <form action="{{route('admin.updatestatus', $order->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group row">
                                                    <label for="orderstatus" class="col-sm-3">Order Status</label>
                                                    <div class="col-sm-4">
                                                        <select name="orderstatus" class="form-control">
                                                            @foreach ($orderstatuses as $orderstatus)
                                                            <option value="{{$orderstatus->id}}" {{$orderstatus->id == $order->order_status_id ? 'selected' : ''}}>{{$orderstatus->status}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="form-group">
                                                            <textarea name="canceldescription"  cols="30" rows="10" class="form-control" placeholder="Fill the reason only if you are canceling order or leave blank"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success">Change Status</button>
                                            </form> --}}
                                        {{-- </div> --}}
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
