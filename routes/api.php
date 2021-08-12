<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\InstituitionController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\PaperReviewController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewUserController;
use App\Http\Controllers\NotificationUserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PushNotificationController;
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
    Route::name("chat.")->group(function () {
         Route::get("chat", [ChatController::class,"index"]);

});


Route::name("areas.")->group(function () {
         Route::get("areas", [AreaController::class,"index"]);
});
Route::name("bases.")->group(function () {
         Route::get("bases", [BaseController::class,"index"]);
});
Route::name("instituitions.")->group(function () {
         Route::get("instituitions", [InstituitionController::class,"index"]);
});
Route::name("reviews.")->group(function () {
         Route::get("reviews/user/{user}", [ReviewController::class,"index"]);
         Route::post("reviews", [ReviewController::class,"store"]);
         Route::patch("reviews/{review}", [ReviewController::class,"update"]);
         Route::delete("reviews", [ReviewController::class,"destroy"]);

});


     Route::name("pushNotifications.")->group(function () {
        Route::post("pushNotifications/send", [PushNotificationController::class,"send"]);
        Route::post("pushNotifications/user/{user}", [PushNotificationController::class,"store"]);
    });

Route::name("papers.")->group(function () {
         Route::get("papers/review/{review}", [PaperController::class,"index"]);
         Route::get("papers", [PaperController::class,"show"]);
         Route::get("papers/mainterms/{review}", [PaperController::class,"mainTerms"]);
         Route::post("papers/base/{base}/review/{review}/upload", [PaperController::class,"store"]);
         Route::patch("papers/{paper}", [PaperController::class,"update"]);
         Route::delete("papers/{paper}", [PaperController::class,"destroy"]);

});

Route::name("paper_reviews.")->group(function () {
         Route::patch("paper_reviews/{paperReview}", [PaperReviewController::class,"update"]);
         Route::get("paper_reviews/base/{base}/review/{review}", [PaperReviewController::class,"edit"]);
         Route::delete("paper_reviews/{paperReview}", [PaperReviewController::class,"destroy"]);
});

Route::name("review_users.")->group(function () {
         Route::post("review_users/{review}", [ReviewUserController::class,"store"]);
         Route::get("review_users/review/{review}", [ReviewUserController::class,"index"]);
         Route::delete("review_users/review/{review}/user/{user}", [ReviewUserController::class,"destroy"]);
});

Route::name("protocols.")->group(function () {
         Route::get("protocols/review/{review}", [PaperController::class,"index"]);
         Route::get("protocols/review/{review}/type/{type}", [PaperController::class,"show"]);
         Route::post("protocols/review/{review}", [PaperController::class,"store"]);
         Route::patch("protocols/{paper}", [PaperController::class,"update"]);
         Route::delete("protocols/{paper}", [PaperController::class,"destroy"]);

});
Route::name("protocolsType.")->group(function () {
         Route::get("protocolsType", [PaperController::class,"index"]);
});


Route::name("notifications.")->group(function () {
         Route::get("notifications/user/{user}", [NotificationController::class,"index"]);
         Route::post("notifications", [NotificationController::class,"store"]);
         Route::patch("notifications/{notificationUser}/user/{user}", [NotificationUserController::class,"update"]);
         Route::delete("notifications/{notificationUser}/user/{user}", [NotificationUserController::class,"destroy"]);
});


});
});
