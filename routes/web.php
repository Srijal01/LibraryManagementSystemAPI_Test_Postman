<?php

use Illuminate\Support\Facades\Route;

Route::get('/app.css', fn () => response()->file(public_path('app.css')));
Route::get('/app.js', fn () => response()->file(public_path('app.js')));
Route::get('/', fn () => response(file_get_contents(public_path('index.html')))->header('Content-Type', 'text/html; charset=UTF-8'));
