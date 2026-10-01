<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/admin/login', [AuthController::class, 'adminLogin']);
    Route::post('/user/login', [AuthController::class, 'userLogin']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/books', [BookController::class, 'index']);
    Route::middleware('role:user')->group(function () {
        Route::get('/loans/mine', [LoanController::class, 'mine']);
        Route::post('/my-loans', [LoanController::class, 'borrowForUser']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('categories', CategoryController::class)->except(['index']);
        Route::get('/books/search', [BookController::class, 'search']);
        Route::apiResource('books', BookController::class)->except(['index']);
        Route::apiResource('members', MemberController::class);

        Route::get('/loans', [LoanController::class, 'index']);
        Route::post('/loans', [LoanController::class, 'store']);
        Route::get('/loans/{loan}', [LoanController::class, 'show']);
        Route::put('/loans/{loan}', [LoanController::class, 'update']);
        Route::delete('/loans/{loan}', [LoanController::class, 'destroy']);
        Route::post('/loans/{loan}/return', [LoanController::class, 'returnBook']);
    });

});
