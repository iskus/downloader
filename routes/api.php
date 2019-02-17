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

use App\Target;
use App\Http\Resources\Target as TargetResource;

Route::get('/targets', function () {
	return TargetResource::collection(Target::all());
});
Route::post('/targets', 'Api\TargetsController@store');
Route::get('/targets/{target}/download', 'Api\TargetsController@download');
