<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caremanager extends Model
{
    //
    protected $fillable = ['phone','klinik','fax','email', 'notifications','salutation', 'firstName', 'lastName'];
    
    protected $table = 'caremanagers';
}
