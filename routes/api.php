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

Route::post("/news",[NewsController::class,'create'])->name("news.create");
Route::get("/news",[NewsController::class,'getAll'])->name("news.getAll");
Route::get("/news/{id}",[NewsController::class,'getOne'])->name("news.getOne");
Route::put("/news/{id}",[NewsController::class,'update'])->name("news.update");
Route::delete("/news/{id}",[NewsController::class,'delete'])->name("news.delete");
