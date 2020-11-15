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

Route::get('/boards', function(Request $request){
    return Board::all();
});

Route::get('/boards/add', function(Request $request){
    return "Add board";
});

Route::get('/boards/delete/{bid}', function(Request $request, $bid){
    return "Delete board: $bid";
});

Route::get('/stickies', function(Request $request){
    return Sticky::all();
});

Route::get('/stickies/add', function(Request $request){
    return "Add sticky";
});

Route::get('/stickies/delete/{sid}', function(Request $request, $sid){
    return "Delete sticky: $sid";
});

Route::get('/groups', function(Request $request){
    return Group::all();
});

Route::get('/groups/add', function(Request $request){
    return "Add group";
});

Route::get('/groups/delete/{gid}', function(Request $request, $gid){
    return "Delete group: $gid";
});
