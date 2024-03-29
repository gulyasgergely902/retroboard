<?php

use Illuminate\Http\Request;

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

Route::any('/{any}', 'FrontendController@app')->where('any', '^(?!api).*$');

/*Route::get('/', 'BoardController@showBoards');
Route::get('/display/{bid}/{tab}', 'BoardController@displayBoard');
Route::post('/add', 'BoardController@add');
Route::post('/remove', 'BoardController@remove');
Route::post('/export', 'BoardController@export');
Route::post('/unlock', 'BoardController@unlock');
Route::get('/lock', 'BoardController@lock');
Route::get('/group/add/{sticky_id}/{group_id}', 'BoardController@groupAdd');
Route::post('/group/create/', 'BoardController@groupCreate');
Route::get('/group/remove/{sticky_id}', 'BoardController@groupRemove');*/