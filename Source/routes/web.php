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

Route::get('/{page?}/{param?}', 'ViewController@getView');

Route::post('/add_flag', 'DiaDiemController@AddFlag');

Route::post('/save_flag', 'DiaDiemController@SaveFlag');

Route::post('/remove_flag', 'DiaDiemController@RemoveFlag');

Route::post('/login', 'LoginController@loginProcess');

Route::post('/checkaccount', 'AccountController@checkNewAccount');

Route::post('/add_account', 'AccountController@AddAcount');

Route::post('/update_account', 'AccountController@UpdateAccount');

Route::post('/detail_account', 'AccountController@GetProfile');

Route::post('/delete_account', 'AccountController@DeleteAccount');

Route::post('/upload_avt', 'AccountController@Upload_Avt');

Route::post('/change_pass', 'AccountController@ChangePass');

Route::post('/reset_pass', 'AccountController@ResetPass');

Route::post('/restore', 'ExcelController@Import_DSTruong');