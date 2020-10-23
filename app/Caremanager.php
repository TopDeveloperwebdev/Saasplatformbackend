<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caremanager extends Model
{
    //
    protected $fillable = ['ansprechpartner','klinik','fax','email', 'notifications'];
    
    protected $table = 'caremanagers';
}
