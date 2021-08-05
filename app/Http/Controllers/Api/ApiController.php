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
        $validateFormData = $request->validate([
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

    function deleteBoard($bid) {
        Sticky::where('bid', $bid)->delete();
        Group::where('board_id', $bid)->delete();
        Board::where('board_id', $bid)->delete();
        return response(200);
    }

    function getStickies() {
        return Sticky::all();
    }

    function getBoardStickies($bid, $type) {
        return Sticky::where("bid", $bid)->where("sticky_type", $type)->get();
    }

    function getBoardStickiesByGroup($bid, $type, $group) {
        return Sticky::where("bid", $bid)->where("sticky_type", $type)->where("group_id", $group)->get();
    }

    function addSticky(Request $request) {
        $validateFormData = $request->validate([
            'sticky_content' => 'required|max:500'
        ]);
    
        $sticky = new Sticky();
        $sticky->sticky_type = $request->input('sticky_type');
        $sticky->bid = $request->input('bid');
        $sticky->sticky_content = $request->input('sticky_content');
        $sticky->save();
        return response(201);
    }

    function moveSticky(Request $request) {
        $validateFormData = $request->validate([
            'to' => 'required',
            'which' => 'required'
        ]);

        Sticky::where('sticky_id', $request->input('which'))->update(array('sticky_type' => $request->input('to')));
        return response(200);
    }

    function linkSticky(Request $request) {
        $validateFormData = $request->validate([
            'sticky_content' => 'required|max:500'
        ]);
    
        $sticky = new Sticky();
        $sticky->sticky_type = $request->input('sticky_type');
        $sticky->bid = $request->input('bid');
        $sticky->sticky_content = $request->input('sticky_content');
        $sticky->linked_sticky = $request->input('linked_sticky');
        $sticky->linked_content = $request->input('linked_content');
        $sticky->save();
        return response(201);
    }

    function assignToGroup(Request $request) {
        $validateFormData = $request->validate([
            'to' => 'required',
            'which' => 'required'
        ]);

        Sticky::where('sticky_id', $request->input('which'))->update(array('group_id' => $request->input('to')));
        return response(200);
    }

    function deleteSticky($id) {
        Sticky::where('sticky_id', $id)->delete();
        Sticky::where('linked_sticky', $id)->delete();
        return response(200);
    }

    function deleteAllSticky($bid) {
        Sticky::where('bid', $bid)->delete();
        return response(200);
    }

    function getGroups() {
        return Group::all();
    }

    function getBoardGroups($bid) {
        return Group::where("board_id", $bid)->get();
    }

    function addGroup(Request $request) {
        $group = new Group();
        $group->group_name = $request->input('group_name');
        $group->board_id = $request->input('bid');
        $group->sticky_type = $request->input('sticky_type');
        $group->save();
        return response(201);
    }

    function deleteGroup(Request $request) {
        $group_id = $request->input('group_id');
        Sticky::where('group_id', $group_id)->delete();
        Group::where('group_id', $group_id)->delete();
        return response(200);
    }

    function deleteBoardGroups($bid) {
        Group::where('board_id', $bid)->delete();
        return response(200);
    }
}
