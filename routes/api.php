<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use williamcruzme\FCM\Facades\Device;

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


Route::prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, 'adminLogin']);
    Route::delete('logout', [AuthController::class, 'adminLogout']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('wishlists', WishlistController::class);
        Route::resource('reviews', ReviewController::class);
        Route::resource('statuses', StatusController::class);
        Route::resource('brands', BrandController::class);
        Route::get('checkAuthenticated', function () {
            return \App\Enums\ResultType::Success;
        });
    });
});
Route::prefix('user')->group(function () {
    Device::routes();
    route::post('login', [AuthController::class, 'userLogin']);
    route::get('profile', [UserController::class, 'getProfile'])->middleware('checkJWT');
    route::post('review/submit', [ReviewController::class, 'submitReview'])->middleware('checkJWT');
    route::get('notifications', [UserController::class, 'showAllNoti'])->middleware('checkJWT');
    route::get('notifications/read', [UserController::class, 'readNoti'])->middleware('checkJWT');
});
Route::prefix('search')->group(function () {
    route::get('autocomplete', [SearchController::class,'autoComplete']);
});
