<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Api\ZivoController;
use App\Http\Middleware\AuthenticateZivo;

Route::prefix('zivo/v1')->name('zivo.')->middleware(AuthenticateZivo::class)->group(function () {
    Route::get('/products', [ZivoController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ZivoController::class, 'show'])->whereNumber('id')->name('products.show');
    Route::get('/store/policies', [ZivoController::class, 'policies'])->name('store.policies');
});

Route::post("/test/",[WelcomeController::class,'testApi']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::group(['prefix' => 'v1'], function () {
     Route::post('/login', 'UsersController@login');
     Route::post('/register', 'UsersController@register');
    Route::get('/logout', 'UsersController@logout')->middleware('auth:api');
});


