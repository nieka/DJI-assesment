<?php

use App\Http\Controllers\Api\ColleagueController;
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
Route::prefix('colleagues')
    ->name('colleagues.')
    ->group(function(){
        Route::get('/', [ColleagueController::class, 'get'])->name('get');
    });
