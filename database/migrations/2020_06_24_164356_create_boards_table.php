<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->increments('board_id');
            $table->string('board_name', 64);
            $table->integer('secure', 11)->default('0');
            $table->string('board_password', 64)->nullable()->default('NULL');
        });
    }

    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
