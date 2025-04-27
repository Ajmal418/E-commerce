<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ProdcutController; 
use App\Http\Controllers\home\HomeController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Route::fallback(function () {
    return view('404');
});
Route::get('/login', [AdminController::class, 'index'])->name('login');
Route::post('/userlogin', [AdminController::class, 'login'])->name('admin.login');

Route::group(['prefix' => 'admin','middleware'=>'auth'], function () {
   
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [ProdcutController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products', [ProdcutController::class, 'index'])->name('products');
    Route::post('/products', [ProdcutController::class, 'products'])->name('products.store');
    Route::get('/products/{id}', [ProdcutController::class, 'editProduct'])->name('products.edit');
    Route::post('/products/{id}', [ProdcutController::class, 'updateproduct'])->name('products.update');
    Route::get('/products/destroy/{id}', [ProdcutController::class, 'destroy'])->name('products.destroy');
});




Route::get('/', [HomeController::class,'index'])->name('home.index');
Route::get('/cart', [HomeController::class,'cart'])->name('home.cart');


