<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    protected $fillable = ['salutation', 'firstName', 'lastName', 'streetNr', 'zipCode', 'city', 'birthday', 'phone1', 'phone2', 'email', 'picture', 'resources', 'insurance', 'services', 'familyDoctor', 'keyNumber', 'floor', 'degreeCare', 'pharmacy', 'userGroup', 'status', 'instance_id' , 'serviceplan'];

    protected $table = 'patients';
}
