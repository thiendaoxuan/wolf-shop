<?php

use App\Http\Controllers\WolfShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/products/{id}/upload-image', [WolfShopController::class, 'uploadImage']);
