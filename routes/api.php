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
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('/user', 'UserController@index');
        Route::post('/user-create', 'UserController@create');
        Route::post('/user-update', 'UserController@update');
        Route::post('/user-delete', 'UserController@delete');
        Route::post('/user-search', 'UserController@libSearch');

        Route::get('/files/export/', 'FileController@export');
        Route::post('/files/import/', 'FileController@import');
        Route::post('/files/export/detail', 'FileController@exportDetailExcel');

        Route::post('/option/password', 'UserController@changePassword');

        Route::post('/user/change-lock', 'UserController@changeLock');

        Route::post('/address/update', 'AddressController@edit');


    });
Route::prefix('smoothfile')
    ->namespace('App\Http\Controllers\Auth')
    ->group(function () {

        Route::post('/sanctum/token', 'LoginController@get_token');
    });
