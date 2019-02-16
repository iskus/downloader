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

//Route::get('/', function () {
//    return view('welcome');
//});





Route::get('/', 'PagesController@home');

Route::get('/targets', 'TargetsController@index');
Route::post('/targets', 'TargetsController@store');
Route::get('/targets/add', 'TargetsController@add');
Route::get('/targets/{targets}/download', 'TargetsController@download');
