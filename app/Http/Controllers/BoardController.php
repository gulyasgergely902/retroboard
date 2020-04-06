<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function displayBoard($bid){
    	$stickies = \DB::table('stickies')->select('sticky_id', 'sticky_type', 'bid', 'sticky_content')->where('bid', '=', $bid)->get();
		return view('display', [
			'stickies' => $stickies,
			'bid' => $bid
		]);
    }

    public function add(Request $request){
    	$mode = $request->input('mode');
		if($mode == 'item'){
			$bid = $request->input('bid');
			$sticky_type = $request->input('sticky_type');
			$sticky_content = $request->input('sticky_content');
			if($sticky_content == "") {
				return redirect('/display/'.$bid);
			}
			\DB::table('stickies')->insert(['sticky_type' => $sticky_type, 'bid' => $bid, 'sticky_content' => $sticky_content]);
			return redirect('display/'.$bid);
		} elseif($mode == 'board') {
			$board_name = $request->input('board_name');
			if($board_name == ""){
				return redirect('/');
			}
			\DB::table('boards')->insert(['board_name' => $board_name]);
			return redirect('/');
		}
		return redirect('/');
    }

    public function remove(Request $request){
    	$mode = $request->input('mode');
		if($mode == 'full') {
			$bid = $request->input('bid');
			\DB::table('stickies')->where('bid', $bid)->delete();
			return redirect('display/'.$bid);
		} elseif($mode == 'single') {
			$bid = $request->input('bid');
			$sticky_id = $request->input('sticky_id');
			\DB::table('stickies')->where('sticky_id', $sticky_id)->delete();
			return redirect('display/'.$bid);
		} elseif($mode == 'board'){
			$bid = $request->input('bid');
			\DB::table('stickies')->where('bid', $bid)->delete();
			\DB::table('boards')->where('board_id', $bid)->delete();
			return redirect('/');
		}
    }

    public function export(Request $request){
    	$bid = $request->input('bid');
		$stickies =  \DB::table('stickies')->where('bid', $bid)->get();

		$handle = fopen("output.csv", "w");

		$headers = array("sticky_type, sticky_content");

		fputcsv($handle, $headers);

		foreach ($stickies as $sticky) {
			$line = array($sticky->sticky_type, $sticky->sticky_content);
			fputcsv($handle, $line);
		}

		fclose($handle);

		return Response::download("output.csv");
    }
}
