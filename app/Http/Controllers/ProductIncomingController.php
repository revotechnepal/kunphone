<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIncoming;
use App\Models\ProductStorage;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductIncomingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $incomingproduct = DB::table('notifications')->where('type','App\Notifications\IncomingProductNotification')->get();
        foreach ($incomingproduct as $product) {
            DB::update('update notifications set is_read = 1 where id = ?', [$product->id]);
        }

        if ($request->ajax()) {

            $data = ProductIncoming::latest()->where('is_approved', 0)->with('product')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('product', function($row){
                        $product = $row->product->name;
                        return $product;
                    })
                    ->addColumn('action', function($row){
                            $showurl = route('admin.productincoming.show', $row->id);
                            $deleteurl = route('admin.productincoming.destroy', $row->id);
                            $csrf_token = csrf_token();
                            $btn = "
                            <a href='$showurl' class='edit btn btn-info btn-sm'>Show</a>
                            <form action='$deleteurl' method='POST' style='display:inline-block;'>
                             <input type='hidden' name='_token' value='$csrf_token'>
                             <input type='hidden' name='_method' value='DELETE' />
                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                            ";

                            return $btn;
                    })
                    ->rawColumns(['product', 'action'])
                    ->make(true);
        }
        return view('backend.product_incoming.unapproved');
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
        $productincoming = ProductIncoming::where('id', $id)->with('product')->first();
        $productstorage = ProductStorage::where('product_id', $productincoming->product_id)->first();
        return view('backend.product_incoming.showunapproved', compact('productincoming', 'productstorage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

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
            'finalprice' => 'required|numeric',
        ]);
        $productincoming = ProductIncoming::where('id', $id)->first();
        $product = Product::where('id', $productincoming->product_id)->first();
        $user = User::where('id', $productincoming->user_id)->first();
        $email = $user->email;
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        $exchangecode =  substr(str_shuffle($str_result), 0, 6);
        $productincoming->update([
            'is_approved' => 1,
            'price' => $data['finalprice'],
            'exchangecode' => $exchangecode,
        ]);
        MailController::notifyUser($product, $productincoming, $email, $exchangecode);
        return redirect()->route('admin.productincoming.index')->with('success', 'Product is approved to buy, go to approved products to view the product.');
    }

    public function approved(Request $request)
    {
        if ($request->ajax()) {

            $data = ProductIncoming::latest()->where('is_approved', 1)->with('product')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('product', function($row){
                        $product = $row->product->name;
                        return $product;
                    })
                    ->addColumn('action', function($row){
                            $showurl = route('admin.productincoming.view', $row->id);
                            $deleteurl = route('admin.productincoming.destroy', $row->id);
                            $csrf_token = csrf_token();
                            $btn = "
                            <a href='$showurl' class='edit btn btn-info btn-sm'>Show</a>
                            <form action='$deleteurl' method='POST' style='display:inline-block;'>
                             <input type='hidden' name='_token' value='$csrf_token'>
                             <input type='hidden' name='_method' value='DELETE' />
                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                            ";

                            return $btn;
                    })
                    ->rawColumns(['product', 'action'])
                    ->make(true);
        }
        return view('backend.product_incoming.approved');
    }

    public function view($id)
    {
        $productincoming = ProductIncoming::where('id', $id)->with('product')->first();

        return view('backend.product_incoming.showapproved', compact('productincoming'));
    }

    public function notificationsread()
    {
        $incomingproduct = DB::table('notifications')->get();
        foreach ($incomingproduct as $product) {
            DB::update('update notifications set is_read = 1 where id = ?', [$product->id]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productincoming = ProductIncoming::findorFail($id);
        $productincoming->delete();
        return redirect()->back()->with('success', 'Incoming Product Successfully Deleted.');
    }
}
