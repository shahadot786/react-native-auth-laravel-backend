<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GreetingController;
use App\Http\Controllers\VideoController;

//public user api routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//protected user api routes
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//protected greetings api routes
//single api resources route
//greetings api
Route::apiResource('greetings', GreetingController::class)->middleware('auth:sanctum');
//videos api
Route::apiResource('videos', VideoController::class)->middleware('auth:sanctum');

//test video upload api public
Route::post('/upload-video', [GreetingController::class, 'uploadVideo']);

//route group
// Route::middleware('auth:sanctum')->group(function (){
//     Route::get('/greetings', [GreetingController::class, 'index']);
//     Route::post('/greetings', [GreetingController::class, 'store']);
//     Route::get('/greetings/{greeting}', [GreetingController::class, 'show']);
//     Route::put('/greetings/{greeting}', [GreetingController::class, 'update']);
//     Route::delete('/greetings/{greeting}', [GreetingController::class, 'destroy']);
// });

//single routes
// //get greetings
// Route::middleware('auth:sanctum')->get('/greetings', [GreetingController::class, 'index']);
// //create greetings
// Route::middleware('auth:sanctum')->post('/greetings', [GreetingController::class, 'store']);
// //show greetings
// Route::middleware('auth:sanctum')->get('/greetings/{greeting}', [GreetingController::class, 'show']);
// //update greetings
// Route::middleware('auth:sanctum')->put('/greetings/{greeting}', [GreetingController::class, 'update']);
// //delete greetings
// Route::middleware('auth:sanctum')->delete('/greetings/{greeting}', [GreetingController::class, 'destroy']);
