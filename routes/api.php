<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\Auth\AuthController;

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

Route::group(["prefix" => "/auth", "middleware" => "api"], function () {
    Route::post("/register", [AuthController::class, "register"])->name("api.register");
    Route::post("/login", [AuthController::class, "login"])->name("api.login");
    Route::delete("/logout", [AuthController::class, "logout"])->name("api.logout")->middleware("auth:sanctum");
});
