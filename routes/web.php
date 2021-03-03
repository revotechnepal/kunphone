<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ExchangeConfirmController;
use App\Http\Controllers\ExchangeOrderController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductIncomingController;
use App\Http\Controllers\ProductOutgoingController;
use App\Http\Controllers\ProductUsedController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\FaqController;
use App\Models\ExchangeConfirm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
})->name('index');

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/faq', [FrontController::class, 'faq'])->name('faq');
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
Route::get('/shop', [FrontController::class, 'shop'])->name('shop');
Route::get('/oldshop', [FrontController::class, 'oldshop'])->name('oldshop');
Route::get('/newshop', [FrontController::class, 'newshop'])->name('newshop');

// Cart
Route::get('/cart', [FrontController::class, 'cart'])->name('cart');
Route::post('/addtocart/{id}', [FrontController::class, 'addtocart'])->name('addtocart');
Route::get('/checkout', [FrontController::class, 'checkout'])->name('checkout');
Route::get('/removecart/{id}', [FrontController::class, 'deletefromcart'])->name('removecart');
Route::post('/updatecart/{id}', [FrontController::class, 'updatecart'])->name('updatecart');
Route::get('/emptycart', [FrontController::class, 'emptycart'])->name('emptycart');

// Products
Route::get('/product/{id}/{slug}', [FrontController::class, 'product'])->name('product');
Route::get('/brandproduct/{slug}', [FrontController::class, 'brandproduct'])->name('brandproduct');

// Buy Product
Route::post('/placeorder', [FrontController::class, 'placeorder'])->name('placeorder');
Route::get('/sellphone', [FrontController::class, 'sellphone'])->name('sellphone');
Route::get('/sellsinglephone/{slug}', [FrontController::class, 'sellsinglephone'])->name('sellsinglephone');
Route::get('/sellvariant/{id}', [FrontController::class, 'sellvariant'])->name('sellvariant');
Route::get('/details/{slug}/{id}', [FrontController::class, 'details'])->name('details');
Route::post('/details/submitdetails/{slug}/{id}', [FrontController::class, 'confirmsell'])->name('details.submitdetails');

// Search price slider
Route::get('/shop/pricesearch', [FrontController::class, 'pricesearch'])->name('shop.pricesearch');
Route::get('/shop/pricesearchbrand/{slug}', [FrontController::class, 'pricesearchbrand'])->name('shop.pricesearchbrand');

// Comparison
Route::get('/compare', [FrontController::class, 'compare'])->name('compare');
Route::post('/comparephone', [FrontController::class, 'comparephone'])->name('comparephone');

// Wishlist
Route::get('/wishlist', [FrontController::class, 'wishlist'])->name('wishlist');
Route::get('/remove/{id}', [FrontController::class, 'destroywishlist'])->name('remove');
Route::get('/addtowishlist/{id}', [FrontController::class, 'addtowishlist'])->name('addtowishlist');

// Approved Products For Exchange
Route::get('/approvedforexchange', [FrontController::class, 'approvedforexchange'])->name('approvedforexchange');
Route::get('/exchange/{price}/{id}', [FrontController::class, 'exchange'])->name('exchange');
Route::get('/exchangewith/{price}/{outgoing_id}/{incoming_id}', [FrontController::class, 'exchangewith'])->name('exchangewith');
Route::put('/exchangecheckout/{outgoing_id}/{incoming_id}', [FrontController::class, 'exchangecheckout'])->name('exchangecheckout');
// Route::post('/exchangeorder/{price}/{outgoing_id}/{incoming_id}', [FrontController::class, 'exchangeorder'])->name('exchangeorder');
Route::put('/cancelorder/{id}', [FrontController::class, 'cancelorder'])->name('cancelorder');

// Customer Email
Route::get('/customerEmail', [MailController::class, 'customerEmail'])->name('customerEmail');

// My Profile
Route::get('/myprofile', [FrontController::class, 'myprofile'])->name('myprofile');
Route::get('/myaccount', [FrontController::class, 'myaccount'])->name('myaccount');
Route::get('/editinfo', [FrontController::class, 'editinfo'])->name('editinfo');
Route::put('/updateinfo/{id}', [FrontController::class, 'updateinfo'])->name('updateinfo');
Route::get('/myorders', [FrontController::class, 'myorders'])->name('myorders');
Route::get('/send-otpemail', [MailController::class, 'sendEmail'])->name('sendotp');
Route::get('/otpvalidation', [FrontController::class, 'otpvalidation'])->name('otpvalidation');
Route::put('/updatepassword', [FrontController::class, 'updatePassword'])->name('updatepassword');

