<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\ProductOutgoing;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
            'quantity' => 'required|numeric',
        ]);

        $orderedproduct = OrderedProduct::findorFail($id);
        $outgoingproduct = ProductOutgoing::findorFail($orderedproduct->product_id);

        $totalquantity = $orderedproduct->quantity + $outgoingproduct->quantity;
        $newquantity = $totalquantity - $data['quantity'];

        if($data['quantity'] > $totalquantity)
        {
            return redirect()->back()->with('error', 'Cannot order more than that of stock.');
        }
        else{
            $orderedproduct->update([
                'quantity' => $data['quantity'],
            ]);

            $outgoingproduct->update([
                'quantity' => $newquantity,
            ]);

            return redirect()->back()->with('success', 'Quantity is updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderproduct = OrderedProduct::findorFail($id);
        $outgoingproduct = ProductOutgoing::where('id', $orderproduct->product_id)->first();

        $quantity = $orderproduct->quantity + $outgoingproduct->quantity;

        $outgoingproduct->update([
            'quantity' => $quantity,
        ]);

        $orderscount = OrderedProduct::where('order_id', $orderproduct->order_id)->get()->count();
        if($orderscount == 1)
        {
            $order = Order::findorFail($orderproduct->order_id);
            $orderproduct->update([
                'order_status_id' => 6
            ]);

            return redirect()->back()->with('success', 'Product is cancelled from order successfully.');
        }
        else{
            $orderproduct->update([
                'order_status_id' => 6
            ]);
            return redirect()->back()->with('success', 'Product is cancelled from order successfully.');
        }
    }

    public function confirmorder(Request $request, $id)
    {
        $orderedproduct = OrderedProduct::findorFail($id);
        $orderedproduct->update([
            'order_status_id' => 5
        ]);
        // $data = $this->validate($request, [
        //     'gtotal' => 'required',
        // ]);
        // $payment = Payment::findorFail($id);
        // $payment->update([
        //     'price' => $data['gtotal'],
        // ]);

        return redirect()->back()->with('success', 'Order has been delievered.');
    }
}
