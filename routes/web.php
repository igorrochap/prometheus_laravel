<?php

use App\Metrics\MetricsController;
use App\Metrics\Prometheus;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(["prometheus"])->get('/', function () {
    $counter = Prometheus::getOrRegisterCounter('app', 'total_requests', 'Total of requests');
    $counter->inc();
    return view('welcome');
});

Route::get("metrics", MetricsController::class);
