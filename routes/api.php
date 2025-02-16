<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FundManagerController;
use App\Http\Controllers\FundController;

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

Route::get('/companies', [CompanyController::class, 'index']);
Route::get('/fund-managers', [FundManagerController::class, 'index']);

Route::get('/funds', [FundController::class, 'index']);
Route::put('/funds/{id}', [FundController::class, 'update']);
Route::post('/funds', [FundController::class, 'store']);
