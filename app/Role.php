<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = ['role','permissions' ];
    
    protected $table = 'roles';
}
 