<?php

use Illuminate\Support\Facades\Route;


Route::post("register/image", [\App\Http\Controllers\Register\RegistrationController::class, "registerByImage"]);

Route::middleware("auth:sanctum")->group(function() {
    
    Route::apiResource("location", \App\Http\Controllers\Location\LocationController::class)->only(["index", "store"]);

    Route::post("greeting", [\App\Http\Controllers\Greeting\GreetingController::class, "store"]);

    Route::post("update/image", [\App\Http\Controllers\Register\UserController::class, "updateImage"]);

    Route::post("logout", [\App\Http\Controllers\Register\RegistrationController::class, "logout"]);
    
});