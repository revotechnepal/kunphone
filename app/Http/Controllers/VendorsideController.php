<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorsideController extends Controller
{
    public function profile()
    {
        return view('backend.vendorside.profile');
    }
}
