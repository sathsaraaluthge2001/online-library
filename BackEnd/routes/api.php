<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/book',BookController::class);

// Custom route for search
Route::get('/book/search/{query}', [BookController::class, 'search']);
Route::get('/book/showtype/{type}', [BookController::class, 'showType']);