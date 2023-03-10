<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Ldap;

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
//route::resource('user', 'UserController');
        Route::prefix('user')
            ->group(function () {
                Route::get('/', 'UserController@index');
                Route::post('/create', 'UserController@create');
                Route::patch('/update', 'UserController@update');
                Route::patch('/change-lock', 'UserController@changeLock');
                Route::patch('/option/password', 'UserController@changePassword');

                Route::delete('/delete', 'UserController@delete');
                Route::get('/search', 'UserController@libSearch');
                Route::get('/search-manual', 'UserController@search');

                Route::get('/export', 'FileController@export');
                Route::get('export/detail', 'FileController@exportDetailExcel');
                Route::post('import', 'FileController@import');
            });


        Route::prefix('address')
            ->group(function () {
                Route::patch('/update', 'AddressController@edit');

            }
            );

        Route::prefix('design')
            ->group(function () {
                Route::post('/regist', 'DesignController@registDesign');

            }
            );

        Route::prefix('ldap')
            ->group(function () {
                Route::post('/regist', 'LdapController@regist');
                Route::delete('/delete', 'LdapController@delete');
                Route::delete('/delete/multi', 'LdapController@deleteMulti');
            }
            );


        Route::post('/emailtemplate/update', 'SetEmailTemplateController@updateWord');


    });
Route::prefix('smoothfile')
    ->namespace('App\Http\Controllers\Auth')
    ->group(function () {

        Route::post('/sanctum/token', 'LoginController@get_token');
    });
