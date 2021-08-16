<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list', [\App\Http\Controllers\SubscriberController::class, 'index'])->name('subscribers.index');
Route::post('/list', [\App\Http\Controllers\SubscriberController::class, 'loadFile']);
Route::get('/send/email/{subscriber}', [\App\Http\Controllers\SubscriberController::class, 'sendEmail'])->name('subscribers.sendEmail');
