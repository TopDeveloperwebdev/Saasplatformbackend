<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //
    protected $fillable = ['title','content','instance_id'];
    
    protected $table = 'documents';
}