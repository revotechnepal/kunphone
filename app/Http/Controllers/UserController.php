<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $newuser = DB::table('notifications')->where('type','App\Notifications\NewUserNotification')->get();
        foreach ($newuser as $product) {
            DB::update('update notifications set is_read = 1 where id = ?', [$product->id]);
        }

        if ($request->ajax()) {
            $data = User::latest()->with('role')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('role', function($row){
                        $role = $row->role->name;
                        return $role;
                    })
                    ->addColumn('action', function($row){
                            $editurl = route('admin.user.edit', $row->id);
                            $deleteurl = route('admin.user.destroy', $row->id);
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
                    ->rawColumns(['role', 'action'])
                    ->make(true);
        }
        return view('backend.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::latest()->get();
        return view('backend.user.create', compact('roles'));
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
        $data = $this->validate($request, [
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'role_id'=>'required',
            'password' => 'sometimes|min:8|confirmed',
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'is_verified' => 1,
            'password' => Hash::make($data['password']),
        ]);
        $user->save();
        // $users = User::where('role_id',1)->first();

        return redirect()->route('admin.user.index')->with('success', 'User Successfully Created');

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
        $user = User::findorfail($id);
        $roles = Role::get();

        return view('backend.user.edit', compact('user','roles'));
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
        //
        $user = User::findorfail($id);
        if(isset($_POST['updatedetails'])){
            $data = $this->validate($request, [
                'name'=>'required|string|max:255',
                'email'=>'required|string|email|max:255|unique:users,email,'.$user->id,
                'role_id'=>'required',
            ]);
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
            ]);
            $user->save();
            return redirect()->route('admin.user.index')->with('success', 'UserDetails Successfully updated');
        }
        elseif(isset($_POST['updatepassword'])){
            $data = $this->validate($request, [
                'oldpassword' => 'required',
                'new_password' => 'sometimes|min:8|confirmed|different:password',
            ]);

            if (Hash::check($data['oldpassword'], $user->password)) {
                if (!Hash::check($data['new_password'] , $user->password)) {
                    $newpass = Hash::make($data['new_password']);

                    $user->update([
                        'password' => $newpass,
                    ]);
                    $user->save;
                    session()->flash('success','password updated successfully');
                    return redirect()->route('admin.user.index');
                  }

                  else{
                        session()->flash('success','new password can not be the old password!');
                        return redirect()->back();
                      }

                 }

             else {
                $request->session()->flash('success', 'Password does not match');
                return redirect()->route('admin.user.index');
            }
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
        //
        if(Auth::user()->role_id == 1){
            $user = User::findorfail($id);
            $user->delete();
            return redirect()->back()->with('success','Successfully Deleted');
        }else{
            return redirect()->back()->with('error','Not Allowed');
        }
    }
}
