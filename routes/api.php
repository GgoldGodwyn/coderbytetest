<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaction;

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

Route::post('createAccount',[transaction::class,'createAccount']);
Route::post('creditAccount',[transaction::class,'creditAccount']);
Route::post('debitAccount',[transaction::class,'debitAccount']);
Route::post('checkbalance',[transaction::class,'checkbalance']);



