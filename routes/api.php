<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Sleep;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware("prometheus")->get("", fn() => response()->json(["message" => "Hello World"]));
Route::middleware("prometheus")->get("slow", function() {
    Sleep::for(2000)->milliseconds();
    return response()->json(["message" => "Hello World Slow"]);
});
