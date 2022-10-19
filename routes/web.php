<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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
	return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
	// ajax route
	Route::get('fetch/category_brands/{category}', [ProductController::class, 'category_brands']);
	Route::get('fetch_products', [OrderController::class, 'fetch_products']);
	Route::post('fetch_single_product', [OrderController::class, 'fetch_single_product']);
	Route::post('fetch_customer', [OrderController::class, 'fetch_customer']);

	// custom permission route
	Route::get('permission/filter', [PermissionController::class,'filter'])->name('permission.filter');
	// Route::get('orders/filter','CustomerController@filter')->name('orders.filter');
	// custom permission route end here

	// custom customer route
	Route::get('customer/orders', [CustomerController::class,'orders'])->name('orders.filter');

	// custom customer route end here

	Route::resource('user', UserController::class);
	Route::resource('role', RoleController::class);
	Route::resource('category', CategoryController::class);
	Route::resource('permission', PermissionController::class);
	Route::resource('brand', BrandController::class);
	Route::resource('product', ProductController::class);
	Route::resource('customer', CustomerController::class);
	Route::resource('order', OrderController::class);
});



// product filter route
Route::get('/filters', 'ProductfilterController@index');
Route::post('/fetch_products', 'ProductfilterController@fetch_products');


// product filter route end here


// sql testing route
Route::get('/sql', 'ProductfilterController@sql');
// sql route end here
