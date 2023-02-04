<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\QRCodeController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function ()
{
    Route::post('login','login');
    Route::post('register','register');
    Route::post('logout','logout');
    Route::post('refresh','refresh');
});




Route::controller(CategoryController::class)->group(function(){
    Route::get('categories','getAllCategories');
    Route::get('categories/{id}','getCategoryById');
    Route::post('categories','addCategory');
    Route::put('categories/{id}','updateCategoryById');
    Route::delete('categories/{id}','deleteCategoryById');
});

Route::controller(ProductController::class)->group(function(){
    Route::get('products','getAllProducts');
    Route::get('products/{id}','getProductById');
    Route::post('products','addProduct');
    Route::put('products/{id}','updateProductById');
    Route::delete('products/{id}','deleteProductById');
});

Route::controller(CartController::class)->group(function(){
    Route::get('carts','getCart');
    Route::post('carts','addToCart');
    Route::patch('carts','removeFromCart');
    Route::delete('carts','deleteCart');
});

Route::controller(QRCodeController::class)->group(function(){
    Route::get('qr-cart','cartQR');
    Route::post('qr-read','readQR')->name('qrinfo');
    Route::get('qr-read','page');
});