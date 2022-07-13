<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;
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
Route::post('/user/login', [AuthController::class ,'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', static function (Request $request) {
        return response()->json([
            'status' => true,
            'message' => 'Authenticated user',
            'data' => $request->user()
        ]);
    });
    Route::get('products/stock', [ProductController::class,'stock']);
    Route::apiResource('products', ProductController::class)->except('edit');
    Route::apiResource('tags', TagController::class)->except([
        'index', 'show', 'update', 'destroy'
    ]);
});


