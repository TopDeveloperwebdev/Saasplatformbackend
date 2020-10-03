<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trigger extends Model
{
    //
    protected $fillable = ['template', 'type', 'usergroup', 'instance_id'];

    protected $table = 'triggers';
}
