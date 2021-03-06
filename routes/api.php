<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PropertyController;
use App\Models\Item;
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
//PUBLIC ROUTES

//Auth routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

//-----------------------------------------------------------------------

//PROTECTED ROUTES
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::resources([
        'items' => ItemController::class,
        'properties' => PropertyController::class,
    ]);
});



