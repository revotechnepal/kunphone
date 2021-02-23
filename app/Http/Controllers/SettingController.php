<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        return view('backend.settings.index', compact('setting'));
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
        $request->validate([
            'site_name'     => 'required|max:250',
            'email'         => 'required|email',
            'phone'         => 'required|numeric',
            'facebook'      => 'nullable|url',
            'twitter'       => 'nullable|url',
            'linkedin'      => 'nullable|url',
            'instagram'     => 'nullable|url',
            'address'       => 'nullable|max:250',
            'aboutus'       => 'required',
        ]);

        $setting = new Setting;
        $setting->updateOrCreate(['id' => 1],
          [
            'site_name'     => $request->site_name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'facebook'      => $request->facebook,
            'twitter'       => $request->twitter,
            'linkedin'      => $request->linkedin,
            'instagram'     => $request->instagram,
            'address'       => $request->address,
            'aboutus'       => $request->aboutus,
          ]
        );

        return back()->with('success', 'Setting updated successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        //
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
