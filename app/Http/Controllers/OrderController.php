<?php

namespace App\Http\Controllers;

use App\Models\Cancelorder;
use App\Models\DelieveryAddress;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\ProductOutgoing;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $neworder = DB::table('notifications')->where('type','App\Notifications\NewOrderNotification')->get();
        foreach ($neworder as $order) {
            DB::update('update notifications set is_read = 1 where id = ?', [$order->id]);
        }

        if ($request->ajax()) {
            $data = Order::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_name', function($row){
                    $customer_name = $row->user->name;
                    return $customer_name;
                })
                ->addColumn('order_status', function($row){
                    $order_status = $row->orderStatus->status;
                    return $order_status;
                })
                ->addColumn('delievery_address', function($row){
                    $delievery_address = $row->delieveryAddress->address;
                    return $delievery_address;
                })
                ->addColumn('total_price', function($row){
                    $total_price = 'Rs.'.$row->payment->price;
                    return $total_price;
                })
                ->addColumn('added_date', function($row){
                    $added_date = date('F d Y, h:i:s a', strtotime($row->created_at));
                    return $added_date;
                })
                ->addColumn('action', function($row){
                    $editurl = route('admin.order.show', $row->id);
                    $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>View order</a>
                           ";

                            return $btn;
                })
                ->rawColumns(['customer_name', 'order_status', 'delievery_address','total_price','added_date', 'action'])
                ->make(true);
        }

        return view('backend.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('id', $id)->first();
        $orderstatuses = OrderStatus::get();
        $orderproducts = OrderedProduct::where('order_id', $id)->get();
        return view('backend.orders.show', compact('order', 'orderstatuses', 'orderproducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'description' => 'required',
        ]);

        $order = Order::where('id', $id)->first();
        $delievery_address = DelieveryAddress::where('id', $order->delievery_address_id)->first();

        $delievery_address->update([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'description' => $data['description'],
        ]);
        return redirect()->back()->with('success', 'Shipping Details Successfully Updated');
    }

    public function updatestatus(Request $request, $id)
    {
        $data = $this->validate($request, [
            'orderstatus' => 'required',
        ]);

        if($data['orderstatus'] == 6){
            $desc = $this->validate($request,[
                'canceldescription'=>'required',
            ]);
            $order = Order::where('id', $id)->first();
            $order->update([
                'order_status_id' => $data['orderstatus'],
            ]);
            $description = 'Cancelled By: '.Auth()->user()->name.'<br> Reason behind Cancellation:'.$desc['canceldescription'];
            $cancelled_order = Cancelorder::create([
                'order_id' => $id,
                'description' => $description,
            ]);
            $cancelled_order->save();

            $orderedproducts = OrderedProduct::where('order_id', $order->id)->get();

            foreach ($orderedproducts as $product) {
                $outgoingproduct = ProductOutgoing::where('id', $product->product_id)->first();
                $quantity = $outgoingproduct->quantity + $product->quantity;

                $outgoingproduct->update([
                    'quantity' => $quantity,
                ]);
            }

            return redirect()->back()->with('success', 'Order Successfully Canceled');

        }else{

            $order = Order::where('id', $id)->first();
            $order->update([
                'order_status_id' => $data['orderstatus'],
            ]);
            return redirect()->back()->with('success', 'Order Status Successfully Updated');
        }
    }

    public function paymentstatus(Request $request, $id)
    {
        $data = $this->validate($request, [
            'status' => 'required',
        ]);
        $order = Order::where('id', $id)->first();
        $payment_id = $order->payment_id;
        $payment = Payment::findorFail($payment_id);

        $payment->update([
            'status' => $data['status'],
        ]);

        $payment->save();
        return redirect()->back()->with('success', 'Payment is done.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
