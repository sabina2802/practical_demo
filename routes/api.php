<?php

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

 // API route for login
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group( function () {

       // API route for login products
      Route::post('/addProduct', [App\Http\Controllers\API\ProductController::class, 'addProduct']);
      Route::post('/listProduct', [App\Http\Controllers\API\ProductController::class, 'listProduct']);
      Route::post('/showProduct', [App\Http\Controllers\API\ProductController::class, 'showProduct']);
    
      // API route for logout
      Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});
