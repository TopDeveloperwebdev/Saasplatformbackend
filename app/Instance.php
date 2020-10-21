<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    //
    protected $fillable = ['instanceName' , 'instanceLogo' , 'phone' , 'fax' , 'streetNr' ,'zip' , 'city'];
    protected $table = 'instances';
}
