<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStickiesTable extends Migration
{
    public function up()
    {
        Schema::create('stickies', function (Blueprint $table) {
            $table->increments('sticky_id');
            $table->integer('sticky_type');
            $table->integer('bid');
            $table->string('sticky_content', 512);
            $table->integer('group_id')->default(-1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('stickies');
    }
}
