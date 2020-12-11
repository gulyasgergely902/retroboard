<?php

use Illuminate\Http\Request;
use App\Board;
use App\Sticky;
use App\Group;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/boards', 'Api\ApiController@getBoards');
Route::post('/boards', 'Api\ApiController@addBoard');
Route::delete('/boards', 'Api\ApiController@deleteBoard');
Route::get('/stickies', 'Api\ApiController@getStickies');
Route::post('/stickies', 'Api\ApiController@addSticky');
Route::delete('/stickies', 'Api\ApiController@deleteSticky');
Route::get('/groups', 'Api\ApiController@getGroups');
Route::post('/groups', 'Api\ApiController@addGroup');
Route::delete('/groups', 'Api\ApiController@deleteGroup');
