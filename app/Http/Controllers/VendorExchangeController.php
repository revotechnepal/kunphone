<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExchangeConfirm;
use App\Models\Product;
use App\Models\ProductIncoming;
use App\Models\ProductOutgoing;
use App\Models\Vendor;
use Illuminate\Http\Request;

use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vendor = Vendor::where('name', Auth::user()->name)->first();
        $exchangeorder = DB::table('notifications')->where('type','App\Notifications\ExchangeOrderNotification')->where('vendor_id', $vendor->id)->get();
        foreach ($exchangeorder as $order) {
            DB::update('update notifications set is_read = 1 where id = ?', [$order->id]);
        }
        if ($request->ajax()) {
            $vendor = Vendor::where('name', Auth::user()->name)->first();
            $data = ExchangeConfirm::latest()->with('user')->where('vendor', $vendor->id)->get();
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
                    $added_date = date('F d, Y', strtotime($row->created_at));
                    return $added_date;
                })
                ->addColumn('action', function($row){
                    $editurl = route('vendor.exchangeorders.show', $row->id);
                    $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>View exchange order</a>
                           ";

                            return $btn;
                })
                ->rawColumns(['customer_name', 'exchanging_product', 'exchanged_product', 'added_date', 'action'])
                ->make(true);
        }

        return view('backend.vendorside.exchange_orders.index');
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
    public function store(Request $request, $id)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exchangeorder = ExchangeConfirm::where('id', $id)->first();
        $incomingproduct = ProductIncoming::where('id', $exchangeorder->incomingproduct_id)->first();
        $outgoingproduct = ProductOutgoing::where('id', $exchangeorder->outgoingproduct_id)->first();
        return view('backend.vendorside.exchange_orders.show', compact('exchangeorder', 'incomingproduct', 'outgoingproduct'));
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
        $exchangeorder = ExchangeConfirm::findorFail($id);
        $outgoingproduct = ProductOutgoing::where('id', $exchangeorder->outgoingproduct_id)->first();

        $quantity = $outgoingproduct->quantity + 1;
        $outgoingproduct->update([
            'quantity' => $quantity
        ]);
        $exchangeorder->update([
            'is_processsing' => 2
        ]);
        return redirect()->back()->with('success', 'Exchange cancelled successfully.');
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

    public function updateexchange(Request $request, $id)
    {
        // dd($id);
        $warranty = $this->validate($request, [
            'warranty' => 'required|mimes:pdf'
        ]);

        $exchangeorder = ExchangeConfirm::findorFail($id);

        $warrantypdf = '';
        if ($request->hasFile('warranty')) {
            $warranty = $request->file('warranty');
            $warrantypdf = $warranty->store('warranty_card', 'uploads');

            $exchangeorder->update([
                'is_processsing' => 0,
                'warranty' => $warrantypdf
            ]);

            return redirect()->back()->with('success', 'Exchange Order completed successfully.');
        }
    }
}
