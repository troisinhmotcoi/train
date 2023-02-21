<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('smoothfile')
    ->namespace('App\Http\Controllers\Api')
    ->middleware('auth:api')
    ->group(function () {
        Route::get('/user', 'UserController@index');
    });
Route::prefix('smoothfile')
     ->namespace('App\Http\Controllers\Auth')
    ->group(function () {

        Route::post('/sanctum/token', 'LoginController@get_token');
    });
