<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OlUserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/book',BookController::class);

// Custom route for search
Route::get('/book/search/title/{title}', [BookController::class, 'showTitle']);
Route::get('/book/search/description/{description}', [BookController::class, 'showDescription']);
Route::get('/book/search/type/{type}', [BookController::class, 'showType']);
Route::get('/book/search/query', [BookController::class, 'search']);

// OlUser registration and login routes
Route::post('/register', [OlUserController::class, 'register']);
Route::post('/login', [OlUserController::class, 'login'])->withoutMiddleware(['auth']);
Route::get('/users', [OlUserController::class, 'getAllUsers']);
Route::post('/user/email', [OlUserController::class, 'getUserByEmail']);


