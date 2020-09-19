<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmacies extends Model
{
    //
    protected $fillable = ['pharmacyLogo','pharmacyName','streetNr','zipcode','instance_id', 'city','phone','fax','email', 'password' ,'notifications','doctorName' ];
    
    protected $table = 'pharmacies';
}
