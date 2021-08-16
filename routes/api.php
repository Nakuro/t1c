<?php

use App\Mail\SubscriberMail;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('/email/send', function (Request $request){
    $validated = $request->validate([
        'email' => 'required|email',
        'fio'   => 'required|string|size:255',
    ]);
    $subscriber = Subscriber::updateOrCreate($validated);
    Mail::to($request->email)->send(new SubscriberMail($subscriber));

    return response()->json(['data' => 'ok']);
});