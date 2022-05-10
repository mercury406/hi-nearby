<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix("register")->group(function () {
    Route::post("/image", [\App\Http\Controllers\Register\RegistrationController::class, "registerByImage"]);
    Route::post("/username", [\App\Http\Controllers\Register\RegistrationController::class, "registerByUsername"]);
});

Route::middleware("auth:sanctum")->group(function() {
    
    Route::apiResource("location", \App\Http\Controllers\Location\LocationController::class)->only(["index", "store"]);

    Route::post("greeting", [\App\Http\Controllers\Greeting\GreetingController::class, "store"]);

    Route::prefix("update")->group(function () {
        Route::post("/image", [\App\Http\Controllers\Register\UserController::class, "updateImage"]);
        Route::post("/username", [\App\Http\Controllers\Register\UserController::class, "updateUsername"]);
    });
    
});
       


Route::get("/get_image", function(){
    return asset("storage/profile_pictures/kCZOFAcNPU3yx8TDOH1JKLoUqhbTiN8tpwdi62rO.jpg");
});