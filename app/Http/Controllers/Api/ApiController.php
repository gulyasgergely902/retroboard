<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Board;
use App\Sticky;
use App\Group;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    function getBoards() {
        return Board::all();
    }

    function addBoard(Request $request) {
        $validateFormData = $request->validate([ // eslint-disable-line no-eval
            'board_name' => 'required|max:60',
            'board_password' => 'max:60'
        ]);
    
        $board = new Board();
        $board->board_name = $request->input('board_name');
        $board->secure = ($request->input('secure_board') == "on" ? 1 : 0);
        $board->board_password = Hash::make($request->input('board_password'));
        $board->save();
        return response("New board added", 201)->header('Content-Type', 'text/plain');
    }

    function deleteBoard(Request $request) {
        $bid = $request->input('bid');
        Sticky::where('bid', $bid)->delete();
        Group::where('board_id', $bid)->delete();
        Board::where('board_id', $bid)->delete();
        return response("Board deleted", 200)->header('Content-Type', 'text/plain');
    }

    function getStickies() {
        return Sticky::all();
    }

    function addSticky(Request $request) {
        $validateFormData = $request->validate([ // eslint-disable-line no-eval
            'sticky_content' => 'required|max:500'
        ]);
    
        $sticky = new Sticky();
        $sticky->sticky_type = $request->input('sticky_type');
        $sticky->bid = $request->input('bid');
        $sticky->sticky_content = $request->input('sticky_content');
        $sticky->save();
        return response("New sticky added", 201)->header('Content-Type', 'text/plain');
    }

    function deleteSticky(Request $request) {
        $sticky_id = $request->input('sticky_id');
        Sticky::where('sticky_id', $sticky_id)->delete();
        return response("Sticky deleted", 200)->header('Content-Type', 'text/plain');
    }

    function getGroups() {
        return Group::all();
    }

    function addGroup(Request $request) {
        $group = new Group();
        $group->group_name = $request->input('group_name');
        $group->board_id = $request->input('bid');
        $group->sticky_type = $request->input('sticky_type');
        $group->save();
        return response("New group added", 201)->header('Content-Type', 'text/plain');
    }

    function deleteGroup(Request $request) {
        $group_id = $request->input('group_id');
        Sticky::where('group_id', $group_id)->delete();
        Group::where('group_id', $group_id)->delete();
        return response("Group deleted", 200)->header('Content-Type', 'text/plain');
    }
}
