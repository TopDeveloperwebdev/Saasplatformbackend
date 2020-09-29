<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    //
    protected $fillable = ['title','documents','service' ,'instance_id'];
    
    protected $table = 'carefolders';
   
}
