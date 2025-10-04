<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImageController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/product',ProductController::class);
 Route::get('/images', [ImageController::class, 'index']); // List
 Route::get('/image/{id}', [ImageController::class, 'show']); // List
Route::post('/addImage', [ImageController::class, 'addImage']); // Add
Route::put('/updateImage/{id}', [ImageController::class, 'updateImage']); // Update
Route::delete('/deleteImage/{id}', [ImageController::class, 'deleteImage']); // Delete


