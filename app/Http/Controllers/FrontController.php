<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cancelorder;
use App\Models\Cart;
use App\Models\DelieveryAddress;
use App\Models\ExchangeConfirm;
use App\Models\ExchangeOrder;
use App\Models\Faq;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Payment;
use App\Models\ProductOutgoing;
use App\Models\Product;
use App\Models\ProductIncoming;
use App\Models\ProductStorage;
use App\Models\ProductUsed;
use App\Models\Question;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Wishlist;
use App\Notifications\ExchangeOrderNotification;
use App\Notifications\IncomingProductNotification;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('KunPhone');
        if(Auth::guest() || Auth::user()->role_id!=3){
            $setting = Setting::first();
            $slider = Slider::get();
            $outproducts = ProductOutgoing::latest()->where('quantity', '>', 0)->take(8)->get();
            $featuredproducts = ProductOutgoing::latest()->where('is_featured', 1)->where('quantity', '>', 0)->take(4)->get();
            $brands = Brand::get();
            return view('frontend.index', compact('setting', 'slider', 'outproducts', 'featuredproducts' ,'brands'));
        } else if(Auth::user()->role_id==3){
            $slider = Slider::get();
            $outproducts = ProductOutgoing::latest()->where('quantity', '>', 0)->take(8)->get();
            $featuredproducts = ProductOutgoing::latest()->where('is_featured', 1)->where('quantity', '>', 0)->take(4)->get();
            $brands = Brand::get();
            $setting = Setting::first();
            return view('frontend.index', compact('setting','slider', 'outproducts', 'featuredproducts', 'brands'));
        }
    }

    // Search
    public function pricesearch(Request $request){
        SEOMeta::setTitle('KunPhone');

        $data = $this->validate($request, [
            'price' => 'required',
        ]);

        $pricerange = explode(" ", $data['price']);
        $priceproducts = 'all';
        $brands = Brand::orderBy('name','ASC')->get();
        $setting = Setting::first();
        //$productoutgoing = ProductOutgoing::latest()->where('price', '>=', $pricefrom)->where('price', '<=', $priceto)->paginate(9);
        $productoutgoing = ProductOutgoing::whereBetween('price', [$pricerange[0], $pricerange[2]])->orderBy('price')->where('quantity', '>', 0)->simplePaginate(9);
        if(count($productoutgoing) == 0){
            $priceproducts = 'empty';
        }

        return view('frontend.pricesearch', compact('brands', 'productoutgoing', 'pricerange','priceproducts','setting'));
    }

    public function pricesearchbrand(Request $request, $slug)
    {

        $currentbrand = Brand::where('slug', $slug)->first();
        $title = $currentbrand->name;
        SEOMeta::setTitle($title);
        $data = $this->validate($request, [
            'price' => 'required',
        ]);

        $pricerange = explode(" ", $data['price']);
        $priceproducts = 'all';
        $brands = Brand::orderBy('name','ASC')->get();
        $setting = Setting::first();
        //$productoutgoing = ProductOutgoing::latest()->where('price', '>=', $pricefrom)->where('price', '<=', $priceto)->paginate(9);
        $productoutgoing = ProductOutgoing::where('brand_id', $currentbrand->id)->whereBetween('price', [$pricerange[0], $pricerange[2]])->orderBy('price')->where('quantity', '>', 0)->simplePaginate(9);
        if(count($productoutgoing) == 0){
            $priceproducts = 'empty';
        }

        return view('frontend.pricesearchbrand', compact('setting','brands', 'productoutgoing', 'pricerange','priceproducts', 'currentbrand'));
    }
    // Search End

    // Shop products
    public function shop()
    {
        SEOMeta::setTitle('KunPhone');
        $brands = Brand::orderBy('name','ASC')->get();
        $productoutgoing = ProductOutgoing::latest()->where('quantity', '>' , 0)->simplePaginate(9);
        $setting = Setting::first();
        return view('frontend.shop', compact('brands', 'productoutgoing', 'setting'));
    }

    public function oldshop()
    {
        SEOMeta::setTitle('KunPhone');
        $brands = Brand::orderBy('name','ASC')->get();
        $setting = Setting::first();
        $productoutgoing = ProductOutgoing::latest()->where('quantity', '>' , 0)->where('condition', 'used')->simplePaginate(9);
        return view('frontend.oldshop', compact('brands', 'productoutgoing', 'setting'));
    }

    public function newshop()
    {
        SEOMeta::setTitle('KunPhone');
        $brands = Brand::orderBy('name','ASC')->get();
        $setting = Setting::first();
        $productoutgoing = ProductOutgoing::latest()->where('quantity', '>' , 0)->where('condition', 'new')->simplePaginate(9);
        return view('frontend.newshop', compact('brands', 'productoutgoing','setting'));
    }

    public function product($id)
    {
        $outgoingproduct = ProductOutgoing::where('id', $id)->first();
        $product = Product::where('id', $outgoingproduct->product_id)->with('brand','productdesign',
                                                'productdisplay',
                                                'productperformance',
                                                'productbackcamera',
                                                'productfrontcamera',
                                                'productsound',
                                                'productbattery',
                                                'productcommunication')->first();
        $title = $product->name;
        SEOMeta::setTitle($title);
        $productstorages = ProductStorage::where('product_id', $product->id)->get();
        $setting = Setting::first();
        $questions = Question::latest()->with('user')->where('outproduct_id', $outgoingproduct->id)->get();
        $allreviews = Review::where('product_id', $outgoingproduct->id)->orderBy('rating', 'DESC')->with('user')->get();
        return view('frontend.product', compact('product','setting', 'productstorages', 'questions', 'allreviews', 'outgoingproduct'));
    }

    public function brandproduct($slug)
    {
        $currentbrand = Brand::where('slug', $slug)->first();
        $title = $currentbrand->name;
        SEOMeta::setTitle($title);
        $brands = Brand::orderBy('name','ASC')->get();
        $priceproducts = 'all';
        $productoutgoing = ProductOutgoing::latest()->where('brand_id', $currentbrand->id)->where('quantity', '>', 0)->simplePaginate(9);
        if(count($productoutgoing) == 0){
            $priceproducts = 'empty';
        }
        $setting = Setting::first();
        return view('frontend.brandproduct', compact('brands', 'setting', 'currentbrand', 'productoutgoing', 'priceproducts'));
    }
    // Shop Products end

    // Sell Phone
    public function sellphone()
    {
        SEOMeta::setTitle('kunPhone');
        if(Auth::guest() || Auth::user()->role_id!=3){
            return redirect()->route('login');
        } else if(Auth::user()->role_id == 3){
            $setting = Setting::first();
            $featuredproducts = ProductOutgoing::latest()->where('is_featured', 1)->where('quantity', '>', 0)->take(4)->get();
            return view('frontend.sellphone.sellphone', compact('setting', 'featuredproducts'));
        }
    }
    public function sellsinglephone($slug){
        $product = Product::where('slug', $slug)->first();
        $title = $product->name;
        SEOMeta::setTitle($title);
        $setting = Setting::first();
        $productstorage = ProductStorage::where('product_id', $product->id)->with('product')->get();
        return view('frontend.sellphone.sellproduct', compact('product', 'setting', 'productstorage'));
    }

    public function sellvariant($id)
    {
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        $productstorage = ProductStorage::where('id', $id)->with('product')->first();
        return view('frontend.sellphone.sellvariant', compact('productstorage', 'setting'));
    }

    public function details($slug, $id)
    {
        $setting = Setting::first();
        $productstorage = ProductStorage::where('id', $id)->first();
        $product = Product::where('slug', $slug)->first();
        $title = $product->name;
        SEOMeta::setTitle($title);
        return view('frontend.sellphone.details', compact('product', 'productstorage', 'setting'));
    }

    public function confirmsell(Request $request, $slug, $id)
    {
        // $product = Product::where('slug', $slug)->first();
        $data = $this->validate($request ,[
            'makecalls' => 'required',
            'phonescreen' => 'required',
            'bodydefects' => 'required',
            'timeused' => 'required|numeric',
            'duration' => 'required',
            'warranty' => 'required',
            'return' => 'required',
            'frontcamera' => 'required',
            'backcamera' => 'required',
            'volumebuttons' => 'required',
            'touchscreen' => 'required',
            'battery' => 'required',
            'volumesound' => 'required',
            'colorfaded' => 'required',
            'powerbutton' => 'required',
            'chargingpot' => 'required',
            'fullname' => 'required',
            'phone' => 'required',
            'frontimage' => 'required|mimes:png,jpg,jpeg',
            'backimage' => 'required|mimes:png,jpg,jpeg',
            'otherdefects' => '',
        ]);

        $productstorage = ProductStorage::where('id', $id)->first();
        $product = Product::where('slug', $slug)->first();
        $title = $product->name;
        SEOMeta::setTitle($title);

        $frontimagename = '';
        $backimagename = '';
        if($request->hasfile('frontimage') && $request->hasfile('backimage')){
            $image = $request->file('frontimage');
            $image1 = $request->file('backimage');
            $frontimagename = $image->store('incoming_frontimage', 'uploads');
            $backimagename = $image1->store('incoming_backimage', 'uploads');

            $product_incoming = ProductIncoming::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
                'makecalls' => $data['makecalls'],
                'phonescreen' => $data['phonescreen'],
                'bodydefects' => $data['bodydefects'],
                'timeused' => $data['timeused'],
                'duration' => $data['duration'],
                'warranty' => $data['warranty'],
                'return' => $data['return'],
                'frontcamera' => $data['frontcamera'],
                'backcamera' => $data['backcamera'],
                'volumebuttons' => $data['volumebuttons'],
                'touchscreen' => $data['touchscreen'],
                'battery' => $data['battery'],
                'volumesound' => $data['volumesound'],
                'colorfaded' => $data['colorfaded'],
                'powerbutton' => $data['powerbutton'],
                'chargingpot' => $data['chargingpot'],
                'fullname' => $data['fullname'],
                'phone' => $data['phone'],
                'frontimage' => $frontimagename,
                'backimage' => $backimagename,
                'otherdefects' => $data['otherdefects'],
                'is_approved' => 0,
                'ram' => $productstorage->ram,
                'rom' => $productstorage->rom,
            ]);

            $product_incoming->save();
            $product_incoming->notify(new IncomingProductNotification($product_incoming));
        }
        return redirect()->route('index')->with('success', 'We have received your information. We will contact you soon for further process.');
    }
    // Sell Phone end

    // Cart
    public function cart()
    {
        // $title = $product->name;
        SEOMeta::setTitle('KunPhone');
        if(Auth::guest() || Auth::user()->role_id!=3){
            return redirect()->route('login');
        }
        else if(Auth()->user()->role_id == 3){
            $setting = Setting::first();
            $cartproducts = Cart::where('user_id',Auth()->user()->id)->get();
            return view('frontend.cart', compact('cartproducts', 'setting'));
        }
    }

    public function addtocart(Request $request, $id)
    {
        SEOMeta::setTitle('KunPhone');
        if(Cart::where('product_id', $id)->where('user_id', Auth()->user()->id)->count()>0)
        {
            return redirect()->back()->with('error', 'Product is already in cart.');
        }
        else{
            $productoutgoing = ProductOutgoing::where('id', $id)->first();

            if ($productoutgoing->quantity < $request['quantity']) {
                return redirect()->back()->with('error', 'Cannot select more quantity than in stock.');
            }
            else {
                $cartproduct = Cart::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $productoutgoing->id,
                    'ram' => $productoutgoing->ram,
                    'rom' => $productoutgoing->rom,
                    'quantity' => $request['quantity'],
                    'price' => $productoutgoing->price
                ]);

                $cartproduct->save();
                return redirect()->back()->with('success', 'Product is added to cart.');
            }
        }
    }

    public function updatecart(Request $request, $id){
        SEOMeta::setTitle('KunPhone');
        $cart = Cart::where('id', $id)->first();
        $outgoingproduct = ProductOutgoing::where('id', $cart->product_id)->first();

        if ($request['quantity'] > $outgoingproduct->quantity) {
            return redirect()->back()->with('error', 'Quantity is more than that of available.');
        } else {

            $data = $this->validate($request, [
                'quantity'=>'required|min:1|numeric'
            ]);
            $cart->update([
                'quantity' => $data['quantity'],
            ]);
            $cart->save();
            return redirect()->back()->with('success', 'Cart Successfully Updated.');
        }
    }

    public function deletefromcart($id)
    {
        $cartproduct = Cart::findorFail($id);
        $cartproduct->delete();
        return redirect()->back()->with('success', 'Product removed from cart successfully.');
    }
    // Cart end

    // Checkout
    public function emptycart()
    {
        return redirect()->back()->with('error', 'Your cart is empty.');
    }

    public function placeorder(Request $request)
    {
        SEOMeta::setTitle('KunPhone');
        if(Auth::guest() || Auth::user()->role_id!=3)
        {
            return redirect()->route('index')->with('error', 'Not allowed');
        }
        else if(Auth::user()->role_id==3)
        {
            $cartproducts = Cart::where('user_id', Auth()->user()->id)->get();
            $sum = 0;
            foreach ($cartproducts as $product)
            {
                $sum = $sum + ($product->price*$product->quantity);
            }
            $data = $this->validate($request, [
                'firstname' => 'required',
                'lastname' => 'required',
                'address' => 'required',
                'tole' => 'required',
                'town' => 'required',
                'postcode' => 'required',
                'latitude' => '',
                'longitude' => '',
                'phone' => 'required|numeric',
                'email' => 'required|email',
                'description' => '',
                'payment_method' => '',
                'readterms' => '',
            ]);

            if(empty($data['longitude']))
            {
                $longitude = null;
            }else {
                $longitude = $data['longitude'];
            }

            if(empty($data['latitude']))
            {
                $latitude = null;
            }else {
                $latitude = $data['latitude'];
            }

            $users = DelieveryAddress::all();
            $check = 0;
            foreach ($users as $user) {
                if($user->user_id == Auth::user()->id)
                {
                   $check++;
                }
            }
            if($check > 0){
                $delieveryaddress = DelieveryAddress::create([
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'address' => $data['address'],
                    'tole' => $data['tole'],
                    'town' => $data['town'],
                    'postcode' => $data['postcode'],
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'user_id' => Auth::user()->id,
                    'description' => $data['description'],
                ]);
                $delieveryaddress->save();

            } elseif ($check == 0){
                $delieveryaddress = DelieveryAddress::create([
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'address' => $data['address'],
                    'tole' => $data['tole'],
                    'town' => $data['town'],
                    'postcode' => $data['postcode'],
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'user_id' => Auth::user()->id,
                    'is_default' => 1,
                    'description' => $data['description'],
                ]);
                $delieveryaddress->save();
            }

            $payment = Payment::create([
                'user_id' => Auth::user()->id,
                'price' => $sum,
                'method' => $data['payment_method'],
            ]);
            $payment->save();

            $order = Order::create([
                'user_id' => Auth::user()->id,
                'order_status_id' => 1,
                'delievery_address_id' => $delieveryaddress['id'],
                'payment_id' => $payment['id'],
            ]);
            $order->save();

            foreach ($cartproducts as $product) {
                $cartproduct = ProductOutgoing::where('id', $product->product_id)->first();

                $orderedProduct = OrderedProduct::create([
                    'order_id' => $order['id'],
                    'product_id' => $cartproduct->id,
                    'quantity' => $product->quantity,
                    'price' => $cartproduct->price,
                ]);

                $newquantity = $cartproduct->quantity - $product->quantity;

                $cartproduct->update([
                    'quantity' => $newquantity,
                ]);

                $orderedProduct->save();
                $product->delete();
            }
            $order->notify(new NewOrderNotification($order));
            return redirect()->route('index')->with('success', 'Thank you for ordering. We will get back to you soon.');
        }
    }

    public function checkout()
    {
        SEOMeta::setTitle('KunPhone');
        if(Auth::guest() || Auth::user()->role_id!=3){
            return redirect()->route('login');
        }
        else if(Auth()->user()->role_id == 3){
            $setting = Setting::first();
            $cartproducts = Cart::where('user_id', Auth()->user()->id)->get();
            return view('frontend.checkout', compact('cartproducts', 'setting'));
        }
    }
    // Checkout end

    public function about()
    {
        SEOMeta::setTitle('KunPhone');
        $aboutus = Setting::latest()->first();
        $setting = Setting::first();
        return view('frontend.aboutus', compact('aboutus', 'setting'));
    }
    public function faq()
    {
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        $faqs = Faq::latest()->get();
        return view('frontend.faq', compact('setting', 'faqs'));
    }
    public function contact()
    {
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        return view('frontend.contact', compact('setting'));
    }

    // Comparing phones
    public function compare()
    {
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        return view('frontend.comparison', compact('setting'));
    }

    public function comparephone(Request $request)
    {
        $setting = Setting::first();
        $data = $this->validate($request, [
            'product1' => '',
            'product2' => '',
        ]);

        $product1 = Product::where('name', $data['product1'])->with('productdesign','productstorage','productdisplay','productperformance','productbackcamera', 'productfrontcamera', 'productsound', 'productbattery','productcommunication')->first();
        $product2 = Product::where('name', $data['product2'])->with('productdesign','productstorage','productdisplay','productperformance','productbackcamera', 'productfrontcamera', 'productsound', 'productbattery','productcommunication')->first();

        $title = $product1->name . ' VS ' . $product2->name;
        SEOMeta::setTitle($title);

        if($product1 == null || $product2 == null)
        {
            return redirect()->route('compare')->with('error', 'Select a valid phone from search.');
        }
        else{
            return view('frontend.comparephone', compact('product1', 'product2', 'setting'));
        }
    }
    // Comparing phones end

    //Wishlist
    public function wishlist()
    {
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->get();
        return view('frontend.wishlist', compact('wishlists', 'setting'));
    }

    public function addtowishlist($id)
    {
        SEOMeta::setTitle('KunPhone');
        if(Wishlist::where('product_id','=', $id)->where('user_id','=', Auth()->user()->id)->count() > 0)
        {
            return redirect()->back()->with('error', 'Product Already Added to Wishlist.');
        }
        else
        {
            $wishlist = Wishlist::create([
                'user_id' => Auth::user()->id,
                'product_id' => $id,
            ]);

            $wishlist->save();
            return redirect()->back()->with('success', 'Product is added to wishlist.');
        }
    }

    public function destroywishlist($id)
    {
        $wish = Wishlist::findorFail($id);
        $wish->delete();
        return redirect()->back()->with('success', 'Product Successfully Deleted from wishlist.');
    }

    // Wishlist End

    // Approved Products for Exchange

    public function approvedforexchange()
    {
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        $approvedproducts = ProductIncoming::latest()->where('user_id', Auth::user()->id)->where('is_confirmed', 0)->where('is_approved', 1)->get();
        $exchangedproducts = ExchangeConfirm::latest()->where('user_id', Auth::user()->id)->get();
        return view('frontend.exchange.approvedproducts', compact('approvedproducts', 'setting', 'exchangedproducts'));
    }

    public function exchange($price , $id)
    {
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        $brands = Brand::orderBy('name','ASC')->get();
        $productoutgoing = ProductOutgoing::where('quantity', '>' , 0)->where('price', '>=', $price)->simplePaginate(9);
        return view('frontend.exchange.exchangeshop', compact('brands', 'productoutgoing' ,'price', 'id', 'setting'));
    }

    public function exchangewith($price, $outgoing_id , $incoming_id)
    {
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        $outgoingproduct = ProductOutgoing::where('id', $outgoing_id)->first();
        $incomingproduct = ProductIncoming::where('id', $incoming_id)->first();
        $exchangingproduct = Product::where('id', $incomingproduct->product_id)->first();
        $exchangingwith = Product::where('id', $outgoingproduct->product_id)->first();
        $vendors = Vendor::get();
        return view('frontend.exchange.exchangefinal', compact('outgoingproduct', 'setting', 'incomingproduct' , 'price','exchangingproduct', 'exchangingwith', 'vendors'));
    }

    public function exchangecheckout(Request $request,  $outgoing_id , $incoming_id)
    {
        SEOMeta::setTitle('KunPhone');
        $outgoingproduct = ProductOutgoing::where('id', $outgoing_id)->first();
        $incomingproduct = ProductIncoming::where('id', $incoming_id)->first();

        $data = $this->validate($request, [
            'vendor' => 'required',
        ]);

        $price = $outgoingproduct->price - $incomingproduct->price;
        $exchangeorder = ExchangeConfirm::create([
            'user_id' => Auth::user()->id,
            'incomingproduct_id' => $incomingproduct->id,
            'product1_ram' => $incomingproduct->ram,
            'product1_rom' => $incomingproduct->rom,
            'product1_price' => $incomingproduct->price,
            'outgoingproduct_id' => $outgoingproduct->id,
            'product2_ram' => $outgoingproduct->ram,
            'product2_rom' => $outgoingproduct->rom,
            'product2_price' => $outgoingproduct->price,
            'pricediff' => $price,
            'vendor' => $data['vendor'],
            'exchangecode' => $incomingproduct->exchangecode,
            'frontimage' => $incomingproduct->frontimage,
            'backimage' => $incomingproduct->backimage,
            'is_processsing' => 1,
        ]);
        $exchangeorder->save();
        $exchangeorder->notify(new ExchangeOrderNotification($exchangeorder));

        $newquantity = $outgoingproduct->quantity - 1;
        $outgoingproduct->update([
            'quantity' => $newquantity,
        ]);
        $incomingproduct->update([
            'is_confirmed' => 1,
        ]);
        return redirect()->route('approvedforexchange')->with('success', 'Your exchange request is in process. Visit our selected vendor to exchange.');
    }

    // public function exchangeorder(Request $request, $price, $outgoing_id , $incoming_id)
    // {
    //     $outgoingproduct = ProductOutgoing::where('id', $outgoing_id)->first();
    //     $incomingproduct = ProductIncoming::where('id', $incoming_id)->first();
    //     $exchangingproduct = Product::where('id', $incomingproduct->product_id)->first();
    //     $exchangingwith = Product::where('id', $outgoingproduct->product_id)->first();

    //     $subtotal = $outgoingproduct->price - $incomingproduct->price;

    //     $data = $this->validate($request, [
    //         'firstname' => 'required',
    //         'lastname' => 'required',
    //         'address' => 'required',
    //         'tole' => 'required',
    //         'town' => 'required',
    //         'postcode' => 'required',
    //         'latitude' => '',
    //         'longitude' => '',
    //         'phone' => 'required|numeric',
    //         'email' => 'required|email',
    //         'description' => '',
    //     ]);

    //     if(empty($data['longitude']))
    //     {
    //         $longitude = null;
    //     }else {
    //         $longitude = $data['longitude'];
    //     }

    //     if(empty($data['latitude']))
    //     {
    //         $latitude = null;
    //     }else {
    //         $latitude = $data['latitude'];
    //     }

    //     $users = DelieveryAddress::all();
    //     $check = 0;
    //     foreach ($users as $user) {
    //         if($user->user_id == Auth::user()->id)
    //         {
    //            $check++;
    //         }
    //     }
    //     if($check > 0){
    //         $delieveryaddress = DelieveryAddress::create([
    //             'firstname' => $data['firstname'],
    //             'lastname' => $data['lastname'],
    //             'address' => $data['address'],
    //             'tole' => $data['tole'],
    //             'town' => $data['town'],
    //             'postcode' => $data['postcode'],
    //             'latitude' => $latitude,
    //             'longitude' => $longitude,
    //             'phone' => $data['phone'],
    //             'email' => $data['email'],
    //             'user_id' => Auth::user()->id,
    //             'description' => $data['description'],
    //         ]);
    //         $delieveryaddress->save();

    //     } elseif ($check == 0){
    //         $delieveryaddress = DelieveryAddress::create([
    //             'firstname' => $data['firstname'],
    //             'lastname' => $data['lastname'],
    //             'address' => $data['address'],
    //             'tole' => $data['tole'],
    //             'town' => $data['town'],
    //             'postcode' => $data['postcode'],
    //             'latitude' => $latitude,
    //             'longitude' => $longitude,
    //             'phone' => $data['phone'],
    //             'email' => $data['email'],
    //             'user_id' => Auth::user()->id,
    //             'is_default' => 1,
    //             'description' => $data['description'],
    //         ]);
    //         $delieveryaddress->save();
    //     }

    //     $exchangeorder = ExchangeOrder::create([
    //         'user_id' => Auth::user()->id,
    //         'order_status_id' => 1,
    //         'delievery_address_id' => $delieveryaddress['id'],
    //         'exchanging_product' => $exchangingproduct->name,
    //         'product1_ram' => $incomingproduct->ram,
    //         'product1_rom' => $incomingproduct->rom,
    //         'product1_price' => $price,
    //         'exchanged_product' => $exchangingwith->name,
    //         'product2_ram' => $outgoingproduct->ram,
    //         'product2_rom' => $outgoingproduct->rom,
    //         'product2_price' => $outgoingproduct->price,
    //         'pricediff' => $subtotal,
    //         'payment_method' => $data['payment_method'],
    //     ]);
    //     $exchangeorder->save();
    //     $exchangeorder->notify(new ExchangeOrderNotification($exchangeorder));

    //     $newquantity = $outgoingproduct->quantity - 1;
    //     $outgoingproduct->update([
    //         'quantity' => $newquantity,
    //     ]);
    //     $incomingproduct->delete();
    //     return redirect()->route('index')->with('success', 'Thank you for ordering. We will get back to you soon.');
    // }

    public function myprofile()
    {
        $setting = Setting::first();
        $user = User::where('id', Auth::user()->id)->first();
        $title = $user->name;
        SEOMeta::setTitle($title);
        return view('frontend.myprofile.myprofile', compact( 'setting', 'user'));
    }

    public function editinfo()
    {
        $setting = Setting::first();
        $user = User::where('id', Auth::user()->id)->first();
        $title = $user->name;
        SEOMeta::setTitle($title);
        return view('frontend.myprofile.editinfo', compact( 'setting', 'user'));
    }

    public function updateinfo(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email'
        ]);
        $user = User::findorFail($id);
        $user->update([
            'name' => $data['name'],
            'email' => $data['email']
        ]);
        return redirect()->route('myprofile')->with('success', 'User Info updated successfully.');
    }

    public function otpvalidation(Request $request)
    {
        // $title = $user->name;
        SEOMeta::setTitle('KunPhone');
        $data = $this->validate($request, [
            'otpcode' => 'required|numeric',
        ]);

        $cookiedata = Cookie::get('otpcookie');

        if($data['otpcode'] == $cookiedata) {

            $setting = Setting::first();
            return view('frontend.myprofile.editpassword', compact( 'setting'));
        }
        else {
            return response()->json([
                'error_message' => 'Your otp code didnt match.'
            ], Response::HTTP_OK);
        }
    }

    public function updatePassword(Request $request)
    {
        $data = $this->validate($request,[
            'oldpassword' =>  'required',
            'newpassword' => 'required|min:8|confirmed|different:password',
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        if(Hash::check($data['oldpassword'], $user->password))
        {
            if(!Hash::check($data['newpassword'], $user->password))
            {
                $newpassword = Hash::make($data['newpassword']);
                $user->update([
                    'password' => $newpassword,
                ]);
                $user->save();
                return redirect()->route('myprofile')->with('success', 'Password has been changed.');
            }
            else
            {
                return redirect()->back()
                        ->with('samepass', 'Old password cannot be new password.');
            }
        }
        else{
            return redirect()->back()
                    ->with('oldfailure', 'Your old password doesnot match our credentials.');
        }
    }

    public function myaccount()
    {
        $setting = Setting::first();
        $user = User::where('id', Auth::user()->id)->first();
        $title = $user->name;
        SEOMeta::setTitle($title);
        $delieveryaddress = DelieveryAddress::where('user_id', $user->id)->where('is_default', 1)->first();
        return view('frontend.myaccount', compact( 'setting', 'user', 'delieveryaddress'));
    }

    public function myorders()
    {
        // $title = $user->name;
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        $orders = Order::latest()->where('user_id', Auth::user()->id)->with('orderStatus', 'delieveryAddress', 'payment')->get();
        return view('frontend.myorders', compact( 'setting', 'orders'));
    }

    public function cancelorder(Request $request, $id)
    {
        $order = Order::findorfail($id);
            if($order->order_status_id == 1 || $order->order_status_id == 2 || $order->order_status_id == 3){
                $data = $this->validate($request, [
                    'reason' => 'required',
                ]);
                $order->update([
                    'order_status_id' => 6,
                ]);
                $description = 'Cancelled By: '.Auth()->user()->name.'<br> Reason behind Cancellation:'.$data['reason'];
                $cancellation = Cancelorder::create([
                    'order_id' => $order->id,
                    'description' => $description,
                ]);
                $cancellation->save();

                $orderedproducts = OrderedProduct::where('order_id', $order->id)->get();
                foreach($orderedproducts as $orderedproduct)
                {
                    $outgoingproduct = ProductOutgoing::where('id', $orderedproduct->product_id)->first();

                    $newquantity = $outgoingproduct->quantity + $orderedproduct->quantity;
                    $outgoingproduct->update([
                        'quantity' => $newquantity,
                    ]);
                }
                return redirect()->back()->with('success', 'Cancellation successful.');
            }
    }

    public function incomingquestions(Request $request, $id)
    {
        // $title = $user->name;
        SEOMeta::setTitle('KunPhone');
        $data = $this->validate($request, [
            'question' => 'required'
        ]);

        $question = Question::create([
            'user_id' => Auth::user()->id,
            'outproduct_id' => $id,
            'question' => $data['question']
        ]);

        $question->save();
        return redirect()->back()->with('success', 'Thank you for your question. We will get back to you soon.');
    }

    public function addreview(Request $request, $id)
    {
        $data = $this->validate($request, [
            'star' => 'required',
            'product_id' => 'required',
            'ratingdescription' => ''
        ]);

        $review = Review::create([
            'user_id' => Auth::user()->id,
            'product_id' => $data['product_id'],
            'rating' => $data['star'],
            'description' => $request['ratingdescription'],
        ]);

        $review->save();

        return redirect()->back()->with('success', 'Review added successfully');
    }

    public function updatereview(Request $request, $id)
    {
        $userreview = Review::findorfail($id);
        $data = $this->validate($request, [
            'star' => 'required',
            'ratingdescription' => ''
        ]);
        $userreview->update([
            'rating' => $data['star'],
            'description' => $request['ratingdescription'],
        ]);
        $userreview->save();
        return redirect()->back()->with('success', 'Review updated successfully');
    }

    public function myreviews()
    {
        // $title = $user->name;
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        $reviews = Review::latest()->where('user_id', Auth::user()->id)->get();
        $questions = Question::latest()->where('user_id', Auth::user()->id)->get();
        return view('frontend.myreviews', compact( 'setting', 'reviews', 'questions'));
    }
    public function editaddress()
    {
        // $title = $user->name;
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        $address = DelieveryAddress::where('user_id', Auth::user()->id)->where('is_default', 1)->first();

        return view('frontend.editaddress', compact('setting', 'address'));
    }

    public function updateaddress(Request $request, $id)
    {
        $data = $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'tole' => 'required',
            'town' => 'required',
            'longitude' => '',
            'latitude' => '',
        ]);

        if(empty($data['longitude']))
            {
                $longitude = null;
            }else {
                $longitude = $data['longitude'];
            }

            if(empty($data['latitude']))
            {
                $latitude = null;
            }else {
                $latitude = $data['latitude'];
            }

        $address = DelieveryAddress::findorfail($id);

        $address->update([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'tole' => $data['tole'],
            'town' => $data['town'],
            'longitude' => $longitude,
            'latitude' => $latitude,
        ]);
        return redirect()->route('myaccount')->with('success', 'Address information Updated Successfully');
    }
    public function policy()
    {
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        return view('frontend.policy', compact('setting'));
    }
    public function termsandconditions()
    {
        SEOMeta::setTitle('KunPhone');
        $setting = Setting::first();
        return view('frontend.termsandconditions', compact('setting'));
    }
}
