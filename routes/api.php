<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
//use App\Http\Controllers\API\ExchangeConfirmController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\FaqController;
use App\Http\Controllers\API\CancelOrderController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\DeliveryAddressController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\SettingController;
use App\Http\Controllers\API\SliderController;
use App\Http\Controllers\API\WishlistController;
use App\Http\Controllers\API\OrderedProductsController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\OrderStatusController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\IncomingProductController;
use App\Http\Controllers\API\OutgoingProductController;
use App\Http\Controllers\API\UsedProductController;

use App\Http\Controllers\API\ExchangeConfirmController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::resource('faq', FaqController::class);
Route::resource('brands', BrandController::class);
Route::resource('sliders', SliderController::class);
Route::resource('settings', SettingController::class);
Route::resource('outgoingproducts', OutgoingProductController::class);
Route::resource('usedproducts', UsedProductController::class);
Route::resource('orderstatus', OrderStatusController::class);
Route::resource('products', ProductController::class);
Route::get('questions', [QuestionController::class, 'index']);
Route::get('reviews', [ReviewController::class, 'index']);


Route::middleware('auth:api')->group( function () {

    Route::resource('exchangeconfirm', ExchangeConfirmController::class);
    Route::post('cancelorder', [CancelOrderController::class, 'store']);
    Route::resource('cart', CartController::class);
    Route::resource('deliveryaddress', DeliveryAddressController::class);

    //Route::resource('questions', QuestionController::class);
    Route::post('questions', [QuestionController::class, 'store']);

    //Route::resource('reviews', ReviewController::class);
    Route::post('reviews', [ReviewController::class, 'store']);
    Route::put('reviews/{id}', [ReviewController::class, 'update']);

    Route::resource('wishlists', WishlistController::class);
    Route::resource('orderedproducts', OrderedProductsController::class);
    Route::resource('orders', OrderController::class);

    Route::resource('payments', PaymentController::class);

    Route::resource('incomingproducts', IncomingProductController::class);

});
