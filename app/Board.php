<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $table = 'boards';
    protected $primaryKey = 'board_id';
    public $timestamps = false;
}
