<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\User;
use App\Models\ProductOutgoing;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Vendor::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('address', function($row){
                    $address = $row->address . ', ' . $row->district;
                    return $address;
                })
                ->addColumn('action', function($row){
                    $editurl = route('admin.vendor.edit', $row->id);
                    $deleteurl = route('admin.vendor.destroy', $row->id);
                    $csrf_token = csrf_token();
                    $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                           <form action='$deleteurl' method='POST' style='display:inline-block;'>
                            <input type='hidden' name='_token' value='$csrf_token'>
                            <input type='hidden' name='_method' value='DELETE' />
                               <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                           </form>
                           ";

                            return $btn;
                })
                ->rawColumns(['address', 'action'])
                ->make(true);
        }
        return view('backend.vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'district' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ]);

        $vendor = Vendor::create([
            'name'=>$data['name'],
            'address'=>$data['address'],
            'district'=>$data['district'],
            'email'=>$data['email'],
            'phone'=>$data['phone'],
            'role_id' => 4
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => 4,
            'is_verified' => 1,
            'password' => Hash::make('password'),
        ]);
        $vendor->save();

        $user->save();

        return redirect()->route('admin.vendor.index')->with('success', 'Vendor Successfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = Vendor::findorfail($id);
        return view('backend.vendor.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vendor = Vendor::findorfail($id);
        $user = User::where('name', $vendor->name)->first();

        $data = $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'district' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ]);

        $vendor->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'district' => $data['district'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        return redirect()->route('admin.vendor.index')->with('success', 'Vendor Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::findorFail($id);
        $productoutgoing = ProductOutgoing::where('vendor_id', $vendor->id)->get();
        if(count($productoutgoing) > 0)
        {
            return redirect()->route('admin.vendor.index')->with('danger', 'Vendor has outgoing products. Cannot delete.');
        }
        else
        {
            $user = User::where('name', $vendor->name)->first();
            $user->delete();
            $vendor->delete();
            return redirect()->route('admin.vendor.index')->with('success', 'Vendor Successfully deleted.');
        }
    }


    public function vendoredit($id)
    {
        $vendor = Vendor::findorfail($id);
        return view('backend.vendorside.profileedit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function vendorupdate(Request $request, $id)
    {
        $vendor = Vendor::findorfail($id);
        $user = User::where('name', $vendor->name)->first();

        $data = $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'district' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ]);

        $vendor->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'district' => $data['district'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        return redirect()->route('vendor.profile')->with('success', 'Profile Successfully Updated');
    }
}
