<?php

use App\Http\Controllers\API\V1\ClientController;
use App\Http\Controllers\API\V1\GetPostController;
use App\Http\Controllers\API\V1\PhotographerController;
use App\Http\Controllers\API\V1\PostController ;
use App\Http\Controllers\API\V1\SearchAndFilterController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

 Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
     return $request->user();
});

Route::apiResource("/V1/photographer",PhotographerController::class);
Route::get("/V1/listofphotographers",[PhotographerController::class,"index"]);
Route::apiResource("/V1/client",ClientController::class)->middleware(["auth:sanctum"]);
Route::post("/V1/register",[UserController::class,"store"]);
Route::post('V1/login', [UserController::class, 'login'])->name('login');
Route::post("V1/logout",[UserController::class,"logout"])->middleware("auth:sanctum");
Route::get("V1/userdata",[UserController::class,"userdata"])->middleware("auth:sanctum");
Route::get("V1/editphotographer/{id}",[UserController::class,"editphotographer"])->middleware("auth:sanctum");
Route::post("V1/search",[SearchAndFilterController::class,"search"]);
Route::apiResource("V1/post",PostController::class)->middleware("auth:sanctum");
Route::get("V1/publicpost",[GetPostController::class,"index"]);
Route::get("V1/userpost",[GetPostController::class,"show"])->middleware("auth:sanctum");
Route::get("V1/public_user_post/{id}",[GetPostController::class,"public_show"]);
Route::post("V1/deletepost",[PostController::class,"destroy"])->middleware("auth:sanctum");
Route::post("V1/post_search/{id}",[SearchAndFilterController::class,"post_search"]);
Route::post("V1/username_email",[UserController::class,"username_email"])->middleware("auth:sanctum");
Route::post("V1/first_last",[UserController::class,"first_last_name"])->middleware("auth:sanctum");
Route::post("V1/client_info_edit",[UserController::class,"client_info_edit"])->middleware("auth:sanctum");
Route::post("V1/PIL",[UserController::class,"phone_instagram_location"])->middleware("auth:sanctum");
Route::post("V1/speciality",[UserController::class,"speciality"])->middleware("auth:sanctum");
Route::post("V1/bio",[UserController::class,"bio"])->middleware("auth:sanctum");
Route::post("V1/profile",[UserController::class,"profile_image"])->middleware("auth:sanctum");
Route::post("V1/big_profile",[UserController::class,"big_profile_image"])->middleware("auth:sanctum");
Route::get("V1/userprofile",[UserController::class,"userprofile"])->middleware("auth:sanctum");
Route::get("V1/basic_info",[UserController::class,"basic_info"])->middleware("auth:sanctum");
Route::post("V1/user_info",[UserController::class,"user_info"])->middleware("auth:sanctum");
Route::get("V1/bio_info",[UserController::class,"bio_info"])->middleware("auth:sanctum");
Route::get("V1/suggest_follow",[UserController::class,"suggest_follow"])->middleware("auth:sanctum");
Route::get("V1/user_basic_info/{id}",[UserController::class,"user_basic_info"]);
