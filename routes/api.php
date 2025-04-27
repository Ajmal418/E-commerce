<?php
use App\Http\Controllers\home\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/productlist',[Homecontroller::class, 'productlist']);
Route::get('/cartitems',[Homecontroller::class, 'cartItems']);
Route::delete('/removecartitem/{id}', [Homecontroller::class, 'removeCartItem']);
Route::post('/addtocart',[Homecontroller::class, 'addToCart']);
