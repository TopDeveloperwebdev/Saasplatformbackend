<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    //
    protected $fillable = ['medicationName','ingredients','packaging','orders', 'patients','instance_id' ];
    
    protected $table = 'medications';
}