// My Address
Route::get('/editaddress', [FrontController::class, 'editaddress'])->name('editaddress');
Route::put('/updateaddress/{id}', [FrontController::class, 'updateaddress'])->name('updateaddress');

// Questions and reviews
Route::post('/questions/{id}', [FrontController::class, 'incomingquestions'])->name('questions');
Route::post('/addreview/{id}',[FrontController::class, 'addreview'])->name('addreview');
Route::put('/updatereview/{id}',[FrontController::class, 'updatereview'])->name('updatereview');
Route::get('/myreviews',[FrontController::class, 'myreviews'])->name('myreviews');
Route::get('/policy',[FrontController::class, 'policy'])->name('policy');
Route::get('/termsandconditions',[FrontController::class, 'termsandconditions'])->name('termsandconditions');


//Blogs
Route::get('/blogs',[FrontController::class, 'blogs'])->name('blogs');
Route::get('/categoryblogs/{slug}',[FrontController::class, 'categoryblogs'])->name('categoryblogs');
Route::get('/viewblog/{id}',[FrontController::class, 'viewblog'])->name('viewblog');





// Route::get('/dashboard', [FrontController::class, 'dashboard'])->name('dashboard');
Route::get('/home', function () {
    if(Auth::user()->role_id == "3"){
        return redirect()->route('index');
    }else{
        return view('backend.index');
    }
})->name('dashboard');

Route::group(['prefix'=>'admin','as'=>'admin.','middleware' => ['auth', 'roles'], 'roles'=>['admin']], function(){
    Route::resource('brand', BrandController::class);
    Route::resource('user', UserController::class);
    // Route::get('/product/brandproducts', [ProductController::class,'brandproducts'])->name('product.brandproducts');
    Route::get('/product/index/{slug}', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/variant/{slug}', [ProductController::class, 'variant'])->name('product.variant');
    Route::post('/product/variant/{slug}', [ProductController::class, 'addvariant'])->name('product.addvariant');
    Route::resource('product', ProductController::class, ['except'=>'variant','except'=>'addvariant','except'=>'index']);
    Route::resource('productoutgoing', ProductOutgoingController::class);
    Route::resource('productused', ProductUsedController::class);
    Route::get('/productincoming/approved', [ProductIncomingController::class, 'approved'])->name('productincoming.approved');
    Route::get('/productincoming/view/{id}', [ProductIncomingController::class, 'view'])->name('productincoming.view');
    Route::get('/notificationsread', [ProductIncomingController::class, 'notificationsread'])->name('notificationsread');
    Route::resource('productincoming', ProductIncomingController::class);
    Route::put('/updatestatus/{id}', [OrderController::class, 'updatestatus'])->name('updatestatus');
    Route::put('/paymentstatus/{id}', [OrderController::class, 'paymentstatus'])->name('paymentstatus');
    Route::resource('order', OrderController::class);
    // Route::put('/updateexchangestatus/{id}', [ExchangeOrderController::class, 'updateexchangestatus'])->name('updateexchangestatus');
    // Route::resource('exchangeorder', ExchangeOrderController::class);
    Route::put('/confirmorder/{id}', [OrderManagementController::class, 'confirmorder'])->name('confirmorder');
    Route::resource('ordermanagement', OrderManagementController::class);
    Route::resource('setting', SettingController::class);
    Route::resource('slider', SliderController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('vendor', VendorController::class);
    Route::resource('exchangeconfirm', ExchangeConfirmController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('blogcategory', BlogCategoryController::class);
    Route::resource('blog', BlogController::class);



});
Route::group(['prefix'=>'admin','as'=>'admin.','middleware' => ['auth', 'roles'], 'roles'=>['admin','vendor']], function(){
    Route::resource('productoutgoing', ProductOutgoingController::class);
    Route::resource('productused', ProductUsedController::class);
    Route::get('vendor/edit/{id}', [VendorController::class, 'edit'])->name('vendor.edit');
    Route::put('vendor/update/{id}', [VendorController::class, 'update'])->name('vendor.update');
});

// Sign in with google
Route::get('auth/google', [SocialMediaController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialMediaController::class, 'handleGoogleCallback']);

// Sign in with facebook
Route::get('auth/facebook', [SocialMediaController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [SocialMediaController::class, 'facebookSignin']);

Auth::routes();

// Route::get('/home', [App\Http\Controllers\FrontController::class, 'index'])->name('home');
Route::get('/verify',[RegisterController::class, 'verifyUser'])->name('verify.user');
