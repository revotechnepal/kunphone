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
Route::resource('sliders', SliderController::class);

Route::middleware('auth:api')->group( function () {
    Route::resource('brands', BrandController::class);
    Route::resource('faq', FaqController::class);

    //Route::post('cancelorder', CancelOrderController::class);
    Route::resource('exchangeconfirm', ExchangeConfirmController::class);
    Route::post('cancelorder', [CancelOrderController::class, 'store']);
    Route::resource('cart', CartController::class);
    Route::resource('deliveryaddress', DeliveryAddressController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('settings', SettingController::class);


});
