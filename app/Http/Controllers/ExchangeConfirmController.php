<?php

namespace App\Http\Controllers;

use App\Models\ExchangeConfirm;
use App\Models\Product;
use App\Models\ProductIncoming;
use App\Models\ProductOutgoing;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class ExchangeConfirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $exchangeorder = DB::table('notifications')->where('type','App\Notifications\ExchangeOrderNotification')->get();
        foreach ($exchangeorder as $order) {
            DB::update('update notifications set is_read = 1 where id = ?', [$order->id]);
        }
        if ($request->ajax()) {
            $data = ExchangeConfirm::latest()->with('user')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_name', function($row){
                    $customer_name = $row->user->name;
                    return $customer_name;
                })
                ->addColumn('exchanging_product', function($row){
                    $exchanging_product = ProductIncoming::where('id', $row->incomingproduct_id)->first();
                    $product = Product::where('id', $exchanging_product->product_id)->first();
                    $productinfo = $product->name .  '<br>(' . $exchanging_product->ram . '/'.  $exchanging_product->rom . ')';
                    return $productinfo;
                })
                ->addColumn('exchanged_product', function($row){
                    $exchanged_product = ProductOutgoing::where('id', $row->outgoingproduct_id)->first();
                    $product = Product::where('id', $exchanged_product->product_id)->first();
                    $productinfo = $product->name . '<br>(' . $exchanged_product->ram . '/' . $exchanged_product->rom. ')';
                    return $productinfo;
                })

                ->addColumn('added_date', function($row){
                    $added_date = date('F d Y, h:i:s a', strtotime($row->created_at));
                    return $added_date;
                })
                ->addColumn('action', function($row){
                    $editurl = route('admin.exchangeconfirm.show', $row->id);
                    $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>View exchange order</a>
                           ";

                            return $btn;
                })
                ->rawColumns(['customer_name', 'exchanging_product', 'exchanged_product', 'added_date', 'action'])
                ->make(true);
        }

        return view('backend.exchange_orders.index');
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
     * @param  \App\Models\ExchangeConfirm  $exchangeConfirm
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exchangeorder = ExchangeConfirm::where('id', $id)->first();
        return view('backend.exchange_orders.show', compact('exchangeorder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExchangeConfirm  $exchangeConfirm
     * @return \Illuminate\Http\Response
     */
    public function edit(ExchangeConfirm $exchangeConfirm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExchangeConfirm  $exchangeConfirm
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $exchangeorder = ExchangeConfirm::findorFail($id);
        $exchangeorder->update([
            'is_processing' => 0
        ]);
        return redirect()->back()->with('success', 'Exchange completed.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExchangeConfirm  $exchangeConfirm
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExchangeConfirm $exchangeConfirm)
    {
        //
    }
}
