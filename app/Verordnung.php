<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verordnung extends Model
{
    //
    protected $fillable = ['content', 'patient', 'from', 'to','type', 'instance_id' , 'send_date' ,'status'];

    protected $table = 'verordnungs';
   
}
