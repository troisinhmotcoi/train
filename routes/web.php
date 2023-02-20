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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['namespace' => 'App\Http\Controllers\Auth'], function()
{
    /**
     * Home Routes
     */
//    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
//        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@create')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login');
        Route::post('/login', 'LoginController@login')->name('login.user');

    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
//        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});
