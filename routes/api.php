<?php

use Illuminate\Http\Request;
use App\Board;
use App\Sticky;
use App\Group;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Board
Route::get('/boards', 'Api\ApiController@getBoards');
Route::post('/boards', 'Api\ApiController@addBoard');
Route::delete('/boards/{bid}', 'Api\ApiController@deleteBoard');

//Sticky
Route::get('/stickies/{bid}/{type}', 'Api\ApiController@getBoardStickies');
Route::get('/stickies/{bid}/{type}/{group}', 'Api\ApiController@getBoardStickiesByGroup');
Route::post('/stickies', 'Api\ApiController@addSticky');
Route::post('/stickies/move', 'Api\ApiController@moveSticky');
Route::post('/stickies/link', 'Api\ApiController@linkSticky');
Route::post('/stickies/assignToGroup', 'Api\ApiController@assignToGroup');
Route::delete('/stickies/{id}', 'Api\ApiController@deleteSticky');
Route::delete('/stickies/board/{bid}', 'Api\ApiController@deleteAllSticky');

//Group
Route::get('/groups/{bid}', 'Api\ApiController@getBoardGroups');
Route::post('/groups', 'Api\ApiController@addGroup');
Route::delete('/groups', 'Api\ApiController@deleteGroup');
Route::delete('/groups/board/{bid}', 'Api\ApiController@deleteBoardGroups');
