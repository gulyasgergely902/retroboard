<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('group_id');
            $table->string('group_name', 64);
            $table->integer('board_id', 11);
            $table->integer('sticky_type', 11)->default(-1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
