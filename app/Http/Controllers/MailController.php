<?php

namespace App\Http\Controllers;

use App\Mail\CustomerEmail;
use App\Mail\NotifyUserMail;
use App\Mail\PasswordChange;
use App\Mail\VendorEmail;
use App\Mail\VendorExchangeEmail;
use App\Mail\VerifyUserEmail;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Artesaos\SEOTools\Facades\SEOMeta;

class MailController extends Controller
{
    public static function verifyEmail($name, $email, $verification_code)
    {
        $mailData = [
            'name' => $name,
            'verification_code' => $verification_code,
        ];

        Mail::to($email)->send(new VerifyUserEmail($mailData));
    }

    public static function notifyUser($product, $productincoming, $email ,$exchangecode)
    {
        $mailData = [
            'name' => $productincoming->fullname,
            'product_name' => $product->name,
            'price' => $productincoming->price,
            'ram' => $productincoming->ram,
            'rom' => $productincoming->rom,
            'exchangecode' => $exchangecode
        ];

        Mail::to($email)->send(new NotifyUserMail($mailData));
    }

    public function customerEmail(Request $request)
    {
        $email = "phone@revonepal.com";

        $mailData = [
            'fullname' => $request['fullname'],
            'customeremail' => $request['customeremail'],
            'message' => $request['message'],
        ];

        Mail::to($email)->send(new CustomerEmail($mailData));

        return redirect()->back()->with('success', 'Thank you for messaging us. We will get back to you soon.');
    }

    public function sendEmail() {
        $user = User::findorFail(Auth::user()->id);
        $title = $user->name;
        SEOMeta::setTitle($title);
        $email = $user->email;

        $otp = mt_rand(111111, 999999);

        Cookie::queue('otpcookie', $otp, 5);

        $mailData = [
            'otp' => $otp,
        ];

        Mail::to($email)->send(new PasswordChange($mailData));
        if (Auth::user()->role_id == 3) {
            $setting = Setting::first();
            return view('frontend.myprofile.otpconfirmation', compact('setting'));
        }
    }

    public static function vendoremail($product, $vendor, $email)
    {
        $mailData = [
            'product_name' => $product->name,
            'vendor_name' => $vendor->name,
        ];

        Mail::to($email)->send(new VendorEmail($mailData));
    }

    public static function vendorexchangeemail($vendor, $email)
    {
        $mailData = [
            'vendor_name' => $vendor->name,
        ];

        Mail::to($email)->send(new VendorExchangeEmail($mailData));
    }
}
