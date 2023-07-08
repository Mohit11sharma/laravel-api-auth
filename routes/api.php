<?php

use App\Http\Controllers\api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
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


Route::post('login', [AuthController::class,'login'])->name('login');
Route::post('register', [AuthController::class,'register']);

Route::group(['middleware'=>'api'],function(){
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('users', [AuthController::class,'users']);
    Route::get('posts', [AuthController::class,'index']);
    Route::post('posts', [AuthController::class,'store']);
    Route::get('posts/{id}', [AuthController::class,'edit']);
    Route::post('posts/{id}', [AuthController::class,'update']);
    Route::delete('posts/{id}', [AuthController::class,'delete']);
});
