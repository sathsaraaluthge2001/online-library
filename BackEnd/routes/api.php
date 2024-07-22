<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OlUserController;
use App\Http\Controllers\BorrowingController;

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

// Routes for Borrowing
Route::get('/borrowings', [BorrowingController::class, 'index']); // All borrowings
Route::post('/borrowing', [BorrowingController::class, 'store']); // Create a borrowing record
Route::get('/borrowings/search', [BorrowingController::class, 'searchByEmail']); // Search borrowings by email
Route::delete('/borrowings/{bookid}', [BorrowingController::class, 'deleteByBookId']); // Delete borrowing by book ID



