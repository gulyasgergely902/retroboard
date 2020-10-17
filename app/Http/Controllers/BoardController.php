<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Hash;
use App\Sticky;
use App\Board;
use App\Group;

class BoardController extends Controller
{
    public function showBoards()
    {
        $boards = Board::all();
        return view('index', [
            'boards' => $boards
        ]);
    }

    public function displayBoard($bid, $tab)
    {
        $match_green = ['bid' => $bid, 'sticky_type' => 0];
        $match_red = ['bid' => $bid, 'sticky_type' => 2];
        $match_yellow = ['bid' => $bid, 'sticky_type' => 1];

        if ($tab == 0) {
            $stickies = Sticky::where($match_green)->inRandomOrder()->get();
        } elseif ($tab == 2) {
            $stickies = Sticky::where($match_red)->inRandomOrder()->get();
        } else {
            $stickies = Sticky::where($match_yellow)->inRandomOrder()->get();
        }

        $groups = Group::where('board_id', $bid)->get();

        $secure = Board::where('board_id', $bid)->pluck('secure')[0];

        $types = ['Went well', 'Action items', 'Needs improvement'];
        $button_color = ['btn-success', 'btn-warning', 'btn-danger'];

        if ($secure == 1) {
            if (\Cookie::get($bid . '-unlocked') == 1) {
                return view('display', [
                    'stickies' => $stickies,
                    'bid' => $bid,
                    'tab' => $tab,
                    'types' => $types,
                    'button_color' => $button_color,
                    'protected' => 1,
                    'groups' => $groups
                ]);
            } else {
                return redirect('/');
            }
        } else {
            return view('display', [
                'stickies' => $stickies,
                'bid' => $bid,
                'tab' => $tab,
                'types' => $types,
                'button_color' => $button_color,
                'protected' => 0,
                'groups' => $groups
            ]);
        }
    }

    public function add(Request $request)
    {
        $mode = $request->input('mode');
        if ($mode == 'item') {
            $validateFormData = $request->validate([
                'sticky_content' => 'required|max:500'
            ]);

            $bid = $request->input('bid');
            $sticky_type = $request->input('sticky_type');

            $sticky = new Sticky();
            $sticky->sticky_type = $sticky_type;
            $sticky->bid = $bid;
            $sticky->sticky_content = $request->input('sticky_content');
            $sticky->save();
            return redirect('/display/' . $bid . '/' . $sticky_type);
        } elseif ($mode == 'board') {
            $validateFormData = $request->validate([
                'board_name' => 'required|max:60',
                'board_password' => 'max:60'
            ]);

            $board_name = $request->input('board_name');

            $board = new Board();
            $board->board_name = $board_name;
            $board->secure = ($request->input('secure_board') == "on" ? 1 : 0);
            $board->board_password = Hash::make($request->input('board_password'));
            $board->save();
            return redirect('/');
        }
        return redirect('/');
    }

    public function remove(Request $request)
    {
        $mode = $request->input('mode');
        if ($mode == 'allsticky') {
            $bid = $request->input('bid');
            Sticky::where('bid', $bid)->delete();
            Group::where('board_id', $bid)->delete();
            return redirect('display/' . $bid . '/0');
        } elseif ($mode == 'singlesticky') {
            $bid = $request->input('bid');
            $sticky_id = $request->input('sticky_id');
            Sticky::where('sticky_id', $sticky_id)->delete();
            return redirect('display/' . $bid . '/0');
        } elseif ($mode == 'board') {
            $bid = $request->input('bid');
            Sticky::where('bid', $bid)->delete();
            Group::where('board_id', $bid)->delete();
            Board::where('board_id', $bid)->delete();
            return redirect('/');
        }
    }

    public function export(Request $request)
    {
        $bid = $request->input('bid');
        $stickies = \DB::table('stickies')->where('bid', $bid)->get();

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

    public function unlock(Request $request)
    {
        $validateFormData = $request->validate([
            'password' => 'required|max:60'
        ]);
        $bid = $request->input('bid');
        $board_password = Board::where('board_id', $bid)->pluck('board_password')[0];
        $current_password = $request->input('password');
        if (Hash::check($current_password, $board_password)) {
            $cookie_name = $bid . "-unlocked";
            \Cookie::queue($cookie_name, 1, 120);
            return redirect('/display/' . $bid . '/0');
        } else {
            return redirect('/')->with(['title' => 'Error', 'message' => 'Error: Wrong password!']);
        }
    }

    public function lock(Request $request)
    {
        $bid = $request->input('bid');
        $cookie_name = $bid . "-unlocked";
        \Cookie::queue(\Cookie::forget($cookie_name));
        return redirect('/');
    }

    public function groupCreate(Request $request)
    {
        $sticky_type = $request->input('sticky_type');
        $bid = $request->input('bid');
        $group = new Group();
        $group->group_name = $request->input('group_name');
        $group->board_id = $bid;
        $group->sticky_type = $sticky_type;
        $group->save();
        return redirect('/display/' . $bid . '/' . $sticky_type);
    }

    public function groupAdd($sticky_id, $group_id)
    {
        $sticky = \App\Sticky::find($sticky_id);
        $bid = $sticky->bid;
        $sticky_type = $sticky->sticky_type;

        $sticky->group_id = $group_id;
        $sticky->save();
        return redirect('/display/' . $bid . '/' . $sticky_type);
    }

    public function groupRemove($sticky_id)
    {
        $sticky = \App\Sticky::find($sticky_id);
        $bid = $sticky->bid;
        $sticky_type = $sticky->sticky_type;

        $sticky->group_id = -1;
        $sticky->save();
        return redirect('/display/' . $bid . '/' . $sticky_type);
    }
}
