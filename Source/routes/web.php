<?php

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
// Route::get('/', 'ViewController@viewLogin')->name('home');

Route::get('/{page?}', 'ViewController@getView');

Route::post('/login', 'LoginController@loginProcess');

Route::post('/checkaccount', 'AccountController@checkNewAccount');

Route::post('/add_account', 'AccountController@AddAcount');

Route::post('/update_account', 'AccountController@UpdateAccount');

Route::post('/delete_account', 'AccountController@DeleteAccount');

// Route::get('/logout', 'LoginController@Logout');
