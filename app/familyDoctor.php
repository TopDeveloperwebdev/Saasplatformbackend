<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class familyDoctor extends Model
{
    //
    protected $fillable = ['practiceName','streetNr','zipcode','instance_id', 'city','phone','fax','email', 'password' ,'notifications','doctorName' ];
    
    protected $table = 'family_doctors';

}
