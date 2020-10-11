<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    public function run()
    {
        \DB::table('boards')->insert([
            'board_name' => "Sample Table",
            'secure' => 0
        ]);

        \DB::table('stickies')->insert([
            'sticky_type' => 0,
            'bid' => 0,
            'sticky_content' => "This is a sample sticky. It can be removed or grouped. You can create one using the '+' button in the bottom right corner!"
        ]);

        \DB::table('stickies')->insert([
            'sticky_type' => 0,
            'bid' => 0,
            'sticky_content' => "You can change the sticky type in the top left corner. There are 3 types of stickies available: green for 'Went Well', red for 'Needs Improvement' and yellow for 'Action Item'."
        ]);

        \DB::table('stickies')->insert([
            'sticky_type' => 2,
            'bid' => 0,
            'sticky_content' => "This is a 'Needs Improvement' sticky."
        ]);

        \DB::table('stickies')->insert([
            'sticky_type' => 1,
            'bid' => 0,
            'sticky_content' => "This is an 'Action Item' sticky."
        ]);
    }
}
