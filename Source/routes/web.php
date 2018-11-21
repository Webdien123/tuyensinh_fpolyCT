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
// Route::get('/', function() {
//     return view('abc');
// });

Route::get('/{page?}/{username?}', 'ViewController@getView');

Route::post('/login', 'LoginController@loginProcess');

Route::post('/checkaccount', 'AccountController@checkNewAccount');

Route::post('/add_account', 'AccountController@AddAcount');

Route::post('/update_account/{page?}/{user?}', 'AccountController@UpdateAccount');

Route::post('/detail_account', 'AccountController@GetProfile');

Route::post('/delete_account', 'AccountController@DeleteAccount');

Route::post('/upload_avt', 'AccountController@Upload_Avt');

Route::post('/change_pass', 'AccountController@ChangePass');

Route::post('/reset_pass', 'AccountController@ResetPass');