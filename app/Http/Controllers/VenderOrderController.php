<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cancelorder;
use App\Models\DelieveryAddress;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductOutgoing;
use App\Models\Vendor;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VenderOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vendor = Vendor::where('name', Auth::user()->name)->first();
        $neworder = DB::table('notifications')->where('type','App\Notifications\NewOrderNotification')->where('vendor_id', $vendor->id)->get();
        foreach ($neworder as $order) {
            DB::update('update notifications set is_read = 1 where id = ?', [$order->id]);
        }

        if ($request->ajax()) {
            $vendor = Vendor::where('name', Auth::user()->name)->first();
            $data = OrderedProduct::latest()->where('vendor_id', $vendor->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_name', function($row){
                    $order = Order::where('id', $row->order_id)->with('user')->first();
                    $customer_name = $order->user->name;
                    return $customer_name;
                })
                ->addColumn('product_info', function($row){
                    $product_outgoing = ProductOutgoing::where('id', $row->product_id)->first();
                    $product = Product::where('id', $product_outgoing->product_id)->first();
                    $product_info = $product->name.'<br>('.$product_outgoing->ram.' / '. $product_outgoing->rom.')';
                    return $product_info;
                })
                ->addColumn('price', function($row){
                    $total_price = 'Rs. '.$row->price*$row->quantity;
                    return $total_price;
                })
                ->addColumn('ordered_date', function($row){
                    $added_date = date('F d, Y', strtotime($row->created_at));
                    return $added_date;
                })
                ->addColumn('status', function($row){
                    $status = $row->orderStatus->status;
                    return $status;
                })
                ->addColumn('action', function($row){
                    $editurl = route('vendor.orders.show', $row->id);
                    $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>View order</a>
                           ";

                            return $btn;
                })
                ->rawColumns(['customer_name','product_info', 'price', 'ordered_date', 'action'])
                ->make(true);
        }

        return view('backend.vendorside.orders.index');
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
        $ordered_product = OrderedProduct::findorFail($id);
        $order = Order::where('id', $ordered_product->order_id)->with('user')->with('delieveryAddress')->first();
        $product_outgoing = ProductOutgoing::where('id', $ordered_product->product_id)->with('product')->with('vendor')->first();
        $orderstatuses = OrderStatus::get();
        return view('backend.vendorside.orders.show', compact('ordered_product', 'order', 'orderstatuses', 'product_outgoing'));
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
        $order = Order::findorFail($id);
        $data = $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'tole' => 'required',
            'email' => 'required',
            'town' => 'required',
            'description' => '',
        ]);

        $delievery_address = DelieveryAddress::where('id', $order->delievery_address_id)->first();

        $delievery_address->update([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'tole' => $data['tole'],
            'email' => $data['email'],
            'town' => $data['town'],
            'description' => $data['description'],
        ]);
        return redirect()->back()->with('success', 'Shipping Details Successfully Updated');
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


    public function updatestatus(Request $request, $id)
    {
        $data = $this->validate($request, [
            'orderstatus' => 'required',
        ]);

        if($data['orderstatus'] == 6){
            $desc = $this->validate($request,[
                'canceldescription'=>'required',
            ]);
            $ordered_product = OrderedProduct::where('id', $id)->first();
            $ordered_product->update([
                'order_status_id' => $data['orderstatus'],
            ]);
            $description = 'Cancelled By: '.Auth()->user()->name.'<br> Reason behind Cancellation:'.$desc['canceldescription'];
            $cancelled_order = Cancelorder::create([
                'order_id' => $id,
                'description' => $description,
            ]);
            $cancelled_order->save();

            $outgoingproduct = ProductOutgoing::where('id', $ordered_product->product_id)->first();
            $quantity = $outgoingproduct->quantity + $ordered_product->quantity;

            $outgoingproduct->update([
                'quantity' => $quantity,
            ]);

            return redirect()->back()->with('success', 'Order cancelled successfully.');

        }
        elseif($data['orderstatus'] == 5)
        {
            $warranty_card = $this->validate($request, [
                'warranty' => 'required|mimes:pdf'
            ]);

            $ordered_product = OrderedProduct::findorFail($id);

            $warrantypdf = '';
            if ($request->hasFile('warranty')) {
                $warranty = $request->file('warranty');
                $warrantypdf = $warranty->store('warranty_card', 'uploads');

                $ordered_product->update([
                    'order_status_id' => $data['orderstatus'],
                    'warranty' => $warrantypdf
                ]);
            }
            return redirect()->back()->with('success', 'Order completed Successfully.');
        }
        else{
            $ordered_product = OrderedProduct::findorFail($id);
            $ordered_product->update([
                'order_status_id' => $data['orderstatus'],
            ]);
            return redirect()->back()->with('success', 'Orderstatus updated Successfully.');
        }
    }

    public function notificationsread()
    {
        $vendor = Vendor::where('name', Auth::user()->name)->first();
        $notifications = DB::table('notifications')->where('vendor_id', $vendor->id)->get();
        foreach ($notifications as $notification) {
            DB::update('update notifications set is_read = 1 where id = ?', [$notification->id]);
        }

        return redirect()->back();
    }
}
