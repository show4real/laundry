<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\AdminVendorController;

use App\Http\Controllers\ForgotPasswordController;


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



 
Route::post('login', [LoginController::class, 'login']);
Route::post('vendor_register', [RegisterController::class, 'vendorRegister']);

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('recoverpassword/{recovery_code}', 'recover');
    Route::post('resetpassword', 'changepassword');
    Route::post('sendrecovery', 'sendrecovery');
});



Route::group(['middleware' => ['jwt.auth', 'CheckAdmin'], 'prefix' => 'admin'],
    function () {
      
        Route::controller(UserController::class)->group(function () {
            Route::post('users', 'index');
            Route::post('adduser', 'save');
            Route::post('updateuser/{user}', 'update');
            Route::get('user/{user}', 'show');
            Route::post('deleteuser/{id}', 'delete');
        });

        Route::controller(AdminVendorController::class)->group(function () {
            Route::post('vendors', 'index');
            Route::post('addvendor', 'save');
            Route::post('vendoruser/{vendor}', 'update');
            Route::get('vendor/{vendor}', 'show');
            Route::post('vendor/delete/{id}', 'delete');
        });

         Route::controller(CategoryController::class)->group(function () {
            Route::post('categories', 'index');
            Route::post('addcategory', 'save');
            Route::post('updatecategory/{category}', 'update');
            Route::get('category/{category}', 'show');
            Route::post('deletecategory/{id}', 'delete');
        });

        Route::controller(ServiceController::class)->group(function () {
            Route::post('services', 'index');
            Route::post('addservice', 'save');
            Route::post('updateservice/{service}', 'update');
            Route::get('service/{service}', 'show');
            Route::post('deleteservice/{id}', 'delete');
        });

         Route::controller(ProductController::class)->group(function () {
            Route::post('products', 'index');
            Route::post('addproduct', 'save');
            Route::post('updateproduct/{product}', 'update');
            Route::get('product/{product}', 'show');
            Route::post('deleteproduct/{id}', 'delete');
        });


    }
);

Route::group(['middleware' => ['jwt.auth', 'CheckVendor'], 'prefix' => 'vendor'],
    function () {
     
        Route::controller(VendorController::class)->group(function () {
           
            Route::post('save', 'save');
            Route::get('profile', 'vendor');

        });

         Route::controller(CategoryController::class)->group(function () {
            Route::post('categories', 'index');
            Route::get('category/{category}', 'show');
        });

        Route::controller(ServiceController::class)->group(function () {
            Route::post('services', 'index');
            Route::get('service/{service}', 'show');
        });

         Route::controller(VendorProductController::class)->group(function () {
            Route::post('products', 'index');
            Route::post('saveproduct', 'save');
            Route::post('product/{product}', 'update');
            Route::get('product/{product}', 'show');
            Route::post('product/delete/{id}', 'delete');
        });


    }
);




