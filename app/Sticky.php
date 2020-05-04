<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sticky extends Model
{
    protected $table = 'stickies';
    protected $primaryKey = 'sticky_id';
    public $timestamps = false;
}
