<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::as('api.')->group(function (){
    Route::apiResource('products', ProductController::class);
    Route::apiResource('tags', TagController::class);

    Route::post('/login', [AuthController::class, 'store']);
    Route::middleware('auth:sanctum')->delete('/logout', [AuthController::class, 'destroy']);
});
