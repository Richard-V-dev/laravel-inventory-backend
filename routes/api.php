<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/v1/auth')->group(function(){
    Route::post("/login",[AuthController::class,'login']);
    Route::post("/register", [AuthController::class,"register"]);
    Route::middleware('auth:sanctum')->group(function(){
        Route::get("/profile",[AuthController::class,"profile"]);
        Route::post("/logout",[AuthController::class,"logout"]);
    });
});
Route::middleware('auth:sanctum')->group(function(){
    Route::get("/users",[UserController::class,'list']);
    Route::post("/users",[UserController::class,'save']);
    Route::get("/users/{id}",[UserController::class,'showOne']);
    Route::put("/users/{id}",[UserController::class,'edit']);
    Route::delete("/users/{id}/delete",[UserController::class,'delete']);

    Route::apiResource("category",CategoryController::class);
    Route::apiResource("role",RoleController::class);
});
Route::get("/non-authorized",function(){
    return response()->json(["message"=>"You are not authorized for this info"]);
})->name("login");
