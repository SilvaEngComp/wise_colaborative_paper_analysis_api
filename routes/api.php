<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\InstituitionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::post("login", [AuthController::class,"login"]);
Route::post("users/new", [UserController::class,"store"]);

Route::prefix("v2")->group(function () {
Route::group([

    "middleware" => "api",
    // "prefix" => "auth"
    ]
,function(){
    Route::post("me",[AuthController::class,"me"]);
    Route::post("refresh", [AuthController::class,"refresh"]);

    Route::name("users.")->group(function () {
         Route::get("users", [UserController::class,"index"]);
         Route::post("users", [UserController::class,"store"]);
         Route::delete("users", [UserController::class,"destroy"]);
         Route::patch("users/policy/{user}", [UserController::class,"updatePolicy"]);
    });
});
    Route::name("chat.")->group(function () {
         Route::get("chat", [ChatController::class,"index"]);

});


Route::name("areas.")->group(function () {
         Route::get("areas", [AreaController::class,"index"]);
});
Route::name("instituitions.")->group(function () {
         Route::get("instituitions", [InstituitionController::class,"index"]);
});
Route::name("reviews.")->group(function () {
         Route::get("reviews", [ReviewController::class,"index"]);
         Route::post("reviews", [ReviewController::class,"store"]);
         Route::patch("reviews/{review}", [ReviewController::class,"update"]);
         Route::delete("reviews", [ReviewController::class,"destroy"]);

});

});
