<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    //
    protected $fillable = ['instanceName'];
    protected $table = 'instances';
}
