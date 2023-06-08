<?php

use App\Http\Controllers\NewsController;
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

Route::post("/news",[NewsController::class,'create']);
Route::get("/news",[NewsController::class,'getAll']);
Route::get("/news/{id}",[NewsController::class,'getOne']);
Route::put("/news/{id}",[NewsController::class,'update']);
Route::delete("/news/{id}",[NewsController::class,'delete']);
