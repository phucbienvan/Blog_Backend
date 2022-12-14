<?php

use App\Http\Controllers\Api\Admin\BlogController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('categories', CategoryController::class);
Route::resource('blogs', BlogController::class);

Route::group(['prefix' => 'users'], function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
});

Route::get('blogs-by-category', [BlogController::class, 'getBlogByCategory']);
Route::get('blogs-by-user', [BlogController::class, 'getBlogByUser']);
Route::get('blogs-by-outstanding', [BlogController::class, 'getBlogsByOutstanding']);

Route::group(['middleware' => ['auth:sanctum']], function () {

});
