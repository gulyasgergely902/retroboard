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

Route::get('/', function () {
	$boards = \DB::table('boards')->select('board_id', 'board_name')->get();
    return view('index', [
    	'boards' => $boards
    ]);
});

Route::get('/display/{bid}', function($bid){
	$stickies = \DB::table('stickies')->select('sticky_id', 'sticky_type', 'bid', 'sticky_content')->where('bid', '=', $bid)->get();
	return view('display', [
		'stickies' => $stickies,
		'bid' => $bid
	]);
});

Route::post('/add-sticky', function(Request $request){
	$bid = $request->input('bid');
	return view('add-sticky', [
		'bid' => $bid
	]);
});

Route::post('/add', function(Request $request) {
	$mode = $request->input('mode');
	if($mode == 'item'){
		$bid = $request->input('bid');
		$sticky_type = $request->input('sticky_type');
		$sticky_content = $request->input('sticky_content');
		if($sticky_content == "") {
			return redirect('/display/'.$bid);
		}
		DB::insert('insert into stickies(sticky_type, bid, sticky_content) values (?, ?, ?)', [$sticky_type, $bid, $sticky_content]);
		return redirect('display/'.$bid);
	} elseif($mode == 'board') {
		$board_name = $request->input('board_name');
		if($board_name == ""){
			return redirect('/');
		}
		DB::insert('insert into boards(board_name) values (?)', [$board_name]);
		return redirect('/');
	}
	return redirect('/');
});

Route::post('/remove', function(Request $request){
	$mode = $request->input('mode');
	if($mode == 'full') {
		$bid = $request->input('bid');
		$deleted = DB::delete('delete from stickies where bid=?', [$bid]);
		return redirect('display/'.$bid);
	} elseif($mode == 'single') {
		$bid = $request->input('bid');
		$sticky_id = $request->input('sticky_id');
		$deleted = DB::delete('delete from stickies where sticky_id=?', [$sticky_id]);
		return redirect('display/'.$bid);
	} elseif($mode == 'board'){
		$bid = $request->input('bid');
		$deleted = DB::delete('delete from stickies where bid=?', [$bid]);
		$deleted = DB::delete('delete from boards where board_id=?', [$bid]);
		return redirect('/');
	}
});

Route::post('/export', function(Request $request){
	$bid = $request->input('bid');
	$table = DB::select('select * from stickies where bid=?', [$bid]);

	$table_array = array('sticky_type', 'sticky_content');

	dd($table_array);

	/*$headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
        ,   'Content-type'        => 'text/csv'
        ,   'Content-Disposition' => 'attachment; filename=galleries.csv'
        ,   'Expires'             => '0'
        ,   'Pragma'              => 'public'
    ];
	

	array_unshift($table, array_keys($table[0]));

	$callback = function() use ($table){
		$FH = fopen('php://output', 'w');
		foreach ($table as $row) {
			fputcsv($FH, $row);
		}
		fclose($handle);
	}

	return Response::stream($callback, 200, $headers);*/
});
