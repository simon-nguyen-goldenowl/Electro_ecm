<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishListController;
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
//Routes are used to display client side's pages
Route::get('/', [CustomerController::class, 'displayIndexPage']);
Route::get('/index', [CustomerController::class, 'displayIndexPage']);
Route::get('/products', [CustomerController::class, 'displayStorePage']);
Route::get('/product-list', [CustomerController::class, 'displayProductListComponent']);
Route::get('/review-list/{id}', [CustomerController::class, 'displayReviewListComponent']);
Route::get('/products/{id}', [CustomerController::class, 'displayProductPage']);
Route::get('/checkout', [CustomerController::class, 'displayCheckoutPage']);
Route::get('/carts', [CustomerController::class, 'displayCartPage']);
Route::get('/wishlists', [CUstomerController::class, 'displayWishlistPage']);
Route::get('/register', [CUstomerController::class, 'displayRegisterPage']);
Route::get('/profile', [CustomerController::class, 'displayProfilePage']);
Route::get('/profile/password-change', [CustomerController::class, 'displayChangePasswordPage']);
Route::get('/orders', [CustomerController::class,'displayOrderPage']);
Route::get('/orders/{id}', [CustomerController::class,'displayOrderDetailPage']);
Route::get('/password/forgot', [CustomerController::class, 'displayForgotPasswordPage']);
Route::get('/password/reset/{id}', [CustomerController::class, 'displayResetPasswordPage']);
Route::get('/search', [CustomerController::class, 'displaySearchPage']);


//Routes are used to process cart resource
Route::post('/carts/{id}', [CartController::class, 'addCart']);
Route::patch('/carts/{id}', [CartController::class,'updateCart']);
Route::delete('/carts/{id}', [CartController::class,'deleteItem']);

//Routes are used to process order resource
Route::post('/orders', [OrderController::class, 'store']);

//Routes are used to process order resource
Route::post('/reviews', [ReviewController::class, 'store']);

//Routes are used to process user resource
Route::post('/users', [UserController::class, 'store']);
Route::patch('/users/{id}', [UserController::class, 'update']);


//Routes are used to process wishlist resource
Route::delete('/wishlists/{id}', [WishListController::class, 'deleteWishlist']);
Route::post('/wishlists/{id}', [WishListController::class, 'addWishlist']);

//Routes are used to process authentication
Route::post('/login', [AuthController::class, 'customerLogin']);
Route::delete('/logout', [AuthController::class, 'logout']);

//Routes are used to process reset password
Route::post('/password/check-mail', [AuthController::class,'checkMail']);
Route::patch('/password/{id}/reset', [AuthController::class, 'resetPassword']);
Route::patch('/password/{id}/change', [AuthController::class, 'changePassword']);

//Routes are used to proccess search
Route::post('/search', [SearchController::class, 'submitSearch']);

//Routes are used to display admin's side page
Route::get('/admin', function () {
    return view('Admin');
});
Route::view('/admin/{any}', 'Admin')
    ->where('any', '.*');
