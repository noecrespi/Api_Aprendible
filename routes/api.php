<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;

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

Route::get('articles', [ArticleController::class, 'index'])
    ->name('api.v1.articles.index');

Route::get('articles/{article}', [ArticleController::class, 'show'])
    ->name('api.v1.articles.show');
