<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = ['title', 'body', 'delivered', 'date_string', 'send_date' ,'receivers'];

    protected $table = 'messages';
}
