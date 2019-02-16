<?php

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


Route::get('targets', 'Api\TargetsController@index');
Route::post('/targets', 'Api\TargetsController@store');
Route::get('/targets/{targets}/download', 'Api\TargetsController@download');
