<?php

use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/register', [UserController::class,'store']);
    Route::post('/login', [UserController::class, 'login']);
});


Route::group([
    'middleware' => ['api','api.jwt'],
    'prefix' => 'transaction'

], function ($router) {
    Route::post('/new', [TransactionController::class,'store']);
    Route::get('/show', [TransactionController::class,'show']);
    Route::get('/expected-balance', [TransactionController::class,'showExpectedBalance']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'investment'

], function ($router) {
    Route::post('/create', [InvestmentController::class,'store'])->middleware('api.jwt');
    Route::get('/show', [InvestmentController::class,'show']);
    Route::get('/my-investment-show', [InvestmentController::class,'showOwnerInvestment'])->middleware('api.jwt');
});

