<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ausgaben extends Model
{
    //
    protected $fillable = ['date','invoiceNr','reason','type', 'user','car', 'amount', 'link' ,'booked'];
    
    protected $table = 'ausgaben';
}
