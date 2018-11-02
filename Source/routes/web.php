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
// Route::get('/{page?}', 'ViewController@getView');

Route::get('/', function() {
    $acc_list = \DB::select('SELECT * FROM nguoidung LEFT JOIN level on nguoidung.level = level.level', [1]);
    return View::make('account')->with('acc_list', $acc_list);
});

Route::post('/login', 'LoginController@loginProcess');
