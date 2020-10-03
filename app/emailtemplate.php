<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class emailtemplate extends Model
{
    //
    protected $fillable = ['title', 'body', 'instance_id' , 'type'];

    protected $table = 'emailtemplates';
}
